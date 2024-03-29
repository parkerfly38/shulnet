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


$cart = new cart();

if (!empty($_POST['id'])) {
    $package = $cart->get_package($_POST['id']);
    $cid     = $_POST['id'];
    $editing = '1';

} else {
    $package = array(
        'name'             => '',
        'prorate_upgrades' => '1',
        'items'            => array()
    );
    $cid     = 'new';
    $editing = '0';

}



?>





<link type="text/css" rel="stylesheet" media="all" href="css/fields_sortable.css"/>

<script src="js/form_rotator.js" type="text/javascript"></script>


<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('package-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('package-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">


    <div id="popupsave">

        <input type="submit" value="Save" class="save"/>

    </div>

    <h1>Package</h1>


    <ul id="theStepList">

        <li class="on" onclick="return goToStep('0');">Overview</li>

        <li onclick="return goToStep('1');">Products</li>

    </ul>


    <div class="pad24t popupbody">


        <ul id="formlist">

            <li class="form_step">


                <fieldset>

                    <legend>Overview</legend>

                    <div class="pad24t">

                        <label>Name</label>
                        <?php
                        echo $af->string('name', $package['name'], 'req');
                        ?>


                        <div class="field">

                            <label>Prorate Upgrades?</label>
                            <?php
                            echo $af
                                ->setDescription('If set to "Yes", the user will be charged at the time of his/her upgrade for the
                                    prorated difference.')
                                ->radio('prorate_upgrades', $package['prorate_upgrades'], array(
                                '1' => 'Yes',
                                '0' => 'No',
                            ));
                            ?>


                        </div>


                    </div>

                </fieldset>


            </li>

            <li class="form_step">


                <?php

                if (!empty($cid) && $cid != 'new') {
                    ?>

                    <fieldset>

                        <legend>Add Another Product</legend>

                        <div class="pad24t">

                            <select id="add_product" style="width:100%;">

                                <option value=""></option>

                                <?php

                                $list = $admin->product_list('', '1');

                                echo $list;

                                ?>

                            </select>

                        </div>

                    </fieldset>

<script type="text/javascript">
    $(function() {
        $( "#prod_list" ).sortable({
            placeholder: "ui-state-highlight"
        });
    });
</script>

                    <fieldset>
                        <legend>Products in Package</legend>
                        <div class="pad24t">
                            <ul id="prod_list" class="colfields ui-sortable">
                                <?php
                                $cur = 0;
                                foreach ($package['items'] as $item) {
                                    $cur++;
                                    echo "
                                <li id=\"td-cell-" . $item['id'] . "\">
                                    <div style=\"float:right;\">
                                        <img src=\"imgs/icon-delete.png\" width=\"16\" height=\"16\" border=\"0\" onclick=\"return delete_item('ppSD_products_linked','" . $item['id'] . "','','0','0');\" class=\"icon hover\" alt=\"Delete\" title=\"Delete\" />
                                    </div>
                                    " . $item['name'] . " (" . $item['format_price'] . ")
                                    <input type=\"hidden\" name=\"product[" . $cur . "][id]\" value=\"" . $item['id'] . "\" />
                                </li>
                                ";
                                }
                                ?>
                            </ul>
                        </div>
                    </fieldset>



                <?php

                } else {
                    echo "<p>You can add products once you save your new package.</p>";

                }

                ?>


            </li>

        </ul>


    </div>


    <script type="text/javascript">


        // function json_add(page_target, id, editing, form_id, passfields, skip_form_check)
        $('#add_product').change(function () {
            value = $('#add_product').val();
            return json_add('package_item-add', '<?php echo $cid; ?>', '1', 'skip', 'product_id=' + value, '1');
            // add_product_to_package(value);
        });


    </script>