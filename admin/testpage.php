<?php
   
require "sd-system/config.php";
$version = $db->get_option('current_version');

$thing = $db->check_password('NUgget38!@','aO&C','be5dc705dd66d8f522e5e772dd91f09cd7c87995');
print_r($thing);
?>