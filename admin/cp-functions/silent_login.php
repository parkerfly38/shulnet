<?php 

// Load the basics
require "../sd-system/config.php";
$admin    = new admin;
$task     = 'silent_login';
$employee = $admin->check_employee($task);
$user     = new user;
$data     = $user->get_user($_GET['id']);
if ($data['data']['owner'] != $employee['id'] && $employee['permissions']['admin'] != '1' && $data['data']['public'] != '1') {
    echo "You cannot perform this task for this member.";
    exit;

}
$task_id = $db->start_task($task, 'staff', $_GET['id'], $employee['username']);
// Create the session at this point.
$session       = new session;
$check_session = $session->check_session();
if ($check_session['error'] != '1') {
    $kill_session = $session->kill_session($check_session['id']);

}
$create = $session->create_session($data['data']['id'], '0');
// Log user into his/her content?
// mod_rewrite directories only. CMS
// stuff is handled when it is loaded.
foreach ($data['areas'] as $content) {
    if ($content['type'] == 'folder') {
        $session->folder_login($create, $content['content_id']);

    }

}
$redirect = PP_URL . '/manage';
$task     = $db->end_task($task_id, '1');
header('Location: ' . $redirect);
exit;



