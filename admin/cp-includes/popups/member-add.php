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
    $ccdata  = new history($_POST['id'], '', '', '', '', '', 'ppSD_accounts');
    $cid     = $_POST['id'];
    $editing = '1';
    $data    = array(
        'name' => $ccdata->final_content['name'],
        'id'   => $ccdata->final_content['id'],
    );

} else {
    $account = new account;
    $data    = $account->get_account($_POST['account']);
    $cid     = generate_id('random', '8');
    $editing = '0';
}

?>





<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('member-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('member-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">


    <div id="popupsave">

        <input type="submit" value="Save" class="save"/>
        <input type="hidden" name="company_name" value="<?php echo $data['company_name']; ?>" />
        <input type="hidden" name="url" value="<?php echo $data['url']; ?>" />

    </div>

    <h1>Add Contact</h1>


    <div class="pad24t popupbody">


        <fieldset>

            <legend>Basic Details</legend>

            <div class="pad24t">

                <div class="field">

                    <label>Account</label>

                    <div class="field_entry">

                        <input type="text" name="account_dud" id="faccount" value="<?php echo $data['name']; ?>"
                               autocomplete="off" onkeyup="return autocom(this.id,'id','name','ppSD_accounts','name','accounts');"
                               style="width:250px;" class="req"/><a href="null.php"
                                                                    onclick="return popup('account-add','');"><img
                                src="imgs/icon-quickadd.png" width="16" height="16" border="0" alt="Add" title="Add"
                                class="icon-right"/></a>

                        <input type="hidden" name="account" id="faccount_id" value="<?php echo $data['id']; ?>"/>

                        <p class="field_desc" id="account_dud_dets">Accounts group similar contacts together.</p>

                    </div>

                </div>

                <div class="field">

                    <label>Assign To</label>

                    <div class="field_entry">

                        <input type="text" id="ownerf" name="owner_dud"
                               autocomplete="off" onkeyup="return autocom(this.id,'id','username','ppSD_staff','username','staff');"
                               value="<?php echo $data['owner']['username']; ?>" style="width:250px;"/>

                        <input type="hidden" name="owner" id="ownerf_id" value="<?php echo $data['owner']['id']; ?>"/>

                        <p class="field_desc" id="owner_dud_dets">Select the employee to which you would like to assign
                            this contact.</p>

                    </div>

                </div>

                <div class="field">

                    <label>Source</label>

                    <div class="field_entry">

                        <input type="text" id="sourcef" name="source_dud"
                               autocomplete="off" onkeyup="return autocom(this.id,'id','source','ppSD_sources','source','');"
                               style="width:250px;" value="<?php echo $data['source']['source']; ?>"/><a href="null.php"
                                                                                                         onclick="return popup('source-add','');"><img
                                src="imgs/icon-quickadd.png" width="16" height="16" border="0" alt="Add" title="Add"
                                class="icon-right"/></a>

                        <input type="hidden" name="source" id="sourcef_id"
                               value="<?php echo $data['source']['id']; ?>"/>

                        <p class="field_desc" id="source_dud_dets">Where did you generate this account?</p>

                    </div>

                </div>

                <div class="field">

                    <label>Created</label>

                    <div class="field_entry">

                        <?php

                        echo $af
                            ->setSpecialType('date')
                            ->setValue(current_date())
                            ->string('joined');

                        //echo $admin->datepicker('joined', current_date(), '1');

                        ?>

                    </div>

                </div>

                <div class="field">

                    <label>Notification</label>

                    <div class="field_entry">

                        <input type="radio" name="notify" value="1" checked="checked"/> Notify this member of his/her
                        new membership.<br/>

                        <input type="radio" name="notify" value="0"/> Do not notify member.

                    </div>

                </div>

            </div>

        </fieldset>



        <?php

        $field = new field;

        $final_form_col1 = $field->generate_form('member-add', $data, '1');

        echo $final_form_col1;

        ?>


    </div>


</form>