<?php

require "../sd-system/config.php";
$admin        = new admin;
$employee     = $admin->check_employee('');
$disable_akax = $db->get_eav_value('employee-' . $employee['id'], 'disable_akax');
if ($disable_akax != '1') {
    $last_check = $db->get_eav_value('employee-' . $employee['id'], 'last_ajax_check');
    $history    = new history('', '', '', '', '', '', '');


    if ($employee['permissions']['admin'] == '1') {
        $where_clause = "ppSD_history.owner = '2' OR";
    } else {
        $where_clause = '';
    }

    $q1         = $db->run_query("
        SELECT
            ppSD_history.id,
            ppSD_history.user_id,
            ppSD_history.method,
            ppSD_history.date,
            ppSD_history.act_id,
            ppSD_history.owner,
            ppSD_history.notes,
            ppSD_history.type
        FROM
            `ppSD_history`
        JOIN
            `ppSD_activity_methods`
        ON
            ppSD_history.method=ppSD_activity_methods.id
        WHERE
            ppSD_activity_methods.in_feed = '1' AND
            ppSD_history.date > '" . $db->mysql_clean($last_check) . "' AND
            ppSD_history.method != '' AND
            (
                $where_clause
                ppSD_history.owner = '" . $db->mysql_clean($employee['id']) . "'
            )
        ORDER BY
            `date` DESC
    ");
    $list       = '';
    $tot        = 0;
    while ($activity = $q1->fetch()) {
        $tot++;
        if ($tot <= 10) {
            $act_data = $history->get_method_data($activity['method'], $activity['act_id'], $activity['date'], $activity['owner'], $activity['type'], $activity['user_id'], $activity);

            $list .= '<li>' . $act_data['icon'] . $act_data['difference'] . ': ' . $act_data['title'] . '</li>';
        }

    }
    if ($tot > 10) {
        $dif = $tot - 10;
        $list .= '<li id="more"><a href="index.php?l=feed">' . $dif . ' additional notices</a></li>';

    } else if ($tot <= 0) {
        $list = 'na';

    }
    $db->update_eav('employee-' . $employee['id'], 'last_ajax_check', current_date());
    echo $list;
    exit;

}



