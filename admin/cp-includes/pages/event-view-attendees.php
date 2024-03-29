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

$event = new event;
$dets = $event->get_name($_POST['id']);
//$attendees = $event->get_event_rsvps($_POST['id']);

$table = 'ppSD_event_rsvps';

// History
$criteria = array(
    'use_advanced'      => '1',
    rand(100, 99999999) => $_POST['id'] . '||event_id||eq||ppSD_event_rsvps',
);

// Additional sorting options.
if (! empty($_POST['filter'])) {
    $add_criteria = $admin->build_subslider_criteria($_POST['filter'], $_POST['filter_type'], $_POST['filter_tables']);
    $add_fields   = $add_criteria['fields'];
    $criteria     = array_merge($criteria, $add_criteria['criteria']);
} else {
    $add_fields = '';
}

$get_crit = htmlentities(serialize($criteria));
$history = new history('', $criteria, '1', '50', 'ppSD_event_rsvp_data.last_name', 'ASC', $table, 'ppSD_event_rsvp_data');
$print_title = $dets . ' Registration List';

?>

<form action="cp-includes/get_table.php" id="slider_sorting" method="post"
      onsubmit="return update_slider_table('<?php echo $table; ?>','ppSD_event_rsvp_data');">
    <input type="hidden" name="event_id" value="<?php echo $_POST['id']; ?>"/>
    <?php
    echo $add_fields;
    ?>
    <input type="hidden" name="order" value="ppSD_event_rsvp_data.last_name"/>
    <input type="hidden" name="dir" value="ASC"/>
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
            <input type="button" value="Add Attendee" class="save"
                   onclick="return popup('rsvp-add','event=<?php echo $_POST['id']; ?>');"/>
            <input type="button" value="E-Mail"
                   onclick="return get_slider_subpage('email','','<?php echo $get_crit; ?>');"/>
            <input type="button" value="Export"
                   onclick="popup('export_rsvp','event_id=<?php echo $_POST['id']; ?>&data=<?php echo $get_crit; ?>','');"/>
            <input type="button" value="Print"
                   onclick="window.open('<?php echo PP_ADMIN . '/cp-functions/print.php?type=build&scope=rsvp&title=' . urlencode($print_title) . '&order=ppSD_event_rsvp_data.last_name&dir=ASC&data=' . $get_crit; ?>','Print Window')"/>
            <input type="button" value="Apply Filters"
                   onclick="return popup('rsvp-filters','data=<?php echo $get_crit; ?>','');"/>
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