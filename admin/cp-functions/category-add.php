<?php

/**
 * If adding, ID is not used. "user_id" is sent.
 * If editing, ID is the id of the item.
 */
// Load the basics
require "../sd-system/config.php";
$admin = new admin;
if ($_POST['edit'] == '1') {
    $type = 'edit';
} else {
    $type = 'add';
}
$task = 'category-' . $type;

// Check permissions and employee
$employee = $admin->check_employee($task);
$task_id  = $db->start_task($task, 'staff', $_POST['id'], $employee['username']);

// Primary fields for main table
$table   = 'ppSD_cart_categories';
$primary = array('');
$ignore  = array('id', 'edit','reorder');
if ($_POST['id'] == '1') {
    $_POST['subcategory'] = '0';
}
$query_form = $admin->query_from_fields($_POST, $type, $ignore, $primary);

if ($type == 'edit') {

    $data = new history($_POST['id'], '', '', '', '', '', $table);
    if ($data->{'final_content'}['public'] != '1' && $data->{'final_content'}['owner'] != $employee['id'] && $employee['permissions']['admin'] != '1') {
        echo "0+++Permission denied.";
        exit;
    }

    // Update the contact
    $update_set1 = substr($query_form['u1'], 1);
    $update_set2 = substr($query_form['u2'], 1);
    $q           = $db->update("
		UPDATE `$table`
		SET $update_set2
		WHERE `id`='" . $db->mysql_clean($_POST['id']) . "'
		LIMIT 1
	");
    $last_id     = $_POST['id'];

    // Re-order products
    $reup = 0;
    if (! empty($_POST['reorder'])) {
        foreach ($_POST['reorder'] as $id => $value) {
            $q1 = $db->update("
            UPDATE `ppSD_products`
            SET `cart_ordering`='" . $reup . "'
            WHERE `id`='" . $db->mysql_clean($id) . "'
            LIMIT 1
        ");
            $reup++;
        }
    }

} else {

    // Create the contact
    $insert_fields1 = substr($query_form['if1'], 1);
    $insert_fields2 = substr($query_form['if2'], 1);
    $insert_values1 = substr($query_form['iv1'], 1);
    $insert_values2 = substr($query_form['iv2'], 1);
    $last_id        = $db->insert("
		INSERT INTO `$table` (`owner`,`created`,`public`,$insert_fields2)
		VALUES ('" . $db->mysql_cleans($employee['id']) . "','" . current_date() . "','1',$insert_values2)
	");

}

$task                  = $db->end_task($task_id, '1');
$table                 = 'ppSD_cart_categories';
$table_format          = new table('category', $table);
$history               = new history($last_id, '', '', '', '', '', $table);
$content               = $history->final_content;
$return                = array();
$return['close_popup'] = '1';

if ($type == 'add') {
    $cell                       = $table_format->render_cell($content);
    $return['append_table_row'] = $cell;
    $return['show_saved']       = 'Created';
} else {
    $cell                 = $table_format->render_cell($content, '1');
    $return['update_row'] = $cell;
    $return['show_saved'] = 'Updated';
}

echo "1+++" . json_encode($return);
exit;