<?php

   

require "sd-system/config.php";

if ($_GET['code'] == SALT1) {
    $admin = new admin;
    $employee = $admin->get_employee($_GET['username']);

    if (! empty($employee['id'])) {
        $db->run_query("
            UPDATE
                `ppSD_staff`
            SET
                `locked`='1920-01-01 00:01:01',
                `locked_ip`='',
                `login_attempts`='0'
            WHERE
                `id`='" . $db->mysql_clean($employee['id']) . "'
            LIMIT 1
        ");

        header('Location: ' . PP_URL . '/admin/login.php?incode=u01');
        exit;
    } else {
        header('Location: ' . PP_URL . '/admin/login.php?incode=u99');
        exit;
    }
} else {
    header('Location: ' . PP_URL . '/admin/login.php?incode=u99');
    exit;
}