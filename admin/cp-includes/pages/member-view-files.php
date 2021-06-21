<?php 


$table = 'ppSD_uploads';
$user = new user;
$data = $user->get_user($_POST['id']);

// History
$criteria = array(
    'item_id' => $data['data']['id']
);
$get_crit = htmlentities(serialize($criteria));
$history = new history('', $criteria, '1', '50', 'date', 'DESC', $table);

$type = 'member';
$id = $_POST['id'];

include 'files-view.php';


