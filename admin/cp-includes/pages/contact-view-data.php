<?php 

/**
 * Get a contact's data.
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

$contact = new contact;
$data = $contact->get_contact($_POST['id']);

$field = new field;
$final_form_col1 = $field->generate_form('contact-edit', $data['data'], '1');
$final_form_col2 = $field->generate_form('contact-edit', $data['data'], '2');

// $scope = $this->fields_in_scope('contact');

$q1 = $db->run_query("
  SELECT
      ppSD_fieldsets.id,
      ppSD_fieldsets.name
  FROM
      `ppSD_fieldsets_locations`
  JOIN
      `ppSD_fieldsets`
  ON
      ppSD_fieldsets.id=ppSD_fieldsets_locations.fieldset_id
  WHERE
      ppSD_fieldsets_locations.location='contact-edit'
  ORDER BY
      ppSD_fieldsets.name ASC
");

$list = '<ul id="fieldset_list">';
$list .= '<li class="on" id="li-fs9999" onclick="return show_fieldset(\'9999\');">Contact Overview</li>';
while ($row = $q1->fetch()) {
    $list .= '<li id="li-fs' . $row['id'] . '" onclick="return show_fieldset(\'' . $row['id'] . '\');">' . $row['name'] . '</li>';
}
$list .= '<li id="show_all" onclick="return show_fieldset(\'show_all\');">Show All</li>';
$list .= '</ul>';


$field = new field();
$final_form_col3 = '';
$q2 = $db->run_query("
    SELECT
        `id`,
        `form_id`,
        `user_id`,
        `form_name`,
        `date`
    FROM
        `ppSD_form_submit`
    WHERE
        `user_id`='" . $db->mysql_clean($data['data']['id']) . "'
    ORDER BY
        `date` DESC
");
$listA = '<ul id="fieldset_list">';
while ($row = $q2->fetch()) {
    $listA .= '<li id="li-fs' . $row['id'] . '" onclick="return show_fieldset(\'' . $row['id'] . '\');">' . $row['form_name'] . '<span class="small">' . $db->format_date($row['date'], 'Y/m/d g:ia') . '</span></li>';
    $dataA = $db->assemble_eav_data($row['id']);
    $final_form_col3 .= $db->format_eav_data($dataA, $row['id'], $row['form_name'], '1');
}

if (empty($final_form_col3)) {
    $listA .= '<li class="weak">No additional data to display.</li>';
}

$listA .= '</ul>';

?>

<script type="text/javascript">
    $.ctrl('S', function () {
        return json_add('contact-add', '<?php echo $data['data']['id']; ?>', '1', 'slider_form');
    });
</script>

<form action="" method="post" id="slider_form"
      onsubmit="return json_add('contact-add','<?php echo $data['data']['id']; ?>','1','slider_form');">


<div id="slide_home_left">
    <?php
    echo $list;
    echo $listA;
    ?>
</div>

<div id="slide_home_right">
<div class="pad24_fs_r" id="primary_fields">

<div class="marginbot right">
    <input type="submit" value="Save" class="save"/>
</div>


<fieldset id="fs9999">
<legend>General Details</legend>

<div class="pad24t">


    <div class="col50l">

        <div class="field">

            <label>Type</label>
            <div class="field_entry">

                <select name="type" style="width:200px;">
                    <!--
            <option<?php if ($data['data']['type'] == 'Contact') {
                        echo " selected=\"selected\"";
                    } ?>>Contact
            </option>

            <option<?php if ($data['data']['type'] == 'Lead') {
                        echo " selected=\"selected\"";
                    } ?>>Lead
            </option>

            <option<?php if ($data['data']['type'] == 'Opportunity') {
                        echo " selected=\"selected\"";
                    } ?>>Opportunity
            </option>

            <option<?php if ($data['data']['type'] == 'Customer') {
                        echo " selected=\"selected\"";
                    } ?>>Customer
            </option>
            -->

                    <?php
                    $types = $contact->getTypes();
                    foreach ($types as $item) {
                        if ($item['id'] == $data['type']['id']) {
                            echo "<option value=\"" . $item['id'] . "\" selected=\"selected\">" . $item['name'] . "</option>";
                        } else {
                            echo "<option value=\"" . $item['id'] . "\">" . $item['name'] . "</option>";
                        }
                    }
                    ?>
                </select>

            </div>

        </div>


        <div class="field">

            <label>Source</label>

            <div class="field_entry">

                <input type="text" id="sourcef" value="<?php echo $data['source']['source']; ?>" name="source_dud"
                       onkeyup="return autocom(this.id,'id','source','ppSD_sources','source','');"
                       style="width:250px;"/>

                <a href="null.php" onclick="return get_list('source','sourcef_id','sourcef');"><img
                        src="imgs/icon-list.png" width="16" height="16" border="0" alt="Select from list"
                        title="Select from list" class="icon-right"/></a>

                <a href="null.php" onclick="return popup('sources','');"><img src="imgs/icon-quickadd.png" width="16"
                                                                              height="16" border="0" alt="Add"
                                                                              title="Add" class="icon-right"/></a>

                <input type="hidden" name="source" id="sourcef_id" value="<?php echo $data['source']['id']; ?>"/>

                <p class="field_desc" id="source_dud_dets">Where did you generate this lead?</p>

            </div>

        </div>


        <div class="field">

            <label>Account</label>

            <div class="field_entry">

                <input type="text" value="<?php echo $data['account']['name']; ?>" name="account_dud" id="accountf"
                       onkeyup="return autocom(this.id,'id','name','ppSD_accounts','name','accounts');"
                       style="width:250px;"/><?php if (!empty($data['account']['id'])) {
                    echo "<a href=\"null.php\" onclick=\"return load_page('account','view','" . $data['account']['id'] . "');\"><img src=\"imgs/icon-view.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"View\" title=\"View\" class=\"icon-right\" /></a>";

                } ?><a href="null.php" onclick="return get_list('account','accountf_id','accountf');"><img
                        src="imgs/icon-list.png" width="16" height="16" border="0" alt="Select from list"
                        title="Select from list" class="icon-right"/></a><a href="null.php"
                                                                            onclick="return popup('account-add','');"><img
                        src="imgs/icon-quickadd.png" width="16" height="16" border="0" alt="Add" title="Add"
                        class="icon-right"/></a>

                <input type="hidden" name="account" id="accountf_id" value="<?php echo $data['account']['id']; ?>"/>

                <p class="field_desc" id="account_dud_dets">Accounts group similar contacts together.</p>

            </div>

        </div>


    </div>
    <div class="col50r">

        <div class="field">

            <label>Expected Value</label>

            <div class="field_entry">

                <?php

                echo place_currency('<input type="text" name="expected_value" value="' . $data['data']['expected_value'] . '" style="width:100px;" />', '1');

                ?>

            </div>

        </div>


        <?php
        if ($employee['permissions']['admin'] == '1') {
            ?>

            <div class="field">

                <label>Assign To</label>

                <div class="field_entry">

                    <input type="text" id="ownerf" name="owner_dud"
                           onkeyup="return autocom(this.id,'id','username','ppSD_staff','username','staff');"
                           value="<?php echo $data['owner']['username']; ?>" style="width:250px;"/>

                    <a href="null.php" onclick="return get_list('staff','ownerf_id','ownerf');"><img
                            src="imgs/icon-list.png" width="16" height="16" border="0" alt="Select from list"
                            title="Select from list" class="icon-right"/></a>

                    <input type="hidden" name="owner" id="ownerf_id" value="<?php echo $data['owner']['id']; ?>"/>

                    <p class="field_desc" id="owner_dud_dets">Select the employee to which you would like to assign this
                        contact.</p>

                </div>

            </div>

        <?php
        }
        ?>


        <div class="field">

            <label>Created</label>

            <div class="field_entry">

                <?php

                echo $af
                    ->setSpecialType('datetime')
                    ->setValue($data['data']['created'])
                    ->string('created');

                // echo $admin->datepicker('created', $data['data']['created'], '1');

                ?>

            </div>

        </div>


        <div class="field">

            <label>Next Action</label>

            <div class="field_entry">

                <?php

                echo $af
                    ->setSpecialType('datetime')
                    ->setValue($data['data']['next_action'])
                    ->string('next_action');

                // echo $admin->datepicker('next_action', $data['data']['next_action'], '1');

                ?>

            </div>

        </div>

    </div>
    <div class="clearfix"></div>



<div class="field">

    <label>E-Mail Preference</label>

    <div class="field_entry">

        <select name="email_pref">

            <option value=""<?php if (empty($data['data']['email_pref'])) {
                echo " selected=\"selected\"";
            } ?>>No Preference
            </option>

            <option value="html"<?php if ($data['data']['email_pref'] == 'html') {
                echo " selected=\"selected\"";
            } ?>>HTML Format
            </option>

            <option value="text"<?php if ($data['data']['email_pref'] == 'text') {
                echo " selected=\"selected\"";
            } ?>>Plain Text
            </option>

        </select>

    </div>

</div>

</div>

</fieldset>



<?php

echo $final_form_col1;

echo $final_form_col2;

echo $final_form_col3;

?>


</div>
</div>

<div class="clear"></div>


</form>


<script type="text/javascript" src="js/fs_rotator.js"></script>