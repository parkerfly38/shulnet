<?php
include '../system.inc.php';
include 'functions.inc.php';

verifyAction('MOVEDIR');
checkAccess('MOVEDIR');

$path = trim(empty($_POST['d'])?'':$_POST['d']);
$newPath = trim(empty($_POST['n'])?'':$_POST['n']);

verifyPath($path);
verifyPath($newPath);

if(is_dir(fixPath($path))){
  if(mb_strpos($newPath, $path) === 0)
    echo getErrorRes(t('E_CannotMoveDirToChild'));
  elseif(file_exists(fixPath($newPath).'/'.basename($path)))
    echo getErrorRes(t('E_DirAlreadyExists'));
  elseif(rename(fixPath($path), fixPath($newPath).'/'.basename($path)))
    echo getSuccessRes();
  else
    echo getErrorRes(t('E_MoveDir').' '.basename($path));
}
else
  echo getErrorRes(t('E_MoveDirInvalisPath'));
?>