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

$cid = generate_id($db->get_option('event_id_format'));

?>

<script src="<?php echo PP_ADMIN; ?>/js/form_builder.js" type="text/javascript" xmlns="http://www.w3.org/1999/html"></script>

<script src="<?php echo PP_ADMIN; ?>/js/form_steps.js" type="text/javascript"></script>

<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('event-add', '<?php echo $cid; ?>', '0', 'popupform');
    });

</script>

<script type="text/javascript">

    var current_ticket_up = 0;

    var current_timeline_up = 0;

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
      onsubmit="return json_add('event-add','<?php echo $cid; ?>','0','popupform');">


<div id="popupsave">

    <!--<input type="button" onclick="return prev();" value="&laquo; Previous" />

	<input type="button" onclick="return next();" value="Next &raquo;" />-->

    <input type="submit" value="Save" class="save"/>

</div>

<h1>Creating Event</h1>

<!--
<ul id="theStepList">
    <li class="on" onclick="return goToStep('0');">Overview</li>
    <li onclick="return goToStep('1');">Dates</li>
    <li onclick="return goToStep('2');">Location</li>
    <li onclick="return goToStep('3');">Attendance</li>
    <li onclick="return goToStep('4');">Timeline</li>
    <li onclick="return goToStep('5');">Forms</li>
    <li onclick="return goToStep('6');">Media</li>
</ul>
-->

<div class="popupbody fullForm">

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
            Timeline
        </li><li>
            Forms
        </li><li>
            Media
        </li>
    </ul>


    <div id="step_1" class="step_form fullForm">

        <p class="highlight">
            Input the basic details for this event.
        </p>

        <div class="col50l">

            <fieldset>

                <div class="pad">

                    <input type="hidden" name="event[id]" value="<?php echo $cid; ?>"/>

                    <div class="field">

                        <label>Status<span class="req_star">*</span></label>
                        <?php
                        echo $af->radio('event[status]', '1', array('1' => 'Live', '0' => 'Hidden'))
                        ?>

                    </div>

                    <div class="field">

                        <label>Name<span class="req_star">*</span></label>

                        <div class="field_entry">

                            <input type="text" name="event[name]" id="e001" maxlength="100" class="req" style="width:250px;"/>

                        </div>

                    </div>

                    <div class="field">

                        <label>Tagline</label>

                        <div class="field_entry">

                            <input type="text" name="event[tagline]" id="e002" maxlength="150" class="req" style="width:100%;"/>

                        </div>

                    </div>


                </div>

            </fieldset>

        </div>
        <div class="col50r">


            <fieldset>

                <div class="pad">


                    <div class="field">

                        <label>Calendar</label>

                        <div class="field_entry">

                            <select name="event[calendar_id]" id="calendar_id" style="width:250px;">

                                <?php





                                $event = new event;

                                echo $event->calendar_list();

                                ?>

                            </select>

                        </div>

                    </div>

                    <div class="field">

                        <label>Template</label>

                        <div class="field_entry">

                            <select name="event[custom_template]" id="template_id" style="width:250px;">

                                <?php





                                echo $db->custom_templates();

                                ?>

                            </select>

                        </div>

                    </div>

                    <div class="field">
                        <label>Tags</label>
                        <div class="field_entry">
                            <input type="text" name="tags" id="tags" style="width:250px;"
                                   autocomplete="off" onkeyup="return autocom(this.id,'name','name','ppSD_event_types','name','','1');" value=""/>
                        </div>
                    </div>
                </div>
            </fieldset>


        </div>

        <div class="clear"></div>

        <fieldset>
            <div class="padLeftRight">

            <div class="field">
                <label class="top">Describe this event to potential registrants</label>
                <div class="clear"></div>
                <div class="field_entry_top">
                                <textarea name="event[description]" class="richtext" id="event_rich"
                                          style="width:100%;height:200px;"></textarea>
                    <?php
                    // Not working for some reason...
                    echo $admin->richtext('100%', '250px', 'event_rich');
                    ?>
                </div>
            </div>

            <div class="field">
                <label class="top">After someone registers for the event, would you like to display a confirmation message?</label>
                <div class="clear"></div>
                <div class="field_entry_top">
                                <textarea name="event[post_rsvp_message]" class="richtext" id="confirm_rich"
                                          style="width:100%;height:100px;"></textarea>
                    <?php
                    // Not working for some reason...
                    echo $admin->richtext('100%', '150px', 'confirm_rich', '0', '1');
                    ?>

                </div>

                <p class="field_desc" id="master_user_dud_dets">Optional message that can be included on confirmation
                    templates.</p>
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

                    <label>Event Starts<span class="req_star">*</span></label>

                    <div class="field_entry">

                        <?php


                        echo $af
                            ->setSpecialType('datetime-local')
                            ->setId('event_starts')
                            ->string('event[starts]');

                        //echo $admin->datepicker('event[starts]', '', '1', '250', '1', '10', '1', 'event_starts');

                        // echo $admin->datepicker('event[starts]', '', '1', '250', '1', '10', '1', 'event_starts');

                        ?>

                    </div>

                </div>

            </div>
            <div class="col33c">

                <div class="field">

                    <label>Event Ends<span class="req_star">*</span></label>

                    <div class="field_entry">

                        <?php



                        echo $af
                            ->setSpecialType('datetime-local')
                            ->setId('event_ends')
                            ->string('event[ends]');


                        // echo $admin->datepicker('event[ends]', '', '1', '250', '1', '10', '1', 'event_ends');

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
                            ->setId('event_start_registrations')
                            ->string('event[start_registrations]');

                        //echo $admin->datepicker('event[start_registrations]', '', '1');

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


                        echo $af
                            ->setSpecialType('datetime-local')
                            ->setDescription('Optional: when to stop accepting registrations.
                            Defaults to the event\'s start date.')
                            ->setId('event_close_registration')
                            ->string('event[close_registration]');



                        //echo $admin->datepicker('event[close_registration]', '', '1');

                        ?>

                        <!--<p class="field_desc" id="master_user_dud_dets">Optional: when to stop accepting registrations.
                            Defaults to the event's start date.</p>-->

                    </div>

                </div>

            </div>
            <div class="col33r">

                <div class="field">

                    <label>End Early Bird Registration</label>

                    <div class="field_entry">

                        <?php

                        echo $af
                            ->setSpecialType('datetime-local')
                            ->setDescription('If you want to set up an "Early Bird" registration
                            period with reduced pricing, input when that registration period ends and when standard
                            registration begins.')
                            ->setId('event_early_bird_end')
                            ->string('event[early_bird_end]');


                        //echo $admin->datepicker('event[early_bird_end]', '', '1');

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

        <div class="col33l">

            <fieldset>

                <legend>Location Name</legend>

                <div class="pad24t">

                    <div class="field">

                        <label class="top">Is this an online event or an offline gathering?</label>

                        <div class="field_entry_top">

                            <input type="radio" name="event[online]" value="0" checked="checked"
                                   onclick="return swap_div('offline_div','online_div');"/> Offline<br/>

                            <input type="radio" name="event[online]" value="1"
                                   onclick="return swap_div('online_div','offline_div');"/> Online

                        </div>

                    </div>

                    <div class="field">

                        <label>Venue Name<span class="req_star">*</span></label>

                        <div class="field_entry">

                            <input type="text" name="event[location_name]" id="e003" style="width:250px;" class="req"/>

                        </div>

                    </div>

                </div>

            </fieldset>

            </div>

            <div class="col66r">

                <div id="online_div" style="display:none;">

                    <fieldset>

                        <legend>Website Details</legend>

                        <div class="pad24t">

                            <div class="field">

                                <label>Website URL</label>

                                <div class="field_entry">

                                    <input type="text" name="event[url]" style="width:250px;"/>

                                </div>

                            </div>

                    </fieldset>

                </div>

                <div id="offline_div">

                    <fieldset>

                        <legend>Location Details</legend>

                        <div class="pad24t">

                            <?php
                            //echo $af->addressForm('event', '', array('first_name', 'last_name'));
                            ?>

                            <div class="field">

                                <label>Address</label>

                                <div class="field_entry">

                                    <input type="text" name="event[address_line_1]" style="width:100%;"/>

                                </div>

                            </div>


                            <div class="field">

                                <label>&nbsp;</label>

                                <div class="field_entry">

                                    <input type="text" name="event[address_line_2]" style="width:100%;"/>

                                </div>

                            </div>


                            <div class="field">

                                <label>City</label>

                                <div class="field_entry">

                                    <input type="text" name="event[city]" style="width:250px;"/>

                                </div>

                            </div>


                            <div class="field">

                                <label>State</label>

                                <div class="field_entry">

                                    <?php





                                    $field = new field('event');

                                    $rendered = $field->render_field('state');

                                    echo $rendered['3'];

                                    ?>

                                </div>

                            </div>


                            <div class="field">

                                <label>Zip</label>

                                <div class="field_entry">

                                    <input type="text" name="event[zip]" style="width:100px;" maxlength="10"/>

                                </div>

                            </div>


                            <div class="field">

                                <label>Country</label>

                                <div class="field_entry">

                                    <?php





                                    $rendered = $field->render_field('country');

                                    echo $rendered['3'];

                                    ?>

                                </div>

                            </div>


                            <div class="field">

                                <label>Phone</label>

                                <div class="field_entry">

                                    <input type="text" name="event[phone]" style="width:150px;"/>

                                </div>

                            </div>


                        </div>

                    </fieldset>

                </div>
            </div>

    </div>

    <div id="step_4" class="step_form fullForm">

        <p class="highlight">
            Control who and how people can attend this event.
        </p>



    <div class="col33l">


    <fieldset>

        <legend>Attendance Limits and Accessibility</legend>

        <div class="pad24t">


            <div class="field">

                <label class="top">Limit Attendees?</label>

                <div class="field_entry_top">

                    <input type="radio" name="limit_attendees_dud" value="1"
                           onclick="return show_div('max_attendees');"/> Limit Attendees<br/><input type="radio"
                                                                                                    name="limit_attendees_dud"
                                                                                                    checked="checked"
                                                                                                    value="0"
                                                                                                    onclick="return hide_div('max_attendees');"/>
                    Do not limit attendees

                </div>

            </div>


            <div class="field" id="max_attendees" style="display:none;">

                <label>Attendance Limit</label>

                <div class="field_entry">

                    <input type="text" name="event[max_rsvps]" maxlength="6" style="width:150px;"/>

                </div>

            </div>


            <div class="field">

                <label class="top">Only allow members to view the event on the calendar?</label>

                <div class="field_entry_top">

                    <input type="radio" name="event[members_only_view]" value="1"/> Only members can view this event on
                    the calendar<br/><input type="radio" name="event[members_only_view]" value="0" checked="checked"/>
                    Anybody can view the event on the calendar

                </div>

            </div>


            <div class="field">

                <label class="top">Only allow members to register for the event online?</label>

                <div class="field_entry_top">

                    <input type="radio" name="event[members_only_rsvp]" value="1"/> Only members can register for this
                    event<br/><input type="radio" value="0" name="event[members_only_rsvp]" checked="checked"/> Anybody
                    can register for this event

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

                    <input type="radio" name="event[allow_guests]" value="1" checked="checked"
                           onclick="return show_div('max_guests');"/> Allow Guests <input type="radio"
                                                                                          name="event[allow_guests]"
                                                                                          value="0"
                                                                                          onclick="return hide_div('max_guests');"/>
                    Disallow Guests

                </div>

            </div>


            <div class="field" id="max_guests">

                <label>Max Per Attendee</label>

                <div class="field_entry">

                    <input type="text" name="event[max_guests]" maxlength="3" value="1" style="width:50px;"/>

                </div>

            </div>


        </div>

    </fieldset>

</div>
        <div class="col66r">

    <fieldset>

        <legend>Ticket Options</legend>

        <div class="pad24t">


            <table cellspacing="0" class="generic" cellpadding="0" border="0" id="ticket_options">
                <thead>
                <tr>

                    <th width="200">Name</th>

                    <th width="300">Description</th>

                    <th width="85">Price</th>

                    <th>Type</th>

                    <th width="16"></th>

                </tr>
                </thead>

                <tbody>


                </tbody>

            </table>


            <a class="submit" href="preventnull.php" onclick="return addticket();">Add a Ticket Option</a>


        </div>

    </fieldset>

        </div>
        <div class="clear"></div>
    </div>

    <div id="step_5" class="step_form fullForm">

        <p class="highlight">
            Control the timeline of events for this event.
        </p>

        <fieldset>
            <div class="pad24t">

                <script type="text/javascript">

                    $("#timeline_ul, #timeline_ul").sortable({

                        placeholder: "ui-state-highlight"

                    }); // .disableSelection();

                </script>

                <ul id="timeline_ul"></ul>

                <a class="submit" href="preventnull.php" onclick="return addtimeline();">Add a Timeline Entry</a>

            </div>
        </fieldset>

    </div>

    <div id="step_6" class="step_form fullForm">

        <p class="highlight">
            Control the forms that users will need to complete to register for the event.
        </p>


        <fieldset>
            <div class="pad24t">
    <?php





    $col1_name = 'Attendee Registration Form';

    $col2_name = 'Guest Registration Form';

    $multi_col = '1';

    include PP_ADMINPATH . "/cp-includes/create_form.php";

    ?>

            </div>
        </fieldset>

    </div>

    <div id="step_7" class="step_form fullForm">

        <p class="highlight">
            Control the media that will be displayed on the event's page.
        </p>


    <fieldset>

        <legend>Upload a Cover Photo</legend>

        <div class="pad24t field" id="event_cover_photo">

            <script type="text/javascript" src="js/jquery.fileuploader.js"></script>

            <script type="text/javascript">

                $(document).ready(function () {
                    var uploader = new qq.FileUploader({

                        element: document.getElementById('fileuploader'),
                        action: 'cp-functions/upload.php',
                        debug: true,
                        params: {

                            type: 'event',
                            id: '<?php echo $cid; ?>',
                            permission: 'event-upload-cover',
                            label: 'event-cover-photo',
                            scope: '0'

                        }

                    });
                });

            </script>

            <p>Drag and drop a cover photo here.<br/><br/>The program will attempt to auto-resize large images, but for
                best results, ideally, a cover photo should be at least 980 x 250 pixels in size.</p>

            <div id="fileuploader">

                <noscript><p>Please enable JavaScript to use file uploader.</p></noscript>

            </div>


        </div>

    </fieldset>


    <fieldset>

        <legend>Upload Additional Photos</legend>

        <div class="pad24t field" id="event_photos">

            <script type="text/javascript" src="js/jquery.fileuploader.js"></script>

            <script type="text/javascript">

                $(document).ready(function () {
                    var uploader = new qq.FileUploader({

                        element: document.getElementById('fileuploaderA'),
                        action: 'cp-functions/upload.php',
                        debug: true,
                        params: {

                            type: 'event',
                            id: '<?php echo $cid; ?>',
                            permission: 'event-upload',
                            label: 'event-photo',
                            scope: '0'

                        }

                    });
                });

            </script>

            <p>Drag and drop a additional event photos here.<br/><br/>There is no limit to how many additional photos
                you can add, however some themes may benefits from limiting the number to 3-5. Themes that support full
                photo albums for events will not have this problem.</p>

            <div id="fileuploaderA">

                <noscript><p>Please enable JavaScript to use file uploader.</p></noscript>

            </div>


        </div>

    </fieldset>

</div>


</div>


</form>