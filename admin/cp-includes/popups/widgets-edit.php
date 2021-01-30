<?php

if (!empty($_POST['id'])) {

    $show          = 1;
    $widget        = $db->widget_data($_POST['id'], '1');
    $name          = $widget['name'];
    $active        = $widget['active'];
    $final_content = $widget['content'];
    $options       = $widget['options'];
    $cid           = $_POST['id'];
    $editing       = '1';

}
if ($show == '1') {
    ?>



    <script type="text/javascript">
        $.ctrl('S', function () {
            return json_add('widget-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
        });
    </script>



    <form action="" method="post" id="popupform"
          onsubmit="return json_add('widget-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">


        <div id="popupsave">

            <input type="submit" value="Save" class="save"/>

            <input type="hidden" name="id" value="<?php echo $cid; ?>"/>

        </div>

        <h1><?php echo $name; ?></h1>


        <ul id="theStepList">

            <li class="on" onclick="return goToStep('0');">Overview</li>

            <li onclick="return goToStep('1');">Settings</li>

            <li onclick="return goToStep('2');">Inclusion Code</li>

        </ul>


        <div class="fullForm popupbody">

            <ul id="formlist">

                <li class="form_step">

                    <fieldset><div class="pad24t">

                    <div class="field">

                        <label class="less">Active</label>

                        <div class="field_entry_less">

                            <input type="radio" name="active" value="1" <?php if ($active == '1') {
                                echo " checked=\"checked\"";
                            } ?> /> Active <input type="radio" name="active" value="0" <?php if ($active != '1') {
                                echo " checked=\"checked\"";
                            } ?> /> Inactive

                        </div>

                    </div>


                    <div class="field">

                        <label class="less">Name</label>

                        <div class="field_entry_less">

                            <input type="text" name="name" id="name" value="<?php echo $name; ?>" class="req"
                                   style="width:300px;"/>

                        </div>

                    </div>



                    <?php





                    if ($widget['type'] == 'html') {
                        ?>

                        <div class="field">

                            <textarea name="content" id="content"
                                      style="width:100%;height:500px;"><?php echo $final_content; ?></textarea>

                        </div>

                        <?php

                        echo $admin->richtext('100%', '500px', 'content');

                    }

                    ?>


                            </div></fieldset>
                </li>

                <li class="form_step">

                    <fieldset><div class="pad24t">

                    <ul class="option_editor">

                        <?php

                        echo $widget['options'];

                        ?>

                    </ul>

</div></fieldset>
                </li>

                <li class="form_step">

                    <fieldset><div class="pad24t">

                    <p class="highlight">Place the following caller tag on any template or page to make it appear on
                        your website.</p>

                    <p class="code">{-<?php echo $cid; ?>-}</p>

                            </div></fieldset>

                </li>

            </ul>

        </div>


    </form>

    <script src="js/form_rotator.js" type="text/javascript"></script>



<?php

}

if ($widget['type'] == 'menu') {
?>

    <script type="text/javascript">
        switch_popup('menu-add', 'id=<?php echo $_POST['id']; ?>', '0');
    </script>

<?php
}

?>