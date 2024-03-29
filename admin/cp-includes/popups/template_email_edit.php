<?php

$fcallers = $db->standard_callers();


if (!empty($_POST['id'])) {
    $cid         = $_POST['id'];
    $title       = 'Editing E-Mail Template';
    $editing     = '1';
    $gettemplate = $db->get_array("

        SELECT *

        FROM `ppSD_templates_email`

        WHERE `template`='" . $db->mysql_clean($cid) . "'

        LIMIT 1

    ");
    if ($gettemplate['custom'] == '1') {
        $final_content = $gettemplate['content'];

    } else {
        $final_content = $db->get_file(PP_PATH . '/pp-templates/email/' . $gettemplate['theme'] . '/' . $cid . '.html');

    }
    $name        = $gettemplate['title'];
    $subject     = $gettemplate['subject'];
    $save        = $gettemplate['save'];
    $track       = $gettemplate['track'];
    $track_links = $gettemplate['track_links'];
    $cc          = $gettemplate['cc'];
    $public      = $gettemplate['public'];
    $bcc         = $gettemplate['bcc'];
    $from        = $gettemplate['from'];
    $status        = $gettemplate['status'];
    $fcallers .= ',' . $gettemplate['caller_tags'];
    $callers = explode(',', $fcallers);

} else {
    $admin->show_popup_error('Template not submitted.');

}



?>



<script src="js/form_rotator.js" type="text/javascript"></script>


<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('template_email-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('template_email-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">


<div id="popupsave">

    <input type="button" value="Preview" onclick="return preview_template('<?php echo $cid; ?>','email');"/>

    <input type="submit" value="Save" class="save"/>

    <input type="hidden" name="id" value="<?php echo $cid; ?>"/>

    <input type="hidden" name="format" value="1"/>

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
            <label class="">Status</label>
            <div class="field_entry">
                <input type="radio" name="status" id="name" value="1" <?php
                if ($status == 1) { echo " checked=\"checked\""; }
                ?> /> Active <input type="radio" name="status" id="name" value="0" <?php
                if ($status != 1) { echo " checked=\"checked\""; }
                ?> /> Inactive
            </div>
        </div>

        <div class="field">
            <label class="">Accessibility</label>
            <div class="field_entry">
                <input type="radio" name="public" value="1"<?php if ($public == '1') {
                    echo " checked=\"checked\"";
                } ?> /> Public: Can be used and altered by all employees<br/>
                <input type="radio" name="public" value="0"<?php if ($public != '1') {
                    echo " checked=\"checked\"";
                } ?> /> Private: Can only be used and altered by me.<br/>
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
                <input type="text" name="subject" id="subject" value="<?php echo $subject; ?>"
                       class="<?php if ($gettemplate['custom'] != '1') {
                           echo 'req';
                       } ?>" style="width:600px;"/>
            </div>
        </div>

    </div>



    <div class="field">

        <textarea name="template" id="template_content"
                  style="width:100%;height:500px;"><?php echo $final_content; ?></textarea>

    </div>



    <?php



    if ($gettemplate['custom'] == '1') {
        echo $admin->richtext('100%', '500px', 'template_content');

    }



    ?>

        </div>
</fieldset>

</li>

<li class="form_step">


    <fieldset>

        <legend>Header and Footer</legend>

        <div class="pad24t">


            <div class="field">

                <label class="">Header</label>

                <div class="field_entry">

                    <select name="header_id" style="width:400px;">

                        <option value="html_header">Standard Header</option>

                    </select>

                </div>

            </div>


            <div class="field">

                <label class="">Footer</label>

                <div class="field_entry">

                    <select name="footer_id" style="width:400px;">

                        <option value="html_footer">Standard Footer</option>

                    </select>

                </div>

            </div>


        </div>

    </fieldset>


    <fieldset>

        <legend>E-Mail Headers</legend>

        <div class="pad24t">

            <div class="field">

                <label class="">From</label>

                <div class="field_entry">

                    <input type="text" name="from" id="from" value="<?php echo $from; ?>" class=""
                           style="width:600px;"/>

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