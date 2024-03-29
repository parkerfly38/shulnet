<?php

$cid = generate_id($db->get_option('order_id_format'));



?>





<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('transaction-add', '<?php echo $cid; ?>', '0', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('transaction-add','<?php echo $cid; ?>','0','popupform');">


<div id="popupsave">

    <input type="submit" value="Save" class="save"/>

</div>

<h1>Add Transaction</h1>


<div class="pad24t popupbody">


<p class="highlight"></p>


<fieldset>

    <legend>Overview</legend>

    <div class="pad24t">


        <div class="col50l">


            <div class="field">

                <label class="less">Order No</label>

                <div class="field_entry_less">

                    <input type="text" value="<?php echo $cid; ?>" class="req" name="order[id]" id="orderid"
                           style="width:200px;" class="req"/>

                </div>

            </div>


            <div class="field">

                <label class="less">Date</label>

                <div class="field_entry_less">

                    <?php
                    //echo $admin->datepicker('order[date]', current_date(), '1', '200px');

                    echo $af
                        ->setSpecialType('datetime')
                        ->setValue(current_date())
                        ->string('order[date]');

                    ?>

                </div>

            </div>


            <div class="field">

                <label class="less">Promo Code</label>

                <div class="field_entry_less">

                    <input type="text" value="" name="coupon_dud" id="coupond"
                           autocomplete="off" onkeyup="return autocom(this.id,'id','id','ppSD_cart_coupon_codes','id','promo_code');"
                           style="width:200px;"/>

                    <input type="hidden" name="order[code]" id="coupond_id" value=""/>

                </div>

            </div>


        </div>

        <div class="col50r">


            <?php
            $member_add = '';
            $contact_add = '';
            $member_username = '';
            $contact_name = '';
            $contact_id = '';
            $member_id = '';
            if (! empty($_POST['uid'])) {
                if ($_POST['utype'] == 'member') {
                    $member_add = $_POST['uid'];
                    $user = new user;
                    $cdata = $user->get_user($_POST['uid']);
                    if (! empty($cdata['data']['id'])) {
                        $member_username = $cdata['data']['username'];
                        $member_id = $_POST['uid'];
                    } else {
                        $default = '1';
                        $member_id = '';
                        $member_username = '';
                    }
                } else {
                    $contact_add = $_POST['uid'];
                    $contact = new contact;
                    $cdata = $contact->get_contact($_POST['uid']);
                    if (! empty($cdata['data']['id'])) {
                        $contact_name = $cdata['data']['last_name'] . ', ' . $cdata['data']['first_name'];
                        $contact_id = $_POST['uid'];
                    } else {
                        $default = '1';
                        $contact_add = '';
                        $contact_id = '';
                    }
                    $member_username = '';
                }
                $default = '0';
            } else {
                $default = '1';
            }
            ?>

            <div class="field">

                <label class="less">Type</label>

                <div class="field_entry_less">

                    <input type="radio" name="member_type" value="member" <?php if ($default == '1' || ! empty($member_add)) { echo " checked=\"checked\""; } ?> /> Existing Member.<br/>

                    <input type="radio" name="member_type" value="new_user" <?php if (! empty($contact_add)) { echo " checked=\"checked\""; } ?> /> New non-member user.<br/>

                </div>

            </div>


            <div id="existing_member">
                <div class="field">
                    <label class="less">Member</label>
                    <div class="field_entry_less">
                        <input type="text" value="<?php echo $member_username; ?>" name="username_dud" id="usernamed"
                               autocomplete="off" onkeyup="return autocom(this.id,'id','username','ppSD_members','username','members');"
                               style="width:200px;"/>
                        <input type="hidden" name="order[member_id]" id="usernamed_id" value="<?php echo $member_id; ?>"/>
                    </div>
                </div>
            </div>


            <div id="new_contact" style="display:none;">


                <div class="field">

                    <label>First Name</label>

                    <div class="field_entry">

                        <input type="text" name="user[first_name]" style="width:250px;"/>

                    </div>

                </div>


                <div class="field">

                    <label>Last Name</label>

                    <div class="field_entry">

                        <input type="text" name="user[last_name]" style="width:250px;"/>

                    </div>

                </div>


                <div class="field">

                    <label>E-Mail</label>

                    <div class="field_entry">

                        <input type="text" name="user[email]" style="width:250px;"/>

                    </div>

                </div>


            </div>


        </div>

        <div class="clear"></div>


    </div>

</fieldset>


<fieldset>

<legend>Run Transaction?</legend>

<div class="pad24t">


<div class="field">

    <label>Type</label>

    <div class="field_entry">

        <input type="radio" name="card_type" value="none" checked="checked"/> Do not charge a card; just add the order
        to the database.<br/>

        <input type="radio" name="card_type" value="existing_card"/> Charge an existing card.<br/>

        <input type="radio" name="card_type" value="new_card"/> Charge a new card.<br/>

    </div>

</div>


<div id="no_card" style="display:block;">


    <div class="col50l">


        <div class="field">

            <label>Gateway</label>

            <div class="field_entry">

                <select name="gateway[id]" style="width:220px;">

                    <option value="">--</option>

                    <?php





                    $cart = new cart;

                    $gateways = $cart->get_gateways();

                    foreach ($gateways as $item) {
                        echo "<option value=\"" . $item['code'] . "\">" . $item['name'] . "</option>";

                    }

                    ?>

                </select>

            </div>

        </div>


    </div>

    <div class="col50r">


        <div class="field">

            <label>Gateway Order No</label>

            <div class="field_entry">

                <input type="text" name="gateway[order_no]" style="width:220px;" maxlength="16"/>

            </div>

        </div>


    </div>

    <div class="clear"></div>


</div>


<ul id="existing_card" style="display:none;"></ul>


<div id="new_card" style="display:none;">


    <div class="col50l">

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


    </div>

    <div class="col50r">


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

    <div class="clear"></div>


</div>


</div>

</fieldset>


<fieldset>

    <legend>Components</legend>

    <div class="pad24t">


        <table cellspacing="0" class="generic" cellpadding="0" border="0" id="components">
            <thead>
            <tr>

                <th>Item</th>

                <th width="150">Unit Price</th>

                <th width="100">Qty</th>

                <th width="16"></th>

            </tr>
            </thead>

            <tbody>


            </tbody>

        </table>


        <p style="text-align:center;"><a href="null.php" onclick="return add_comp_real();">[+] Add Existing Product</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a
                href="null.php" onclick="return add_comp();">[+] Add a Component</a></p>

    </div>

</fieldset>


<fieldset>

    <legend>Shipping Details</legend>

    <div class="pad24t">


        <div class="field">

            <label>Shipping?</label>

            <div class="field_entry">

                <input type="radio" name="ship_yesno" value="0" checked="checked"
                       onclick="return hide_div('shipping_show');"/>
                No shipping required <input type="radio" name="ship_yesno" value="1"
                                            onclick="return show_div('shipping_show');"/> Shipping required

            </div>

        </div>


        <div id="shipping_show" style="display:none;margin-top:12px;">


            <div class="col50l">

                <div class="field">

                    <label>Method</label>

                    <div class="field_entry">

                        <?php





                        $cart = new cart;

                        $opts = $cart->get_flat_shipping('', 'admin');

                        echo $opts;

                        ?>

                    </div>

                </div>


                <div class="field">

                    <label>First Name</label>

                    <div class="field_entry">

                        <input type="text" name="shipping[first_name]" style="width:220px;"/>

                    </div>

                </div>


                <div class="field">

                    <label>Last Name</label>

                    <div class="field_entry">

                        <input type="text" name="shipping[last_name]" style="width:220px;"/>

                    </div>

                </div>


                <div class="field">

                    <label>Address Line 1</label>

                    <div class="field_entry">

                        <input type="text" name="shipping[address_line_1]" style="width:220px;"/>

                    </div>

                </div>


                <div class="field">

                    <label>Address Line 2</label>

                    <div class="field_entry">

                        <input type="text" name="shipping[address_line_2]" style="width:200px;"/>

                    </div>

                </div>

            </div>

            <div class="col50r">


                <div class="field">

                    <label>City</label>

                    <div class="field_entry">

                        <input type="text" name="shipping[city]" style="width:220px;"/>

                    </div>

                </div>


                <div class="field">

                    <label>State</label>

                    <div class="field_entry">

                        <select name="shipping[state]" style="width:220px;">

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

                        <input type="text" name="shipping[zip]" style="width:100px;" maxlength="6"/>

                    </div>

                </div>


                <div class="field">

                    <label>Country</label>

                    <div class="field_entry">

                        <select name="shipping[country]" style="width:220px;">

                            <?php





                            $fields = new field;

                            echo $fields->country_list('', '1', 'select');

                            ?>

                        </select>

                    </div>

                </div>

            </div>

            <div class="clear"></div>


        </div>


    </div>

</fieldset>


<fieldset>

    <legend>Taxes</legend>

    <div class="pad24">


        <div class="field">

            <label>Exempt?</label>

            <div class="field_entry">

                <input type="radio" name="tax_exempt" value="1" checked="checked"
                       onclick="return hide_div('show_tax');"/> Tax Exempt <input type="radio" name="tax_exempt"
                                                                                  value="0"
                                                                                  onclick="return show_div('show_tax');"/>
                Taxable

            </div>

        </div>


        <div id="show_tax" style="display:none;">


            <div class="col50l">


                <div class="field">

                    <label class="less">State</label>

                    <div class="field_entry_less">

                        <select name="order[state]" style="width:220px;">

                            <?php





                            $fields = new field;

                            echo $fields->state_list('', '1', 'select');

                            ?>

                        </select>

                    </div>

                </div>


            </div>

            <div class="col50r">


                <div class="field">

                    <label class="less">Country</label>

                    <div class="field_entry_less">

                        <select name="order[country]" style="width:220px;">

                            <?php





                            $fields = new field;

                            echo $fields->country_list('', '1', 'select');

                            ?>

                        </select>

                    </div>

                </div>


            </div>

            <div class="clear"></div>


        </div>


    </div>

</fieldset>

</div>


</form>


<script type="text/javascript">

    var current_real = 0;
    function add_comp_real() {
        current_real++;
        row = '<tr id="com_option-' + current_real + '">';
        row += '<td><input type="text" name="comps[' + current_real + '][name]" id="productd-' + current_real + '" value="" placeholder="Type existing product name here." style="width:100%;" autocomplete="off" onkeyup="return autocom(this.id,\'id\',\'name\',\'ppSD_products\',\'name\',\'products\');" />';
        row += '<input type="hidden" name="comps[' + current_real + '][id]" id="productd-' + current_real + '_id" value="" /></td>';
        row += '<td>--</td>';
        row += '<td><input type="text" name="comps[' + current_real + '][qty]" value="1" style="width:80px;" /></td>';
        row += '<td><img src="imgs/icon-delete.png" width="16" height="16" border="0" alt="Remove" title="Remove" class="hover" onclick="return remove_comp(\'' + current_real + '\');" /></td>';
        row += '</tr>';
        $('#components').append(row);
        return false;
    }
    function add_comp() {
        current_real++;
        row = '<tr id="com_option-' + current_real + '">';
        row += '<td><input type="text" name="comps[' + current_real + '][name]" value="" placeholder="Type new product name here." style="width:100%;" /><input type="hidden" name="comps[' + current_real + '][id]" value="new" /></td>';
        row += '<td><input type="text" name="comps[' + current_real + '][price]" value="" placeholder="0.00" class="zen_money" style="width:120px;" /></td>';
        row += '<td><input type="text" name="comps[' + current_real + '][qty]" value="1" style="width:80px;" /></td>';
        row += '<td><img src="imgs/icon-delete.png" width="16" height="16" border="0" alt="Remove" title="Remove" class="hover" onclick="return remove_comp(\'' + current_real + '\');" /></td>';
        row += '</tr>';
        $('#components').append(row);
        return false;
    }
    function remove_comp(anOption) {
        $('#com_option-' + anOption).remove();
        return false;
    }
    $("input[name=card_type]").live("change", function () {
        var val = $('input[name=card_type]:checked', '#popupform').val();
        if (val == 'existing_card') {
            if (!$('#usernamed_id').val()) {
                alert('Select a member to use an existing credit card.');
            } else {
                send_data = 'id=' + $('#usernamed_id').val();
                $.post('cp-functions/find_credit_card.php', send_data, function (theResponse) {
                    $('#existing_card').html(theResponse);
                    $('#new_card').hide();
                    $('#existing_card').show();
                    $('#no_card').hide();
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
    $("input[name=member_type]").live("change", function () {
        var val = $('input[name=member_type]:checked', '#popupform').val();
        if (val == 'member') {
            $('#new_contact').hide();
            $('#existing_member').show();
        } else {
            $('#existing_member').hide();
            $('#new_contact').show();
        }
    });

</script>