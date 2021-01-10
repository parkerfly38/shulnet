<?php

require "../sd-system/config.php";
$admin = new admin;
// Check permissions and employee
$employee = $admin->check_employee('conditions');
$current  = $_POST['condition'];
if (!empty($_POST['id'])) {
    $id = $_POST['id'];

} else {
    $id = '';

}
$data = $admin->cell_form_condition($current, $id);
echo $data;
exit;





