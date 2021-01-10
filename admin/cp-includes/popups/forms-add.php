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
$cid = generate_id('random', '7');
$type = $_POST['type'];

?>

<script src="js/form_builder.js" type="text/javascript"></script>
<script src="js/form_rotator.js" type="text/javascript"></script>

<script type="text/javascript">
    $.ctrl('S', function () {
        return json_add('form-add', '<?php echo $cid; ?>', '0', 'popupform');
    });
</script>

<form action="" method="post" id="popupform"
      onsubmit="return json_add('form-add','<?php echo $cid; ?>','0','popupform');">

<div id="popupsave">
    <!--<input type="button" onclick="return prev();" value="&laquo; Previous" />
	<input type="button" onclick="return next();" value="Next &raquo;" />-->
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

    <div class="col50l">
        <div class="pad24t">

            <label>What would you like to name this form?</label>
            <?php
            echo $af
                ->string('data[name]', '', 'req');
            ?>

            <label>Would you like to make this form live?</label>
            <?php
            echo $af
                ->setDescription('If set to Live, users will be able to access it. Otherwise no one will be able to use it.')
                ->radio('data[disabled]', '0', array(
                    '0' => 'Live',
                    '1' => 'Disabled',
                ));
            ?>

        </div>
    </div>
    <div class="col50r">
        <div class="pad24t">

            <label>Provide the form with a description.</label>
            <?php
            echo $af->richtext('description', '', '150', '1');
            ?>

        </div>
    </div>
    <div class="clear"></div>

</fieldset>


<fieldset>

    <legend>Options</legend>

    <div class="col50l">
        <div class="pad24t">

            <?php
            if ($type != 'contact' && $type != 'dependency' && $type != 'update') {
            ?>

                <label>Assign users registering from this form to a member type?</label>
                <?php
                echo $af
                    ->setDescription('Note that products can also assign access to a member type and will override this setting if applicable.')
                    ->memberTypeList('data[member_type]');
                ?>

                <label>Should members be automatically activated or have to confirm their details first?</label>
                <?php
                echo $af
                    ->setDescription('Determines the initial status of the member\'s account after registering.')
                    ->radio('data[reg_status]', 'A', array(
                        'A' => 'Active',
                        'P' => 'Pending E-Mail Confirmation',
                        'Y' => 'Admin Approval Required',
                    ));
                ?>

                <label>Require a special code (invite only) to register from this form?</label>
                <?php
                echo $af
                    ->setDescription('If set to yes, a registration code will need to be issued to a user before
                        he/she can register from this form.')
                    ->radio('data[code_required]', '0', array(
                        '1' => 'Yes',
                        '0' => 'No',
                    ));

                ?>
                <label>List this form publicly?</label>
                <?php
                echo $af
                    ->setDescription('If set to "Yes", this form will appear as an option
                        at ' . PP_URL . '/register.php')
                    ->radio('data[public_list]', '1', array(
                        '1' => 'Yes',
                        '0' => 'No',
                    ));

            }
            ?>

            <?php
            if ($type != 'update') {
            ?>

                <label>Display a confirmation/preview screen before submitting the data?</label>
                <?php
                echo $af
                    ->setDescription('If set to "Yes", the user will be able to preview the the form before
                        finalizing the submission.')
                    ->radio('data[preview]', '0', array(
                        '1' => 'Yes',
                        '0' => 'No',
                    ));
                ?>

            <?php
            }

            if ($type == 'register-free' || $type == 'register-paid') {
                ?>

                <label>Would you like to create an account and assign the member to it?</label>
                <?php
                echo $af
                    ->setDescription('If set to "Yes", an account will be created when the member register. <b>Note
                        that the "Company Name" field is require on the form for this function to work!')
                    ->radio('data[account_create]', '0', array(
                        '1' => 'Yes',
                        '0' => 'No',
                    ));
                ?>

            <?php
            }
            ?>

        </div>
    </div>
    <div class="col50r">
        <div class="pad24t">

            <?php
            if ($type != 'dependency' && $type != 'update') {
            ?>

                <label>Assign to Source?</label>
                <?php
                echo $af
                    ->setDescription('If you would like to assign users using this form to a custom source, select
                        it above. Otherwise the form\'s ID will be associated with the user.')
                    ->sourceList('data[source]');
                ?>


                <label>Assign to Account?</label>
                <?php
                echo $af->setDescription('If you would like to assign users using this form to a custom account, select
                        it above. Otherwise the default account for this user type will be used.')
                    ->accountList('data[account]');

            }
            ?>

            <label>Redirect to a custom "thank you" page after submission?</label>
            <?php
            echo $af
                ->setDescription('This is generally NOT recommended unless you have specific reason not to use the program\'s standard thank you page.')
                ->string('data[redirect]', '', '', 'Example: ' . PP_URL . '/myCustomThankYouPage.php');
            ?>

            <label>Require a CAPTCHA?</label>
            <?php
            echo $af
                ->setDescription('The program will require that the user complete a CAPTCHA if set to "Yes".')
                ->radio('data[captcha]', '0', array(
                    '1' => 'Yes',
                    '0' => 'No',
                ));
            ?>
        </div>
    </div>
    <div class="clear"></div>

</fieldset>


</li>

<li class="form_step">


    <fieldset>

        <legend>E-Mail Template</legend>

        <div class="pad24t">


            <div class="field">

                <label>Thank You Email</label>

                <div class="field_entry">

                    <input type="radio" name="data[email_thankyou]" value="1" checked="checked"
                           onclick="return show_div('email_up');"/> Send user a thank you email.<br/>

                    <input type="radio" name="data[email_thankyou]" value="0" onclick="return hide_div('email_up');"/>
                    Do not send a thank you email.

                </div>

            </div>


            <div id="email_up">

                <div class="field">

                    <label>User Template</label>

                    <div class="field_entry">

                        <select name="data[template]" style="width:250px;">

                            <option value="" selected="selected">Default Template</option>

                            <?php





                            echo $admin->get_email_templates_type('template', '', '1');

                            ?>

                        </select>

                        <p class="field_desc">Select the template you would like to use for the "Thank You" email.</p>

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
                                      style="width:100%;height:150px;"></textarea>

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

        <tbody></tbody>

    </table>

    <p class="center"><a href="returnnull.php" onclick="return add_condition();">Add a Condition [+]</a></p>


</li>

<?php





if ($type == 'register-free') {
    ?>

    <li class="form_step">

        <p class="highlight">
            The following content will be assigned to the member as well as the content package assigned by the member type (assuming you've selected a member type in step 1). Likewise, selecting additional content is optional.
        </p>


        <table cellspacing="0" class="generic" cellpadding="0" border="0" id="content_options">
            <thead>
            <tr>

                <th>Content</th>

                <th width="200">Timeframe</th>

                <th width="16"></th>

            </tr>
            </thead>

            <tbody></tbody>

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
            <tbody></tbody>
        </table>

        <a class="submit" href="returnnull.php" onclick="return add_product();">Add a Product Option</a>


    </li>


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

<?php

}

?>

</ul>


</div>


</form>


<script type="text/javascript">

    var current_condition = 0;
    var current_product = 0;

</script>

<script type="text/javascript" src="js/form_items.js"></script>