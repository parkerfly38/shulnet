<?php

   
require "../admin/sd-system/config.php";
if (! empty($_GET['id'])) {
    $invoice = new invoice();
    $data    = $invoice->check_invoice($_GET['id'], $_GET['h']);
    if (empty($data)) {
        $db->show_error_page('I006');
        exit;
    } else {

        if ($data['data']['quote'] == '1') {
            $template = 'invoice_print_quote';
        } else {
            $template = 'invoice_print';
        }

        $printed = $invoice->generate_template($data['data']['id'], $template);
        echo $printed;
        exit;
    }
} else {
    $db->show_error_page('I006');
    exit;
}