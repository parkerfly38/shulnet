<?php

   

require "admin/sd-system/config.php";

$session = new session;
$check = $session->check_session();

if ($check['error'] == '1') {

    $changes = array();
    if (!empty($_GET['r'])) {
        $options = array(
            'https://',
            'http://',
            '://',
            '//',
        );
        if (substr(PP_URL, 0, 8) == 'https://') {
            $rep = 'https://';
        } else {
            $rep = 'http://';
        }
        $r = $rep . str_replace($options, '', $_GET['r']);
        $changes['url'] = $r;
    } else {
        $changes['url'] = '';
    }

    $template = new template('login', $changes, '1');

    echo $template;
    exit;

} else {

    header('Location: ' . PP_URL . '/manage');
    exit;

}