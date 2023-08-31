<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}
set_error_handler("exception_error_handler");
print_r("<p>Starting...</p>");
// Sample Command (every 15 minutes):
// */15	*	*	*	*	php /full/server/path/to/members/admin/cp-cron/emailing.php

require '../../vendor/autoload.php';



print_r("Using Mailgun...<br />");
use Mailgun\Mailgun;

print_r("Domain and key set...<br />");
//prod conn string
$pdo = new PDO("mysql:host=localhost;dbname=cbisrael_shulnet", "cbisrael_dbuser", "NUgget38!@");
$delstmt = $pdo->prepare("DELETE FROM ppSD_email_scheduled WHERE user_type = 'contact' AND user_id NOT IN (SELECT id from ppSD_contacts)");
$delstmt->execute();
$stmt = $pdo->prepare("SELECT * FROM `ppSD_email_scheduled` LIMIT 500");
$stmt->execute();
$rows = $stmt->fetchAll();
$getMGKey = $pdo->prepare("SELECT value FROM ppSD_options WHERE id = 'apikey'");
$getMGKey->execute();
$mgkey = $getMGKey->fetch()["value"];
$getMGDomain = $pdo->prepare("SELECT value FROM ppSD_options WHERE id = 'domain'");
$getMGDomain->execute();
$domain = $getMGDomain->fetch()["value"];
$mg =  Mailgun::create($mgkey);
$getCompanyName = $pdo->prepare("SELECT value FROM ppSD_options WHERE id = 'company_name'");
$getCompanyName->execute();
$companyName = $getCompanyName->fetch()["value"];
$getCompanyEmail = $pdo->prepare("SELECT value FROM ppSD_options WHERE id = 'company_email'");
$getCompanyEmail->execute();
$companyEmail = $getCompanyEmail->fetch()["value"];
$from = $companyName . " <". $companyEmail . ">";
    
foreach ($rows as $row)
{
    $to = "";
    try {
        if ($row["user_type"] == 'contact')
        {
            $getUser = $pdo->prepare("SELECT email FROM ppSD_contacts where id = '".$row['user_id']."'");
            $getUser->execute();
            $todata = $getUser->fetch();
            $to = $todata["email"];
        }
        if ($row["user_type"] == 'member')
        {
            $getUser = $pdo->prepare("SELECT email FROM ppSD_members WHERE id = '".$row['user_id']."'");
            $getUser->execute();
            $todata = $getUser->fetch();
            $to = $todata["email"];
        }
    }
    catch (Exception $exception)
    {
        //do nothing
        print_r($exception);
    }
    //get message
    $getEmail = $pdo->prepare("SELECT * FROM ppSD_saved_email_content WHERE id = '".$row["email_id"]."'");
    $getEmail->execute();
    $emailData = $getEmail->fetch();
    $subject = $emailData["subject"];
    $message = $emailData["message"];
    $cc = $emailData["cc"];
    $bcc = $emailData["bcc"];
    //look for attachments
    $getUploads = $pdo->prepare("SELECT * FROM ppSD_uploads WHERE email_id = '".$row["email_id"]."'");
    $getUploads->execute();
    $uploads = $getUploads->fetchAll();
    $attachmentarray = array();
    foreach($uploads as $upload)
    {
        $file_path = "../admin/sd-system/attachments/" . $upload['filename'];
        $size      = filesize($file_path);
        $attachments = array("filePath"=>$file_path, "filename"=>$upload["filename"]);
        if ($size > 0)
        {
            array_push($attachmentarray, $attachments);
        }
    }

    $this_trackback_id = generate_id('random', '27');
    $final_url = "https://<your host>/pp-functions/etc.php?id=" . $this_trackback_id;
    $message .= "<img src=\"$final_url\" width=\"0\" height=\"0\" border=\"0\" />";
    $mailarray = array(
        'from'=>$from,
        'to'=> $to,
        'subject' => $subject,
        'html' => $message,
        'o:tracking' => "true",
        'o:tracking-clicks' => "true",
        'o:tracking-opens' => "true"
    );
    if (strlen($cc) > 0)
    {
        $mailarray["cc"] = $cc;
    }
    if (strlen($bcc) > 0)
    {
        $mailarray["bcc"] = $bcc;
    }
    if (count($attachmentarray) > 0)
    {
        $mailarray['attachment'] = $attachmentarray;
    }
    if (strlen($to) > 0)
    {
    $mailResponse = $mg->messages()->send($domain, $mailarray);
        //email trackback setup
        $insertEmailTrackBack = $pdo->prepare("INSERT INTO `ppSD_email_trackback` (`id`,`email_id`,`date`,`status`,`user_id`,`user_type`,`campaign_id`,`campaign_saved_id`)
                    VALUES ('".$this_trackback_id."','" . $row['email_id'] . "',NOW(),'0','" . $row['user_id']. "','" . $row["user_type"] . "','" . $row['campaign'] . "','')
                ");
        $insertEmailTrackBack->execute();
        //delete from queue
        $insertSavedMail = $pdo->prepare("INSERT INTO ppSD_saved_emails (`id`, `date`, `content`, `subject`, `to`, `from`, `cc`, `bcc`, `format`, `newsletter`, `user_id`, `user_type`, `fail`, `sentvia`, `vendor_id`)
                                            VALUES ('".$row["email_id"]."',NOW(),'".$message."','".$subject."','".$to."','".$from."','".$cc."','".$bcc."',1,0,'".$row["user_id"]."','".$row["user_type"]."',0,'mailgun','".$mailResponse->getId()."')");
        $insertSavedMail->execute();
        //$delSavedMail = $pdo->prepare("DELETE FROM ppSD_saved_email_content WHERE id = '".$row["email_id"]."'");
        //$delSavedMail->execute();
    }
    $delfromMessageQueue = $pdo->prepare("DELETE FROM ppSD_email_scheduled WHERE email_id = '".$row["email_id"]."' and user_id = '".$row["user_id"]."'");
    $delfromMessageQueue->execute();
    
}
$updateEmailQueue = $pdo->prepare("UPDATE ppSD_options SET `value` = '".date('Y-m-d H:i:s', time())."' WHERE id = 'email_queue_last_sent'");
print_r("Sending");
$updateEmailQueue->execute();
print_r($updateEmailQueue);

// Send scheduled queue
//$connect = new connect();
//$sent    = $connect->send_queue();
// Bounced e-mails
//require "bounced_emails.php";

function generate_id($format = 'random', $length = '20')
{
    $format = trim($format);
    if ($format == "random" || empty($format)) {
        $final_id = md5(time() . rand(1000, 999999999) . uniqid(rand(), true)) . md5(rand(1, 999) . rand(999, 999999));

    } else {
        $final_id      = '';
        $letters_lower = 'abcdefghijklmnopqrstuvwxyz';
        $letters_upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $the_format    = preg_split('//', $format, -1, PREG_SPLIT_NO_EMPTY);
        foreach ($the_format as $aLetter) {
            if ($aLetter == "l") {
                $temp_rand = rand(0, 25);
                $get_one   = $letters_lower[$temp_rand];
                $final_id .= $get_one;

            } elseif ($aLetter == "L") {
                $temp_rand = rand(0, 25);
                $get_one   = $letters_upper[$temp_rand];
                $final_id .= $get_one;

            } elseif ($aLetter == "n") {
                $temp_rand = rand(1, 9);
                $final_id .= $temp_rand;

            } else {
                $final_id .= $aLetter;

            }

        }

    }
    $final_id = substr($final_id, 0, $length);

    return $final_id;

}