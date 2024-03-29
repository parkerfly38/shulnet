<?php 

/**
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
// Check permissions, ownership,
// and if it exists.
$ownership = new ownership($data['data']['owner'], $data['data']['public']);
if ($ownership->result != '1') {
    $admin->show_no_permissions($error, '', '1');

} else {
    $reminders = $event->get_reminders($_POST['id']);
    $cdate     = explode(' ', current_date());
    $total     = sizeof($reminders['reminders']) + sizeof($reminders['followups']);



    ?>





    <script type="text/javascript">

        $.ctrl('S', function () {
            return json_add('event_reminders-add', '<?php echo $_POST['id']; ?>', '1', 'popupform');
        });

    </script>



    <script src="js/form_rotator.js" type="text/javascript"></script>



    <form action="" method="post" id="popupform"
          onsubmit="return json_add('event_reminders-add','<?php echo $_POST['id']; ?>','1','popupform');">



        <div id="popupsave">

            <input type="submit" value="Save" class="save"/>

        </div>

        <h1>Reminder and Followup Messages</h1>


        <div class="popupbody">


            <ul id="theStepList">

                <li class="on" onclick="return goToStep('0');">Reminders</li>

                <li onclick="return goToStep('1');">Followups</li>

                <li onclick="return goToStep('2');">Create New</li>

            </ul>


            <input type="hidden" name="event_id" value="<?php echo $_POST['id']; ?>"/>


            <ul id="formlist">


                <?php



                $two = 2;

                while ($two > 0) {
                    if ($two == 2) {
                        $array = $reminders['reminders'];
                        $msg   = 'Reminders are sent before an event takes place.';

                    } else {
                        $array = $reminders['followups'];
                        $msg   = 'Followups are sent after an event has ended.';

                    }
                    echo "<li class=\"form_step\"><div class=\"pad24t\"><p class=\"highlight\">$msg</p>";
                    if (empty($array)) {
                        echo "<span class=weak>Nothing scheduled.</span>";

                    } else {
                        foreach ($array as $aRe) {
                            $bdate = explode(' ', $aRe['send_date']);
                            $sdate = explode(' ', $aRe['sent_on']);
                            if ($aRe['sent_on'] != '1920-01-01') {
                                $title = 'Sent on ' . format_date($sdate['0']);
                                $edit  = '0';

                            } else if ($aRe['send_date'] == $cdate['0']) {
                                $title = 'Scheduled to send today';
                                $edit  = '1';

                            } else {
                                $title = 'Scheduled to send on ' . format_date($bdate['0']);
                                $edit  = '1';

                            }
                            if ($edit == '1') {
                                ?>



                                <fieldset>

                                    <legend><?php echo $title; ?></legend>

                                    <div class="pad24t">


                                        <div class="field">

                                            <label>Type</label>

                                            <div class="field_entry">

                                                <input type="radio" name="existing[<?php echo $aRe['id']; ?>][sms]" value="0"
                                                       onclick="return show_div('<?php echo $aRe['id']; ?>-email_temp');" <?php if ($aRe['sms'] != '1') {
                                                    echo " checked=\"checked\"";
                                                } ?> /> E-Mail Message<br/>

                                                <input type="radio" name="existing[<?php echo $aRe['id']; ?>][sms]" value="1"
                                                       onclick="return hide_div('<?php echo $aRe['id']; ?>-email_temp');" <?php if ($aRe['sms'] == '1') {
                                                    echo " checked=\"checked\"";
                                                } ?>  /> SMS Message

                                            </div>

                                        </div>


                                        <div class="field" id="<?php echo $aRe['id']; ?>-email_temp"
                                             style="display:<?php if ($aRe['sms'] == '1') {
                                                 echo "none";
                                             } else {
                                                 echo "block";
                                             } ?>;">

                                            <label>Template</label>

                                            <div class="field_entry">

                                                <select name="existing[<?php echo $aRe['id']; ?>][template_id]" style="width:250px;">

                                                    <option value=""<?php if (empty($aRe['template_id'])) {
                                                        echo "selected=\"selected\"";
                                                    } ?>>Default Template
                                                    </option>

                                                    <?php





                                                    echo $admin->get_email_templates_type('template', $aRe['template_id'], '1');

                                                    ?>

                                                </select>

                                            </div>

                                        </div>


                                        <div class="field">

                                            <label>Scheduled Date</label>

                                            <div class="field_entry">

                                                <?php



                                                echo $af
                                                    ->setSpecialType('date')
                                                    ->setValue($bdate['0'])
                                                    ->string('existing[' . $aRe['id'] . '][send_date]');


                                                //echo $admin->datepicker('existing[' . $aRe['id'] . '][send_date]', $bdate['0'], '0');

                                                ?>

                                            </div>

                                        </div>


                                        <div class="field">

                                            <label class="top">Custom Message</label>

                                            <div class="clear"></div>

                                            <div class="field_entry_top">

                                <textarea name="existing[<?php echo $aRe['id'] . '][custom_message]'; ?>"
                                          id="custom_message-<?php echo $aRe['id']; ?>"
                                          style="width:100%;height:150px;"><?php echo $aRe['custom_message']; ?></textarea>

                                                <?php

                                                // custom_message

                                                echo $admin->richtext('848px', '400px', 'custom_message-' . $aRe['id']);

                                                ?>

                                            </div>

                                        </div>


                                        <div class="field">

                                            <label>Delete?</label>

                                            <div class="field_entry">

                                                <input type="checkbox" name="existing[<?php echo $aRe['id'] . '][delete]'; ?>"
                                                       value="1"/> Delete this message when I press "Save".

                                            </div>

                                        </div>


                                    </div>

                                </fieldset>



                            <?php

                            } else {
                                ?>



                                <fieldset>

                                    <legend><?php echo $title; ?></legend>

                                    <div class="pad24t">


                                        <div class="field">

                                            <label>Type</label>

                                            <div class="field_entry">

                                                <?php





                                                if ($aRe['sms'] == '1') {
                                                    echo "SMS Message";

                                                } else {
                                                    echo "E-Mail Message";

                                                }

                                                ?>

                                            </div>

                                        </div>


                                        <div class="field">

                                            <label class="top">Message</label>

                                            <div class="field_entry_top">

                                                <?php





                                                echo $aRe['custom_message'];

                                                ?>

                                            </div>

                                        </div>


                                    </div>

                                </fieldset>



                            <?php

                            }

                        }

                    }
                    echo "</div></li>";
                    $two--;

                }



                ?>



                <li class="form_step">

                    <div class="pad24t" id="event_reminder_new">


                        <fieldset>

                            <legend>Create New Message</legend>

                            <div class="pad24t">


                                <div class="field">

                                    <label>Type</label>

                                    <div class="field_entry">

                                        <input type="radio" name="new[sms]" value="0" onclick="return show_div('email_temp');"
                                               checked="checked"/> E-Mail Message<br/>

                                        <input type="radio" name="new[sms]" value="1" onclick="return hide_div('email_temp');"/> SMS
                                        Message

                                    </div>

                                </div>


                                <div class="field" id="email_temp">

                                    <label>Template</label>

                                    <div class="field_entry">

                                        <select name="new[template_id]" style="width:250px;">

                                            <option value="">Default Template</option>

                                            <?php





                                            echo $admin->get_email_templates_type('template', '', '1');

                                            ?>

                                        </select>

                                    </div>

                                </div>


                                <div class="field">

                                    <label>When?</label>

                                    <div class="field_entry">

                                        <select name="new[when]" style="width:200px;">

                                            <option value="before" selected="selected">Before the event (Reminder)</option>

                                            <option value="after">After the event (Followup)</option>

                                        </select>

                                    </div>

                                </div>


                                <div class="field">

                                    <label>Scheduled</label>

                                    <div class="field_entry">

                                        <?php





                                        echo $admin->timeframe_field('new[timeframe]', '', '0');

                                        ?>

                                    </div>

                                </div>


                                <div class="field">

                                    <label class="top">Custom Message</label>

                                    <div class="clear"></div>

                                    <div class="field_entry_top">

                        <textarea name="<?php echo 'new[custom_message]'; ?>" id="new123"
                                  style="width:848px;height:150px;"></textarea>

                                        <?php





                                        // custom_message

                                        echo $admin->richtext('848px', '400px', 'new123');

                                        ?>

                                    </div>

                                </div>


                            </div>

                        </fieldset>


                    </div>

                </li>

            </ul>


        </div>



<?php

}