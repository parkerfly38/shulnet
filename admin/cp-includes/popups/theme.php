<?php
?>

<div id="popupsave">

    <input type="button" value="Get More Themes" class="save" onclick="return switch_popup('extension_store','','1');"/>

</div>

<h1>Theme Manager</h1>


<div class="popupbody">


    <?php



    if (empty($_POST['type'])) {
        $_POST['type'] = 'html';

    }


    $q1 = $db->run_query("

        SELECT *

        FROM `ppSD_themes`

        WHERE `type`='" . $db->mysql_clean($_POST['type']) . "'

        ORDER BY `active` DESC, `name` ASC

    ");

    while ($row = $q1->fetch()) {
        $theme        = PP_URL . '/pp-templates/' . $_POST['type'] . '/' . $row['id'];
        $row['img_1'] = str_replace('%theme%', $theme, $row['img_1']);
        $row['img_2'] = str_replace('%theme%', $theme, $row['img_2']);



        ?>



        <div class="popup_full_section <?php if ($row['active'] == '1') {
            echo "active";
        } ?>" id="theme-<?php echo $row['id']; ?>">

            <div class="popup_h4_right">&nbsp;</div>

            <h4><?php echo $row['name']; ?></h4>

            <div class="pad24">

                <div class="floatright" style="width:200px;margin:0 0 24px 24px;text-align: center;">

                    <input type="button" value="Select This Theme"
                           onclick="return pick_theme('<?php echo $_POST['type']; ?>','<?php echo $row['id']; ?>');"/>

                    <a href="<?php echo $row['img_1']; ?>" target="_blank"><img src="<?php echo $row['img_1']; ?>"
                                                                                width="200" height="150" border="0"
                                                                                alt="<?php echo $row['name']; ?>"
                                                                                title="<?php echo $row['name']; ?>"
                                                                                class="theme_preview"/></a>

                </div>

                <dl>

                    <dt>Style</dt>

                    <dd><?php echo $row['style']; ?></dd>

                    <dt>Description</dt>

                    <dd><?php echo $row['description']; ?></dd>

                    <dt>Author</dt>

                    <dd><a href="<?php echo $row['author_url']; ?>" target="_blank"><?php echo $row['author']; ?></a>
                    </dd>

                </dl>

                <div class="clear"></div>

            </div>

        </div>



    <?php

    }

    ?>


</div>