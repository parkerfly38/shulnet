<?phpShulNETShulNETShulNET



/**
 * Displays recent tweets for a contact or member.
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


$smedia = new socialmedia;



?>

<div class="pad24">

    <?php

    if (!empty($twitter_id)) {
        $twitter_username = $smedia->get_twitter_username($twitter_id);
        // Profile Picture!
        echo "<h1>Twitter (<a href=\"" . $twitter_id . "\" target=\"_blank\">@" . $twitter_username . "</a>)</h1>";
        $tweets = $smedia->get_tweets($twitter_username);
        foreach ($tweets as $entry) {
            echo $smedia->format_tweet($entry);

        }

    } else {
        $admin->show_no_permissions('', 'Input a twitter URL for this user to import his/her tweets.', '1');

    }

    ?>

</div>