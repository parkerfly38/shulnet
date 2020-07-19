<?php

   
$criteria = new criteria($_POST['id']);
if (empty($criteria->{'data'}['id'])) {
    $admin->show_no_permissions('', 'Could not find criteria.', '1');
} else {
    $id      = $_POST['id'];
    $crit_id = $_POST['id'];
    $etype   = 'targeted';
    $type    = 'member';
    $to_name = "<a href=\"returnnull.php\" onclick=\"return popup('preview_criteria','id=" . $crit_id . "','1');\">Criteria \"" . $criteria->{'data'}['name'] . "\"</a>";
    include 'email-send.php';

}