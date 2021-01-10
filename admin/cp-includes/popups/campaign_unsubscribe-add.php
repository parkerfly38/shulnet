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


$campaign = new campaign($_POST['campaign_id']);

$data = $campaign->get_campaign();

$cid = $_POST['campaign_id'];

?>



<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('campaign_unsubscribe-add', '<?php echo $cid; ?>', '0', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('campaign_unsubscribe-add','<?php echo $cid; ?>','0','popupform');">


    <div id="popupsave">

        <input type="submit" value="Unsubscribe" class="save"/>

        <input type="hidden" name="campaign_id" value="<?php echo $cid; ?>"/>

    </div>

    <h1>Unsubscribe User</h1>


    <div id="pop_inner" class="pad24t popupbody">


        <p class="highlight smaller">Type the user's information, select them from the results, and click "Unsubscribe"
            above.</p>



        <?php





        if ($data['user_type'] == 'member') {
            ?>



            <fieldset>

                <legend>Member</legend>

                <div class="pad24t">


                    <div id="member">

                        <div class="field">

                            <label class="">Username</label>

                            <div class="field_entry">

                                <input type="text" value="" name="username_dud" id="usernamed"
                                       autocomplete="off" onkeyup="return autocom(this.id,'id','username','ppSD_members','username','members');"
                                       style="width:100%;"/>

                                <input type="hidden" name="user_id" id="usernamed_id" value=""/>

                                <input type="hidden" name="user_type" value="member"/>

                            </div>

                        </div>

                    </div>


                </div>

            </fieldset>



        <?php

        } else if ($data['user_type'] == 'contact') {
            ?>

            <fieldset>

                <legend>Contact</legend>

                <div class="pad24t">


                    <div id="contact">

                        <div class="field">

                            <label class="">Last Name</label>

                            <div class="field_entry">

                                <input type="text" value="" name="usernameA_dud" id="usernameAd"
                                       autocomplete="off" onkeyup="return autocom(this.id,'contact_id','first_name,last_name','ppSD_contact_data','last_name','contacts');"
                                       style="width:100%;"/>

                                <input type="hidden" name="user_id" id="usernameAd_id" value=""/>

                                <input type="hidden" name="user_type" value="contact"/>

                            </div>

                        </div>

                    </div>


                </div>

            </fieldset>



        <?php

        }

        ?>


    </div>


    </div>


</form>