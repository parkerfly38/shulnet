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
// Check permissions, ownership,
// and if it exists.
$show = '1';
$permission = 'product';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $show  = '0';
    $error = 'permissions';

}
// Show?
if ($show != '1') {
    $admin->show_no_permissions($error, '', '1');

} else {
    // Check if refreshing the cache.
    include "check_cache.php";
    $cart = new cart;
    $data = $cart->get_product($_POST['id'], $recache);
    ?>



    <div id="slider_submit">
        <div class="pad24tb">


            <div id="topicons">

                <?php

                if ($data['data']['type'] == '2' || $data['data']['type'] == '3') {
                    if (!empty($data['package'])) {
                        ?>

                        <a href="null.php"
                           onclick="return popup('package','id=<?php echo $data['package']['id']; ?>');"><img
                                src="imgs/icon-package.png" border="0" title="Package" alt="Package" class="icon"
                                width="16" height="16"/> View Package</a>

                    <?php

                    }

                }

                if ($data['data']['hide'] != '1') {
                    ?>

                    <a href="<?php echo $data['data']['link']; ?>" target="_blank"><img src="imgs/icon-view.png"
                                                                                        border="0"
                                                                                        title="View in Catalog"
                                                                                        alt="View in Catalog"
                                                                                        class="icon" width="16"
                                                                                        height="16"/> View in
                        Catalog</a>

                <?php

                }

                ?>

                <a href="null.php"
                   onclick="return delete_item('ppSD_products','<?php echo $data['data']['id']; ?>','','1');"><img
                        src="imgs/icon-delete-on.png" border="0" title="Delete" alt="Delete" class="icon" width="16"
                        height="16"/> Delete</a>

            </div>


            <ul id="slider_tabs">

                <li id="overview" class="on">Overview</li>

                <li id="product-edit:<?php echo $data['data']['id']; ?>" class="popup_large">Edit</li>

                <li id="history">History</li>

                <li id="notes">Notes<a class="topright_bubble" href="returnnull.php"
                                       onclick="return popup('note-add','user_id=<?php echo $data['data']['id']; ?>&scope=product','1');">+</a>
                </li>

            </ul>

            <div id="slider_left">

                <span class="title"><?php echo $data['data']['name']; ?></span>

            <span class="data"><?php



                echo $data['data']['show_type'] . ' in ' . $data['category']['name'];

                ?></span>

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

?>