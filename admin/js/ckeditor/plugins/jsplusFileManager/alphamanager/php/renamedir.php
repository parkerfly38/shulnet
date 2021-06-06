<?php
include '../system.inc.php';
include 'functions.inc.php';

verifyAction('RENAMEDIR');
checkAccess('RENAMEDIR');

$path = trim(empty($_POST['d'])? '': $_POST['d']);
$name = trim(empty($_POST['n'])? '': $_POST['n']);
verifyPath($path);

$newPath = dirname(fixPath($path)).'/'.$name;

if(is_dir(fixPath($path))){
  if(fixPath($path.'/') == fixPath(getFilesPath().'/'))
    echo getErrorRes(t('E_CannotRenameRoot'));
  else if (is_dir($newPath) || is_file($newPath) || is_link($newPath))
    echo getErrorRes(t('E_FileAlreadyExists'));
  else if (rename(fixPath($path), $newPath))
    echo getSuccessRes();
  else
    echo getErrorRes(t('E_RenameDir').' '.basename($path));
}
else
  echo getErrorRes(t('E_RenameDirInvalidPath'));
?>