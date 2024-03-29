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


if (!empty($_POST['id'])) {
    $data     = new history($_POST['id'], '', '', '', '', '', 'ppSD_accounts');
    $final_id = $_POST['id'];
    $editing  = '1';

} else {
    $editing  = '0';
    $final_id = generate_id('random', '8');

}

?>



<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('account-add', '<?php echo $final_id; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('account-add','<?php echo $final_id; ?>','<?php echo $editing; ?>','popupform');">


    <div id="popupsave">

        <input type="submit" value="Save" class="save"/>

        <input type="hidden" name="dud_quick_add" value="1"/>

    </div>

    <h1>Add Account</h1>


    <div class="popupbody">

        <p class="highlight">Use this form to quickly create a new account.</p>

        <fieldset>
            <div class="pad fullForm">

                <div class="field">

                    <label class="top">Name</label>

                    <div class="field_entry_top">

                        <input type="text" name="name" style="width:250px;" class="req"/>

                    </div>

                </div>


                <div class="field">

                    <label class="top">Contact Frequency</label>

                    <div class="field_entry_top">

                        <?php

                        echo $admin->timeframe_field('contact_frequency', '000100000000');

                        ?>

                        <p class="contact_frequency_dets">This controls how often a contact in this account will require
                            attention.</p>

                    </div>

                </div>

            </div>
        </fieldset>

    </div>


</form>