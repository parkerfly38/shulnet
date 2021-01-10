<?php
require "../sd-system/config.php";
$admin = new admin;
// Check permissions and employee
$employee = $admin->check_employee('upload-edit');
// Find file
$editing = PP_PATH . '/custom/uploads/' . $_POST['filename'];
if (file_exists($editing)) {
    $url = PP_URL . '/custom/uploads/' . $_POST['filename'];

} else {
    $editing = PP_PATH . '/admin/sd-system/attachments/' . $_POST['filename'];
    $url     = PP_URL . '/admin/sd-system/attachments/' . $_POST['filename'];

}
/**
 * CROP
 */
if ($_POST['action'] == 'crop') {
    $task_id    = $db->start_task('upload-crop', 'staff', $_POST['id'], $employee['username']);
    $new_width  = $_POST['x2'] - $_POST['x1'];
    $new_height = $_POST['y2'] - $_POST['y1'];
    $image      = imagecreatefromjpeg($editing);
    $width      = imagesx($image);
    $height     = imagesy($image);
    /*
    $original_aspect = $width / $height;
    $thumb_aspect = $thumb_width / $thumb_height;
    if ( $original_aspect >= $thumb_aspect ) {
       // If image is wider than thumbnail (in aspect ratio sense)
       $new_height = $thumb_height;
       $new_width = $width / ($height / $thumb_height);
    } else {
       // If the thumbnail is wider than the image
       $new_width = $thumb_width;
       $new_height = $height / ($width / $thumb_width);
    }
    */
    $thumb = imagecreatetruecolor($new_width, $new_height);
    // Resize and crop
    imagecopyresampled($thumb,
        $image,
        0,
        0,
        $_POST['x1'],
        $_POST['y1'],
        $new_width,
        $new_height,
        $new_width,
        $new_height);
    imagejpeg($thumb, $editing, '100');
    $task = $db->end_task($task_id, '1');

} /**
 * RESIZE

 */
else if ($_POST['action'] == 'resize') {
    $task_id = $db->start_task('upload-resize', 'staff', $_POST['id'], $employee['username']);
    $task    = $db->end_task($task_id, '1');

} /**
 * ROTATE

 */
else if ($_POST['action'] == 'rotate') {
    $task_id = $db->start_task('upload-rotate', 'staff', $_POST['id'], $employee['username']);
    $source  = imagecreatefromjpeg($editing);
    $degrees = $_POST['rotate'];
    $rotate  = imagerotate($source, $degrees, 0);
    imagejpeg($rotate, $editing);
    $task = $db->end_task($task_id, '1');

}



echo "1+++$url";
exit;



