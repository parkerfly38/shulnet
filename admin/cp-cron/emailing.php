<?php

// Sample Command (every 15 minutes):
// */15	*	*	*	*	php /full/server/path/to/members/admin/cp-cron/emailing.php
require '../../vendor/autoload.php';
use Mailgun\Mailgun;

$mg =  Mailgun::create("key-b25b4f8a77f1f981ca630925563b4a20");
$domain = "mg.cbisrael.org";

//prod conn string
$pdo = new PDO("mysql:host=216.15.188.201;dbname=cbisrael_shulnet", "cbisrael_dbuser", "NUgget38!@");
$stmt = $pdo->prepare("SELECT * FROM `ppSD_email_scheduled` LIMIT 500");
$stmt->execute();
$rows = $stmt->fetchAll();
foreach ($rows as $row)
{
    $to = "";
    $from = "Congregation Beth Israel <office@cbisrael.org>";
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
    $mailarray = array(
        'from'=>$from,
        'to'=> $to,
        'subject' => $subject,
        'html' => $message,
        'o:tracking' => true,
        'o:tracking-clicks' => true,
        'o:tracking-opens' => true
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

    $mailResponse = $mg->messages()->send($domain, $mailarray);
    //delete from queue
    $insertSavedMail = $pdo->prepare("INSERT INTO ppSD_saved_emails (`id`, `date`, `content`, `subject`, `to`, `from`, `cc`, `bcc`, `format`, `newsletter`, `user_id`, `user_type`, `fail`, `sentvia`, `vendor_id`)
                                        VALUES ('".$row["email_id"]."',NOW(),'".$message."','".$subject."','".$to."','".$from."','".$cc."','".$bcc.",1,0,'".$row["user_id"]."','".$row["user_type"]."',0,'mailgun','".$mailResponse->getId()."')");
    $insertSavedMail->execute();
    //$delSavedMail = $pdo->prepare("DELETE FROM ppSD_saved_email_content WHERE id = '".$row["email_id"]."'");
    //$delSavedMail->execute();
    $delfromMessageQueue = $pdo->prepare("DELETE FROM ppSD_email_scheduled WHERE email_id = '".$row["email_id"]."' and user_id = '".$row["user_id"]."')");
    $delfromMessageQueue->execute();
}
$updateEmailQueue = $pdo->prepare("UPDATE ppSD_options SET `value` = '".date('Y-m-d H:i:s', time())."' WHERE id = 'email_queue_last_sent'");
$updateEmailQueue->execute();


// Send scheduled queue
//$connect = new connect();
//$sent    = $connect->send_queue();
// Bounced e-mails
//require "bounced_emails.php";