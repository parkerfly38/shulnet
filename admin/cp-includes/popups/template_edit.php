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

if (!empty($_POST['lang'])) {
    $lang = $_POST['lang'];
} else {
    $lang = $db->get_option('language');
}

if (!empty($_POST['id'])) {
    $cid         = $_POST['id'];
    $title       = 'Editing Template';
    $editing     = '1';
    $gettemplate = new history($cid, '', '', '', '', '', 'ppSD_templates');
    $theme       = $gettemplate->final_content['theme'];
    $name        = $gettemplate->final_content['title'];
    $meta_title  = $gettemplate->final_content['meta_title'];
    if ($gettemplate->final_content['type'] == '3') {
        $final_content = $gettemplate->final_content['custom_template'];
    }
    if (empty($final_content)) {
        $final_content = $db->get_file(PP_PATH . '/pp-templates/html/' . $theme . '/' . $lang . '/' . $cid . '.php');
    }
    $fcallers .= ',' . $gettemplate->final_content['caller_tags'];
    $callers = explode(',', $fcallers);
} else {
    $cid     = 'new';
    $title   = 'Creating Custom Template';
    $editing = '0';
    $name    = '';
    $meta_title = '';
}

?>



<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('template-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('template-add','<?php echo $cid; ?>','<?php echo $editing; ?>');">


    <div id="popupsave">

        <input type="button" value="Preview" onclick="return preview_template('<?php echo $cid; ?>');"/>

        <input type="submit" value="Save" class="save"/>

        <input type="hidden" name="id" value="<?php echo $cid; ?>"/>
        <input type="hidden" name="lang" value="<?php echo $lang; ?>"/>

    </div>

    <h1><?php echo $title; ?></h1>



    <div class="popupbody">

        <p class="highlight">Edit a front end template.</p>

        <fieldset>
            <div class="pad fullForm">

                <div class="col50l">

                    <div class="field">
                        <label class="less">Name</label>
                        <div class="field_entry_less">
                            <input type="text" name="name" id="name" value="<?php echo $name; ?>" class="req" style="width:300px;"/>
                        </div>
                    </div>

                </div>
                <div class="col50r">

                    <div class="field">
                        <label class="less">Meta Title</label>
                        <div class="field_entry_less">
                            <input type="text" name="meta_title" id="meta_title" value="<?php echo $meta_title; ?>" class="" style="width:300px;"/>
                        </div>
                    </div>

                </div>
                <div class="clear"></div>



                <div class="field">

                    <textarea name="template" id="template_content"
                              style="width:100%;height:600px;"><?php echo $final_content; ?></textarea>

                </div>

            </div>
        </fieldset>


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