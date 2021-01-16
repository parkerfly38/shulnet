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
$permission = 'invoice-add';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $admin->show_no_permissions($error, '', '1');
} else {
    $cid = generate_id($db->get_option('invoice_id_format'));



    ?>



    <script type="text/javascript">

        $.ctrl('S', function () {

            //submit_invoice();
            return json_add('invoice-add', '<?php echo $cid; ?>', '0', 'popupform');
        });

    </script>



    <script type="text/javascript">

        var inner_option = 0;
        function add_existing_product() {
            inner_option += 1;
            var id = Math.random() * 100000;
            var id1 = Math.random() * 100000;
            row = '<tr id="troption-' + inner_option + '">';
            // row += '<td><input type="hidden" name="components[' + inner_option + '][type]" value="product" />';
            row += '<td><input type="hidden" name="components[' + inner_option + '][type]" value="product" /><input type="text" value="" name="p_dud" id="C' + inner_option + '" autocomplete="off" onkeyup="return autocom(this.id,\'id\',\'name\',\'ppSD_products\',\'name\',\'product\');" style="width:95%;" />';
            row += '<a href="null.php" onclick="return get_list(\'products\',\'C' + inner_option + '_id\',\'C' + inner_option + '\');"><img src="imgs/icon-list.png" width="16" height="16" border="0" alt="Select from list" title="Select from list" class="icon-right"/></a>';
            row += '<input type="hidden" name="components[' + inner_option + '][id]" id="C' + inner_option + '_id" value="" /></td>';
            //row += '<input type="text" name="components[' + inner_option + '][name]" value="" style="width:100%;" class="req" id="A' + inner_option + '" /></td>';
            row += '<td><input type="text" name="components[' + inner_option + '][qty]" value="1" style="width:100%;" class="req" id="B' + inner_option + '" /></td>';
            row += '<td>--</td>';
            row += '<td><input type="checkbox" name="components[' + inner_option + '][tax]" value="1" /></td>';
            row += '<td><img src="imgs/icon-delete.png" width="16" height="16" border="0" alt="Remove" title="Remove" class="hover" onclick="return delete_inner_option(\'' + inner_option + '\');" /></td>';
            row += '</tr>';
            $('#components tbody').append(row);
            return false;
        }
        function add_credit() {
            inner_option += 1;
            var id = Math.random() * 100000;
            var id1 = Math.random() * 100000;
            row = '<tr id="troption-' + inner_option + '">';
            row += '<td><input type="hidden" name="components[' + inner_option + '][type]" value="credit" /><input type="text" name="components[' + inner_option + '][name]" class="req" id="A' + inner_option + '" value="Invoice Credit" style="width:100%;" /><textarea name="components[' + inner_option + '][desc]" style="width:100%;height:85px;margin-top:6px;"></textarea></td>';
            row += '<td>--</td>';
            row += '<td><input type="text" name="components[' + inner_option + '][price]" value="" placeholder="0.00" style="width:100%;" class="req" id="B' + inner_option + '" /></td>';
            row += '<td><input type="checkbox" name="components[' + inner_option + '][tax]" value="1" /></td>';
            row += '<td><img src="imgs/icon-delete.png" width="16" height="16" border="0" alt="Remove" title="Remove" class="hover" onclick="return delete_inner_option(\'' + inner_option + '\');" /></td>';
            row += '</tr>';
            $('#components tbody').append(row);
            return false;
        }
        function add_hourly() {
            inner_option += 1;
            var id = Math.random() * 100000;
            var id1 = Math.random() * 100000;
            row = '<tr id="troption-' + inner_option + '">';
            row += '<td><input type="hidden" name="components[' + inner_option + '][type]" value="hourly" /><input type="text" name="components[' + inner_option + '][name]" value="" style="width:100%;" class="req" id="B' + inner_option + '" /><textarea name="components[' + inner_option + '][desc]" style="width:100%;height:85px;margin-top:6px;"></textarea></td>';
            row += '<td><input type="text" name="components[' + inner_option + '][qty]" value="1" style="width:100%;" class="req" id="A' + inner_option + '" /> <select name="components[' + inner_option + '][hourtype]"><option value="hours">Hours</option><option value="minutes">Minutes</option></select></td>';
            row += '<td>--</td>';
            row += '<td><input type="checkbox" name="components[' + inner_option + '][tax]" value="1" /></td>';
            row += '<td><img src="imgs/icon-delete.png" width="16" height="16" border="0" alt="Remove" title="Remove" class="hover" onclick="return delete_inner_option(\'' + inner_option + '\');" /></td>';
            row += '</tr>';
            $('#components tbody').append(row);
            return false;
        }
        function add_inner_option() {
            inner_option += 1;
        }
        function delete_inner_option(id) {
            $('#troption-' + id).remove();
            return false;
        }

    </script>



    <form action="" method="post" id="popupform"
          onsubmit="return json_add('invoice-add','<?php echo $cid; ?>','0','popupform');">


    <div id="popupsave">

        <!--<input type="button" onclick="return prev();" value="&laquo; Previous" />

	    <input type="button" onclick="return next();" value="Next &raquo;" />-->

        <input type="submit" value="Save" class="save"/>

    </div>

    <h1>Creating Invoice</h1>


    <div id="primary_slider_content" class="fullForm popupbody">

    <ul id="step_tabs" class="popup_tabs">

        <li class="on">Overview</li>

        <li>Components</li>

        <li>Shipping</li>

    </ul>

        <p class="highlight">
            An invoice is considered payable and has a fixed due date, while a quote is a non-commital estimate of how much a project will cost.
        </p>


    <div class="pad24">


    <script src="js/form_builder.js" type="text/javascript"></script>


    <div id="step_1" class="step_form">


    <input type="hidden" name="id" value="<?php echo $cid; ?>"/>


    <fieldset>

        <legend>Overview</legend>

        <div class="pad24t">

            <div class="col50l">
                <label>Is this a quote or an invoice?</label>
                <?php
                echo $af
                    ->radio('data[quote]', '0', array(
                        '0' => 'Invoice',
                        '1' => 'Quote',
                    ));
                ?>

                <label>Auto-Inform</label>
                <?php
                echo $af
                    ->setDescription('If set to "automatically" inform the user, notices for any actions taken on the invoice will be sent to the user, including creating, closing, payments, and adding components.')
                    ->radio('data[auto_inform]', '1', array(
                        '1' => 'Automatically e-mail invoice updates',
                        '0' => 'Manually e-mail invoice updates',
                    ));
                ?>
            </div>

            <div class="col50r">

                <div id="due_date">
                    <label>Due Date</label>
                    <?php
                    echo $af
                        ->setSpecialType('date')
                        ->string('data[due_date]');
                    ?>

                    <label>Acceptable Forms of Payment</label>
                    <?php
                    echo $af
                        ->radio('data[check_only]', '0', array(
                            '0' => 'All',
                            '1' => 'Check Only',
                        ));
                    ?>
                </div>

                <label>Hourly Rate</label>
                <?php
                echo $af
                    ->setRightText('/hour')
                    ->setSpecialType('number')
                    ->SetValue($db->get_option('invoice_hourly'))
                    ->string('data[hourly_rate]');
                ?>

                <label>Tax Rate</label>
                <?php
                echo $af
                    ->setRightText('%')
                    ->setSpecialType('number')
                    ->string('data[tax_rate]');
                ?>
            </div>

            <div class="clear"></div>


        </div>

    </fieldset>


    <fieldset>

    <legend>Client</legend>

    <div class="pad24t">


    <?php
    $member_add = '';
    $contact_add = '';
    $member_username = '';
    $contact_name = '';
    $contact_id = '';
    $member_id = '';
    if (! empty($_POST['uid'])) {
        if ($_POST['utype'] == 'member') {
            $member_add = $_POST['uid'];
            $user = new user;
            $cdata = $user->get_user($_POST['uid']);
            if (! empty($cdata['data']['id'])) {
                $member_username = $cdata['data']['username'];
                $member_id = $_POST['uid'];
            } else {
                $default = '1';
                $member_id = '';
                $member_username = '';
            }
        } else {
            $contact_add = $_POST['uid'];
            $contact = new contact;
            $cdata = $contact->get_contact($_POST['uid']);
            if (! empty($cdata['data']['id'])) {
                $contact_name = $cdata['data']['last_name'] . ', ' . $cdata['data']['first_name'];
                $contact_id = $_POST['uid'];
            } else {
                $default = '1';
                $contact_add = '';
                $contact_id = '';
            }
            $member_username = '';
        }
        $default = '0';
    } else {
        $default = '1';
    }
    ?>

    <div class="field">
        <label class="less">Type</label>
        <div class="field_entry_less">
            <input type="radio" name="data[member_type]"
                   onclick="return swap_multi_div('member','contact,new_contact');" value="member" <?php if ($default == '1' || ! empty($member_add)) { echo " checked=\"checked\""; } ?> />
            Existing Member<br/>

            <input type="radio" name="data[member_type]"
                   onclick="return swap_multi_div('contact','member,new_contact');" value="contact" <?php if (! empty($contact_add)) { echo " checked=\"checked\""; } ?> /> Existing
            Contact<br/>

            <input type="radio" name="data[member_type]"
                   onclick="return swap_multi_div('new_contact','contact,member');" value="new_contact"/> New
            Contact<br/>
        </div>
    </div>


    <div id="member" style="display:<?php
    if (! empty($member_add)) { echo "block"; }
    else if ($default == '1') { echo "block"; }
    else { echo "none"; }
    ?>;">

        <div class="field">

            <label class="less">Member</label>

            <div class="field_entry_less">

                <input type="text" value="<?php echo $member_username; ?>" name="username_dud" id="usernamed"
                       autocomplete="off" onkeyup="return autocom(this.id,'id','username','ppSD_members','username','members');"
                       style="width:200px;"/><a href="null.php"
                                                onclick="return get_list('member','usernamed_id','usernamed');"><img
                        src="imgs/icon-list.png" width="16" height="16" border="0" alt="Select from list"
                        title="Select from list" class="icon-right"/></a>

                <input type="hidden" name="data[member_id]" id="usernamed_id" value="<?php echo $member_id; ?>"/>

            </div>

        </div>

    </div>

    <div id="contact" style="display:<?php
    if (! empty($contact_add)) { echo "block"; }
    else { echo "none"; }
    ?>;">

        <div class="field">

            <label class="less">Last Name</label>

            <div class="field_entry_less">

                <input type="text" value="<?php echo $contact_name; ?>" name="usernameA_dud" id="usernameAd"
                       autocomplete="off" onkeyup="return autocom(this.id,'contact_id','first_name,last_name','ppSD_contact_data','last_name','contacts');"
                       style="width:200px;"/> <a href="null.php"
                                                 onclick="return get_list('contact','usernameAd_id','usernameAd');"><img
                        src="imgs/icon-list.png" width="16" height="16" border="0" alt="Select from list"
                        title="Select from list" class="icon-right"/></a>

                <input type="hidden" name="data[contact_id]" id="usernameAd_id" value="<?php echo $contact_id; ?>"/>

            </div>

        </div>

    </div>

    <div id="new_contact" style="display:none;">

        <div class="col50l">


            <div class="field">

                <label class="less">Company</label>

                <div class="field_entry_less">

                    <input type="text" name="billing[company_name]" style="width:220px;"/>

                </div>

            </div>


            <div class="field">

                <label class="less">Contact</label>

                <div class="field_entry_less">

                    <input type="text" name="billing[contact_name]" style="width:220px;"/>

                </div>

            </div>


            <div class="field">

                <label class="less">E-Mail</label>

                <div class="field_entry_less">

                    <input type="text" name="billing[email]" style="width:220px;"/>

                </div>

            </div>


            <div class="field">

                <label class="less">Phone</label>

                <div class="field_entry_less">

                    <input type="text" name="billing[phone]" style="width:220px;"/>

                </div>

            </div>


            <div class="field">

                <label class="less">Fax</label>

                <div class="field_entry_less">

                    <input type="text" name="billing[fax]" style="width:220px;"/>

                </div>

            </div>


            <div class="field">

                <label class="less">Website</label>

                <div class="field_entry_less">

                    <input type="text" name="billing[website]" style="width:220px;"/>

                </div>

            </div>


        </div>

        <div class="col50r">


            <div class="field">

                <label class="less">Address</label>

                <div class="field_entry_less">

                    <input type="text" name="billing[address_line_1]" style="width:220px;"/>

                </div>

            </div>


            <div class="field">

                <label class="less">&nbsp;</label>

                <div class="field_entry_less">

                    <input type="text" name="billing[address_line_2]" style="width:220px;"/>

                </div>

            </div>


            <div class="field">

                <label class="less">City</label>

                <div class="field_entry_less">

                    <input type="text" name="billing[city]" style="width:220px;"/>

                </div>

            </div>


            <div class="field">

                <label class="less">State</label>

                <div class="field_entry_less">

                    <select name="billing[state]" style="width:220px;">

                        <?php





                        $field = new field;

                        echo $field->state_list('', '1', 'select');

                        ?>

                    </select>

                </div>

            </div>


            <div class="field">

                <label class="less">Zip</label>

                <div class="field_entry_less">

                    <input type="text" name="billing[zip]" maxlength="7" style="width:100px;"/>

                </div>

            </div>


            <div class="field">

                <label class="less">Country</label>

                <div class="field_entry_less">

                    <select name="billing[country]" style="width:220px;">

                        <?php





                        $field = new field;

                        echo $field->country_list('', '0', 'select');

                        ?>

                    </select>

                </div>

            </div>


        </div>

        <div class="clear"></div>

    </div>


    </div>

    </fieldset>


    <fieldset>

        <legend>Memo</legend>

        <div class="pad24t">

            <textarea name="billing[memo]" class="richtext" id="billmemo" style="width:100%;height:150px;"></textarea>
            <?php
            echo $admin->richtext('100%', '250px', 'billmemo');
            ?>

        </div>

    </fieldset>


    </div>


    <div id="step_2" class="step_form" style="display:none;">


        <p class="highlight">Note that you can also add components to the invoice later.</p>


        <table cellspacing="0" class="generic" cellpadding="0" border="0" id="components">
            <thead>
            <tr>

            <thead>

            <th>Item</th>

            <th width="80">Qty</th>

            <th width="120">Unit Price</th>

            <th width="35">Tax</th>

            <th width="25"></th>

            </thead>

            <tbody></tbody>

        </table>


        <div class="submit">

            <a href="null.php" onclick="return add_existing_product();">Add Existing Product</a> | <a href="null.php"
                                                                                                      onclick="return add_hourly();">Add
                Hourly Component</a> | <a href="null.php" onclick="return add_credit();">Add Credit</a>

        </div>


    </div>


    <div id="step_3" class="step_form" style="display:none;">


    <fieldset>

    <legend>Components</legend>

    <div class="pad24t">


        <div class="field">

            <label>Shipping?</label>

            <div class="field_entry">
                <?php

                echo $af->radio('ship_yesno', '0', array(
                    '0' => 'No shipping required',
                    '1' => 'Shipping Required',
                ));

                ?>

                <!--
                <input type="radio" name="ship_yesno" value="0" checked="checked"
                       onclick="return hide_div('shipping_show');"/> No shipping required <input type="radio"
                                                                                                 name="ship_yesno"
                                                                                                 value="1"
                                                                                                 onclick="return show_div('shipping_show');"/>
                Shipping required
                -->

                <script type="text/javascript">

                    $(document).ready(function() {
                        $("input[type=radio][name='ship_yesno']").change(function() {
                            switch(this.value) {
                                case '1':
                                    return show_div('shipping_show');
                                case '0':
                                    return hide_div('shipping_show');
                            }
                        });
                    });

                </script>

            </div>

        </div>


        <div id="shipping_show" style="display:none;margin-top:12px;">

            <div class="field">
                <label>Method</label>
                <div class="field_entry">
                    <?php
                    $cart = new cart;
                    $opts = $cart->get_flat_shipping('', 'admin');
                    echo $opts;
                    ?>
                </div>
            </div>

            <?php
            echo $af->addressForm('shipping', '');
            ?>


            <!--
            <div class="col50l">


                <div class="field">

                    <label>First Name</label>

                    <div class="field_entry">

                        <input type="text" name="shipping[first_name]" style="width:220px;"/>

                    </div>

                </div>


                <div class="field">

                    <label>Last Name</label>

                    <div class="field_entry">

                        <input type="text" name="shipping[last_name]" style="width:220px;"/>

                    </div>

                </div>


                <div class="field">

                    <label>Address Line 1</label>

                    <div class="field_entry">

                        <input type="text" name="shipping[address_line_1]" style="width:220px;"/>

                    </div>

                </div>


                <div class="field">

                    <label>Address Line 2</label>

                    <div class="field_entry">

                        <input type="text" name="shipping[address_line_2]" style="width:200px;"/>

                    </div>

                </div>

            </div>

            <div class="col50r">


                <div class="field">

                    <label>City</label>

                    <div class="field_entry">

                        <input type="text" name="shipping[city]" style="width:220px;"/>

                    </div>

                </div>


                <div class="field">

                    <label>State</label>

                    <div class="field_entry">

                        <select name="shipping[state]" style="width:220px;">

                            <?php





                            $fields = new field;

                            echo $fields->state_list('', '1', 'select');

                            ?>

                        </select>

                    </div>

                </div>


                <div class="field">

                    <label>Zip</label>

                    <div class="field_entry">

                        <input type="text" name="shipping[zip]" style="width:100px;" maxlength="6"/>

                    </div>

                </div>


                <div class="field">

                    <label>Country</label>

                    <div class="field_entry">

                        <select name="shipping[country]" style="width:220px;">

                            <?php





                            $fields = new field;

                            echo $fields->country_list('', '1', 'select');

                            ?>

                        </select>

                    </div>

                </div>

            </div>

            <div class="clear"></div>
            -->


        </div>


    </div>


    </div>

    </fieldset>


    </div>


    <div class="clear"></div>

    </div>


    </form>

    <script src="<?php echo PP_ADMIN; ?>/js/forms.js" type="text/javascript"></script>

    <script src="<?php echo PP_ADMIN; ?>/js/form_steps.js" type="text/javascript"></script>


    <script type="text/javascript">
        $("input[type=radio][name='data[quote]']").change(function() {
            switch(this.value) {
                case '1':
                    return hide_div('due_date');
                case '0':
                    return show_div('due_date');
            }
        });
    </script>


<?php

}