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

$contact = new contact;

$data = $contact->get_contact($_POST['id']);

?>



<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('convert_contact-add', '<?php echo $data['data']['id']; ?>', '1', 'popupformA');
    });

</script>


<form action="" method="post" id="popupformA"
      onsubmit="return json_add('convert_contact-add','<?php echo $data['data']['id']; ?>','1','popupformA');">


<div id="popupsave">

    <input type="submit" value="Save" class="save"/>

</div>

<h1>Contact Conversion</h1>


<div class="popupbody fullForm">

    <p class="highlight">Converting a contact allows you to keep track of expected vs actual values, conversion rates of employees, and optionally create a membership for the contact.</p>

    <div class="col33l">

        <fieldset>
            <div class="pad">
                <label>Who converted this contact?</label>
                <?php
                echo $af->staffList('owner', $data['owner']['id']);
                ?>

                <label>When was the contact converted?</label>
                <?php
                echo $af
                    ->setSpecialType('date')
                    ->string('conversion_date', current_date());
                ?>

                <label>What was the actual monetary value of this conversion? The expected value was originally set at <b><?php echo place_currency($data['data']['expected_value']); ?></b>.</label>
                <?php
                echo $af->radio('dud_type', 'input', array(
                    'input' => 'There was a monetary value for this, which was...',
                    'order_id' => 'Determine value based on a transaction ID.',
                    'none' => 'There was no value for this conversion.',
                ))
                ?>

                <script type="text/javascript">
                    $(document).ready(function() {
                        $("input[type=radio]['data[dud_type]']").change(function() {
                            switch(this.value) {
                                case 'order_id':
                                    return swap_multi_div('show_order','show_input,show_none');
                                case 'input':
                                    return swap_multi_div('show_input','show_order,show_none');
                                case 'none':
                                    return swap_multi_div('show_none','show_input,show_order');
                            }
                        });
                        $("input[type=radio]['data[member_type]']").change(function() {
                            switch(this.value) {
                                case 'new':
                                    return swap_multi_div('member_new_show','member_none,member_id_show');
                                case 'existing':
                                    return swap_multi_div('member_id_show','member_none,member_new_show');
                                case 'none':
                                    return swap_multi_div('member_none','member_new_show,member_id_show');
                            }
                        });
                    });
                </script>


                <div id="show_order" style="display:none;">
                    <img src="imgs/arrow-down.png" class="lookDown" />

                    <label>What is the transaction ID?</label>
                    <?php
                    echo $af->transactionList('order_id', '')
                    ?>

                </div>

                <div id="show_input" style="display:block;">
                    <img src="imgs/arrow-down.png" class="lookDown" />

                    <label>What was the monetary value of the conversion?</label>
                    <?php
                    echo $af
                        ->setRightText(CURRENCY_SYMBOL)
                        ->string('actual_value', $data['data']['expected_value']);
                    ?>

                </div>

                <div id="show_none" style="display:none;">

                </div>


            </div>
        </fieldset>

    </div>
    <div class="col66r">

        <fieldset>
            <div class="pad">

                <label>What action should we take with the contact?</label>
                <?php
                echo $af->radio('member_type', 'new', array(
                    'new' => 'Create a new member from this contact',
                    'existing' => 'Merge this contact with an existing member.',
                    'none' => 'Do not create a new member.',
                ))
                ?>

                <div id="member_none" style="display:none;"></div>

                <div id="member_new_show" style="display:block;">
                    <img src="imgs/arrow-down.png" class="lookDown" />

                    <label>Create a new member below...</label>
                    <?php
                    echo $af->memberForm('', $data['data']);
                    ?>
                </div>

                <div id="member_id_show" style="display:none;">
                    <img src="imgs/arrow-down.png" class="lookDown" />

                    <label>Find the existing member below...</label>
                    <?php
                    echo $af->memberList('user_id');
                    ?>
                </div>

        </fieldset>

    </div>
    <div class="clear"></div>

</div>
</form>