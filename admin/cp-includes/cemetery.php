<?php

$permission = 'cemetery';
$check = $admin->check_permissions('cemetery', $employee);
if ($check != '1') {
    $admin->show_no_permissions();

} else {
    //get cemeteries
    $cemetery = new cemetery;
    $cemeteries = $cemetery->get_cemeteries();
    ?>
    <div id="topblue" class="fonts small">
        <div class="holder">
            <div class="floatright" id="tb_right">&nbsp;</div>
            <div class="floatleft" id="tb_left"><span><strong>Cemetery Module</strong></div>
        </div>
    </div>
    <div id="mainsection">
        <div class="nontable_section">
            <div class="col50">
            <fieldset>

            <legend><?php echo $cemeteries[0]["CemeteryName"]; ?></legend>

            <div class="pad24t">
            <?php
            //render first or selected cemetery
            //echo $cemeteries[0]["CemeteryName"];
            //if (strlen($cemeteries[0]["MapsPlusCode"]) > 0)
            //{ 
            //    echo generate_map_code($cemeteries[0]["StreetAddress"],'100%','400');
            //} else {
                echo generate_map_latlong($cemeteries[0]["Latitude"],$cemeteries[0]["Longitude"]);
            //}
            ?>
            </div>
            </div>

        </div>
    </div>
<?php
}
?>