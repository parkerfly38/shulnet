<?php

require "admin/sd-system/config.php";
$session = new session;
$ses     = $session->check_session();
$kill    = $session->kill_session();
$task_id = $db->start_task('logout', 'user', '', $ses['member_id']);
$logout_url = $db->get_option('logout_redirect');
if (empty($logout_url)) {
    $logout_url = PP_URL . '/login.php';
}
$history = $db->add_history('logout', '2', $ses['member_id'], '1', $ses['member_id'], '');
$indata = array();
if (! empty($ses['id'])) {
    $indata['member_id']  = $ses['member_id'];
    $indata['session_id'] = $ses['id'];
}
$task   = $db->end_task($task_id, '1', '', 'logout', '', $indata);
header('Location: ' . $logout_url);
exit;