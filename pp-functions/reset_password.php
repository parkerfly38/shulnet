<?php

/**
 * Reset password.
 *
 * ShulNET Membership Software
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
require "../admin/sd-system/config.php";
$user  = new user;
$check = $user->check_pwd_reset($_GET['s']);
if ($check == '0') {
    $array = array('code' => 'L024');
    $link  = build_link('lost_password.php', $array);
    header('Location: ' . $link);
    exit;
} else {
    // $reset = $user->clear_pwd_reset($_GET['s']);
    $changes = array(
        'code' => $_GET['s'],
    );
    echo new template('password_reset', $changes, '1');
    exit;
}
