<?php

   
$table = 'ppSD_notes';
// History
$criteria = array(
    'user_id' => $_POST['id'],
    'OR'      => array(
        'added_by' => $employee['id'],
        'public' => '1',
        '`for`' => $employee['id'],
    ),
);
$get_crit = htmlentities(serialize($criteria));
$history  = new history('', $criteria, '1', '50', 'date', 'DESC', $table);
$scope    = 'campaign';
$id       = $_POST['id'];
include "note-table.php";