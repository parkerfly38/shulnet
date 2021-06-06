<?php
include '../system.inc.php';
include 'functions.inc.php';

verifyAction('UPLOAD');
checkAccess('UPLOAD');

$isAjax = (isset($_POST['method']) && $_POST['method'] == 'ajax');
$path = trim(empty($_POST['d'])?getFilesPath():$_POST['d']);
verifyPath($path);
$res = '';
if(is_dir(fixPath($path))){
  if(!empty($_FILES['files']) && is_array($_FILES['files']['tmp_name'])){
    $errors = $errorsExt = array();
    foreach($_FILES['files']['tmp_name'] as $k=>$v){
      $filename = $_FILES['files']['name'][$k];
      $filesize = $_FILES['files']['size'][$k];
      $filename = AlphaManagerFile::MakeUniqueFilename(fixPath($path), $filename);
      $filePath = fixPath($path).'/'.$filename;
      $isUploaded = true;
      if(!AlphaManagerFile::CanUploadFile($filename)){
        $errorsExt[] = $filename;
        $isUploaded = false;
      } elseif(intval(MAX_FILE_SIZE) > 0 && $filesize > intval(MAX_FILE_SIZE)) {
         $errors[] = $filename;
         $isUploaded = false;
      } else {

        $sizeProhibited = false;
        if (intval(MAX_IMAGE_WIDTH) > 0 || intval(MAX_IMAGE_HEIGHT) > 0) {
           $tmp = getimagesize($filePath);
           $w = $tmp[0];
           $h = $tmp[1];
           if ((intval(MAX_IMAGE_WIDTH) > 0 && intval(MAX_IMAGE_WIDTH) < $w) || (intval(MAX_IMAGE_HEIGHT) > 0 && intval(MAX_IMAGE_HEIGHT) < $h)) {
              $errors[] = $filename;
              $isUploaded = false;
              $sizeProhibited = true;
           }
        }
        if($sizePhohibited !== true) {
            if(!move_uploaded_file($v, $filePath)){
                $errors[] = $filename;
                $isUploaded = false;
            }
        }

      }
      if(is_file($filePath)){
         @chmod ($filePath, octdec(FILEPERMISSIONS));
      }
      if($isUploaded && AlphaManagerFile::IsImage($filename) && (intval(RESIZE_IMAGE_WIDTH) > 0 || intval(RESIZE_IMAGE_HEIGHT) > 0)){
        AlphaManagerImage::Resize($filePath, $filePath, $filePath, intval(RESIZE_IMAGE_WIDTH), intval(RESIZE_IMAGE_HEIGHT));
      }
    }
    if($errors && $errorsExt)
      $res = getSuccessRes(t('E_UploadNotAll').' '.t('E_FileExtensionForbidden'));
    elseif($errorsExt)
      $res = getSuccessRes(t('E_FileExtensionForbidden'));
    elseif($errors)
      $res = getSuccessRes(t('E_UploadNotAll'));
    else
      $res = getSuccessRes();
  }
  else
    $res = getErrorRes(t('E_UploadNoFiles'));
}
else
  $res = getErrorRes(t('E_UploadInvalidPath'));

if($isAjax){

  if($errors || $errorsExt)
    $res = getErrorRes(t('E_UploadNotAll'));
  echo $res;
}
else{
  echo '
<script>
parent.fileUploaded('.$res.');
</script>';
}
?>
