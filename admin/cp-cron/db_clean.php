<?php

// Clear temporary data.
$db->clear_temp_data();

// Mark memberships inactive.
$user = new user;
$user->check_inactive();


// Clean up some potential incorrect member IDs
// on orders
$cart = new cart;
$last_run = $db->get_option('cron_last_run');
$orders = $db->run_query("
    SELECT
        `id`,`member_id`,`member_type`
    FROM
        ppSD_cart_sessions
    WHERE
        `date_completed` >= '" . $db->mysql_clean($last_run) . "' AND
        `member_type`='member'
");
while ($row = $orders->fetch()) {
    if (! empty($row['member_id'])) {
        $find_user = $user->get_username($row['member_id']);
        if (empty($find_user)) {
            $updated = $cart->updateOrderUserType($row['id'], 'contact');
        }
    }
}


// Re-secure key folders.
secure_folder(PP_PATH . '/admin/sd-system/attachments');
secure_folder(PP_PATH . '/admin/sd-system/exports');

/**
 * Creates "off-limits" security for
 * folders that cannot be accessed from
 * a web browser.
 *
 * @param string $folder Path to folder.
 */
function secure_folder($folder)
{
    // .htaccess file
    $final_data = "# Generated by ShulNET.\n";
    $final_data .= "# IMPORTANT SECURITY FILE! DO NOT ALTER OR DELETE!\n";
    $final_data .= "# ShulNET: http://www.covebrookcode.com/shulnet\n";
    $final_data .= "AuthUserFile " . $folder . "/.htpasswd\n";
    $final_data .= "AuthName \"Content Off Limits\"\n";
    $final_data .= "AuthType Basic\n";
    $final_data .= "require valid-user";
    $htfile = $folder . "/.htaccess";
    if ($fh = fopen($htfile, 'w')) {
        fwrite($fh, $final_data);
        fclose($fh);
    }
    // .htpasswd file
    $content = md5(uniqid(rand(), true)) . ":" . crypt(md5(uniqid(rand(), true)) . md5(time() . rand(10000, 99999999))) . "\n";
    $htfile1 = $folder . "/.htpasswd";
    if ($fh = fopen($htfile1, 'w')) {
        fwrite($fh, $content);
        fclose($fh);
    }
}