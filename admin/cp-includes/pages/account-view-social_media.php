<?php

   
$account    = new account;
$data       = $account->get_account($_POST['id']);
$twitter_id = $data['twitter'];
include 'social_media-twitter.php';
?>