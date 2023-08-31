<?php 
require "../sd-system/config.php";
$task     = 'invoice-email';
$admin    = new admin;
$employee = $admin->check_employee($task);
if (!empty($_POST['id'])) {
    $table     = 'ppSD_notes';
    $type      = 'edit';
    $update_id = $_POST['id'];
    $permitted = array('all');
    // Permissions and ownership
    $admin       = new admin;
    $employee    = $admin->check_employee();
    $permissions = new permissions('note', $type, $update_id, $table);
    if ($_POST['complete'] == '1') {
        $force_fields = array('complete' => '1', 'completed_on' => current_date(), 'completed_by' => $employee['id']);

    } else {
        $force_fields = array('complete' => '0', 'completed_on' => '', 'completed_by' => '');

    }
    $binding = new bind($table, $force_fields, $permitted, '', '', '', $type, $update_id, 'id');

}
$return                 = array();
$return['close_popup']  = '1';
$return['show_saved']   = 'Note Marked Complete';
$return['remove_cells'] = array('note-' . $_POST['id']);
echo "1+++" . json_encode($return);
exit;



