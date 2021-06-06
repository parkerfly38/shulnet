<?php
include '../system.inc.php';
include 'functions.inc.php';

verifyAction('CREATEDIR');
checkAccess('CREATEDIR');

$path = trim(empty($_POST['d'])?'':$_POST['d']);
$name = trim(empty($_POST['n'])?'':$_POST['n']);
verifyPath($path);

if(is_dir(fixPath($path))){
  if(mkdir(fixPath($path).'/'.$name, octdec(DIRPERMISSIONS)))
    echo getSuccessRes();
  else
    echo getErrorRes(t('E_CreateDirFailed').' '.basename($name));
}
else
  echo  getErrorRes(t('E_CreateDirInvalidPath'));
?>