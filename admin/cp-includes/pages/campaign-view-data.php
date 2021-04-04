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


$campaign = new campaign($_POST['id']);

$data = $campaign->get_campaign();





?>



<?php

if ($data['total_messages'] <= 0 && $data['optin_type'] == 'criteria') {
    echo "<p class=\"highlight center\">There are no messages in this campaign. Click on \"Messages\" to add some.</p>";

}

?>



<div class="pad24">


<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('campaign-add', '<?php echo $data['id']; ?>', '1', 'slider_form');
    });

</script>


<form action="" method="post" id="slider_form"
      onsubmit="return json_add('campaign-add','<?php echo $data['id']; ?>','1','slider_form');">


<div class="col50l">

    <fieldset>

        <legend>Basic Details</legend>

        <div class="pad24t">


            <div class="field">

                <label>Campaign Title</label>

                <div class="field_entry">

                    <input type="text" id="name" value="<?php echo $data['name']; ?>" name="name" style="width:100%;"
                           class="filterinputtype"/>

                </div>

            </div>



            <?php



            if ($data['optin_type'] != 'criteria') {
                ?>

                <div class="field">

                    <label>Opt-in Type</label>

                    <div class="field_entry">

                        <select name="optin_type" style="width:200px;">

                            <option value="double_optin"<?php if ($data['optin_type'] == 'double') {
                                echo " selected=\"selected\"";
                            } ?>>Double Opt-In
                            </option>

                            <option value="single_optin"<?php if ($data['optin_type'] == 'single') {
                                echo " selected=\"selected\"";
                            } ?>>Single Opt-In
                            </option>

                        </select>

                    </div>

                </div>

            <?php

            }

            ?>


        </div>

    </fieldset>


    <fieldset>

        <legend>Settings</legend>

        <div class="pad24t">


            <div class="field">

                <label>Status</label>

                <div class="field_entry">

                    <input type="radio" name="status" value="1" <?php if ($data['status'] == '1') {
                        echo " checked=\"checked\"";
                    } ?> /> Active <input type="radio" name="status" value="0" <?php if ($data['status'] != '1') {
                        echo " checked=\"checked\"";
                    } ?> /> Inactive

                </div>

            </div>


            <div class="field">

                <label>Update Activity</label>

                <div class="field_entry">

                    <input type="radio" name="update_activity" value="1" <?php if ($data['update_activity'] == '1') {
                        echo " checked=\"checked\"";
                    } ?> /> Update Activity<br/>

                    <input type="radio" name="update_activity" value="0" <?php if ($data['update_activity'] != '1') {
                        echo " checked=\"checked\"";
                    } ?> /> Do Not Update Activity

                    <p class="field_desc">If set to "Update Activity", the contacts/members "last activity" date will be
                        updated with each message.</p>

                </div>

            </div>



            <?php



            if ($data['optin_type'] == 'criteria') {
                ?>

                <div class="field">

                    <label>Kill Condition</label>

                    <div class="field_entry">

                        <select name="kill_condition" style="width:100%;">

                            <option value="unsubscribe"<?php if ($data['kill_condition'] == 'unsubscribe') {
                                echo " selected=\"selected\"";
                            } ?>>Unsubscription
                            </option>

                            <option value="on_open"<?php if ($data['kill_condition'] == 'on_open') {
                                echo " selected=\"selected\"";
                            } ?>>Message Opened
                            </option>

                            <option value="purchase"<?php if ($data['kill_condition'] == 'purchase') {
                                echo " selected=\"selected\"";
                            } ?>>Purchase
                            </option>

                            <option value="register"<?php if ($data['kill_condition'] == 'register') {
                                echo " selected=\"selected\"";
                            } ?>>Member Registration
                            </option>

                            <option value="form_submit"<?php if ($data['kill_condition'] == 'form_submit') {
                                echo " selected=\"selected\"";
                            } ?>>Form Submission
                            </option>

                            <option value="rsvp"<?php if ($data['kill_condition'] == 'rsvp') {
                                echo " selected=\"selected\"";
                            } ?>>Event Registration
                            </option>

                        </select>

                    </div>

                </div>



            <?php

            }

            ?>


        </div>

    </fieldset>


</div>


<div class="col50r">
    <?php
    $quickstats = $campaign->get_stats($_POST['id']);
    ?>
    <fieldset>
        <legend>Statistics</legend>
        <div class="pad24t">
            <dl>
                <dt>Subscriptions</dt>
                <dd><?php echo $quickstats['campaign_subscriptions']; ?></dd>
                <dt>Unsubscriptions</dt>
                <dd><?php echo $quickstats['campaign_unsubscriptions']; ?> (<?php echo $quickstats['percent_unsub']; ?>)</dd>
                <dt>Bounced E-Mails</dt>
                <dd><?php echo $quickstats['bounced']; ?> (<?php echo $quickstats['percent_bounced']; ?>)</dd>
                <!--
                <dt>Effectiveness</dt>
                <dd><?php echo $quickstats['campaign_effectiveness']; ?></dd>
                -->
                <dt>E-Mails Sent</dt>
                <dd><?php echo $quickstats['emails_sent']; ?></dd>
                <dt>E-Mails Read</dt>
                <dd><?php echo $quickstats['emails_read']; ?> (<?php echo $quickstats['percent_read']; ?>)</dd>
                <dt>Links Clicked</dt>
                <dd><?php echo $quickstats['link_clicks']; ?> (<?php echo $quickstats['percent_clicked']; ?>)</dd>
            </dl>
            <div class="clear"></div>
        </div>
    </fieldset>


    <fieldset>

        <legend>Milestones</legend>

        <div class="pad24t">


            <dl>

                <dt>Milestones</dt>

                <dd><?php echo $quickstats['milestones']; ?> (<?php echo $quickstats['percent_milestone']; ?>)</dd>

                <dt>Milestone Value</dt>

                <dd><?php echo $quickstats['milestone_value']; ?></dd>

                <dt>Members</dt>

                <dd><?php echo $quickstats['milestone_members']; ?></dd>

                <dt>Event Reg.</dt>

                <dd><?php echo $quickstats['milestone_rsvp']; ?></dd>

                <dt>Contacts</dt>

                <dd><?php echo $quickstats['milestone_contact']; ?></dd>

                <dt>Purchases</dt>

                <dd><?php echo $quickstats['milestone_order']; ?></dd>

                <dt>Invoices</dt>

                <dd><?php echo $quickstats['milestone_invoice']; ?></dd>

            </dl>

            <div class="clear"></div>


        </div>

    </fieldset>


</div>

<div class="clear"></div>


<div id="submit">

    <input type="submit" value="Save" class="save"/>

</div>


</form>