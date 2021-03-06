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

$permission = 'export-' . $_POST['type'];
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    echo "0+++You don't have permission to use this feature.";
    exit;
} else {

if (empty($_POST['type'])) {
    $_POST['type'] = 'misc';

}

$criteria = new criteria();
if (! empty($_POST['data'])) {
    // Build criteria and proceed
    $crit_array = unserialize($_POST['data']);

    // -----
    // Added 10/24/2013
    $found_gt = '0';
    $found_lt = '0';
    $found = array();
    $finalize_array = array();

    foreach ($crit_array as $name) {

        $check_dups = explode('||', $name);

        if ( ($check_dups['2'] == 'gte' || $check_dups['2'] == 'gt') && $found_gt != '1' ) {
            foreach ($crit_array as $nameA) {
                $check_dupsA = explode('||', $nameA);
                if ( $check_dupsA['2'] == 'lte' || $check_dupsA['2'] == 'lt' ) {
                    $found_lt = '1';
                    $finalize_array[] = $check_dupsA['0'] . '||' . $check_dupsA['1'] . '_low||' . $check_dupsA['2'] . '||' . $check_dupsA['3'];
                }
            }
            if ($found_lt == '1') {
                $finalize_array[] = $check_dups['0'] . '||' . $check_dups['1'] . '_high||' . $check_dups['2'] . '||' . $check_dups['3'];
            }
        }

        else if ( ($check_dups['2'] == 'lte' || $check_dups['2'] == 'lt') && $found_lt != '1' ) {
            foreach ($crit_array as $nameA) {
                $check_dupsA = explode('||', $nameA);
                if ( $check_dupsA['2'] == 'gte' || $check_dupsA['2'] == 'gt' ) {
                    $found_gt = '1';
                    $finalize_array[] = $check_dupsA['0'] . '||' . $check_dupsA['1'] . '_high||' . $check_dupsA['2'] . '||' . $check_dupsA['3'];
                }
            }
            if ($found_gt == '1') {
                $finalize_array[] = $check_dups['0'] . '||' . $check_dups['1'] . '_low||' . $check_dups['2'] . '||' . $check_dups['3'];
            }
        }

        else {
            if ( $found_lt != '1' &&  $found_gt != '1' ) {
                $finalize_array[] = $name;
            }
        }

    }
    // -----


    $crit_id = $criteria->build_filters($finalize_array, $_POST['type'], 'export');
    // Build this export's criteria.
}
else if (! empty($_POST['crit_id'])) {
    $crit_id = $_POST['crit_id'];
}
else {
    // Array ( [all] => 1 [filters] => Array ( ) [filter_type] => Array ( ) [filter_tables] => Array ( ) )
    $crit_array = array(
        'all' => '1',
    );
    $crit_id = $criteria->create($crit_array, 'Export', '0', '1', $_POST['type'], 'export');
}

$act_id = '';
$get_crit = new criteria($crit_id);


?>

<script type="text/javascript">
    $.ctrl('S', function () {
        document.forms["popupform"].submit();
    });

    $('#popupform').submit(function () {
        process_success_action('close_popup', '1');
    });

    function processExport() {
        var queryString = 't=b&crit_id=<?php echo $crit_id; ?>&delimiter=' + $('#delimiter').val() + '&act_id=<?php echo $act_id; ?>';

        window.open("<?php echo PP_ADMIN; ?>/cp-functions/export.php?" + queryString, '_blank');
    }
</script>

<form action="<?php echo PP_ADMIN; ?>/cp-functions/export.php" method="get" id="popupform">

    <div id="popupsave">

        <input type="button" value="Export" class="save" onClick="processExport()" />

        <input type="hidden" name="crit_id" value="<?php echo $crit_id; ?>"/>

        <input type="hidden" name="act_id" value="<?php echo $act_id; ?>"/>

    </div>

    <h1>Exporting</h1>


    <div class="pad24t popupbody">


        <fieldset>

            <legend>Export Settings</legend>

            <div class="pad24">


                <div class="field">

                    <label>Delimiter</label>

                    <div class="field_entry">

                        <select name="delimiter" id="delimiter">

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

                echo $get_crit->readable;

                ?>

            </div>

        </fieldset>


    </div>

</form>

<?php
}
?>