<?php
require "../sd-system/config.php";
$admin = new admin;
// Check permissions and employee
$employee = $admin->check_employee('conditions');
$scope    = $_POST['type'];
if (!empty($_POST['id']) && $_POST['id'] != 'undefined') {
    $id = $_POST['id'];
} else {
    $id = '';
}
if (!empty($_POST['value']) && $_POST['value'] != 'undefined') {
    $value = $_POST['value'];
} else {
    $value = '';
}
if (!empty($_POST['eq']) && $_POST['eq'] != 'undefined') {
    $eq = $_POST['eq'];
} else {
    $eq = '';
}
$data = $admin->cell_criteria($scope, $id, $value, $eq);
echo $data;
exit;





