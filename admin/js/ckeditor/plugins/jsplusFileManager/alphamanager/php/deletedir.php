<?php
include '../system.inc.php';
include 'functions.inc.php';

verifyAction('DELETEDIR');
checkAccess('DELETEDIR');

$path = trim(empty($_POST['d'])?'':$_POST['d']);
verifyPath($path);

function delDir($path) {
    if (is_dir($path) === true) {
        $files = scandir($path);
        for ($i = 0; $i<count($files); $i++)
            if ($files[$i] != '.' && $files[$i] != '..') {
                if (delDir($path . '/' . $files[$i]) != null)
                    return $path . '/' . $files[$i];
            }
        return rmdir($path) ? null : $path;
    } else if (is_file($path) === true || is_link($path) === true) {
        return unlink($path) ? null : $path;
    }
    return "?";
}

if(is_dir(fixPath($path))){
  if(fixPath($path.'/') == fixPath(getFilesPath().'/'))
    echo getErrorRes(t('E_CannotDeleteRoot'));
  else {
    $res = delDir(fixPath($path));
    if ($res == null)
        echo getSuccessRes();
    else
        echo getErrorRes(t('E_CannotDeleteDir').' '.basename($res));
  }
}
else
  echo getErrorRes(t('E_DeleteDirInvalidPath').' '.$path);
?>