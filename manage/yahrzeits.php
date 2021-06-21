<?php
require "../admin/sd-system/config.php";

$session = new session;
$ses = $session->check_session();
if ($ses['error'] == '1') {
    $session->reject('login', $ses['ecode']);
    exit;
} else {
    $user = new user;
    $member = $user->get_user($ses['member_id']);

    $query = "SELECT English_Name, Hebrew_Date_of_Death FROM ppSD_yahrzeits INNER JOIN ppSD_yahrzeit_members ON id = yahrzeit_id WHERE user_id = '".$ses["member_id"]."'";
    $STH = $db->run_query($query);
    $trs = "";
    while($row = $STH->fetch())
    {
        $trs .= "<tr><td>".$row["English_Name"]."</td><td>".$row["Hebrew_Date_of_Death"]."</td><td></td></tr>";

    }
    $changes = array(
        'yahrzeits' => $trs
    );
    $wrapper = new template('manage_yahrzeits', $changes, '1');
    echo $wrapper;
    exit;
}
?>