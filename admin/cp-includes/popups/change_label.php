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

$uploads = new uploads;
$get_upload = $uploads->get_upload($_POST['id']);

?>

<script type="text/javascript">
    $.ctrl('S', function () {
        return json_add('change_label', '<?php echo $_POST['id']; ?>', '1', 'popupform');
    });
</script>

<form action="" method="post" id="popupform" onsubmit="return json_add('change_label','<?php echo $_POST['id']; ?>','1','popupform');">

    <div id="popupsave">
        <input type="hidden" name="file_id" value="<?php echo $_POST['id']; ?>"/>
        <input type="submit" value="Save" class="save"/>
    </div>

    <h1>Change File Label</h1>

    <div class="popupbody">
        <p class="highlight">
            Labels allow you to control where the file is displayed.
        </p>
        <div class="pad fullForm">

            <label class="top">Select a Label</label>
            <?php
            echo $af->labelList('label', $get_upload['label']);
            ?>

        </div>
    </div>

</form>