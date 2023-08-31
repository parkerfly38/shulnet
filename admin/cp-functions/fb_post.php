<?php
// Load the basics
require "../sd-system/config.php";
$admin = new admin;
if ($_POST['edit'] == '1') {
    $type = 'edit';

} else {
    $type = 'add';

}
$task = 'fb_post';
// Check permissions and employee
$employee = $admin->check_employee($task);
$task_id  = $db->start_task($task, 'staff', $_POST['id'], $employee['username']);
$return   = array();
$smedia   = new socialmedia();
$check    = $smedia->confirm_fb_setup();
$smedia->fb_connect();
if ($check['error'] == '1') {
    $good = array(
        'error'   => '1',
        'message' => $check['error_message'],
    );

} else {
    if (!empty($_POST['action'])) {
        $action = $_POST['action'];

    } else {
        $action = '';

    }
    if ($action == 'delete') {
        $good                   = $smedia->delete_status($_POST['id']);
        $return['remove_cells'] = array('fbpost-' . $_POST['id']);
        $return['show_saved']   = 'Status Deleted';

    } else {
        $good                     = $smedia->post_status($_POST['status']);
        $return['redirect_popup'] = array('page' => 'facebook');
        $return['show_saved']     = 'Status Posted';

    }

}
$task = $db->end_task($task_id, '1');
if ($good['error'] != '1') {
    echo "1+++" . json_encode($return);
    exit;

} else {
    echo "0+++" . $good['error_message'];
    exit;

}



