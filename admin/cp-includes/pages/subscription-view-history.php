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
// Check permissions, ownership,
// and if it exists.
$permission = 'subscription-edit';
$check = $admin->check_permissions($permission, $employee);
if ($check != '1') {
    $admin->show_no_permissions($error, '', '1');

} else {
    // Ownership
    $subscription = new subscription;
    $sub          = $subscription->get_subscription($_POST['id']);
    // History
    $criteria = array(
        'subscription_id' => $sub['data']['id']
    );
    $get_crit = htmlentities(serialize($criteria));
    $history  = new history('', $criteria, '1', '50', 'date', 'DESC', 'ppSD_cart_items_complete');



    ?>



    <form action="cp-includes/get_table.php" id="slider_sorting" method="post"
          onsubmit="return update_slider_table('ppSD_cart_items_complete');">

        <input type="hidden" name="subscription_id" value="<?php echo $sub['data']['id']; ?>"/>

        <input type="hidden" name="criteria" value="<?php echo $get_crit; ?>"/>

        <input type="hidden" name="order" value="date"/>

        <input type="hidden" name="dir" value="DESC"/>

        <div id="slider_top_table">

            <div class="floatright">

                <span>Displaying <input type="text" name="display" value="<?php echo $history->{'display'}; ?>"
                                        style="width:35px;" class="normalpad"/> of <span
                        id="sub_total_display"><?php echo $history->{'total_results'}; ?></span></span>

                <span class="div">|</span>

                <span>Page <input type="text" name="page" value="<?php echo $history->{'page'}; ?>" style="width:25px;"
                                  class="normalpad"/> of <span
                        id="sub_page_number"><?php echo $history->{'pages'}; ?></span></span>

                <span><input type="submit" value="Go"
                             style="position:absolute;left:-9999px;width:1px;height:1px;"/></span>

            </div>

            <div class="floatleft">

                <!--
                <input type="button" value="New Charge" class="save"
                       onclick="return popup('transaction_add','subscription_id=<?php echo $sub['data']['id']; ?>&member_id=<?php echo $sub['data']['member_id']; ?>&card_id=<?php echo $sub['data']['card_id']; ?>');"/>
                       -->

            </div>

            <div class="clear"></div>

        </div>

    </form>





    <table class="tablesorter listings" id="subslider_table" border="0">

        <?php

        echo $history->table_cells['th'];

        echo $history->table_cells['td'];

        ?>

    </table>





<?php

}

?>