<?php

   
require "../admin/sd-system/config.php";
$cart = new cart();
//pa($cart);
$cart->check_permission('3');
// No session!
if (empty($cart->id)) {
    header('Location: ' . PP_URL . '/catalog.php?code=S009');
    exit;
} else {
    // Are there any products in the
    // user's cart?
    $total_products = $cart->total_items_in_cart($cart->id);
    if ($total_products <= 0) {
        header('Location: ' . PP_URL . '/catalog.php?code=S010');
        exit;
    } // Found session and products
    // We can checkout now!
    else {
        // Terms?
        $cart->check_terms();
        $cart->check_forms();
        $cart->check_upsell();
        // Get the primary gateway
        if (!empty($_GET['method'])) {
            $primary_gateway = $cart->get_gateways('', $_GET['method']);
        } else {
            $primary_gateway = $cart->get_gateways('1');
        }
        if (empty($primary_gateway)) {

            echo "<h1>No primary payment gateway has been selected. Please select a payment gateway below:</h1>";

            $gateways = $cart->get_gateways();
            foreach ($gateways as $option) {
                echo "<a href=\"" . PP_URL . "/pp-cart/checkout.php?method=" . $option['code'] . "\">" . $option['name'] . "</a><br />";
            }

        } else {
            // Update gateway
            $cart->update_order_gateway($primary_gateway['0']['code']);

            // API!
            if ($primary_gateway['0']['api'] == '1') {

                $ssl = $db->getSecureLink();

                header('Location: ' . $ssl . '/pp-cart/payment.php');
                exit;
            }
            // Not an API
            else {
                // Shipping?
                $cart->check_for_shipping();

                $gateway = new $primary_gateway['0']['code'];
                $link = $gateway->checkout();

                header("Location: " . $link);
                exit;
            }
        }
    }
}

