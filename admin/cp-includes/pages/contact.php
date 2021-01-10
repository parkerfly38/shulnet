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
$show = '1';
$permission = 'contact';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $show  = '0';
    $error = 'permissions';

} else {
    // Check if refreshing the cache.
    include "check_cache.php";
    // Ownership
    $contact = new contact;
    $data    = $contact->get_contact($_POST['id'], $recache);

    if (! empty($data['data']['id']) && $data['data']['public'] != '1' && $data['data']['owner'] != $employee['id'] && $employee['permissions']['admin'] != '1') {
        $show  = '0';
        $error = 'permissions';
    }
    else if (empty($data['data']['id'])) {
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

                <?php

                $check_fav = $admin->check_favorite($employee['id'], 'contact', $data['data']['id']);

                if ($check_fav == '1') {
                    ?>

                    <a href="null.php"
                       onclick="return json_add('favorite_add','<?php echo $data['data']['id']; ?>','1','skip','mtype=contact&type=remove');"><img
                            src="imgs/icon-fav-on.png" id="favorite-button-<?php echo $data['data']['id']; ?>"
                            border="0" title="Remove from Favorites" alt="Remove from Favorites" class="icon" width="16"
                            height="16"/> Favorite</a>

                <?php

                } else {
                    ?>

                    <a href="null.php"
                       onclick="return json_add('favorite_add','<?php echo $data['data']['id']; ?>','1','skip','mtype=contact&type=add');"><img
                            src="imgs/icon-fav-off.png" id="favorite-button-<?php echo $data['data']['id']; ?>"
                            border="0" title="Add to Favorites" alt="Add to Favorites" class="icon" width="16"
                            height="16"/> Favorite</a>

                <?php

                }

                ?>

                <a href="index.php?l=transactions&filters[]=<?php echo $data['data']['id']; ?>||member_id||eq||ppSD_cart_sessions&filters[]=1||status||eq||ppSD_cart_sessions"><img
                        src="imgs/icon-sales.png" border="0" title="Sales" alt="Sales" class="icon" width="16"
                        height="16"/> Sales</a>

                <a href="index.php?l=invoices&filters[]=<?php echo $data['data']['id']; ?>||member_id||eq||ppSD_invoices"><img
                        src="imgs/icon-invoices.png" border="0" title="Invoices" alt="Invoices" class="icon" width="16"
                        height="16"/> Invoices</a> <a href="null.php" onclick="return popup('invoice-add','uid=<?php echo $_POST['id']; ?>&utype=contact', '1');"><img src="imgs/icon-quickadd-slider.png" alt="Create Invoice" title="Create Invoice" class="icon-right-slider" /></a>

                <a href="index.php?l=subscriptions&filters[]=<?php echo $data['data']['id']; ?>||member_id||eq||ppSD_subscriptions"><img
                        src="imgs/icon-subscriptions.png" border="0" title="Subscriptions" alt="Subscriptions"
                        class="icon" width="16" height="16"/> Subscriptions</a>

                <?php

                if ($data['data']['status'] == '3') {
                    ?>

                    <a href="returnnull.php"
                       onclick="return json_add('contact_status','<?php echo $data['data']['id']; ?>','1','skip','status=1');"><img
                            src="imgs/icon-mark-alive.png" border="0" title="Mark Alive" alt="Mark Alive" class="icon"
                            width="16" height="16"/> Re-Open</a>

                <?php

                } else {
                    ?>

                    <a href="returnnull.php"
                       onclick="return json_add('contact_status','<?php echo $data['data']['id']; ?>','1','skip','status=3');"><img
                            src="imgs/icon-mark-dead.png" border="0" title="Mark Dead" alt="Mark Dead" class="icon"
                            width="16" height="16"/> Mark Dead</a>

                <?php

                }

                if ($data['data']['converted'] == '1') {
                    ?>

                    <a href="returnnull.php"
                       onclick="return delete_item('ppSD_lead_conversion','<?php echo $data['data']['converted_id']; ?>');"><img
                            src="imgs/icon-mark_unconverted.png" border="0" title="Remove Conversion"
                            alt="Remove Conversion" class="icon" width="16" height="16"/> Unconvert</a>

                <?php

                } else {
                    ?>

                    <a href="returnnull.php"
                       onclick="return popup('contact-convert','id=<?php echo $data['data']['id']; ?>');"><img
                            src="imgs/icon-mark_converted.png" border="0" title="Mark Converted" alt="Mark Converted"
                            class="icon" width="16" height="16"/> Convert</a>

                <?php

                }

                $sms_plugin = $db->get_option('sms_plugin');
                $showSMS = false;
                if (! empty($sms_plugin)) {
                    if (!empty($data['data']['cell']) && $data['data']['sms_optout'] != '1') {
                        $showSMS = true;
                    }
                } else {
                    if (!empty($data['data']['cell']) && !empty($data['data']['cell_carrier']) && $data['data']['cell_carrier'] != 'SMS Unavailable' && $data['data']['sms_optout'] != '1') {
                        $showSMS = true;
                    }
                }
                if ($showSMS) {
                    echo "<a href=\"#\" onclick=\"return popup('send-sms','id=" . $data['data']['id'] . "&type=member');\"><img src=\"imgs/icon-text.png\" border=\"0\" title=\"SMS\" alt=\"SMS\" class=\"icon\" width=\"16\" height=\"16\" /> SMS</a>";
                }
                ?>


                <!--<a href="index.php?l=contact-print"><img src="imgs/icon-print.png" border="0" title="Print" alt="Print" class="icon" width="16" height="16" /> Print</a>-->

                <a href="returnnull.php"
                   onclick="return delete_item('ppSD_contacts','<?php echo $data['data']['id']; ?>','','1');"><img
                        src="imgs/icon-delete-on.png" border="0" title="Delete" alt="Delete" class="icon" width="16"
                        height="16"/> Delete</a>

            </div>


            <ul id="slider_tabs">

                <li id="overview" class="on">Overview</li>

                <li id="data">Data</li>

                <li id="history">History</li>

                <li id="notes">Notes<a class="topright_bubble" href="returnnull.php"
                                       onclick="return popup('note-add','user_id=<?php echo $data['data']['id']; ?>&scope=contact','1');">+</a>
                </li>

                <li id="outbox">Outbox</li>

                <li id="email">E-Mail</li>

                <li id="files">Files</li>

                <?php

                if (!empty($data['data']['twitter']) && $data['data']['twitter'] != 'http://') {
                    echo "<li id=\"social_media\"><img src=\"imgs/icon-twitter.png\" width=\"16\" height=\"16\" alt=\"Twitter Feed\" title=\"Twitter Feed\" border=0 style=\"margin-top:10px;\" /></li>";

                }

                if (!empty($data['data']['facebook']) && $data['data']['facebook'] != 'http://') {
                    echo "<li class=\"external\" id=\"external\" zenurl=\"" . $data['data']['facebook'] . "\"><img src=\"imgs/icon-facebook.png\" width=\"16\" height=\"16\" alt=\"Facebook Feed\" title=\"Facebook Feed\" border=0 style=\"margin-top:10px;\" /></li>";
                }

                ?>

            </ul>

            <div id="slider_left">

                <?php



                echo $data['profile_pic'];



                ?><span class="title"><?php echo $data['data']['last_name']; ?>
                    , <?php echo $data['data']['first_name']; ?></span><?php

                if ($data['data']['converted'] == '1') {
                    echo "<span class=\"data\"><img src=\"imgs/icon-save.png\" border=\"0\" title=\"Converted!\" alt=\"Converted!\" class=\"icon\" />Coverted on " . $data['conversion']['date_show'] . " (" . $data['conversion']['time_since'] . " ago) into member <a href=\"#\" onclick=\"return load_page('member','view','" . $data['conversion']['user_id'] . "');\">" . $data['conversion']['user']['data']['username'] . "</a></span>";

                } else {
                    echo "<span class=\"data\">";
                    if (strtotime(current_date()) >= strtotime($data['action']['next_date'])) {
                        echo "<img src=\"imgs/icon-attention-on.png\" border=\"0\" title=\"Action Required\" alt=\"Action Required!\" class=\"icon\" />Contact is overdue, last action was required on " . $data['action']['next_date'] . " (" . $data['action']['time_to_next'] . " ago)</span>";

                    } else {
                        echo "<img src=\"imgs/icon-attention-off.png\" border=\"0\" title=\"Not overdue\" alt=\"Not overdue\" class=\"icon\" />Next action required on " . $data['action']['next_date'] . " (" . $data['action']['time_to_next'] . ")</span>";

                    }

                }

                ?>

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