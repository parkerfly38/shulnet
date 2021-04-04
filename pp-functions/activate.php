<?php

   
require "../admin/sd-system/config.php";
$user = new user;
if (!empty($_GET['c']) && !empty($_GET['u'])) {
    $task_id = $db->start_task('activate', 'user', '', $_GET['u']);
    // Get user
    $check = $user->check_activation_code($_GET['c'], $_GET['u']);
    // Correct code?
    if ($check == '1') {
        // Activate
        $confirm = $user->confirm_email($_GET['u']);

        $indata = array(
            'member_id' => $_GET['u'],
        );
        $task = $db->end_task($task_id, '1', '', 'activate', $_GET['u'], $indata);

        // Display template
        $changes = array();
        // $task    = $db->end_task($task_id, '1', '', 'activate');
        $temp    = new template('email_confirmed', $changes, '1');
        echo $temp;
        exit;
    } else {
        $task = $db->end_task($task_id, '0', '', 'activate');
        // Display template
        $changes = array(
            'details' => $db->get_error('L014')
        );
        $temp    = new template('error', $changes, '1');
        echo $temp;
        exit;
    }
}