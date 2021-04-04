<?php

   
require "../admin/sd-system/config.php";
$cart = new cart();
// No session!
if (empty($cart->{'id'})) {
    header('Location: ' . PP_URL . '/catalog.php?code=S010');
    exit;
} else {
    if (!empty($_POST['agree'])) {
        $q = $db->update("
			UPDATE `ppSD_cart_sessions`
			SET `agreed_to_terms`='1'
			WHERE `id`='" . $db->mysql_clean($cart->{'id'}) . "'
			LIMIT 1
		");
        header('Location: ' . PP_URL . '/pp-cart/checkout.php');
        exit;
    } else {
        header('Location: ' . PP_URL . '/pp-cart/checkout.php?code=S011');
        exit;
    }
}

