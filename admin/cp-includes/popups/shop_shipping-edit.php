<?php

if (!empty($_POST['id'])) {
    $cart = new cart;
    $data = $cart->get_shipping_rule($_POST['id']);
    // $data = new history($_POST['id'],'','','','','','ppSD_cart_terms');
    $cid     = $_POST['id'];
    $editing = '1';
} else {
    $data    = array(
        'cost'     => '',
        'low'      => '',
        'high'     => '',
        'country'  => '',
        'state'    => '',
        'details'  => '',
        'priority' => '',
        'product'  => '',
        'sync_id'  => '',
        'type'     => 'flat',
        'name'     => '',
    );
    $cid     = generate_id('random', '8');
    $editing = '0';
}

?>

<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('shop_shipping-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('shop_shipping-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">


<div id="popupsave">

    <input type="submit" value="Save" class="save"/>

</div>

<h1>Shipping Rules</h1>


<div class="pad24t popupbody">


<p class="highlight">Shipping rules allow you to set up flat shipping rates, as well as "special rules" shipping rules
    according to region, weight, or quantity, cart total, or product. All rules, with the exception of "flat-rate" rules
    apply to individual products, not the entire cart.</p>


<fieldset>

    <legend>Step 1: Rule Basics</legend>

    <div class="pad24t">


        <div class="field">

            <label>Type</label>

            <div class="field_entry">

                <b>Cart-specific</b><br/>

                <input type="radio" name="type" value="flat"
                       onclick="return swap_multi_div('flat','region,qty,total,product');" <?php if ($data['type'] == 'flat') {
                    echo "checked=\"checked\"";
                } ?> /> Flat-rate shipping rule<br/>

                <input type="radio" name="type" value="region"
                       onclick="return swap_multi_div('region','flat,qty,total,product');" <?php if ($data['type'] == 'region') {
                    echo "checked=\"checked\"";
                } ?> /> Region-based rule<br/>

                <input type="radio" name="type" value="qty"
                       onclick="return swap_multi_div('qty','region,flat,total,product');" <?php if ($data['type'] == 'qty') {
                    echo "checked=\"checked\"";
                } ?> /> Quantity-based rule<br/><br/>

                <!--
                <input type="radio" name="type" value="total"
                       onclick="return swap_multi_div('total','region,qty,flat,product');" <?php if ($data['type'] == 'total') {
                    echo "checked=\"checked\"";
                } ?> /> Cart total based rule<br/><br/>
                -->

                <b>Product-specific</b><br/>


                <input type="radio" name="type" value="product"
                       onclick="return swap_multi_div('product','region,qty,total,flat');" <?php if ($data['type'] == 'product') {
                    echo "checked=\"checked\"";
                } ?> /> Product-specific rule

            </div>

        </div>


        <div class="field">

            <label>Name</label>

            <div class="field_entry">

                <input type="text" value="<?php echo $data['name']; ?>" name="name" id="name" style="width:200px;"
                       class="req"/>

            </div>

        </div>



        <div class="field">
            <label>SyncId</label>
            <div class="field_entry">
                <input type="text" value="<?php echo $data['sync_id']; ?>" name="sync_id" id="sync_id" style="width:200px;"
                       class=""/>
                <p class="field_desc">Optional "SyncId" used for development and external service matching.</p>

            </div>

        </div>


        <div class="field">

            <label>Details</label>

            <div class="field_entry">

                <input type="text" value="<?php echo $data['details']; ?>" name="details" id="details"
                       style="width:100%;"/>

            </div>

        </div>


        <div class="field">

            <label>Cost</label>

            <div class="field_entry">

                <?php





                echo currency_symbol('<input type="text" value="' . $data['cost'] . '" name="cost" id="cost" style="width:80px;" maxlength="7" />');

                ?>

            </div>

        </div>


        <div class="field">

            <label>Priority</label>

            <div class="field_entry">

                <input type="text" value="<?php echo $data['priority']; ?>" name="priority" id="priority"
                       style="width:85px;" maxlength="3" class="zen_num"/>

                <p class="field_desc">Relative to other shipping rules that could apply to a product, where does this
                    rule rank in importance?</p>

            </div>

        </div>


    </div>

</fieldset>


<fieldset id="flat" style="display:<?php if ($data['type'] == 'flat') {
    echo "block";
} else {
    echo "none";
} ?>;">

    <legend>Flat-rate Shipping Rule</legend>

    <div class="pad24t">

        <p>No additional information is required.</p>

    </div>

</fieldset>


<fieldset id="region" style="display:<?php if ($data['type'] == 'region') {
    echo "block";
} else {
    echo "none";
} ?>;">

    <legend>Region-based Shipping Rule</legend>

    <div class="pad24t">

        <div class="field">

            <label>Country</label>

            <div class="field_entry">

                <?php





                $field = new field;

                $rendered = $field->render_field('country', $data['country'], '', '', '', '', 'width:200px;', 'region[country]');

                echo $rendered['3'];

                ?>

            </div>

        </div>

        <div class="field">

            <label>State</label>

            <div class="field_entry">

                <?php





                $rendered = $field->render_field('state', $data['state'], '', '', '', '', 'width:200px;', 'region[state]');

                echo $rendered['3'];

                ?>

            </div>

        </div>

    </div>

</fieldset>


<fieldset id="qty" style="display:<?php if ($data['type'] == 'qty') {
    echo "block";
} else {
    echo "none";
} ?>;">

    <legend>Quantity-based Shipping Rule</legend>

    <div class="pad24t">

        <div class="field">

            <label>Quantity</label>

            <div class="field_entry">

                Between <input type="text" value="<?php echo $data['low']; ?>" name="qty[low]" id="low"
                               style="width:85px;" maxlength="5" class=""/> and <input type="text"
                                                                                       value="<?php echo $data['high']; ?>"
                                                                                       name="qty[high]" id="high"
                                                                                       style="width:85px;" maxlength="5"
                                                                                       class=""/> units

            </div>

        </div>

    </div>

</fieldset>


<fieldset id="total" style="display:<?php if ($data['type'] == 'total') {
    echo "block";
} else {
    echo "none";
} ?>;">

    <legend>Cart-total Shipping Rule</legend>

    <div class="pad24t">

        <div class="field">

            <label>Total</label>

            <div class="field_entry">

                Between <?php





                echo currency_symbol('<input type="text" value="' . $data['low'] . '" name="total[low]" id="low" style="width:85px;" maxlength="5" class="" />');

                ?> and <?php





                echo currency_symbol('<input type="text" value="' . $data['high'] . '" name="total[high]" id="high" style="width:85px;" maxlength="5" class="" />');

                ?>

            </div>

        </div>

    </div>

</fieldset>


<fieldset id="product" style="display:<?php if ($data['type'] == 'product') {
    echo "block";
} else {
    echo "none";
} ?>;">

    <legend>Product-specific Shipping Rule</legend>

    <div class="pad24t">

        <div class="field">

            <label>Name</label>

            <div class="field_entry">

                <input type="text" id="productf" name="product_dud"
                       autocomplete="off" onkeyup="return autocom(this.id,'id','name','ppSD_products','name','product');" value="<?php

                if (! empty($data['product'])) {
                    $prod = $cart->get_product_name($data['product']);
                    echo $prod;
                }

                ?>" style="width:285px;"/> <a href="null.php" onclick="return get_list('products','productf_id','productf');"><img src="imgs/icon-list.png" width="16" height="16" border="0" alt="Select from list" title="Select from list" class="icon-right"/></a>

                <input type="hidden" name="product" id="productf_id" value="<?php echo $data['product']; ?>"/>

                <p class="field_desc" id="product_dud_dets">Begin typing the product's name and select it when it
                    appears.</p>

            </div>

        </div>

    </div>

</fieldset>


<fieldset id="weight" style="display:<?php if ($data['type'] == 'weight') {
    echo "block";
} else {
    echo "none";
} ?>;">

    <legend>Product-weight Shipping Rule</legend>

    <div class="pad24t">

        <div class="field">

            <label>Weight</label>

            <div class="field_entry">

                Between <input type="text" value="<?php echo $data['low']; ?>" name="weight[low]" id="low"
                               style="width:85px;" maxlength="5" class=""/> and <input type="text"
                                                                                       value="<?php echo $data['high']; ?>"
                                                                                       name="weight[height]" id="high"
                                                                                       style="width:85px;" maxlength="5"
                                                                                       class=""/>

            </div>

        </div>

    </div>

</fieldset>


</div>


</form>