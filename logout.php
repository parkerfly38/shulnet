<?php

/**
 * Logs a member out.
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
 * @author      Cove Brook Coders
 * @link        https://www.covebrookcode.com/
 * @copyright   (c) 2019 Cove Brook Coders
 * @license     http://www.gnu.org/licenses/gpl-3.0.en.html
 * @project     ShulNET Membership Software
 */

require "admin/sd-system/config.php";
$session = new session;
$ses     = $session->check_session();
$kill    = $session->kill_session();
$task_id = $db->start_task('logout', 'user', '', $ses['member_id']);
$logout_url = $db->get_option('logout_redirect');
if (empty($logout_url)) {
    $logout_url = PP_URL . '/login.php';
}
$history = $db->add_history('logout', '2', $ses['member_id'], '1', $ses['member_id'], '');
$indata = array();
if (! empty($ses['id'])) {
    $indata['member_id']  = $ses['member_id'];
    $indata['session_id'] = $ses['id'];
}
$task   = $db->end_task($task_id, '1', '', 'logout', '', $indata);
header('Location: ' . $logout_url);
exit;