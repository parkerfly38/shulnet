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


$account = new account;

$data = $account->get_account($_POST['id']);


$field = new field;

$final_form_col1 = $field->generate_form('account-edit', $data, '1');

$final_form_col2 = $field->generate_form('account-edit', $data, '2');

$notes = new notes;
$pinned_notes = $notes->get_pinned_notes($_POST['id']);


?>





<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('account-add', '<?php echo $data['id']; ?>', '1', 'slider_form');
    });

</script>


<form action="" method="post" id="slider_form"
      onsubmit="return json_add('account-add','<?php echo $data['id']; ?>','1','slider_form');">


<div class="col50">
    <div class="pad24_fs_l">


        <?php

        echo $final_form_col1;

        ?>


    </div>
</div>

<div class="col50">
    <div class="pad24_fs_r">

        <?php

        if (!empty($pinned_notes)) {

            echo '<div style="margin-bottom:24px;">';

            foreach ($pinned_notes as $item) {
                echo $admin->format_note($item);
            }

            echo '</div>';

        }

        ?>

        <fieldset>

            <legend>Details</legend>


            <div class="pad24t">

                <div class="field">

                    <label>Name</label>

                    <div class="field_entry">

                        <input type="text" name="name" style="width:250px;" class="req"
                               value="<?php echo $data['name']; ?>"/>

                        <p class="field_desc" id="name_dets">Select a name for this account.</p>

                    </div>

                </div>

                <?php

                if ($employee['permissions']['admin'] == '1') {
                    ?>

                    <div class="field">

                        <label>Assign To</label>

                        <div class="field_entry">

                            <input type="text" id="ownerf" name="owner_dud"
                                   onkeyup="return autocom(this.id,'id','username','ppSD_staff','username,firstname,lastname','staff');"
                                   value="<?php echo $data['owner']['username']; ?>" style="width:250px;"/><a
                                href="null.php" onclick="return get_list('staff','ownerf_id','ownerf');"><img
                                    src="imgs/icon-list.png" width="16" height="16" border="0"
                                    alt="Select from list" title="Select from list" class="icon-right"/></a>

                            <input type="hidden" name="owner" id="ownerf_id"
                                   value="<?php echo $data['owner']['id']; ?>"/>

                            <p class="field_desc" id="owner_dud_dets">Select the employee to which you would like to
                                assign this contact.</p>

                        </div>

                    </div>

                <?php

                }

                ?>

                <div class="field">

                    <label>Source</label>

                    <div class="field_entry">

                        <input type="text" id="sourcef" value="<?php echo $data['source']['source']; ?>"
                               name="source_dud"
                               onkeyup="return autocom(this.id,'id','source','ppSD_sources','source','');"
                               style="width:250px;"/><a href="null.php"
                                                        onclick="return get_list('source','sourcef_id','sourcef');"><img
                                src="imgs/icon-list.png" width="16" height="16" border="0" alt="Select from list"
                                title="Select from list" class="icon-right"/></a><a href="null.php"
                                                                                    onclick="return popup('sources','');"><img
                                src="imgs/icon-quickadd.png" width="16" height="16" border="0" alt="Add" title="Add"
                                class="icon-right"/></a>

                        <input type="hidden" name="source" id="sourcef_id"
                               value="<?php echo $data['source']['id']; ?>"/>

                        <p class="field_desc" id="source_dud_dets">Where did you generate this lead?</p>

                    </div>

                </div>

                <div class="field">

                    <label>Master Member</label>

                    <div class="field_entry">

                        <input type="text" id="master_userf" name="master_user_dud"
                               onkeyup="return autocom(this.id,'id','username','ppSD_members','username,email','username');"
                               value="<?php echo $data['master']['username']; ?>" style="width:250px;"/><a
                            href="null.php"
                            onclick="return get_list('member','master_userf_id','master_userf');"><img
                                src="imgs/icon-list.png" width="16" height="16" border="0" alt="Select from list"
                                title="Select from list" class="icon-right"/></a><?php

                        if (!empty($data['master']['username'])) {
                            ?><a href="null.php"
                                 onclick="return load_page('member','view','<?php echo $data['master']['id']; ?>');">
                                <img src="imgs/icon-view.png" width="16" height="16" border="0" alt="View"
                                     title="View" class="icon-right"/></a>

                        <?php

                        }

                        ?>

                        <input type="hidden" name="master_user" id="master_userf_id"
                               value="<?php echo $data['master']['id']; ?>"/>

                        <p class="field_desc" id="master_user_dud_dets"><b>Only applicable for accounts with
                                members!</b> If you wish to allow a single member to act as the account's manager,
                            select the member above.</p>

                    </div>

                </div>

                <div class="field">

                    <label>Contact Frequency</label>

                    <div class="field_entry">

                        <?php

                        echo $admin->timeframe_field('contact_frequency', $data['contact_frequency']);

                        ?>

                        <p id="contact_frequency_dets" class="field_desc">This controls how often a contact in this
                            account will require attention.</p>

                    </div>

                </div>

                <div class="field">

                    <label>Created</label>

                    <div class="field_entry">

                        <?php

                        echo $af
                            ->setSpecialType('datetime')
                            ->setValue($data['created'])
                            ->string('created');

                        //echo $admin->datepicker('created', $data['created'], '1');

                        ?>

                    </div>

                </div>

                <div class="field">
                    <label>Login Redirection</label>
                    <div class="field_entry">
                        <input type="text" value="<?php echo $data['start_page']; ?>" name="start_page"
                               id="start_page" style="width:250px;" class="zen_url"/>
                        <p class="field_desc" id="start_page_dud_dets">If you would like to redirect all members of this account to a custom start page at login, input the URL here (http://www.yoursite.com/redirect/here)</p>
                    </div>
                </div>

            </div>

        </fieldset>


        <fieldset>

            <legend>Location</legend>

            <div class="pad24t">

                <?php

                echo generate_map($data, '100%', '275');

                ?>

            </div>

        </fieldset>



        <?php

        echo $final_form_col2;

        ?>


    </div>
</div>

<div class="clear"></div>


<div id="submit">

    <input type="submit" value="Save" class="save"/>

</div>


</form>