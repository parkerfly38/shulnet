<?php

   

if (! empty($_GET['id'])) {
    require "../admin/sd-system/config.php";
    $session = new session;
    $ses     = $session->check_session();
    if ($ses['error'] == '1') {
        $result = array('error' => 'You must be logged in to upload files.');
        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        exit;
    }
    $task_id = $db->start_task('download', 'user', '', $ses['member_id']);

    $upload = new uploads();
    $get = $upload->get_upload($_GET['id']);

    $path = PP_PATH . '/custom/uploads/' . $get['filename'];

    // Download the file.
    $mm_type = "application/octet-stream";
    header("Content-type: application/force-stream");
    header("Content-Transfer-Encoding: Binary");
    header("Content-length: " . filesize($path) );
    header("Content-disposition: attachment; filename=\"" . basename($get['name']) . "\"");
    readfile($path);
    exit;

}