<?php/** * * * Zenbership Membership Software * Copyright (C) 2013-2016 Castlamp, LLC * * This program is free software: you can redistribute it and/or modify * it under the terms of the GNU General Public License as published by * the Free Software Foundation, either version 3 of the License, or * (at your option) any later version. * * This program is distributed in the hope that it will be useful, * but WITHOUT ANY WARRANTY; without even the implied warranty of * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the * GNU General Public License for more details. * * You should have received a copy of the GNU General Public License * along with this program.  If not, see <http://www.gnu.org/licenses/>. * * @author      Castlamp * @link        http://www.castlamp.com/ * @link        http://www.zenbership.com/ * @copyright   (c) 2013-2016 Castlamp * @license     http://www.gnu.org/licenses/gpl-3.0.en.html * @project     Zenbership Membership Software */$homepage = new homepage_widgets($employee);$homepage->get_widgets();$homepage->render_widgets();if (empty($homepage->widget_list)) {    if (empty($employee['permissions']['start_page'])) {        header('Location: index.php?l=calendar');        exit;    } else {        header('Location: index.php?l=' . $employee['permissions']['start_page']);        exit;    }} else {?><div id="topblue" class="fonts small">    <div class="holder">        <div class="floatright" id="tb_right">            <?php            /*            $smedia = new socialmedia();            $twitter = $smedia->confirm_twitter_setup();            $fb = $smedia->confirm_fb_setup();            if ($twitter['error'] != '1') {                echo "<span><a href=\"index.php?l=social_media_twitter\"><img src='imgs/icon-twitter.png' width=16 height=16 border=0 class='icon' />Twitter Feeds</a></span>";            }            if ($fb['error'] != '1') {                if ($twitter['error'] != '1') {                    echo "<span class=\"div\"></span>";                }                echo "<span><a href=\"index.php?l=social_media_facebook\"><img src='imgs/icon-facebook.png' width=16 height=16 border=0 class='icon' />Facebook Feeds</a></span>";            }            */            ?>        </div>        <div class="floatleft" id="tb_left">            <span><b>Welcome!</b></span>            <span class="div">|</span>            <span id="innerLinks">                <a href="index.php?l=notes">Notes</a>                <a href="index.php?l=notes&filters[]=4||label||eq||ppSD_notes&filters[]=1||complete||neq||ppSD_notes">To Do List</a>                <a href="index.php?l=notes&filters[]=0000-00-00 00:00:00||deadline||neq||ppSD_notes&filters[]=1||complete||neq||ppSD_notes&order=deadline&dir=ASC">Deadlines</a>                <a href="index.php?l=notes&filters[]=25||label||eq||ppSD_notes&filters[]=1||complete||neq||ppSD_notes&order=deadline&dir=ASC">Appointments</a>                <a href="index.php?l=calendar">Calendar</a>                <span class="div">|</span>                <a href="index.php?l=feed">Activity Feed</a>            </span>        </div>        <div class="clear"></div>    </div></div><div id="mainsection">    <a name="top"></a>    <div id="home_all">        <div id="home_left">            <div class="home_x_pad">                <div id="hold_home_widgets">                    <h1>                        <a class="home_right_link" href="returnnull.php" onclick="return popup('home_widgets');">Customize</a>                        Widgets                    </h1>                    <div class="home_left_inner">                        <ul class="home_ul">                            <?php                            echo $homepage->widget_list;                            ?>                        </ul>                    </div>                </div>                <h1>Deadlines Within 7 Days</h1>                <?php                echo $admin->employee_notes();                ?>            </div>        </div>        <div id="home_right">            <?php            echo $homepage->rendered_col1;            echo $homepage->rendered_col2;            ?>        </div>        <div class="clear"></div>    </div></div><?php}?>