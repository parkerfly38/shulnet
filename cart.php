<?php

   
// Load the basics
require "admin/sd-system/config.php";
$cart = new cart();

if (! empty($_GET['reset'])) {
    $cart->reset_cart();
    header('Location: ' . PP_URL . '/catalog.php');
    exit;
}

if (! empty($cart->order['data']['reg_session'])) {
    header('Location: ' . PP_URL . '/register.php?id=' . $cart->order['data']['reg_session'] . '&code=F043');
    exit;
}

/**
 * Permissions:
 * 0 : None
 * 1 : View Catalog
 * 2 : View Cart
 * 3 : Checkout
 */
$cart->check_permission('2');

/**
 * Delete cookie is applicable
 */
if ($cart->order['data']['status'] == '1') {
    $del = $db->delete_cookie('zen_cart');
    header('Location: ' . PP_URL . '/cart.php');
    exit;
}
/**
 * Forced addition?
 */
if (! empty($_GET['id'])) {
    if (empty($_GET['qty'])) { $qty = 1; }
    else {
        if (is_numeric($_GET['qty'])) {
            $qty = $_GET['qty'];
        } else {
            $qty = 1;
        }
    }
    $add = $cart->add($_GET['id'], $qty, '');
    if ($add['error'] == '1') {
        header('Location: cart.php?code=' . $add['code']);
        exit;
    } else {
        header('Location: cart.php?scode=S068');
        exit;
    }
}

/**
 * View Cart products
 */
if ($cart->order['data']['total_items'] <= 0) {
    $panels        = '';
    $template_name = 'cart_overview_empty';
} else {
    $panels        = $cart->build_product_blocks($cart->order['components']);
    $template_name = 'cart_overview';
}

$changes = array(
    'cart_components' => $panels,
    'pricing'         => $cart->order['pricing'],
    'code'            => $cart->order['code'],
    'data'            => $cart->order['data'],
);
$temp    = new template($template_name, $changes, '1');
echo $temp;
exit;