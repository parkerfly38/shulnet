<?php

if (empty($_POST['scope'])) {
    echo $admin->show_popup_error('No import type submitted.');
} else {
    if ($_POST['scope'] == 'member') {
        $type = 'Members';
        $perm = 'member';
    } else if ($_POST['scope'] == 'contact') {
        $type = 'Contacts';
        $perm = 'contact';
    } else if ($_POST['scope'] == 'rsvp') {
        $type = 'Event Registrations';
        $perm = 'rsvp';
    } else if ($_POST['scope'] == 'account') {
        $type = 'Accounts';
        $perm = 'account';
    } else if ($_POST['scope'] == 'transaction') {
        $type = 'Transactions';
        $perm = 'transaction';
    } else {
        $type = '';
    }
}

if (empty($type)) {
    echo $admin->show_popup_error('Import type is not supported.');
} else {

    $permission = 'import-' . $perm;
    $check = $admin->check_permissions($permission, $employee);
    if ($check != '1') {
        echo "0+++You don't have permission to use this feature.";
        exit;
    } else {

    $id = generate_id('random', '25');
    //print_r($id);
    ?>



    <script type="text/javascript">

        $.ctrl('S', function () {
            document.forms["popupform"].submit();
        });

    </script>



    <form action="cp-functions/import.php" method="post" id="popupform" enctype="multipart/form-data">



<div id="popupsave">

    <input type="submit" value="Import" class="save"/>

    <input type="hidden" name="id" value="<?php echo $id; ?>"/>

    <input type="hidden" name="scope" value="<?php echo $_POST['scope']; ?>"/>

</div>

<h1>Importing <?php echo $type; ?></h1>


<div class="pad24t popupbody">


    <p class="highlight">You'll be able to preview your data before anything is imported into the database.</p>


    <fieldset>

        <legend>Import File</legend>

        <div class="pad24">

            <div class="field">

                <label>File</label>

                <div class="field_entry">

                    <input type="file" name="file" id="file"/>

                </div>

            </div>

        </div>

    </fieldset>


    <fieldset>

        <legend>Import Settings</legend>

        <div class="pad24">


            <div class="field">

                <label>Delimiter</label>

                <div class="field_entry">

                    <select name="delimiter">

                        <option value=",">Comma</option>

                        <option value="\t">Tab</option>

                    </select>

                </div>

            </div>


            <div class="field">

                <label>Date Format</label>

                <div class="field_entry">

                    <select name="options[date_format]">

                        <option value="yyyy-mm-dd">yyyy-mm-dd</option>

                        <option value="mm/dd/yy">mm/dd/yy</option>

                        <option value="mm/dd/yyyy">mm/dd/yyyy</option>

                        <option value="dd/mm/yy">dd/mm/yy</option>

                        <option value="dd/mm/yyyy">dd/mm/yyyy</option>

                        <option value="yyyy/mm/dd">yyyy/mm/dd</option>

                        <option value="yy/mm/dd">yy/mm/dd</option>

                    </select>

                </div>

            </div>


            <div class="field">

                <label>Create Records</label>

                <div class="field_entry">

                    <input type="radio" name="options[skip_create]" value="0" checked="checked"/> Create new
                    records<br/><input type="radio" name="options[skip_create]" value="1"/> Do NOT create new records

                </div>

            </div>


            <div class="field">

                <label>Update Records</label>

                <div class="field_entry">

                    <input type="radio" name="options[skip_update]" value="0" checked="checked"/> Update existing
                    records<br/><input type="radio" name="options[skip_update]" value="1"/> Do NOT update existing
                    records

                </div>

            </div>


            <div class="field">

                <label>Delete Records</label>

                <div class="field_entry">

                    <input type="radio" name="options[delete]" value="1"/> Delete matching records<br/><input
                        type="radio"
                        name="options[delete]"
                        value="0"
                        checked="checked"/>
                    Do NOT delete any records

                </div>

            </div>


        </div>

    </fieldset>



    <?php

    if ($_POST['scope'] == 'member') {
        ?>



        <fieldset>

            <legend>Additional Options</legend>

            <div class="pad24">


                <div class="field">

                    <label>E-Mail Members?</label>

                    <div class="field_entry">

                        <input type="radio" name="options[email_users]" value="1"/> E-Mail New Members<br/><input
                            type="radio" name="options[email_users]" value="0" checked="checked"/> Do NOT e-mail new
                        members.

                    </div>

                </div>


                <div class="field">

                    <label>Template</label>

                    <div class="field_entry">

                        <select name="options[email_template]">

                            <option value="">Default Template</option>

                            <?php

                            echo $admin->get_email_templates_type('template', '', '1');

                            ?>

                        </select>

                    </div>

                </div>


            </div>

        </fieldset>



    <?php

    }

    ?>


</div>



<?php

}
}

?>