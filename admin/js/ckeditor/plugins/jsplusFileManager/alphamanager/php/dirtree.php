<?php
include '../system.inc.php';
include 'functions.inc.php';

verifyAction('DIRLIST');
checkAccess('DIRLIST');

function getFilesNumber($path, $type){
  $files = 0;
  $dirs = 0;
  $tmp = listDirectory($path);
  foreach ($tmp as $ff){
    if($ff == '.' || $ff == '..')
      continue;
    elseif(is_file($path.'/'.$ff) && ($type == '' || ($type == 'image' && AlphaManagerFile::IsImage($ff)) || ($type == 'flash' && AlphaManagerFile::IsFlash($ff))))
      $files++;
    elseif(is_dir($path.'/'.$ff))
      $dirs++;
  }

  return array('files'=>$files, 'dirs'=>$dirs);
}
function GetDirs($path, $type){
  $ret = $sort = array();
  $files = listDirectory(fixPath($path), 0);
  foreach ($files as $f){
    $fullPath = $path.'/'.$f;
    if(!is_dir(fixPath($fullPath)) || $f == '.' || $f == '..')
      continue;
    $tmp = getFilesNumber(fixPath($fullPath), $type);
    $ret[$fullPath] = array('path'=>$fullPath,'files'=>$tmp['files'],'dirs'=>$tmp['dirs']);
    $sort[$fullPath] = $f;
  }
  natcasesort($sort);
  foreach ($sort as $k => $v) {
    $tmp = $ret[$k];
    echo ',{"p":"'.mb_ereg_replace('"', '\\"', $tmp['path']).'","f":"'.$tmp['files'].'","d":"'.$tmp['dirs'].'"}';
    GetDirs($tmp['path'], $type);
  }
}

$type = (empty($_POST['type'])?'':strtolower($_POST['type']));
if($type != 'image' && $type != 'flash')
  $type = '';

echo "[\n";
$tmp = getFilesNumber(fixPath(getFilesPath()), $type);
echo '{"p":"'.  mb_ereg_replace('"', '\\"', getFilesPath()).'","f":"'.$tmp['files'].'","d":"'.$tmp['dirs'].'"}';
GetDirs(getFilesPath(), $type);
echo "\n]";
?>