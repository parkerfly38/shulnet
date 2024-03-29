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
$forms = new form;
$data = $forms->get_form($_POST['id']);
if (empty($data['id'])) {
    echo $admin->show_popup_error('Form not found');

} else {
    $cid  = str_replace('register-', '', $data['id']);
    $type = $data['type'];

    ?>



    <script src="js/form_builder.js" type="text/javascript"></script>

    <script src="js/form_rotator.js" type="text/javascript"></script>



    <script type="text/javascript">

        $.ctrl('S', function () {
            return json_add('form-add', '<?php echo $cid; ?>', '1', 'popupform');
        });

    </script>



    <form action="" method="post" id="popupform"
          onsubmit="return json_add('form-add','<?php echo $cid; ?>','1','popupform');">


    <div id="popupsave">

        <!--<input type="button" onclick="return prev();" value="&laquo; Previous" />

	<input type="button" onclick="return next();" value="Next &raquo;" />-->

        <input type="button" onclick="return switch_popup('form_code','id=<?php echo $cid; ?>','1');"
               value="Generate Code"/>

        <input type="submit" value="Save" class="save"/>

        <input type="hidden" name="type" value="<?php echo $type; ?>"/>

        <input type="hidden" name="id" value="<?php echo $cid; ?>"/>

    </div>

    <h1>Creating Form</h1>


    <ul id="theStepList">

        <li class="on" onclick="return goToStep('0');">Overview</li>

        <li onclick="return goToStep('1');">E-Mails</li>

        <li onclick="return goToStep('2');">Form Builder</li>

        <li onclick="return goToStep('3');">Special Conditions</li>

        <?php





        if ($type == 'register-free') {
            ?>

            <li onclick="return goToStep('4');">Content Access</li>

        <?php

        } else if ($type == 'register-paid') {
            ?>

            <li onclick="return goToStep('4');">Products</li>

        <?php

        }

        ?>

    </ul>


    <div class="fullForm popupbody">


    <ul id="formlist">

    <li class="form_step">


    <fieldset>

        <legend>Overview</legend>

        <div class="pad24t">


            <div class="field">

                <label>Status<span class="req_star">*</span></label>

                <div class="field_entry">

                    <input type="radio" name="data[disabled]" value="0" <?php if ($data['disabled'] != '1') {
                        echo "checked=\"checked\"";
                    } ?> /> Live <input type="radio" name="data[disabled]"
                                        value="1" <?php if ($data['disabled'] == '1') {
                        echo "checked=\"checked\"";
                    } ?> /> Disabled

                </div>

            </div>


            <div class="field">

                <label>Name<span class="req_star">*</span></label>

                <div class="field_entry">

                    <input type="text" name="data[name]" value="<?php echo $data['name']; ?>" id="e001" maxlength="50"
                           class="req" style="width:450px;"/>

                </div>

            </div>


            <div class="field">

                <label class="top">Description</label>

                <div class="clear"></div>

                <div class="field_entry_top">

                    <textarea name="data[description]" class="richtext" id="form_rich"
                              style="width:100%;height:150px;"><?php echo $data['description']; ?></textarea>

                    <?php
                    echo $admin->richtext('100%', '150px', 'form_rich', '0');
                    ?>

                </div>

            </div>



            <?php

            if ($type != 'dependency' && $type != 'update') {
                ?>

                <div class="field">

                    <label>Source</label>

                    <div class="field_entry">

                        <?php


                        if (!empty($data['source'])) {
                            $source = new source;
                            $scc    = $source->get_source($data['source']);

                        } else {
                            $scc['source'] = '';

                        }

                        ?>

                        <input type="text" id="sourcef" name="source_dud" value="<?php echo $scc['source']; ?>"
                               autocomplete="off" onkeyup="return autocom(this.id,'id','source','ppSD_sources','source','');"
                               style="width:250px;"/><a href="null.php"
                                                        onclick="return get_list('source','sourcef_id','sourcef');"><img
                                src="imgs/icon-list.png" width="16" height="16" border="0" alt="Select from list"
                                title="Select from list" class="icon-right"/></a>

                        <input type="hidden" name="data[source]" id="sourcef_id"
                               value="<?php echo $data['source']; ?>"/>

                        <p class="field_desc">If you would like to assign users using this form to a custom source,
                            select it above. Otherwise the form's ID will be associated with the user.</p>

                    </div>

                </div>



                <div class="field">

                    <label>Account</label>

                    <div class="field_entry">

                        <?php





                        if (!empty($data['account'])) {
                            $account = new account;
                            $acc     = $account->get_account($data['account']);

                        } else {
                            $acc['name'] = '';

                        }

                        ?>

                        <input type="text" id="accountf" name="account_dud"
                               autocomplete="off" onkeyup="return autocom(this.id,'id','name','ppSD_accounts','name','');"
                               value="<?php echo $acc['name']; ?>" style="width:250px;"/><a href="null.php"
                                                                                            onclick="return get_list('account','accountf_id','accountf');"><img
                                src="imgs/icon-list.png" width="16" height="16" border="0" alt="Select from list"
                                title="Select from list" class="icon-right"/></a>

                        <input type="hidden" name="data[account]" id="accountf_id"
                               value="<?php echo $data['account']; ?>"/>

                        <p class="field_desc">If you would like to assign users using this form to a custom account,
                            select it above. Otherwise the default account for this user type will be used.</p>

                    </div>

                </div>



            <?php

            }

            ?>


        </div>

    </fieldset>


    <fieldset>

    <legend>Options</legend>

    <div class="pad24t">


    <?php

    if ($type != 'contact' && $type != 'dependency' && $type != 'update') {
        ?>

        <div class="field">

            <label>Member Status</label>

            <div class="field_entry">

                <input type="radio" name="data[reg_status]" <?php if ($data['reg_status'] == 'A') {
                    echo " checked=\"checked\"";
                } ?> value="A"/> Active<br/>

                <input type="radio" name="data[reg_status]" <?php if ($data['reg_status'] == 'P') {
                    echo " checked=\"checked\"";
                } ?> value="P"/> Pending E-Mail Confirmation<br/>

                <input type="radio" name="data[reg_status]" <?php if ($data['reg_status'] == 'Y') {
                    echo " checked=\"checked\"";
                } ?>value="Y"/> Admin Approval Required<br/>

                <p class="field_desc">Determines the initial status of the member's account after
                    registering.</p>

            </div>

        </div>

        <?php
        if (! empty($data['member_type'])) {
            $user = new user;
            $member_type = $user->get_member_type($data['member_type']);
            $mt_name = $member_type['name'];
            $mt_id = $data['member_type'];
        } else {
            $mt_name = '';
            $mt_id = '';
        }
        ?>

        <div class="field">
            <label>Member Type</label>
            <div class="field_entry">
                <input type="text" value="<?php echo $mt_name; ?>" name="member_type_dud" id="member_typed"
                       autocomplete="off" onkeyup="return autocom(this.id,'id','name','ppSD_member_types','name','member_types');"
                       style="width:250px;"/><a href="null.php" onclick="return get_list('member_types','member_typed_id','member_typed');"><img
                        src="imgs/icon-list.png" width="16" height="16" border="0" alt="Select from list"
                        title="Select from list" class="icon-right"/></a>
                <input type="hidden" name="data[member_type]" id="member_typed_id" value="<?php echo $mt_id; ?>"/>
            </div>
        </div>


        <div class="field">

            <label>Require Code?</label>

            <div class="field_entry">

                <input type="radio" name="data[code_required]"
                       value="1" <?php if ($data['code_required'] == '1') {
                    echo " checked=\"checked\"";
                } ?> /> Yes <input type="radio" name="data[code_required]"
                                   value="0" <?php if ($data['code_required'] != '1') {
                    echo " checked=\"checked\"";
                } ?> /> No

                <p class="field_desc">If set to yes, a registration code will need to be issued to a user before
                    he/she can register from this form.</p>

            </div>

        </div>



        <div class="field">

            <label>Public Listing?</label>

            <div class="field_entry">

                <input type="radio" name="data[public_list]" value="1"<?php if ($data['public_list'] == '1') {
                    echo " checked=\"checked\"";
                } ?> /> Yes <input type="radio" name="data[public_list]"
                                   value="0"<?php if ($data['public_list'] != '1') {
                    echo " checked=\"checked\"";
                } ?> /> No

                <p class="field_desc">If set to "Yes", this form will appear as an option
                    at <?php echo PP_URL . '/register.php'; ?>.</p>

            </div>

        </div>

    <?php

    }

    ?>



    <!--

    <div class="field">

        <label>Establish Account?</label>

        <div class="field_entry">

            <input type="radio" name="data[account_create]" value="1" /> Yes <input type="radio" name="data[account_create]" value="0" checked="checked" /> No

            <p class="field_desc">If set to "Yes", an account will be establish on top of the membership, allowing for sub-members managed by the primary account holder.</p>

        </div>

    </div>

    -->


    <div class="field">

        <label>Captcha?</label>

        <div class="field_entry">

            <input type="radio" name="data[captcha]"<?php if ($data['captcha'] == '1') {
                echo " checked=\"checked\"";
            } ?> value="1"/> Yes <input type="radio" name="data[captcha]"
                                        value="0"<?php if ($data['captcha'] != '1') {
                echo " checked=\"checked\"";
            } ?> /> No

            <p class="field_desc">The program will require that the user complete a CAPTCHA if set to "Yes".</p>

        </div>

    </div>



    <?php

    if ($type != 'update') {
        ?>

        <div class="field">

            <label>Preview Screen?</label>

            <div class="field_entry">

                <input type="radio" name="data[preview]"<?php if ($data['preview'] == '1') {
                    echo " checked=\"checked\"";
                } ?> value="1"/> Yes <input type="radio" name="data[preview]"
                                            value="0"<?php if ($data['preview'] != '1') {
                    echo " checked=\"checked\"";
                } ?> /> No

                <p class="field_desc">If set to "Yes", the user will be able to preview the the form before
                    finalizing the submission.</p>

            </div>

        </div>

    <?php

    }

    if ($type == 'register-free' || $type == 'register-paid') {
        ?>

        <div class="field">

            <label>Create Account?</label>

            <div class="field_entry">

                <input type="radio" name="data[account_create]"
                       value="1"<?php if ($data['account_create'] == '1') {
                    echo " checked=\"checked\"";
                } ?> /> Yes <input type="radio" name="data[account_create]"
                                   value="0"<?php if ($data['account_create'] != '1') {
                    echo " checked=\"checked\"";
                } ?> /> No

                <p class="field_desc">If set to "Yes", an account will be created when the member register. Note
                    that the "Company Name" field is require on the form for this function to work.</p>

            </div>

        </div>

    <?php

    }

    ?>





    <div class="field">

        <label>Redirect</label>

        <div class="field_entry">

            <input type="text" name="data[redirect]" id="e0341" maxlength="150"
                   value="<?php echo $data['redirect']; ?>" style="width:100%;"/>

            <p class="field_desc">Where would you like to redirect users have a form has been processed? Leave
                blank to use the standard template-generated thank you page.</p>

        </div>

    </div>


    </div>

    </fieldset>


    </li>

    <li class="form_step">


        <fieldset>

            <legend>E-Mail Template</legend>

            <div class="pad24t">


                <div class="field">

                    <label>Thank You Email</label>

                    <div class="field_entry">

                        <input type="radio" name="data[email_thankyou]"<?php if ($data['email_thankyou'] == '1') {
                            echo " checked=\"checked\"";
                        } ?> value="1" onclick="return show_div('email_up');"/> Send user a thank you email.<br/>

                        <input type="radio" name="data[email_thankyou]"<?php if ($data['email_thankyou'] != '1') {
                            echo " checked=\"checked\"";
                        } ?> value="0" onclick="return hide_div('email_up');"/> Do not send a thank you email.

                    </div>

                </div>


                <div id="email_up" style="display:<?php if ($data['email_thankyou'] == '1') {
                    echo "block";
                } else {
                    echo "none";
                } ?>;">

                    <div class="field">

                        <label>User Template</label>

                        <div class="field_entry">

                            <select name="data[template]" style="width:250px;">

                                <option value="" <?php if (empty($data['template'])) {
                                    echo " selected=\"selected\"";
                                } ?> >Default Template
                                </option>

                                <?php





                                echo $admin->get_email_templates_type('template', $data['template'], '1');

                                ?>

                            </select>

                            <p class="field_desc">Select the template you would like to use for the "Thank You"
                                email.</p>

                        </div>

                    </div>


                </div>


            </div>

        </fieldset>


    <Fieldset>
            <legend>Notifications</legend>

            <div class="pad24t">
        
                    <div class="field">

                            <textarea name="data[email_forward]" id="e0151"
                                      style="width:100%;height:150px;"><?php echo str_replace(",", "\n", $data['email_forward']); ?></textarea>

                            <p class="field_desc">If you would like to notify certain e-mails, input one per line.</p>

                    </div>
        
             </div>
    </fieldset>

    </li>

    <li class="form_step">


        <?php

        $form_type = '1'; // <- Standard Form

        $col1_name = 'Form Builder';

        $col2_name = '';

        $multi_col = '0';

        $col1_load = $data['id'];

        include PP_ADMINPATH . "/cp-includes/create_form.php";

        ?>


    </li>

    <li class="form_step">


        <table cellspacing="0" cellpadding="0" id="conditions" class="generic">
            <thead>

            <tr>

                <th width="160">Field</th>

                <th width="90">-></th>

                <th width="160">Value</th>

                <th>Result</th>

                <th width="18">&nbsp;</th>

            </tr>

            </thead>

            <tbody>

            <?php





            $current_conds = 0;

            $current_prods = 0;

            $current_content = 0;

            foreach ($data['conditions'] as $item) {
                echo $admin->cell_form_condition($current_conds, $item['id']);
                $current_conds++;

            }

            ?>

            </tbody>

        </table>

        <p class="center"><a href="returnnull.php" onclick="return add_condition();">Add a Condition [+]</a></p>


    </li>

    <?php





    if ($type == 'register-free') {
        ?>

        <li class="form_step">

            <p class="highlight">If you selected a "Member Type" to which this product will assign members purchasing it, the following content will be assigned to the member as well as the content package assigned by the member type. Note that you do not need to select a member type. Likewise, selecting additional content is optional.</p>

            <table cellspacing="0" class="generic" cellpadding="0" border="0" id="content_options">
                <thead>
                <tr>

                    <th>Content</th>

                    <th width="200">Timeframe</th>

                    <th width="16"></th>

                </tr>
                </thead>

                <tbody>

                <?php





                foreach ($data['content'] as $item) {
                    echo $admin->cell_content_grant($current_content, $item['id']);
                    $current_content++;

                }

                ?>

                </tbody>

            </table>


            <a class="submit" href="returnnull.php" onclick="return addcontent();">Add Content Access</a>


        </li>

    <?php

    } else if ($type == 'register-paid') {
        ?>

        <li class="form_step">


            <p class="highlight">For a paid registration form, all content access (with the exception of the content packages assigned by the member type, if any) is controlled by product settings.
                Whichever product(s) a user purchase will control what that user gets access to.</p>

            <table cellspacing="0" class="generic" cellpadding="0" border="0" id="product_options">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th width="16"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($data['products'] as $item) {
                    echo $admin->cell_form_product($current_prods, $item['id']);
                    $current_prods++;

                }
                ?>
                </tbody>
            </table>

            <a class="submit" href="returnnull.php" onclick="return add_product();">Add a Product Option</a>

            <script type="text/javascript">
                var fixHelper = function(e, ui) {
                    ui.children().each(function() {
                        $(this).width($(this).width());
                    });
                    return ui;
                };
                $("#product_options tbody").sortable({
                    helper: fixHelper
                }); // .disableSelection();
            </script>

        </li>

    <?php

    }

    ?>

    </ul>


    </div>


    </form>



    <script type="text/javascript">

        var current_condition = <?php echo $current_conds; ?>;
        var current_product = <?php echo $current_prods; ?>;
        content = <?php echo $current_content; ?>;

    </script>

    <script type="text/javascript" src="js/form_items.js"></script>



<?php

}

?>