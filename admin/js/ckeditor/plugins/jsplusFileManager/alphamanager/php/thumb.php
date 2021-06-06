<?php
include '../system.inc.php';
include 'functions.inc.php';

header("Pragma: cache");
header("Cache-Control: max-age=3600");

verifyAction('GENERATETHUMB');
checkAccess('GENERATETHUMB');

$path = urldecode(empty($_GET['f'])?'':$_GET['f']);
verifyPath($path);

@chmod(fixPath(dirname($path)), octdec(DIRPERMISSIONS));
@chmod(fixPath($path), octdec(FILEPERMISSIONS));

$w = intval(empty($_GET['width'])?'100':$_GET['width']);
$h = intval(empty($_GET['height'])?'0':$_GET['height']);

//echo($path . " | " . $w . " " . $h . " = " . AlphaManagerImage::getThumbFileName($path, $w, $h)); die;

header('Content-type: '.AlphaManagerFile::GetMIMEType(basename($path)));
$thumbFileName = AlphaManagerImage::getThumbFileName($path, $w, $h);
/*if (STORE_PREVIEWS_DIR != null && strlen(STORE_PREVIEWS_DIR) > 0 ) {
    if (is_file($thumbFileName)) {
        AlphaManagerImage::OutputImage($thumbFileName, AlphaManagerFile::GetExtension($thumbFileName));
        return;
    }
}*/

if($w && $h)
  AlphaManagerImage::CropCenter(fixPath($path), $thumbFileName, null, $w, $h);
else
  AlphaManagerImage::Resize(fixPath($path), $thumbFileName, null, $w, $h);
?>