<?php 

/**
 *
 *
 * Zenbership Membership Software
 * Copyright (C) 2013-2016 Castlamp, LLC
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author      Castlamp
 * @link        http://www.castlamp.com/
 * @link        http://www.zenbership.com/
 * @copyright   (c) 2013-2016 Castlamp
 * @license     http://www.gnu.org/licenses/gpl-3.0.en.html
 * @project     Zenbership Membership Software
 */

$permission = 'event';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $admin->show_no_permissions();

} else {
    $table         = 'ppSD_events';
    $order         = 'ppSD_events.starts';
    $dir           = 'DESC';
    $display       = '50';
    $page          = '1';
    $defaults      = array(
        'sort'    => $order,
        'order'   => $dir,
        'page'    => $page,
        'display' => $display,
        'filters' => array(
            '2||status||neq||ppSD_events',
            date('Y-m-d H:i:s') . '||ends||gt||ppSD_events',
        ),
    );
    $force_filters = array();
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
                <span><b>Listing Events</b></span>
                <span class="div">|</span>
                <a href="null.php" onclick="return show_filters();">Filters<img src="imgs/down-arrow.png"
                                                                                id="filter_arrow" width="10" height="10"
                                                                                alt="Expand" border="0"
                                                                                class="icon-right"/></a>
                <span class="div">|</span>
                <span id="innerLinks">
                    <a href="prevent_null.php" onclick="return popup('event-add','','1');">Create Event</a>
                    <a href="index.php?l=calendars">Calendars</a>
                    <a href="prevent_null.php" onclick="return popup('event_types');">Event Types</a>
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

	   			<span><?php

                    echo $admin->alpha_list('events', 'name', 'ppSD_events');

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
                        'starts:ppSD_events:1:1',
                        'ends:ppSD_events:1:1',
                        'start_registrations:ppSD_events:1:1',
                        'close_registration:ppSD_events:1:1',
                        'city:ppSD_events::',
                        'state:ppSD_events::',
                        'country:ppSD_events::',
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

                    <label>Name</label>

                    <div class="field_entry">

                        <input type="text" value="" name="filter[name]" style="width:110px;" class="filterinputtype"/>

                    </div>

                </div>

                <div class="field">

                    <label>Location Name</label>

                    <div class="field_entry">

                        <input type="text" value="" name="filter[location_name]" style="width:110px;"
                               class="filterinputtype"/>

                    </div>

                </div>

                <div class="field">

                    <label>Calendar</label>

                    <div class="field_entry">

                        <input type="text" value="" name="calendar_name" id="calendar"
                               onkeyup="return autocom('calendar','id','name','ppSD_calendars','name','calendars');"
                               style="width:110px;" class="filterinputtype"/>

                        <input type="hidden" name="filter[calendar]" id="account_id" value=""/>

                    </div>

                </div>


                <div class="field">

                    <label>Status</label>

                    <div class="field_entry">

                        <select name="filter[status]">
                            <option></option>
                            <option value="1">Live</option>
                            <option value="0">Hidden</option>
                            <option value="2">Canceled</option>
                        </select>

                    </div>

                </div>

                <div class="field">

                    <label>Guests</label>

                    <div class="field_entry">

                        <select name="filter[allow_guests]">

                            <option></option>

                            <option value="1">Allow Guests</option>

                            <option value="0">No Guests Allowed</option>

                        </select>

                    </div>

                </div>

                <div class="field">

                    <label>Max Attendees</label>

                    <div class="field_entry">

                        <input type="text" value="" name="filter[max_rsvps]" style="width:110px;"
                               class="filterinputtype"/>

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