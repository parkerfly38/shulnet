<?php
require "../admin/sd-system/config.php";

$session = new session;
$ses = $session->check_session();
if ($ses['error'] == '1') {
    $session->reject('login', $ses['ecode']);
    exit;
} else {
    $user = new user;
    $member = $user->get_user($ses["member_id"]);

    $familymembers = new familymembers;
    $fms = $familymembers->getFamilyMembersByMemberID($ses["member_id"]);
    $trs = "";
    foreach($fms as $fm)
    {
        $trs .= "<tr><td>".$fm->last_name.", ".$fm->first_name."</td><td>".date_format(date_create($fm->DOB), 'm/d/Y')."</td><td>View</td></tr>";
    }
    $changes = array(
        'familymembers' => $trs
    );
    $wrapper = new template('manage_familymembers',$changes, '1');
    echo $wrapper;
    exit;
}
?>