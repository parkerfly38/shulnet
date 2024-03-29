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

$permission = 'export-rsvp';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {

    echo "0+++You don't have permission to use this feature.";
    exit;

} else {

    if (!empty($_POST['data'])) {
        // Build criteria and proceed
        $crit_array   = unserialize($_POST['data']);
        $crit_array[] = $_POST['event_id'] . '||event_id||eq||ppSD_event_rsvps';
        // Build this export's criteria.
    } else {
        $crit_array = array();
    }

    $act_id = $_POST['event_id']; // <- not really used... no idea why it is here.

    $criteria = new criteria();
    $crit_id = $criteria->build_filters($crit_array, 'rsvp', 'export');
    $get_crit = new criteria($crit_id);

?>

<script type="text/javascript">
    $.ctrl('S', function () {
        document.forms["popupform"].submit();
    });
</script>

<form action="<?php echo PP_ADMIN; ?>/cp-functions/export.php" method="post" id="popupform">

    <div id="popupsave">
        <input type="submit" value="Export" class="save"/>
        <input type="hidden" name="crit_id" value="<?php echo $crit_id; ?>"/>
        <input type="hidden" name="act_id" value="<?php echo $act_id; ?>"/>
    </div>

    <h1>Exporting Event Attendee List</h1>
    <div class="pad24t popupbody">
        <fieldset>
            <legend>Export Settings</legend>
            <div class="pad24">
                <div class="field">
                    <label>Delimiter</label>
                    <div class="field_entry">
                        <select name="delimiter">
                            <option value=",">Comma</option>
                            <option value="\t">Tab</option>
                        </select>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Criteria</legend>
            <div class="pad24">
                <?php
                echo $get_crit->{'readable'};
                ?>
            </div>
        </fieldset>

    </div>


<?php
}
?>