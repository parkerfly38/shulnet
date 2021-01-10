<?php
/**
 * Create Event
 * From admin

 */
// Load the basics
require "../sd-system/config.php";
$admin = new admin;
$task  = 'event_duplicate';
// Check permissions and employee
$employee = $admin->check_employee($task);
$task_id  = $db->start_task($task, 'staff', $_POST['id'], $employee['username']);
$event    = new event;
$data     = $event->get_event($_POST['id']);
if ($employee['permissions']['admin'] != '1' && $data['data']['owner'] != $employee['id']) {
    echo "You are not permitted to duplicate this event.";
    exit;

} else {
    // Event
    $new_id = $event->duplicate($_POST['id'], $data['data']['name']);

}
$task = $db->end_task($task_id, '1');
// Return Cell
$history     = new history($new_id, '', '', '', '', '', 'ppSD_events');
//$return_cell = $history->{'table_cells'};

$table_format  = new table('event', 'ppSD_events');
$return_cell = $table_format->render_cell($history->final_content);

echo "1+++table_append+++" . $return_cell;
exit;



