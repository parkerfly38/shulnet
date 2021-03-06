<?php 



if (!empty($_POST['id'])) {
    $cid     = $_POST['id'];
    $editing = '1';
    $data    = new history($_POST['id'], '', '', '', '', '', 'ppSD_payment_gateways');

} else {
    exit;

}

?>



<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('payment_gateway-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('payment_gateway-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">


<div id="popupsave">

    <input type="submit" value="Save" class="save"/>

</div>

<h1><?php echo $data->{'final_content'}['name']; ?></h1>


<div class="pad24t popupbody">


<fieldset>

    <legend>Gateway Description</legend>

    <div class="pad24t">


        <dl>

            <dt>Code</dt>

            <dd><?php echo $data->{'final_content'}['code']; ?></dd>


            <dt>Type</dt>

            <dd><?php if ($data->{'final_content'}['api'] == '1') {
                    echo "API";
                } else {
                    echo "Non-API";
                } ?></dd>


            <dt>Card Storage</dt>

            <dd><?php if ($data->{'final_content'}['api'] == '1') {
                    if ($data->{'final_content'}['local_card_storage'] == '1') {
                        echo "Encrypted and stored locally.";

                    } else {
                        echo "Stored by the gateway.";

                    }

                } else {
                    echo "Credit card storage unavailable.";
                } ?></dd>

        </dl>


        <dt>PCI Compliance</dt>

        <dd><?php





            if ($data->{'final_content'}['api'] == '1') {
                if ($data->{'final_content'}['local_card_storage'] == '1') {
                    echo "Full compliance is required.";
                    $pci_compliance = '1';

                } else {
                    echo "Basic compliance is required.";
                    $pci_compliance = '1';

                }

            } else {
                echo "Not required.";
                $pci_compliance = '0';

            }

            ?></dd>


        <div class="clear"></div>


    </div>

</fieldset>


<fieldset>

    <legend>Gateway Overview</legend>

    <div class="pad24t">


        <div class="field">

            <label class="less">Status</label>

            <div class="field_entry_less">

                <input onclick="return show_div('show_active');" type="radio" name="active"
                       value="1" <?php if ($data->{'final_content'}['active'] == '1') {
                    echo "checked=\"checked\"";
                } ?> /> On <input onclick="return hide_div('show_active');" type="radio" name="active"
                                  value="0" <?php if ($data->{'final_content'}['active'] != '1') {
                    echo "checked=\"checked\"";
                } ?> /> Off

            </div>

        </div>


        <div class="field">

            <label class="less">Fees</label>

            <div class="field_entry_less">

                <?php echo currency_symbol('<input type="text" value="' . $data->{'final_content'}['fee_flat'] . '" name="fee_flat" id="fee_flat" style="width:80px;" maxlength="7" />'); ?>
                flat rate + <input type="text" name="fee_percent" style="width:80px;" maxlength="5"
                                   value="<?php echo $data->{'final_content'}['fee_percent']; ?>"/>% per transaction

            </div>

        </div>


    </div>

</fieldset>


<div id="show_active" style="<?php if ($data->{'final_content'}['active'] == '1') {
    echo "display:block;";
} else {
    echo "display:none;";
} ?>">


    <fieldset>

        <legend>Gateway Mode</legend>

        <div class="pad24t">


            <div class="field">

                <label class="less">Primary</label>

                <div class="field_entry_less">

                    <input type="radio" name="primary" value="1" <?php if ($data->{'final_content'}['primary'] == '1') {
                        echo "checked=\"checked\"";
                    } ?> /> Primary <input type="radio" name="primary"
                                           value="0" <?php if ($data->{'final_content'}['primary'] != '1') {
                        echo "checked=\"checked\"";
                    } ?> /> Secondary

                    <p class="field_desc_radio">Your primary gateway is what the program defaults to for all
                        transactions unless that primary gateway doesn't have a method available.</p>

                </div>

            </div>


            <div class="field">

                <label class="less">Mode</label>

                <div class="field_entry_less">

                    <input type="radio" name="test_mode"
                           value="0" <?php if ($data->{'final_content'}['test_mode'] != '1') {
                        echo "checked=\"checked\"";
                    } ?> /> Live <input type="radio" name="test_mode"
                                        value="1" <?php if ($data->{'final_content'}['test_mode'] == '1') {
                        echo "checked=\"checked\"";
                    } ?> /> Test Mode

                </div>

            </div>


        </div>

    </fieldset>


    <fieldset>

        <legend>Gateway Credentials</legend>

        <div class="pad24t">


            <p>Please reference the Zenbership online documentation for information on which credentials are required
                for this gateway.</p>


            <div class="field">

                <label>Credential 1</label>

                <div class="field_entry">

                    <input type="text" id="credential1" name="credential1"
                           value="<?php echo $data->{'final_content'}['credential1']; ?>" style="width:250px;"/>

                </div>

            </div>


            <div class="field">

                <label>Credential 2</label>

                <div class="field_entry">

                    <input type="text" id="credential2" name="credential2"
                           value="<?php echo $data->{'final_content'}['credential2']; ?>" style="width:250px;"/>

                </div>

            </div>


            <div class="field">

                <label>Credential 3</label>

                <div class="field_entry">

                    <input type="text" id="credential3" name="credential3"
                           value="<?php echo $data->{'final_content'}['credential3']; ?>" style="width:250px;"/>

                </div>

            </div>


        </div>

    </fieldset>



    <?php





    if ($pci_compliance == '1') {
        ?>

        <fieldset>

            <legend>PCI Compliance Agreement</legend>

            <div class="pad24t">


                <p><b><input type="checkbox" name="agree" value="1"/> My company is PCI Compliant and agree with the
                        following terms.</b></p>

                <p>By using this payment gateway, I understand that I alone am responsible for ensuring that my company
                    meets all PCI Compliance regulations as set forth by the <a
                        href="https://www.pcisecuritystandards.org/" target="_blank">PCI Security Standards Council</a>.
                    Castlamp is not responsible or liable for any damages resulting from a failure to comply with
                    these standards.</p>


            </div>

        </fieldset>

    <?php

    } else {
        echo "<input type=\"hidden\" name=\"agree\" value=\"1\" />";

    }

    ?>

</div>


</div>


</form>