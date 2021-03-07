<?php

$permission = 'gabbaim';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $admin->show_no_permissions();
} else {
    
    if(!isset($_POST["year"]))
    {
?>

<div id="mainsection">

<div class="nontable_section">
    <div class="pad24">
        <h1 style="text-align: center;">Update Aliyot and Kibbudim Calendar</h1>
        <form method="post" action="index.php?l=updateluach">
        <label>Select a year to update:</label>
        <select name="year" id="year">
            <?php
                echo "<option>".date("Y")."</option>";
                echo "<option>".(date("Y")+1)."</option>";
                echo "<option>".(date("Y")+2)."</option>";
                echo "<option>".(date("Y")+3)."</option>";
                echo "<option>".(date("Y")+4)."</option>";
            ?>
        </select>
        <p><strong>WARNING: </strong>This will reset all aliyot and kibbudim you have scheduled for the Gregorian calendar yeat.</p>
        <input type="submit" value="Update Year" />
        </form>
    </div>
</div>
</div>

<?php
    } else {
    
        $year = $_POST["year"];
    $calendarjson = file_get_contents("https://www.hebcal.com/hebcal?v=1&cfg=json&maj=on&min=on&mod=on&nx=on&year=".$year."&month=x&ss=on&mf=on&c=on&geo=Bangor&geonameid=4957280&m=50&s=on");

    $calendarjson = json_decode($calendarjson, TRUE);
    $db->run_query("DELETE FROM ppSD_leyning WHERE parashat_id IN (SELECT id FROM ppSD_parashat WHERE YEAR(parsha_date) = ".$year.")");
    $db->run_query("DELETE FROM ppSD_parashat WHERE YEAR(parsha_date) = ".$year);

    $triennialYN = $db->get_option("triennial");

    foreach($calendarjson['items'] as $item)
    {
        if ($item["category"] === 'parashat')
        {
            $insertSQL = "INSERT INTO ppSD_parashat (parsha_date, title, category)
                VALUES('".$item["date"]."','".$item["title"]."','".$item["category"]."')";
            $newid = $db->insert($insertSQL);
            if ($triennialYN === 'Yes')
            {
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'1st Aliyah - ".$item["leyning"]["triennial"]["1"]."')";
                $db->insert($insertLeyningSql);
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'2nd Aliyah - ".$item["leyning"]["triennial"]["2"]."')";
                $db->insert($insertLeyningSql);
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'3rd Aliyah - ".$item["leyning"]["triennial"]["3"]."')";
                $db->insert($insertLeyningSql);
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'4th Aliyah - ".$item["leyning"]["triennial"]["4"]."')";
                $db->insert($insertLeyningSql);
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'5th Aliyah - ".$item["leyning"]["triennial"]["5"]."')";
                $db->insert($insertLeyningSql);
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'6th Aliyah - ".$item["leyning"]["triennial"]["6"]."')";
                $db->insert($insertLeyningSql);
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'7th Aliyah - ".$item["leyning"]["triennial"]["7"]."')";
                $db->insert($insertLeyningSql);
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'Maftir - ".$item["leyning"]["triennial"]["maftir"]."')";
                $db->insert($insertLeyningSql);
            } else {
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'1st Aliyah - ".$item["leyning"]["1"]."')";
                $db->insert($insertLeyningSql);
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'2nd Aliyah - ".$item["leyning"]["2"]."')";
                $db->insert($insertLeyningSql);
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'3rd Aliyah - ".$item["leyning"]["3"]."')";
                $db->insert($insertLeyningSql);
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'4th Aliyah - ".$item["leyning"]["4"]."')";
                $db->insert($insertLeyningSql);
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'5th Aliyah - ".$item["leyning"]["5"]."')";
                $db->insert($insertLeyningSql);
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'6th Aliyah - ".$item["leyning"]["6"]."')";
                $db->insert($insertLeyningSql);
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'7th Aliyah - ".$item["leyning"]["7"]."')";
                $db->insert($insertLeyningSql);
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'Maftir - ".$item["leyning"]["maftir"]."')";
                $db->insert($insertLeyningSql);
            }
            $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'Haftarah - ".$item["leyning"]["haftarah"]."')";
            $db->insert($insertLeyningSql);
            $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'Baal Keriah')";
            $db->insert($insertLeyningSql);
        }
        $yomtov = array_key_exists('yomtov', $item) ? $item["yomtov"] : false;
        if ($item["category"] === 'holiday' && $yomtov)
        {
            $insertSQL = "INSERT INTO ppSD_parashat (parsha_date, title, category)
                VALUES('".$item["date"]."','".$item["title"]."','".$item["category"]."')";
            $newid = $db->insert($insertSQL);
            $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'1st Aliyah - ".$item["leyning"]["1"]."')";
            $db->insert($insertLeyningSql);
            $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'2nd Aliyah - ".$item["leyning"]["2"]."')";
            $db->insert($insertLeyningSql);
            $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'3rd Aliyah - ".$item["leyning"]["3"]."')";
            $db->insert($insertLeyningSql);
            $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'4th Aliyah - ".$item["leyning"]["4"]."')";
            $db->insert($insertLeyningSql);
            $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'5th Aliyah - ".$item["leyning"]["5"]."')";
            $db->insert($insertLeyningSql);
            if (array_key_exists('6',$item["leyning"]))
            {
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'6th Aliyah - ".$item["leyning"]["6"]."')";
                $db->insert($insertLeyningSql);
            }
            if (array_key_exists('7',$item["leyning"]))
            {
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'7th Aliyah - ".$item["leyning"]["7"]."')";
                $db->insert($insertLeyningSql);
            }
            $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'Maftir - ".$item["leyning"]["maftir"]."')";
            $db->insert($insertLeyningSql);
            $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'Haftarah - ".$item["leyning"]["haftarah"]."')";
            $db->insert($insertLeyningSql);
            $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'Baal Keriah')";
            $db->insert($insertLeyningSql);
        }
        $leyning = array_key_exists('leyning',$item) ? true : false;
        if ($item["category"] === "holiday" && $leyning && !$yomtov)
        {
            $insertSQL = "INSERT INTO ppSD_parashat (parsha_date, title, category)
                VALUES('".$item["date"]."','".$item["title"]."','".$item["category"]."')";
            $newid = $db->insert($insertSQL);
            if (array_key_exists('1',$item["leyning"]))
            {
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'1st Aliyah - ".$item["leyning"]["1"]."')";
                $db->insert($insertLeyningSql);
            }
            if (array_key_exists('2',$item["leyning"]))
            {
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'2nd Aliyah - ".$item["leyning"]["2"]."')";
                $db->insert($insertLeyningSql);
            }
            if (array_key_exists('3',$item["leyning"]))
            {
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'3rd Aliyah - ".$item["leyning"]["3"]."')";
                $db->insert($insertLeyningSql);
            }
            if (array_key_exists('4', $item["leyning"]))
            {
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'4th Aliyah - ".$item["leyning"]["4"]."')";
                $db->insert($insertLeyningSql);
            }
            if (array_key_exists('5', $item["leyning"]))
            {
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'5th Aliyah - ".$item["leyning"]["5"]."')";
                $db->insert($insertLeyningSql);
            }
            if (array_key_exists('6',$item["leyning"]))
            {
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'6th Aliyah - ".$item["leyning"]["6"]."')";
                $db->insert($insertLeyningSql);
            }
            if (array_key_exists('7',$item["leyning"]))
            {
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'7th Aliyah - ".$item["leyning"]["7"]."')";
                $db->insert($insertLeyningSql);
            }
            if (array_key_exists('maftir',$item["leyning"]))
            {
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'Maftir - ".$item["leyning"]["maftir"]."')";
                $db->insert($insertLeyningSql);
            }
            if (array_key_exists('haftarah',$item["leyning"]))
            {
                $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'Haftarah - ".$item["leyning"]["haftarah"]."')";
                $db->insert($insertLeyningSql);
            }
            $insertLeyningSql = "INSERT INTO ppSD_leyning (parashat_id, honor) VALUES (".$newid.",'Baal Keriah')";
            $db->insert($insertLeyningSql);
        }
    }
}
}
?>