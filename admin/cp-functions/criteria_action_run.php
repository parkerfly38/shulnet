<?php

// Load the basics
require "../sd-system/config.php";
$task = 'criteria_action';

// Check permissions and employee
$admin    = new admin;
$employee = $admin->check_employee($task);
$task_id  = $db->start_task($task, 'staff', $_POST['id'], $employee['username']);

$criteriaAction = new criteriaActions($_POST['scope']);
$criteriaAction->setCriteria($_POST['cid'])->setId($_POST['id']);

$ids = $criteriaAction->getUserIds();
$data = $_POST['data'];

$actionFile = $criteriaAction->getActionFile();

require $actionFile;

$db->end_task($task_id, '1');

$return                 = array();
$return['close_popup']  = '1';
$return['reload']  = '1';

echo "1+++" . json_encode($return);
exit;

