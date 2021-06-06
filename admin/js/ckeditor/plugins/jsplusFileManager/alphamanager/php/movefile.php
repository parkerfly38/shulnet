<?php
include '../system.inc.php';
include 'functions.inc.php';

verifyAction('MOVEFILE');
checkAccess('MOVEFILE');

$newPath = trim(empty($_POST['n'])?'':$_POST['n']);
verifyPath($newPath);

$files = $_POST['fs'];
for ($i=0; $i<count($files); $i++) {
    $path = $files[$i]['f'];
    verifyPath($path);

    $newFilePath = $newPath.'/'.basename($path);

    if(is_file(fixPath($path))){
      if (file_exists(fixPath($newFilePath))) {
        echo getErrorRes(t('E_MoveFileAlreadyExists').' '.basename($newFilePath));
        die;
      } elseif (!rename(fixPath($path), fixPath($newFilePath))) {
        echo getErrorRes(t('E_MoveFile').' '.basename($path));
        die;
      }
    } else {
      echo getErrorRes(t('E_MoveFileInvalisPath'));
      die;
    }

}

echo getSuccessRes();

?>