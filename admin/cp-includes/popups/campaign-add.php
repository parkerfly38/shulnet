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


if (!empty($_POST['criteria_id'])) {
    $cid     = generate_id('random', '11');
    $editing = '0';
    // Get Criteria
    $criteria = new criteria($_POST['criteria_id']);

} else {
    $admin->show_popup_error('You must build criteria for this campaign.');
    exit;

}

?>


<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('campaign-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('campaign-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">


<div id="popupsave">

    <input type="submit" value="Save" class="save"/>

    <input type="hidden" name="optin_type" value="criteria"/>

</div>

<h1>Campaign Creator</h1>

<div id="pop_inner" class="fullForm popupbody">

<p class="highlight smaller">Now that we have established the criteria that will be used to determine who will receive
    the campaign's messages, we can set up the campaign. In the next step you'll be able to create the messages that
    belong to this campaign.</p>


    <div class="col33l">

        <fieldset>
            <div class="pad">

            <label>Campaign Name</label>
            <?php
            echo $af->string('name', '', 'req');
            ?>


            <label>Campaign Type</label>
            <?php
            echo $af->radio('type', 'email', array(
                'email' => 'E-Mail Campaign',
            ));
            ?>


                <dl class="horizontal">
                    <dt>Criteria Being Used</dt>
                    <dd><?php echo $criteria->{'data'}['name']; ?></dd>

                    <input type="hidden" name="criteria_id"
                           value="<?php echo $criteria->{'data'}['id']; ?>"/>

                    <dt>This Campaign Targets</dt>
                    <dd><input type="hidden" name="user_type" value="<?php echo $criteria->{'data'}['type']; ?>"/> <?php
                        if ($criteria->{'data'}['type'] == 'member') {
                            echo "Members";
                        } else if ($criteria->{'data'}['type'] == 'contact') {
                            echo "Contacts";
                        } else if ($criteria->{'data'}['type'] == 'rsvp') {
                            echo "Event Registrations";
                        } else {
                            echo "Accounts";
                        }
                        ?></dd>
                </dl>

            </div>
        </fieldset>

        </div>
    <div class="col66r">

        <fieldset>
            <div class="pad">


        <label>Would you like to take the campaign live now or later?</label>
        <?php
        echo $af->radio('status', '1', array(
            '1' => 'Now: we\'re doing it live!',
            '0' => 'Later: I\'ll activate it later.',
        ));
        ?>

        <label>Should we update a user's activity when a message is sent to them?</label>
        <?php
        echo $af->radio('update_activity', '1', array(
            '1' => 'Yes, update the last activity date',
            '0' => 'No, do not update the last activity date'
        ));
        ?>

        <label>What kill condition when met should stop the user from receiving further messages?</label>
        <?php
        echo $af->select('kill_condition', 'unsubscribe', array(
            'unsubscribe' => 'When the user manually unsubscribes',
            'on_open' => 'Wehn a message is opened',
            'purchase' => 'When a purchase is made after clicking a link in a message',
            'register' => 'When a user registers after clicking a link in a message',
            'form_submit' => 'When a user submits a form after clicking a link in a message',
            'rsvp' => 'When a user registers for an event after clicking a link in a message',
        ))
        ?>

                <label>What should be the basis of messages sent in this campaign?</label>
                <?php
                echo $af->select('when_type', 'after_join', array(
                    'after_join' => 'Messages will be sent at fixed intervals after a user is created',
                    'exact_date' => 'Messages will be sent on exact dates.',
                ));
                ?>

            </div>
        </fieldset>

    </div>
    <div class="clear"></div>


</div>

</form>