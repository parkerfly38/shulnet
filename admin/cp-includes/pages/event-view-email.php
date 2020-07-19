<?php

   
$event    = new event;
$data     = $event->get_event($_POST['id']);
$id       = $_POST['id'];
$etype    = 'targeted';
$type     = 'event';
$criteria = new criteria;
if (!empty($_POST['pd']) && $_POST['pd'] != 'undefined') {
    $crit_id = $criteria->build_filters(unserialize($_POST['pd']), 'rsvp', 'email');
    $to_name = "Specific attendees of " . $data['data']['name'] . " (<a href=\"return_null.php\" onclick=\"return popup('preview_criteria','id=" . $crit_id . "');\">View</a>)";
} else {
    $edata   = array(
        'x' => $id . '||event_id||eq||ppSD_event_rsvps'
    );
    $crit_id = $criteria->build_filters($edata, 'rsvp', 'email');
    $to_name = "Attendees of " . $data['data']['name'];
}
include 'email-send.php';

?>