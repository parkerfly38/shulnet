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
$task = 'content-redirect-' . $type;
// Check permissions and employee
$employee = $admin->check_employee($task);
$task_id  = $db->start_task($task, 'staff', $_POST['id'], $employee['username']);
// Check requirements
$content = new content;
if (empty($_POST['permalink'])) {
    echo "0+++Permalink is required.";
    exit;

} else {
    $perma = $content->format_permalink($_POST['permalink']);
    $check = $content->check_permalink($perma);
    if (!empty($check['id']) && $_POST['id'] != $check) {
        echo "0+++Permalink already exists.";
        exit;

    } else {
        $_POST['permalink'] = $perma;

    }

}
$check = $db->check_url($_POST['url']);
if ($check != '1') {
    echo "0+++The URL does not exist or is not properly formatted (http://www.yoursite.com).";
    exit;

}
// Primary fields for main table
$primary    = array();
$ignore     = array('id', 'edit', 'template', 'menus');
$query_form = $admin->query_from_fields($_POST, $type, $ignore, $primary);
if ($type == 'edit') {
    // Get item
    $content = new content;
    $item    = $content->get_content($_POST['id']);
    // Clear menus
    $site = new site;
    foreach ($item['menus'] as $menu) {
        $site->delete_link_from_menu($menu, $_POST['id']);

    }
    // Update content
    $up = $db->update("

        UPDATE

            `ppSD_content`

        SET " . substr($query_form['u2'], 1) . "

        WHERE

            `id`='" . $db->mysql_clean($_POST['id']) . "'

        LIMIT 1

    ");
    // Re-cache menus
    if (!empty($_POST['menus'])) {
        foreach ($_POST['menus'] as $menu) {
            $add = $site->add_to_menu($menu, $_POST['name'], '1', $_POST['permalink'], $_POST['id']);

        }

    }
    $id = $_POST['id'];

} else {
    // Account
    $id = $db->insert("

		INSERT INTO `ppSD_content` (`id`" . $query_form['if2'] . ")

		VALUES ('" . $db->mysql_cleans($_POST['id']) . "'" . $query_form['iv2'] . ")

	");
    // Menus?
    if (!empty($_POST['menus'])) {
        $site = new site;
        foreach ($_POST['menus'] as $aMenu) {
            $add = $site->add_to_menu($aMenu, $_POST['name'], '1', $_POST['permalink'], $id);

        }

    }

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
    $return['show_saved']       = 'Created Redirection';

} else {
    $cell                 = $table_format->render_cell($content, '1');
    $return['update_row'] = $cell;
    $return['show_saved'] = 'Updated Redirection';

}
echo "1+++" . json_encode($return);
exit;

