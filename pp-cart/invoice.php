<?php

   

require "../admin/sd-system/config.php";

$invoice = new invoice();
if (! empty($_GET['id'])) {
    $data    = $invoice->check_invoice($_GET['id'], $_GET['h']);
    if (empty($data)) {
        $db->show_error_page('I006');
        exit;
    } else {

        if ($data['data']['quote'] == '1') {
            $template = 'invoice_quote';
        } else {
            $template = 'invoice';
        }

        if (empty($_GET['isp'])) {
            $invoice->markSeen($data['data']['id']);
        } else {
            $substr = substr(SALT1, 4, 10);
            if ($_GET['isp'] != $substr) {
                $invoice->markSeen($data['data']['id']);
            }
        }


        $printed = $invoice->generate_template($data['data']['id'], $template, '1');
        echo $printed;
        exit;
    }
} else {
    $db->show_error_page('I006');
    exit;
}

