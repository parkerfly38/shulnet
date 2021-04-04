<?php 

require "../../admin/sd-system/config.php";
if (!isset($_POST["id"]) || !isset($_POST["honoree"]))
{
    http_response_code(400);
} else {
    $updateLeyningSql = "UPDATE ppSD_leyning SET honoree = '".$_POST["honoree"]."' WHERE id = ".$_POST["id"];
    $db->update($updateLeyningSql);
}
?>