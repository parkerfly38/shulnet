<?php
require "../admin/sd-system/config.php";
$session = new session;
$ses = $session->check_session();
if ($ses['error'] == '1')
{
    $result = array('error' => "You must be logged in to add family members.");
    http_response_code(403);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($result);
    exit;
}