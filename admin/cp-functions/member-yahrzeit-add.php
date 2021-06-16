<?php
    require "../sd-system/config.php";  
    $data = array($_POST);
    $yz = new yahrzeits;
    $yz->create_yahrzeit_relationship($data[0]);
    $newyahrzeit = $yz->get_member_yarhzeit($_POST["yahrzeit"], $_POST["user_id"]);
    $return                = array();
    $return['close_popup'] = '1'; // For quick add
    $return['show_saved'] = 'Added ' . $newyahrzeit['English_Name'];
    $return['append_table_row'] = "<tr id='td-cell-".$newyahrzeit["id"]."'><td class='center'><input type='checkbox' name='".$newyahrzeit["id"]."' value='1' /></td>";
    $return['append_table_row'] .= "<td id=\"".$newyahrzeit["id"]."-English_Name\">".$newyahrzeit["English_Name"]."</td>";
    $return['append_table_row'] .= "<td id=\"".$newyahrzeit["id"]."-Hebrew_Name\">".$newyahrzeit["Hebrew_Name"]."</td>";
    $return['append_table_row'] .= "<td id=\"".$newyahrzeit["id"]."-English_Date_of_Death\">".$newyahrzeit["English_Date_of_Death"]."</td>";
    $return['append_table_row'] .= "<td id=\"".$newyahrzeit["id"]."-Hebrew_Date_of_Death\">".$newyahrzeit["Hebrew_Date_of_Death"]."</td>";
    $return['append_table_row'] .= "<td id=\"".$newyahrzeit["id"]."-Relationship\">".$newyahrzeit["Relationship"]."</td>";
    $return['append_table_row'] .= "<td class=\"options\" style=\"width: 72px;\"><a href=\"return null.php\" onclick=\"return delete_item('ppSD_yahrzeits','".$newyahrzeit["id"]."');\"><img src=\"imgs/icon-delete.png\" width=\"16\" height=\"16\" border=\"0\" class=\"icon\" alt=\"Delete\" title=\"Delete\"></a></td></tr>";
    echo "1+++" . json_encode($return);
    exit;
?>