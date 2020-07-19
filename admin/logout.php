<?php

   
require "sd-system/config.php";
$admin = new admin;
$admin->end_session();
header("Location: " . PP_ADMIN . "/login.php?notice=2");
exit;