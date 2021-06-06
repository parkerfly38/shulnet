<?php
include '../system.inc.php';
include 'functions.inc.php';

verifyAction('COPYDIR');
checkAccess('COPYDIR');

$path = trim(empty($_POST['d'])?'':$_POST['d']);
$newPath = trim(empty($_POST['n'])?'':$_POST['n']);
verifyPath($path);
verifyPath($newPath);

function copyDir($path, $newPath){
  $items = listDirectory($path);
  if(!is_dir($newPath))
    mkdir ($newPath, octdec(DIRPERMISSIONS));
  foreach ($items as $item){
    if($item == '.' || $item == '..')
      continue;
    $oldPath = AlphaManagerFile::FixPath($path.'/'.$item);
    $tmpNewPath = AlphaManagerFile::FixPath($newPath.'/'.$item);
    if(is_file($oldPath))
      copy($oldPath, $tmpNewPath);
    elseif(is_dir($oldPath)){
      copyDir($oldPath, $tmpNewPath);
    }
  }
}

if(is_dir(fixPath($path))){
  copyDir(fixPath($path.'/'), fixPath($newPath.'/'.basename($path)));
  echo getSuccessRes();
}
else
  echo getErrorRes(t('E_CopyDirInvalidPath'));
?>