<?php

   


$table = 'ppSD_uploads';

$data = $admin->get_employee('', $_POST['id']);

// History
$criteria = array(
    'item_id' => $data['id']
);
$get_crit = htmlentities(serialize($criteria));

$history = new history('', $criteria, '1', '50', 'date', 'DESC', $table);

$id = $_POST['id'];
include 'files-view.php';

?>
