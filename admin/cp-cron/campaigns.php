<?php
$date = explode(' ', current_date());
$q1   = $db->run_query("
    SELECT
      ppSD_campaign_items.id,
      ppSD_campaign_items.campaign_id,
      ppSD_campaigns.criteria_id,
      ppSD_campaigns.when_type,
      ppSD_campaigns.user_type,
      ppSD_campaigns.name,
      ppSD_campaigns.type
    FROM
      `ppSD_campaign_items`
    JOIN
      `ppSD_campaigns`
    ON
      ppSD_campaigns.id=ppSD_campaign_items.campaign_id
    WHERE
      ppSD_campaigns.status='1' AND
      ppSD_campaigns.optin_type='criteria'
");

while ($row = $q1->fetch()) {

    // ----------------------------
    //   Load campaign functions,
    //   Load the message,
    //   And prepare for sending.
    $campaign = new campaign($row['campaign_id']);
    $msg_data = $campaign->get_msg($row['id']);

    $connect  = new connect($msg_data['data']['msg_id']); // Load the email
    // ----------------------------
    //   Get criteria and build the query.
    $criteria   = new criteria($row['criteria_id'], true);

    if ($criteria->error) {
        $cronObject->alert('ShulNET could not send a campaign! The criteria that was set up for campaign "' . $row['name'] . '" has been deleted or cannot be found.');
        continue;
    }

    if (strpos($criteria->query, 'ppSD_accounts') !== false) {
        $cronObject->alert('ShulNET could not send a campaign! The criteria that was set up for campaign "' . $row['name'] . '" has is for accounts, not members or contacts.');
        continue;
    }

    try {
        $applicable = $db->run_query($criteria->query);
    } catch (Exception $e) {
        $cronObject->alert('Criteria for campaign "' . $row['name'] . '" failed: ' . $e->getMessage());
        echo "<li>SKIPPING: " . $row['name'] . ' / ' . $e->getMessage();
        continue;
    }


    // ----------------------------
    //   "after_join" campaigns
    if ($row['when_type'] == 'after_join') {
        // Loop possible users.
        try {
            while ($user = $applicable->fetch()) {

                if ($row['user_type'] == 'member') {
                    $use_date = $user['joined'];
                } else {
                    $use_date = $user['created'];
                }

                $dif = explode(' ', add_time_to_expires($msg_data['data']['when_timeframe'], $use_date));

                // Correct date: proceed.
                if ($dif['0'] == $date['0']) {
                    $check_log = $campaign->check_log($user['id'], $row['user_type'], $row['id']);
                    $unsubscription = $campaign->find_unsubscription($user['id'], $row['user_type']);
                    if ($unsubscription['unsubscribed'] != '1' && $check_log <= 0) {
                        // Queue email for sending...
                        if ($row['type'] == 'email') {
                            $add = $connect->queue_email($user['id'], $row['user_type'], '0');
                            $add_log = $campaign->add_log($user['id'], $row['user_type'], $row['id']);
                        }
                    }
                } else {
                    continue;
                }

            }
        } catch (Exception $e) {
            $cronObject->alert('Failed to run criteria: ' . $e->getMessage());
            echo "<li>SKIPPING: " . $row['name'] . ' / ' . $e->getMessage();
            continue;
        }

    } // ----------------------------
    //   "exact_date" campaigns
    else if ($row['when_type'] == 'exact_date') {
        // Only send on correct date
        $bdate = explode(' ', $msg_data['data']['when_date']);
        if ($bdate['0'] == $date['0']) {
            // Loop possible users.
            try {
                while ($user = $applicable->fetch()) {
                    $check_log = $campaign->check_log($user['id'], $row['user_type'], $row['id']);
                    $unsubscription = $campaign->find_unsubscription($user['id'], $row['user_type']);
                    if ($unsubscription['unsubscribed'] != '1' && $check_log <= 0) {
                        // Queue email for sending...
                        if ($row['type'] == 'email') {
                            $add = $connect->queue_email($user['id'], $row['user_type'], '0');
                            $add_log = $campaign->add_log($user['id'], $row['user_type'], $row['id']);
                        }

                    }

                }
            } catch (Exception $e) {
                $cronObject->alert('Failed to run criteria: ' . $e->getMessage());
                echo "<li>SKIPPING: " . $row['name'] . ' / ' . $e->getMessage();
                continue;
            }

        }

    }

}