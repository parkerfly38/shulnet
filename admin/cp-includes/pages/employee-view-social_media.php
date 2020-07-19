<?php

   
$data       = $admin->get_employee('', $_POST['id']);
$twitter_id = $data['twitter'];
include 'social_media-twitter.php';
?>