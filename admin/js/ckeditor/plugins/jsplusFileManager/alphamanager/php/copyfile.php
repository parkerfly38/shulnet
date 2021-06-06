<?php
include '../system.inc.php';
include 'functions.inc.php';

verifyAction('COPYFILE');
checkAccess('COPYFILE');

$newPath = trim(empty($_POST['n'])?'':$_POST['n']);
verifyPath($newPath);

$files = $_POST['fs'];
for ($i=0; $i<count($files); $i++) {
    $path = $files[$i]['f'];
    verifyPath($path);

    if(is_file(fixPath($path))){

      $newFilePath = $newPath.'/'.AlphaManagerFile::MakeUniqueFilename(fixPath($newPath), basename($path));

      if(!copy(fixPath($path), fixPath($newFilePath))) {
        echo getErrorRes(t('E_CopyFile'));
        die;
      }
    } else {
      echo getErrorRes(t('E_CopyFileInvalisPath'));
      die;
    }
}

echo getSuccessRes();


?>