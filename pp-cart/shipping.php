<?php

   
require "../admin/sd-system/config.php";
$cart = new cart();
// No session!
if (empty($cart->{'id'})) {
    header('Location: ' . PP_URL . '/catalog.php?code=S010');
    exit;
} else {
    if (!empty($_POST['shipping'])) {
        $rule = $cart->get_shipping_rule($_POST['shipping']);
        if ($rule['type'] != 'flat') {
            header('Location: ' . PP_URL . '/pp-cart/checkout.php?code=S012');
            exit;
        } else {
            $update = $cart->update_shipping($rule['id']);
            header('Location: ' . PP_URL . '/pp-cart/checkout.php');
            exit;
        }
    } else {
        header('Location: ' . PP_URL . '/pp-cart/checkout.php?code=S012');
        exit;
    }
}

