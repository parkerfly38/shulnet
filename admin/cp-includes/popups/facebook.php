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
$smedia = new socialmedia();
$check = $smedia->confirm_fb_setup();
if ($check['error'] == '1') {
    echo $admin->show_popup_error($check['error_message']);

} else {
    $smedia->fb_connect();

    ?>



    <script src="js/form_rotator.js" type="text/javascript"></script>



    <h1>Facebook Account Management</h1>



    <ul id="theStepList">

        <li class="on" onclick="return goToStep('0');">Post a Status Update</li>

        <li onclick="return goToStep('1');">Status Posts</li>

    </ul>



    <div class="pad24t popupbody">


        <ul id="formlist">

            <li class="form_step">


                <form action="" method="post" id="popupform" onsubmit="return json_add('fb_post','x','0','popupform');">


                    <script type="text/javascript">

                        $.ctrl('S', function () {
                            return json_add('fb_post', 'x', '0', 'popupform');
                        });

                    </script>

                    <script language="javascript" type="text/javascript">

                        $("document").ready(function () {
                            $('#tweet').live('keyup change', function () {
                                var str = $(this).val();
                                var length = str.length;
                                var remaining = 450 - length;
                                $('#char_remain').html(remaining);
                                var mx = parseInt($(this).attr('maxlength'));
                                if (str.length > mx) {
                                    $(this).val(str.substr(0, mx))
                                    return false;
                                }
                            })
                        })

                    </script>


                    <textarea name="status" id="tweet" maxlength="450" style="width:100%;height:250px;"
                              onkeypress="return imposeMaxLength(this, 140);"></textarea>

                    <p class="field_desc"><span id='char_remain'>450</span> characters remaining.</p>


                    <div class="submit">

                        <input type="submit" value="Post" class="save"/>

                    </div>


                </form>


            </li>

            <li class="form_step">


                <?php

                $together = '';

                $fb_id = $smedia->fb_id($db->get_option('facebook_url'));

                $posts = $smedia->fb_graph($fb_id, 'posts', 'limit=20');

                foreach ($posts->data as $aPost) {
                    $together .= $smedia->format_fb_post($aPost, '', '');

                }

                if (empty($together)) {
                    echo "<span class=\"weak\">Nothing to display.</span>";

                } else {
                    echo $together;

                }

                ?>


            </li>

        </ul>


    </div>



<?php

}

?>