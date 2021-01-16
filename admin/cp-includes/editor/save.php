<?php 

/**
 *
 *
 * Zenbership Membership Software
 * Copyright (C) 2013-2016 Castlamp, LLC
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author      Castlamp
 * @link        http://www.castlamp.com/
 * @link        http://www.zenbership.com/
 * @copyright   (c) 2013-2016 Castlamp
 * @license     http://www.gnu.org/licenses/gpl-3.0.en.html
 * @project     Zenbership Membership Software
 */


require "../../sd-system/config.php";

$admin = new admin;
$task  = 'template-edit';
$table = 'ppSD_template';
$scope = 'template';

// Check permissions and employee
$employee = $admin->check_employee($task);
$task_id  = $db->start_task($task, 'staff', $_POST['content_id'], $employee['username']);
// Ensure content was posted
if (!isset($_POST['myContent'])) {
    echo 'No content to save';
    return;
}

// Decode content
$postedContent = json_decode($_POST['myContent']);

// Validate content
if (!$postedContent) {
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo 'Error reading content, please try again';
        return;
    }
    echo 'No content to save';
}

// Save content
$done = '';
foreach ($_POST as $id => $html) {
    $done .= "$id: $html\n\n";

}

$task = $db->end_task($task_id, '1');
echo "Saved.";
exit;

