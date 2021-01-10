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


if (empty($_POST['event'])) {
    $admin->show_popup_error('No event ID submitted.');
    exit;

} else {
    $event = new event;
    $data  = $event->get_event($_POST['event']);

}


$editing = '0';

$cid = generate_id($db->get_option('rsvp_ticket_format'));


$form_id = 'event-' . $_POST['event'] . '-2';


$field = new field('fields');

$form = $field->generate_form($form_id, '', '1');



?>



<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('rsvp-add', '<?php echo $cid; ?>', '<?php echo $editing; ?>');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('rsvp-add','<?php echo $cid; ?>','<?php echo $editing; ?>');">


<div id="popupsave">

    <input type="submit" value="Save" class="save"/>

    <input type="hidden" name="id" value="<?php echo $cid; ?>"/>

    <input type="hidden" name="event_id" value="<?php echo $_POST['event']; ?>"/>

</div>

<h1>Event Attendee</h1>


<ul id="theStepList">

    <li class="on" onclick="return goToStep('0');">Overview</li>

    <li onclick="return goToStep('1');">Registrant Details</li>

    <li onclick="return goToStep('2');">Guests</li>

</ul>


<div class="pad24t popupbody">


<ul id="formlist">

<li class="form_step">


<fieldset>

    <legend>Overview</legend>

    <div class="pad24">


        <div class="field">

            <label class="">Status</label>

            <div class="field_entry">

                <input type="radio" name="status" value="0" checked="checked"
                       onclick="return swap_multi_div('products,unpaid','orderid');"/> Create Order<br/>

                <input type="radio" name="status" value="1"
                       onclick="return swap_multi_div('orderid','unpaid,products,invoice_user,pay_card');"/> Order
                Already Complete

            </div>

        </div>


        <div class="field" id="orderid" style="display:none;">

            <label class="">Order ID</label>

            <div class="field_entry">

                <input type="text" id="order_id" value="" name="order_id_dud"
                       autocomplete="off" onkeyup="return autocom(this.id,'id','id','ppSD_cart_sessions','id','');"
                       style="width:250px;"/></a>

                <input type="hidden" name="order_id" id="order_id_id" value=""/>

                <p class="field_desc" id="source_dud_dets">Type and select the order ID, if any, of the order associated
                    with this registration.</p>

            </div>

        </div>


        <div class="field" id="unpaid" style="display:block;">

            <label class="">Charge Type</label>

            <div class="field_entry">

                <!--<input type="radio" name="payment_type" value="1" checked="checked" onclick="hide_div('invoice_user');hide_div('pay_card');" /> No charge required: create order in database but do not charge or invoice the user<br />-->

                <input type="radio" name="payment_type" value="1" onclick="return swap_div('pay_card','invoice_user');"
                       checked="checked"/> Process Order Now<br/>

                <input type="radio" name="payment_type" value="2"
                       onclick="return swap_div('invoice_user','pay_card');"/> Invoice User<br/>

            </div>

        </div>


        <div id="existing_member">

            <div class="field">

                <label class="">Member</label>

                <div class="field_entry">

                    <input type="text" value="" name="username_dud" id="usernamed"
                           autocomplete="off" onkeyup="return autocom(this.id,'id','username','ppSD_members','username','members');"
                           style="width:200px;"/> <a href="null.php" onclick="return get_list('member','usernamed_id','usernamed');"><img src="imgs/icon-list.png" width="16" height="16" border="0" alt="Select from list" title="Select from list" class="icon-right"/></a>

                    <input type="hidden" name="user_id" id="usernamed_id" value=""/>

                    <p class="field_desc" id="usernamed_id_dets">If you want to assign this registration to a member,
                        select the username from the list above.</p>

                </div>

            </div>

        </div>


    </div>

</fieldset>


<fieldset id="products">

    <table cellspacing="0" cellpadding="0" border="0" width="100%" class="listings">
        <thead>
        <tr>
            <th>Product</th>
            <th width="120">Cost</th>
            <th width="80">Qty</th>
        </tr>
        </thead><?php


        $up = 0;

        foreach ($data['products']['tickets'] as $item) {
            $up++;
            echo '<tr id="ticket_opt-' . $up . '">';
            echo '<td valign="top">' . $item['data']['name'] . '</td>';
            echo '<td valign="top">' . place_currency($item['data']['price']) . '</td>';
            echo '<td valign="top"><input type="text" value="0" onblur="return uptotal(this.value,\'' . $item['data']['price'] . '\');" name="product[' . $item['data']['id'] . ']" style="width:80px;" /></td>';
            echo '</tr>';

        }

        foreach ($data['products']['member_only'] as $item) {
            $up++;
            echo '<tr id="ticket_opt-' . $up . '">';
            echo '<td valign="top">' . $item['data']['name'] . '</td>';
            echo '<td valign="top">' . place_currency($item['data']['price']) . '</td>';
            echo '<td valign="top"><input type="text" value="0" onblur="return uptotal(this.value,\'' . $item['data']['price'] . '\');" name="product[' . $item['data']['id'] . ']" style="width:80px;" /></td>';
            echo '</tr>';

        }

        foreach ($data['products']['guests'] as $item) {
            $up++;
            echo '<tr id="ticket_opt-' . $up . '">';
            echo '<td valign="top">' . $item['data']['name'] . '</td>';
            echo '<td valign="top">' . place_currency($item['data']['price']) . '</td>';
            echo '<td valign="top"><input type="text" value="0" onblur="return uptotal(this.value,\'' . $item['data']['price'] . '\');" name="product[' . $item['data']['id'] . ']" style="width:80px;" /></td>';
            echo '</tr>';

        }

        foreach ($data['products']['early_bird'] as $item) {
            $up++;
            echo '<tr id="ticket_opt-' . $up . '">';
            echo '<td valign="top">' . $item['data']['name'] . '</td>';
            echo '<td valign="top">' . place_currency($item['data']['price']) . '</td>';
            echo '<td valign="top"><input type="text" value="0" onblur="return uptotal(this.value,\'' . $item['data']['price'] . '\');" name="product[' . $item['data']['id'] . ']" style="width:80px;" /></td>';
            echo '</tr>';

        }

        foreach ($data['products']['other'] as $item) {
            $up++;
            echo '<tr id="ticket_opt-' . $up . '">';
            echo '<td valign="top">' . $item['data']['name'] . '</td>';
            echo '<td valign="top">' . place_currency($item['data']['price']) . '</td>';
            echo '<td valign="top"><input type="text" value="0" onblur="return uptotal(this.value,\'' . $item['data']['price'] . '\');" name="product[' . $item['data']['id'] . ']" style="width:80px;" /></td>';
            echo '</tr>';

        }



        ?>

        <tr>

            <td colspan="2">&nbsp;</td>

            <td><?php echo place_currency('<span id="calc_total" class="larger">0.00</span>', '1') ?></td>

        </tr>
    </table>

</fieldset>


<fieldset id="pay_card" style="display:block;">
<legend>Order Details</legend>
<div class="pad24">

    <div class="field">
        <label>Type</label>
        <div class="field_entry">
            <input type="radio" name="card_type" value="no_card" checked="checked"/> Don't charge a card: just add the
            order<br/>
            <input type="radio" name="card_type" value="new_card"/> Charge a new card.<br/>
            <input type="radio" name="card_type" value="existing_card"/> Charge an existing card.
        </div>
    </div>


    <ul id="existing_card" style="display:none;"></ul>

    <div id="new_card" style="display:none;">

        <div class="field">
            <label>Number</label>
            <div class="field_entry">
                <input type="text" name="cc[cc_number]" style="width:220px;" maxlength="16"/>
            </div>
        </div>

        <div class="field">
            <label>Expires (MM/YY)</label>
            <div class="field_entry">
                <input type="text" name="cc[card_exp_mm]" style="width:80px;" class="zen_num" maxlength="2"/> / <input
                    type="text" name="cc[card_exp_yy]" style="width:80px;" class="zen_num" maxlength="2"/>
            </div>
        </div>


        <div class="field">
            <label>CVV</label>
            <div class="field_entry">
                <input type="text" name="cc[cvv]" style="width:100px;" maxlength="4"/>
            </div>
        </div>


        <div class="field">
            <label>First Name</label>
            <div class="field_entry">
                <input type="text" name="cc[first_name]" style="width:220px;"/>
            </div>
        </div>


        <div class="field">
            <label>Last Name</label>
            <div class="field_entry">
                <input type="text" name="cc[last_name]" style="width:220px;"/>
            </div>
        </div>


        <div class="field">
            <label>Address Line 1</label>
            <div class="field_entry">
                <input type="text" name="cc[address_line_1]" style="width:220px;"/>
            </div>
        </div>


        <div class="field">
            <label>Address Line 2</label>
            <div class="field_entry">
                <input type="text" name="cc[address_line_2]" style="width:200px;"/>
            </div>
        </div>


        <div class="field">
            <label>City</label>
            <div class="field_entry">
                <input type="text" name="cc[city]" style="width:220px;"/>
            </div>
        </div>


        <div class="field">
            <label>State</label>
            <div class="field_entry">
                <select name="cc[state]" style="width:220px;">
                    <?php
                    $fields = new field;
                    echo $fields->state_list('', '1', 'select');
                    ?>
                </select>
            </div>
        </div>


        <div class="field">
            <label>Zip</label>
            <div class="field_entry">
                <input type="text" name="cc[zip]" style="width:100px;" maxlength="6"/>
            </div>
        </div>


        <div class="field">
            <label>Country</label>
            <div class="field_entry">
                <select name="cc[country]" style="width:220px;">
                    <?php
                    $fields = new field;
                    echo $fields->country_list('', '1', 'select');
                    ?>
                </select>
            </div>
        </div>


    </div>

</fieldset>


<fieldset id="invoice_user" style="display:none;">

    <legend>Invoice Details</legend>

    <div class="pad24">

        <div class="field">
            <label class="">Company</label>
            <div class="field_entry">
                <input type="text" name="invoice[company_name]" style="width:220px;"/>
            </div>
        </div>

        <div class="field">
            <label class="">Contact Name</label>
            <div class="field_entry">
                <input type="text" name="invoice[contact_name]" style="width:220px;"/>
            </div>
        </div>


        <div class="field">
            <label class="">E-Mail</label>
            <div class="field_entry">
                <input type="text" name="invoice[email]" style="width:220px;"/>
            </div>
        </div>

        <div class="field">
            <label>Address Line 1</label>
            <div class="field_entry">
                <input type="text" name="invoice[address_line_1]" style="width:220px;"/>
            </div>
        </div>


        <div class="field">

            <label>Address Line 2</label>

            <div class="field_entry">

                <input type="text" name="invoice[address_line_2]" style="width:200px;"/>

            </div>

        </div>


        <div class="field">

            <label>City</label>

            <div class="field_entry">

                <input type="text" name="invoice[city]" style="width:220px;"/>

            </div>

        </div>


        <div class="field">

            <label>State</label>

            <div class="field_entry">

                <select name="invoice[state]" style="width:220px;">

                    <?php





                    $fields = new field;

                    echo $fields->state_list('', '1', 'select');

                    ?>

                </select>

            </div>

        </div>


        <div class="field">

            <label>Zip</label>

            <div class="field_entry">

                <input type="text" name="invoice[zip]" style="width:100px;" maxlength="6"/>

            </div>

        </div>


        <div class="field">

            <label>Country</label>

            <div class="field_entry">

                <select name="invoice[country]" style="width:220px;">

                    <?php





                    $fields = new field;

                    echo $fields->country_list('', '1', 'select');

                    ?>

                </select>

            </div>

        </div>


        <div class="field">

            <label class="">Phone</label>

            <div class="field_entry">

                <input type="text" name="invoice[phone]" style="width:220px;"/>

            </div>

        </div>


        <div class="field">

            <label class="top">Memo</label>

            <div class="field_entry_top">

                <textarea name="invoice[memo]" style="width:100%;height:150px;"></textarea>

            </div>

        </div>


    </div>

</fieldset>


</li>

<li class="form_step">


    <?php





    echo $form;

    ?>


</li>

<li class="form_step">


    <?php





    if ($data['data']['allow_guests'] == '1') {
        echo "<input type=\"hidden\" id=\"guests\" name=\"guests\" value=\"0\" /><div class=\"highlight center\"><a href=\"#\" onclick=\"return add_guest();\">Add a Guest [+]</a></div>";
        echo "<div id=\"append_guests\"></div>";

    }

    ?>


</li>

</ul>


</div>


</form>


<script type="text/javascript">


    var cur_guest = 0;
    var cur_total = 0;
    function add_guest() {
        show_loading();
        cur_guest++;
        send_data = 'action=gen_form&type=guest&event_id=<?php echo $_POST['event']; ?>&current=' + cur_guest;
        $.post('cp-functions/event_addition.php', send_data, function (theResponse) {
            if (debug == 1) {
                console.log(theResponse);
            }
            $('#append_guests').append(theResponse);
            $('#guests').val(cur_guest);
            close_loading();
        });
        return false;
    }
    function uptotal(qty, price) {
        cur_total = cur_total + (qty * price);
        $('#calc_total').html(cur_total);
    }
    $("input[name=card_type]").live("change", function () {
        var val = $('input[name=card_type]:checked', '#popupform').val();
        if (val == 'existing_card') {
            if (!$('#usernamed_id').val()) {
                handle_error('Select a member to use an existing credit card.');
            } else {
                show_loading();
                send_data = 'id=' + $('#usernamed_id').val();
                $.post('cp-functions/find_credit_card.php', send_data, function (theResponse) {
                    $('#existing_card').html(theResponse);
                    $('#new_card').hide();
                    $('#existing_card').show();
                    $('#no_card').hide();
                    close_loading();
                });
                return false;
            }
        }
        else if (val == 'new_card') {
            $('#new_card').show();
            $('#existing_card').hide();
            $('#no_card').hide();
        }
        else {
            $('#new_card').hide();
            $('#existing_card').hide();
            $('#no_card').show();
        }
    });

</script>


<script src="js/form_rotator.js" type="text/javascript"></script>