<?phpShulNETShulNETShulNET



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
// Check permissions, ownership,
// and if it exists.
$show = '1';
$permission = 'event';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $show  = '0';
    $error = 'permissions';

} else {
    // Check if refreshing the cache.
    include "check_cache.php";
    // Ownership
    $event = new event;
    $data  = $event->get_event($_POST['id'], $recache);

    if ($data['data']['public'] != '1' && $data['data']['owner'] != $employee['id'] && $employee['permissions']['admin'] != '1') {
        $show  = '0';
        $error = 'permissions';

    } else if (empty($data['data']['id'])) {
        $show  = '0';
        $error = 'noexists';

    }

}
// Show?
if ($show != '1') {
    $admin->show_no_permissions($error, '', '1');

} else {

    ?>



    <div id="slider_submit">
        <div class="pad24tb">


            <div id="topicons">

                <a href="null.php"
                   onclick="return popup('event_reminders','id=<?php echo $data['data']['id']; ?>','1');"><img
                        src="imgs/icon-lg-queue.png" border="0" title="Reminders" alt="Reminders" class="icon"
                        width="16" height="16"/> Reminders</a>

                <a href="null.php"
                   onclick="return popup('event_cancel','id=<?php echo $data['data']['id']; ?>', '0');"><img
                        src="imgs/icon-mark-dead.png" border="0" title="Cancel" alt="Cancel" class="icon"
                        width="16" height="16"/> Cancel</a>

                <a href="null.php" onclick="return get_slider_subpage('email');"><img src="imgs/icon-email.png"
                                                                                      border="0" title="E-Mail"
                                                                                      alt="E-Mail" class="icon"
                                                                                      width="16" height="16"/>
                    E-Mail</a>

                <!--<a href="null.php" onclick="return popup('send-sms','id=<?php echo $data['data']['id']; ?>&type=event');"><img src="imgs/icon-text.png" border="0" title="SMS" alt="SMS" class="icon" width="16" height="16" /> SMS</a>-->

                <a href="<?php echo $data['data']['link'] ?>" target="_blank"><img src="imgs/icon-view.png" border="0"
                                                                                   title="View" alt="View" class="icon"
                                                                                   width="16" height="16"/> View Online</a>

                <a href="null.php"
                   onclick="return delete_item('ppSD_events','<?php echo $data['data']['id']; ?>','','1');"><img
                        src="imgs/icon-delete-on.png" border="0" title="Delete" alt="Delete" class="icon" width="16"
                        height="16"/> Delete</a>

            </div>


            <ul id="slider_tabs">

                <li id="overview" class="on">Overview</li>

                <li id="event-edit:<?php echo $data['data']['id']; ?>" class="popup_large">Edit</li>

                <li id="attendees">Attendees</li>

                <li id="timeline">Timeline</li>

                <li id="notes">Notes<a class="topright_bubble" href="returnnull.php"
                                       onclick="return popup('note-add','user_id=<?php echo $data['data']['id']; ?>&scope=event');">+</a>
                </li>

                <li id="files">Files</li>

            </ul>

            <div id="slider_left">

                <span class="title"><?php echo $data['data']['name']; ?></span>

                <span
                    class="data"><?php echo $data['data']['starts_formatted'] . ' until ' . $data['data']['ends_formatted']; ?></span>

            </div>

            <div class="clear"></div>

        </div>
    </div>



    <div id="primary_slider_content">

        <?php


        if ($data['data']['status'] == '2') {
            echo "<p id=\"canceled\" class=\"highlight\">This event has been canceled.</p>";
        }

        ?>
        %inner_content%

    </div>



    <script type="text/javascript" src="<?php echo PP_ADMIN; ?>/js/forms.js"></script>

    <script type="text/javascript" src="<?php echo PP_ADMIN; ?>/js/sliders.js"></script>





<?php

}

?>