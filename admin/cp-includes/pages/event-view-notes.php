<?php

   
$table = 'ppSD_notes';
// History
if ($employee['permissions']['admin'] == '1') {
    $criteria = array(
        'user_id' => $_POST['id'],
    );
} else {
    $criteria = array(
        'user_id' => $_POST['id'],
        'OR'      => array(
            'added_by' => $employee['id'],
            'public' => '1',
            '`for`' => $employee['id'],
        ),
    );
}

$get_crit = htmlentities(serialize($criteria));
$history  = new history('', $criteria, '1', '50', 'date', 'DESC', $table);
$scope    = 'event';
$id       = $_POST['id'];
include "note-table.php";