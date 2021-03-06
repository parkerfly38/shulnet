<?php

/**
 * SUBSCRIPTION RENEWALS
 * This file is part of a cron job (index.php)
 * All necessary classes have been pre-loaded.
 */
$sub = new subscription;
$cart = new cart;

$subscription_retries = $db->get_option('subscription_retries');

if (empty($subscription_retries) || ! is_numeric($subscription_retries)) {
    $subscription_retries = 3;
}

$q1S = $db->run_query("
    SELECT `id`,`retry`
    FROM `ppSD_subscriptions`
    WHERE
      `status`='1' AND
      `next_renew`<='" . current_date() . "'
");
while ($row = $q1S->fetch()) {
    if ($row['retry'] >= $subscription_retries) {
        $er           = $db->get_error('S040');
        $er = str_replace('%retry%', $row['retry'], $er);
        $sub->cancel_subscription($row['id'], $er);
    } else {
        $sub->renew_subscription($row['id'], '1');
    }
}

// Notify upcoming subscriptions
$sub->notifyUpcoming();


// --------------------------------------------------
// Expiring Credit Cards

$expiringCreditCards = $db->get_option('cc_expiring_notify');

$contact = new contact;

if ($expiringCreditCards == '1') {
    // 04 -> 05
    $time = strtotime("+1 month", time());
    $nextMonth = date("m", $time);
    $nextYear = date("y", $time);

    $cards = $db->run_query("
        SELECT *
        FROM ppSD_cart_billing
        WHERE
            `notice_sent` IS NULL
    ");
    while ($row = $cards->fetch()) {
        $thisCard = $cart->decode_card($row);

        /*
        $find = $db->get_array("
            SELECT `id`
            FROM ppSD_subscriptions
            WHERE `card_id`='" . $db->mysql_clean($row['id']) . "'
            LIMIT 1
        ");
        */

        if ($thisCard['card_exp_yy'] == $nextYear && $thisCard['card_exp_mm'] == $nextMonth) {

            // Send the email
            $changes = $thisCard;
            $findContact = $contact->get_contact($thisCard['member_id']);
            if (! empty($findContact['data']['id'])) {
                $force_member_type = 'contact';
            } else {
                $force_member_type = 'member';
            }
            $email = new email('', $thisCard['member_id'], $force_member_type, '', $changes, 'cart_credit_card_expiring');

            // Update the database.
            $up = $db->update("
                UPDATE ppSD_cart_billing
                SET `notice_sent`='1'
                WHERE `id`='" . $db->mysql_clean($row['id']) . "'
                LIMIT 1
            ");
        }

    }

}
