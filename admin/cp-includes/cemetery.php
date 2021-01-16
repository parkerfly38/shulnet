<?php

$permission = 'cemetery';
$check = $admin->check_permissions('cemetery', $employee);
if ($check != '1') {
    $admin->show_no_permissions();

} else {
    //get cemeteries
    $cemetery = new cemetery;
    $stuff = $cemetery->get_cemeteries();
    ?>
    <div id="topblue" class="fonts small">
        <div class="holder">
            <div class="floatright" id="tb_right">&nbsp;</div>
            <div class="floatleft" id="tb_left"><span><strong>Cemetery Module</strong></div>
        </div>
    </div>
    <div id="mainsection">
        <div class="nontable_section">
        <?php print_r($stuff); ?>
        </div>
    </div>
<?php
}
?>