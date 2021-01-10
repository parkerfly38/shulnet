<?php
// Load the basics
require "../sd-system/config.php";
$task     = 'content-folder-add';
$admin    = new admin;
$employee = $admin->check_employee($task);
$check    = $db->check_path($_POST['path']);
if ($check == '1') {
    echo '<img src="imgs/icon-save.png" width="16" height="16" border="0" class="icon" /> Folder found!';
    exit;

} else if ($check == '2') {
    echo '<img src="imgs/icon-warning.png" width="20" height="16" border="0" class="icon" /> You can only secure folders outside of the program\'s folder. You also cannot secure the base directory of your website.';
    exit;

} else if ($check == '3') {
    echo '<img src="imgs/icon-warning.png" width="20" height="16" border="0" class="icon" /> The folder exists, however it is not writable. This means that the program cannot write the necessary file to make the folder secure. Please set the permissions on the folder to "777" before continuing.';
    exit;

} else {
    echo '<img src="imgs/icon-warning.png" width="20" height="16" border="0" class="icon" /> Folder does not exist.';
    exit;

}



