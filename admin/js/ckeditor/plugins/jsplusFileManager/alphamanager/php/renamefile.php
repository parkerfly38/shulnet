<?php
include '../system.inc.php';
include 'functions.inc.php';

verifyAction('RENAMEFILE');
checkAccess('RENAMEFILE');

$path = trim(empty($_POST['f'])?'':$_POST['f']);
$name = trim(empty($_POST['n'])?'':$_POST['n']);
verifyPath($path);

$newPath = dirname(fixPath($path)).'/'.$name;
if (is_dir($newPath) || is_file($newPath) || is_link($newPath))
    echo getErrorRes(t('E_FileAlreadyExists'));
elseif(!AlphaManagerFile::CanUploadFile($name))
    echo getErrorRes(t('E_FileExtensionForbidden').' ".'.AlphaManagerFile::GetExtension($name).'"');
elseif(rename(fixPath($path), $newPath))
    echo getSuccessRes();
else
    echo getErrorRes(t('E_RenameFile').' '.basename($path));

?>