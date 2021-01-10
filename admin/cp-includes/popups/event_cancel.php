<?phpShulNETShulNETShulNET

/**
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
// Check permissions, ownership,
// and if it exists.
$ownership = new ownership($data['data']['owner'], $data['data']['public']);
if ($ownership->result != '1') {
    $admin->show_no_permissions($error, '', '1');

} else {

?>





    <script type="text/javascript">

        $.ctrl('S', function () {
            return json_add('event_cancel', '<?php echo $_POST['id']; ?>', '1', 'popupform');
        });

    </script>



    <script src="js/form_rotator.js" type="text/javascript"></script>



<form action="" method="post" id="popupform"
      onsubmit="return json_add('event_cancel','<?php echo $_POST['id']; ?>','1','popupform');">



<div id="popupsave">

    <input type="submit" value="Cancel Event" class="del"/>

</div>

<h1>Cancel Event</h1>


    <div class="popupbody fullForm">


<input type="hidden" name="event_id" value="<?php echo $_POST['id']; ?>"/>


<div class="popupbody fullForm">

<ul id="formlist">


        <p class="highlight">The program does not issue refunds on tickets.</p>


        <fieldset>
            <div class="pad24t">

                    <label>Notify Attendees?</label>
                    <?php
                    echo $af
                        ->setDescription('Would you like to notify attendees of the cancellation?')
                        ->radio('inform_attendees', '1', array(
                            '1' => 'Yes, notify attendees by email',
                            '2' => 'No, do NOT notify attendees',
                        ));
                    ?>


                <div class="field">

                    <label class="top">Message To Attendees</label>
                    <div class="clear"></div>
                    <?php
                    echo $af
                        ->setDescription('This will be included on the email that is sent out. The email is controlled by a template.')
                        ->textarea('reason', '');
                    ?>

                </div>

            </div>
        </fieldset>

</ul>

</div>



<?php

}