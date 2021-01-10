<?php

// Sample Command (every 15 minutes):
// */15	*	*	*	*	php /full/server/path/to/members/admin/cp-cron/emailing.php
require dirname(dirname(__FILE__)) . '/sd-system/config.php';
// Send scheduled queue
$connect = new connect();
$sent    = $connect->send_queue();
// Bounced e-mails
require "bounced_emails.php";