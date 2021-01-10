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
$twitter_handle = $db->get_option('twitter_handle');
if (empty($twitter_handle)) {
    echo $admin->show_popup_error('You have not set up your twitter handle.');
} else {
    ?>

    <script src="js/form_rotator.js" type="text/javascript"></script>

    <h1>Twitter Account Management</h1>

    <ul id="theStepList">
        <li class="on" onclick="return goToStep('0');">Post a Tweet</li>
        <li onclick="return goToStep('1');">Tweets</li>
    </ul>

    <div class="fullForm popupbody">

        <ul id="formlist">

            <li class="form_step">

                <p class="highlight">
                    Post Tweets directly to your Twitter feed from here.
                </p>

                <fieldset>
                    <div class="pad24t">

                <?php

                $confirm = $smedia->confirm_twitter_setup();

                if ($confirm['error'] != '1') {
                    ?>



                    <form action="" method="post" id="popupform"
                          onsubmit="return json_add('tweet','x','0','popupform');">


                        <script type="text/javascript">

                            $.ctrl('S', function () {
                                return json_add('tweet', 'x', '0', 'popupform');
                            });

                        </script>

                        <script language="javascript" type="text/javascript">

                            $("document").ready(function () {
                                $('#tweet').live('keyup change', function () {
                                    var str = $(this).val();
                                    var length = str.length;
                                    var remaining = 140 - length;
                                    $('#char_remain').html(remaining);
                                    var mx = parseInt($(this).attr('maxlength'));
                                    if (str.length > mx) {
                                        $(this).val(str.substr(0, mx))
                                        return false;
                                    }
                                })
                            })

                        </script>


                        <textarea name="tweet_info" id="tweet" style="width:100%;height:100px;"
                                  onkeypress="return imposeMaxLength(this, 140);"><?php

                            if (!empty($_POST['to'])) {
                                echo '@' . $_POST['to'] . ' ';

                            } else if (!empty($_POST['msg'])) {
                                echo urldecode($_POST['msg']);

                            }

                            ?></textarea>

                        <p class="field_desc"><span id='char_remain'>140</span> characters remaining.</p>


                        <div class="submit">

                            <input type="submit" value="Tweet" class="save"/>

                        </div>


                    </form>



                <?php

                } else {

                    echo "<p>" . $confirm['error_message'] . "</p>";

                ?>

                <?php

                }

                ?>

                </div>
            </fieldset>

            </li>

            <li class="form_step">

                <p class="highlight">
                    A list of all recent tweets on your Twitter feed.
                </p>

                <fieldset>
                    <div class="pad24t">

                <?php

                $smedia = new socialmedia();
                $tweets = $smedia->get_tweets(ltrim($twitter_handle, '@'), '20');
                foreach ((array)$tweets as $entry) {
                    echo $smedia->format_tweet($entry);

                }

                ?>

                    </div>
                </fieldset>

            </li>

        </ul>


    </div>



<?php

}

?>