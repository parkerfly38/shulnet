<?php
require dirname(dirname(__FILE__)) . '/sd-system/config.php';

// Perform the backup.
$backup = new backup('1', '1', '0');
// Generic user checks
// Expiring content
// Inactive account action : option timeframe, suspend account, demote to contact, etc.
// Abuse clear
// Loop expired or old sessions and remove files from /custom/sessions/
// Clear out old form sessions
// Criteria without "save" = '1' and with "date" older than "x"...
// Previews from ppSD_temp
exit;