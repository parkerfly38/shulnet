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


$fcallers = $db->standard_callers();


$cid = 'new';

$title = 'Creating Custom E-Mail Template';

$editing = '0';

$name = '';

$bcc = '';

$cc = '';

$from = '';

$final_content = '';

$subject = '';

$public = '1';

$save = '0';

$track = '1';

$track_links = '0';



?>



<script src="js/form_rotator.js" type="text/javascript"></script>


<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('template_email-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('template_email-add','<?php echo $cid; ?>','<?php echo $editing; ?>');">


<div id="popupsave">

    <input type="button" value="Preview" onclick="return preview_template('<?php echo $cid; ?>','email');"/>

    <input type="submit" value="Save" class="save"/>

    <input type="hidden" name="id" value="<?php echo $cid; ?>"/>

</div>

<h1><?php echo $title; ?></h1>


<ul id="theStepList">

    <li class="on" onclick="return goToStep('0');">Template</li>

    <li onclick="return goToStep('1');">Options</li>

</ul>


<div class="pad24t popupbody">


<ul id="formlist">

<li class="form_step">

<fieldset>
    <div class="pad">

    <div class="col50l">

        <div class="field">
            <label class="">Accessibility</label>
            <div class="field_entry">
                <input type="radio" name="public" value="1" checked="checked"/> Public: Can be used and altered by all
                employees<br/>
                <input type="radio" name="public" value="0"/> Private: Can only be used and altered by me.<br/>
            </div>
        </div>

    </div>
    <div class="col50r">

        <div class="field">
            <label class="">Reference Title</label>
            <div class="field_entry">
                <input type="text" name="name" id="name" value="<?php echo $name; ?>" class="req" style="width:400px;"/>
            </div>
        </div>

        <div class="field">
            <label class="">Subject</label>
            <div class="field_entry">
                <input type="text" name="subject" id="subject" value="<?php echo $subject; ?>" class="req"
                       style="width:600px;"/>
            </div>
        </div>

    </div>
    <div class="holderClear"></div>

    <div class="field">
        <textarea name="template" id="template_content"
                  style="width:100%;height:500px;"><?php echo $final_content; ?></textarea>
        <?php
        echo $admin->richtext('100%', '500px', 'template_content');
        ?>
    </div>

    </div>
</fieldset>

</li>

<li class="form_step">

<fieldset>

    <legend>E-Mail Headers</legend>

    <div class="pad24t">

        <div class="field">

            <label class="">From</label>

            <div class="field_entry">

                <input type="text" name="from" id="from" value="<?php echo $from; ?>" class="" style="width:600px;"/>

                <p class="field_desc">Leave blank for the default "From" address.</p>

            </div>

        </div>


        <div class="field">

            <label class="">CC</label>

            <div class="field_entry">

                <input type="text" name="cc" id="cc" value="<?php echo $cc; ?>" class="" style="width:600px;"/>

            </div>

        </div>


        <div class="field">

            <label class="">BCC</label>

            <div class="field_entry">

                <input type="text" name="bcc" id="bcc" value="<?php echo $bcc; ?>" class="" style="width:600px;"/>

            </div>

        </div>

    </div>

</fieldset>


<fieldset>

    <legend>Options</legend>

    <div class="pad24t">


        <div class="field">

            <label class="">Track Reading</label>

            <div class="field_entry">

                <input type="radio" name="track" value="1" <?php if ($track == '1') {
                    echo " checked=\"checked\"";
                } ?> /> Yes <input type="radio" name="track" value="0" <?php if ($track != '1') {
                    echo " checked=\"checked\"";
                } ?> /> No

                <p class="field_desc">Would you like to track when a user reads this email?</p>

            </div>

        </div>


        <div class="field">

            <label class="">Track Link Clicks</label>

            <div class="field_entry">

                <input type="radio" name="track_links" value="1" <?php if ($track_links == '1') {
                    echo " checked=\"checked\"";
                } ?> /> Yes <input type="radio" name="track_links" value="0" <?php if ($track_links != '1') {
                    echo " checked=\"checked\"";
                } ?> /> No

                <p class="field_desc">Would you like to track when links are clicked on this email?</p>

            </div>

        </div>


        <div class="field">
            <label class="">Save a Copy</label>
            <div class="field_entry">
                <input type="radio" name="save" value="1" <?php if ($save == '1') {
                    echo " checked=\"checked\"";
                } ?> /> Yes <input type="radio" name="save" value="0" <?php if ($save != '1') {
                    echo " checked=\"checked\"";
                } ?> /> No
                <p class="field_desc">Would you like to save a copy of this outgoing email for all users?</p>
            </div>
        </div>
    </div>

</fieldset>


</li>

</ul>


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