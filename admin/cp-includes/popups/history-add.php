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


if (!empty($_POST['id'])) {
    $data       = new history($_POST['id'], '', '', '', '', '', 'ppSD_history');
    $date       = $data->{'final_content'}['date'];
    $editing    = '1';
    $final_user = $data->{'final_content'}['user_id'];

} else {
    $date       = current_date();
    $editing    = '0';
    $final_user = $_POST['user_id'];

}

?>



<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('history-add', '<?php if (! empty($_POST['id'])) { echo $_POST['id']; } ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform" onsubmit="return json_add('history-add','<?php if (!empty($_POST['id'])) {
    echo $_POST['id'];
} ?>','<?php echo $editing; ?>','popupform');">


    <div id="popupsave">

        <input type="submit" value="Save" class="save"/>

        <input type="hidden" name="user_id" value="<?php echo $final_user; ?>"/>

    </div>

    <h1>Add History</h1>


    <div class="pad24t popupbody">

        <div class="field">

            <label class="top">Date</label>

            <div class="field_entry_top">

                <?php




                echo $af
                    ->setSpecialType('datetime')
                    ->setValue($date)
                    ->string('date');


               // echo $admin->datepicker('date', $date, '1', '250');

                ?>

            </div>

        </div>


        <div class="field">

            <label class="top">Method</label>

            <div class="field_entry_top">

                <select name="method">

                    <option value="">-</option>

                    <?php





                    if (!empty($data->{'final_content'}['method'])) {
                        ?>

                        <option value="email"<?php if ($data->{'final_content'}['method'] == 'email') {
                            echo " selected=\"selected\"";
                        } ?>>E-Mail
                        </option>

                        <option value="phone"<?php if ($data->{'final_content'}['method'] == 'phone') {
                            echo " selected=\"selected\"";
                        } ?>>Phone
                        </option>

                        <option value="in_person"<?php if ($data->{'final_content'}['method'] == 'in_person') {
                            echo " selected=\"selected\"";
                        } ?>>In Person
                        </option>

                    <?php

                    } else {
                        ?>

                        <option value="email">E-Mail</option>

                        <option value="phone">Phone</option>

                        <option value="in_person">In Person</option>

                    <?php

                    }

                    ?>

                </select>

            </div>

        </div>


        <div class="field">

            <label class="top">Notes</label>

            <div class="field_entry_top">

                <textarea name="notes"
                          style="width:100%;height:200px;"><?php if (!empty($data->{'final_content'}['notes'])) {
                        echo $data->{'final_content'}['notes'];
                    } ?></textarea>

            </div>

        </div>

    </div>


</form>