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
$uploads = $event->get_uploads($_POST['id']);

?>



<form action="cp-includes/get_table.php" id="slider_sorting" method="post"
      onsubmit="return update_slider_table('<?php echo $table; ?>');">
    <input type="hidden" name="item_id" value="<?php echo $_POST['id']; ?>"/>
    <input type="hidden" name="criteria" value="<?php echo $get_crit; ?>"/>
    <input type="hidden" name="order" value="date"/>
    <input type="hidden" name="dir" value="DESC"/>
    <div id="slider_top_table">
        <div class="floatright">
            &nbsp;
        </div>
        <div class="floatleft">
            <input type="button" value="Upload Cover Photo" class="save"
                   onclick="return popup('upload-files','item_id=<?php echo $_POST['id']; ?>&type=cover&label=event-cover-photo&permission=event-upload-cover&type=event');"/>
            <input type="button" value="Upload Photo" class="save"
                   onclick="return popup('upload-files','item_id=<?php echo $_POST['id']; ?>&type=image&label=event-photo&permission=event-upload&type=event');"/>
        </div>
        <div class="clear"></div>
    </div>
</form>


<div class="pad24">

    <h1>Cover Photo</h1>
    <p class="highlight">Cover photos will automatically be grouped together into a rotating slider.</p>
    <div id="event_cover_photo">

        <?php
        foreach ($uploads['covers'] as $file) {
            $final_id = image_id_from_name($file);
            echo "<div class=\"zen_event_img_cover_container\" id=\"td-cell-" . $final_id . "\">
                <a href=\"return_null.php\" onclick=\"return popup('crop_image','id=" . $final_id . "&filename=" . $file . "&label=event-cover-photo&type=event_cover_photo','1');\">" . $event->format_an_image($file, '980', '232', '1') . "</a>
                <p class=\"small\" style=\"margin-top:6px;\"><a href=\"null.php\" onclick=\"return delete_item('ppSD_uploads','" . $final_id . "','','0');\"><img src=\"imgs/icon-delete-on.png\" border=\"0\" title=\"Delete\" alt=\"Delete\" class=\"icon\" width=\"16\" height=\"16\"/>Delete Image</a></p>
            </div>";
        }
        ?>

    </div>

    <div class="clear"></div>


    <h1>Additional Photo</h1>

    <div id="event_photos">

        <?php
        foreach ($uploads['photos'] as $file) {
            $final_id = image_id_from_name($file['0']);
            echo "<div class=\"zen_event_img_container\" id=\"td-cell-" . $final_id . "\">
                <a href=\"return_null.php\" onclick=\"return popup('crop_image','id=" . $final_id . "&filename=" . $file['0'] . "&label=event-photo&type=event_photo','1');\">" . $event->format_an_image($file, '133', '100', '1') . "</a>
                <p class=\"small\" style=\"margin-top:6px;\"><a href=\"null.php\" onclick=\"return delete_item('ppSD_uploads','" . $final_id . "','','0');\"><img src=\"imgs/icon-delete-on.png\" border=\"0\" title=\"Delete\" alt=\"Delete\" class=\"icon\" width=\"16\" height=\"16\"/>Delete Image</a></p>
            </div>";
        }
        ?>

    </div>

    <div class="clear"></div>

</div>