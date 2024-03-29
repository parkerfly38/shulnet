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
// Check permissions, ownership,
// and if it exists.
$permission = 'account-add';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $admin->show_no_permissions($error, '', '1');

} else {
    $cid             = generate_id('random', '8');
    $field           = new field;
    $final_form_col1 = $field->generate_form('account-add', '', '1');
    $final_form_col2 = $field->generate_form('account-add', '', '2');



    ?>





    <script type="text/javascript" xmlns="http://www.w3.org/1999/html">

        $.ctrl('S', function () {
            return json_add('account-add', '<?php echo $cid; ?>', '0', 'slider_form');
        });

    </script>



    <form action="" method="post" id="slider_form"
          onsubmit="return json_add('account-add','<?php echo $cid; ?>','0','slider_form');">


    <div id="slider_submit">
        <div class="pad24tb">

            <div id="slider_right">

                <input type="submit" value="Save" class="save"/>

            </div>

            <div id="slider_left">

                <a href="null.php" onclick="return popup('profile_picture','id=<?php echo $cid; ?>&type=account');"><img
                        src="<?php echo PP_ADMIN; ?>/imgs/anon.png" width="48" height="48" border="0" alt=""
                        title="" class="profile_pic border"/></a><span class="title">Creating Account</span><span
                    class="data">Click here to upload a logo for this account.</span>

            </div>

            <div class="clear"></div>

        </div>
    </div>


    <div id="primary_slider_content">

        <div class="col50">
            <div class="pad24_fs_l">


                <?php



                echo $final_form_col1;

                ?>


            </div>
        </div>

        <div class="col50">
            <div class="pad24_fs_r">


                <fieldset>

                    <legend>Lead Details</legend>

                    <div class="pad24t">

                        <div class="field">

                            <label>Name</label>

                            <div class="field_entry">

                                <input type="text" name="name" style="width:250px;" class="req"/>

                                <p class="field_desc" id="name_dets">Select a name for this account.</p>

                            </div>

                        </div>

                        <div class="field">

                            <label>Contact Frequency</label>

                            <div class="field_entry">

                                <?php

                                echo $admin->timeframe_field('contact_frequency', '000100000000');

                                ?>

                                <p id="contact_frequency_dets" class="field_desc">This controls how often a contact
                                    in this account will require attention.</p>

                            </div>

                        </div>


                        <div class="field">

                            <label>Assign To</label>

                            <div class="field_entry">

                                <input type="text" id="ownerf" name="owner_dud"
                                       onkeyup="return autocom(this.id,'id','username','ppSD_staff','username,firstname,lastname','staff');"
                                       value="<?php echo $employee['username']; ?>" style="width:250px;"/><a
                                    href="null.php" onclick="return get_list('staff','ownerf_id','ownerf');"><img
                                        src="imgs/icon-list.png" width="16" height="16" border="0"
                                        alt="Select from list" title="Select from list" class="icon-right"/></a>

                                <input type="hidden" name="owner" id="ownerf_id"
                                       value="<?php echo $employee['id']; ?>"/>

                                <p class="field_desc" id="owner_dud_dets">Select the employee to which you would
                                    like to assign this contact.</p>

                            </div>

                        </div>


                        <div class="field">

                            <label>Source</label>

                            <div class="field_entry">

                                <input type="text" id="sourcef" name="source_dud"
                                       onkeyup="return autocom(this.id,'id','source','ppSD_sources','source','');"
                                       style="width:250px;"/><a href="null.php"
                                                                onclick="return get_list('source','sourcef_id','sourcef');"><img
                                        src="imgs/icon-list.png" width="16" height="16" border="0"
                                        alt="Select from list" title="Select from list" class="icon-right"/></a><a
                                    href="null.php" onclick="return popup('sources','');"><img
                                        src="imgs/icon-quickadd.png" width="16" height="16" border="0" alt="Add"
                                        title="Add" class="icon-right"/></a>

                                <input type="hidden" name="source" id="sourcef_id"/>

                                <p class="field_desc" id="source_dud_dets">Where did you generate this account?</p>

                            </div>

                        </div>


                        <div class="field">

                            <label>Master Member</label>

                            <div class="field_entry">

                                <input type="text" id="master_userf" name="master_user_dud"
                                       onkeyup="return autocom(this.id,'id','username','ppSD_members','username,email','username');"
                                       value="" style="width:250px;"/><a href="null.php"
                                                                         onclick="return get_list('member','master_userf_id','master_userf');"><img
                                        src="imgs/icon-list.png" width="16" height="16" border="0"
                                        alt="Select from list" title="Select from list" class="icon-right"/></a>

                                <input type="hidden" name="master_user" id="master_userf_id" value=""/>

                                <p class="field_desc" id="master_user_dud_dets"><b>Only applicable for accounts with
                                        members!</b> If you wish to allow a single member to act as the account's
                                    manager, select the member above.</p>

                            </div>

                        </div>

                        <div class="field">

                            <label>Created</label>

                            <div class="field_entry">

                                <?php


                                echo $af
                                    ->setSpecialType('datetime')
                                    ->setValue(current_date())
                                    ->string('created');

                                //echo $admin->datepicker('created', current_date(), '1');

                                ?>

                            </div>

                        </div>

                    </div>

                </fieldset>



                <?php



                echo $final_form_col2;

                ?>


            </div>
        </div>

        <div class="clear"></div>

    </div>


    </form>

    <script type="text/javascript" src="<?php echo PP_ADMIN; ?>/js/forms.js"></script>



<?php

}

?>