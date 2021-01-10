<?php


require "../sd-system/config.php";
$task     = 'event-checkin';
$admin    = new admin;
$employee = $admin->check_employee($task);

$event = new event();
$event->checkin($_POST['id'], $employee['id']);

$return                 = array();
$return['show_saved']   = 'Attendee has been checked in.';
$return['add_class']    = array(
    'id'    => 'td-cell-' . $_POST['id'],
    'class' => 'converted',
);

echo "1+++" . json_encode($return);
exit;



