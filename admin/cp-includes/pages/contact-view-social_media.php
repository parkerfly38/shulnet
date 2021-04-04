<?php

   
$contact    = new contact;
$data       = $contact->get_contact($_POST['id']);
$twitter_id = $data['data']['twitter'];
include 'social_media-twitter.php';
?>