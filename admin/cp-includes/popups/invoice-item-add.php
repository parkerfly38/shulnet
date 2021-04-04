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

$invoice = new invoice;
$data = $invoice->get_invoice($_POST['invoice_id']);

/*
if ($data['data']['status'] == '1') {
    $admin->show_popup_error('You cannot alter a paid invoice. Please create a new invoice.');
    exit;
}
*/

if ($_POST['id'] == 'new') {
    $element = array(
        'invoice_id'  => '',
        'type'        => 'product',
        'minutes'     => '0',
        'hourly'      => '',
        'product_id'  => '',
        'qty'         => '',
        'unit_price'  => '',
        'status'      => '',
        'date'        => '',
        'option1'     => '',
        'option2'     => '',
        'option3'     => '',
        'option4'     => '',
        'option5'     => '',
        'name'        => '',
        'description' => '',
        'owner'       => '2',
        'tax'         => '1',
    );
    $cid     = 'new';
    $editing = '0';

} else {
    $element = $invoice->get_component($_POST['id']);
    $cid     = $_POST['id'];
    $editing = '1';

}



?>



<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('invoice_item-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('invoice_item-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">

<input type="hidden" name="invoice_id" value="<?php echo $_POST['invoice_id']; ?>"/>


<div id="popupsave">

    <input type="submit" value="Save" class="save"/>

</div>

<h1>Invoice Component</h1>


<div class="fullForm popupbody">

    <p class="highlight">A component is a product, credit, or hourly billing that is added to the invoice. Components are added up together to get the invoice's total.</p>

    <div class="col33l noBorder">

        <fieldset>

<?php

if ($editing != '1') {
    ?>

        <legend>Component Type</legend>

        <div class="pad24t">

            <div class="field">

                <label>Type</label>

                <div class="field_entry">

                    <input type="radio" name="type" value="product" <?php if ($element['type'] == 'product') {
                        echo " checked=\"checked\"";
                    } ?> onclick="return swap_multi_div('product','newproduct,time,credit');"/> Existing Product<br/>

                    <input type="radio" name="type" value="newproduct"
                           onclick="return swap_multi_div('newproduct','product,time,credit');"/> New Product<br/>

                    <input type="radio" name="type" value="time"  <?php if ($element['type'] == 'time') {
                        echo " checked=\"checked\"";
                    } ?> onclick="return swap_multi_div('time','newproduct,product,credit');"/> Time-based<br/>

                    <input type="radio" name="type" value="credit"  <?php if ($element['type'] == 'credit') {
                        echo " checked=\"checked\"";
                    } ?> onclick="return swap_multi_div('credit','newproduct,product,time');"/> Credit<br/>

                </div>

            </div>

        </div>


<?php

} else {
    ?>

    <input type="hidden" name="type" value="<?php echo $element['type']; ?>"/>

<?php

}

?>

            <legend>Options</legend>
            <div class="pad24t">
                <div class="field">
                    <label class="less">Taxable?</label>
                    <div class="field_entry_less">
                        <input type="checkbox" name="tax" value="1" <?php if ($element['tax'] == '1') {
                            echo "checked=\"checked\"";
                        } ?> /> Taxable (Rate = <?php echo $data['format_totals']['format_tax_rate']; ?>)
                    </div>
                </div>


                <div class="field">
                    <label class="less">Notify User</label>
                    <div class="field_entry_less">
                        <input type="checkbox" name="notify_user" value="1" <?php
                        if ($data['data']['auto_inform'] == '1') { echo " checked=\"checked\""; }
                        ?> /> Notify the client of an update to this invoice.
                    </div>
                </div>
            </div>

        </fieldset>

    </div>
    <div class="col66r noBorder">

<fieldset id="newproduct" style="display:none;">
    <legend>New Product</legend>
    <div class="pad24t">

        <div class="field">
            <label class="less">Name</label>

            <div class="field_entry_less">
                <input type="text" value="" name="newproduct[name]" id="newprodid" style="width:100%;"/>
            </div>
        </div>

        <div class="field">
            <label class="less">Description</label>

            <div class="field_entry_less">
                <input type="text" value="" name="newproduct[tagline]" id="newprodtagline" style="width:100%;"/>
            </div>
        </div>

        <div class="col50l">

            <div class="field">
                <label class="less">Price</label>
                <div class="field_entry_less">
                    <?php
                    echo place_currency('<input type="text" value="" name="newproduct[price]" id="newprodprice" style="width:80px;"/>', '1')
                    ?>
                </div>
            </div>

        </div>
        <div class="col50r">

            <div class="field">
                <label class="less">Qty</label>

                <div class="field_entry_less">
                    <input type="text" name="newproduct[qty]" value="<?php echo $element['qty']; ?>" style="width:80px;"/>
                </div>
            </div>

        </div>
        <div class="clear"></div>

    </div>
</fieldset>


<fieldset id="product" style="display:<?php if ($element['type'] == 'product') {
    echo "block";
} else {
    echo "none";
} ?>;">

    <legend>Existing Product</legend>

    <div class="pad24t">

        <div class="col75l">

            <div class="field">
                <label class="less">Product</label>

                <div class="field_entry_less">
                    <input type="text" value="<?php echo $element['name']; ?>" name="product_dud" id="productd"
                           autocomplete="off" onkeyup="return autocom(this.id,'id','name','ppSD_products','name','products');"
                           style="width:90%;"/> <a href="null.php" onclick="return get_list('products','productd_id','productd');"><img src="imgs/icon-list.png" width="16" height="16" border="0" alt="Select from list" title="Select from list" class="icon-right"/></a>
                    <input type="hidden" name="product[id]" id="productd_id" value="<?php echo $element['product_id']; ?>"/>
                </div>
            </div>

        </div>
        <div class="col25l">

            <div class="field">
                <label class="less">Qty</label>
                <div class="field_entry_less">
                    <input type="text" name="product[qty]" value="<?php echo $element['qty']; ?>" style="width:80px;"/>
                </div>
            </div>

        </div>
        <div class="clear"></div>


        <div class="field">
            <label class="top">Description</label>
            <div class="clear"></div>
            <div class="field_entry_top">
                <textarea name="product[description]" id="cdesc" class="richtext"
                          style="width:100%;height:200px;"><?php echo $element['description']; ?></textarea>
            </div>
            <?php
            echo $admin->richtext('100%', '150px', 'cdesc', '0', '1');
            ?>
        </div>

    </div>

</fieldset>


<fieldset id="credit" style="display:<?php if ($element['type'] == 'credit') {
    echo "block";
} else {
    echo "none";
} ?>;">
    <legend>Credit</legend>
    <div class="pad24t">

        <div class="col75l">

            <div class="field">
                <label class="less">Name</label>
                <div class="field_entry_less">
                    <input type="text" name="credit[name]" value="<?php echo $element['name']; ?>" style="width:100%;"/>
                </div>
            </div>

        </div>
        <div class="col25r">

            <div class="field">
                <label class="less">Amount</label>
                <div class="field_entry_less">
                    <?php
                    echo place_currency('<input type="text" name="credit[amount]" value="' . $element['unit_price'] . '" style="width:100px;" />', '1')
                    ?>
                </div>
            </div>

        </div>
        <div class="clear"></div>

        <div class="field">
            <label class="top">Description</label>
            <div class="clear"></div>
            <div class="field_entry_top">
                <textarea name="credit[description]" id="cdesc1" class="richtext"
                          style="width:100%;height:200px;"><?php echo $element['description']; ?></textarea>
            </div>
            <?php
            echo $admin->richtext('480px', '250px', 'cdesc1', '0', '1');
            ?>
        </div>

    </div>
</fieldset>


<fieldset id="time" style="display:<?php if ($element['type'] == 'time') {
    echo "block";
} else {
    echo "none";
} ?>;">

    <legend>Time-based</legend>

    <div class="pad24t">

        <div class="col75l">
            <div class="field">
                <label class="less">Title</label>
                <div class="field_entry_less">
                    <input type="text" name="time[name]" value="<?php echo $element['name']; ?>" style="width:100%;"/>
                </div>
            </div>
        </div>
        <div class="col25r">

            <div class="field">
                <label class="less">Minutes</label>
                <div class="field_entry_less">
                    <input type="text" id="time_min_text" style="width:120px;" name="time[minutes]"
                           value="<?php echo $element['minutes']; ?>"/>
                </div>
            </div>

            <div class="field">
                <label class="less">Timer<span id="time_sec_text" style="display:inline;margin-left:12px;display:none;">00</span></label>
                <div class="field_entry_less">
                     <input
                        type="button" id="timer_button" value="Start" />
                </div>
            </div>


        </div>
        <div class="clear"></div>

        <div class="field">
            <label class="top">Description</label>
            <div class="clear"></div>
            <div class="field_entry_top">
                    <textarea name="time[description]" id="tdesc" class="richtext"
                              style="width:100%;height:200px;"><?php echo $element['description']; ?></textarea>
            </div>
            <?php
            echo $admin->richtext('480px', '250px', 'tdesc', '0', '1');
            ?>
        </div>

    </div>

</fieldset>

    </div>

</div>


</form>


<script type="text/javascript" src="js/stopwatch.js"></script>

<span id="sound_dummy"></span>