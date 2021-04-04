<?php
$connect          = new connect;
$bounced_inbox    = $db->get_option('bounced_email_inbox');
$bounced_server   = $db->get_option('bounced_smtp_server');
$bounced_username = $db->get_option('bounced_smtp_username');
$bounced_password = $db->get_option('bounced_smtp_password');
$bounced_port     = $db->get_option('bounced_smpt_port');
if (!empty($bounced_inbox) && !empty($bounced_server) && !empty($bounced_username) && !empty($bounced_password)) {
    // Connect to the inbox.
    $inbox = new inbox($bounced_server, $bounced_username, $bounced_password, $bounced_port);
    foreach ($inbox->inbox as $message) {
        $email_id = $connect->email_id_from_headers($message['body']);
        if (!empty($email_id)) {
            // Update bounced
            $q1 = $db->update("
            UPDATE `ppSD_saved_emails`
            SET `fail`='2',`fail_reason`='Bounced'
            WHERE `id`='" . $db->mysql_clean($email_id) . "'
            LIMIT 1
        ");
            // Determine if it is from a campaign
            // and unsubscribe the user if it is
            $data = new history($email_id, '', '', '', '', '', 'ppSD_saved_emails');
            // Stats
            $db->put_stats('bounced_emails');
            // Check if this belongs
            // to a campaign.
            if (!empty($data->final_content['mass_email_id'])) {
                $campaign = new campaign($data->final_content['mass_email_id']);
                $unsub    = $campaign->unsubscribe(
                    $data->final_content['user_id'],
                    $data->final_content['user_type'],
                    'bounce'
                );
                if (!empty($unsub)) {
                    $db->put_stats('bounced_emails-' . $data->final_content['mass_email_id']);
                }
            }
            // Update user bounce notice
            if (!empty($data->final_content['user_id']) && !empty($data->final_content['user_type'])) {
                if ($data->final_content['user_type'] == 'member') {
                    $user = new user;
                    $user->bounced($data->final_content['user_id']);
                    $type = '1';
                } else if ($data->final_content['user_type'] == 'contact') {
                    $contact = new contact;
                    $contact->bounced($data->final_content['user_id']);
                    $type = '2';
                } else if ($data->final_content['user_type'] == 'rsvp') {
                    $event = new event;
                    $event->bounced($data->final_content['user_id']);
                    $type = '3';
                }
                add_history('bounced', '2', $data->final_content['user_id'], $type, $data->final_content['user_id']);
            }
            // Add Bounce
            $connect->add_bounce($email_id, $data->final_content['user_id'], $data->final_content['user_type']);
        }
    }
    // Close the connection and empty
    // the inbox.
    $inbox->close();

}