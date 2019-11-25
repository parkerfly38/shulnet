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
 * @author      Cove Brook Coders
 * @link        https://www.covebrookcode.com/
 * @copyright   (c) 2019 Cove Brook Coders
 * @license     http://www.gnu.org/licenses/gpl-3.0.en.html
 * @project     ShulNET Membership Software
 * 
 * 
 * extended with synagogue yarzheit data
 * @author      Brian Kresge
 * @link        https://www.covebrookcode.com
 */

$user = new user;
$subs = new subscription;
$inv = new invoice;
$notes = new notes;

$data = $user->get_user($_POST['id']);
$invoice_statuses = $user->invoice_statuses($_POST['id']);
$subscriptions = $subs->get_user_subscriptions($_POST['id']);
$invoices = $inv->get_user_invoices($_POST['id']);
$pinned_notes = $notes->get_pinned_notes($_POST['id']);

$accu_stats = $user->user_statistics($_POST['id']);

if ($data['data']['locked'] != '1920-01-01 00:01:01' && $data['data']['locked'] != '0000-00-00 00:00:00') {
    echo "<p id=\"lock_notice\" class=\"highlight\">This member's account is currently locked due to " . $data['data']['login_attempts'] . " failed login attempts from IP " . $data['data']['locked_ip'] . " <a href=\"null.php\" onclick=\"return json_add('unlock','" . $data['data']['id'] . "&ip=" . $data['data']['locked_ip'] . "','0','','skip');\">Click here</a> to unlock the member.</p>";
}

?>



<div class="col67">
    <div class="pad24_fs_l">

        <?php
        if (! empty($subscriptions)) {
        ?>
            <fieldset>

                <legend>Subscriptions</legend>

                <div class="pad24t">
                     <table class="generic tablesorter">
                         <thead>
                         <tr>
                             <th>Renews</th>
                             <th>Products</th>
                             <th>Status</th>
                             <th>Created</th>
                             <th>Last</th>
                             <th>Price</th>
                             <th>Trial?</th>
                         </tr>
                         </thead>
                         <tbody>
                         <?php
                         foreach ($subscriptions as $aSub) {
                             ?>
                             <tr>
                                 <td><a href="returnnull.php" onclick="return load_page('subscription','view','<?php echo $aSub['data']['id']; ?>');"><?php echo $aSub['data']['renews']; ?></a></td>
                                 <td><?php echo $aSub['product']['name']; ?></a></td>
                                 <td><?php echo $aSub['data']['show_status']; ?></td>
                                 <td><?php echo $aSub['data']['started']; ?></td>
                                 <td><?php echo $aSub['data']['last_renew_format']; ?></td>
                                 <td><?php echo $aSub['data']['format_next_price']; ?></td>
                                 <td><?php echo ($aSub['data']['in_trial'] == 1) ? 'Yes' : 'No'; ?></td>
                             </tr>
                         <?php
                         }
                         ?>
                         </tbody>
                     </table>

                </div>

            </fieldset>
        <?php
        }


        if (! empty($invoices)) {
            ?>
            <fieldset>

                <legend>Invoices</legend>

                <div class="pad24t">
                    <table class="generic tablesorter">
                        <thead>
                        <tr>
                            <th>Issued</th>
                            <th>Due</th>
                            <th>Reminder</th>
                            <th>Status</th>
                            <th>Balance</th>
                            <th>Paid</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $due = 0;
                        $paid = 0;
                        foreach ($invoices as $aInv) {
                            $due += $aInv['totals']['due'];
                            $paid += $aInv['totals']['paid'];
                        ?>
                            <tr>
                                <td><a href="returnnull.php" onclick="return load_page('invoice','view','<?php echo $aInv['data']['id']; ?>');"><?php echo $aInv['data']['format_date']; ?></a></td>
                                <td><?php echo $aInv['data']['format_due_date']; ?></td>
                                <td><?php echo $aInv['data']['format_last_reminder']; ?></td>
                                <td><?php echo $aInv['data']['format_status']; ?></td>
                                <td><?php echo $aInv['format_totals']['format_due']; ?></td>
                                <td><?php echo $aInv['format_totals']['format_paid']; ?></td>
                            </tr>
                        <?php
                        }
                        $total = $due + $paid;
                        ?>
                        <tr>
                            <td colspan="4"></td>
                            <td><?php echo place_currency($due); ?></td>
                            <td><?php echo place_currency($paid); ?></td>
                        </tr>
                        <tr>
                            <td colspan="5"></td>
                            <td><i><?php echo place_currency($total); ?></i></td>
                        </tr>
                        </tbody>
                    </table>

                </div>

            </fieldset>
            <?php
        }
        ?>


        <fieldset>

            <legend>Activity Logs</legend>

            <div class="pad24t">

                <ul class="history_list">

                    <?php
                    $history = new history('', '', '', '', '', '', '');

                    $q12 = $db->run_query("
                        SELECT *
                        FROM `ppSD_history`
                        WHERE `user_id`='" . $db->mysql_clean($data['data']['id']) . "'
                        ORDER BY `date` DESC
                        LIMIT 50
                    ");

                    while ($item = $q12->fetch()) {
                        echo $history->format_condensed($item);
                    }
                    ?>

                </ul>

            </div>

        </fieldset>


    </div>
</div>

<div class="col33">
    <div class="pad24_fs_r">

        <?php

        if (! empty($pinned_notes)) {

            echo '<div style="margin-bottom:24px;">';

            foreach ($pinned_notes as $item) {
                echo $admin->format_note($item);
            }

            echo '</div>';

        }

        ?>

        <fieldset>
            <legend>Status</legend>
            <div class="pad24t">
                <dl>
                    <dt>Status</dt>
                    <dd>
                        <?php
                        $sp = new special_fields('member');
                        $sp->update_row($data['data']);
                        echo $sp->process('status', $data['data']['status']);
                        ?>
                    </dd>
                    <dt>Type</dt>
                    <dd><?php echo $data['data']['mtype']; ?></dd>
                    <dt>Joined</dt>
                    <dd><?php echo $data['dates']['joined']; ?></dd>
                    <dt>Last Updated</dt>
                    <dd><?php echo $data['dates']['last_updated']; ?></dd>
                    <dt>Last Login</dt>
                    <dd><?php echo $data['dates']['last_login']; ?></dd>
                    <dt>Last Renewal</dt>
                    <dd><?php echo $data['dates']['last_renewal']; ?></dd>
                    <?php
                    if (! empty($data['conversion'])) {
                        echo "<dt>Converted</dt>";
                        echo "<dd><a href=\"null.php\" onclick=\"return popup('conversion','id=" . $data['conversion']['id'] . "','');\">" . format_date($data['conversion']['date']) . "</a></dd>";
                    }
                    ?>
                </dl>
                <div class="clear"></div>
            </div>

        </fieldset>


        <!--
        <fieldset>

            <legend>Graphical Overview</legend>

            <div class="pad24t">

                <form action="" id="graph_form" onsubmit="return regen_graph();" method="get">

                    <?php

                    //echo $admin->graph_form($gdata);

                    ?>

                    <div class="graph_area">

                        <div id="stats_graphA" class="graph_box" style="height:250px;"></div>

                    </div>

                </form>

            </div>

        </fieldset>
        -->

        <fieldset>
            <legend>Statistical Overview</legend>
            <div class="pad24t">
                <dl>
                    <dt>Transactions</dt>
                    <dd><?php echo $accu_stats['sales']; ?></dd>
                    <dt>Revenue</dt>
                    <dd><?php echo place_currency($accu_stats['revenue']); ?></dd>
                    <dt><a href="index.php?l=logins&filters[]=<?php echo $data['data']['id']; ?>||member_id||like||ppSD_logins">Logins</a></dt>
                    <dd><?php echo $accu_stats['logins']; ?></dd>
                    <dt>Event Reg.</dt>
                    <dd><?php echo $accu_stats['rsvps']; ?></dd>
                    <dt>E-Mails Read</dt>
                    <dd><?php echo $accu_stats['emails_read']; ?></dd>
                    <dt>Clickthroughs</dt>
                    <dd><?php echo $accu_stats['link_clicks']; ?></dd>
                    <dt>Unpaid Invoices</dt>
                    <dd><?php echo $invoice_statuses['unpaid']; ?></dd>
                    <dt>Overdue Invoices</dt>
                    <dd><?php echo $invoice_statuses['overdue']; ?></dd>
                    <dt>Dead Invoices</dt>
                    <dd><?php echo $invoice_statuses['dead']; ?></dd>
                </dl>
                <div class="clear"></div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Additional Options</legend>
            <div class="pad24t">

                <ul class="suboptions">

                    <li><a href="null.php" onclick="return popup('send_form','id=<?php echo $data['data']['id']; ?>');"><img
                                src="imgs/icon-lg-forms.png" border="0" title="Send Form" alt="Send Form" class="icon"
                                width="16" height="16"/> Request a Form</a></li>

                    <li><a href="cp-functions/silent_login.php?id=<?php echo $data['data']['id']; ?>"
                           target="_blank"><img src="imgs/icon-silent_login.png" border="0" title="Silent Login"
                                                alt="Silent Login" class="icon" width="16" height="16"/> Silent
                            Login</a></li>
                    <li><a href="null.php"
                           onclick="return json_add('reset_login_tracking','<?php echo $data['data']['id']; ?>','1','','skip');"><img
                                src="imgs/icon-resetpass.png" border="0" title="Reset Password" alt="Reset Password"
                                class="icon" width="16" height="16"/> Reset Login Tracking</a></li>

                    <li style="margin-top:8px;"><a href="null.php"
                                                   onclick="return json_add('reset_password','<?php echo $data['data']['id']; ?>&type=email','1','','skip');"><img
                                src="imgs/icon-resetpass.png" border="0" title="Reset Password" alt="Reset Password"
                                class="icon" width="16" height="16"/> Send Password Reset Request</a></li>
                    <li><a href="null.php"
                                                   onclick="return json_add('reset_password','<?php echo $data['data']['id']; ?>&type=force','1','','skip');"><img
                                src="imgs/icon-resetpass.png" border="0" title="Reset Password" alt="Reset Password"
                                class="icon" width="16" height="16"/> Reset Password Now</a></li>

                </ul>

            </div>

        </fieldset>

        <fieldset>
            <legend>Trackstat</legend>
            <div class="pad24t">
                <?php
                $tracking = $user->trackstat($data['data']['id']);
                ?>
                <dl>
                    <dt>Rating</dt>
                    <dd><?php echo $tracking['rating']; ?>%</dd>
                    <dt>Accuracy</dt>
                    <dd><?php echo $tracking['accuracy']; ?></dd>
                </dl>
                <div class="clear"></div>
            </div>
        </fieldset>

        <fieldset>

            <legend>Location</legend>

            <div class="pad24t">

                <?php



                echo generate_map($data['data'], '100%', '275');

                ?>

            </div>

        </fieldset>


    </div>
</div>

<div class="clear"></div>