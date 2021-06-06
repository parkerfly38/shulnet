<?php
include '../system.inc.php';
include 'functions.inc.php';

verifyAction('UPLOADURL');
checkAccess('UPLOADURL');

$path = trim(empty($_POST['d'])?getFilesPath():$_POST['d']);
$url = $_POST['u'];
$doOverwrite = $_POST['o'] == 't';
$fileName = $_POST['n'];
verifyPath($path);

$res = '';
if(is_dir(fixPath($path))){
    if (strlen($fileName) === 0 || $fileName == '.' || strpos($fileName, '..') !== false || strpos($fileName, '/') > 0) {
        $res = getErrorRes(t('E_UploadNotAll'));
    } else if (file_exists($path.$fileName)) {
        $res = getErrorRes(t(is_dir($path.$fileName) ? 'E_DirAlreadyExists' : 'E_UploadInvalidPath'));
    } else {

        $result = rehost($url, $path, $fileName, false, $doOverwrite);
        if ($result[0] === true)
            $res = getSuccessRes();
        else
            $res = getErrorRes($result[1]);

    }
}
else
  $res = getErrorRes(t('E_UploadInvalidPath'));

echo $res;

function rehost($url, $path, $filename, $makeUniqueFileName, $doOverwrite) {
    $bytes = file_get_contents($url);
	if ($bytes == false)
		return array(false, t('E_UnableToDownload'));

    if ($filename == null) {
	    // $http_response_header filled by file_get_contents()
        foreach($http_response_header as $header)
        {
            if (strpos(strtolower($header),'content-disposition') !== false)
            {
                $tmp_name = explode('=', $header);
                if ($tmp_name[1])
                    $filename = trim($tmp_name[1],'";\'');
            }
        }
        if (!isset($filename)) {
            $stripped_url = preg_replace('/\\?.*/', '', $url);
            $filename = basename($stripped_url);
        }

        $tmpDir = sys_get_temp_dir();
        if (file_exists($tmpDir.'/'.$filename)) {
            $n = 1;
            do {
                $n ++;
            } while (file_exists($tmpDir.'/'.$n.'_'.$filename));
            $filename = $n.'_'.$filename;
        }
	}

    if ($makeUniqueFileName === true)
        $file = MakeUniqueFilename($path, $filename);
    else {
        $file = $path . '/' . $filename;
        if (!$doOverwrite && file_exists($file))
            return array(false, t(is_dir($file) ? 'E_DirAlreadyExists' : 'E_MoveFileAlreadyExists'));
    }

	$bytesDownloaded = file_put_contents($file, $bytes, LOCK_EX);
	if ($bytesDownloaded === false)
		return array(false, t('E_UnableToSaveFile'));
    else {
        $thumbFileName = AlphaManagerImage::getThumbFileName($file, 159, 139); // TODO: remove thumbnails of all sizes
        if (is_file($thumbFileName))
            unlink($thumbFileName);
        //echo $thumbFileName; echo " | "; echo $file; die;
    }
	return array(true, $file);
}



?>
