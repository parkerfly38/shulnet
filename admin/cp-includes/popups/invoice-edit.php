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
$permission = 'invoice-edit';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $admin->show_no_permissions($error, '', '1');

} else {
    $invoice = new invoice;
    $data    = $invoice->get_invoice($_POST['id']);
    if (empty($data['data']['id'])) {
        $admin->show_popup_error('Could not find invoice.');
        exit;

    } else {
        $cid = $_POST['id'];

    }



    ?>



    <script type="text/javascript">

        $.ctrl('S', function () {

            //submit_invoice();
            return json_add('invoice-add', '<?php echo $cid; ?>', '1', 'popupform');
        });

    </script>





    <form action="" method="post" id="popupform"
          onsubmit="return json_add('invoice-add','<?php echo $cid; ?>','1','popupform');">

    <input type="hidden" name="id" value="<?php echo $data['data']['id']; ?>"/>


        <div id="popupsave">

            <!--<input type="button" onclick="return prev();" value="&laquo; Previous" />

            <input type="button" onclick="return next();" value="Next &raquo;" />-->

            <input type="submit" value="Save" class="save"/>

        </div>

        <h1>Editing Invoice</h1>


    <!--<div id="slider_submit">
        <div class="pad24tb">


            <div id="topicons">&nbsp;</div>


            <div id="slider_right">

                <input type="submit" class="save" value="Save"/>

            </div>


            <div id="slider_left">

                <span class="title">Editing Invoice</span>

            </div>

            <div class="clear"></div>

        </div>
    </div>-->


    <div id="primary_slider_content" class="popupbody">

    <ul id="step_tabs" class="popup_tabs">
        <li class="on">Overview</li>
        <li>Client</li>
        <li>Shipping</li>
    </ul>

    <div class="pad24">

    <div id="step_1" class="step_form">

        <input type="hidden" name="id" value="<?php echo $cid; ?>"/>

        <fieldset>
            <legend>Notify Client</legend>
            <div class="pad24t">
                <div class="field">
                    <label class="less">Notify User</label>
                    <div class="field_entry_less">
                        <input type="checkbox" name="notify_user" value="1" checked="checked"/> Notify the client of an
                        update to this invoice.


                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset>

            <legend>Overview</legend>

            <div class="col50l">

            <div class="pad24t">

                <div class="field">
                    <label class="less">Date Created</label>
                    <div class="field_entry_less">
                        <?php
                        $date = explode(' ', $data['data']['date']);
                        // echo $admin->datepicker('data[date]', $date['0'], '', '220');

                        echo $af
                            ->setSpecialType('date')
                            ->setValue($date['0'])
                            ->string('data[date]');
                        ?>
                    </div>
                </div>

                <div class="field">
                    <label class="less">Due Date</label>
                    <div class="field_entry_less">
                        <?php
                        $date = explode(' ', $data['data']['date_due']);
                        // echo $admin->datepicker('data[date_due]', $date['0'], '', '220');

                        echo $af
                            ->setSpecialType('date')
                            ->setValue($date['0'])
                            ->string('data[date_due]');
                        ?>
                    </div>
                </div>

                </div>
                </div>
                <div class="col50r">

                    <div class="pad24t">

                <div class="field">

                    <label class="less">Hourly Rate</label>

                    <div class="field_entry_less">

                        <?php

                        echo $af
                            ->setRightText('/hour')
                            ->setValue($data['data']['hourly'])
                            ->setSpecialType('number')
                            ->string('data[hourly]');

                        //echo place_currency('<input type="text" name="data[hourly]" value="' . $data['data']['hourly'] . '" style="width:100px;" />', '1');

                        ?>

                    </div>

                </div>


                <div class="field">

                    <label class="less">Tax Rate</label>

                    <div class="field_entry_less">

                        <!--<input type="text" name="data[tax_rate]" value="<?php echo $data['data']['tax_rate']; ?>"
                               style="width:50px;" maxlength="5"/>%-->

                        <?php

                        echo $af
                            ->setRightText('%')
                            ->setValue($data['data']['tax_rate'])
                            ->setSpecialType('number')
                            ->string('data[tax_rate]');
                        ?>
                    </div>

                </div>


                <div class="field">

                    <label class="less">Auto-Inform</label>

                    <div class="field_entry_less">

                        <input type="radio" name="data[auto_inform]"
                               value="1" <?php if ($data['data']['auto_inform'] == '1') {
                            echo " checked=\"checked\"";
                        } ?> /> Automatically e-mail invoice updates<br/>

                        <input type="radio" name="data[auto_inform]"
                               value="0" <?php if ($data['data']['auto_inform'] != '1') {
                            echo " checked=\"checked\"";
                        } ?> /> Manually e-mail invoice updates

                        <p class="field_desc">If set to "automatically" inform the user, notices of all actions on the
                            invoice will be sent to the user, including creating, closing, and adding components.</p>

                    </div>

                </div>

                    </div>

            </div>

        </fieldset>


        <fieldset>

            <legend>Memo</legend>

            <div class="pad24t">

                <textarea name="billing[memo]" id="in1" class="richtext" style="width:100%;height:150px;"><?php
                    echo $data['billing']['memo'];
                    ?></textarea>

                <?php
                echo $admin->richtext('100%', '250px', 'in1', '0', '1');
                ?>

            </div>

        </fieldset>

    </div>


    <div id="step_2" class="step_form" style="display:none;">


        <div class="col33l">
            <fieldset>
                <legend>Client Overview</legend>

                <div class="pad24t">
                    <label>Company</label>
                    <?php
                    echo $af->string('billing[company_name]', $data['billing']['company_name']);
                    ?>

                    <label>Contact Name</label>
                    <?php
                    echo $af->string('billing[contact_name]', $data['billing']['contact_name']);
                    ?>

                    <label>E-Mail</label>
                    <?php
                    echo $af->string('billing[email]', $data['billing']['email']);
                    ?>

                    <label>Phone</label>
                    <?php
                    echo $af->string('billing[phone]', $data['billing']['phone']);
                    ?>

                    <label>Fax</label>
                    <?php
                    echo $af->string('billing[fax]', $data['billing']['fax']);
                    ?>

                    <label>Website</label>
                    <?php
                    echo $af->string('billing[website]', $data['billing']['website']);
                    ?>
                </div>

            </fieldset>
        </div>

        <div class="col66r">
            <fieldset>
                <legend>Client Address</legend>

                <div class="pad24t">
                    <?php
                    echo $af->addressForm('billing', $data['billing'], array('first_name', 'last_name'));
                    ?>
                </div>

            </fieldset>
        </div>

    </div>

    </fieldset>


    </div>


    <div id="step_3" class="step_form" style="display:none;">


    <fieldset>

        <legend>Shipping Data</legend>

        <div class="pad24t">

            <?php

            if ($data['data']['shipping_rule'] != '0') {
                $data['data']['shipping_rule'] = '1';
            }

            echo $af->radio('ship_yesno', $data['data']['shipping_rule'], array(
                '0' => 'No shipping required',
                '1' => 'Shipping Required',
            ));

            ?>

            <!--
            <div class="field">

                <label class="">Shipping?</label>

                <div class="field_entry">

                    <input type="radio" name="ship_yesno" value="0" <?php if (empty($data['data']['shipping_rule'])) {
                        echo "checked=\"checked\"";
                    } ?> onclick="return hide_div('shipping_show');"/> No shipping required<br/>

                    <input type="radio" name="ship_yesno" value="1" <?php if (!empty($data['data']['shipping_rule'])) {
                        echo "checked=\"checked\"";
                    } ?>  onclick="return show_div('shipping_show');"/> Shipping required

                </div>

            </div>
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



            <div id="shipping_show" style="display:<?php if (!empty($data['data']['shipping_rule'])) {
                echo "block";
            } else { echo 'none'; } ?>;margin-top:12px;">


                <div class="field">

                    <label>Method</label>

                    <div class="field_entry">

                        <?php


                        $cart = new cart;
                        $opts = $cart->get_flat_shipping($data['data']['shipping_rule'], 'admin');
                        echo $opts;

                        ?>

                    </div>

                </div>



                <?php
                echo $af->addressForm('shipping', $data['shipping']);
                ?>

                <!--

                <div class="field">

                    <label>First Name</label>

                    <div class="field_entry">

                        <input type="text" value="<?php echo $data['shipping']['first_name']; ?>"
                               name="shipping[first_name]" style="width:220px;"/>

                    </div>

                </div>


                <div class="field">

                    <label>Last Name</label>

                    <div class="field_entry">

                        <input type="text" value="<?php echo $data['shipping']['last_name']; ?>"
                               name="shipping[last_name]"
                               style="width:220px;"/>

                    </div>

                </div>


                <div class="field">

                    <label>Address</label>

                    <div class="field_entry">

                        <input type="text" value="<?php echo $data['shipping']['address_line_1']; ?>"
                               name="shipping[address_line_1]" style="width:220px;"/>

                    </div>

                </div>


                <div class="field">

                    <label>&nbsp;</label>

                    <div class="field_entry">

                        <input type="text" value="<?php echo $data['shipping']['address_line_2']; ?>"
                               name="shipping[address_line_2]" style="width:220px;"/>

                    </div>

                </div>


                <div class="field">

                    <label>City</label>

                    <div class="field_entry">

                        <input type="text" value="<?php echo $data['shipping']['city']; ?>" name="shipping[city]"
                               style="width:220px;"/>

                    </div>

                </div>


                <div class="field">

                    <label>State</label>

                    <div class="field_entry">

                        <select name="shipping[state]" style="width:220px;">

                            <?php





                            $fields = new field;

                            echo $fields->state_list($data['shipping']['state'], '1', 'select');

                            ?>

                        </select>

                    </div>

                </div>


                <div class="field">

                    <label>Zip</label>

                    <div class="field_entry">

                        <input type="text" value="<?php echo $data['shipping']['zip']; ?>" name="shipping[zip]"
                               style="width:80px;" maxlength="6"/>

                    </div>

                </div>


                <div class="field">

                    <label>Country</label>

                    <div class="field_entry">

                        <select name="shipping[country]" style="width:220px;">

                            <?php





                            $fields = new field;

                            echo $fields->country_list($data['shipping']['country'], '1', 'select');

                            ?>

                        </select>

                    </div>

                </div>

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



<?php

}

?>