<?php

/**
 *

 */
// Load the basics
require "../sd-system/config.php";
$admin = new admin;
if ($_POST['edit'] == '1') {
    $type = 'edit';

} else {
    $type = 'add';

}
$task = 'department-' . $type;
// Check permissions and employee
$employee = $admin->check_employee($task);
$task_id  = $db->start_task($task, 'staff', $_POST['id'], $employee['username']);
// Current departments
$depts      = explode(',', $db->get_option('departments'));
$final_list = '';
$cur        = 0;
foreach ($_POST['department'] as $current_name => $aDep) {
    $aDep = str_replace(',', '&#44;', $aDep);
    if (!empty($current_name)) {
        // Editing department name
        if ($aDep != $current_name) {
            $q = $db->update("

				UPDATE `ppSD_staff`

				SET `department`='" . $db->mysql_clean($aDep) . "'

				WHERE `department`='" . $db->mysql_clean($current_name) . "'

			");

        } // Delete department
        else if (empty($aDep)) {
            $q = $db->update("

				UPDATE `ppSD_staff`

				SET `department`=''

				WHERE `department`='" . $db->mysql_clean($current_name) . "'

			");

        }

    }
    if (!empty($aDep)) {
        $final_list .= ',' . $aDep;

    }
    $cur++;

}
$final_list            = ltrim($final_list, ',');
$q1                    = $db->update("

	UPDATE `ppSD_options`

	SET `value`='" . $db->mysql_clean($final_list) . "'

	WHERE `id`='departments'

	LIMIT 1

");
$task                  = $db->end_task($task_id, '1');
$return                = array();
$return['close_popup'] = '1';
$return['show_saved']  = 'Updated Departments';
echo "1+++" . json_encode($return);
exit;

