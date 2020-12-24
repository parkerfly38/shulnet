<?php

require "../sd-system/config.php";
$admin = new admin;
$yahrzeit = new yahrzeits;
if ($_POST['edit'] == '1')
{
    $type = 'edit';
} else {
    $type = 'add';
}

$task = 'yahrzeit_' . $type;

//check permissions and employee
$employee = $admin->check_employee($task);
$task_id = $db->start_task($task, 'staff', $_POST['id'], $employee['username']);

//primary fields for main table
$table  = 'ppSD_yahrzeits';
$primary = array('');
$ignore = array('edit');

$query_form = $admin->query_from_fields($_POST, $type, $ignore, $primary);

if ($type == 'edit')
{
    //ownership
    $data = $yahrzeit->get_yahrzeit($_POST['id']);

    $ownership = new ownership($data['data']['owner'], $data['data']['public']);
    if ($ownership->result != '1')
    {
        echo "0+++" . $ownership->reason;
        exit;
    }

    //update the yahrzeit
    $update = $query_form['u1'];
    $q = $db->update("
        UPDATE `ppSD_yahrzeits`
        SET '.$update.' WHERE `id` = '".$db->mysql_clean($_POST['id'])."'
        LIMIT 1;
    ");

    $id = $_POST['id'];
    $add = $db->add_history('yahrzeit_update', $employee['id'], $_POST['id'], 2, $_POST['id']);

} else {
    $idA = $yahrzeit->create_yahrzeit($_POST);
    $id = $idA['id'];
}

// Re-cache
$data                  = $yahrzeit->get_yahrzeit($id);
$content               = $data['data'];
$return                = array();
$table_format          = new table('yahrzeits', 'ppSD_yahrzeits');
$return                = array();
$return['close_popup'] = '1'; // For quick add
if ($type == 'add') {
    /*if ($quick_add != '1') {
        $return['load_slider']      = array(
            'page'    => 'contact',
            'subpage' => 'view',
            'id'      => $content['id'],
        );
        $cell                       = $table_format->render_cell($content);
        $return['append_table_row'] = $cell;

    }*/
    $return['show_saved'] = 'Created';

} else {
    $return['show_saved'] = 'Updated';
    $cell                 = $table_format->render_cell($content, '1');
    $return['update_row'] = $cell;

}
$task = $db->end_task($task_id, '1');
echo "1+++" . json_encode($return);
exit;
?>