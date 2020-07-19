<?php

   
/**
 * Zenbership
 * Cart ajax functions.
 */
require "../admin/sd-system/config.php";
$cart = new cart;
$cart->empty_cart();
header('Location: ' . PP_URL . '/cart.php');
exit;

