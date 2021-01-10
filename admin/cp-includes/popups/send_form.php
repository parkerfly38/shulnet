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


if (!empty($_POST['type']) && $_POST['type'] == 'contact') {
    $type = 'contact';

} else {
    $type = 'member';

}

?>



<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('send_form', '<?php echo $_POST['id']; ?>', '1', 'popupformA');
    });

</script>


<form action="" method="post" id="popupformA"
      onsubmit="return json_add('send_form','<?php echo $_POST['id']; ?>','1','popupformA');">


    <div id="popupsave">

        <input type="hidden" name="mid" value="<?php echo $_POST['id']; ?>"/>

        <input type="hidden" name="type" value="<?php echo $type; ?>"/>

        <input type="submit" value="Send Form Request" class="save"/>

    </div>

    <h1>Send Form Request</h1>


    <div class="pad24t popupbody">


        <fieldset>

            <legend>Overview</legend>

            <div class="pad24t">

                <div class="field">
                    <label>Form</label>
                    <div class="field_entry">
                        <select name="id" style="width:100%;">
                            <option></option>
                            <?php
                            if ($type == 'contact') {
                                $update = '0';
                            } else {
                                $update = '1';
                            }
                            echo $admin->list_direct_forms($update);
                            ?>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label>Email</label>
                    <div class="field_entry">
                        <input type="text" name="email" style="width:250px;" />
                        <p class="field_desc">Who should receive this request? Leave blank to use the email on the membership. Otherwise, input a different email to override that default.</p>
                    </div>
                </div>

                <div class="field">

                    <label>Reason</label>

                    <div class="field_entry">

                        <textarea name="reason" style="width:100%;height:200px;"></textarea>

                    </div>

                </div>


            </div>

        </fieldset>


    </div>


</form>