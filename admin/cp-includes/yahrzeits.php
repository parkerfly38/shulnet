<?php

$permission = 'calendar';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $admin->show_no_permissions();
} else {
    
    if (!empty($_GET['criteria_id'])) {
        $criteria_id = $_GET['criteria_id'];
    } else {
        $criteria_id = '';
    }

    $useDisplay = '';
    $useSort = '';
    $useOrder = '';

    if (! empty($criteria_id)) {
        $crit = new criteria($criteria_id);
        if (! empty($crit->data['sort'])) {
            $useSort = $crit->data['sort'];
            if ($useSort == 'username') {
                $useSort = 'ppSD_members.username';
            } else {
                $useSort = 'ppSD_member_data.' . $useSort;
            }
        }
        if (! empty($crit->data['sort_order'])) {
            $useOrder = $crit->data['sort_order'];
        }
        if (! empty($crit->data['display_per_page'])) {
            $useDisplay = $crit->data['display_per_page'];
        }
    }
    $ordering = $admin->build_ordering('ppSD_yahrzeits.English_Date_of_Death','DESC','50','1');
    $table = 'ppSD_yahrzeits';
    $defaults = array(
        'sort' => $ordering['order'],
        'order' => $ordering["dir"],
        'page' => $ordering["page"],
        'display' => $ordering["display"],
        'filters' => array()
    );
    $force_filters = array();
    if ($employee['permissions']['admin'] != '1') {
        $force_filters[] = array(
            $employee['id'] . '||for||eq||ppSD_yahrzeits',
            '1||public||eq||ppSD_yahrzeits',
            '2||public||eq||ppSD_yahrzeits',
            $employee['id'] . '||added_by||eq||ppSD_yahrzeits',
        );

    }
    $gen_table = $admin->get_table($table, $_GET, $defaults, $force_filters, $criteria_id);
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

                <span><b>Listing Yahrzeits</b></span>

                
                                                                                
                <span class="div">|</span>
                <span class="innerLinks">
                    <a href="null.php" onclick="return load_page('yahrzeit','add');">Create Yahrzeit</a>
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
                    'date:ppSD_notes:1:1',
                    'deadline:ppSD_notes:1:1',
                    'name:ppSD_notes::',
                    'value:ppSD_notes::',
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

                            <p class="field_desc_show">Create a date range by inputting two dates, or select a specific
                                date
                                by only inputting the first field. All dates need to be in the "YYYY-MM-DD" format.</p>

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

                    <select name="filter[public]" style="width:110px;" class="filterinputtype">

                        <option value=""></option>

                        <option value="1">Public</option>

                        <option value="2">Broadcast</option>

                        <option value="0">Private</option>

                    </select>

                </div>

            </div>

            <div class="field">

                <label>Label</label>

                <div class="field_entry">

                    <select name="filter[label]" style="width:110px;" class="filterinputtype">

                        <option value=""></option>

                        <?php

                        $labs = $admin->get_note_labels('', 'array');

                        foreach ($labs as $id => $name) {
                            echo "<option value=\"$id\">$name</option>";

                        }

                        ?>

                    </select>
                    <input type="hidden" name="filter_type[label]" value="eq"/>

                </div>

            </div>

            <?php

            if ($employee['permissions']['admin'] == '1') {
                ?>

                <div class="field">

                    <label>Posted By</label>

                    <div class="field_entry">

                        <input type="text" id="owner"
                               onkeyup="return autocom('owner','id','username','ppSD_staff','username,firstname,lastname','staff');"
                               value="" style="width:110px;" class="filterinputtype"/>

                        <input type="hidden" name="filter[added_by]" id="owner_id" value=""/>

                    </div>

                </div>

                <div class="field">

                    <label>For</label>

                    <div class="field_entry">

                        <input type="text" id="for"
                               onkeyup="return autocom('owner','id','username','ppSD_staff','username,firstname,lastname','staff');"
                               value="" style="width:110px;" class="filterinputtype"/>

                        <input type="hidden" name="filter[for]" id="for_id" value=""/>

                    </div>

                </div>

                <div class="field">

                    <label>Pinned</label>

                    <div class="field_entry">

                        <select name="filter[pin]" style="width:250px;" class="filterinputtype">
                            <option value=""></option>
                            <option value="2">Dashboard Homepage</option>
                            <option value="1">To Specific Items</option>
                        </select>

                    </div>

                </div>

            <?php

            }

            ?>

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
                <div class="pad16">


                    <span class="small gray caps bold" style="margin-right:24px;">With Selected:</span><input
                        type="button" value="Delete" class="del"
                        onclick="return compile_delete('<?php echo $table; ?>','table_checkboxes');"/>

                </div>
            </div>

        </form>

    </div>



<?php

}