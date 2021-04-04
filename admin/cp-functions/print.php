<?php 


/**
 * Print based on criteria.
 * GET:scope = 'member', 'contact', 'rsvp', 'account'
 * GET:act_id = member ID, contact ID, rsvp ID, account ID
 * GET:type = build
 *  -> Builds criteria based on GET:data
 * GET:type = other
 *  -> Uses pre-build criteria based on GET:criteria_id
 */

require "../sd-system/config.php";
$task     = 'print';
$admin    = new admin;
$employee = $admin->check_employee($task);

if ($_GET['type'] == 'build') {
    $data     = unserialize($_GET['data']);
    $criteria = new criteria;
    $crit_id  = $criteria->build_filters($data, $_GET['scope'], 'print');
} else {
    $crit_id = $_GET['criteria_id'];
}

$task_id = $db->start_task($task, 'staff', $crit_id, $employee['username']);

if (! empty($_GET['title'])) {
    $title = $_GET['title'];
} else {
    $title = '';
}
if (! empty($_GET['order'])) {
    $order = $_GET['order'];
    if (! empty($_GET['dir'])) {
        $order .= ' ' . $_GET['dir'];
    }
} else {
    $order = '';
}

$print   = new printer($crit_id, $title, $order);

echo $print;
$task = $db->end_task($task_id, '1');
exit;



