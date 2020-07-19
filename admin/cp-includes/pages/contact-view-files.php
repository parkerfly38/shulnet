<?php

   


$table = 'ppSD_uploads';

$contact = new contact;
$data = $contact->get_contact($_POST['id']);

// History
$criteria = array(
    'item_id' => $data['data']['id']
);
$get_crit = htmlentities(serialize($criteria));

$history = new history('', $criteria, '1', '50', 'date', 'DESC', $table);

$id = $_POST['id'];
include 'files-view.php';

?>
