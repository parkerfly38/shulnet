<?php

header('Access-Control-Allow-Origin: *');

function checkAccess($action){
  if(!session_id())
    session_start();
}
?>