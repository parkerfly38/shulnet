<?php
    require "../sd-system/config.php";  
    $data = array($_POST);
    $yz = new yahrzeits;
    $yz->create_yahrzeit_relationship($data[0]);
    $return                = array();
    $return['close_popup'] = '1'; // For quick add
    echo "1+++" . json_encode($return);
    exit;
?>