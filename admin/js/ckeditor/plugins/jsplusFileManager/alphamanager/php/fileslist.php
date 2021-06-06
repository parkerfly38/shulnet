<?php
include '../system.inc.php';
include 'functions.inc.php';

verifyAction('FILESLIST');
checkAccess('FILESLIST');

$path = (empty($_POST['d'])? getFilesPath(): $_POST['d']);
$type = (empty($_POST['type'])?'':strtolower($_POST['type']));
if($type != 'image' && $type != 'flash')
  $type = '';
verifyPath($path);

$files = listDirectory(fixPath($path), 0);
natcasesort($files);
$str = '';
echo '[';
foreach ($files as $f){
  $fullPath = $path.'/'.$f;
  if(!is_file(fixPath($fullPath)) || ($type == 'image' && !AlphaManagerFile::IsImage($f)) || ($type == 'flash' && !AlphaManagerFile::IsFlash($f)))
    continue;
  $size = filesize(fixPath($fullPath));
  $time = filemtime(fixPath($fullPath));
  $w = 0;
  $h = 0;
  if(AlphaManagerFile::IsImage($f)){
    $tmp = @getimagesize(fixPath($fullPath));
    if($tmp){
      $w = $tmp[0];
      $h = $tmp[1];
    }
  }
  $str .= '{"p":"'.mb_ereg_replace('"', '\\"', $fullPath).'","s":"'.$size.'","t":"'.$time.'","w":"'.$w.'","h":"'.$h.'"},';
}
$str = mb_substr($str, 0, -1);
echo $str;
echo ']';
?>