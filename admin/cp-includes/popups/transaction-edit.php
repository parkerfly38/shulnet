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


if (!empty($_POST['id'])) {
    $cart = new cart;
    $data = $cart->get_order($_POST['id']);
    // $data = new history($_POST['id'],'','','','','','ppSD_cart_terms');
    $cid     = $_POST['id'];
    $editing = '1';

}

?>



<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('transaction-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('transaction-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">


<div id="popupsave">

    <input type="submit" value="Save" class="save"/>

</div>

<h1>Editing Order <?php echo $cid; ?></h1>

    <script src="<?php echo PP_ADMIN; ?>/js/form_steps.js" type="text/javascript"></script>
    <ul id="step_tabs" class="popup_tabs">
        <li class="on">
            Overview
        </li><li>
            Shipping
        </li><li>
            Tax Information
        </li>
    </ul>

<div class="popupbody fullForm">

    <div id="step_1" class="step_form fullForm">

    <p class="highlight">You can edit the basics of your order below. Some elements cannot be edited for bookkeeping reasons.</p>

    <fieldset>

        <div class="pad">

            <input type="hidden" value="<?php echo $cid; ?>" name="order[id]"/>

            <label>When was the order placed?</label>
            <?php
            echo $af->date('order[date]', $data['data']['date']);
            ?>

            <label>Was a promo code used for this order?</label>
            <?php
            echo $af->couponList('order[code]', $data['data']['code']);
            ?>


            <label>Who made this purchase?</label>
            <?php
            echo $af->radio('order[member_type]', $data['data']['member_type'], array(
                'member' => 'Member',
                'contact' => 'Contact',
            ));
            ?>

            <div id="show_member" style="display:<?php
            if ($data['data']['member_type'] == 'member') {
                echo 'block';
            } else {
                echo 'none';
            }
            ?>;">
                <label>What member placed this order?</label>
                <?php
                echo $af->memberList('order[member_id]', $data['data']['member_id']);
                ?>
            </div>
            <div id="show_contact" style="display:<?php
            if ($data['data']['member_type'] == 'contact') {
                echo 'block';
            } else {
                echo 'none';
            }
            ?>;">
                <label>What contact placed this order?</label>
                <?php
                echo $af->contactList('order[member_id]', $data['data']['member_id']);
                ?>
            </div>

        </div>

    </fieldset>

</div>


    <script type="text/javascript">
        $("input[type=radio]['order[member_type]']").change(function() {
            switch(this.value) {
                case 'contact':
                    return swap_multi_div('show_contact','show_member');
                case 'member':
                    return swap_multi_div('show_member','show_contact');
            }
        });
        $("input[type=radio]['tax_exempt']").change(function() {
            switch(this.value) {
                case '1':
                    return hide_div('show_tax');
                case '0':
                    return show_div('show_tax');
            }
        });
        $("input[type=radio]['ship_yesno']").change(function() {
            switch(this.value) {
                case '1':
                    return show_div('shipping_show');
                case '0':
                    return hide_div('shipping_show');
            }
        });
    </script>


    <div id="step_2" class="step_form fullForm" style="display:none;">

        <p class="highlight">If shipping information is required for this order, input it below.</p>

<?php

if (!empty($data['shipping_info'])) {
    if (!empty($data['shipping_info']['cart_session']) && $data['shipping_info']['shipped'] != '1') {
        $shipping = '1';
    } else {
        if ($data['shipping_info']['shipped'] != '1') {
            $shipping = '0';
        } else {
            $shipping = '2';
        }
    }
} else {
    $shipping = '0';
}

if ($shipping != '0') {
    ?>

    <fieldset>

    <div class="pad">

    <?php

    if ($shipping == '2') {
        ?>

        <p>This order shipped on <?php echo format_date($data['shipping_info']['ship_date']); ?>
            through <?php echo $data['shipping_info']['shipping_provider'];

            if ($data['shipping_info']['trackable'] == '1') {
                echo " (tracking number " . $data['shipping_info']['shipping_number'] . ")";
            } else {
                echo ".";
            }
            ?></p>

    <?php

    } else {
        ?>

        <label>Shipping?</label>
        <?php
        echo $af->radio('ship_yesno', $shipping, array(
            '0' => 'No shipping required',
            '1' => 'Shipping required',
        ));
        ?>

    <?php

    }

    ?>



    <div id="shipping_show" style="display:<?php if ($shipping == '1') {
        echo "block";
    } else {
        echo "none";
    } ?>;margin-top:12px;">

        <label>Company Name</label>

        <?php
        echo $af->string('shipping[company_name]', $data['shipping_info']['company_name']);

        echo $af->addressForm('shipping', $data['shipping_info']);
        ?>

        <label>Special Instructions</label>
        <?php
        echo $af->string('shipping[ship_directions]', $data['shipping_info']['ship_directions']);
        ?>

    </div>


    </div>

    </fieldset>



<?php

}

?>


    </div>

    <div id="step_3" class="step_form fullForm" style="display:none;">

        <p class="highlight"></p>

<fieldset>

    <div class="pad">

        <?php
        if (! empty($data['data']['state']) || ! empty($data['data']['country'])) {
            $taxable = '1';
        } else {
            $taxable = '0';
        }
        ?>

        <label class="less">Exempt?</label>
        <?php
        echo $af->radio('tax_exempt', $taxable, array(
            '1' => 'Tax Exempt',
            '0' => 'Taxable',
        ));
        ?>

        <div id="show_tax" style="display:<?php if ($taxable == '1') {
            echo "block";
        } else {
            echo "none";
        } ?>;">

            <label class="less">State</label>
            <?php
            echo $af->select('order[state]', $data['data']['state'], state_array());
            ?>

            <label class="less">Country</label>
            <?php
            echo $af->select('order[country]', $data['data']['country'], country_array());
            ?>

        </div>


    </div>

</fieldset>


    </div>
</div>

</form>