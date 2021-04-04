<?php
// page
// display
// Load the basics
require "../sd-system/config.php";
$admin = new admin;
if ($_POST['edit'] == '1') {
    $type = 'edit';

} else {
    $type = 'add';

}
$task = 'content-section-' . $type;
// Check permissions and employee
$employee = $admin->check_employee($task);
$task_id  = $db->start_task($task, 'staff', $_POST['id'], $employee['username']);
$content  = new content;
if (empty($_POST['name'])) {
    echo "0+++Permalink is required.";
    exit;
} else {
    $perma = $content->format_permalink($_POST['name']);
    $check = $content->get_section($perma);
    if ($check['error'] != '1') {
        echo "0+++Section already exists.";
        exit;
    } else {
        $_POST['name'] = $perma;
    }
}

// Primary fields for main table
$primary    = array();
$ignore     = array('id', 'edit', 'type');
$query_form = $admin->query_from_fields($_POST, $type, $ignore, $primary);
if ($type == 'edit') {
    /*
    $update1 = $db->update("
        UPDATE
            `ppSD_sections`
        SET
            `name`='" . $db->mysql_clean($_POST['name']) . "',
            `display_title`='" . $db->mysql_clean($_POST['display_name']) . "',
            `secure`='" . $db->mysql_clean($_POST['secure']) . "'
        WHERE
            `name`='" . $db->mysql_clean($_POST['id']) . "'
        LIMIT 1
	");
    */
    $perma   = $content->format_permalink($_POST['name']);
    $update2 = $db->update("
        UPDATE
            `ppSD_content`
        SET
            `name`='" . $db->mysql_clean($_POST['display_name']) . "',
            `secure`='" . $db->mysql_clean($_POST['secure']) . "',
            `permalink`='" . $db->mysql_clean($perma) . "',
            `permalink_clean`='" . $db->mysql_clean($perma) . "'
        WHERE
            `id`='" . $db->mysql_clean($_POST['id']) . "'
        LIMIT 1
	");
    $id      = $_POST['name'];

} else {
    // name	display_title	url	subsection	main_nav
    /*

    $go = $db->insert("

		INSERT INTO `ppSD_sections` (

            `name`,

            `display_title`,

            `secure`

		)

		VALUES (

            '" . $db->mysql_clean($_POST['name']) . "',

            '" . $db->mysql_clean($_POST['display_name']) . "',

            '" . $db->mysql_clean($_POST['secure']) . "'

		)

	");

    */
    $perma = $content->format_permalink($_POST['name']);
    $go    = $db->insert("
		INSERT INTO `ppSD_content` (
            `name`,
            `permalink`,
            `permalink_clean`,
            `type`,
            `secure`
		)
		VALUES (
            '" . $db->mysql_clean($_POST['display_name']) . "',
            '" . $db->mysql_clean($perma) . "',
            '" . $db->mysql_clean($perma) . "',
            'section',
            '" . $db->mysql_clean($_POST['secure']) . "'
		)
	");
    $id    = $_POST['name'];

}
// Re-cache
$task                  = $db->end_task($task_id, '1');
$table                 = 'ppSD_content';
$scope                 = 'content';
$history               = new history($id, '', '', '', '', '', $table);
$content               = $history->final_content;
$table_format          = new table($scope, $table);
$return                = array();
$return['close_popup'] = '1';
if ($type == 'add') {
    $cell                       = $table_format->render_cell($content);
    $return['append_table_row'] = $cell;
    $return['show_saved']       = 'Section Created';

} else {
    $cell                 = $table_format->render_cell($content, '1');
    $return['update_row'] = $cell;
    $return['show_saved'] = 'Section Updated';

}
echo "1+++" . json_encode($return);
exit;