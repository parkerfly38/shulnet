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
if (empty($_POST['id'])) {
    $admin->show_popup_error('No member selected.');

} else {
    $user = new user;
    $data = $user->get_user($_POST['id']);
    $cid  = $_POST['id'];



    ?>



    <script src="js/form_rotator.js" type="text/javascript"></script>

    <script type="text/javascript">

        $.ctrl('S', function () {
            return json_add('activate-add', '<?php echo $cid; ?>', '1');
        });

    </script>



    <form action="" method="post" id="popupform" onsubmit="return json_add('activate-add','<?php echo $cid; ?>','1');">


    <div id="popupsave">

        <input type="submit" value="Save" class="save"/>

    </div>

    <h1>Member Status Management</h1>


    <div class="popupbody">


        <ul id="theStepList">

            <li class="on" onclick="return goToStep('0');">Status</li>

            <li onclick="return goToStep('1');">History</li>

        </ul>


        <ul id="formlist">

            <li class="form_step">

                <div class="pad24t">


                    <fieldset>

                        <legend>Overview</legend>

                        <div class="pad24t">

                            <?php

                            echo $admin->build_quick_view($data['data'], 'member', 'member_quick_view');

                            ?>

                            <div class="clear"></div>

                        </div>

                    </fieldset>


                    <fieldset>

                        <legend>Activation Status</legend>

                        <div class="pad24t">


                            <div class="field">

                                <label>Status</label>

                                <div class="field_entry">

                                    <input type="radio" name="status"
                                           value="A"<?php if ($data['data']['status'] == 'A') {
                                        echo " checked=\"checked\"";
                                    } ?> /> Active<br/>

                                    <input type="radio" name="status"
                                           value="R"<?php if ($data['data']['status'] == 'R') {
                                        echo " checked=\"checked\"";
                                    } ?> /> Reject<br/>

                                    <input type="radio" name="status"
                                           value="C"<?php if ($data['data']['status'] == 'C') {
                                        echo " checked=\"checked\"";
                                    } ?> /> Suspend<br/>

                                    <input type="radio" name="status"
                                           value="Y"<?php if ($data['data']['status'] == 'Y') {
                                        echo " checked=\"checked\"";
                                    } ?> /> Pending Approval<br/>

                                    <input type="radio" name="status"
                                           value="P"<?php if ($data['data']['status'] == 'P') {
                                        echo " checked=\"checked\"";
                                    } ?> /> Pending E-Mail Confirmation<br/>

                                    <input type="radio" name="status"
                                           value="S"<?php if ($data['data']['status'] == 'S') {
                                        echo " checked=\"checked\"";
                                    } ?> /> Pending Invoice Payment<br/>

                                    <input type="radio" name="status"
                                           value="I"<?php if ($data['data']['status'] == 'I') {
                                        echo " checked=\"checked\"";
                                    } ?> /> Inactive

                                </div>

                            </div>

                            <div class="field">
                                <label>E-Mail User?</label>
                                <div class="field_entry">
                                    <input type="radio" name="send_email" value="1" checked="checked"/> E-Mail member
                                    about this change<Br/>
                                    <input type="radio" name="send_email" value="0"/> Do not e-mail member about this
                                    change
                                </div>
                            </div>

                            <div class="field">
                                <label class="top">Reason</label>
                                <div class="clear"></div>
                                <div class="field_entry_top">
                                    <textarea name="reason" class="richtext" id="asd1"
                                              style="width:100%;height:170px;"></textarea>
                                    <?php
                                    echo $admin->richtext('100%', '170px', 'asd1', '0', '1');
                                    ?>
                                </div>
                            </div>
                    </fieldset>


                </div>

            </li>

            <li class="form_step">


                <table class="tablesorter listings popuptable" id="active_table" border="0" id="poptable">
                    <thead>

                    <th class="first">Date</th>

                    <th>Status</th>

                    <th>By</th>

                    <th>Reason</th>

                    </thead>

                    <tbody>

                    <?php





                    $sf = new special_fields('member');

                    foreach ($data['status_history'] as $history) {
                        $sf->update_row($history);
                        echo "<tr>

                    <td>" . $sf->process('date', $history['date']) . "</td>

                    <td>" . $sf->process('status', $history['status']) . "</td>

                    <td>" . $sf->process('owner', $history['owner']) . "</td>

                    <td>" . $sf->process('reason', $history['reason']) . "</td>

                    </tr>";

                    }

                    ?>

                    </tbody>

                </table>


            </li>

        </ul>


    </div>


    </form>



<?php

}

?>