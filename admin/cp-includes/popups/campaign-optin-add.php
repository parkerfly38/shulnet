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


$cid = generate_id('random', '11');

?>



<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('campaign-add', '<?php echo $cid; ?>', '0', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('campaign-add','<?php echo $cid; ?>','0','popupform');">


    <div id="popupsave">

        <input type="submit" value="Save" class="save"/>

        <input type="hidden" name="user_type" value="contact"/>

    </div>

    <h1>Campaign Creator</h1>


    <div id="pop_inner" class="fullForm popupbody">

        <p class="highlight">Establish your opt-in campaign settings below. You will be able to add messages later.</p>

        <fieldset>
            <div class="pad">

                <label>Campaign Name</label>
                <?php
                echo $af->string('name', '', 'req');
                ?>


                <label>Campaign Type</label>
                <?php
                echo $af->radio('type', 'email', array(
                    'email' => 'E-Mail Campaign',
                ));
                ?>

                <label>Opt-in type?</label>
                <?php
                echo $af->radio('optin_type', 'double_optin', array(
                    'double_optin' => 'Double Opt-In',
                    'single_optin' => 'Single Opt-In',
                ));
                ?>


                <label>Would you like to take the campaign live now or later?</label>
                <?php
                echo $af->radio('status', '1', array(
                    '1' => 'Now: we\'re doing it live!',
                    '0' => 'Later: I\'ll activate it later.',
                ));
                ?>

            </div>

        </fieldset>

    </div>


</form>