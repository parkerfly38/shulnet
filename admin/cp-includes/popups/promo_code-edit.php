<?php


if (!empty($_POST['id'])) {
    $cid     = $_POST['id'];
    $editing = '1';
    $cart    = new cart;
    $data    = $cart->get_savings_code($cid);

} else {
    $data    = array(
        'description'            => '',
        'dollars_off'            => '',
        'percent_off'            => '',
        'products'               => '',
        'max_use_overall'        => '',
        'date_start'             => '',
        'date_end'               => '',
        'current_customers_only' => '',
        'max_use_per_user'       => '',
        'cart_minimum'           => '',
        'type'                   => 'percent_off',
        'flat_shipping'          => '',
        'id'                     => ''
    );
    $cid     = '';
    $editing = '0';

}

?>



<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('promo_code-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('promo_code-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">


<div id="popupsave">

    <input type="submit" value="Save" class="save"/>

</div>

<h1>Promo Code Management</h1>


<div class="pad24t popupbody">


<fieldset>

    <legend>Code Overview</legend>

    <div class="pad24t">


        <div class="field">

            <label>Code</label>

            <div class="field_entry">

                <input type="text" name="id" id="id" style="" maxlength="15" class="req"
                       value="<?php echo $data['id']; ?>" class="zen_letnum"/>

            </div>

        </div>


        <div class="field">

            <label>Description</label>

            <div class="field_entry">

                <input type="text" name="description" id="description" maxlength="150" style="width:100%;"
                       value="<?php echo $data['description']; ?>"/>

            </div>

        </div>


        <div class="field">

            <label>Type</label>

            <div class="field_entry">

                <input type="radio" onclick="return swap_multi_div('percent','dollars,shipping');" name="type"
                       value="percent_off" <?php if ($data['type'] == 'percent_off') {
                    echo " checked=\"checked\"";
                } ?> /> Percent Discount<br/>

                <input type="radio" onclick="return swap_multi_div('dollars','percent,shipping');" name="type"
                       value="dollars_off" <?php if ($data['type'] == 'dollars_off') {
                    echo " checked=\"checked\"";
                } ?> /> Fixed Discount<br/>

                <input type="radio" onclick="return swap_multi_div('shipping','percent,dollars');" name="type"
                       value="shipping" <?php if ($data['type'] == 'shipping') {
                    echo " checked=\"checked\"";
                } ?> /> Flat-Rate Shipping

            </div>

        </div>


        <div class="field" id="percent" style="display:<?php if ($data['type'] == 'percent_off') {
            echo "block";
        } else {
            echo "none";
        } ?>;">

            <label>Discount</label>

            <div class="field_entry">

                <input type="text" value="<?php echo $data['percent_off']; ?>" name="percent_off" id="percent_off"
                       style="width:80px;" maxlength="5" class="zen_money"/>%

            </div>

        </div>


        <div class="field" id="shipping" style="display:<?php if ($data['type'] == 'shipping') {
            echo "block";
        } else {
            echo "none";
        } ?>;">

            <label>Shipping Cost</label>

            <div class="field_entry">

                <?php





                echo currency_symbol('<input type="text" value="' . $data['flat_shipping'] . '" name="flat_shipping" id="flat_shipping" style="width:80px;" maxlength="7" class="zen_money" />');

                ?>

            </div>

        </div>


        <div class="field" id="dollars" style="display:<?php if ($data['type'] == 'dollars_off') {
            echo "block";
        } else {
            echo "none";
        } ?>;">

            <label>Discount</label>

            <div class="field_entry">

                <?php





                echo currency_symbol('<input type="text" value="' . $data['dollars_off'] . '" name="dollars_off" id="dollars_off" style="width:80px;" maxlength="5" class="zen_money" />');

                ?>

            </div>

        </div>


    </div>

</fieldset>


<fieldset>

    <legend>Usage Criteria</legend>

    <div class="pad24t">


        <div class="field">

            <label>Cart Minimum</label>

            <div class="field_entry">

                <?php





                echo currency_symbol('<input type="text" value="' . $data['cart_minimum'] . '" name="cart_minimum" id="cart_minimum" style="width:80px;" maxlength="7" class="zen_money" />');

                ?>

            </div>

        </div>


        <div class="field">

            <label>Effective Date</label>

            <div class="field_entry">

                <?php

                echo $af
                    ->setSpecialType('datetime')
                    ->setValue($data['date_start'])
                    ->string('date_start');

                //echo $admin->datepicker('date_start', $data['date_start'], '1', '250');

                ?>

            </div>

        </div>


        <div class="field">

            <label>Expiration Date</label>

            <div class="field_entry">

                <?php



                echo $af
                    ->setSpecialType('datetime')
                    ->setValue($data['date_end'])
                    ->string('date_end');


                // echo $admin->datepicker('date_end', $data['date_end'], '1', '250');

                ?>

            </div>

        </div>


        <div class="field">

            <label>Max Uses</label>

            <div class="field_entry">

                <input type="text" value="<?php echo $data['max_use_overall']; ?>" name="max_use_overall"
                       id="max_use_overall" style="width:80px;" maxlength="7" class="zen_num"/>

            </div>

        </div>


        <div class="field">

            <label>Permissions</label>

            <div class="field_entry">

                <input type="radio" name="current_customers_only"
                       value="0" <?php if ($data['current_customers_only'] != '1') {
                    echo " checked=\"checked\"";
                } ?> onclick="return hide_div('uses_per_user');"/> Anybody <input type="radio"
                                                                                  name="current_customers_only"
                                                                                  value="1" <?php if ($data['current_customers_only'] == '1') {
                    echo " checked=\"checked\"";
                } ?> onclick="return show_div('uses_per_user');"/> Members Only

            </div>

        </div>


        <div class="field" id="uses_per_user" style="<?php if ($data['current_customers_only'] == '1') {
            echo "display:block;";
        } else {
            echo "display:none;";
        } ?>">

            <label>Max Uses Per Member</label>

            <div class="field_entry">

                <input type="text" value="<?php echo $data['max_use_per_user']; ?>" name="max_use_per_user"
                       id="max_use_per_user" style="width:80px;" maxlength="7" class="zen_num"/>

            </div>

        </div>


    </div>

</fieldset>


<fieldset>

    <legend>Applicable Products</legend>

    <div class="pad24t">

        <p>At least one of these will need to be in a user's cart for the code to be applied.</p>


        <div class="field">

            <input type="text" name="products" id="products" style="width:250px;"
                   autocomplete="off" onkeyup="return autocom(this.id,'id','name','ppSD_products','name','','1');" value=""/>

            <?php
            if ($editing == '1') {
                if (!empty($data['products'])) {
                    $exp = explode(',', $data['products']);
                    foreach ($exp as $aProd) {
                        $mid = rand(100, 9999999);
                        echo '<span title="Click to Remove" style="width:232px;" class="atag" id="' . $mid . '" onclick="return closeDiv(\'' . $mid . '\',\'\',\'1\')">' . $aProd . '<input type="hidden" name="products[]" value="' . $aProd . '"></span>';

                    }

                }

            }
            ?>

        </div>


    </div>

</fieldset>


</div>


</form>