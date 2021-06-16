<?php

require "../sd-system/config.php";
$admin = new admin;
if ($_POST["edit"]=='1')
{
    $type="edit";
} else {
    $type="add";
}
$task = 'familymember-' . $type;

//check permissions
$employee = $admin->check_employee($task);
$task_id  = $db->start_task($task, 'staff', $_POST['id'], $employee['username']);
$familymembers = new familymembers();

$familymember_id = $_POST["id"];

if ($type == "edit")
{
    $familymember = $familymembers->getFamilyMemberByID($_POST["id"]);
    $familymember["first_name"] = $_POST["first_name"];
    $familymember["last_name"] = $_POST["last_name"];
    $familymember["address_line_1"] = $_POST["address_line_1"];
    $familymember["address_line_2"] = $_POST["address_line_2"];
    $familymember["city"] = $_POST["city"];
    $familymember["state"] = $_POST["state"];
    $familymember["zip"] = $_POST["zip"];
    $familymember["country"] = $_POST["country"];
    $familymember["phone"] = $_POST["phone"];
    $familymember["email"] = $_POST["email"];
    $familymember["DOB"] = $_POST["DOB"];
    $familymember["hebrew_name"] = $_POST["hebrew_name"];
    $familymember["bnai_mitzvah_date"] = $_POST["bnai_mitzvah_date"];
    $familymembers->updateFamilyMember($familymember);
} else {
    $familymember = new familymember(
        $_POST["id"], $_POST["member_id"], $_POST["first_name"], $_POST["last_name"],
        $_POST["address_line_1"], $_POST["address_line_2"], $_POST["city"],
        $_POST["state"], $_POST["zip"], $_POST["country"], $_POST["phone"],
        $_POST["email"], $_POST["DOB"], $_POST["hebrew_name"], $_POST["bnai_mitzvah_date"]);
    $familymember_id = $familymembers->addFamilyMember($familymember);
}

//$recache
$data = $familymembers->getFamilyMemberByID($familymember_id);
$use_in_table = $data;
$return = array();
$return['close_popup'] = '1';
if ($type == "add")
{
    $return["show_saved"] = "Created Family Member ".$data->first_name . " " . $data->last_name;
    $return["append_table_row"] = "<tr><td><input type='checkbox' name='".$data->id."' value='1' /></td>";
    $return["append_table_row"] .= "  <td><a href='null.php' onclick=\"return popup('familymember-add','id=".$data->id."','1');\">".$data->last_name.", ".$data->first_name."</a></td>";
    $return["append_table_row"] .=  "  <td>".$data->city."</td>";
    $return["append_table_row"] .=  "  <td>".$data->state."</td>";
    $return["append_table_row"] .=  "  <td>".$data->email."</td>";
    $return["append_table_row"] .=  "  <td>".$data->DOB."</td>";
    $return["append_table_row"] .=  "  <td class=\"options\" style=\"width:52px;\"><a href=\"return_null.php\" onclick=\"return delete_item('ppSD_member_family','".$data->id."');\"><img src=\"imgs/icon-delete.png\" width=\"16\" height=\"16\" border=\"0\" class=\"icon\" alt=\"Delete\" title=\"Delete\"></a></td>";
    $return["append_table_row"] .=  "</tr>";
} else {
    $return["show_saved"] = "Created Family Member ".$data->first_name . " " . $data->last_name;
    $return["update_row"] = "<tr><td><input type='checkbox' name='".$data->id."' value='1' /></td>";
    $return["update_row"] .= "  <td><a href='null.php' onclick=\"return popup('familymember-add','id=".$data->id."','1');\">".$data->last_name.", ".$data->first_name."</a></td>";
    $return["update_row"] .=  "  <td>".$data->city."</td>";
    $return["update_row"] .=  "  <td>".$data->state."</td>";
    $return["update_row"] .=  "  <td>".$data->email."</td>";
    $return["update_row"] .=  "  <td>".$data->DOB."</td>";
    $return["update_row"] .=  "  <td class=\"options\" style=\"width:52px;\"><a href=\"return_null.php\" onclick=\"return delete_item('ppSD_member_family','".$data->id."');\"><img src=\"imgs/icon-delete.png\" width=\"16\" height=\"16\" border=\"0\" class=\"icon\" alt=\"Delete\" title=\"Delete\"></a></td>";
    $return["update_row"] .=  "</tr>";
    $return["refresh_slider"] = '1';
}

echo "1+++" . json_encode($return);
exit;
$task = $db->end_task($task_id, '1');
echo "1+++" . $_POST['id'] . "+++refresh";
exit;