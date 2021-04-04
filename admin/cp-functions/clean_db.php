<?php
require "../sd-system/config.php";
$admin = new admin;
// Check permissions and employee
$employee = $admin->check_employee('conditions');
if ($employee['permissions']['admin'] != '1') {
    echo "0+++No permission.";
    exit;

} else {
    if ($_POST['type'] == 'cache') {
        $db->clear_cache();

    } else if ($_POST['type'] == 'stats') {
        $db->clear_stats();

    } else if ($_POST['type'] == 'temp') {
        $db->clear_temp_data();

    }
    echo "1+++Database Maintenance Complete";
    exit;

}





