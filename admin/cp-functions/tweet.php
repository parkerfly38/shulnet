<?php
// Load the basics
require "../sd-system/config.php";
$admin = new admin;
if ($_POST['edit'] == '1') {
    $type = 'edit';

} else {
    $type = 'add';

}
$task = 'tweet';
// Check permissions and employee
$employee = $admin->check_employee($task);
$task_id  = $db->start_task($task, 'staff', $_POST['id'], $employee['username']);
$smedia   = new socialmedia();
$return   = array();
if (!empty($_POST['action'])) {
    $action = $_POST['action'];

} else {
    $action = '';

}
if ($action == 'retweet') {
    $good = $smedia->retweet($_POST['id']);

} else if ($action == 'delete') {
    $good                   = $smedia->delete_tweet($_POST['id']);
    $return['remove_cells'] = array('tweet-' . $_POST['id']);

} else {
    $good                     = $smedia->post_tweet($_POST['tweet_info']);
    $return['redirect_popup'] = array('page' => 'twitter');

}
$task = $db->end_task($task_id, '1');
if ($good['error'] != '1') {
    $return['show_saved'] = $good['message'];
    echo "1+++" . json_encode($return);
    exit;

} else {
    echo "0+++Could not post tweet: " . $good['error_message'];
    exit;

}



