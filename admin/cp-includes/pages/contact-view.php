<?php

$contact = new contact;

$data = $contact->get_contact($_POST['id']);

$subs = new subscription;
$subscriptions = $subs->get_user_subscriptions($_POST['id']);

$inv = new invoice;
$invoices = $inv->get_user_invoices($_POST['id']);

$notes = new notes;
$pinned_notes = $notes->get_pinned_notes($_POST['id']);

$field = new field;

$final_form_col1 = $field->generate_form('contact-edit', $data['data'], '1');

$final_form_col2 = $field->generate_form('contact-edit', $data['data'], '2');

?>



<?php

if ($data['data']['status'] == '2') {
    echo "<p class=\"highlight center\">This contact is marked as \"Converted\". <a href=\"null.php\" onclick=\"return popup('conversion','id=" . $data['data']['converted_id'] . "','');\">Click here</a> for information on the conversion.</p>";

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
            <legend>Quick Contact Information</legend>
            <div class="pad24t">
                <dl>
                    <dt>E-Mail</dt>
                    <dd><a href="null.php"
                           onclick="return get_slider_subpage('email');"><?php echo $data['data']['email']; ?></a>
                    </dd>
                    <dt>Phone</dt>
                    <dd><?php echo $data['data']['phone']; ?></dd>
                </dl>
                <div class="clear"></div>
            </div>
        </fieldset>

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
                        LIMIT 25
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

        if (!empty($pinned_notes)) {

            echo '<div style="margin-bottom:24px;">';

            foreach ($pinned_notes as $item) {
                echo $admin->format_note($item);
            }

            echo '</div>';

        }

        ?>
        <fieldset>

            <legend>Key Dates</legend>

            <div class="pad24t">

                <dl>
                    <dt>Created</dt>
                    <dd><?php echo $data['dates']['created']; ?></dd>
                    <dt>Next Action</dt>
                    <dd><?php echo $data['dates']['next_action']; ?><a href="null.php"
                                                                       onclick="return json_add('extend_next_action','<?php echo $data['data']['id']; ?>','1','skip','type=contact');"><img src="imgs/icon-delay-solid-on.png" width="16" height="16" border="0" class="iconR" alt="Extend Next Action" title="Extend Next Action"></a></dd>
                    <dt>Time Until</dt>
                    <dd><?php echo $data['dates']['time_until']; ?></dd>
                    <dt>Last Action</dt>
                    <dd><?php echo $data['dates']['last_action']; ?></dd>
                    <dt>Time Since</dt>
                    <dd><?php echo $data['dates']['time_since']; ?></dd>
                    <dt>Options</dt>
                    <dd><a href="null.php"
                           onclick="return popup('contact-merge','id=<?php echo $data['data']['id']; ?>');">Merge Contacts</a></dd>
                </dl>

                <div class="clear"></div>

            </div>

        </fieldset>


        <fieldset>

            <legend>Status</legend>

            <div class="pad24t">

                <dl>

                    <dt>ID</dt>

                    <dd>
                        <?php echo $data['data']['id']; ?>
                    </dd>

                    <dt>Status</dt>

                    <dd>

                        <?php

                        $sp = new special_fields('contact');

                        $sp->update_row($data['data']);

                        echo $sp->process('status', $data['data']['status']);

                        ?>

                    </dd>

                    <dt>Type</dt>

                    <dd>

                        <?php

                        echo $data['data']['type'];

                        ?>

                    </dd>

                    <dt>Assigned To</dt>

                    <dd><?php

                        if (!empty($data['owner']['username'])) {
                            echo $data['owner']['username'];

                        } else {
                            echo "<span class=\"weak\">N/A</span>";

                        }

                        ?></dd>

                    <dt>Account</dt>

                    <dd><a href="null.php"
                           onclick="return load_page('account','view','<?php echo $data['data']['account']; ?>');"><?php echo $data['account']['name']; ?></a>
                    </dd>

                    <dt>Source</dt>

                    <dd>
                        <a href="index.php?l=contacts&filters[]=<?php echo $data['source']['id']; ?>||source||eq||ppSD_contacts"><?php echo $data['source']['source']; ?></a>
                    </dd>

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

