<?php 

$permission = 'employee';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $admin->show_no_permissions();

} else {
    $table         = 'ppSD_staff';
    $order         = 'ppSD_staff.last_name';
    $dir           = 'ASC';
    $display       = '50';
    $page          = '1';
    $defaults      = array(
        'sort'    => $order,
        'order'   => $dir,
        'page'    => $page,
        'display' => $display,
        'filters' => array(),
    );
    $force_filters = array('system||username||noteq||ppSD_staff');
    $gen_table     = $admin->get_table($table, $_GET, $defaults, $force_filters);



    ?>



    <form action="cp-includes/get_table.php" id="table_filters" method="post" onsubmit="return update_table();">

        <input type="hidden" name="order" value="<?php echo $gen_table['order']; ?>"/>

        <input type="hidden" name="dir" value="<?php echo $gen_table['dir']; ?>"/>

        <input type="hidden" name="menu" value="<?php echo $gen_table['menu']; ?>"/>

        <input type="hidden" name="table" value="<?php echo $table; ?>"/>

        <input type="hidden" name="permission" value="<?php echo $permission; ?>"/>

        <div id="topblue" class="fonts small">
            <div class="holder">

                <div class="floatright" id="tb_right">
                    <?php
                    include dirname(__FILE__) . '/pagination_display.php';
                    ?>
                </div>

                <div class="floatleft" id="tb_left">

                    <span><b>Listing Employees</b></span>

                    <span class="div">|</span>

                    <a href="null.php" onclick="return show_filters();">Filters<img src="imgs/down-arrow.png"
                                                                                    id="filter_arrow" width="10"
                                                                                    height="10" alt="Expand" border="0"
                                                                                    class="icon-right"/></a>

                    <span class="div">|</span>

			<span id="innerLinks">

				<a href="null.php" onclick="return load_page('employee-add');">Create Employee</a>
				<a href="index.php?l=usage">Usage Logs</a>
				<a href="null.php" onclick="return popup('departments');">Departments</a>

			</span>

                </div>

                <div class="clear"></div>

            </div>
        </div>


        <div id="filters" class="fonts smaller">
            <div class="pad24">

                <div id="filters_top">

                    <div id="filters_right">

                        <input type="submit" value="Apply Filters" class="save"/>

                    </div>

                    <div id="filters_left">

                        <span><b>Applying Filters</b></span>

	   			<span><?php

                    echo $admin->alpha_list('employees', 'username', $table);

                    ?></span>

                    </div>

                    <div class="clear"></div>

                </div>

                <div class="col50">

                    <?php

                    $optname = $permission . '_filters';

                    $opt_filters = $db->get_option($optname);

                    if (!empty($employee['options'][$optname])) {
                        $thefilters = explode(',', $employee['options'][$optname]);

                    } else if (!empty($opt_filters)) {
                        $thefilters = explode(',', $opt_filters);

                    } else {
                        // name:table:date:date_range
                        $thefilters = array(
                            'username:ppSD_staff::',
                            'first_name:ppSD_staff::',
                            'last_name:ppSD_staff::',
                            'email:ppSD_staff::',
                        );

                    }

                    foreach ($thefilters as $aFilter) {
                        $exp = explode(':', $aFilter);
                        if (empty($exp['1'])) {
                            $exp['1'] = $table;
                        }

                        ?>

                        <div class="field">

                            <label><?php echo format_db_name($exp['0']); ?></label>

                            <div class="field_entry">

                                <?php

                                if ($exp['2'] == '1') {
                                    $date = '1';
                                } else {
                                    $date = '0';
                                }

                                if ($exp['3'] == '1') {
                                    $dater = '1';
                                } else {
                                    $dater = '0';
                                }

                                echo $admin->filter_field($exp['0'], '', $exp['1'], '1', $date, $dater);

                                if ($dater == '1') {
                                    ?>

                                    <p class="field_desc_show">Create a date range by inputting two dates, or select a
                                        specific date by only inputting the first field. All dates need to be in the
                                        "YYYY-MM-DD" format.</p>

                                <?php

                                }

                                ?>

                            </div>

                        </div>

                    <?php

                    }

                    ?>

                </div>

                <div class="col50">

                    <div class="field">

                        <label>Type</label>

                        <div class="field_entry">

                            <select name="filter[permission_group]">

                                <option></option>

                                <?php

                                echo $admin->list_permission_groups();

                                ?>

                            </select>

                        </div>

                    </div>

                </div>

                <div class="clear"></div>

            </div>
        </div>

    </form>



    <div id="mainsection">

        <form id="table_checkboxes">

            <table class="tablesorter listings" id="active_table" border="0">

                <?php

                echo $gen_table['th'];

                echo $gen_table['td'];

                ?>

            </table>


            <div id="bottom_delete">
                <div class="pad16"><span class="small gray caps bold"
                                         style="margin-right:24px;">With Selected:</span><input type="button"
                                                                                                value="Delete"
                                                                                                class="del"
                                                                                                onclick="return compile_delete('<?php echo $table; ?>','table_checkboxes');"/>
                </div>
            </div>

        </form>

    </div>



<?php

}

?>