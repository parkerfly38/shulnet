<?php 

if (empty($_POST['id'])) {
    $admin->show_popup_error('No campaign selected.');

} else {
    $cid        = $_POST['id'];
    $found_form = $db->get_array("

        SELECT COUNT(*) FROM `ppSD_forms` WHERE `id`='campaign-" . $cid . "'

    ");
    if ($found_form['0'] == '1') {
        $form_name = 'campaign-' . $cid;

    } else {
        $form_name = '';

    }



    ?>



    <script src="js/form_builder.js" type="text/javascript"></script>

    <script src="js/form_rotator.js" type="text/javascript"></script>

    <script src="<?php echo PP_ADMIN; ?>/js/form_steps.js" type="text/javascript"></script>


    <script type="text/javascript">

        $.ctrl('S', function () {
            return json_add('campaign_form-add', '<?php echo $cid; ?>', '0');
        });

    </script>



    <form action="" method="post" id="popupform"
          onsubmit="return json_add('campaign_form-add','<?php echo $cid; ?>','0');">


        <div id="popupsave">

            <input type="submit" value="Save" class="save"/>

        </div>

        <h1>Campaign Sign Up Form</h1>

        <div class="popupbody fullForm">

        <ul id="step_tabs" class="popup_tabs">
            <li class="on">
                Existing Form
            </li><li>
                Build a Form
            </li>
        </ul>

        <div id="step_1" class="step_form">

            <p class="highlight">Copy and paste the following code onto any template or page within your
                membership website. If no code appears below, you will need to generate a form from the "Build a
                Form" tab above.</p>

            <fieldset>
                <div class="pad">

                    <?php

                    $form = '{-form_campaign-' . $cid . '-}';


                    if (empty($form_name)) {
                        ?>

                        <script type="text/javascript">

                            $(document).ready(function () {
                                add_field('1', 'email||E-Mail||1||text');
                                add_field('1', 'first_name||First Name||1||text');
                                add_field('1', 'last_name||Last Name||1||text');
                            });

                        </script>

                    <?php

                    } else {

                        // $field = new field('','1');
                        // $form = $field->generate_form($form_name);
                    }



                    ?>

                    <textarea id="cp_form_data" style="width:100%;height:100px;"><?php echo $form; ?></textarea>

                </div>
            </fieldset>

        </div>

        <div id="step_2" class="step_form">

            <?php

            if (empty($form_name)) {
                echo "<p class=\"highlight\">You have not yet generated a sign up form for this campaign. We have generated a form with some recommended fields below.</p>";
            } else {
                echo "<p class=\"highlight\">Customize the fields you wish to collect from users subscribing to this campaign below.</p>";
            }

            ?>

            <fieldset>
                <div class="pad">

                <?php

                $col1_load = $form_name;

                $col1_name = 'Sign Up Form';

                $multi_col = '0';

                include PP_ADMINPATH . "/cp-includes/create_form.php";

                ?>

                </div>
            </fieldset>

        </div>


    </form>



<?php

}

?>