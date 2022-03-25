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
$familymembers = new familymembers;

$familymember = new familymember(
    '', 
    $ses['member_id'],
    $_POST["firstname"],
    $_POST["lastname"],
    $_POST["addressline1"],
    $_POST["addressline2"],
    $_POST["city"],
    $_POST["state"],
    $_POST["zip"],
    $_POST["country"],
    $_POST["phone"],
    $_POST["email"],
    $_POST["DOB"],
    $_POST["hebrewname"],
    $_POST["bnaimitzvahdate"]);

try {
    $id = $familymembers->addFamilyMember($familmember);$result = array('fmid' => $id);
    http_response_code(200);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($result);
    exit;
}
catch (Exception $exception)
{
    $result = array('error' => $exception);
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($result);
    exit;
}
?>