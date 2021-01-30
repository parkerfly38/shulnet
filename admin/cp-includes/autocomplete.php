<?php 



require "../sd-system/config.php";
$admin = new admin;

// Check permissions and employee
if (!empty($_POST['permission'])) {
    $employee = $admin->check_employee($_POST['permission']);
}

$fields_exp = explode(',', $_POST['fields']);
$fields     = '';

foreach ($fields_exp as $aField) {
    $data = explode('|', $aField);
    if (!empty($data['1'])) {
        $use_val = $data['1'];
    } else {
        $use_val = $_POST['value'];
    }
    $fields .= " OR `" . $db->mysql_cleans($data['0']) . "` LIKE '%" . $db->mysql_cleans($use_val) . "%'";
}

$fields         = substr($fields, 4);
$dis_fields     = explode(',', $_POST['display_field']);

$display_fields = '';

foreach ($dis_fields as $item) {
    $display_fields .= ',`' . $db->mysql_cleans($item) . '`';

}
$display_fields = ltrim($display_fields, ',');
if ($_POST['table'] == 'ppSD_cart_sessions') {
    $fields .= " AND `status`='1'";
}

$STH     = $db->run_query("
	SELECT $display_fields,`" . $db->mysql_cleans($_POST['return_field']) . "`
	FROM `" . $db->mysql_cleans($_POST['table']) . "`
	WHERE $fields
	LIMIT 10
");

// echo "0+++SELECT $display_fields,`" . $db->mysql_cleans($_POST['return_field']) . "` FROM `" . $db->mysql_cleans($_POST['table']) . "` WHERE $fields LIMIT 10";

$results = 0;
$compile = '';
while ($row = $STH->fetch()) {
    $results++;
    $return = '';
    foreach ($dis_fields as $item) {
        $return .= $row[$item] . ' ';

    }
    $return = trim($return);
    $compile .= "<li onclick=\"return autocomplete_select('" . addslashes($row[$_POST['return_field']]) . "','" . addslashes($return) . "');\">" . $return . "</li>";
}
$compile = str_replace('+++', '&#43;&#43;&#43;', $compile);

echo "1+++" . $results . "+++" . $compile;
exit;