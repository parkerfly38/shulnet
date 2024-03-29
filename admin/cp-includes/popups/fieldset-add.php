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

if (!empty($_POST['id'])) {
    $data    = new history($_POST['id'], '', '', '', '', '', 'ppSD_fieldsets');
    $cid     = $_POST['id'];
    $editing = '1';
    if ($data->final_content['static'] == '1') {
        $static = 1;

    } else {
        $static = 0;

    }
    $name = $data->final_content['name'];
    $desc = $data->final_content['desc'];

    // Scopes
    $admin = new admin;
    $locations = $admin->fieldset_scopes($cid);

    $member_add = $locations['member-add'];
    $member_edit = $locations['member-edit'];
    $contact_add = $locations['contact-add'];
    $contact_edit = $locations['contact-edit'];
    $account_add = $locations['account-add'];
    $account_edit = $locations['account-edit'];
    $update_account = $locations['update-account'];

} else {
    $cid     = 'new';
    $editing = '0';
    $static  = 0;
    $desc    = '';
    $name    = '';
    $member_add = '0';
    $member_edit = '0';
    $contact_add = '0';
    $contact_edit = '0';
    $account_add = '0';
    $account_edit = '0';
    $update_account = '0';
}

?>





<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('fieldset-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<script type="text/javascript">

    var fields = [];
    $(document).ready(function () {
        $("#col2_fields").sortable({
            connectWith: ".colfields",
            placeholder: "ui-state-highlight"
        }); // .disableSelection();
    });
    function add_field(id, name, field_type) {
        var remove_id = 'prev-field-' + id;
        var type_img = '<span><img src="imgs/icon-fb-' + field_type + '.png" width="16" height="16" border="0" alt="' + field_type + '" title="' + field_type + '" class="iconmid" /></span>';
        var html = '<li id="field-' + id + '"><div style="float:right;"><img src="imgs/icon-required.png" id="reqimg-' + id + '" width="16" height="16" border="0" onclick="return set_required(\'' + id + '\');" class="icon hover_req" alt="Required" title="Required" /><img src="imgs/icon-delete.png" width="16" height="16" border="0" onclick="return remove_field(\'' + id + '\',\'' + name + '\',\'' + field_type + '\')" class="icon hover" alt="Delete" title="Delete" /></div><div class="move"></div>' + type_img + name + '<input type="hidden" id="req-' + id + '" name="field[' + id + ']" value="0" /></li>';
        // var html = '<li id="field-' + id + '" onclick="return remove_field(\'" + id + "\',\'" + name + "\')"><input type="hidden" name="fields[' + id + ']" value="1" />' + name + '</li>';
        $('#col2_fields').append(html);
        //$('#' + remove_id).remove();
        $('.removefield').remove();
    }
    function remove_field(id, name, type) {
        var fid = 'field-' + id;
        $('#' + fid).remove();
        // var html = '<li id="prev-field-' + id + '" onclick="return add_field(\'" + id + "\',\'" + name + "\',\'" + type + "\');">' + name + '</li>';
    }
    function set_required(id, force) {
        if (!force) {
            var cur_val = $('#req-' + id).val();
        } else {
            var cur_val = force;
        }
        // Set to not required
        if (cur_val == '1') {
            $('#req-' + id).val('0');
            $('#reqimg-' + id).attr('src', 'imgs/icon-required.png');
        } else {
            $('#req-' + id).val('1');
            $('#reqimg-' + id).attr('src', 'imgs/icon-required-on.png');
        }
        return false;
    }

</script>

<script src="js/form_rotator.js" type="text/javascript"></script>


<form action="null.php" method="post" id="popupform"
      onsubmit="return json_add('fieldset-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">


<div id="popupsave">

    <input type="submit" value="Save" class="save"/>

</div>

<h1>Fieldset Management</h1>


<ul id="theStepList">

    <li class="on" onclick="return goToStep('0');">Settings</li>

    <li onclick="return goToStep('1');">Fields</li>

</ul>


<div class="fullForm popupbody">


    <?php

    if ($static == 1) {
        echo "<p class=\"highlight\">This is a pre-defined fieldset. While the program will not prevent you from changing it, we recommend against changing the default fields in the set to prevent potentials issues with functionality.</p>";
    }

    ?>

    <ul id="formlist">

        <li class="form_step">

            <fieldset>
                <legend>Overview</legend>
                <div class="pad24t">

                    <div class="field">
                        <label>Name</label>
                        <div class="field_entry">
                            <input type="text" value="<?php echo $name; ?>" name="data[name]" class="req" id="nameAF"
                                   style="width:300px;"/>
                        </div>
                    </div>


                    <div class="field">
                        <label class="top">Description</label>
                        <div class="clear"></div>
                        <div class="field_entry_top">
                            <textarea name="data[desc]" class="richtext" id="event_rich"
                                      style="width:100%;height:150px;"><?php echo $desc; ?></textarea>
                            <?php
                            // Not working for some reason...
                            echo $admin->richtext('100%', '250px', 'event_rich');
                            ?>
                        </div>
                    </div>


                    <div class="field">
                        <label class="top">Scopes</label>
                        <div class="clear"></div>
                        <div class="field_entry_top">
                            <input type="checkbox" name="scope[member-add]" value="1" <?php if ($member_add == '1') { echo " checked=\"checked\""; } ?> /> Member (Add)<br />
                            <input type="checkbox" name="scope[member-edit]" value="1" <?php if ($member_edit == '1') { echo " checked=\"checked\""; } ?> /> Member (Edit)<br />
                            <input type="checkbox" name="scope[contact-add]" value="1" <?php if ($contact_add == '1') { echo " checked=\"checked\""; } ?> /> Contact (Add)<br />
                            <input type="checkbox" name="scope[contact-edit]" value="1" <?php if ($contact_edit == '1') { echo " checked=\"checked\""; } ?> /> Contact (Edit)<br />
                            <input type="checkbox" name="scope[account-add]" value="1" <?php if ($account_add == '1') { echo " checked=\"checked\""; } ?> /> Account (Add)<br />
                            <input type="checkbox" name="scope[account-edit]" value="1" <?php if ($account_edit == '1') { echo " checked=\"checked\""; } ?> /> Account (Edit)<Br />
                            <input type="checkbox" name="scope[update-account]" value="1" <?php if ($update_account == '1') { echo " checked=\"checked\""; } ?> /> Member Update Page</div>
                    </div>

                </div>

            </fieldset>


        </li>

        <li class="form_step">


            <div class="col33l" style="padding-right:24px;">


                <h4>Available Fields</h4>


                <ul id="col1_fields" class="long_list">

                    <?php

                    $q1 = $db->run_query("
                        SELECT `id`,`display_name`,`type`
                        FROM `ppSD_fields`
                        ORDER BY `display_name` ASC
                    ");

                    while ($row = $q1->fetch()) {
                        echo "<li id=\"prev-field-" . $row['id'] . "\" onclick=\"return add_field('" . $row['id'] . "','" . addslashes($row['display_name']) . "','" . $row['type'] . "');\">" . $row['display_name'] . "</li>";
                    }

                    ?>

                </ul>


            </div>

            <div class="col66r" style="margin-left:-48px;">


                <h4>Fields in this Fieldset</h4>


                <ul id="col2_fields" class="colfields">

                    <?php

                    if ($editing == '1') {
                        echo "<script type=\"text/javascript\">";
                        echo "$(document).ready(function() {\n";
                        $inset = $db->run_query("
                            SELECT
                              ppSD_fields.id,
                              ppSD_fields.type,
                              ppSD_fields.display_name
                            FROM
                              `ppSD_fieldsets_fields`
                            JOIN
                              ppSD_fields
                            ON
                              ppSD_fields.id=ppSD_fieldsets_fields.field
                            WHERE
                              ppSD_fieldsets_fields.fieldset='" . $db->mysql_clean($cid) . "'
                            ORDER BY
                              ppSD_fieldsets_fields.order ASC
                        ");
                        while ($row = $inset->fetch()) {
                            echo "add_field('" . $row['id'] . "','" . addslashes($row['display_name']) . "','" . $row['type'] . "');\n";

                        }
                        echo "});";
                        echo "</script>";

                    } else {
                        ?>

                        <li class="removefield">Click any field to the left to add it to the fieldset.</li>

                    <?php

                    }

                    ?>

                </ul>


            </div>

            <div class="clear"></div>


        </li>

    </ul>


</div>


</form>


<link type="text/css" rel="stylesheet" media="all" href="css/fields_sortable.css"/>