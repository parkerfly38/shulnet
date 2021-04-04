<?php
// Load the basics
require "../sd-system/config.php";
$task = 'activate';
// Check permissions and employee
$admin    = new admin;
$employee = $admin->check_employee($task);
$task_id  = $db->start_task($task, 'staff', $_POST['id'], $employee['username']);
$user     = new user;
$data     = $user->get_user($_POST['id']);

// Ownership
$permission = new ownership($data['data']['owner'], $data['data']['public']);
if ($permission->result != '1') {
    echo "0+++" . $permission->reason;
    exit;
}

$user->update_status($data['data']['id'], $_POST['status'], $_POST['reason'], $_POST['send_email']);
$task                   = $db->end_task($task_id, '1');
$data['data']['status'] = $_POST['status'];
$sf                     = new special_fields('member');
$sf->update_row($data['data']);
$status                 = $sf->process('status', $_POST['status']);
$return                 = array();
$return['close_popup']  = '1';
$return['update_cells'] = array('member-status-' . $data['data']['id'] => $status); // update_cells => array('cell_id' => 'cell_value', 'cell_id2' => 'cell_value2')
echo "1+++" . json_encode($return);
exit;

