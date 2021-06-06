<?php
$permission = 'gabbaim';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $admin->show_no_permissions();

} else {
    //get the closest events to our date
    $gc = new gabbai;
    $aliyot = $gc->getAliyotByDate('2021-06-12');
    print_r($aliyot);
?>

<?php } ?>