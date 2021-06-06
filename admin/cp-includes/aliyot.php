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

<link rel="stylesheet" type="text/css" href="css/print.min.css" />
<script src="js/print.min.js" type="text/javascript"></script>
<div id="topblue" class="fonts small">
            <div class="holder">

                <div class="floatright" id="tb_right">
                <div class="floatleft">
                <form id="prevform" method="post" action="index.php?l=aliyot">
                    <input type="hidden" name="previd" id="previd" value="<?php echo $arrEvents[0]["id"]; ?>" />
                    <input type="hidden" name="parsha_date" id="parsha_date" value="<?php echo $arrEvents[0]["parsha_date"]; ?>" />
                    <a href="javascript:jQuery('#prevform').submit();">&lt;&lt; Previous Event</a>
                </form>
                </div>
                <div class="floatright">
                <form id="nextform" method="post" action="index.php?l=aliyot">
                    <input type="hidden" name="nextid" id="nextid" value="<?php echo $arrEvents[0]["id"]; ?>" />
                    <input type="hidden" name="parsha_date" id="parsha_date" value="<?php echo $arrEvents[0]["parsha_date"]; ?>" />
                    <span class="div">|</span><a href="javascript:jQuery('#nextform').submit();">Next Event &gt;&gt;</a>
                </form>
                </div>
                </div>

                <div class="floatleft" id="tb_left">

                    <span><b>Assign Aliyot and Kibbudim</b></span>

                    <span class="div">|</span>

                    <?php echo "<span>" . $arrEvents[0]["title"]." - ".date("D, M j Y",strtotime($arrEvents[0]["parsha_date"]))."</span>"; ?>

                    <span class="div">|</span>

			<span id="innerLinks">

				<a href="javascript: printCard();">Print Gabbai Card</a>

			</span>

                </div>

                <div class="clear"></div>

            </div>
        </div>
<div id="mainsection">

            <?php
                foreach ($arrEvents as $event)
                {
                    echo "<table id='aliyotTable' class='tablesorter listings' border=0>";
                    $getAssignmentsSql = "SELECT a.*, CONCAT(b.first_name,' ', b.last_name) AS `honoreename` FROM ppSD_leyning a LEFT JOIN ppSD_member_data b ON a.honoree = b.member_id WHERE parashat_id = ".$event["id"];
                    $arrLeyning = $db->run_query($getAssignmentsSql,0)->fetchAll();
                    echo "<thead><tr><th>Aliyah/Honor</th><th>Oleh</th><th></th></tr></thead>";
                    echo "<tbody>";
                    foreach($arrLeyning as $leyning)
                    {
                        echo "<tr><td>".$leyning["honor"]."</td>";
                        ?>
                            <td><input type="text" id="honoreeid_<?php echo $leyning["id"]; ?>" name="master_user_dud" value="<?php echo $leyning['honoreename']; ?>"
                                       onkeyup="return autocom(this.id,'member_id','first_name,last_name','ppSD_member_data','first_name,last_name','members');"
                                       value="" style="width:250px;"/><a href="null.php"
                                                                         onclick="return get_list('members_withnames','honoreeid_id<?php echo $leyning["id"]; ?>','honoreeid_<?php echo $leyning["id"]; ?>');"><img
                                        src="imgs/icon-list.png" width="16" height="16" border="0"
                                        alt="Select from list" title="Select from list" class="icon-right"/></a>

                                <input type="hidden" class="honoreeid_id" name="honoreeid" id="honoreeid_id<?php echo $leyning["id"]; ?>" value="<?php echo $leyning['honoree']; ?>"/>
                                <input type="hidden" name="leyning_id" id="leyning_id" value="<?php echo $leyning["id"]; ?>" />
                            </td>
                                
                        <?php
                        echo "<td><input type='button' id='save' class='saveButton' value='Save' /></td></tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                }
            ?>
</div>
<div id="printableArea" style="display:none;"></div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $(".saveButton").on("click",function()
        {
            id = $(this).parent().parent().find("#leyning_id").val();
            honoree = $(this).parent().parent().find(".honoreeid_id").val();
            $.ajax({
                url: "../admin/cp-includes/save_aliyot.php",
                type: "POST",
                data: "id="+id+"&honoree="+honoree
            }).error(function() {
                alert("There was a problem saving this aliyah.");
            }).done(function(){

            });
        });
    });
    function printCard()
    {
        let rawHtml = "<div id='printableArea2'><h1>Gabbai Card for <?php echo $arrEvents[0]["title"]." - ".date("D, M j Y",strtotime($arrEvents[0]["parsha_date"]));?></h1>";
        rawHtml += "<table border='0' cellpadding='5' cellspacing='5'>";
        rawHtml += "<thead><tr><th>Portion/Role</th><th>Honoree</th></tr></thead>";
        rawHtml += "<tbody>";
        $('#aliyotTable tbody tr').each(function(){
            rawHtml += "<tr><td>" + $(this).find('td').eq(0).html() + "</td>";
            rawHtml += "<td>" + $(this).find('td').eq(1).find('input').eq(0).val() + "</td></tr>";
        })
        rawHtml += "</tr></tbody></table>";
        $("#printableArea").html(rawHtml);
        printJS({ type: "html", printable: 'printableArea2'});
    }
</script>
<?php } ?>