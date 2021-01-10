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
$permission = 'invoice';
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
    $invoice = new invoice;
    $data    = $invoice->get_invoice($_POST['id'], $recache);

?>



    <div id="slider_submit">
        <div class="pad24tb">


            <div id="topicons">

                <a href="<?php echo $data['data']['link'] . '&isp=' . substr(SALT1, 4, 10); ?>" target="_blank"><img src="imgs/icon-view.png" border="0"
                                                                                    title="View in Catalog"
                                                                                    alt="View in Catalog" class="icon"
                                                                                    width="16" height="16"/> View Online</a>

                <a href="null.php" onclick="return resend_invoice('<?php echo $data['data']['id']; ?>');"><img
                        src="imgs/icon-email.png" border="0" title="E-Mail Invoice" alt="E-Mail Invoice" class="icon"
                        width="16" height="16"/> E-Mail Invoice</a>

                <a href="<?php echo $data['data']['print_invoice']; ?>" target="_blank"><img src="imgs/icon-print.png"
                                                                                             border="0" title="Print"
                                                                                             alt="Print" class="icon"
                                                                                             width="16" height="16"/>
                    Print</a>

                <a href="null.php"
                   onclick="return delete_item('ppSD_invoices','<?php echo $data['data']['id']; ?>','','1');"><img
                        src="imgs/icon-delete-on.png" border="0" title="Delete" alt="Delete" class="icon" width="16"
                        height="16"/> Delete</a>

            </div>


            <ul id="slider_tabs">

                <li id="overview" class="on">Overview</li>

                <li id="invoice-edit:<?php echo $data['data']['id']; ?>" class="popup">Edit</li>

                <li id="items">Components</li>

                <li id="payments">Payments</li>

                <li id="notes">Notes<a class="topright_bubble" href="returnnull.php"
                                       onclick="return popup('note-add','user_id=<?php echo $data['data']['id']; ?>&scope=invoice','1');">+</a>
                </li>

            </ul>

            <div id="slider_left">

                <span class="title">No. <?php echo $data['data']['id']; ?></span>

            <span class="data"><?php



                echo 'Due on ' . $data['data']['format_due_date'] . ' (' . $data['data']['time_to_due_date'] . '). Status: <b>' . $data['data']['format_status'] . '</b>';

                if ($data['data']['status'] == '3' || $data['data']['status'] == '4') {
                    echo " (<a href=\"returnnull.php\" onclick=\"return command('invoice_dead','" . $data['data']['id'] . "','');\">Mark Dead</a>)";

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