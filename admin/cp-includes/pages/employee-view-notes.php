<?php

   
$table = 'ppSD_notes';
$data  = $admin->get_employee('', $_POST['id']);
// History
$criteria = array(
    'user_id' => $data['id'],
);
$get_crit = htmlentities(serialize($criteria));
$history  = new history('', $criteria, '1', '50', 'date', 'DESC', $table);
$scope    = 'employee';
$id       = $_POST['id'];
include "note-table.php";