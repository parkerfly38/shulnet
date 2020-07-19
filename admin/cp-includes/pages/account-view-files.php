<?php

   


$table = 'ppSD_uploads';

$account = new account;
$data = $account->get_account($_POST['id']);

// History
$criteria = array(
    'item_id' => $data['id']
);
$get_crit = htmlentities(serialize($criteria));

$history = new history('', $criteria, '1', '50', 'date', 'DESC', $table);

$type = 'account';
$id = $_POST['id'];
include 'files-view.php';
