<?phpShulNETShulNETShulNET



/**
 * Displays recent facebook posts for a contact or member.
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

$smedia->fb_connect();



?>

<div class="pad24">

    <?php

    if (!empty($fb_url)) {
        $together = '';
        $fb_id    = $smedia->fb_id($fb_url);
        // Profile Picture!
        echo "<h1>Facebook</h1>";
        $posts = $smedia->fb_graph($fb_id, 'posts', 'limit=20');
        foreach ($posts->data as $aPost) {
            // pa($aPost);
            $together .= '<li>' . $smedia->format_fb_post($aPost, '', '') . '</li>';

        }
        if (empty($together)) {
            echo "<li class=\"weak\">Nothing to display.</li>";

        } else {
            echo $together;

        }

    } else {
        $admin->show_no_permissions('', 'Input a facebook URL for this user to display his/her tweets.', '1');

    }

    ?>

</div>