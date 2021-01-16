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
$permission = 'subscription-edit';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $admin->show_no_permissions($error, '', '1');

} else {
    // Ownership
    $subscription = new subscription;
    $sub          = $subscription->get_subscription($_POST['id']);



    ?>



    <div class="col50l">
        <div class="pad24_fs_l">


            <fieldset>

                <legend>Product Overview</legend>

                <div class="pad24">


                    <dl>

                        <dt>ID</dt>

                        <dd><?php echo $sub['data']['id']; ?></dd>

                        <dt>Status</dt>

                        <dd><?php echo $sub['data']['show_status']; ?></dd>

                        <dt>Product</dt>

                        <dd><a href="null.php"
                               onclick="return load_page('product','view','<?php echo $sub['product']['id']; ?>');"><?php echo $sub['product']['name']; ?></a>
                        </dd>

                        <dt>User</dt>

                        <dd><?php



                            if ($sub['data']['member_type'] == 'member') {
                                echo "<a href=\"null.php\" onclick=\"return load_page('member','view','" . $sub['data']['member_id'] . "');\">" . $sub['data']['member_id'] . "</a>";

                            } else {
                                echo "<a href=\"null.php\" onclick=\"return load_page('contact','view','" . $sub['data']['member_id'] . "');\">" . $sub['data']['member_id'] . "</a>";

                            }

                            ?></dd>

                        <dt>Last Price</dt>

                        <dd><?php echo $sub['data']['format_price']; ?></dd>

                        <dt>Next Price</dt>

                        <dd><?php echo $sub['data']['format_next_price']; ?></dd>

                        <dt>Type</dt>

                        <dd><?php

                            if (empty($sub['data']['card_id'])) {
                                $nocard_opt = $db->get_option('sub_no_card_action');
                                if ($nocard_opt == 'invoice') {
                                    echo "Invoiced";

                                } else {
                                    echo "Manual Payments";

                                }
                                echo " (<a href=\"null.php\" onclick=\"return popup('credit_card-add','subscription_id=" . $sub['data']['id'] . "');\">Add credit card</a>)";

                            } else {
                                echo "Credit Card on File (<a href=\"null.php\" onclick=\"return popup('credit_card-view','id=" . $sub['data']['card_id'] . "');\">View</a>)";

                            }

                            ?></dd>

                    </dl>

                    <div class="clear"></div>


                </div>

            </fieldset>


        </div>
    </div>

    <div class="col50r">
        <div class="pad24_fs_r">


            <fieldset>

                <legend>Statistics</legend>

                <div class="pad24">


                    <dl>

                        <dt>Started</dt>
                        <dd><?php echo $sub['data']['started']; ?></dd>


                        <dt>Next Renews</dt>
                        <dd><?php echo $sub['data']['renews']; ?></dd>



                        <dt>Last Renewal</dt>
                        <dd><?php
                            if (! empty($sub['data']['last_renewed']) && $sub['data']['last_renewed'] != '1920-01-01 00:01:01') {
                                echo $sub['data']['last_renew_format'];
                            } else {
                                echo 'Has not renewed.';
                            }
                        ?></dd>


                        <?php
                        if (! empty($sub['data']['next_renew_keep']) && $sub['data']['next_renew_keep'] != '1920-01-01 00:01:01') {
                        ?>
                            <dt>Original Renewal Date</dt>
                            <dd><?php
                                echo $sub['data']['next_renew_keep_format'];
                                ?>
                            </dd>
                        <?php
                        }
                        ?>

                        <dt>Total Charges</dt>
                        <dd><?php echo $sub['data']['transactions']; ?></dd>

                    </dl>

                    <div class="clear"></div>


                </div>

            </fieldset>


        </div>
    </div>

    <div class="clear"></div>





<?php

}

?>