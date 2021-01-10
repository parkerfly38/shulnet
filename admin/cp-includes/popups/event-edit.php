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


$event = new event;

$data = $event->get_event($_POST['id']);



?>



<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('event-add', '<?php echo $data['data']['id']; ?>', '1', 'popupform');
    });

</script>


<script src="<?php echo PP_ADMIN; ?>/js/form_builder.js" type="text/javascript"></script>

<script src="<?php echo PP_ADMIN; ?>/js/form_steps.js" type="text/javascript"></script>

<script type="text/javascript">

    var current_ticket_up = <?php echo count($data['products'])-1; ?>;
    var current_timeline_up =<?php echo count($data['timeline'])-1; ?>;
    function addticket() {
        current_ticket_up += 1;
        var row = '<tr id="ticket_opt-' + current_ticket_up + '">';
        row += '<td valign="top"><input type="text" name="ticket[' + current_ticket_up + '][name]" style="width:200px;margin-bottom:4px;" /></td>';
        row += '<td valign="top"><textarea name="ticket[' + current_ticket_up + '][description]" style="width:100%;height:45px;" id="prod_desc_' + current_ticket_up + '"></textarea></td>';
        row += '<td valign="top"><?php echo currency_symbol(''); ?><input type="text" name="ticket[' + current_ticket_up + '][price]" style="width:55px;" /></td>';
        row += '<td valign="top"><select name="ticket[' + current_ticket_up + '][type]" style="width:160px;"><option value="1">Standard Ticket</option><option value="2">Guest Ticket</option><option value="5">Standard Ticket (Member Pricing)</option><option value="4">Early Bird Ticket</option><option value="6">Early Bird Ticket (Member Pricing)</option><option value="3">Add On Product</option></select></td>';
        row += '<td valign="top"><img src="imgs/icon-delete.png" width="16" height="16" border="0" alt="Remove" title="Remove" class="hover" onclick="return delete_ticket(\'' + current_ticket_up + '\');" /></td>';
        row += '</tr>';
        $('#ticket_options tbody').append(row);
        return false;
    }
    function delete_ticket(id) {
        $('#ticket_opt-' + id).remove();
        return false;
    }
    function addtimeline() {
        current_timeline_up += 1;
        send_data = 'action=timeline_entry&number=' + current_timeline_up + '&starts=' + $('#event_starts').val() + '&ends=' + $('#event_ends').val();
        $.post('cp-functions/event_addition.php', send_data, function (repSo) {
            $('#timeline_ul').append(repSo);
        });
        return false;
    }


</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('event-add','<?php echo $data['data']['id']; ?>','1','popupform');">


<div id="popupsave">

    <!--<input type="button" onclick="return prev();" value="&laquo; Previous" />

<input type="button" onclick="return next();" value="Next &raquo;" />-->

    <input type="submit" value="Save" class="save"/>

</div>

<h1>Editing Event</h1>

<!--
<ul id="theStepList">

    <li class="on" onclick="return goToStep('0');">Overview</li>

    <li onclick="return goToStep('1');">Dates</li>

    <li onclick="return goToStep('2');">Location</li>

    <li onclick="return goToStep('3');">Attendance</li>

    <li onclick="return goToStep('4');">Forms</li>

    <li onclick="return goToStep('5');">Tickets</li>

</ul>
-->

    <ul id="step_tabs" class="popup_tabs">
        <li class="on">
            Overview
        </li><li>
            Dates
        </li><li>
            Location
        </li><li>
            Attendance
        </li><li>
            Forms
        </li><li>
            Tickets
        </li>
    </ul>


    <div class="pad24t popupbody">


        <div id="step_1" class="step_form fullForm">

            <p class="highlight">
                Input the basic details for this event.
            </p>


    <fieldset>

        <legend>Overview</legend>

        <div class="pad24t">


            <input type="hidden" name="event[id]" value="<?php echo $data['data']['id']; ?>"/>


            <div class="field">

                <label>Status<span class="req_star">*</span></label>

                <div class="field_entry">

                    <input type="radio" name="event[status]" value="1" <?php if ($data['data']['status'] == '1') {
                        echo "checked=\"checked\"";
                    } ?> /> Live <input type="radio" name="event[status]"
                                        value="0" <?php if ($data['data']['status'] == '0') {
                        echo "checked=\"checked\"";
                    } ?> /> Hidden <input type="radio" name="event[status]"
                                          value="0" <?php if ($data['data']['status'] == '2') {
                        echo "checked=\"checked\"";
                    } ?> /> Canceled

                </div>

            </div>

            <div class="field">

                <label>Name<span class="req_star">*</span></label>

                <div class="field_entry">

                    <input type="text" name="event[name]" id="e001" value="<?php echo $data['data']['name']; ?>"
                           maxlength="100" class="req" style="width:250px;"/>

                </div>

            </div>

            <div class="field">

                <label>Tagline</label>

                <div class="field_entry">

                    <input type="text" name="event[tagline]" id="e002" value="<?php echo $data['data']['tagline']; ?>"
                           maxlength="150" class="req" style="width:100%;"/>

                </div>

            </div>

            <div class="field">

                <label class="top">Description</label>

                <div class="clear"></div>

                <div class="field_entry_top">

                    <textarea name="event[description]" class="richtext" id="event_rich"
                              style="width:100%;height:150px;"><?php echo $data['data']['description']; ?></textarea>

                    <?php





                    // Not working for some reason...

                    echo $admin->richtext('100%', '250px', 'event_rich');

                    ?>

                </div>

            </div>


            <div class="field">

                <label class="top">Confirmation Message</label>

                <div class="clear"></div>

                <div class="field_entry_top">

                    <textarea name="event[post_rsvp_message]" class="richtext" id="confirm_rich"
                              style="width:100%;height:150px;"><?php echo $data['data']['post_rsvp_message']; ?></textarea>

                    <?php





                    // Not working for some reason...

                    echo $admin->richtext('100%', '150px', 'confirm_rich', '0', '1');

                    ?>

                </div>

                <p class="field_desc" id="master_user_dud_detss">Optional message that can be included on confirmation
                    templates.</p>

            </div>


        </div>

    </fieldset>


    <fieldset>

        <legend>Calendar &amp; Layout</legend>

        <div class="pad24t">


            <div class="field">

                <label>Calendar</label>

                <div class="field_entry">

                    <select name="event[calendar_id]" id="calendar_id" style="width:250px;">

                        <?php





                        $event = new event;

                        echo $event->calendar_list($data['data']['calendar_id']);

                        ?>

                    </select>

                </div>

            </div>

            <div class="field">

                <label>Template</label>

                <div class="field_entry">

                    <select name="event[custom_template]" id="template_id" style="width:250px;">

                        <?php





                        echo $db->custom_templates($data['data']['custom_template']);

                        ?>

                    </select>

                </div>

            </div>


        </div>

    </fieldset>


    <fieldset>

        <legend>Event Types (Classification)</legend>

        <div class="pad24t">


            <div class="field">

                <label>Tags</label>

                <div class="field_entry">

                    <input type="text" name="tags" id="tags" style="width:250px;"
                           autocomplete="off" onkeyup="return autocom(this.id,'name','name','ppSD_event_types','name','','1');" value=""/>

                    <?php
                    foreach ($data['tags'] as $aTag) {
                        $rand = rand(100, 999999999);
                        echo "
                                <span title=\"Click to Remove\" style=\"width:232px;\" class=\"atag\" id=\"" . $rand . "\" onclick=\"return closeDiv('" . $rand . "','','1')\">" . $aTag['name'] . "
                                <input type=\"hidden\" name=\"tags[]\" value=\"" . $aTag['name'] . "\"></span>
                                ";
                    }
                    ?>
                </div>

            </div>


        </div>

    </fieldset>


    </div>

    <div id="step_2" class="step_form fullForm">

        <p class="highlight">
            Control all dates related to this event.
        </p>



    <fieldset>

        <legend>Dates</legend>

        <div class="pad24t">

        <div class="col33l">

            <div class="field">
                <label>Starts<span class="req_star">*</span></label>
                <div class="field_entry">
                    <?php

                    echo $af
                        ->setSpecialType('datetime-local')
                        ->setValue($data['data']['starts'])
                        ->setId('event_starts')
                        ->string('event[starts]');

                    //echo $admin->datepicker('event[starts]', $data['data']['starts'], '1', '250', '1', '10', '1', 'event_starts');
                    ?>
                </div>
            </div>

        </div>
        <div class="col33r">

            <div class="field">
                <label>Ends<span class="req_star">*</span></label>
                <div class="field_entry">
                    <?php

                    echo $af
                        ->setSpecialType('datetime-local')
                        ->setValue($data['data']['ends'])
                        ->setId('event_ends')
                        ->string('event[ends]');

                    //echo $admin->datepicker('event[ends]', $data['data']['ends'], '1', '250', '1', '10', '1', 'event_ends');
                    ?>
                </div>
            </div>

        </div>
        <div class="clear"></div>

        <div class="col33l">
            <div class="field">
                <label>Start Registration</label>
                <div class="field_entry">
                    <?php

                    echo $af
                        ->setSpecialType('datetime-local')
                        ->setDescription('Optional: when to start accepting registrations. If
                        left blank, users will be able to register as soon as the event is live on the calendar.')
                        ->setValue($data['data']['start_registrations'])
                        ->setId('event_start_registrations')
                        ->string('event[start_registrations]');

                    //echo $admin->datepicker('event[start_registrations]', $data['data']['start_registrations'], '1');
                    ?>
                    <!--<p class="field_desc" id="master_user_dud_dets">Optional: when to start accepting registrations. If
                        left blank, users will be able to register as soon as the event is live on the calendar.</p>-->
                </div>
            </div>

        </div>
        <div class="col33c">

            <div class="field">
                <label>Close Registration</label>
                <div class="field_entry">
                    <?php
                    //echo $admin->datepicker('event[close_registration]', $data['data']['close_registration'], '1');

                    echo $af
                        ->setSpecialType('datetime-local')
                        ->setDescription('Optional: when to stop accepting registrations.
                        Defaults to the event\'s start date.')
                        ->setValue($data['data']['close_registration'])
                        ->setId('event_close_registration')
                        ->string('event[close_registration]');
                    ?>
                    <!--<p class="field_desc" id="master_user_dud_dets">Optional: when to stop accepting registrations.
                        Defaults to the event's start date.</p>-->
                </div>
            </div>

        </div>
        <div class="col33r">

            <div class="field">
                <label>End Early Bird</label>
                <div class="field_entry">
                    <?php

                    echo $af
                        ->setSpecialType('datetime-local')
                        ->setDescription('If you want to set up an "Early Bird" registration
                        period with reduced pricing, input when that registration period ends and when standard
                        registration begins.')
                        ->setValue($data['data']['early_bird_end'])
                        ->setId('event_early_bird_end')
                        ->string('event[early_bird_end]');

                    //echo $admin->datepicker('event[early_bird_end]', $data['data']['early_bird_end'], '1');
                    ?>
                    <!--<p class="field_desc" id="master_user_dud_dets">If you want to set up an "Early Bird" registration
                        period with reduced pricing, input when that registration period ends and when standard
                        registration begins.</p>-->
                </div>
            </div>

        </div>
        <div class="clear"></div>

        </div>
    </fieldset>

    </div>

        <div id="step_3" class="step_form fullForm">

            <p class="highlight">
                Where is this event taking place?
            </p>


<fieldset>

    <legend>Event Type</legend>

    <div class="pad24t">


        <div class="field">

            <label class="top">Is this an online event or an offline gathering?</label>

            <div class="field_entry_top">

                <input type="radio" name="event[online]" value="0" <?php if ($data['data']['online'] != '1') {
                    echo "checked=\"checked\"";
                } ?> onclick="return swap_div('offline_div','online_div');"/> Offline<br/>

                <input type="radio" name="event[online]" value="1" <?php if ($data['data']['online'] == '1') {
                    echo "checked=\"checked\"";
                } ?> onclick="return swap_div('online_div','offline_div');"/> Online

            </div>

        </div>


    </div>

</fieldset>


<fieldset>

    <legend>Location Name</legend>

    <div class="pad24t">

        <div class="field">

            <label>Name<span class="req_star">*</span></label>

            <div class="field_entry">

                <input type="text" name="event[location_name]" value="<?php echo $data['data']['location_name']; ?>"
                       id="e003" style="width:250px;" class="req"/>
            </div>
        </div>
    </div>
</fieldset>





<div id="online_div" style="display:<?php
if ($data['data']['online'] == '1') {
    echo "block";
} else {
    echo "none";
}
?>;">

    <fieldset>

        <legend>Website Details</legend>

        <div class="pad24t">

            <div class="field">

                <label>Website URL</label>

                <div class="field_entry">
                    <input type="text" name="event[url]" value="<?php echo htmlentities($data['data']['plain_url']); ?>"
                           style="width:100%;"/>

                </div>

            </div>

    </fieldset>

</div>


<div id="offline_div" style="display:<?php
if ($data['data']['online'] != '1') {
    echo "block";
} else {
    echo "none";
}
?>;">

    <fieldset>

        <legend>Location Details</legend>

        <div class="pad24t">


            <div class="field">

                <label>Address</label>

                <div class="field_entry">

                    <input type="text" name="event[address_line_1]"
                           value="<?php echo $data['data']['address_line_1']; ?>" style="width:100%;"/>

                </div>

            </div>


            <div class="field">

                <label>&nbsp;</label>

                <div class="field_entry">

                    <input type="text" name="event[address_line_2]"
                           value="<?php echo $data['data']['address_line_2']; ?>" style="width:100%;"/>

                </div>

            </div>


            <div class="field">

                <label>City</label>

                <div class="field_entry">

                    <input type="text" name="event[city]" value="<?php echo $data['data']['city']; ?>"
                           style="width:250px;"/>

                </div>

            </div>


            <div class="field">

                <label>State</label>

                <div class="field_entry">

                    <?php





                    $field = new field('event');

                    $rendered = $field->render_field('state', $data['data']['state']);

                    echo $rendered['3'];

                    ?>

                </div>

            </div>


            <div class="field">

                <label>Zip</label>

                <div class="field_entry">

                    <input type="text" name="event[zip]" style="width:100px;" maxlength="10"
                           value="<?php echo $data['data']['zip']; ?>"/>

                </div>

            </div>


            <div class="field">

                <label>Country</label>

                <div class="field_entry">

                    <?php





                    $rendered = $field->render_field('country', $data['data']['country']);

                    echo $rendered['3'];

                    ?>

                </div>

            </div>


            <div class="field">

                <label>Phone</label>

                <div class="field_entry">

                    <input type="text" name="event[phone]" style="width:150px;"
                           value="<?php echo $data['data']['phone']; ?>"/>

                </div>

            </div>


        </div>

    </fieldset>

</div>


        </div>

        <div id="step_4" class="step_form fullForm">

            <p class="highlight">
                Control who and how people can attend this event.
            </p>



    <fieldset>

        <legend>Attendance Limits and Accessibility</legend>

        <div class="pad24t">


            <div class="field">

                <label class="top">Limit Attendees?</label>

                <div class="field_entry_top">

                    <input type="radio" name="limit_attendees_dud" value="1"
                           onclick="return show_div('max_attendees');" <?php if ($data['data']['max_rsvps'] > 0) {
                        echo "checked=\"checked\"";
                    } ?> /> Limit Attendees<br/><input type="radio" name="limit_attendees_dud" value="0"
                                                       onclick="return hide_div('max_attendees');" <?php if ($data['data']['max_rsvps'] <= 0) {
                        echo "checked=\"checked\"";
                    } ?> /> Do not limit attendees

                </div>

            </div>


            <div class="field" id="max_attendees" style="display:<?php if ($data['data']['max_rsvps'] > 0) {
                echo "block";
            } else {
                echo "none";
            } ?>;">

                <label>Attendance Limit</label>

                <div class="field_entry">

                    <input type="text" name="event[max_rsvps]" value="<?php echo $data['data']['max_rsvps']; ?>"
                           maxlength="6" style="width:150px;"/>

                </div>

            </div>


            <div class="field">

                <label class="top">Only allow members to view the event on the calendar?</label>

                <div class="field_entry_top">

                    <input type="radio" name="event[members_only_view]"
                           value="1" <?php if ($data['data']['members_only_view'] == '1') {
                        echo "checked=\"checked\"";
                    } ?> /> Only members can view this event on the calendar<br/><input type="radio"
                                                                                        name="event[members_only_view]"
                                                                                        value="0" <?php if ($data['data']['members_only_view'] != '1') {
                        echo "checked=\"checked\"";
                    } ?> /> Anybody can view the event on the calendar

                </div>

            </div>


            <div class="field">

                <label class="top">Only allow members to register for the event online?</label>

                <div class="field_entry_top">

                    <input type="radio" name="event[members_only_rsvp]"
                           value="1" <?php if ($data['data']['members_only_rsvp'] == '1') {
                        echo "checked=\"checked\"";
                    } ?> /> Only members can register for this event<br/><input type="radio" value="0"
                                                                                name="event[members_only_rsvp]" <?php if ($data['data']['members_only_rsvp'] != '1') {
                        echo "checked=\"checked\"";
                    } ?> /> Anybody can register for this event

                </div>

            </div>


        </div>

    </fieldset>


    <fieldset>

        <legend>Guest Options</legend>

        <div class="pad24t">


            <div class="field">

                <label class="top">Allow attendees to bring guests?</label>

                <div class="field_entry_top">

                    <input type="radio" name="event[allow_guests]"
                           value="1" <?php if ($data['data']['allow_guests'] == '1') {
                        echo "checked=\"checked\"";
                    } ?> onclick="return show_div('max_guests');"/> Allow Guests <input type="radio"
                                                                                        name="event[allow_guests]"
                                                                                        value="0"
                                                                                        onclick="return hide_div('max_guests');" <?php if ($data['data']['allow_guests'] != '1') {
                        echo "checked=\"checked\"";
                    } ?> /> Disallow Guests

                </div>

            </div>


            <div class="field" id="max_guests">

                <label>Max Per Attendee</label>

                <div class="field_entry">

                    <input type="text" name="event[max_guests]" maxlength="3"
                           value="<?php echo $data['data']['max_guests']; ?>" style="width:50px;"/>

                </div>

            </div>


        </div>

    </fieldset>


        </div>

        <div id="step_5" class="step_form fullForm">

            <p class="highlight">
                Control the forms that users will need to complete to register for the event.
            </p>

            <fieldset>
                <div class="pad24t">


    <?php





    $col1_name = 'Attendee Registration Form';

    $col2_name = 'Guest Registration Form';

    $multi_col = '1';

    $col1_load = 'event-' . $_POST['id'] . '-2';

    $col2_load = 'event-' . $_POST['id'] . '-4';

    include PP_ADMINPATH . "/cp-includes/create_form.php";

    ?>

                </div>
                </fieldset>

        </div>

        <div id="step_6" class="step_form fullForm">

            <p class="highlight">
                Control how people can pay for access to this event.
            </p>


    <fieldset>

        <div class="pad24t">


            <table cellspacing="0" class="generic" cellpadding="0" border="0" id="ticket_options">
                <thead>
                <tr>

                    <th width="200">Name</th>

                    <th width="300">Description</th>

                    <th width="85">Price</th>

                    <th>Type</th>

                    <th width="16">Del</th>

                </tr>
                </thead>

                <tbody>

                <?php


                $up = 0;

                foreach ($data['products']['tickets'] as $item) {
                    $up++;
                    echo '<tr id="ticket_opt-' . $up . '">';
                    echo '<td valign="top"><input type="hidden" name="ticket[' . $up . '][current]" value="1" /><input type="hidden" name="ticket[' . $up . '][id]" value="' . $item['data']['id'] . '" /><input type="hidden" name="ticket[' . $up . '][type]" value="1" /><input type="text" name="ticket[' . $up . '][name]" style="width:200px;margin-bottom:4px;" value="' . $item['data']['name'] . '" /></td>';
                    echo '<td valign="top"><textarea name="ticket[' . $up . '][description]" style="width:100%;height:45px;" id="prod_desc_' . $up . '">' . $item['data']['description'] . '</textarea></td>';
                    echo '<td valign="top">' . currency_symbol('<input type="text" name="ticket[' . $up . '][price]" style="width:75px;" value="' . $item['data']['price'] . '" />', '0') . '</td>';
                    echo '<td valign="top">Ticket</td>';
                    echo '<td valign="top"><input type="checkbox" name="ticket[' . $up . '][del]" value="1" /></td>';
                    echo '</tr>';

                }

                foreach ($data['products']['member_only'] as $item) {
                    $up++;
                    echo '<tr id="ticket_opt-' . $up . '">';
                    echo '<td valign="top"><input type="hidden" name="ticket[' . $up . '][current]" value="1" /><input type="hidden" name="ticket[' . $up . '][id]" value="' . $item['data']['id'] . '" /><input type="hidden" name="ticket[' . $up . '][type]" value="5" /><input type="text" name="ticket[' . $up . '][name]" style="width:200px;margin-bottom:4px;" value="' . $item['data']['name'] . '" /></td>';
                    echo '<td valign="top"><textarea name="ticket[' . $up . '][description]" style="width:100%;height:45px;" id="prod_desc_' . $up . '">' . $item['data']['description'] . '</textarea></td>';
                    echo '<td valign="top">' . currency_symbol('<input type="text" name="ticket[' . $up . '][price]" style="width:75px;" value="' . $item['data']['price'] . '" />', '0') . '</td>';
                    echo '<td valign="top">Member Ticket</td>';
                    echo '<td valign="top"><input type="checkbox" name="ticket[' . $up . '][del]" value="1" /></td>';
                    echo '</tr>';

                }

                foreach ($data['products']['guests'] as $item) {
                    $up++;
                    echo '<tr id="ticket_opt-' . $up . '">';
                    echo '<td valign="top"><input type="hidden" name="ticket[' . $up . '][current]" value="1" /><input type="hidden" name="ticket[' . $up . '][id]" value="' . $item['data']['id'] . '" /><input type="hidden" name="ticket[' . $up . '][type]" value="2" /><input type="text" name="ticket[' . $up . '][name]" style="width:200px;margin-bottom:4px;" value="' . $item['data']['name'] . '" /></td>';
                    echo '<td valign="top"><textarea name="ticket[' . $up . '][description]" style="width:100%;height:45px;" id="prod_desc_' . $up . '">' . $item['data']['description'] . '</textarea></td>';
                    echo '<td valign="top">' . currency_symbol('<input type="text" name="ticket[' . $up . '][price]" style="width:75px;" value="' . $item['data']['price'] . '" />', '0') . '</td>';
                    echo '<td valign="top">Guest Ticket</td>';
                    echo '<td valign="top"><input type="checkbox" name="ticket[' . $up . '][del]" value="1" /></td>';
                    echo '</tr>';

                }

                foreach ($data['products']['early_bird'] as $item) {
                    $up++;
                    echo '<tr id="ticket_opt-' . $up . '">';
                    echo '<td valign="top"><input type="hidden" name="ticket[' . $up . '][current]" value="1" /><input type="hidden" name="ticket[' . $up . '][id]" value="' . $item['data']['id'] . '" /><input type="hidden" name="ticket[' . $up . '][type]" value="4" /><input type="text" name="ticket[' . $up . '][name]" style="width:200px;margin-bottom:4px;" value="' . $item['data']['name'] . '" /></td>';
                    echo '<td valign="top"><textarea name="ticket[' . $up . '][description]" style="width:100%;height:45px;" id="prod_desc_' . $up . '">' . $item['data']['description'] . '</textarea></td>';
                    echo '<td valign="top">' . currency_symbol('<input type="text" name="ticket[' . $up . '][price]" style="width:75px;" value="' . $item['data']['price'] . '" />', '0') . '</td>';
                    echo '<td valign="top">Early Bird</td>';
                    echo '<td valign="top"><input type="checkbox" name="ticket[' . $up . '][del]" value="1" /></td>';
                    echo '</tr>';

                }

                foreach ($data['products']['other'] as $item) {
                    $up++;
                    echo '<tr id="ticket_opt-' . $up . '">';
                    echo '<td valign="top"><input type="hidden" name="ticket[' . $up . '][current]" value="1" /><input type="hidden" name="ticket[' . $up . '][id]" value="' . $item['data']['id'] . '" /><input type="hidden" name="ticket[' . $up . '][type]" value="3" /><input type="text" name="ticket[' . $up . '][name]" style="width:200px;margin-bottom:4px;" value="' . $item['data']['name'] . '" /></td>';
                    echo '<td valign="top"><textarea name="ticket[' . $up . '][description]" style="width:100%;height:45px;" id="prod_desc_' . $up . '">' . $item['data']['description'] . '</textarea></td>';
                    echo '<td valign="top">' . currency_symbol('<input type="text" name="ticket[' . $up . '][price]" style="width:75px;" value="' . $item['data']['price'] . '" />', '0') . '</td>';
                    echo '<td valign="top">Add-on</td>';
                    echo '<td valign="top"><input type="checkbox" name="ticket[' . $up . '][del]" value="1" /></td>';
                    echo '</tr>';

                }

                ?>

                </tbody>

            </table>


            <a class="submit" href="preventnull.php" onclick="return addticket();">Add a Ticket Option</a>


        </div>

    </fieldset>


        </div>



</form>


</div>