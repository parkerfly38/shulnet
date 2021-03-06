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


$fcallers = $db->standard_callers();


$campaign = new campaign($_POST['campaign_id']);

$data = $campaign->get_campaign();


if (!empty($_POST['id'])) {
    $msg             = $campaign->get_msg($_POST['id']);
    $cid             = $_POST['id'];
    $title           = 'Editing Campaign Message';
    $editing         = '1';
    $name            = $msg['data']['title'];
    $bcc             = $msg['message']['bcc'];
    $cc              = $msg['message']['cc'];
    $from            = $msg['message']['from'];
    $update_activity = $msg['message']['update_activity'];
    $final_content   = $msg['message']['message'];
    $subject         = $msg['message']['subject'];
    $save            = $msg['message']['save'];
    $track           = $msg['message']['trackback'];
    $track_links     = $msg['message']['track_links'];
    $time_date       = $msg['data']['when_date'];
    $timeframe       = $msg['data']['when_timeframe'];

} else {
    $cid             = 'new';
    $title           = 'Creating Campaign Message';
    $editing         = '0';
    $name            = '';
    $bcc             = '';
    $cc              = '';
    $from            = '';
    $update_activity = '1';
    $final_content   = $admin->get_default_template('1');
    $subject         = '';
    $save            = '0';
    $track           = '1';
    $track_links     = '1';
    $time_date       = '';
    $timeframe       = '';

}
?>



<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('campaign_email-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('campaign_email-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">

<div id="popupsave">
    <input type="button" value="Preview" onclick="return preview_template('<?php echo $cid; ?>','email');"/>
    <input type="submit" value="Save" class="save"/>
    <input type="hidden" name="id" value="<?php echo $cid; ?>"/>
</div>


<h1><?php echo $title; ?></h1>

<input type="hidden" name="campaign_id" value="<?php echo $_POST['campaign_id']; ?>"/>

<div class="popupbody">

    <script src="<?php echo PP_ADMIN; ?>/js/form_steps.js" type="text/javascript"></script>
    <ul id="step_tabs" class="popup_tabs">
        <li class="on">
            Message Settings
        </li><li>
            Message Contents
        </li>
    </ul>

    <div id="step_1" class="step_form fullForm">

        <p class="highlight">Use this step to create the basic settings that will dictate how this message will work.</p>

        <div class="col50l">
            <fieldset>
                <div class="pad">

                    <label>Reference Title</label>
                    <?php
                    echo $af
                        ->setDescription('Create a reference name for the message to help you quickly remember what it is.')
                        ->string('name', $name, 'req');


                    if ($data['when_type'] == 'after_join') {
                        ?>

                        <label class="">How long after the user was created should he/she receive this message?</label>
                        <?php
                        echo $af->timeframe('when_timeframe', $timeframe, 1, 0);
                        ?>

                    <?php
                    } else {
                        ?>

                        <label class="">On what date should this user receive this message?</label>
                        <?php
                        echo $af
                            ->setSpecialType('date')
                            ->string('when_date', $time_date);
                        ?>


                    <?php
                    }
                    ?>
                </div>
            </fieldset>
        </div>

        <div class="col50l">
            <fieldset>
                <div class="pad">

                    <label class="">Would you like to track readership?</label>
                    <?php
                    echo $af->radio('track', $track, array(
                        '1' => 'Yes',
                        '0' => 'No',
                    ));
                    ?>

                    <label class="">Would you like to track link clicks?</label>
                    <?php
                    echo $af->radio('track_links', $track_links, array(
                        '1' => 'Yes',
                        '0' => 'No',
                    ));
                    ?>

                    <label class="">Would you like to save a copy of all outgoing emails?</label>
                    <?php
                    echo $af->radio('save', $save, array(
                        '1' => 'Yes',
                        '0' => 'No',
                    ));
                    ?>

                    <label class="">Would you like to update a user's last activity date when a message is sent?</label>
                    <?php
                    echo $af->radio('update_activity', $update_activity, array(
                        '1' => 'Yes',
                        '0' => 'No',
                    ));
                    ?>

                </div>
            </fieldset>
        </div>
        <div class="clear"></div>


    </div>
    <div id="step_2" class="step_form fullForm">

        <p class="highlight">Use this step to create the actual message that users will receive.</p>

        <div class="col33l">
            <fieldset>
                <div class="pad">
                    <label class="">Would you like to use a custom template?</label>
                    <?php
                    $options = $admin->get_email_templates_type('template', '', '1', 'array');

                    echo $af
                        ->setDescription('')
                        ->select('template_id', '', $options);
                    ?>

                    <script type="text/javascript">
                        $(function() {
                            $("select[name='template']").change(function() {
                                return populate_template(this.value, true);
                            });
                        });
                    </script>

                    <label class="">From</label>
                    <?php
                    echo $af
                        ->setId('email_from')
                        ->setDescription('Leave blank for the default "From" address.')
                        ->string('from', $from);
                    ?>

                    <label class="">CC</label>
                    <?php
                    echo $af
                        ->setId('email_cc')
                        ->setDescription('')
                        ->string('cc', $cc);
                    ?>

                    <label class="">Bcc</label>
                    <?php
                    echo $af
                        ->setId('email_bcc')
                        ->setDescription('')
                        ->string('bcc', $bcc);
                    ?>
                </div>
            </fieldset>
        </div>

        <div class="col66r">
            <fieldset>
                <div class="pad">
                    <label class="">Subject</label>
                    <?php
                    echo $af
                        ->setId('email_subject')
                        ->setDescription('')
                        ->string('subject', $subject);
                    ?>

                    <label class="">Message</label>
                    <?php
                    echo $af
                        ->setId('email_message')
                        ->setDescription('')
                        ->richtext('template', $final_content, '500');
                    ?>
                </div>
            </fieldset>
        </div>
        <div class="clear"></div>

    </div>

</div>


</form>


<script type="text/javascript">

    function add_caller() {
        value = $('#caller_tags').val();
        insertAtCaret('template_content', value);
        return false;
    }

    function insertAtCaret(areaId, text) {
        var txtarea = document.getElementById(areaId);
        var scrollPos = txtarea.scrollTop;
        var strPos = 0;
        var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
            "ff" : (document.selection ? "ie" : false ) );
        if (br == "ie") {
            txtarea.focus();
            var range = document.selection.createRange();
            range.moveStart('character', -txtarea.value.length);
            strPos = range.text.length;
        }
        else if (br == "ff") strPos = txtarea.selectionStart;
        var front = (txtarea.value).substring(0, strPos);
        var back = (txtarea.value).substring(strPos, txtarea.value.length);
        txtarea.value = front + text + back;
        strPos = strPos + text.length;
        if (br == "ie") {
            txtarea.focus();
            var range = document.selection.createRange();
            range.moveStart('character', -txtarea.value.length);
            range.moveStart('character', strPos);
            range.moveEnd('character', 0);
            range.select();
        }
        else if (br == "ff") {
            txtarea.selectionStart = strPos;
            txtarea.selectionEnd = strPos;
            txtarea.focus();
        }
        txtarea.scrollTop = scrollPos;
    }

</script>