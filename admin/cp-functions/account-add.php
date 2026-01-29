<?php

// Load the basics
require "../sd-system/config.php";
$admin = new admin;
if ($_POST['edit'] == '1') {
    $type = 'edit';
} else {
    $type = 'add';
}
$task = 'account-' . $type;

// Quick add?
if (!empty($_POST['dud_quick_add'])) {
    $quick_add             = '1';
    $_POST['company_name'] = $_POST['name'];
} else {
    $quick_add = '0';
}
unset($_POST['dud_quick_add']);


if (empty($_POST['name'])) {
    $_POST['name'] = $_POST['company_name'];
}

// Check permissions and employee
$employee = $admin->check_employee($task);
$task_id  = $db->start_task($task, 'staff', $_POST['id'], $employee['username']);

// Primary fields for main table
$table      = 'ppSD_accounts';
$primary    = array('master_user', 'name', 'created', 'source', 'status', 'owner');
$ignore     = array('id', 'edit', 'contact_frequency'); // 'owner'
$query_form = $admin->query_from_fields($_POST, $type, $ignore, $primary);

// ----------------------------
$timeframe = $admin->construct_timeframe($_POST['contact_frequency']['number'], $_POST['contact_frequency']['unit']);

// ----------------------------
if ($type == 'edit') {
    $data = new history($_POST['id'], '', '', '', '', '', $table);

    /*
    if ($data->{'final_content'}['public'] != '1' && $data->{'final_content'}['owner'] != $employee['id'] && $employee['permissions']['admin'] != '1') {
        echo "0+++Permission denied.";
        exit;
    }
    */

    $ownership = new ownership($data->final_content['owner'], $data->final_content['public']);
    if ($ownership->result != '1') {
        echo "0+++" . $ownership->reason;
        exit;
    }

    // `name`='" . $db->mysql_cleans($_POST['name']) . "',
    // Update the contact
    //$update_set1 = substr($query_form['u1'],1);

    // Convert to parameter binding
    $set_clauses = array(
        '`contact_frequency` = ?',
        '`last_updated` = ?',
        '`start_page` = ?',
        '`last_updated_by` = ?'
    );
    $params = array($timeframe, current_date(), $_POST['start_page'], $employee['id']);
    
    // Process update fields from query_form
    if (!empty($query_form['u1'])) {
        $update_pairs = explode(',', $query_form['u1']);
        foreach ($update_pairs as $pair) {
            if (!empty(trim($pair)) && preg_match('/`([^`]+)`=\'(.*)\'/i', trim($pair), $matches)) {
                $field_name = $matches[1];
                $field_value = $matches[2];
                $set_clauses[] = "`{$field_name}` = ?";
                $params[] = $field_value;
            }
        }
    }
    
    // Add WHERE parameter
    $params[] = $_POST['id'];
    
    $set_clause = implode(', ', $set_clauses);
    $q = $db->update("
        UPDATE
            `ppSD_accounts`
        SET
            {$set_clause}
        WHERE
            `id` = ?
        LIMIT 1
    ", $params);

    // Convert account data update to parameter binding
    if (!empty($query_form['u2'])) {
        $set_clauses = array();
        $params = array();
        
        $update_pairs = explode(',', substr($query_form['u2'], 1));
        foreach ($update_pairs as $pair) {
            if (preg_match('/`([^`]+)`=\'(.*)\'/i', trim($pair), $matches)) {
                $field_name = $matches[1];
                $field_value = $matches[2];
                $set_clauses[] = "`{$field_name}` = ?";
                $params[] = $field_value;
            }
        }
        
        // Add WHERE parameter
        $params[] = $_POST['id'];
        
        $set_clause = implode(', ', $set_clauses);
        $q = $db->update("
            UPDATE
                `ppSD_account_data`
            SET
                {$set_clause}
            WHERE
                `account_id` = ?
            LIMIT 1
        ", $params);
    }

    $add = $db->add_history('account_updated', $employee['id'], $_POST['id'], '3', $_POST['id']);

    // Reassigned?
    if (! empty($_POST['owner']) && $data->final_content['owner'] != $_POST['owner']) {
        $account = new account;
        $account->reassign($_POST['id'], $_POST['owner']);
    }

} else {

    $insert_fields1 = $query_form['if1'];
    $insert_fields2 = $query_form['if2'];
    $insert_values1 = $query_form['iv1'];
    $insert_values2 = $query_form['iv2'];
    // Create the contact
    $last_id = $db->insert("
        INSERT INTO `{$table}` ({$fields_str})
        VALUES ({$placeholders})
    ", $params);
    
    // Convert account data INSERT to parameter binding
    $data_fields = array('`account_id`');
    $data_params = array($_POST['id']);
    
    if (!empty($query_form['if2'])) {
        $insert_fields = explode(',', $query_form['if2']);
        $insert_values = explode(',', $query_form['iv2']);
        
        foreach ($insert_fields as $i => $field) {
            $data_fields[] = trim($field);
            $value = trim($insert_values[$i]);
            if (preg_match('/\'([^\']*)\'/', $value, $matches)) {
                $data_params[] = $matches[1];
            } else {
                $data_params[] = $value;
            }
        }
    }
    
    $data_fields_str = implode(', ', $data_fields);
    $data_placeholders = str_repeat('?, ', count($data_params) - 1) . '?';
    
    $next = $db->insert("
        INSERT INTO `ppSD_account_data` ({$data_fields_str})
        VALUES ({$data_placeholders})
    ", $data_params);
    $data_params = array($_POST['id']);
    
    if (!empty($query_form['if2'])) {
        $insert_fields = explode(',', $query_form['if2']);
        $insert_values = explode(',', $query_form['iv2']);
        
        foreach ($insert_fields as $i => $field) {
            $data_fields[] = trim($field);
            $value = trim($insert_values[$i]);
            if (preg_match('/\'([^\']*)\'/', $value, $matches)) {
                $data_params[] = $matches[1];
            } else {
                $data_params[] = $value;
            }
        }
    }
    
    $data_fields_str = implode(', ', $data_fields);
    $data_placeholders = str_repeat('?, ', count($data_params) - 1) . '?';
    
    $next = $db->insert("
        INSERT INTO `ppSD_account_data` ({$data_fields_str})
        VALUES ({$data_placeholders})
    ", $data_params);
    $add     = $db->add_history('account_created', $employee['id'], $_POST['id'], '3', $_POST['id']);

}

// Re-cache
$account      = new account;
$content      = $account->get_account($_POST['id'], '1');
$return       = array();
$table_format = new table('account', 'ppSD_accounts');
$return       = array();

if ($type == 'add') {
    if ($quick_add == '1') {
        $return['show_saved']  = 'Created';
        $return['close_popup'] = '1';
    } else {
        $return['load_slider']      = array(
            'page'    => 'account',
            'subpage' => 'view',
            'id'      => $content['id'],
        );
        $return['show_saved']       = 'Created';
        $cell                       = $table_format->render_cell($content);
        $return['append_table_row'] = $cell;
    }
} else {
    $return['show_saved'] = 'Updated';
    $cell                 = $table_format->render_cell($content, '1');
    $return['update_row'] = $cell;
}

$task = $db->end_task($task_id, '1');
echo "1+++" . json_encode($return);
exit;