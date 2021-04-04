<?php


?>



<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('update_staff-add', '<?php echo $employee['id']; ?>', '1', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('update_staff-add','<?php echo $employee['id']; ?>','1','popupform');">


    <div id="popupsave">

        <input type="submit" value="Save" class="save"/>

    </div>

    <h1>Manage Profile</h1>


    <div class="pad24t popupbody">


        <fieldset>

            <legend>Current Password</legend>

            <div class="pad24">


                <div class="field">

                    <label>Current</label>

                    <div class="field_entry">

                        <input type="password" id="password" value="" name="current_password" style="width:250px;"
                               class="req"/>

                    </div>

                </div>


            </div>

        </fieldset>


        <fieldset>

            <legend>Update Password</legend>

            <div class="pad24">


                <div class="field">

                    <label>New Password</label>

                    <div class="field_entry">

                        <input type="password" value="" name="new_password" style="width:250px;"/>

                    </div>

                </div>


                <div class="field">

                    <label>Repeat Password</label>

                    <div class="field_entry">

                        <input type="password" value="" name="repeat_password" style="width:250px;"/>

                    </div>

                </div>


            </div>

        </fieldset>


        <fieldset>

            <legend>Overview</legend>

            <div class="pad24">


                <div class="field">

                    <label>First Name</label>

                    <div class="field_entry">

                        <input type="text" name="first_name" value="<?php echo $employee['first_name']; ?>"
                               style="width:250px;"/>

                    </div>

                </div>


                <div class="field">

                    <label>Last Name</label>

                    <div class="field_entry">

                        <input type="text" name="last_name" value="<?php echo $employee['last_name']; ?>"
                               style="width:250px;"/>

                    </div>

                </div>


                <div class="field">

                    <label>E-Mail</label>

                    <div class="field_entry">

                        <input type="text" name="email" value="<?php echo $employee['email']; ?>" style="width:250px;"/>

                    </div>

                </div>


            </div>

        </fieldset>


        <fieldset>

            <legend>Signature</legend>

            <div class="pad24">


                <div class="field">

                    <textarea id="signature" name="signature"
                              style="width:100%;height:200px;"><?php echo $employee['signature']; ?></textarea>

                    <?php

                    echo $admin->richtext('100%', '200px', 'signature', '0', '1');

                    ?>

                </div>


            </div>

        </fieldset>



        <?php





        $field = new field;

        $final_form_col1 = $field->generate_form('employee-update', $employee, '1');

        echo $final_form_col1;

        ?>


    </div>


</form>