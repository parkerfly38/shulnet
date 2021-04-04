<?php 


$permission = 'today';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $admin->show_no_permissions();
} else {

?>


<div id="topblue" class="fonts small">
    <div class="holder">
        <div class="floatright" id="tb_right">
            <?php
            echo '<span><a href="' . $nextprev['prev_link'] . '">' . $nextprev['prev_month'] . '</a></span>';
            echo '<span class="div"></span>';
            echo '<span><b>' . $nextprev['title'] . '</b></span>';
            echo '<span class="div"></span>';
            echo '<span><a href="' . $nextprev['next_link'] . '">' . $nextprev['next_month'] . '</a></span>';
            ?>
        </div>
        <div class="floatleft" id="tb_left">
            <b>Daily Planner</b>
            <?php
            include PP_PATH . "/admin/cp-includes/user_link_menu.php";
            ?>
        </div>
        <div class="clear"></div>
    </div>
</div>

<link rel="stylesheet" type="text/css" media="all" href="css/calendar.css"/>
<div id="mainsection">
    <div class="nontable_section">
        <div class="pad24">
            <h1>Daily Planner (<?php echo $nextprev['title']; ?>)</h1>
            <div class="nontable_section_inner">
                <div class="col66l"><div class="pad24_fs_l">
                    <?php

                    ?>
                </div></div>
                <div class="col33r"><div class="pad24_fs_r">
                    <h2>Notes</h2>
                    <?php

                    ?>
                </div></div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>

<?php
}
?>