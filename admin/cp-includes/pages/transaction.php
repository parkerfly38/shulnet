<?php 



/**
 *
 *
 * Zenbership Membership Software
 * Copyright (C) 2013-2016 Castlamp, LLC
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author      Castlamp
 * @link        http://www.castlamp.com/
 * @link        http://www.zenbership.com/
 * @copyright   (c) 2013-2016 Castlamp
 * @license     http://www.gnu.org/licenses/gpl-3.0.en.html
 * @project     Zenbership Membership Software
 */
// Check permissions, ownership,
// and if it exists.
$show = '1';
$permission = 'transaction';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $show  = '0';
    $error = 'permissions';

}
// Show?
if ($show != '1') {
    $admin->show_no_permissions($error, '', '1');

} else {
    // Check if refreshing the cache.
    include "check_cache.php";
    $cart  = new cart;
    $order = $cart->get_order($_POST['id'], '0', $recache);
    ?>



    <div id="slider_submit">
        <div class="pad24tb">


            <div id="topicons">

                <a href="null.php" onclick="return json_add('transaction-email','<?php echo $_POST['id']; ?>','0','','','1');"><img src="imgs/icon-email.png"
                                                                                      border="0" title="Send Email"
                                                                                      alt="Send Email" class="icon"
                                                                                      width="16" height="16"/>Re-send Receipt</a>

                <a target="_blank" href="<?php echo PP_URL; ?>/pp-cart/view_order.php?id=<?php echo $order['data']['id']; ?>&s=<?php echo $order['data']['salt']; ?>"><img src="imgs/icon-receipt.png" border="0" title="Receipt"
                                                             alt="Receipt" class="icon" width="16" height="16"/> View Receipt</a>

                <a href="index.php?l=transaction-print"><img src="imgs/icon-print.png" border="0" title="Print"
                                                             alt="Print" class="icon" width="16" height="16"/> Print</a>

                <a href="null.php"
                   onclick="return delete_item('ppSD_cart_sessions','<?php echo $order['data']['id']; ?>','','1');"><img
                        src="imgs/icon-delete-on.png" border="0" title="Delete" alt="Delete" class="icon" width="16"
                        height="16"/> Delete</a>

            </div>


            <ul id="slider_tabs">

                <li id="overview" class="on">Overview</li>

                <li id="transaction-edit:<?php echo $order['data']['id']; ?>" class="popup">Edit</li>

                <?php



                if (!empty($order['shipping_info']['cart_session'])) {
                    ?>

                    <li id="shipping_mark:<?php echo $order['data']['id']; ?>" class="popup">Shipping</li>

                <?php

                }

                if ($order['data']['status'] == '1' || $order['data']['status'] == '3') {
                    echo '<li id="refund:' . $order['data']['id'] . '" class="popup">Refund</li>';

                }

                //if (! empty($order['data']['card_id'])) {

                //    echo "<li id=\"credit_card-edit:" . $order['data']['card_id'] . "\" class=\"popup\">Credit Card</li>";

                //}

                ?>


                <li id="notes">Notes<a class="topright_bubble" href="returnnull.php"
                                       onclick="return popup('note-add','user_id=<?php echo $order['data']['id']; ?>&scope=transaction','1');">+</a>
                </li>

            </ul>

            <div id="slider_left">

                <span class="title">No. <?php echo $order['data']['id']; ?></span>

            <span class="data"><?php



                echo "Processed on " . format_date($order['data']['date_completed']) . " through " . $order['data']['payment_gateway'];

                ?></span>

            </div>

            <div class="clear"></div>

        </div>
    </div>



    <div id="primary_slider_content">

        %inner_content%

    </div>



    <script type="text/javascript" src="<?php echo PP_ADMIN; ?>/js/forms.js"></script>

    <script type="text/javascript" src="<?php echo PP_ADMIN; ?>/js/sliders.js"></script>





<?php

}

?>