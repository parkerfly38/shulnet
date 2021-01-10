<?phpShulNETShulNETShulNET



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
$task = 'print-note';
$admin = new admin;
$employee = $admin->check_employee($task);
$task_id  = $db->start_task($task, 'staff', $_POST['id'], $employee['username']);
$error = '0';
$owner = '1';
if (empty($_GET['id'])) {
    echo "Note not found.";
    exit;
} else {
    $data      = new history($_GET['id'], '', '', '', '', '', 'ppSD_notes');
    $ownership = new ownership($data->final_content['added_by'], $data->final_content['public']);
    if ($ownership->result != '1') {
        if ($data->final_content['for'] != $employee['id']) {
            echo "You cannot print this note.";
            exit;
        }
    }

    include "print_header.php";
    $notes         = new notes;
    $get_printable = $notes->get_printable($data->final_content['id']);
    echo $get_printable;
    include "print_footer.php";

    $task = $db->end_task($task_id, '1');
    exit;
}