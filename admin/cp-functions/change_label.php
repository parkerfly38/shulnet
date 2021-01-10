<?php
/**
 * If adding, ID is not used. "user_id" is sent.
 * If editing, ID is the id of the item.
 */
// Load the basics
require "../sd-system/config.php";
$admin = new admin;
$task = 'change_label';

// Check permissions and employee
$employee = $admin->check_employee($task);
$task_id  = $db->start_task($task, 'staff', $_POST['id'], $employee['username']);

$upload = new uploads;
$file = $upload->get_upload($_POST['id']);

// Ownership
$ownership = new ownership($file['owner'], '0');
if ($ownership->result != '1') {
    echo "0+++" . $ownership->reason;
    exit;
}

// Update
$q1 = $db->update("
    UPDATE `ppSD_uploads`
    SET `label`='" . $db->mysql_clean($_POST['label_dud']) . "'
    WHERE `id`='" . $db->mysql_clean($_POST['id']) . "'
    LIMIT 1
");

// Reply
$task                  = $db->end_task($task_id, '1');
$table                 = 'ppSD_uploads';
$table_format          = new table('uploads', $table);
$history               = new history($_POST['id'], '', '', '', '', '', $table);
$content               = $history->final_content;
$cell                  = $table_format->render_cell($content, '1');

$return                = array();
$return['update_row'] = $cell;
$return['show_saved'] = 'Updated';
$return['close_popup'] = '1';

echo "1+++" . json_encode($return);
exit;