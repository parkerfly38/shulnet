<?php 


$permission = 'feed';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $admin->show_no_permissions();

} else {
    $table         = 'ppSD_history';
    $order         = 'ppSD_history.date';
    $dir           = 'DESC';
    $display       = '50';
    $page          = '1';
    $defaults      = array(
        'sort'    => $order,
        'order'   => $dir,
        'page'    => $page,
        'display' => $display,
        'filters' => array('-||method||neq||ppSD_history'),
    );
    $force_filters = array();
    if ($employee['permissions']['admin'] != '1') {
        $force_filters[] = array(
            $employee['id'] . '||owner||eq||ppSD_history',
            '2||owner||eq||ppSD_history',
        );

    }
    $gen_table = $admin->get_table($table, $_GET, $defaults, $force_filters);

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

                    <span><b>Listing Activity Feed</b></span>

                    <span class="div">|</span>

                    <a href="null.php" onclick="return show_filters();">Filters<img src="imgs/down-arrow.png"
                                                                                    id="filter_arrow" width="10"
                                                                                    height="10" alt="Expand" border="0"
                                                                                    class="icon-right"/></a>

                    <?php
                    include PP_PATH . "/admin/cp-includes/user_link_menu.php";
                    ?>

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

                        <!--<span><a href="null.php" onclick="return popup('filters-<?php echo $permission; ?>');"><img src="imgs/icon-settings.png" width="16" height="16" border="0" alt="Settings" title="Settings" class="icon" />Settings</a></span>-->

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
                            'date::1:1',
                            'plugin:::',
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

                        <label>Method</label>

                        <div class="field_entry">

                            <select name="filter[method]" style="width:110px;" class="filterinputtype">

                                <option value=""></option>

                                <?php
                                $history = new history;
                                $methods = $history->method_list();
                                foreach ($methods as $name) {
                                    echo "<option value=\"" . $name['id'] . "\">" . $name['name'] . "</option>";

                                }

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