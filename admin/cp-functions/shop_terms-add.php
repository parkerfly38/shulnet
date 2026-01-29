<?php 



/**
 *
 *
 * Zenbership Membership Software
 * Copyright (C) 2013-2016 Castlamp, LLC
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author      Castlamp
 * @link        http://www.castlamp.com/
 * @link        http://www.zenbership.com/
 * @copyright   (c) 2013-2016 Castlamp
 * @license     http://www.gnu.org/licenses/gpl-3.0.en.html
 * @project     Zenbership Membership Software
 */
// page
// display
// Load the basics
require "../sd-system/config.php";
$admin = new admin;
if ($_POST['edit'] == '1') {
    $type = 'edit';

} else {
    $type = 'add';

}
$task = 'shop_terms-' . $type;
// Check permissions and employee
$employee = $admin->check_employee($task);
$task_id  = $db->start_task($task, 'staff', $_POST['id'], $employee['username']);
// Primary fields for main table
$primary    = array();
$ignore     = array('id', 'edit');
$query_form = $admin->query_from_fields($_POST, $type, $ignore, $primary);
if ($type == 'edit') {
    // Extract field updates from query_form and convert to parameter binding
    $set_clauses = array();
    $params = array();
    
    // Process the update fields from query_form
    if (!empty($query_form['u2'])) {
        $update_pairs = explode(',', substr($query_form['u2'], 1));
        foreach ($update_pairs as $pair) {
            // Match field=value pattern, handling escaped quotes
            if (preg_match('/`([^`]+)`=\'(.*)\'/i', trim($pair), $matches)) {
                $field_name = $matches[1];
                $field_value = $matches[2];
                $set_clauses[] = "`{$field_name}` = ?";
                $params[] = $field_value;
            }
        }
    }
    
    // Add the WHERE parameter
    $params[] = $_POST['id'];
    
    $set_clause = implode(', ', $set_clauses);
    $q = $db->update("
        UPDATE `ppSD_cart_terms`
        SET {$set_clause}
        WHERE `id` = ?
        LIMIT 1
    ", $params);
    $qin = $_POST['id'];

} else {
    // Extract fields and values from query_form and convert to parameter binding
    $fields = array('`created`');
    $params = array(current_date());
    
    // Process the insert fields from query_form
    if (!empty($query_form['if2'])) {
        $insert_fields = explode(',', substr($query_form['if2'], 1));
        $insert_values = explode(',', substr($query_form['iv2'], 1));
        
        foreach ($insert_fields as $i => $field) {
            $fields[] = trim($field);
            // Extract value from quoted string
            $value = trim($insert_values[$i]);
            if (preg_match('/\'([^\']*)\'/', $value, $matches)) {
                $params[] = $matches[1];
            } else {
                $params[] = $value;
            }
        }
    }
    
    $fields_str = implode(',', $fields);
    $placeholders = str_repeat('?,', count($params) - 1) . '?';
    
    $qin = $db->insert("
        INSERT INTO `ppSD_cart_terms` ({$fields_str})
        VALUES ({$placeholders})
    ", $params);

}
$table                 = 'ppSD_cart_terms';
$scope                 = 'terms';
$history               = new history($qin, '', '', '', '', '', $table);
$content               = $history->final_content;
$table_format          = new table($scope, $table);
$return                = array();
$return['close_popup'] = '1';
if ($type == 'add') {
    $cell                       = $table_format->render_cell($content);
    $return['append_table_row'] = $cell;
    $return['show_saved']       = 'Created Terms';

} else {
    $cell                 = $table_format->render_cell($content, '1');
    $return['update_row'] = $cell;
    $return['show_saved'] = 'Updated Terms';

}
echo "1+++" . json_encode($return);
exit;