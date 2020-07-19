<?php

   
$campaign    = new campaign($_POST['id']);
$data        = $campaign->get_campaign();
$id          = $_POST['id'];
$etype       = 'targeted';
$type        = 'campaign';
$campaign_id = $_POST['id'];
$criteria    = new criteria;
$edata       = array(
    'x1' => $id . '||campaign_id||eq||ppSD_campaign_subscriptions',
    'x2' => '1||active||eq||ppSD_campaign_subscriptions',
);
$crit_id     = $criteria->build_filters($edata, 'campaign', 'email');
$to_name     = $data['name'] . " Campaign";
include 'email-send.php';