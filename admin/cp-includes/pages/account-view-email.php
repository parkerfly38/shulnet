<?php

   
$account  = new account;
$data     = $account->get_account($_POST['id']);
$id       = $_POST['id'];
$etype    = 'targeted';
$type     = 'account';
$criteria = new criteria;
if ($_POST['type'] == 'contacts') {
    $edata    = array(
        'account' => $id . '||account||eq||ppSD_contacts'
    );
    $type = "contact";
} else {
    $edata    = array(
        'account' => $id . '||account||eq||ppSD_members'
    );
    $type = "member";
}
$crit_id  = $criteria->build_filters($edata, $type, 'email');
$to_name  = $data['name'] . " Account";
include 'email-send.php';