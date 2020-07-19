<?php

   
require "admin/sd-system/config.php";
$captcha  = new captcha;
$issue    = $db->issue_captcha(get_ip(), 'user', '');
$url      = PP_ADMIN . "/cp-functions/generate_captcha.php?c=" . $issue;
$captput  = $captcha->captcha_block($url);
$changes  = array(
    'captcha_block' => $captput,
);
$template = new template('password_recovery', $changes, '1');
echo $template;
exit;