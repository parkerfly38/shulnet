<?php
// page
// display
// Load the basics
require "../sd-system/config.php";
$admin = new admin;
$task  = 'contact-edit';
// Check permissions and employee
$employee = $admin->check_employee($task);

/*
// Variables
if (empty($_POST['account'])) {
	echo "0+++An account is required for all contacts.";
	exit;
}
*/

if (! empty($_POST['id'])) {

    $task_id  = $db->start_task($task, 'staff', $_POST['id'], $employee['username']);

    $contact = new contact;

    $data = $contact->get_contact($_POST['id']);
    $ownership = new ownership($data['data']['owner'], $data['data']['public']);
    if ($ownership->result != '1') {
        echo "0+++" . $ownership->reason;
        exit;

    }
    $id = $_POST['id'];
    if ($_POST['status'] == '3') {
        $q1 = $db->update("

        UPDATE `ppSD_contacts`

        SET `status`='3'

        WHERE `id`='" . $db->mysql_clean($_POST['id']) . "'

        LIMIT 1

    ");
        $add = $db->add_history('contact_dead', $employee['id'], $_POST['id'], '2', $_POST['id']);

    } else {
        $q1 = $db->update("

        UPDATE `ppSD_contacts`

        SET `status`='1'

        WHERE `id`='" . $db->mysql_clean($_POST['id']) . "'

        LIMIT 1

    ");
        $add = $db->add_history('contact_reopen', $employee['id'], $_POST['id'], '2', $_POST['id']);

    }


// Re-cache
    $data         = $contact->get_contact($id, '1');
    $content      = $data['data'];
    $return       = array();
    $table_format = new table('contact', 'ppSD_contacts');

    if ($_POST['status'] == '3') {
        $return['show_saved']   = 'Marked Dead';
        $return['add_class']    = array(
            'id'    => 'td-cell-' . $_POST['id'],
            'class' => 'dead',
        );
        $return['close_slider'] = '1';

    } else {
        $return['show_saved']   = 'Re-Opened';
        $return['update_row']   = $cell;
        $return['remove_class'] = array(
            'id'    => 'td-cell-' . $_POST['id'],
            'class' => 'dead',
        );

    }
    $cell                 = $table_format->render_cell($content, '1');
    $return['update_row'] = $cell;

    $task                 = $db->end_task($task_id, '1');

}


// --------------------------------
// Multiple at once...
else {

    if ($_POST['status'] == '3') {
        $return['show_saved'] = 'Marked Dead';
        $return['add_classes'] = array();

        foreach ($_POST as $name => $value) {
            if ($name == 'id' || $name == 'ext' || $name == 'edit' || $name == 'status') {
                continue;
            } else {
                $q1 = $db->update("
                    UPDATE `ppSD_contacts`
                    SET `status`='3'
                    WHERE `id`='" . $db->mysql_clean($name) . "'
                    LIMIT 1
                ");

                $return['add_classes']['td-cell-' . $name] = 'dead';

                $add = $db->add_history('contact_dead', $employee['id'], $name, '2', $name);
            }
        }

    }

}

echo "1+++" . json_encode($return);
exit;



