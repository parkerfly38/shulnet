<?php

$date  = explode(' ', current_date());
$check = $date['0'];
$event = new event;
$sms   = new sms;
$q     = $db->run_query("
    SELECT
        ppSD_event_reminders.*
    FROM
        `ppSD_event_reminders`
    JOIN
        `ppSD_events`
    ON
        ppSD_event_reminders.event_id=ppSD_events.id
    WHERE
        ppSD_events.status='1' AND
        ppSD_event_reminders.send_date='" . $db->mysql_clean($check) . "' AND
        ppSD_event_reminders.sent_on='1920-01-01'
");
while ($row = $q->fetch()) {

    // Get RSVPS and the event data.
    $rsvps = $event->get_event_rsvps($row['event_id']);
    $edata = $event->get_event($row['event_id']);

    // Determine template.
    if (empty($row['template_id'])) {
        if ($row['when'] == 'before') {
            $template = 'event_reminder';
        } else {
            $template = 'event_followup';
        }
    } else {
        $template = $row['template_id'];
    }

    // Make changes to custom message...
    $hold_msg = $row['custom_message'];
    foreach ($edata['data'] as $item => $value) {
        $hold_msg = str_replace('%event:' . $item . '%', $value, $hold_msg);
    }

    // Email/SMS RSVPs
    foreach ($rsvps as $user) {
        $fail        = '0';
        $fail_reason = '';
        $proceed = false;

        if ($row['when'] == 'before' || ($row['when'] == 'after' && $user['arrived'] == '1')) {
            $proceed = true;
        }

        // Check reminder status
        if ($proceed) {

            $check = $event->check_reminder($row['id'], $user['id']);
            if ($check <= 0) {

                // Update custom message
                foreach ($user as $item => $value) {
                    if (!is_array($value)) {
                        $hold_msg = str_replace('%' . $item . '%', $value, $hold_msg);
                    }
                }

                // SMS or email?
                if ($row['sms'] == '1') {
                    if (!empty($user['cell']) && !empty($user['cell_carrier'])) {
                        $fail = '1';
                        $fail_reason = 'Not enough cell data.';
                    } else if (!empty($user['sms_optout'])) {
                        $fail = '1';
                        $fail_reason = 'SMS Output';
                    } else {
                        $prep = $sms->prep_sms($user['id'], 'rsvp', $hold_msg);
                    }

                } // Email
                else {
                    if (!empty($user['email'])) {
                        $data = array();
                        $changes = $user;
                        $changes['custom_message'] = $hold_msg;
                        $changes['event'] = $edata['data'];
                        $email = new email('', $user['id'], 'rsvp', $data, $changes, $template);
                    } else {
                        $fail = '1';
                        $fail_reason = 'No E-Mail';
                    }
                }

                // ppSD_event_reminder_logs
                $add_log = $event->add_reminder_log($row['event_id'], $user['id'], $row['id'], $fail, $fail_reason);

            }
        }

    }

    // Update the notice status
    $q1 = $db->update("
        UPDATE `ppSD_event_reminders`
        SET `sent_on`='" . current_date() . "'
        WHERE `id`='" . $db->mysql_clean($row['id']) . "'
        LIMIT 1
    ");

}