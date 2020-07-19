<?php

   
$table = 'ppSD_notes';
$user  = new user;
$data  = $user->get_user($_POST['id']);


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
$scope    = 'member';
$id       = $_POST['id'];
include "note-table.php";
