<?php
include 'security.inc.php';
function t($key){
  global $LANG;
  if(empty($LANG)){
    $file = 'en.json';
    $langPath = '../lang/';
    if(defined('LANG')){
      if(LANG == 'auto'){
        $lang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
        if(is_file($langPath.$lang.'.json'))
          $file = $lang.'.json';
      }
      elseif(is_file($langPath.LANG.'.json'))
        $file = LANG.'.json';
    }
    $file = $langPath.$file;
    $LANG = json_decode(file_get_contents($file), true);
  }
  if(!$LANG[$key])
    $LANG[$key] = $key;

  return $LANG[$key];
}
function checkPath($path){
  $ret = false;
  if(mb_strpos($path.'/', getFilesPath()) === 0)
    $ret = true;

  return $ret;
}
function verifyAction($action){
  /*if(!defined($action) || !constant($action))
    exit;
  else{
    $confUrl = constant($action);
    $qStr = mb_strpos($confUrl, '?');
    if($qStr !== false)
      $confUrl = mb_substr ($confUrl, 0, $qStr);
    $confUrl = BASE_PATH.'/'.$confUrl;
    $confUrl = AlphaManagerFile::FixPath($confUrl);
    $thisUrl = dirname(__FILE__).'/'.basename($_SERVER['PHP_SELF']);
    $thisUrl = AlphaManagerFile::FixPath($thisUrl);
    if($thisUrl != $confUrl){
      echo "$confUrl $thisUrl";
      exit;
    }
  }*/
}
function verifyPath($path){
  if(!checkPath($path)){
    echo getErrorRes("Access to $path is denied").' '.$path;
    exit;
  }
}
function fixPath($path){
  if (strpos('/', $path) === 0)
    $path = $_SERVER['DOCUMENT_ROOT'].'/'.$path;
  $path = str_replace('\\', '/', $path);
  $path = AlphaManagerFile::FixPath($path);
  return $path;
}
function gerResultStr($type, $str = ''){
  return '{"res":"'.  addcslashes($type, '"\\').'","msg":"'.  addcslashes($str, '"\\').'"}';
}
function getSuccessRes($str = ''){
  return gerResultStr('ok', $str);
}
function getErrorRes($str = ''){
  return gerResultStr('error', $str);
}
function getFilesPath(){
  $ret = (isset($_SESSION[SESSION_PATH_KEY]) && $_SESSION[SESSION_PATH_KEY] != ''?$_SESSION[SESSION_PATH_KEY]:FILES_ROOT);
  if(!$ret){
    $ret = AlphaManagerFile::FixPath(BASE_PATH.'/uploads');
    $tmp = $_SERVER['DOCUMENT_ROOT'];
    if(mb_substr($tmp, -1) == '/' || mb_substr($tmp, -1) == '\\')
      $tmp = mb_substr($tmp, 0, -1);
    $ret = str_replace(AlphaManagerFile::FixPath($tmp), '', $ret);
  }
  return $ret;
}
function listDirectory($path){
  $ret = @scandir($path);
  if($ret === false){
    $ret = array();
    $d = opendir($path);
    if($d){
      while(($f = readdir($d)) !== false){
        $ret[] = $f;
      }
      closedir($d);
    }
  }
  
  return $ret;
}
class AlphaManagerFile{
  static public function CheckWritable($dir){
    $ret = false;
    if(self::CreatePath($dir)){
      $dir = self::FixPath($dir.'/');
      $testFile = 'writetest.txt';
      $f = @fopen($dir.$testFile, 'w', false);
      if($f){
        fclose($f);
        $ret = true;
        @unlink($dir.$testFile);
      }
    }

    return $ret;
  }
  static function CanUploadFile($filename){
    $ret = false;
    $forbidden = array_filter(preg_split('/[^\d\w]+/', strtolower(FORBIDDEN_UPLOADS)));
    $allowed = array_filter(preg_split('/[^\d\w]+/', strtolower(ALLOWED_UPLOADS)));
    $ext = AlphaManagerFile::GetExtension($filename);

    if((empty($forbidden) || !in_array($ext, $forbidden)) && (empty($allowed) || in_array($ext, $allowed)))
      $ret = true;

    return $ret;
  }
  static function ZipAddDir($path, $zip, $zipPath){
    $d = opendir($path);
    $zipPath = str_replace('//', '/', $zipPath);
    if($zipPath && $zipPath != '/'){
      $zip->addEmptyDir($zipPath);
    }
    while(($f = readdir($d)) !== false){
      if($f == '.' || $f == '..')
        continue;
      $filePath = $path.'/'.$f;
      if(is_file($filePath)){
        $zip->addFile($filePath, ($zipPath?$zipPath.'/':'').$f);
      }
      elseif(is_dir($filePath)){
        self::ZipAddDir($filePath, $zip, ($zipPath?$zipPath.'/':'').$f);
      }
    }
    closedir($d);
  }
  static function ZipDir($path, $zipFile, $zipPath = ''){
    $zip = new ZipArchive();
    $zip->open($zipFile, ZIPARCHIVE::CREATE);
    self::ZipAddDir($path, $zip, $zipPath);
    $zip->close();
  }
  static function IsImage($fileName){
    $ret = false;
    $ext = strtolower(self::GetExtension($fileName));
    if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'jpe' || $ext == 'png' || $ext == 'gif' || $ext == 'ico')
      $ret = true;
    return $ret;
  }
  static function IsFlash($fileName){
    $ret = false;
    $ext = strtolower(self::GetExtension($fileName));
    if($ext == 'swf' || $ext == 'flv' || $ext == 'swc' || $ext == 'swt')
      $ret = true;
    return $ret;
  }
  /**
   * Returns human formated file size
   *
   * @param int $filesize
   * @return string
   */
  static function FormatFileSize($filesize){
    $ret = '';
    $unit = 'B';
    if($filesize > 1024){
      $unit = 'KB';
      $filesize = $filesize / 1024;
    }
    if($filesize > 1024){
      $unit = 'MB';
      $filesize = $filesize / 1024;
    }
    if($filesize > 1024){
      $unit = 'GB';
      $filesize = $filesize / 1024;
    }

    $ret = round($filesize, 2).' '.$unit;
    return $ret;
  }
  /**
   * Returns MIME type of $filename
   *
   * @param string $filename
   * @return string
   */
  static function GetMIMEType($filename){
    $type = 'application/octet-stream';
    $ext = self::GetExtension($filename);

    switch(strtolower($ext)){
      case 'jpg':  $type = 'image/jpeg';break;
      case 'jpeg': $type = 'image/jpeg';break;
      case 'gif':  $type = 'image/gif';break;
      case 'png':  $type = 'image/png';break;
      case 'bmp':  $type = 'image/bmp';break;
      case 'tiff': $type = 'image/tiff';break;
      case 'tif':  $type = 'image/tiff';break;
      case 'pdf':  $type = 'application/pdf';break;
      case 'rtf':  $type = 'application/msword';break;
      case 'doc':  $type = 'application/msword';break;
      case 'xls':  $type = 'application/vnd.ms-excel'; break;
      case 'zip':  $type = 'application/zip'; break;
      case 'swf':  $type = 'application/x-shockwave-flash'; break;
      default: $type = 'application/octet-stream';
    }

    return $type;
  }

  /**
   * Replaces any character that is not letter, digit or underscore from $filename with $sep
   *
   * @param string $filename
   * @param string $sep
   * @return string
   */
  static function CleanupFilename($filename, $sep = '_'){
    $str = '';
    if(strpos($filename,'.')){
      $ext = self::GetExtension($filename) ;
      $name = self::GetName($filename);
    }
    else{
      $ext = '';
      $name = $filename;
    }
    if(mb_strlen($name) > 32)
      $name = mb_substr($name, 0, 32);
    $str = str_replace('.php', '', $str);
    $str = mb_ereg_replace("[^\\w]", $sep, $name);
    
    $str = mb_ereg_replace("$sep+", $sep, $str).($ext?'.'.$ext:'');

    return $str;
  }

  /**
   * Returns file extension without dot
   *
   * @param string $filename
   * @return string
   */
  static function GetExtension($filename) {
    $ext = '';

    if(mb_strrpos($filename, '.') !== false)
      $ext = mb_substr($filename, mb_strrpos($filename, '.') + 1);

    return strtolower($ext);
  }

  /**
   * Returns file name without extension
   *
   * @param string $filename
   * @return string
   */
  static function GetName($filename) {
    $name = '';
    $tmp = mb_strpos($filename, '?');
    if($tmp !== false)
        $filename = mb_substr ($filename, 0, $tmp);
    $dotPos = mb_strrpos($filename, '.');
    if($dotPos !== false)
      $name = mb_substr($filename, 0, $dotPos);
    else
      $name = $filename;

    return $name;
  }
  static function GetFullName($filename) {
    $tmp = mb_strpos($filename, '?');
    if($tmp !== false)
      $filename = mb_substr ($filename, 0, $tmp);
    $filename = basename($filename);

    return $filename;
  }
  static public function FixPath($path){
    $path = mb_ereg_replace('[\\\/]+', '/', $path);
    return $path;
  }
  /**
   * creates unique file name using $filename( " - Copy " and number is added if file already exists) in directory $dir
   *
   * @param string $dir
   * @param string $filename
   * @return string
   */
  static function MakeUniqueFilename($dir, $filename){
    $temp = '';
    $dir .= '/';
    $dir = self::FixPath($dir.'/');
    $ext = self::GetExtension($filename);
    $name = self::GetName($filename);
    $name = self::CleanupFilename($name);
    $name = mb_ereg_replace(' \\- Copy \\d+$', '', $name);
    if($ext)
      $ext = '.'.$ext;
    if(!$name)
      $name = 'file';

    $i = 0;
    do{
      $temp = ($i > 0? $name." - Copy $i": $name).$ext;
      $i++;
    }while(file_exists($dir.$temp));

    return $temp;
  }
  /**
   * creates unique directory name using $name( " - Copy " and number is added if directory already exists) in directory $dir
   *
   * @param string $dir
   * @param string $name
   * @return string
   */
  static function MakeUniqueDirname($dir, $name){
    $temp = '';
    $dir = self::FixPath($dir.'/');
    $name = mb_ereg_replace(' - Copy \\d+$', '', $name);
    if(!$name)
      $name = 'directory';

    $i = 0;
    do{
      $temp = ($i? $name." - Copy $i": $name);
      $i++;
    }while(is_dir($dir.$temp));

    return $temp;
  }
}
class AlphaManagerImage{
  public static function GetImage($path){
    $img = null;
    switch(AlphaManagerFile::GetExtension(basename($path))){
      case 'png':
        $img = imagecreatefrompng($path);
        break;
      case 'gif':
        $img = imagecreatefromgif($path);
        break;
      default:
        $img = imagecreatefromjpeg($path);
    }
    $cTransparent = imagecolorallocatealpha($img, 0, 0, 0, 127);
    imagecolortransparent($img, $cTransparent);
    imagefilledrectangle($img,0,0,127,127,$cTransparent);
    imagealphablending($img, false);
    imagesavealpha($img, true);
    return $img;
  }
  public static function OutputImage($img, $type, $destination = null, $quality = 90){
    if(is_string($img))
      $img = self::GetImage ($img);
    switch(strtolower($type)){
      case 'png':
        imagepng($img, $destination);
        break;
      case 'gif':
        imagegif($img, $destination);
        break;
      default:
        imagejpeg($img, $destination, $quality);
    }
  }
  public static function Resize($source, $thumbFileName, $destination, $width = '150',$height = 0, $quality = 90) {
    $tmp = getimagesize($source);
    $w = $tmp[0];
    $h = $tmp[1];
    $r = $w / $h;

    if($w <= ($width + 1) && (($h <= ($height + 1)) || (!$height && !$width))){
      if($source != $destination)
        self::OutputImage($source, AlphaManagerFile::GetExtension(basename($source)), $destination, $quality);
      return;
    }
    
    $newWidth = $width;
    $newHeight = floor($newWidth / $r);
    if(($height > 0 && $newHeight > $height) || !$width){
      $newHeight = $height;
      $newWidth = intval($newHeight * $r);
    }

    $thumbImg = imagecreatetruecolor($newWidth, $newHeight);
    $cTransparent = imagecolorallocatealpha($thumbImg, 0, 0, 0, 127);
    imagecolortransparent($thumbImg, $cTransparent);
    imagefilledrectangle($thumbImg,0,0,127,127,$cTransparent);
    imagealphablending($thumbImg, false);
    imagesavealpha($thumbImg, true);
    $img = self::GetImage($source);
    imagecopyresampled($thumbImg, $img, 0, 0, 0, 0, $newWidth, $newHeight, $w, $h);

    self::Cache($thumbImg, $thumbFileName);

    self::OutputImage($thumbImg, AlphaManagerFile::GetExtension(basename($source)), $destination, $quality);
  }
  public static function Cache($img, $thumbFileName, $quality = 90) {
    if (STORE_PREVIEWS_DIR != null && strlen(STORE_PREVIEWS_DIR) > 0 ) {
       self::OutputImage($img, AlphaManagerFile::GetExtension(basename($thumbFileName)), $thumbFileName, $quality);
    }
  }
  public static function GetThumbFileName($path, $w, $h) {
      return '../' . STORE_PREVIEWS_DIR . '/' . md5($w . "|" . $h . "|" . $path) . '.' . 'jpg'; //AlphaManagerFile::GetExtension($path);
  }
  public static function CropCenter($source, $thumbFileName, $destination, $width, $height, $quality = 90) {
    $tmp = getimagesize($source);
    $w = $tmp[0];
    $h = $tmp[1];
    if(($w <= $width) && (!$height || ($h <= $height))){
      self::OutputImage(self::GetImage($source), AlphaManagerFile::GetExtension(basename($source)), $destination, $quality);
    }
    $ratio = $width / $height;
    $top = $left = 0;

    $cropWidth = floor($h * $ratio);
    $cropHeight = floor($cropWidth / $ratio);
    if($cropWidth > $w){
      $cropWidth = $w;
      $cropHeight = $w / $ratio;
    }
    if($cropHeight > $h){
      $cropHeight = $h;
      $cropWidth = $h * $ratio;
    }

    if($cropWidth < $w){
       $left = floor(($w - $cropWidth) / 2);
    }
    if($cropHeight < $h){
       $top = floor(($h- $cropHeight) / 2);
    }
    self::Crop($source, $thumbFileName, $destination, $left, $top, $cropWidth, $cropHeight, $width, $height, $quality);
  }
  public static function Crop($source, $thumbFileName, $destination, $x, $y, $cropWidth, $cropHeight, $width, $height, $quality = 90) {
    $thumbImg = imagecreatetruecolor($width, $height);
    $cTransparent = imagecolorallocatealpha($thumbImg, 0, 0, 0, 127);
    imagecolortransparent($thumbImg, $cTransparent);
    imagealphablending($thumbImg, false);
    imagesavealpha($thumbImg, true);
    $img = self::GetImage($source);
    imagecopyresampled($thumbImg, $img, 0, 0, $x, $y, $width, $height, $cropWidth, $cropHeight);
    self::Cache($thumbImg, $thumbFileName);
    self::OutputImage($thumbImg, AlphaManagerFile::GetExtension(basename($source)), $destination, $quality);
  }
}
$tmp = json_decode(file_get_contents(BASE_PATH.'/conf.json'), true);
if($tmp){
  foreach ($tmp as $k=>$v) {
    if ($k != 'LANG')
        define($k, $v);
    else {
        if (isset($_GET['l']))
            define($k, $_GET['l']);
        else if (isset($_POST['l']))
            define($k, $_POST['l']);
        else
            define($k, $v);
    }
  }
}
else
  die('Error parsing configuration');
$FilesRoot = fixPath(getFilesPath());
if(!is_dir($FilesRoot))
  @mkdir($FilesRoot, octdec(DIRPERMISSIONS));
?>