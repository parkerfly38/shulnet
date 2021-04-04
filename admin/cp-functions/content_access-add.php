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
$task = 'content_access-' . $type;
// Check permissions and employee
$employee = $admin->check_employee($task);
$task_id  = $db->start_task($task, 'staff', $_POST['id'], $employee['username']);
// Primary fields for main table
$table       = 'ppSD_content_access';
$primary     = array('');
$ignore      = array('id', 'edit');
$query_form  = $admin->query_from_fields($_POST, $type, $ignore, $primary);
$user        = new user;
$add         = $user->add_content_access($_POST['content_id'], $_POST['member_id'], '', $_POST['expires']);
$access_id   = $user->check_content_access_id($_POST['content_id'], $_POST['member_id']);
$history     = new history($access_id, '', '', '', '', '', $table);
$return_cell = $history->{'table_cells'};
$task        = $db->end_task($task_id, '1');
// Re-cache
$data                       = $user->get_user($_POST['id'], '', '1');
$history                    = new history($access_id, '', '', '', '', '', $table);
$content                    = $history->final_content;
$scope                      = 'member-content';
$table_format               = new table($scope, $table);
$cell                       = $table_format->render_cell($content);
$return                     = array();
$return['close_popup']      = '1';
$return['append_table_row'] = $cell;
$return['show_saved']       = 'Access Granted';
echo "1+++" . json_encode($return);
exit;





