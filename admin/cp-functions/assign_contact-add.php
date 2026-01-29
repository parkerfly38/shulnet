<?php


// Load the basics
require "../sd-system/config.php";
$admin = new admin;
if ($_POST['edit'] == '1') {
    $type = 'edit';

} else {
    $type = 'add';

}
$task = 'assign_contact-' . $type;
// Check permissions and employee
$employee = $admin->check_employee($task);
$task_id  = $db->start_task($task, 'staff', $_POST['id'], $employee['username']);
// Ownership
$contact = new contact;
$data    = $contact->get_contact($_POST['id']);
if ($data['data']['owner'] != $employee['id'] && $employee['permissions']['admin'] != '1') {
    echo "0+++You cannot re-assign this contact.";
    exit;

}
// Assign Contact
$q1 = $db->update("
    UPDATE
        `ppSD_contacts`
    SET
        `source` = ?,
        `account` = ?,
        `expected_value` = ?,
        `public` = ?
    WHERE
        `id` = ?
    LIMIT 1
", array($_POST['source'], $_POST['account'], $_POST['expected_value'], $_POST['public'], $_POST['id']));
// Email Employee or push it
// to his/her homepage.
$contact->assign($_POST['id'], $_POST['owner']);
// Re-cache
$data                  = $contact->get_contact($_POST['id'], '1');
$content               = $data['data'];
$table_format          = new table('contact', 'ppSD_contacts');
$return                = array();
$return['close_popup'] = '1';
$cell                  = $table_format->render_cell($content, '1');
$return['update_row']  = $cell;
$return['show_saved']  = 'Contact Assigned';
$task                  = $db->end_task($task_id, '1');
echo "1+++" . json_encode($return);
exit;



