<?php

   

// Check permissions, ownership,
// and if it exists.

$show = '1';
$permission = 'member';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $show  = '0';
    $error = 'permissions';
} else {
    // Check if refreshing the cache.
    include "check_cache.php";
    // Ownership
    $user = new user;
    $data = $user->get_user($_POST['id'], '', $recache);
    if (! empty($data['data']['id']) && $employee['permissions']['admin'] != '1') {
        if ($data['data']['public'] == '1') {
            // Nothing.
        }
        else if ($data['data']['owner'] == $employee['id']) {
            // Nothing.
        }
        else {
            $show  = '0';
            $error = 'permissions';
        }
    }
    else if (empty($data['data']['id'])) {
        $show  = '0';
        $error = 'noexists';
    }
}

// Show?
if ($show != '1') {
    $admin->show_no_permissions($error, '', '1');
} else {

?>

    <div id="slider_submit">
        <div class="pad24tb">


            <div id="topicons">

                <?php

                $check_fav = $admin->check_favorite($employee['id'], 'member', $data['data']['id']);

                if ($check_fav == '1') {
                    ?>

                    <a href="null.php"
                       onclick="return json_add('favorite_add','<?php echo $data['data']['id']; ?>','1','skip','mtype=member&type=remove');"><img
                            src="imgs/icon-fav-on.png" id="favorite-button-<?php echo $data['data']['id']; ?>"
                            border="0" title="Remove from Favorites" alt="Remove from Favorites" class="icon" width="16"
                            height="16"/> Favorite</a>

                <?php

                } else {
                    ?>

                    <a href="null.php"
                       onclick="return json_add('favorite_add','<?php echo $data['data']['id']; ?>','1','skip','mtype=member&type=add');"><img
                            src="imgs/icon-fav-off.png" id="favorite-button-<?php echo $data['data']['id']; ?>"
                            border="0" title="Add to Favorites" alt="Add to Favorites" class="icon" width="16"
                            height="16"/> Favorite</a>

                <?php

                }

                ?>

                <a href="null.php" onclick="return get_slider_subpage('email');"><img src="imgs/icon-email.png"
                                                                                      border="0" title="Send Email"
                                                                                      alt="Send Email" class="icon"
                                                                                      width="16" height="16"/>E-Mail</a>

                <a href="index.php?l=logins&filters[]=<?php echo $data['data']['id']; ?>||member_id||eq||ppSD_logins"><img
                        src="imgs/icon-login.png" border="0" title="Logins" alt="Logins" class="icon" width="16"
                        height="16"/> Logins</a>

                <a href="index.php?l=transactions&filters[]=<?php echo $data['data']['id']; ?>||member_id||eq||ppSD_cart_sessions&filters[]=1||status||eq||ppSD_cart_sessions"><img
                        src="imgs/icon-sales.png" border="0" title="Sales" alt="Sales" class="icon" width="16"
                        height="16"/> Sales</a> <a href="null.php" onclick="return popup('transaction-add','uid=<?php echo $_POST['id']; ?>&utype=member', '1');"><img src="imgs/icon-quickadd-slider.png" alt="Create Transaction" title="Create Transaction" class="icon-right-slider" /></a>

                <a href="index.php?l=invoices&filters[]=<?php echo $data['data']['id']; ?>||member_id||eq||ppSD_invoices"><img
                        src="imgs/icon-invoices.png" border="0" title="Invoices" alt="Invoices" class="icon" width="16"
                        height="16"/> Invoices</a> <a href="null.php" onclick="return popup('invoice-add','uid=<?php echo $_POST['id']; ?>&utype=member', '1');"><img src="imgs/icon-quickadd-slider.png" alt="Create Invoice" title="Create Invoice" class="icon-right-slider" /></a>

                <a href="index.php?l=subscriptions&filters[]=<?php echo $data['data']['id']; ?>||member_id||eq||ppSD_subscriptions"><img
                        src="imgs/icon-subscriptions.png" border="0" title="Subscriptions" alt="Subscriptions"
                        class="icon" width="16" height="16"/> Subscriptions</a>

                <?php
                $sms_plugin = $db->get_option('sms_plugin');

                $showSMS = false;
                if (! empty($sms_plugin)) {
                    if (!empty($data['data']['cell']) && $data['data']['sms_optout'] != '1') {
                        $showSMS = true;
                    }
                } else {
                    if (!empty($data['data']['cell']) && !empty($data['data']['cell_carrier']) && $data['data']['cell_carrier'] != 'SMS Unavailable' && $data['data']['sms_optout'] != '1') {
                        $showSMS = true;
                    }
                }
                if ($showSMS) {
                    echo "<a href=\"#\" onclick=\"return popup('send-sms','id=" . $data['data']['id'] . "&type=member');\"><img src=\"imgs/icon-text.png\" border=\"0\" title=\"SMS\" alt=\"SMS\" class=\"icon\" width=\"16\" height=\"16\" /> SMS</a>";
                }
                ?>

                <a href="null.php"
                   onclick="return delete_item('ppSD_members','<?php echo $data['data']['id']; ?>','','1');"><img
                        src="imgs/icon-delete-on.png" border="0" title="Delete" alt="Delete" class="icon" width="16"
                        height="16"/> Delete</a>

            </div>


            <ul id="slider_tabs">

                <li id="overview" class="on">Overview</li>

                <li id="data">Data</li>

                <li id="familymembers">Family Members</li>

                <li id="yahrzeits">Yahrzeits</li>

                <li id="history">Activity</li>

                <li id="content">Content</li>

                <li id="notes">Notes<a class="topright_bubble" href="returnnull.php"
                                       onclick="return popup('note-add','user_id=<?php echo $data['data']['id']; ?>&scope=member','1');">+</a>
                </li>

                <li id="outbox">Outbox</li>

                <li id="files">Files</li>

                <?php

                if (!empty($data['data']['twitter']) && $data['data']['twitter'] != 'http://') {
                    echo "<li id=\"social_media\"><img src=\"imgs/icon-twitter.png\" width=\"16\" height=\"16\" alt=\"Twitter Feed\" title=\"Twitter Feed\" border=0 style=\"margin-top:10px;\" /></li>";

                }

                if (!empty($data['data']['facebook']) && $data['data']['facebook'] != 'http://') {
                    echo "<li class=\"external\" id=\"external\" zenurl=\"" . $data['data']['facebook'] . "\"><img src=\"imgs/icon-facebook.png\" width=\"16\" height=\"16\" alt=\"Facebook Feed\" title=\"Facebook Feed\" border=0 style=\"margin-top:10px;\" /></li>";
                }

                ?>

            </ul>

            <div id="slider_left">

                <?php



                echo $data['profile_pic'];



                ?><span class="title"><?php echo $data['data']['last_name']; ?>
                    , <?php echo $data['data']['first_name']; ?></span><?php



                if ($data['data']['converted'] == '1') {
                    echo "<span class=\"data\"><img src=\"imgs/icon-save.png\" border=\"0\" title=\"Converted!\" alt=\"Converted!\" class=\"icon\" />Coverted on " . $data['conversion']['date_show'] . " (" . $data['conversion']['time_since'] . " ago) into member <a href=\"#\" onclick=\"return load_page('member','view','" . $data['conversion']['user_id'] . "');\">" . $data['conversion']['user']['data']['username'] . "</a></span>";

                } else {
                    echo "<span class=\"data\">Member No. " . $data['data']['member_id'] . "</span>";
                }

                echo "<span class=\"data\">" . $data['data']['username'] . "</span>";

                ?>

            </div>

            <div class="clear"></div>

        </div>
    </div>



    <div id="primary_slider_content">

        %inner_content%

    </div>



    <script type="text/javascript" src="<?php echo PP_ADMIN; ?>/js/forms.js"></script>

    <script type="text/javascript" src="<?php echo PP_ADMIN; ?>/js/sliders.js"></script>



<?php

}
