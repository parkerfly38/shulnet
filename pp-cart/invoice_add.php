<?php

   
require "../admin/sd-system/config.php";
// GET OR POST Request?
// Both are possible, GET if invoice_allow_partial=0,
// POST if invoice_allow_partial=1
if ($db->get_option('invoice_allow_partial') == '1') {
    $amount = $_POST['amount'];
    $id     = $_POST['id'];
    $hash   = $_POST['hash'];
} else {
    $amount = $_GET['amount'];
    $id     = $_GET['id'];
    $hash   = $_GET['hash'];
}
$amount = str_replace(',','',$amount);
// Everything there?
if (empty($amount) || empty($id) || empty($hash)) {
    $db->show_error_page('I009');
}
// Get invoice
$invoice = new invoice();
$data    = $invoice->check_invoice($id, $hash);
// Get total.
if ($amount > $data['totals']['due']) {
    $amount = $data['totals']['due'];
}
// Amount numeric?
if (! is_numeric($amount)) {
    $db->show_error_page('I008');
}
// Add to cart
// Create a product for the amount
$pricing_data   = array(
    'name'          => 'Payment for invoice ID ' . $id,
    'price'         => $amount,
    'type'          => '1',
    'hide'          => '2',
    'hide_in_admin' => '1',
    'max_per_cart'  => '1',
    'owner'         => $data['data']['owner'],
    'public'        => '1',
    'invoice_id'    => $data['data']['id'],
);
$cart           = new cart;
$create_product = $cart->add_product($pricing_data);
$empty          = $cart->empty_cart();
$cart_session   = $cart->check_session();
$add            = $cart->add($create_product, '1', '', $data['data']['member_id'], '', $cart_session);
$path           = '/pp-cart/invoice.php?id=' . $data['data']['id'] . '&h=' . $data['data']['hash'];
$return_path    = $cart->update_return($cart_session, $path);
$db->create_cookie('zen_invoice', $id . '|||' . $create_product);
$secure = $db->getSecureLink();
//header('Location: ' . $secure . '/pp-cart/checkout.php');
header('Location: ' . PP_URL . '/pp-cart/checkout.php');
exit;
