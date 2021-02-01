<?php


if (!empty($_POST['id'])) {
    $cart = new cart;
    $data = $cart->get_order($_POST['id'], '0');
    // $data = new history($_POST['id'],'','','','','','ppSD_cart_terms');
    $cid     = $_POST['id'];
    $editing = '1';

}

?>



<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('shipping-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('shipping-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">


    <div id="popupsave">

        <input type="submit" value="Save" class="save"/>

    </div>

    <h1>Mark Order Shipped</h1>


    <div class="pad24t popupbody">


        <fieldset>

            <legend>Overview</legend>

            <div class="pad24t">


                <div class="field">

                    <label class="">Status</label>

                    <div class="field_entry">

                        <input type="radio" name="shipped" onclick="return show_div('more_info');"
                               value="1" <?php if ($data['shipping_info']['shipped'] == '1') {
                            echo "checked=\"checked\"";
                        } ?> /> Shipped

                        <input type="radio" name="shipped" onclick="return show_div('more_info');"
                               value="0" <?php if ($data['shipping_info']['shipped'] != '1') {
                            echo "checked=\"checked\"";
                        } ?> /> Has Not Shipped

                    </div>

                </div>


            </div>

        </fieldset>


        <div id="more_info" style="display:<?php if ($data['shipping_info']['shipped'] == '1') {
            echo "block";
        } else {
            echo "none";
        } ?>;">

            <fieldset>

                <legend>Additional Details</legend>

                <div class="pad24t">


                    <div class="field">

                        <label class="">Provider</label>

                        <div class="field_entry">

                            <select name="shipping_provider" style="width:220px;">

                                <?php

                                echo $admin->shipping_providers($data['shipping_info']['shipping_provider']);

                                ?>

                            </select>

                        </div>

                    </div>


                    <div class="field">

                        <label class="">Trackable</label>

                        <div class="field_entry">

                            <input type="radio" name="trackable" onclick="return show_div('tracking_no');"
                                   value="1" <?php if ($data['shipping_info']['trackable'] == '1') {
                                echo "checked=\"checked\"";
                            } ?> /> Trackable

                            <input type="radio" name="trackable" onclick="return hide_div('tracking_no');"
                                   value="0" <?php if ($data['shipping_info']['trackable'] != '1') {
                                echo "checked=\"checked\"";
                            } ?> /> Not Trackable

                        </div>

                    </div>


                    <div class="field" id="tracking_no"
                         style="display:<?php if ($data['shipping_info']['trackable'] == '1') {
                             echo "block";
                         } else {
                             echo "none";
                         } ?>;">

                        <label class="">Tracking Number</label>

                        <div class="field_entry">

                            <input type="text" name="shipping_number" style="width:220px;"
                                   value="<?php echo $data['shipping_info']['shipping_number']; ?>"/>

                        </div>

                    </div>


                </div>

            </fieldset>


            <fieldset>

                <legend>Remarks</legend>

                <div class="pad24t">


                    <div class="field">

                        <textarea name="remarks" id="remoak" class="richtext" style="width:100%;height:120px;"></textarea>

                        <?php

                        echo $admin->richtext('480px', '250px', 'remoak', '0', '1');

                        ?>

                    </div>


                </div>

            </fieldset>


        </div>


</form>