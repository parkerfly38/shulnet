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
$invoice = new invoice;
if (empty($_POST['invoice_id'])) {
    echo $admin->show_popup_error('No invoice ID submitted.');
} else {

    if (!empty($_POST['id'])) {
        $pay      = $invoice->get_payment($_POST['id']);
        $date     = $pay['date'];
        $paid     = $pay['paid'];
        $order_id = $pay['order_id'];
        $cid      = $_POST['id'];
        $editing  = '1';

    } else {

        $invoice_details = $invoice->get_invoice($_POST['invoice_id']);
        $date     = current_date();
        $paid     = '';
        $order_id = '';
        $cid      = 'new';
        $editing  = '0';
        $paid      = $invoice_details['totals']['due'];
    }

?>





    <script type="text/javascript">

        $.ctrl('S', function () {
            return json_add('invoice_payment-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>', 'popupform');
        });

    </script>



    <form action="" method="post" id="popupform"
          onsubmit="return json_add('invoice_payment-add','<?php echo $cid; ?>','<?php echo $editing; ?>','popupform');">


        <div id="popupsave">

            <input type="submit" value="Save" class="save"/>

            <input type="hidden" name="invoice_id" value="<?php echo $_POST['invoice_id']; ?>"/>

        </div>

        <h1>Payment Made On Invoice</h1>


        <div class="fullForm popupbody">


            <p class="highlight">This feature allows you to add a payment to the invoice history but will not actually
                charge the user.</p>


            <fieldset>

                <legend>Payment Overview</legend>

                <div class="pad24t">


                    <div class="field">

                        <label>Amount</label>

                        <div class="field_entry">

                            <?php





                            echo place_currency('<input type="text" value="' . $paid . '" name="paid" id="paid" style="width:100px;" class="req zen_money" />', '1')

                            ?>

                        </div>

                    </div>


                    <div class="field">

                        <label>Date</label>

                        <div class="field_entry">

                            <?php




                            echo $af
                                ->setSpecialType('datetime')
                                ->setValue($date)
                                ->string('date');

                            //echo $admin->datepicker('date', $date, '1');

                            ?>

                        </div>

                    </div>


                    <div class="field">

                        <label>Reference No.</label>

                        <div class="field_entry">

                            <input type="text" name="order_id" value="<?php echo $order_id; ?>" style="width:200px;"/>

                            <p class="field_desc">Generally an order number or check number.</p>

                        </div>

                    </div>


                </div>

            </fieldset>


        </div>


    </form>



<?php

}

?>