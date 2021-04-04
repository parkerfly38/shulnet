<?php


if (!empty($_POST['label'])) {
    $label = $_POST['label'];

} else {
    $label = 'account_file';

}

if (!empty($_POST['permission'])) {
    $perm = $_POST['permission'];

} else {
    $perm = 'upload-note';

}

if (!empty($_POST['type'])) {
    $type = $_POST['type'];

} else {
    $type = 'contact';

}

if (empty($_POST['cp_only'])) {
    $cp_only = '0';
} else {
    if ($_POST['cp_only'] == '0') {
        $cp_only = '0';
    } else {
        $cp_only = '1';
    }
}

?>



<h1>Add Files</h1>


<div class="fullForm popupbody">



<?php


    echo "<p class=\"highlight\">";
    if ($cp_only != '1') {
        echo "This file will be accessible to the member from his/her membership management page.
        <br/>";
    }
    echo "<b>Important:</b> Make sure you select a label <u>before</u> uploading your file. <a href=\"http://documentation.zenbership.com/Uploads/Setting-Labels\" target=\"_blank\">Click here</a> for more information on labels.</p>";

    ?>


    <fieldset>
        <div class="pad24t">


            <div class="field">

                <label class="top">Select a Label</label>

                <div class="field_entry_top">

                    <input type="text" name="label_dud" id="flabel" value="<?php echo $label; ?>"
                           autocomplete="off" onkeyup="return autocom(this.id,'label','label','ppSD_uploads','label','uploads');"
                           style="width:250px;" class="req"/><a href="null.php"
                                                                onclick="return get_list('labels','flabel','flabel_id');"><img
                            src="imgs/icon-list.png" width="16" height="16" border="0" alt="Select from list"
                            title="Select from list" class="icon-right"/></a>

                    <input type="hidden" name="label" id="flabel_id" value="<?php echo $label; ?>"/>

                    <p class="field_desc" id="label_dud_dets">Select a label or "tag" for this upload, or create a new label by
                        typing your desired label above.</p>

                </div>

            </div>


            <div class="field">

                <label class="top">Files</label>

                <script type="text/javascript" src="js/jquery.fileuploader.js"></script>

                <script type="text/javascript">

                    $(document).ready(function () {
                        var uploader = new qq.FileUploader({

                            element: document.getElementById('fileuploader'),
                            action: 'cp-functions/upload.php',
                            debug: true,
                            params: {

                                type: '<?php echo $type; ?>',
                                id: '<?php echo $_POST['item_id']; ?>',
                                permission: '<?php echo $perm; ?>',
                                label: '<?php echo $label; ?>',
                                scope: '<?php echo $cp_only; ?>' // 1 = admin cp only, 0 = user page as well
                            }

                        });

                        $('#flabel').on('blur', function(){
                            uploader._options.params.label = $('#flabel').val();
                        });

                    });


                </script>

                <p>Drag and drop files here to attach them to this item.</p>

                <div id="fileuploader">

                    <noscript><p>Please enable JavaScript to use file uploader.</p></noscript>

                </div>

            </div>

        </div>
    </fieldset>

</div>