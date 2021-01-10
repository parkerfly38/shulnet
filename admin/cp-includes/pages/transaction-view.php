<?phpShulNETShulNETShulNET



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
$permission = 'transaction-view';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $admin->show_no_permissions($error, '', '1');

} else {
    // Ownership
    $cart  = new cart;
    $order = $cart->get_order($_POST['id'], '0');


    $notes = new notes;
    $pinned_notes = $notes->get_pinned_notes($_POST['id']);

    // echo "<pre>";
    //print_r($order);
    ?>



    <table class="tablesorter listings" id="subslider_table" border="0">
        <thead>
        <tr>

            <th>Product</th>

            <th width="80">Qty</th>

            <th width="200">Unit Price</th>

            <th width="120">Total</th>

        </tr>
        </thead>

        <tbody>

        <?php



        foreach ($order['components'] as $anItem) {
            echo "<tr>

            <td><a href=\"returnnull.php\" onclick=\"return load_page('product','view','" . $anItem['data']['id'] . "');\">" . $anItem['data']['name'] . "</a>";

            if (! empty($anItem['selected_option'])) {
                echo "<br />Selected options: ";
                if (! empty($anItem['selected_option']['option1'])) {
                    echo $anItem['selected_option']['option1'];
                }
                if (! empty($anItem['selected_option']['option2'])) {
                    echo ' / ' . $anItem['selected_option']['option2'];
                }
                if (! empty($anItem['selected_option']['option3'])) {
                    echo ' / ' . $anItem['selected_option']['option3'];
                }
                if (! empty($anItem['selected_option']['option4'])) {
                    echo ' / ' . $anItem['selected_option']['option4'];
                }
                if (! empty($anItem['selected_option']['option5'])) {
                    echo ' / ' . $anItem['selected_option']['option5'];
                }
            }

            echo "</td>

            <td>" . $anItem['display']['qty'] . "</td>

            <td>" . $anItem['display']['unit_price'] . "</td>

            <td>" . $anItem['display']['total'] . "</td>

            </tr>";

        }


        if (!empty($order['refunds'])) {
            foreach ($order['refunds'] as $aRefund) {
                if ($aRefund['type'] == '1') {
                    $rename = 'Refund';

                } else {
                    $rename = 'Chargeback';

                }
                echo "<tr>

            <td colspan=\"3\">" . $rename . ': ' . $anItem['data']['reason'] . "</td>

            <td>(" . $anItem['display']['total'] . ")</td>

            </tr>";

            }

        }



        ?>

        <tr class="overview">

            <td class="overview_left right" colspan="3">Unit Subtotal</td>

            <td class="overview_right"><?php echo $order['pricing']['format_subtotal_nosave']; ?></td>

        </tr>

        <tr class="overview">

            <td class="overview_left right" colspan="3">Subtotal (before savings and volume discounts)</td>

            <td class="overview_right"><?php echo $order['pricing']['format_subtotal']; ?></td>

        </tr>

        <tr class="overview">

            <td class="overview_left right" colspan="3">Tax</td>

            <td class="overview_right"><?php echo $order['pricing']['format_tax'] . ' (' . $order['pricing']['format_tax_rate'] . ')'; ?></td>

        </tr>

        <tr class="overview">

            <td class="overview_left right" colspan="3">Shipping</td>

            <td class="overview_right"><?php echo $order['pricing']['format_shipping']; ?></td>

        </tr>

        <tr class="overview">

            <td class="overview_left right" colspan="3">Savings<?php if (!empty($order['data']['code'])) {
                    echo "<p class=\"small\">Savings code " . $order['data']['code'] . "</p>";
                } ?></td>

            <td class="overview_right">(<?php echo $order['pricing']['format_savings']; ?>)</td>

        </tr>

        <?php



        if ($order['pricing']['refunds'] > 0) {
            ?>

            <tr class="overview">

                <td class="overview_left right" colspan="3">Refunds</td>

                <td class="overview_right">(<?php echo $order['pricing']['format_refunds']; ?>)</td>

            </tr>

        <?php

        }

        ?>

        <tr class="overview">

            <td class="overview_left right" colspan="3">Total</td>

            <td class="overview_right ctotal"><?php echo $order['pricing']['format_total']; ?></td>

        </tr>

        </tbody>

    </table>



    <div class="col50l">
    <div class="pad24_fs_l">


        <?php

        if (!empty($pinned_notes)) {

            echo '<div style="margin-bottom:24px;">';

            foreach ($pinned_notes as $item) {
                echo $admin->format_note($item);
            }

            echo '</div>';

        }

        ?>



        <fieldset>

            <legend>Shipping Overview</legend>

            <div class="pad24">


                <?php

                if (!empty($order['shipping_info']['cart_session'])) {
                    ?>



                    <dl>

                        <dt>Method</dt>

                        <dd><?php echo $order['shipping_info']['name']; ?></dd>

                        <dt>Status</dt>

                        <?php



                        if ($order['shipping_info']['shipped'] == '1') {
                            ?>

                            <dd>Shipped</dd>

                            <dt>Date</dt>

                            <dd><?php echo format_date($order['shipping_info']['ship_date']); ?></dd>

                            <dt>Provider</dt>

                            <dd><?php echo $order['shipping_info']['shipping_provider']; ?></dd>

                            <?php



                            if ($order['shipping_info']['trackable'] == '1') {
                                echo "<dt>Tracking</dt>

                                    <dd>" . $order['shipping_info']['shipping_number'] . "</dd>

                                    <dt>Tracking</dt>

                                    <dd>" . $cart->tracking_link($order['shipping_info']['shipping_number'], $order['shipping_info']['shipping_provider']) . "</dd>";

                            } else {
                                echo "<dt>Tracking</dt><dd>Tracking unavailable.</dd>";

                            }

                            ?>

                        <?php

                        } else {
                            echo "<dd>Unshipped</dd>";

                        }

                        ?>
                        <dt>First Name</dt>
                        <dd><?php echo $order['shipping_info']['first_name']; ?></dd>
                        <dt>Last Name</dt>
                        <dd><?php echo $order['shipping_info']['last_name']; ?></dd>
                        <dt>Address</dt>
                        <dd><?php echo $order['shipping_info']['address_line_1']; ?></dd>
                        <dt>&nbsp;</dt>
                        <dd><?php echo $order['shipping_info']['address_line_2']; ?></dd>
                        <dt>City</dt>
                        <dd><?php echo $order['shipping_info']['city']; ?></dd>
                        <dt>State</dt>
                        <dd><?php echo $order['shipping_info']['state']; ?></dd>
                        <dt>Zip</dt>
                        <dd><?php echo $order['shipping_info']['zip']; ?></dd>
                        <dt>Country</dt>
                        <dd><?php echo $order['shipping_info']['country']; ?></dd>
                        <dt>Instructions</dt>
                        <dd><?php echo $order['shipping_info']['ship_directions']; ?></dd>
                    </dl>

                    <div class="clear"></div>



                <?php

                } else {
                    echo "<p>No shipping is required for this order.</p>";

                }

                ?>


            </div>

        </fieldset>


        <fieldset>

            <legend>Billing Information</legend>

            <div class="pad24">


                <?php
                if (empty($order['billing']['id'])) {
                    echo "<p>No billing information available.</p>";

                } else {
                    if ($order['billing']['method'] == 'Credit Card') {
                        ?>

                        <dl>
                            <dt>Card Number</dt>
                            <dd><?php echo $order['billing']['full_method'] . $order['billing']['img']; ?></dd>
                            <dt>Card Expiration</dt>
                            <dd><?php echo $order['billing']['card_exp_mm']; ?>
                                /<?php echo $order['billing']['card_exp_yy']; ?></dd>
                            <dt>First Name</dt>
                            <dd><?php echo $order['billing']['first_name']; ?></dd>
                            <dt>Last Name</dt>
                            <dd><?php echo $order['billing']['last_name']; ?></dd>
                            <dt>Phone</dt>
                            <dd><?php echo $order['billing']['phone']; ?></dd>
                            <dt>E-Mail</dt>
                            <dd><?php echo $order['billing']['email']; ?></dd>
                            <dt>Address 1</dt>
                            <dd><?php echo $order['billing']['address_line_1']; ?></dd>
                            <dt>Address 2</dt>
                            <dd><?php echo $order['billing']['address_line_2']; ?></dd>
                            <dt>City</dt>
                            <dd><?php echo $order['billing']['city']; ?></dd>
                            <dt>State</dt>
                            <dd><?php echo $order['billing']['state']; ?></dd>
                            <dt>Country</dt>
                            <dd><?php echo $order['billing']['country']; ?></dd>
                        </dl>

                    <?php

                    } else {

                        ?>

                        <dl>
                            <dt>Method</dt>
                            <dd><?php echo $order['billing']['method']; ?></dd>
                            <dt>First Name</dt>
                            <dd><?php echo $order['billing']['first_name']; ?></dd>
                            <dt>Last Name</dt>
                            <dd><?php echo $order['billing']['last_name']; ?></dd>
                            <dt>Phone</dt>
                            <dd><?php echo $order['billing']['phone']; ?></dd>
                            <dt>E-Mail</dt>
                            <dd><?php echo $order['billing']['email']; ?></dd>
                            <dt>Address 1</dt>
                            <dd><?php echo $order['billing']['address_line_1']; ?></dd>
                            <dt>Address 2</dt>
                            <dd><?php echo $order['billing']['address_line_2']; ?></dd>
                            <dt>City</dt>
                            <dd><?php echo $order['billing']['city']; ?></dd>
                            <dt>State</dt>
                            <dd><?php echo $order['billing']['state']; ?></dd>
                            <dt>Country</dt>
                            <dd><?php echo $order['billing']['country']; ?></dd>
                        </dl>

                        <?php

                    }

                }

                ?>

                <div class="clear"></div>


            </div>

        </fieldset>


    </div>
    </div>

    <div class="col50r">
        <div class="pad24_fs_r">


            <fieldset>

                <legend>Order Overview</legend>

                <div class="pad24">


                    <dl>

                        <dt>Order No.</dt>

                        <dd><?php echo $order['data']['id']; ?></dd>

                        <dt>Status</dt>

                        <?php



                        if ($order['data']['status'] == '9') {
                            echo '<dd>Rejected</dd>';
                        } else if ($order['data']['status'] == '2') {
                            echo '<dd>Pending Payment</dd>';
                        } else if ($order['data']['status'] == '3') {
                            echo '<dd>Partially Refunded</dd>';
                        } else if ($order['data']['status'] == '4') {
                            echo '<dd>Fully Refunded</dd>';
                        } else if ($order['data']['status'] == '1') {
                            echo '<dd>Success</dd>';
                        } else {
                            $activity = $cart->get_last_activity($order['data']['id']);
                            if ($activity['error'] != '1') {
                                $la_dif = date_difference($activity['date']);
                                echo '<dd>Abandonned or still active</dd>';
                                echo '<dt>Last Activity</dt><dd>' . $activity['format_date'] . ' (' . $la_dif . ')</dd>';
                                echo '<dt>Last Page</dt><dd><a href="' . $activity['format_page'] . '" target="_blank">' . $activity['page'] . '</a></dd>';

                            } else {
                                echo "<dd>Abandonned</dd>";

                            }

                        }

                        ?>

                        <dt>Date Started</dt>

                        <dd><?php echo format_date($order['data']['date']); ?></dd>

                        <dt>Date Completed</dt>

                        <dd><?php echo format_date($order['data']['date_completed']); ?></dd>

                        <dt>Turn Around</dt>

                        <dd><?php echo date_difference($order['data']['date_completed'], $order['data']['date']); ?></dd>



                        <?php



                        if (!empty($order['data']['invoice_id'])) {
                            ?>

                            <dt>Invoice ID</dt>

                            <dd><a href="return_null.php"
                                   onclick="return load_page('invoice','view','<?php echo $order['data']['invoice_id']; ?>');"><?php echo $order['data']['invoice_id']; ?></a>
                            </dd>

                        <?php

                        }

                        ?>



                        <dt>Gateway</dt>

                        <dd><?php echo $order['data']['payment_gateway']; ?></dd>

                        <dt>Gateway Ref.</dt>

                        <dd><?php echo $order['data']['gateway_order_id']; ?></dd>

                        <dt>Gateway Msg.</dt>

                        <dd><?php echo $order['data']['gateway_msg']; ?></dd>

                        <dt>Gateway Resp.</dt>

                        <dd><?php echo $order['data']['gateway_resp_code']; ?></dd>

                        <dt>User</dt>

                        <dd><?php
                            $foundUser = false;
                            if ($order['data']['member_type'] == 'member') {
                                $user = new user;
                                $find = $user->get_username($order['data']['member_id']);
                                if (! empty($find)) {
                                    $pageType = 'member';
                                    $verb = 'Member';
                                } else {
                                    $pageType = 'contact';
                                    $verb = 'Contact';
                                    $up = $cart->updateOrderUserType($order['data']['id'], 'contact');
                                }
                            } else {
                                $pageType = 'contact';
                                $verb = 'Contact';
                            }
                            echo "<a href=\"#\" onclick=\"return load_page('" . $pageType . "','view','" . $order['data']['member_id'] . "');\">" . $order['data']['member_id'] . " (" . $verb . ")</a>";
                            ?></dd>

                        <dt>IP</dt>

                        <dd><?php echo $order['data']['ip']; ?></dd>

                    </dl>

                    <div class="clear"></div>


                </div>

            </fieldset>


            <fieldset>

                <legend>Totals</legend>

                <div class="pad24">


                    <dl>

                        <dt>Products</dt>

                        <dd><?php echo $order['data']['total_products']; ?></dd>

                        <dt>Items</dt>

                        <dd><?php echo $order['data']['total_items']; ?></dd>

                        <dt>Physical Items</dt>

                        <dd><?php echo $order['data']['total_physical_items']; ?></dd>

                        <dt>Total Weight</dt>

                        <dd><?php echo $order['data']['weight']; ?></dd>

                    </dl>

                    <div class="clear"></div>


                </div>

            </fieldset>


            <fieldset>

                <legend>Refunds</legend>

                <div class="pad24">

                    <?php



                    if (empty($order['refunds'])) {
                        echo "<p>No refunds found on this order.</p>";

                    } else {
                        foreach ($order['refunds'] as $aRef) {

                        }

                    }

                    ?>

                </div>

            </fieldset>


        </div>
    </div>

    <div class="clear"></div>



<?php

}

?>