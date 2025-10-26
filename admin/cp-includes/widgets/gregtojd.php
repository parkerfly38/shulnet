<?php

include '../../sd-system/config.php';


$jewishdate = new jewishdates();
$datetoConvert = strtotime($_POST["englishDate"]);
$dateToShow = $jewishdate->getHebrewFromGregorian($datetoConvert);

echo substr($dateToShow["Hebrew Date English"], 0, -5);