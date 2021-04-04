<?php 

/**
 */

$type = 'folder';

if (!empty($_POST['id'])) {
    $content = new content;
    $data    = $content->get_content($_POST['id']);
    if ($data['error'] == '1') {
        $admin->show_popup_error($data['error_details']);
        exit;

    } else {
        $cid     = $_POST['id'];
        $editing = '1';

    }

} else {
    $temp_data = '';
    $data      = array(
        'name'            => '',
        'menus'           => array(),
        'fieldsets'       => array(),
        'url'             => PP_URL,
        'path'            => PP_BASE_PATH,
        'permalink'       => '',
        'permalink_clean' => '',
        'full_link'       => PP_URL,
    );
    $cid       = 'new';
    $editing   = '0';

}

?>

<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('content-folder-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('content-folder-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">

    <div id="popupsave">
        <?php
        if (! empty($_POST['id'])) {
            ?>
            <input type="submit" value="Grant Access From Criteria" onclick="return switch_popup('build_criteria','type=member&act=content_access&act_id=<?php echo $cid; ?>','');" />
        <?php
        }
        ?>
        <input type="submit" value="Save" class="save" />
        <input type="hidden" name="type" value="<?php echo $type; ?>" />
    </div>

    <h1>Folder Security Management</h1>

    <div class="popupbody fullForm">

        <script src="<?php echo PP_ADMIN; ?>/js/form_steps.js" type="text/javascript"></script>
        <ul id="step_tabs" class="popup_tabs">
            <li class="on">
                Folder Basics
            </li><li>
                Fieldsets &amp; Menus
            </li>
        </ul>

        <div id="step_1" class="step_form fullForm">

            <p class="highlight">A secure folder is a physical folder on your server that will be off limits to non-members. This is different from a section in that a secure folder is outside the scope of Zenbership, Zenbership just secures it and manages access to it, but doesn't control its content.</p>

            <div class="col50l">
                <fieldset>
                    <div class="pad">

                        <label>What should this content be called?</label>
                        <?php
                        echo $af
                            ->setDescription('This is how it will appear to members in their content list.')
                            ->string('name', $data['name'], 'req');
                        ?>

                    </div>
                </fieldset>
            </div>
            <div class="col50r">
                <fieldset>
                    <div class="pad">

                        <label>What is the path on your server to the folder (not a file)?</label>
                        <?php
                        echo $af
                            ->setAutocomplete(false)
                            ->setId('path')
                            ->string('path', $data['path'], 'req');
                        ?>
                        <p class="field_desc" id="preview_path"></p>
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#path').keyup(function() {
                                    return check_folder();
                                });
                            });
                        </script>

                        <label>What should the start page be for this content?</label>
                        <?php
                        echo $af
                            ->setDescription('The URL to which users will be redirected when they click on this
                                        content from the member management page. Format:<br/>
                                        http://www.yoursite.com/path/to/secure/folder/start_page.php')
                            ->setPlaceholder('http://www.yoursite.com/path/to/secure/folder/start_page.php')
                            ->string('url', $data['url'], 'req');
                        ?>

                    </div>
                </fieldset>

            </div>
            <div class="clear"></div>

        </div>
        <div id="step_2" class="step_form">

            <p class="highlight">These options allow you to customize what fields are associated with content access as well as what menus this content will appear on within the CMS.</p>

            <div class="col50l">
                <fieldset>
                    <div class="pad">

                        <label>What fieldsets should any member with access to this content be able to edit from their "Update Account" page?</label>

                        <?php
                        echo $admin->get_fieldsets($data['fieldsets']);
                        ?>

                    </div>
                </fieldset>
            </div>
            <div class="col50r">
                <fieldset>
                    <div class="pad">

                        <label class="margintop">What menus should this content appear on?</label>
                        <?php
                        echo $admin->get_menus($data['menus']);
                        ?>

                    </div>
                </fieldset>
            </div>
            <div class="clear"></div>

        </div>

    </div>

</form>


<script type="text/javascript">

    function check_folder() {
        send_data = 'path=' + $('#path').val();
        $.post('cp-functions/check_folder.php', send_data, function (theResponse) {
            $('#preview_path').html(theResponse);
        });
        return false;
    }

</script>