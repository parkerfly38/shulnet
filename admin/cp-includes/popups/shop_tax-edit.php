<?php

if (!empty($_POST['id'])) {
    $cart = new cart;
    $data = $cart->get_tax_class($_POST['id']);
    // $data = new history($_POST['id'],'','','','','','ppSD_cart_terms');
    $cid     = $_POST['id'];
    $editing = '1';

} else {
    $data    = array(
        'state'            => '',
        'country'          => '',
        'percent_physical' => '0.00',
        'percent_digital'  => '0.00',
        'name'             => '',
    );
    $cid     = generate_id('random', '8');
    $editing = '0';

}

?>



<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('shop_tax-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('shop_tax-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">


    <div id="popupsave">

        <input type="submit" value="Save" class="save"/>

    </div>

    <h1>Tax Class</h1>


    <div class="fullForm popupbody">


        <p>Tax classes can be applied to individual products after being created here. Once applied to a product, tax
            will be automatically calculated for a product when a user adds it into his/her shopping cart.</p>


        <fieldset>

            <legend>Basics</legend>

            <div class="pad24t">


                <div class="field">

                    <label>Title</label>

                    <div class="field_entry">

                        <input type="text" value="<?php echo $data['name']; ?>" name="name" id="name"
                               style="width:250px;" class="req"/>

                    </div>

                </div>


            </div>

        </fieldset>


        <fieldset>

            <legend>Tax Rates</legend>

            <div class="pad24t">


                <p>Specify a tax rate for physical (shipped) and digital products.</p>


                <div class="field">

                    <label>Digital Products</label>

                    <div class="field_entry">

                        <input type="text" value="<?php echo $data['percent_physical']; ?>" name="percent_digital"
                               id="percent_digital" style="width:50px;" maxlength="6"/>%

                    </div>

                </div>


                <div class="field">

                    <label>Physical Products</label>

                    <div class="field_entry">

                        <input type="text" value="<?php echo $data['percent_digital']; ?>" name="percent_physical"
                               id="percent_physical" style="width:50px;" maxlength="6"/>%

                    </div>

                </div>


            </div>

        </fieldset>


        <fieldset>

            <legend>Region-Specific</legend>

            <div class="pad24t">


                <p>If you wish to limit this tax class to users who live in a certain region, select the region
                    below.</p>


                <div class="field">

                    <label>Country</label>

                    <div class="field_entry">

                        <?php





                        $field = new field;

                        $rendered = $field->render_field('country', $data['country'], '', '', '', '', 'width:200px;', 'country');

                        echo $rendered['3'];

                        ?>

                    </div>

                </div>


                <div class="field">

                    <label>State</label>

                    <div class="field_entry">

                        <?php





                        $rendered = $field->render_field('state', $data['state'], '', '', '', '', 'width:200px;', 'state');

                        echo $rendered['3'];

                        ?>

                    </div>

                </div>


            </div>

        </fieldset>

    </div>


</form>