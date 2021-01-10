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


$event = new event;

if (!empty($_POST['id'])) {
    $data = $event->timeline_item($_POST['id']);
    if ($data['error'] == '1') {
        echo "0+++Could not find timeline entry.";
        exit;

    }
    $id      = $_POST['id'];
    $editing = '1';

} else {
    $editing = '0';
    $id      = 'new';
    $data    = array(
        'title'          => '',
        'description'    => '',
        'starts'         => '',
        'ends'           => '',
        'location_name'  => '',
        'address_line_1' => '',
        'address_line_2' => '',
        'city'           => '',
        'state'          => '',
        'zip'            => '',
        'country'        => '',
        'phone'          => '',
    );

}

$event_data = $event->get_event($_POST['event']);

$event_id = $_POST['event'];

?>



<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('event_timeline-add', '<?php echo $id; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('event_timeline-add','<?php echo $id; ?>','<?php echo $editing; ?>','popupform');">


<div id="popupsave">

    <input type="submit" value="Save" class="save"/>

    <input type="hidden" value="<?php echo $event_id; ?>" name="event_id"/>

</div>

<h1>Timeline Management</h1>


<div class="pad24t popupbody">


<fieldset>

    <legend>Overview</legend>

    <div class="pad24">


        <div class="field">

            <label class="">Name</label>

            <div class="field_entry">

                <input type="text" id="title" name="title" style="width:250px;" value="<?php echo $data['title']; ?>"
                       class="req"/>

            </div>

        </div>


        <div class="field">

            <label class="top">Description</label>

            <div class="clear"></div>

            <div class="field_entry_top">

                <textarea name="description" class="richtext" id="b213"
                          style="width:100%;height:200px;"><?php echo $data['description']; ?></textarea>

                <?php
                echo $admin->richtext('100%', '200px', 'b213', '', '1');
                ?>

            </div>

        </div>


        <div class="col50l">

            <div class="field">

                <label class="top">Starts</label>

                <div class="field_entry_top">

                    <?php
                    $start = date('Y-m-d', strtotime($event_data['data']['starts'])) . ' 00:00:00';

                    echo $af
                        ->setSpecialType('datetime')
                        ->setValue($data['starts'])
                        ->string('starts');


                    //echo $admin->datepicker('starts', $data['starts'], '1', '220', '1', '15', '1', '', $start);
                    ?>

                </div>

            </div>

        </div>

        <div class="col50r">

            <div class="field">

                <label class="top">Ends</label>

                <div class="field_entry_top">

                    <?php
                    //echo $admin->datepicker('ends', $data['ends'], '1', '220', '1', '15', '1', '', $start);

                    echo $af
                        ->setSpecialType('datetime')
                        ->setValue($data['ends'])
                        ->string('ends');
                    ?>

                </div>

            </div>

        </div>

        <div class="clear"></div>


    </div>

</fieldset>


<fieldset>

    <legend>Location</legend>

    <div class="pad24">


        <div class="field">

            <label class="">Same as Event?</label>

            <div class="field_entry">

                <input type="radio" name="dud_same"
                       onclick="return hide_div('new_location');" <?php if (empty($data['location_name'])) {
                    echo " checked=\"checked\"";
                } ?> /> Same as event <input type="radio" name="dud_same"
                                             onclick="return show_div('new_location');" <?php if (!empty($data['location_name'])) {
                    echo " checked=\"checked\"";
                } ?> /> Not same as event

            </div>

        </div>


        <div id="new_location" style="display:<?php if (empty($data['location_name'])) {
            echo "none";
        } else {
            echo "block";
        } ?>;">

            <div class="field">

                <label class="">Location Name</label>

                <div class="field_entry">

                    <input type="text" name="location_name" style="width:250px;"
                           value="<?php echo $data['location_name']; ?>" class=""/>

                </div>

            </div>


            <div class="field">

                <label class="">Address</label>

                <div class="field_entry">

                    <input type="text" name="address_line_1" style="width:100%;"
                           value="<?php echo $data['address_line_1']; ?>"/>

                </div>

            </div>


            <div class="field">

                <label class="">&nbsp;</label>

                <div class="field_entry">

                    <input type="text" name="address_line_2" style="width:100%;"
                           value="<?php echo $data['address_line_2']; ?>"/>

                </div>

            </div>


            <div class="field">

                <label class="">City</label>

                <div class="field_entry">

                    <input type="text" name="city" style="width:250px;" value="<?php echo $data['city']; ?>"/>

                </div>

            </div>


            <div class="field">

                <label class="">State</label>

                <div class="field_entry">

                    <input type="text" name="state" style="width:150px;" value="<?php echo $data['state']; ?>"/>

                </div>

            </div>


            <div class="field">

                <label class="">Zip</label>

                <div class="field_entry">

                    <input type="text" name="zip" style="width:150px;" value="<?php echo $data['zip']; ?>"/>

                </div>

            </div>


            <div class="field">

                <label class="">Country</label>

                <div class="field_entry">

                    <input type="text" name="country" style="width:250px;" value="<?php echo $data['country']; ?>"/>

                </div>

            </div>


            <div class="field">

                <label class="">Phone</label>

                <div class="field_entry">

                    <input type="text" name="phone" style="width:250px;" value="<?php echo $data['phone']; ?>"/>

                </div>

            </div>


        </div>


    </div>

</fieldset>


</div>


</form>