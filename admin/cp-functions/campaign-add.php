<?php
// Load the basics
require "../sd-system/config.php";
$admin = new admin;
if ($_POST['edit'] == '1') {
    $type = 'edit';

} else {
    $type = 'add';

}
$task = 'campaign-' . $type;
// Check permissions and employee
$employee = $admin->check_employee($task);
$task_id  = $db->start_task($task, 'staff', $_POST['id'], $employee['username']);
// Primary fields for main table
$table      = 'ppSD_campaigns';
$primary    = array('');
$ignore     = array('id', 'edit');
$query_form = $admin->query_from_fields($_POST, $type, $ignore, $primary);
// ----------------------------
if ($type == 'edit') {
    // Update the contact
    $update_set1          = substr($query_form['u1'], 1);
    $update_set2          = substr($query_form['u2'], 1);
    $q                    = $db->update("

		UPDATE `$table`

		SET $update_set2

		WHERE `id`='" . $db->mysql_cleans($_POST['id']) . "'

		LIMIT 1

	");
    $last_id              = $_POST['id'];
    $task                 = $db->end_task($task_id, '1');
    $return               = array(
        'show_saved' => 'Updated Campaign',
    );
    $campaign             = new campaign($_POST['id']);
    $content              = $campaign->get_campaign();
    $table_format         = new table('campaign', 'ppSD_campaigns');
    $cell                 = $table_format->render_cell($content, '1');
    $return['update_row'] = $cell;
    echo "1+++" . json_encode($return);
    exit;

} else {
    // Create the contact
    $insert_fields2 = substr($query_form['if2'], 1);
    $insert_values2 = substr($query_form['iv2'], 1);
    $last_id        = $db->insert("

		INSERT INTO `$table` (`id`,`date`,`owner`,$insert_fields2)

		VALUES ('" . $db->mysql_cleans($_POST['id']) . "','" . current_date() . "','" . $employee['id'] . "',$insert_values2)

	");
    // Generate a default form
    $form_builder = new form_builder();
    $form_data    = array(
        'id'            => 'campaign-' . $_POST['id'],
        'type'          => 'campaign',
        'act_id'        => $_POST['id'],
        'name'          => 'Campaign Signup Form',
        'preview'       => '0',
        'pages'         => '1',
        'code_required' => '0',
    );
    $fields       = array(
        'email'      => '1',
        'first_name' => '1',
        'last_name'  => '1',
    );
    $add          = $form_builder->create_form($form_data, $fields);
    $aCond        = array(
        'field'       => 'zen_fixed_autopop',
        'eq'          => 'eq',
        'value'       => '',
        'type'        => 'campaign',
        'campaign_id' => $_POST['id'],
    );
    $condition    = new conditions;
    $condition->create_condition($aCond, $_POST['id']);
    $task = $db->end_task($task_id, '1');
    // Proceed
    $campaign                   = new campaign($_POST['id']);
    $content                    = $campaign->get_campaign();
    $table_format               = new table('campaign', 'ppSD_campaigns');
    $cell                       = $table_format->render_cell($content);
    $return                     = array(
        'close_popup' => '1',
        'show_saved'  => 'Campaign Created',
        'load_slider' => array(
            'page'    => 'campaign',
            'subpage' => 'view',
            'id'      => $_POST['id'],
        ),
    );
    $return['append_table_row'] = $cell;
    echo "1+++" . json_encode($return);
    exit;

}





