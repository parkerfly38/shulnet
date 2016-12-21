<?php

/**
 *    Zenbership
 *    http://www.zenbership.com/
 *    (c) 2012, Castlamp.
 *
 *    Purpose: User management page:
 *    -> Update Account
 *
 *    WARNING!
 *    DO NOT EDIT THIS FILE!
 *    To change the calendar's
 *    apperance, please edit the
 *    program templates from the
 *    "Integration" section of the
 *    admin control panel.
 *
 */
// Load the basics
require "../admin/sd-system/config.php";
// Check a user's session
$session = new session;
$ses     = $session->check_session();
if ($ses['error'] == '1') {
    $session->reject('login', $ses['ecode']);
    exit;
} else {
    // Get Announcements
    $announcement = new announcements($ses['member_id']);
    $formatted    = $announcement->find_announcements();
    // Template
    $changes = array(
        'announcements' => $formatted,
    );
    $wrapper = new template('manage_announcements', $changes, '1');
    echo $wrapper;
    exit;
}