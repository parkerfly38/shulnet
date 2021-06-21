<?php 


$table = 'ppSD_history';


$user = new user;

$data = $user->get_user($_POST['id']);


// History

$criteria = array(
    'user_id' => $data['data']['id']
);

$get_crit = htmlentities(serialize($criteria));


$history = new history('', $criteria, '1', '50', 'date', 'DESC', $table);



?>





<form action="cp-includes/get_table.php" id="slider_sorting" method="post"
      onsubmit="return update_slider_table('<?php echo $table; ?>');">

    <input type="hidden" name="user_id" value="<?php echo $_POST['id']; ?>"/>

    <input type="hidden" name="criteria" value="<?php echo $get_crit; ?>"/>

    <input type="hidden" name="order" value="date"/>

    <input type="hidden" name="dir" value="DESC"/>

    <div id="slider_top_table">

        <div class="floatright">

            <span>Displaying <input type="text" name="display" value="<?php echo $history->{'display'}; ?>"
                                    style="width:35px;" class="normalpad"/> of <span
                    id="sub_total_display"><?php echo $history->{'total_results'}; ?></span></span>

            <span class="div">|</span>

            <span>Page <input type="text" name="page" value="<?php echo $history->{'page'}; ?>" style="width:25px;"
                              class="normalpad"/> of <span
                    id="sub_page_number"><?php echo $history->{'pages'}; ?></span></span>

            <span><input type="submit" value="Go" style="position:absolute;left:-9999px;width:1px;height:1px;"/></span>

        </div>

        <div class="floatleft">

            &nbsp;

        </div>

        <div class="clear"></div>

    </div>

</form>


<form action="" id="slider_checks" method="post">

    <table class="tablesorter listings" id="subslider_table" border="0">

        <?php

        echo $history->table_cells['th'];

        echo $history->table_cells['td'];

        ?>

    </table>

</form>


<div id="bottom_delete">
    <div class="pad16"><span class="small gray caps bold" style="margin-right:24px;">With Selected:</span><input
            type="button" value="Delete" class="del"
            onclick="return compile_delete('<?php echo $table; ?>','slider_checks');"/></div>
</div>