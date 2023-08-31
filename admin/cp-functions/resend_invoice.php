<?php 
require "../sd-system/config.php";
$task     = 'invoice-email';
$admin    = new admin;
$employee = $admin->check_employee($task);
if (!empty($_POST['id'])) {
    $invoice = new invoice;
    $data    = $invoice->get_invoice($_POST['id'], '1');
    if ($employee['id'] != $data['data']['owner'] && $employee['permissions']['admin'] != '1' && $employee['data']['public'] != '1') {
        echo "0+++You cannot edit this invoice.";
        exit;

    } else {
        $send = $invoice->send_invoice($_POST['id']);
        echo "1+++Invoice sent.";
        exit;

    }

} else {
    echo "0+++Could not find invoice.";
    exit;

}
echo $data;
exit;



