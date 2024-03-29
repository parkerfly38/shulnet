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
$permission = 'subscription';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $show  = '0';
    $error = 'permissions';

} else {
    // Ownership
    $subscription = new subscription;
    $sub          = $subscription->get_subscription($_POST['id']);

    if (empty($sub['data']['id'])) {
        $show  = '0';
        $error = 'noexists';
    }

}
// Show?
if ($show != '1') {
    $admin->show_no_permissions($error, '', '1');

} else {
    ?>



    <div id="slider_submit">
        <div class="pad24tb">


            <div id="topicons">

                <a href="<?php echo $sub['data']['update_link']; ?>" target="_blank"><img src="imgs/icon-view.png"
                                                                                          border="0"
                                                                                          title="View in Catalog"
                                                                                          alt="View in Catalog"
                                                                                          class="icon" width="16"
                                                                                          height="16"/> View Online</a>

                <?php



                if ($sub['data']['status'] == '1') {
                    ?>

                    <a href="null.php" onclick="return command('cancel_sub','<?php echo $sub['data']['id']; ?>');"><img
                            src="imgs/icon-cancel.png" border="0" title="Delete" alt="Delete" class="icon" width="16"
                            height="16"/>Cancel</a>

                <?php

                } else {
                    ?>

                    <a href="null.php" onclick="return command('cancel_sub','<?php echo $sub['data']['id']; ?>');"><img
                            src="imgs/icon-cancel.png" border="0" title="Re-activate" alt="Re-activate" class="icon"
                            width="16" height="16"/>Re-activate</a>

                <?php

                }

                ?>

                <a href="null.php"
                   onclick="return delete_item('ppSD_subscriptions','<?php echo $sub['data']['id']; ?>','','1');"><img
                        src="imgs/icon-delete-on.png" border="0" title="Delete" alt="Delete" class="icon" width="16"
                        height="16"/> Delete</a>

            </div>


            <ul id="slider_tabs">

                <li id="overview" class="on">Overview</li>

                <li id="history">Transactions</li>

                <li id="subscription-edit:<?php echo $sub['data']['id']; ?>" class="popup">Edit</li>

                <?php

                if (!empty($sub['data']['card_id'])) {
                    echo "<li id=\"credit_card-view:" . $sub['data']['card_id'] . "\" class=\"popup\">Credit Card</li>";

                }

                ?>

            </ul>

            <div id="slider_left">

                <span class="title"><?php echo $sub['data']['id']; ?></span>

            <span class="data"><?php



                if ($sub['data']['status'] == '1') {
                    echo "For <a href=\"null.php\" onclick=\"return load_page('product','view','" . $sub['product']['id'] . "');\">" . $sub['product']['name'] . "</a> that next renews " . format_date($sub['data']['next_renew']);
                    if ($sub['data']['retry'] > 0) {
                        echo ". <img src=\"imgs/icon-warning.png\" width=\"16\" height=\"16\" border=\"0\" class=\"icon\" /> This subscription has failed to renew " . $sub['data']['retry'] . " time(s).";

                    }

                } else {
                    if (empty($sub['data']['cancel_reason'])) {
                        $sub['data']['cancel_reason'] = '<span class="weak">No reason.</span>';

                    }
                    echo "Canceled on " . format_date($sub['data']['cancel_date']) . ": " . $sub['data']['cancel_reason'];

                }

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