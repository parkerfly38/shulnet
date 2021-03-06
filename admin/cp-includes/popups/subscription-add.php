<?php


$editing = '0';

$cid = generate_id('random', '22');

$title = "Creating Subscription";

$datein = explode(' ', current_date());

$date = $datein['0'];


if (! empty($_POST['user_id'])) {
    $user = new user;
    $getU = $user->get_user($_POST['user_id']);
    $username = $getU['data']['username'];
    $user_id = $getU['data']['id'];
    $type = 'member';
}
else if (! empty($_POST['contact_id'])) {
    $contact = new contact;
    $getContact = $contact->get_contact($_POST['contact_id']);
    $name = $getContact['data']['first_name'] . ' ' . $getContact['data']['last_name'];
    $user_id = $getcontact['data']['id'];
    $type = 'contact';
}
else {
    $getU = array();
    $username = '';
    $user_id = '';
    $type = 'member';
}

$product = '';

$product_id = '';

$card_id = '';

$price = '';

?>



<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('subscription-add', '<?php echo $cid; ?>', '0', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('subscription-add','<?php echo $cid; ?>','0','popupform');">


<div id="popupsave">

    <input type="submit" value="Save" class="save"/>

    <input type="hidden" name="id" value="<?php echo $cid; ?>"/>

</div>

<h1>Creating Subscription</h1>

<div class="popupbody">

    <script src="<?php echo PP_ADMIN; ?>/js/form_steps.js" type="text/javascript"></script>
    <ul id="step_tabs" class="popup_tabs">
        <li class="on">
            Basics
        </li><li>
            Credit Card
        </li><li>
            Overrides
        </li>
    </ul>

    <div id="step_1" class="step_form fullForm">

    <p class="highlight">Subscriptions allow you to charge a member or contact on a recurring basis.</p>


    <div class="col50l">

        <fieldset>
            <div class="padLeft padTop">

                <label>What product is this subscription for?</label>
                <?php
                echo $af
                    ->setDescription('Selecting a product will assign the content associated with that product to the user when the subscription renews. Important: only members have access to content, so content access does not apply to subscriptions created for contacts.')
                    ->productList('sub[product]', $product, 'req', 'subscriptions');
                ?>

                <label>When should this subscription begin?</label>
                <?php
                echo $af
                    ->setSpecialType('date')
                    ->setDescription('This is the date on which the program will begin charging the user for the subscription.')
                    ->string('sub[next_renew]', $date, 'req');
                ?>

            </div>
        </fieldset>

    </div>
    <div class="col50r">

        <fieldset>
            <div class="padRight padTop">

                <label>Who is this subscription for?</label>
                <?php
                echo $af->radio('member_type', $type, array(
                    'member' => 'An existing member',
                    // 'contact' => 'An existing contact',
                    'new_user' => 'A new member',
                ));
                ?>

                <img src="imgs/arrow-down.png" class="lookDown" />

                <div id="member" style="<?php
                if ($type == 'member' || empty($type)) {
                    echo "display:block;";
                } else {
                    echo "display:none;";
                }
                ?>">
                    <label>Find the member below...</label>
                    <?php
                    echo $af
                        ->setId('username_pick')
                        ->memberList('sub[member_id]', $user_id);
                    ?>
                </div>

                <div id="contact" style="<?php
                if ($type == 'contact') {
                    echo "display:block;";
                } else {
                    echo "display:none;";
                }
                ?>">
                    <label>Find the contact below...</label>
                    <?php
                    echo $af->contactList('sub[contact_id]', $user_id);
                    ?>
                </div>

                <div id="new_contact" style="display:none;">
                    <label>Create a new member below...</label>
                    <?php
                    echo $af->memberForm('user');
                    /*
                    echo $af
                        ->string('user[username]', '', '', 'Username', 'width:50%;');

                    echo $af
                        ->setSpecialType('email')
                        ->string('user[email]', '', '', 'user@emailaddress.com', 'width:50%;');

                    echo $af
                        ->string('user[first_name]', '', '', 'First Name', 'width:50%;');

                    echo $af
                        ->string('user[last_name]', '', '', 'Last Name', 'width:50%;');
                    */
                    ?>
                </div>

            </div>
        </fieldset>

    </div>

    </div>
    <div id="step_2" class="step_form fullForm" style="display:none;">

        <p class="highlight">The user will NOT be charged right away. Instead, the program will naturally charge the user when the automated cron job runs on the "next renewal" date specified above.</p>

        <fieldset>
            <div class="pad">

                <?php
                echo $af->radio('card_type', 'none', array(
                    'none' => 'Do not add a card: user will be invoiced for the subscription',
                    'existing_card' => 'Select an existing credit card',
                    'new_card' => 'Add a new credit card for this subscription',
                ));
                ?>

                <div id="no_card" style="display:block;">

                </div>

                <ul id="existing_card" style="display:none;"></ul>

                <div id="new_card" style="display:none;">
                    <?php
                    echo $af->creditCardForm('cc');
                    ?>
                </div>

                </div>
        </fieldset>

    </div>
    <div id="step_3" class="step_form fullForm">

        <p class="highlight">
            These options are not required but give you more control over the subscription.
        </p>

        <fieldset>
            <div class="pad">

                <label>Would you like to set a custom price for this subscription?</label>
                <?php
                echo
                $af
                    ->setDescription('If you leave this blank, the default price associated with the product selected above will be used.')
                    ->setRightText(CURRENCY_SYMBOL)
                    ->setPlaceholder('150.00')
                    ->string('sub[price]', $price);
                ?>

                <label>Would you like to skip the trial period?</label>
                <?php
                echo $af
                    ->setDescription('This is only applicable if the product has a trial period.')
                    ->radio('skip_trial', '0', array(
                        '1' => 'Skip trial period',
                        '0' => 'Do not skip the trial period.',
                    ));
                ?>

            </div>
        </fieldset>
    </div>

</div>


    <script type="text/javascript">
        $("input[type=radio][name='data[member_type]']").change(function() {
            switch(this.value) {
                case 'member':
                    return swap_multi_div('member','contact,new_contact');
                case 'contact':
                    return swap_multi_div('contact','member,new_contact');
                case 'new_user':
                    return swap_multi_div('new_contact','contact,member');
            }
        });
        $("input[type=radio][name='data[card_type]']").change(function() {
            switch(this.value) {
                case 'existing_card':
                    show_loading();
                    if (! $("#username_pick_id").val()) {
                        handle_error('Select a member first.');
                        return false;
                    } else {
                        send_data = 'id=' + $("#username_pick_id").val();
                        $.post('cp-functions/find_credit_card.php', send_data, function (theResponse) {
                            $('#existing_card').html(theResponse);

                            swap_multi_div('existing_card','new_card,no_card');

                            close_loading();
                        });
                        return false;
                    }
                case 'new_card':
                    return swap_multi_div('new_card','existing_card,no_card');
                case 'none':
                    return swap_multi_div('no_card','new_card,existing_card');
            }
        });
    </script>

</div>
</form>