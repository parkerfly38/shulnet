<?php
include '../system.inc.php';
include 'functions.inc.php';

verifyAction('DOWNLOAD');
checkAccess('DOWNLOAD');

$path = trim($_GET['f']);
verifyPath($path);

if(is_file(fixPath($path))){
  $file = urldecode(basename($path));
  header('Content-Disposition: attachment; filename="'.$file.'"');
  header('Content-Type: application/force-download');
  readfile(fixPath($path));
}
?>