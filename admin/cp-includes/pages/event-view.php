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

$data = $event->get_event($_POST['id']);


$notes = new notes;
$pinned_notes = $notes->get_pinned_notes($_POST['id']);

//pa($data);


?>



<!--

    <div id="slider_top_table" style="margin-bottom:-6px;">

        <div class="floatright">

            &nbsp;

        </div>

        <div class="floatleft">

            <input type="button" value="Edit" class="save" onclick="return popup('event-edit','id=<?php echo $data['data']['id']; ?>','1');" />

        </div>

        <div class="clear"></div>

    </div>

        -->


<div class="col50">
    <div class="pad24_fs_l">


        <fieldset>

            <legend>Overview</legend>

            <div class="pad24t">

                <dl>

                    <dt>ID</dt>

                    <dd><?php echo $data['data']['id']; ?></dd>

                    <dt>Calendar</dt>

                    <dd><a href="return_null.php"
                           onclick="return popup('calendar-edit','id=<?php echo $data['data']['calendar_id']; ?>');"><?php echo $data['data']['calendar_name']; ?></a>
                    </dd>

                    <dt>Live?</dt>

                    <dd><?php



                        if ($data['data']['status'] == '1') {
                            echo "Yes";

                        } else {
                            echo "<span class=\"alert\">No</span>";

                        }

                        ?></dd>

                    <dt>Name</dt>

                    <dd><?php echo $data['data']['name']; ?></dd>

                    <dt>Tagline</dt>

                    <dd><?php echo $data['data']['tagline']; ?></dd>

                    <dt>Status</dt>

                    <dd><?php echo $data['data']['status_show']; ?></dd>

                    <dt>Max Attendees</dt>

                    <dd><?php echo $data['data']['max_rsvps']; ?></dd>

                </dl>

                <div class="clear"></div>

            </div>

        </fieldset>


        <fieldset>

            <legend>Guests</legend>

            <div class="pad24t">

                <dl>

                    <dt>Allow Guests?</dt>

                    <dd><?php



                        if ($data['data']['allow_guests'] == '1') {
                            echo "Yes";
                        } else {
                            echo "<span class=\"weak\">No</span>";
                        }

                        ?></dd>

                    <dt>Max per user</dt>

                    <dd><?php echo $data['data']['max_guests']; ?></dd>

                </dl>

                <div class="clear"></div>

            </div>

        </fieldset>


        <fieldset>

            <legend>Tags</legend>

            <div class="pad24t">

                <?php



                $tags = $event->format_tags($data['tags'], '1');

                echo $tags;

                ?>

                <div class="clear"></div>

            </div>

        </fieldset>


    </div>
</div>

<div class="col50">
    <div class="pad24_fs_r">

        <?php

        if (!empty($pinned_notes)) {

            echo '<div style="margin-bottom:24px;">';

            foreach ($pinned_notes as $item) {
                echo $admin->format_note($item);
            }

            echo '</div>';

        }

        ?>

        <fieldset>

            <legend>Dates</legend>

            <div class="pad24t">

                <dl>

                    <dt>Start Registration</dt>

                    <dd><?php echo $data['data']['start_registrations_formatted']; ?></dd>



                    <?php



                    if ($data['data']['early_bird'] == '1') {
                        ?>

                        <dt>Early Bird Ends</dt>

                        <dd><?php echo $data['data']['earlybird_formatted']; ?></dd>

                    <?php

                    } else {
                        ?>

                        <dt>Early Bird Ends</dt>

                        <dd><span class="weak">N/A</span></dd>

                    <?php

                    }

                    ?>



                    <dt>End Registration</dt>

                    <dd><?php echo $data['data']['close_registrations_formatted']; ?></dd>

                    <dt>Starts</dt>

                    <dd><?php echo $data['data']['starts_formatted']; ?></dd>

                    <dt>Ends</dt>

                    <dd><?php echo $data['data']['ends_formatted']; ?></dd>

                </dl>

                <div class="clear"></div>

            </div>

        </fieldset>



        <?php



        if ($data['data']['online'] == '1') {
            ?>

            <fieldset>

                <legend>Online Event</legend>

                <div class="pad24t">

                    <dl>

                        <dt>Website</dt>

                        <dd><?php echo $data['data']['url']; ?></dd>

                    </dl>

                    <div class="clear"></div>

                </div>

            </fieldset>

        <?php

        } else {
            ?>

            <fieldset>

                <legend>Location</legend>

                <div class="pad24t">

                    <dl>

                        <dt>Venue</dt>

                        <dd><?php echo $data['data']['location_name']; ?></dd>

                        <dt>Address</dt>

                        <dd><?php echo $data['data']['formatted_address']; ?></dd>

                        <dt>Phone</dt>

                        <dd><?php echo $data['data']['phone']; ?></dd>

                    </dl>

                    <div class="clear"></div>

                </div>

            </fieldset>

            <fieldset>

                <legend>Map</legend>

                <div class="pad24t">

                    <?php



                    echo generate_map($data['data'], '100%', '275');

                    ?>

                </div>

            </fieldset>

        <?php

        }

        ?>


    </div>
</div>

<div class="clear"></div>

