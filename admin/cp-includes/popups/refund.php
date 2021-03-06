<?php


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
        return json_add('refund-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('refund-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">


<div id="popupsave">

    <input type="submit" value="Save" class="save"/>

</div>

<h1>Refund Order</h1>


<div class="pad24t popupbody">


    <fieldset>

        <legend>Overview</legend>

        <div class="pad24t">


            <div class="field">

                <label class="less">Amount</label>

                <div class="field_entry_less">

                    <?php

                    echo place_currency('<input type="text" id="total" name="total" style="width:100px;" class="req zen_money" value="' . $data['pricing']['total'] . '" />', '1');

                    ?>

                </div>

            </div>


        </div>

    </fieldset>


    <fieldset>

        <legend>Options</legend>

        <div class="pad24t">


            <div class="field">

                <label class="">Refund</label>

                <div class="field_entry">

                    <?php

                    if (!empty($order['data']['payment_gateway'])) {
                        echo "<input type=\"hidden\" name=\"issue_in_gateway\" value=\"0\" /><p>There is no payment gateway associated with this order. This means that you will need to manually refund the order from the payment gateway interface.</p>";

                    } else {
                        $gateway = $cart->get_gateways('', $data['data']['payment_gateway']);
                        if ($gateway['0']['method_refund'] == '1') {
                            if (!empty($data['data']['gateway_order_id'])) {
                                echo "<input type=\"radio\" name=\"issue_in_gateway\" value=\"1\" checked=\"checked\" /> Issue refund in gateway<br />";
                                echo "<input type=\"radio\" name=\"issue_in_gateway\" value=\"0\" /> Do not refund in payment gateway";

                            } else {
                                echo "<p>Your gateway supports refunds, however this order does not appear to have a gateway reference number. This means that you will need to manually refund the order from your payment gateway.</p>";

                            }

                        } else {
                            echo "<input type=\"hidden\" name=\"issue_in_gateway\" value=\"0\" /><p>The module for this payment gateway (" . $gateway['0']['name'] . ") does not support refunds.</p>";

                        }

                    }

                    ?>

                </div>

            </div>


            <div class="field">

                <label class="">E-Mail User</label>

                <div class="field_entry">

                    <input type="radio" name="email_user" onclick="return show_div('show_remarks');" value="1"
                           checked="checked"/> E-Mail the user about the refund.<br/>

                    <input type="radio" name="email_user" onclick="return hide_div('show_remarks');" value="0"/> Do not
                    e-mail the user.<br/>

                </div>

            </div>


            <div class="field">

                <label class="">Subscriptions</label>

                <div class="field_entry">

                    <input type="radio" name="cancel_subs" value="1"/> Cancel subscriptions and invoices, if any.<br/>

                    <input type="radio" name="cancel_subs" value="0" checked="checked"/> Do not cancel subscription and
                    invoices.<br/>

                </div>

            </div>


        </div>

    </fieldset>


    <fieldset>

        <legend>Refund Type?</legend>

        <div class="pad24t">


            <div class="field">

                <label class="">Type</label>

                <div class="field_entry">

                    <input type="radio" name="type" value="1" checked="checked"
                           onclick="return hide_div('chargeback_fee');"/> Refund<br/>

                    <input type="radio" name="type" value="2" onclick="return show_div('chargeback_fee');"/>
                    Chargeback<br/>

                </div>

            </div>


            <div class="field" id="chargeback_fee" style="display:none;">

                <label class="">Chargeback Fee</label>

                <div class="field_entry">

                    <?php

                    echo place_currency('<input type="text" id="chargeback_fee" name="chargeback_fee" style="width:100px;" class="zen_money" value="" />', '1');

                    ?>

                </div>

            </div>


        </div>

    </fieldset>


    <fieldset>

        <legend>Remarks</legend>

        <div class="pad24t">


            <div class="field">

                <textarea name="remarks" class="richtext" id="fje82" style="width:100%;height:200px;"></textarea>

                <?php
                echo $admin->richtext('100%', '250px', 'fje82', '0', '1');
                ?>

            </div>


            <div class="field" id="show_remarks">

                <label class="less">Show Remarks?</label>

                <div class="field_entry_less">

                    <input type="radio" name="show_remarks" value="1" checked="checked"/> Display remarks to the
                    user.<br/>

                    <input type="radio" name="show_remarks" value="0"/> Do not show user these remarks.<br/>

                </div>

            </div>


        </div>

    </fieldset>


</div>


</form>