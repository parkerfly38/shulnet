<?php

   

$contact = new contact;
$data    = $contact->get_contact($_POST['id']);

if (empty($data['data']['email'])) {
    $admin->show_no_permissions('', 'There is no email on file for this user.', '1');
}
else if ($data['data']['email_optout'] == '1') {
    $admin->show_no_permissions('', 'User has been opted out of e-mail services.', '1');
}
else {
    $id      = $_POST['id'];
    $etype   = 'email';
    $type    = 'contact';
    $user_type    = 'contact';
    $crit_id = '';
    $to_name = $data['data']['last_name'] . ", " . $data['data']['first_name'] . " &lt;" . $data['data']['email'] . "&gt;";
    include 'email-send.php';
}
