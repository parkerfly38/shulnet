<?php
include '../system.inc.php';
include 'functions.inc.php';
@ini_set('memory_limit', -1);
verifyAction('DOWNLOADDIR');
checkAccess('DOWNLOADDIR');

$path = trim($_GET['d']);
verifyPath($path);
$path = fixPath($path);

if(!class_exists('ZipArchive')){
  echo '<script>alert("Cannot create zip archive - ZipArchive class is missing. Check your PHP version and configuration");</script>';
}
else{
  try{
    $filename = basename($path);
    $zipFile = $filename.'.zip';
    $zipPath = BASE_PATH.'/tmp/'.$zipFile;
    AlphaManagerFile::ZipDir($path, $zipPath);

    header('Content-Disposition: attachment; filename="'.$zipFile.'"');
    header('Content-Type: application/force-download');
    readfile($zipPath);
    function deleteTmp($zipPath){
      @unlink($zipPath);
    }
    register_shutdown_function('deleteTmp', $zipPath);
  }
  catch(Exception $ex){
    echo '<script>alert("'.  addcslashes(t('E_CreateArchive'), '"\\').'");</script>';
  }
}
?>