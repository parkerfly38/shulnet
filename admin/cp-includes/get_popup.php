<?php 


require "../sd-system/config.php";
$admin = new admin;
/**
 *    Gets a page to be populated
 *    into the popup element.
 */
if (! empty($_POST['p'])) {

    // Check permissions and employee
    $permission = $_POST['p']; // . '-popup';
    $employee   = $admin->check_employee($permission);
    $task_id    = $db->start_task($permission, 'staff', '', $employee['username']);

    $af = new adminFields();

    // Get popup
    $lit = 'popups/' . $_POST['p'] . '.php';

    if (! file_exists($lit)) {
        $edit = explode('-', $_POST['p']);

        $e1 = (! empty($edit['1'])) ? $edit['1'] : ''; // Action
        $e2 = (! empty($edit['0'])) ? $edit['0'] : ''; // Plugin ID

        $ae = new admin_extensions($e1, $employee, $e2);

        $content = $ae->runTask($edit['1'], 'views/popup');
    } else {
        ob_start();
        require($lit);
        $content = ob_get_contents();
        ob_end_clean();
    }

    $task = $db->end_task($task_id, 'staff', $employee['username'], '1');

    $fcontent = str_replace('+++', '&#43;&#43;&#43;', $content);

    echo "1+++" . $fcontent;
    exit;
}