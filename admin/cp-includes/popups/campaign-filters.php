<?php

   

if (!empty($_POST['data'])) {
    $data = unserialize($_POST['data']);
} else {
    $data = array();
}

?>

<form action="" method="post" id="popupform" onsubmit="return apply_filters('subscriptions');">

    <div id="popupsave">
        <input type="submit" value="Save" class="save"/>
        <input type="hidden" value="filter[campaign_id]" class="<?php echo $_POST['campaign_id']; ?>" />
    </div>
    <h1>Apply Filters</h1>

    <div id="pop_inner" class="fullForm popupbody">

        <p class="highlight">Filters allow you to select only specific subscribers for a campaign.</p>

        <fieldset>
            <div class="pad">

                <?php
                $admin = new admin;
                // name:table:date:date_range
                $thefilters = array(
                    'date:ppSD_campaign_subscriptions:1:1',
                    'optin_date:ppSD_campaign_subscriptions:1:1',
                );
                foreach ($thefilters as $aFilter) {
                    $exp = explode(':', $aFilter);
                    if (empty($exp['1'])) {
                        $exp['1'] = 'ppSD_event_rsvps';
                    }
                    if (!empty($data[$exp['0']])) {
                        $value = $data[$exp['0']];
                    } else {
                        $value = '';
                    }

                    ?>
                    <div class="field">
                        <label><?php echo format_db_name($exp['0']); ?></label>

                        <div class="field_entry">
                            <?php

                            if ($exp['2'] == '1') {
                                $date = '1';
                            } else {
                                $date = '0';
                            }
                            if ($exp['3'] == '1') {
                                $dater = '1';
                            } else {
                                $dater = '0';
                            }
                            echo $admin->filter_field($exp['0'], $value, $exp['1'], '1', $date, $dater);
                            if ($dater == '1') {
                                ?>
                                <p class="field_desc_show">Create a date range by inputting two dates, or select a
                                    specific date by only inputting the first field. All dates need to be in the
                                    "YYYY-MM-DD" format.</p>
                            <?php

                            }
                            ?>
                        </div>
                    </div>
                <?php

                }
                ?>

                <div class="field">
                    <label>Subscribed By</label>
                    <div class="field_entry">
                        <input type="radio" name="filter[subscribed_by]" value="" checked="checked" /> --<br/>
                        <input type="radio" name="filter[subscribed_by]" value="condition" /> Form Condition<br/>
                        <input type="radio" name="filter[subscribed_by]" value="criteria" /> Criteria<br/>
                    </div>
                </div>
                <input type="hidden" name="filter_tables[subscribed_by]" value="ppSD_campaign_subscriptions"/>

                <div class="field">
                    <label>Status</label>
                    <div class="field_entry">
                        <input type="radio" name="filter[active]" value="" checked="checked" /> --<br/>
                        <input type="radio" name="filter[active]" value="1" /> Active<br/>
                        <input type="radio" name="filter[active]" value="-" /> Pending<br/>
                    </div>
                </div>
                <input type="hidden" name="filter_tables[active]" value="ppSD_campaign_subscriptions"/>

                <div class="field">
                    <label>User Type</label>
                    <div class="field_entry">
                        <input type="radio" name="filter[user_type]" value="" checked="checked" /> --<br/>
                        <input type="radio" name="filter[user_type]" value="member" /> Member<br/>
                        <input type="radio" name="filter[user_type]" value="contact" /> Contact<br/>
                    </div>
                </div>
                <input type="hidden" name="filter_tables[user_type]" value="ppSD_campaign_subscriptions"/>

            </div>
        </fieldset>

    </div>

</form>