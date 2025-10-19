<?php

require "../sd-system/config.php";
$admin = new admin;
// Check permissions and employee
if (!empty($_GET['permission'])) {
    $employee = $admin->check_employee($_GET['permission']);

}
$allowedExtensions = array('jpg','jpeg','png','gif','zip','pdf','doc','docx','odt','xlsx','csv','xltx','xml','xls','ods','txt','rtf');
// max file size in bytes
$sizeLimit = 9437184; // 9 Mb
//$exts = $db->get_option('uploads_exts');
//$size = $db->get_option('uploads_max_size');
//if (empty($size)) {
//    $size = '5242880';
//}
//$allowedExtensions = explode(',', $exts);
//$sizeLimit         = $size; // 5 Mb
$uploader          = new qqFileUploader($allowedExtensions, $sizeLimit);
if (! empty($_GET['attachment'])) {
    $result = $uploader->handleUpload(PP_PATH . '/admin/sd-system/attachments');
} else {
    $result = $uploader->handleUpload(PP_PATH . '/custom/uploads');
}
// to pass data through iframe you will need to encode all html tags
echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
exit;



