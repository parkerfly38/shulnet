# Database Method Conversion Guide

This guide shows how to convert existing database calls to use the new parameter binding approach.

## Updated Method Signatures

The core database methods now accept parameters as function arguments:

```php
// Old signature: function insert($query)
// New signature: function insert($query, $params = null)

// Old signature: function update($query) 
// New signature: function update($query, $params = null)

// Old signature: function delete($query)
// New signature: function delete($query, $params = null)

// Old signature: function get_array($query, $skip_bind_clear = '0', $assoc = '0')
// New signature: function get_array($query, $params = null, $skip_bind_clear = '0', $assoc = '0')

// Old signature: function run_query($query, $skip_bind_clear = '0')
// New signature: function run_query($query, $params = null, $skip_bind_clear = '0')

// New methods:
function get_array_assoc($query, $params = null)  // Returns associative array
function get_all_assoc($query, $params = null)    // Returns all rows as assoc arrays
function clean_value($value)                       // Clean value without adding to binding array
```

## Conversion Patterns

### 1. INSERT Statements

**OLD (Vulnerable to SQL Injection):**
```php
$insertSQL = "INSERT INTO ppSD_parashat (parsha_date, title, category)
    VALUES('".$item["date"]."','".$item["title"]."','".$item["category"]."')";
$newid = $db->insert($insertSQL);
```

**NEW (Safe Parameter Binding):**
```php
$insertSQL = "INSERT INTO ppSD_parashat (parsha_date, title, category) VALUES (?, ?, ?)";
$params = [$item["date"], $item["title"], $item["category"]];
$newid = $db->insert($insertSQL, $params);
```

### 2. UPDATE Statements

**OLD:**
```php
$updateSQL = "UPDATE ppSD_users SET name='".$name."', email='".$email."' WHERE id='".$id."'";
$db->update($updateSQL);
```

**NEW:**
```php
$updateSQL = "UPDATE ppSD_users SET name=?, email=? WHERE id=?";
$params = [$name, $email, $id];
$db->update($updateSQL, $params);
```

### 3. DELETE Statements

**OLD:**
```php
$deleteSQL = "DELETE FROM ppSD_temp WHERE id='".$id."'";
$db->delete($deleteSQL);
```

**NEW:**
```php
$deleteSQL = "DELETE FROM ppSD_temp WHERE id=?";
$params = [$id];
$db->delete($deleteSQL, $params);
```

### 4. SELECT Statements

**OLD:**
```php
$query = "SELECT * FROM ppSD_users WHERE email='".$email."' AND status='".$status."'";
$user = $db->get_array($query, '0', '1');
```

**NEW:**
```php
$query = "SELECT * FROM ppSD_users WHERE email=? AND status=?";
$params = [$email, $status];
$user = $db->get_array_assoc($query, $params);
```

### 5. Multiple Row SELECT

**OLD:**
```php
$query = "SELECT * FROM ppSD_events WHERE date >= '".$start_date."'";
$STH = $db->run_query($query);
while ($row = $STH->fetch(PDO::FETCH_ASSOC)) {
    // process row
}
```

**NEW:**
```php
$query = "SELECT * FROM ppSD_events WHERE date >= ?";
$params = [$start_date];
$rows = $db->get_all_assoc($query, $params);
foreach ($rows as $row) {
    // process row
}
```

### 6. Converting mysql_clean() usage

**OLD (using mysql_clean):**
```php
$query = "SELECT * FROM ppSD_users WHERE name=".$db->mysql_clean($name)." AND id=".$db->mysql_clean($id);
$result = $db->get_array($query);
```

**NEW (using parameters):**
```php
$query = "SELECT * FROM ppSD_users WHERE name=? AND id=?";
$params = [$db->clean_value($name), $db->clean_value($id)];
$result = $db->get_array($query, $params);

// Or even simpler:
$query = "SELECT * FROM ppSD_users WHERE name=? AND id=?";
$result = $db->get_array($query, [$name, $id]);
```

## Benefits of New Approach

1. **Security**: Eliminates SQL injection vulnerabilities
2. **Performance**: PDO can cache prepared statements
3. **Clarity**: Clearer separation of SQL structure and data
4. **Type Safety**: Proper handling of different data types (null, integers, strings)
5. **Debugging**: Better error messages with parameter count validation

## Backward Compatibility

All methods maintain backward compatibility. The old approach using `mysql_clean()` and the global binding array still works, but should be gradually converted to the new parameter-based approach.

## Migration Strategy

1. Start with high-risk areas (user input, forms, API endpoints)
2. Convert one file at a time
3. Test thoroughly after each conversion
4. Use both approaches during transition period
5. Gradually phase out mysql_clean() usage

## Common Gotchas

1. **Parameter Order**: Make sure parameter array order matches ? placeholders in query
2. **NULL Values**: Use `null` in parameter array, not empty strings, for NULL database values  
3. **Backward Compatibility**: When updating method calls, be aware of parameter position changes
4. **Array vs Single Value**: Single values are automatically converted to arrays