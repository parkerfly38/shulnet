<?php

/**
 * Merge Two Contacts Into One
 */
// page
// display
// Load the basics
require "../sd-system/config.php";
$admin = new admin;
$type = 'merge';
$task = 'contact-' . $type;

// Check permissions and employee
$employee = $admin->check_employee($task);
//$task_id  = $db->start_task($task, 'staff', $_POST['id'], $employee['username']);

$contact = new contact;

if (! empty($_POST['id']) && ! empty($_POST['merge_into'])) {

    $get = $contact->merge($_POST['id'], $_POST['merge_into']);

} else {
    $return                = array();
    $return['show_saved']  = 'Could not merge contacts. Primary contact and contacts to merge are both required.';
    exit;
}

// Re-cache.
$data                  = $contact->get_contact($_POST['id'], '1');

// Send back information.
$return                = array();
$return['close_popup'] = '1';
$return['show_saved']  = 'Contacts Merged.';

//$task = $db->end_task($task_id, '1');
echo "1+++" . json_encode($return);
exit;