<?php
header('Content-Type: text/html; charset=utf-8');
require "admin/sd-system/config.php";

$jewishdate = new jewishdates();
$dateToShow = $jewishdate->getHebrewFromGregorian(time());

print_r($dateToShow);
?>