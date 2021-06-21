<?php

$familymember = new familymembers;

$data = $familymember->getFamilyMembersByMemberID($_POST["id"]); 

?>






    <div id="slider_top_table">

        
        <div class="floatleft">

        <input type="button" value="New" class="save"
                   onclick="return popup('familymember-add','user_id=<?php echo $_POST["id"]; ?>&scope=','1');"/>

        </div>

        <div class="clear"></div>

    </div>


<form action="" id="slider_checks" method="post">

    <table class="tablesorter listings" id="subslider_table" border="0">

        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>City</th>
                <th>State</th>
                <th>Email</th>
                <th>Birthdate</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($data as $row)
            {
                echo "<tr>";
                echo "  <td><input type='checkbox' name='".$row->id."' value='1' /></td>";
                echo "  <td><a href='null.php' onclick=\"return popup('familymember-add','id=".$row->id."','1');\">".$row->last_name.", ".$row->first_name."</a></td>";
                echo "  <td>".$row->city."</td>";
                echo "  <td>".$row->state."</td>";
                echo "  <td>".$row->email."</td>";
                echo "  <td>".$row->DOB."</td>";
                echo "  <td class=\"options\" style=\"width:52px;\"><a href=\"return_null.php\" onclick=\"return delete_item('ppSD_member_family','".$row->id."');\"><img src=\"imgs/icon-delete.png\" width=\"16\" height=\"16\" border=\"0\" class=\"icon\" alt=\"Delete\" title=\"Delete\"></a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

</form>


<div id="bottom_delete">
    <div class="pad16"><span class="small gray caps bold" style="margin-right:24px;">With Selected:</span><input
            type="button" value="Delete" class="del"
            onclick="return compile_delete('yahrzeit_member','slider_checks','<?php echo $_POST['id']; ?>');"/></div>
</div>