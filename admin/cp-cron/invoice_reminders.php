<?php


$notes = new notes();

$reminder_pre  = $db->get_option('invoice_reminder_pre');
$reminder_post = $db->get_option('invoice_reminder_post');

if (empty($reminder_pre) && empty($reminder_post)) {

    // Reminders are not active.
} else {
    $invoice = new invoice;
    // Not-overdue reminders
    $pre_date = add_time_to_expires($reminder_pre);
    //$days = 86400 * substr($reminder_pre,4,2);
    //$pre_date = date('Y-m-d H:i:s',strtotime(current_date()) - $days);
    // Overdue reminders
    $post_date = add_time_to_expires($reminder_post);
    $STH       = $db->run_query("
        SELECT *
        FROM `ppSD_invoices`
        WHERE `status`!='1' AND `quote`!='1'
    ");
    while ($row = $STH->fetch()) {

        // Remind to pay before due date
        if (current_date() < $row['date_due'] && !empty($reminder_pre)) {
            $days     = 86400 * substr($reminder_pre, 4, 2);
            $pre_date = date('Y-m-d H:i:s', strtotime($row['date_due']) - $days);

            if ($pre_date <= current_date() && $row['last_reminder'] == '1920-01-01 00:01:01') {
                $data = $invoice->send_invoice($row['id'], '3');

                // Update "Last Reminder"
                $q1 = $db->update("
                    UPDATE
                        `ppSD_invoices`
                    SET
                        `last_reminder`='" . current_date() . "'
                    WHERE
                        `id`='" . $db->mysql_clean($row['id']) . "'
                    LIMIT 1
                ");

                $addNote = $notes->add_note(array(
                    'user_id' => $row['id'],
                    'item_scope' => 'invoice',
                    'name' => 'Reminder to pay sent',
                    'note' => 'User was sent a reminder to pay the invoice.',
                ));
            }
        }

        // Overdue notices after due date
        if (current_date() >= $row['date_due'] && !empty($reminder_post)) {
            // Get the right date to check
            if ($row['last_reminder'] != '1920-01-01 00:01:01') {
                $use_date = $row['last_reminder'];
            } else {
                $use_date = $row['date_due'];
            }
            // Calculate proper information.
            $days      = 86400 * substr($reminder_post, 4, 2);
            $post_date = date('Y-m-d H:i:s', strtotime($use_date) + $days);
            if (current_date() >= $post_date) {
                // Send reminder
                if ($row['total_reminders'] < $db->get_option('invoice_max_reminders')) {
                    // Send the notice
                    $data = $invoice->send_invoice($row['id'], '4');
                    // Update the database of reminders
                    $q1 = $db->update("
                        UPDATE `ppSD_invoices`
                        SET
                            `last_reminder`='" . current_date() . "',
                            `total_reminders`=(`total_reminders`+1),
                            `status`='3'
                        WHERE `id`='" . $db->mysql_clean($row['id']) . "'
                        LIMIT 1
                    ");

                    $next = $row['total_reminders'] + 1;

                    $addNote = $notes->add_note(array(
                        'user_id' => $row['id'],
                        'item_scope' => 'invoice',
                        'name' => 'Overdue invoice reminder #' . $next . ' sent.',
                        'note' => 'The invoice is overdue - the user was informed about this via email.',
                    ));
                } // Mark as overdue
                else {
                    $q1 = $db->update("
                        UPDATE `ppSD_invoices`
                        SET `status`='4'
                        WHERE `id`='" . $db->mysql_clean($row['id']) . "'
                        LIMIT 1
                    ");

                    $addNote = $notes->add_note(array(
                        'user_id' => $row['id'],
                        'item_scope' => 'invoice',
                        'name' => 'Invoice Marked as dead.',
                        'note' => 'After reminding the user multiple times of an overdue invoice, it was marked as dead.',
                    ));
                }

            }

        }

    }

}