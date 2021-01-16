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
// Check permissions, ownership,
// and if it exists.
$show = '1';
$permission = 'campaign';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $show  = '0';
    $error = 'permissions';

} else {
    // Check if refreshing the cache.
    include "check_cache.php";
    // Ownership
    $campaign = new campaign($_POST['id']);
    $data     = $campaign->get_campaign();

    if ($data['public'] != '1' && $data['owner'] != $employee['id'] && $employee['permissions']['admin'] != '1') {
        $show  = '0';
        $error = 'permissions';
    } else if (empty($data['id'])) {
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

                <?php
                if ($data['optin_type'] == 'criteria') {
                    ?>

                    <a href="null.php"
                       onclick="return popup('preview_criteria','id=<?php echo $data['criteria_id']; ?>','','1');"><img
                            src="imgs/icon-silent_login.png" border="0" title="Add Contact" alt="Add Contact"
                            class="icon" width="16" height="16"/> User List</a>

                    <a href="null.php"
                       onclick="return popup('preview_criteria','id=<?php echo $data['criteria_id']; ?>&type=criteria','','0');"><img
                            src="imgs/icon-lg-criteria.png" border="0" title="View Criteria" alt="View Criteria"
                            class="icon" width="16" height="16"/> View Criteria</a>

                    <a href="null.php"
                       onclick="return popup('build_criteria','id=<?php echo $data['criteria_id']; ?>&type=<?php echo $data['user_type']; ?>','1','');"><img
                            src="imgs/icon-lg-criteria.png" border="0" title="Edit Criteria" alt="Edit Criteria"
                            class="icon" width="16" height="16"/> Edit Criteria</a>

                <?php
                } else {
                    ?>

                    <a href="null.php" onclick="return get_slider_subpage('send');"><img
                            src="imgs/icon-email_outbox.png" border="0" title="Send Campaign" alt="Send Campaign"
                            class="icon" width="16" height="16"/> Send Message</a>

                    <a href="null.php"
                       onclick="return popup('campaign_form','id=<?php echo $data['id']; ?>','','');"><img
                            src="imgs/icon-lg-forms.png" border="0" title="Campaign Form" alt="Campaign Form"
                            class="icon" width="16" height="16"/> Subscribe Form</a>



                <?php

                }

                ?>

                <a href="null.php"
                   onclick="return delete_item('ppSD_campaigns','<?php echo $data['id']; ?>','','1');"><img
                        src="imgs/icon-delete-on.png" border="0" title="Delete" alt="Delete" class="icon" width="16"
                        height="16"/> Delete</a>

            </div>


            <ul id="slider_tabs">

                <li id="overview" class="on">Performance</li>

                <li id="data">Overview</li>

                <?php



                if ($data['optin_type'] == 'criteria') {
                    ?>

                    <li id="messages">Messages</li>

                <?php

                }

                ?>



                <!--<li id="logs">Logs</li>-->

                <li id="unsubscribers">Unsubscriptions</li>

                <?php



                if ($data['optin_type'] != 'criteria') {
                    ?>

                    <li id="subscriptions">Subscriptions</li>

                <?php

                }

                ?>

                <li id="milestones">Milestones</li>

                <li id="notes">Notes<a class="topright_bubble" href="returnnull.php"
                                       onclick="return popup('note-add','user_id=<?php echo $data['data']['id']; ?>&scope=campaign');">+</a>
                </li>

            </ul>

            <div id="slider_left">

                <span class="title"><?php echo $data['name']; ?></span>

                <span class="data">Type: <?php echo $data['format_type']; ?>
                    &#183; User Type: <?php echo $data['format_user_type']; ?>
                    &#183; Opt-In: <?php echo $data['optin_type']; ?></span>

            </div>

            <div class="clear"></div>

        </div>
    </div>



    <div id="primary_slider_content">

        %inner_content%

    </div>



    <script type="text/javascript" src="<?php echo PP_ADMIN; ?>/js/forms.js"></script>

    <script type="text/javascript" src="<?php echo PP_ADMIN; ?>/js/sliders.js"></script>





<?php

}

?>