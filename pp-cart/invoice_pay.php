<?php

   
require "../admin/sd-system/config.php";
$invoice = new invoice();
if (! empty($_GET['id'])) {
    $data    = $invoice->check_invoice($_GET['id'], $_GET['h']);
    if (empty($data)) {
        $db->show_error_page('I006');
        exit;
    } else {
        $temp    = $invoice->generate_template($data['data']['id'], 'invoice_pay', '1');

        if ($db->get_option('invoice_allow_partial') == '1') {
            $payment_info = place_currency('<input type="text" name="amount" value="' . $data['totals']['due'] . '" style="width:100px;" />', '1');
            $temp         = str_replace('%payment_field%', $payment_info, $temp);
            echo $temp;
            exit;
        } else {
            $secure = $invoice->getSecureLink();
            header('Location: ' . $secure . '/pp-cart/invoice_add.php?id=' . urlencode($data['data']['id']) . '&hash=' . urlencode($data['data']['hash']) . '&amount=' . urlencode($data['totals']['due']));
            exit;
        }

    }
} else {
    $db->show_error_page('I006');
    exit;
}

