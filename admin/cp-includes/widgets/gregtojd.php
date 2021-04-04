<?php

include '../../sd-system/config.php';


$jewishdate = new jewishdates();
$datetoConvert = strtotime($_POST["englishDate"]);
$dateToShow = $jewishdate->getHebrewFromGregorian($datetoConvert);

echo $dateToShow["Hebrew Date English"];
?>