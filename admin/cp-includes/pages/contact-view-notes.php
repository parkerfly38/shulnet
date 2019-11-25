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
 * @author      Cove Brook Coders
 * @link        https://www.covebrookcode.com/
 * @copyright   (c) 2019 Cove Brook Coders
 * @license     http://www.gnu.org/licenses/gpl-3.0.en.html
 * @project     ShulNET Membership Software
 */
$table   = 'ppSD_notes';
$contact = new contact;
$data    = $contact->get_contact($_POST['id']);


// History
if ($employee['permissions']['admin'] == '1') {
    $criteria = array(
        'user_id' => $data['data']['id'],
    );
} else {
    $criteria = array(
        'user_id' => $data['data']['id'],
        'OR'      => array(
            'added_by' => $employee['id'],
            'public' => '1',
            '`for`' => $employee['id'],
        ),
    );
}

$get_crit = htmlentities(serialize($criteria));
$history  = new history('', $criteria, '1', '50', 'date', 'DESC', $table);
$scope    = 'contact';
$id       = $_POST['id'];
include "note-table.php";