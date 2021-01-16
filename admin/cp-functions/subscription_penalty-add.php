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
// Load the basics
require "../sd-system/config.php";
$admin = new admin;
$type = 'edit';
$task = 'subscription_penalties-' . $type;

// Check permissions and employee
$employee = $admin->check_employee($task);
$task_id  = $db->start_task($task, 'staff', $_POST['id'], $employee['username']);

$cur = 0;
while ($cur < 5) {
    $cur++;
    $attempt = 'attempt_' . $cur;
    $up = $db->update("
        UPDATE
            `ppSD_subscription_reattempts`
        SET
            `penalty_percent`='" . $db->mysql_clean($_POST[$attempt]['penalty_percent']) . "',
            `penalty_fixed`='" . $db->mysql_clean($_POST[$attempt]['penalty_fixed']) . "'
        WHERE
            `fail_attempt`='" . $cur . "'
        LIMIT 1
    ");
}

$task                  = $db->end_task($task_id, '1');
$return                = array();
$return['close_popup'] = '1';
$return['show_saved']  = 'Updated Subscription Penalties';
echo "1+++" . json_encode($return);
exit;