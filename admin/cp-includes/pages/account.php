<?php/** * * * Zenbership Membership Software * Copyright (C) 2013-2016 Castlamp, LLC * * This program is free software: you can redistribute it and/or modify * it under the terms of the GNU General Public License as published by * the Free Software Foundation, either version 3 of the License, or * (at your option) any later version. * * This program is distributed in the hope that it will be useful, * but WITHOUT ANY WARRANTY; without even the implied warranty of * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the * GNU General Public License for more details. * * You should have received a copy of the GNU General Public License * along with this program.  If not, see <http://www.gnu.org/licenses/>. * * @author      Castlamp * @link        http://www.castlamp.com/ * @link        http://www.zenbership.com/ * @copyright   (c) 2013-2016 Castlamp * @license     http://www.gnu.org/licenses/gpl-3.0.en.html * @project     Zenbership Membership Software */// Check permissions, ownership,// and if it exists.$show = '1';$permission = 'account';$check = $admin->check_permissions($permission, $employee);if ($check != '1') {    $show  = '0';    $error = 'permissions';} else {    // Check if refreshing the cache.    include "check_cache.php";    // Ownership    $account = new account;    $data    = $account->get_account($_POST['id'], $recache);    if (! empty($data['id']) && $employee['permissions']['admin'] != '1') {        if ($data['public'] == '1') {            // Nothing.        }        else if ($data['owner']['id'] == $employee['id']) {            // Nothing.        }        else {            $show  = '0';            $error = 'permissions';        }    }    else if (empty($data['id'])) {        $show  = '0';        $error = 'noexists';    }    /*    if (! empty($data['id']) &&  $data['public'] != '1' && $data['owner'] != $employee['id'] && $employee['permissions']['admin'] != '1') {        $show  = '0';        $error = 'permissions';    } else if (empty($data['id'])) {        $show  = '0';        $error = 'noexists';    }    */}// Show?if ($show != '1') {    $admin->show_no_permissions($error, '', '1');} else {    ?>    <div id="slider_submit">        <div class="pad24tb">            <div id="topicons">                <!--<a href="index.php?l=account-print"><img src="imgs/icon-print.png" border="0" title="Print" alt="Print" class="icon" width="16" height="16" /> Print</a>-->                <?php                $check_fav = $admin->check_favorite($employee['id'], 'account', $data['id']);                if ($check_fav == '1') {                    ?>                    <a href="null.php"                       onclick="return json_add('favorite_add','<?php echo $data['id']; ?>','1','skip','mtype=account&type=remove');"><img                            src="imgs/icon-fav-on.png" id="favorite-button-<?php echo $data['id']; ?>" border="0"                            title="Remove from Favorites" alt="Remove from Favorites" class="icon" width="16"                            height="16"/> Favorite</a>                <?php                } else {                    ?>                    <a href="null.php"                       onclick="return json_add('favorite_add','<?php echo $data['id']; ?>','1','skip','mtype=account&type=add');"><img                            src="imgs/icon-fav-off.png" id="favorite-button-<?php echo $data['id']; ?>" border="0"                            title="Add to Favorites" alt="Add to Favorites" class="icon" width="16" height="16"/>                        Favorite</a>                <?php                }                ?>                <a href="null.php" onclick="return popup('note_stream','account=<?php echo $data['id']; ?>','1');"><img                        src="imgs/icon-note_stream.png" border="0" title="Note Stream" alt="Note Stream" class="icon"                        width="16" height="16"/> Note Stream</a>                <a href="null.php"                   onclick="return popup('contact-add','account=<?php echo $data['id']; ?>','','1');"><img                        src="imgs/icon-contact-add.png" border="0" title="Add Contact" alt="Add Contact" class="icon"                        width="16" height="16"/> Add Contact</a>                <a href="null.php"                   onclick="return popup('member-add','account=<?php echo $data['id']; ?>','','1');"><img                        src="imgs/icon-member-add.png" border="0" title="Add Member" alt="Add Member" class="icon"                        width="16" height="16"/> Add Member</a>                <a href="null.php"                   onclick="return delete_item('ppSD_accounts','<?php echo $data['id']; ?>','','1');"><img                        src="imgs/icon-delete-on.png" border="0" title="Delete" alt="Delete" class="icon" width="16"                        height="16"/> Delete</a>            </div>            <ul id="slider_tabs">                <li id="overview" class="on">Overview</li>                <li id="members">Members</li>                <li id="contacts">Contacts</li>                <li id="notes">Notes<a class="topright_bubble" href="returnnull.php"                                       onclick="return popup('note-add','user_id=<?php echo $data['id']; ?>&scope=account','1');">+</a>                </li>                <li id="files">Files</li>                <?php                if (!empty($data['twitter']) && $data['twitter'] != 'http://') {                    echo "<li id=\"social_media\"><img src=\"imgs/icon-twitter.png\" width=\"16\" height=\"16\" alt=\"Twitter Feed\" title=\"Twitter Feed\" border=0 style=\"margin-top:10px;\" /></li>";                }                if (!empty($data['facebook']) && $data['facebook'] != 'http://') {                    echo "<li class=\"external\" id=\"external\" zenurl=\"" . $data['data']['facebook'] . "\"><img src=\"imgs/icon-facebook.png\" width=\"16\" height=\"16\" alt=\"Facebook Feed\" title=\"Facebook Feed\" border=0 style=\"margin-top:10px;\" /></li>";                }                ?>            </ul>            <div id="slider_left">                <?php                echo $data['profile_pic'];                ?><span class="title"><?php echo $data['name']; ?></span>			<span class="data">Account with <?php                echo $data['stats']['contacts'] . " contact";                if ($data['stats']['contacts'] != 1) {                    echo "s";                }                ?> and <?php                echo $data['stats']['members'] . " member";                if ($data['stats']['members'] != 1) {                    echo "s";                }                ?> (ID = <?php echo $data['id']; ?>)</span>            </div>            <div class="clear"></div>        </div>    </div>    <div id="primary_slider_content">        %inner_content%    </div>    <script type="text/javascript" src="<?php echo PP_ADMIN; ?>/js/forms.js"></script>    <script type="text/javascript" src="<?php echo PP_ADMIN; ?>/js/sliders.js"></script><?php}?>