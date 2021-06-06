<?php
include '../system.inc.php';
include 'functions.inc.php';

verifyAction('DELETEFILE');
checkAccess('DELETEFILE');

$files = $_POST['fs'];
for ($i=0; $i<count($files); $i++) {

    $path = $files[$i]['f'];
    verifyPath($path);

    if(is_file(fixPath($path))){
      if(!unlink(fixPath($path))) {
        echo getErrorRes(t('E_DeletеFile').' '.basename($path));
        die;
      }
    }
    else {
      echo getErrorRes(t('E_DeleteFileInvalidPath'.' '.$path));
      die;
    }
}

echo getSuccessRes();

?>