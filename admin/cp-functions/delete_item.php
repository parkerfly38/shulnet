<?php

// Load the basics
require "../sd-system/config.php";
$deleted_ids = '';
if (!empty($_POST['special'])) {
    $special = '1';

} else {
    $special = '0';

}
$found = 0;
foreach ($_POST as $id => $one) {
    $found = 1;
    if ($id == 'scope') {
        continue;
    } else if ($id == 'special') {
        continue;
    } else {
        $del = new delete($id, $_POST['scope'], $special);
        // Deleted?
        if ($del->result == '1') {
            $deleted_ids .= ',' . $id;

        }

    }

}
$deleted_ids = substr($deleted_ids, 1);
if ($del->result == '1' && $found == 1) {
    echo "1+++$deleted_ids";
    exit;
} else {
    echo "0+++" . $del->reason;
    exit;
}