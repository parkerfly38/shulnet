<?php

   
/**
 *
 * ShulNET
 *
 * View an order after it
 * was placed.
 */
// Required stuff
require "../admin/sd-system/config.php";
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
} else {
    show_view_error();
}
$cart = new cart();
$order = $cart->get_order($id);

if (empty($order['data']['id'])) {
    show_view_error();
    exit;
}
// Salt?
if ($order['data']['salt'] != $_GET['s']) {
    show_view_error();
    exit;
}

$billing_data = $cart->order_card_info($order['data']['card_id']);
// Shipping
if ($order['data']['need_shipping'] == '1') {
    $f12           = new field('shipping', '0', '', '', '', '', '1');
    $shipping_form = $f12->generate_form('shipping_form', $order['shipping_info']);
    // Shipped?
    if ($order['shipping_info']['shipped'] == '1') {
        $status = $db->get_error('S032');
        $status = str_replace('%ship_date%', format_date($order['shipping_info']['ship_date']), $status);
        $status = str_replace('%ship_provider%', $order['shipping_info']['shipping_provider'], $status);
        // Tracking?
        if ($order['shipping_info']['trackable'] == '1') {
            $tracking   = $db->get_error('S034');
            $track_link = $cart->tracking_link($order['shipping_info']['shipping_number'], $order['shipping_info']['shipping_provider']);
            $tracking   = str_replace('%tracking_number%', $order['shipping_info']['shipping_number'], $tracking);
        } else {
            $tracking   = $db->get_error('S035');
            $track_link = $db->get_error('S037');
        }
    } else {
        $status     = $db->get_error('S033');
        $tracking   = $db->get_error('S035');
        $track_link = $db->get_error('S037');
    }
    $cart->{'shipping'}['tracking'] = $tracking;
    $cart->{'shipping'}['status']   = $status;
    $cart->{'shipping'}['link']     = $track_link;
} else {
    $shipping_form                  = $db->get_error('S028');
    $cart->{'shipping'}['tracking'] = $db->get_error('S035');
    $cart->{'shipping'}['status']   = $db->get_error('S033');
    $cart->{'shipping'}['link']     = $db->get_error('S037');
}
$f12           = new field('billing', '0', '', '', '', '', '1');
$billing_form  = $f12->generate_form('billing_form', $billing_data);
$show_products = $cart->build_product_blocks($order['components'], '0', $order['data']['state'], $order['data']['country']);
$changes       = array(
    'data'            => $order['data'],
    'cart_components' => $show_products,
    'billing'         => $billing_data,
    'billing_form'    => $billing_form,
    'shipping_form'   => $shipping_form,
    'shipping'        => $cart->{'shipping'},
    'pricing'         => $order['pricing'],
);
$temp          = new template('cart_view_order', $changes, '1');
echo $temp;
exit;
/**
 * Show cart error.
 */
function show_view_error($code = 'S030')
{
    global $db;
    $changes = array(
        'details' => $db->get_error($code)
    );
    $temp    = new template('error', $changes);
    echo $temp;
    exit;
}


