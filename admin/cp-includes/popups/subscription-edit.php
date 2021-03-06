<?php


if (!empty($_POST['id'])) {
    $subscription = new subscription;
    $data         = $subscription->get_subscription($_POST['id']);
    $editing      = '1';
    $cid          = $_POST['id'];
    $datein       = explode(' ', $data['data']['next_renew']);
    $date         = $datein['0'];
    //$cart = new cart;
    //$prod = $cart->get_product($data['data']['product']);
    $product_id = $data['product']['id'];
    $product    = $data['product']['name'];
    if ($data['data']['member_type'] == 'member') {
        $user    = new user;
        $usedata = $user->get_user($data['data']['member_id']);
        if (!empty($usedata['data']['username'])) {
            $username = $usedata['data']['username'];

        } else {
            $username = 'N/A';

        }
        $user_id   = $data['data']['member_id'];
        $user_type = 'Member';

    } else {
        $contact   = new contact;
        $usedata   = $contact->get_contact($data['data']['member_id']);
        $username  = $usedata['data']['first_name'] . ' ' . $usedata['data']['last_name'];
        $user_id   = $data['data']['member_id'];
        $user_type = 'Non-member';

    }
    $price = $data['data']['price'];

}

?>



<script type="text/javascript">

    $.ctrl('S', function () {
        return json_add('subscription-add', '<?php echo $cid; ?>', '1', 'popupform');
    });

</script>


<form action="" method="post" id="popupform"
      onsubmit="return json_add('subscription-add','<?php echo $cid; ?>','1','popupform');">


    <div id="popupsave">

        <input type="submit" value="Save" class="save"/>

        <input type="hidden" name="id" value="<?php echo $cid; ?>"/>

    </div>

    <h1>Editing Subscription</h1>


    <div class="pad24t popupbody">


        <fieldset>

            <legend>Overview</legend>

            <div class="pad24">


                <?php

                if ($data['data']['retry'] > 0) {
                    echo "<p class=\"highlight\">This subscription has failed to renew " . $data['data']['retry'] . " time(s).</p>";

                }

                ?>



                <dl>

                    <dt>User</dt>

                    <dd><?php echo $username; ?></dd>

                    <dt>User type</dt>

                    <dd><?php echo $user_type; ?></dd>

                    <dt>Product</dt>

                    <dd><?php echo $data['product']['name']; ?></dd>

                    <dt>Status</dt>

                    <dd><?php echo $data['data']['show_status']; ?></dd>

                    <dt>Renews</dt>

                    <dd><?php if (!empty($data['data']['format_timeframe'])) {
                            echo $data['data']['format_timeframe'];
                        } else {
                            echo 'N/A';
                        } ?></dd>

                    <dt>Started</dt>

                    <dd><?php echo $data['data']['started']; ?></dd>

                    <dt>Remaining Charges</dt>

                    <dd><?php

                        if ($data['data']['in_trial'] == '1') {
                            echo $data['data']['trial_charges_remaining'];

                        } else {
                            echo $data['data']['remaining_charges'];

                        }

                        ?></dd>

                    <dt>Gateway</dt>

                    <dd><?php echo $data['data']['gateway']; ?></dd>

                </dl>

                <div class="clear"></div>


            </div>

        </fieldset>


        <fieldset>

            <legend>Settings</legend>

            <div class="pad24">


                <div class="field">

                    <label>Next Renewal</label>

                    <div class="field_entry">

                        <?php

                        echo $af
                            ->setSpecialType('date')
                            ->setDescription('Setting this to today\'s date will charge the user the next time the cron
                            job runs.')
                            ->setValue($date)
                            ->string('sub[next_renew]');

                        //echo $admin->datepicker('sub[next_renew]', $date, '0', '250', '', '', '1');

                        ?>

                        <!--<p class="field_desc">Setting this to today's date will charge the user the next time the cron
                            job runs.</p>-->

                    </div>

                </div>


                <div class="field">

                    <label>Price</label>

                    <div class="field_entry">

                        <?php





                        echo place_currency('<input type="text" name="sub[price]" value="' . $price . '" maxlength="12" style="width:125px;" />', '1');

                        ?>

                        <p class="field_desc">Leave blank to use the standard product price. Setting this to any value
                            will automatically override any trial period and pricing associated with the product.</p>

                    </div>

                </div>


            </div>

        </fieldset>


    </div>


</form>