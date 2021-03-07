<?php
$permission = 'gabbaim';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $admin->show_no_permissions();

} else {
    //get the closest events to our date
    if(isset($_POST["nextid"]) || isset($_POST["previd"]))
    {
        $selectEventSql = "SELECT * from ppSD_parashat ";
        if (isset($_POST["previd"]))
        {
            $selectEventSql .= "WHERE date(parsha_date) = (select max(date(parsha_date)) FROM ppSD_parashat
            WHERE id ";
        }
        if (isset($_POST["nextid"]))
        {
            $selectEventSql .= "WHERE date(parsha_date) = (select min(date(parsha_date)) FROM ppSD_parashat
            WHERE id ";
        }
        if (isset($_POST["nextid"]))
        {
            $selectEventSql .= "> ".$_POST["nextid"]." ";
        }
        if (isset($_POST["previd"]))
        {
            $selectEventSql .= "< ".$_POST["previd"]." ";
        }
        $selectEventSql .= "AND date(parsha_date) <> date('".$_POST["parsha_date"]."'));";
        $arrEvents = $db->run_query($selectEventSql)->fetchAll();
    } else {
        $selectEventSql = "SELECT * from ppSD_parashat
            WHERE date(parsha_date) = (select min(date(parsha_date)) FROM ppSD_parashat WHERE date(parsha_date) > date(now()));";
        $arrEvents = $db->run_query($selectEventSql,0)->fetchAll();
    }
?>
<div id="mainsection">

<div class="nontable_section">
    <div class="pad24">
            <div style="float:left;">
                <form method="post" action="index.php?l=aliyot">
                    <input type="hidden" name="previd" id="previd" value="<?php echo $arrEvents[0]["id"]; ?>" />
                    <input type="hidden" name="parsha_date" id="parsha_date" value="<?php echo $arrEvents[0]["parsha_date"]; ?>" />
                    <input type="submit" value="<< Previous Event" />
                </form>
            </div>
            <div style="float:right;">
                <form method="post" action="index.php?l=aliyot">
                    <input type="hidden" name="nextid" id="nextid" value="<?php echo $arrEvents[0]["id"]; ?>" />
                    <input type="hidden" name="parsha_date" id="parsha_date" value="<?php echo $arrEvents[0]["parsha_date"]; ?>" />
                    <input type="submit" value="Next Event >>" />
                </form>
            </div>
            <div style="clear: both;"></div>
            <h1 style="text-align: center;">Assign Aliyot and Kibbudim</h1>
            <?php
                foreach ($arrEvents as $event)
                {
                    echo "<h2 style='margin-top:20px;'>".$event["title"]." - ".date("D, M j Y",strtotime($event["parsha_date"]))."</h2>";
                    
                    echo "<table class='listings'>";
                    $getAssignmentsSql = "SELECT * FROM ppSD_leyning WHERE parashat_id = ".$event["id"];
                    $arrLeyning = $db->run_query($getAssignmentsSql,0)->fetchAll();
                    echo "<thead><tr><th>Aliyah/Honor</th><th>Oleh</th><th></th></tr></thead>";
                    echo "<tbody>";
                    foreach($arrLeyning as $leyning)
                    {
                        echo "<tr><td>".$leyning["honor"]."</td>";
                        echo "<td><input type='text' id='honoree".$leyning["id"]."' value='".$leyning["honoree"]."' /></td>";
                        echo "<td><input type='button' id='save' class='saveButton' value='Save' /></td></tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                }
            ?>
    </div>
</div>
</div>

<?php } ?>