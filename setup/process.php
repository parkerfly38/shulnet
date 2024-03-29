<?php

// error_reporting(E_ALL);
if (get_magic_quotes_gpc()) {
    function magicQuotes_awStripslashes(&$value, $key) {$value = stripslashes($value);}
    $gpc = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    array_walk_recursive($gpc, 'magicQuotes_awStripslashes');
}

ini_set('display_errors', 0);
error_reporting(0);

/**
 *
 *
 * ShulNET Membership Software
 * Copyright (C) 2013-2016 Castlamp, LLC
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author      Castlamp
 * @link        http://www.castlamp.com/
 * @license     GNU General Public License v3.0
 * @link        http://www.gnu.org/licenses/gpl.html
 * @date        2/25/13 2:55 PM
 * @version     v1.0
 * @project
 */


                // ----------------------------------------

                        $version = '115';

                // ----------------------------------------

require "assets/functions.php";

// ----------------------------

$path = str_replace('/setup','',dirname(__FILE__));
$exp = explode('/',$path);
$folder_name = array_pop($exp);
$base_path = implode('/',$exp);

$url = current_url();

// ----------------------------

if (! is_writable($path . '/admin/sd-system')) {
        echo "admin/sd-system not writable. Could not proceed.";
        exit;
}

// ----------------------------

// $DBH = new PDO("mysql:host=" . $_POST['mysql']['host'] . ";dbname=" . $_POST['mysql']['db'], $_POST['mysql']['user'], $_POST['mysql']['pass']);
try {
    $DBH = new PDO("mysql:host=" . $_POST['mysql']['host'] . ";dbname=" . $_POST['mysql']['db'], $_POST['mysql']['user'], $_POST['mysql']['pass']);

    // For servers with 16-byte password encryption.
    // Additional changes are required if you choose to use
    // this route. Files containing references to PDO  include:
    //   admin/cp-classes/bind.class.php
    //   admin/cp-classes/contact.class.php
    //   admin/cp-classes/db.class.php
    //   admin/cp-classes/plugin.class.php
    //   admin/cp-classes/socialmedia.class.php
    //   admin/cp-classes/user.class.php
    //   admin/cp-functions/hook-add.php
    //   admin/sd-system/start_app.php
    // $DBH = new mysqli($_POST['mysql']['host'], $_POST['mysql']['user'], $_POST['mysql']['pass'], $_POST['mysql']['db']);
}
catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "<br/>";
    exit;
}

// ----------------------------

$domain = str_replace('www.','',$_SERVER['SERVER_NAME']);

$date_change = time() + ($_POST['hour_change'] * 3600);
$date = date('Y-m-d H:i:s',strtotime($date_change));

$site_name = $_POST['site_name'];

//$company_address = $_POST['company_address'];
$company_address = '';
$company_url = $_POST['company_url'];
$company_email = $_POST['company_email'];
$company_name = $_POST['company_name'];
$company_logo = $_POST['company_logo']; // http://www.castlamp.com/imgs/logo.png
$stat_opt_in = (! empty($_POST['stat_opt_in'])) ? 1: 0;
// $company_contact = $_POST['company_contact_line']; // <b>Phone:</b> 123-123-1234<br /><b>E-Mail:</b> info@castlamp.com<br /><b>Fax:</b> 999-123-1234<br /><b>Online:</b> http://www.castlamp.com/';
$company_contact = '';
$update_array = '';

// ----------------------------

require "../admin/cp-classes/db.class.php";
$db = new db;

$salt = uniqid() . md5(uniqid()) . md5(rand(100,999999999));
$salt1 = md5(uniqid() . md5(uniqid()) . md5(rand(100,999999999)));

$saltfile = "<?php\n";
$saltfile .= "define('SALT','$salt');\n";
$saltfile .= "define('SALT1','$salt1');\n";

if (is_writable($path . '/admin/sd-system')) {
    $step1 = '';
    $fh = fopen($path . '/admin/sd-system/salt.php', 'w');
    fwrite($fh, $saltfile);
    fclose($fh);
    define('SALT',$salt);
    define('SALT1',$salt1);
} else {
    echo "admin/sd-system not writable. Could not proceed.";
    exit;
}

$admin_pass_salt = $db->generate_salt();
$admin_pass_encoded = $db->encode_password($_POST['admin']['pass'],$admin_pass_salt);

$emp_name = $_POST['admin']['first_name'] . ' ' . $_POST['admin']['last_name'];
$emp_first_name = $_POST['admin']['first_name'];
$emp_last_name = $_POST['admin']['last_name'];

// ----------------------------

$queries = '';
require "mysql/create.php";
require "mysql/inserts.php";
foreach ($create as $item) {
    try {
        $queries .= $item . "\n\n";
        $STH = $DBH->prepare($item);
        $STH->execute();
    }
    catch (PDOException $e) {
        echo "<h1>MySQL Error</h1>";
        var_dump($e);
    }
}
foreach ($inserts as $item) {
    try {
        $queries .= $item . "\n\n";
        $STH = $DBH->prepare($item);
        $STH->execute();
    }
    catch (PDOException $e) {
        echo "<h1>MySQL Error</h1>";
        var_dump($e);
    }
}

// ----------------------------

$use_url = $url;

$config = "<?php\n";
$config .= "define('PP_BASE_PATH','" . $base_path . "');\n";
$config .= "define('PP_PATH','" . $path . "');\n";
$config .= "define('PP_URL','" . $use_url . "');\n";
$config .= "define('PP_ADMINPATH','" . $path . "/admin');\n";
$config .= "define('PP_ADMIN','" . $use_url . "/admin');\n";
$config .= "define('PP_PREFIX','ppSD_');\n";
$config .= "define('PP_MYSQL_HOST','" . $_POST['mysql']['host'] . "');\n";
$config .= "define('PP_MYSQL_DB','" . $_POST['mysql']['db'] . "');\n";
$config .= "define('PP_MYSQL_USER','" . $_POST['mysql']['user'] . "');\n";
$config .= "define('PP_MYSQL_PASS','" . addslashes($_POST['mysql']['pass']) . "');\n";
$config .= "define('ZEN_SECRET_PHRASE','');\n";
$config .= "define('ZEN_HIDE_DEBUG_TIME', false);\n";
$config .= "define('DISABLE_CAPTCHA', false);\n";
$config .= "define('DISABLE_PERFORMANCE_BOOSTS', false);\n";

$config .= "require_once PP_ADMINPATH . \"/sd-system/loader.php\";";

if (is_writable($path . '/admin/sd-system')) {
    $step1 = '';
    $fh = fopen($path . '/admin/sd-system/config.php', 'w');
    fwrite($fh, $config);
    fclose($fh);
} else {
    $step1 = '<li>Create config.php (see right)</li>';
}

// ----------------------------
//   Secure key folders

@secure_folder($path . '/admin/exports');
@secure_folder($path . '/admin/attachments');

// ----------------------------
//   Delete unwanted files

@unlink($path . '/admin/sd-system/config.sample.php');
@unlink($path . '/admin/sd-system/salt.sample.php');
@unlink($path . '/admin/sd-system/license.sample.php');

// ----------------------------
//   Newsletter?
// enroll_newsletter
if (! empty($_POST['enroll_newsletter'])) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://www.castlamp.com/clients/custom/newsletter_remote_enroll.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
        'first_name' => $_POST['admin']['first_name'],
        'last_name' => $_POST['admin']['last_name'],
        'site' => $url,
        'email' => $_POST['admin']['email'],
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
    curl_close ($ch);
}

// ----------------------------
//   Complete Process

include "assets/header.php";
?>

    <div class="col50l">

        <fieldset class="green">
            <legend>Remaining Steps</legend>

            <p class="desc">Your database structure was successfully established! You will now need to manually complete the following steps:</p>

            <ul class="form">
                <?php echo $step1; ?>
                <li>Delete the "setup" folder</li>
                <li>Set permissions on the "admin/sd-system" folder to "755".</li>
                <li>Set permissions on all files within the "admin/cp-cron" folder to "755".</li>
                <li>Create the cron jobs (commands to the right) from your website's control panel.</li>
            </ul>

        </fieldset>

    </div>
    <div class="col50r">

        <fieldset class="blue">
            <legend>config.php</legend>

            <?php
            if (empty($step1)) {
                echo "<p class=\"desc good\">Your config.php file was successfully created. No further action is required.</p>";
            } else {
            ?>
            <p class="desc bad">The installer was not able to create the config.php file for you. This file is vital to the functioning of the program. Please create the following file named <b>config.php</b> and place it within the "admin/sd-system" folder.</p>
            <textarea style="width:100%;height:600px;"><?php echo $config; ?></textarea>
            <?php
            }
            ?>
        </fieldset>

        <fieldset class="red">
            <legend>Cron Jobs</legend>
            <p class="desc">*/15 * * * * php <?php echo $path; ?>/admin/cp-cron/emailing.php</p>
            <p class="desc">0 */2 * * * php <?php echo $path; ?>/admin/cp-cron/index.php</p>
            <!--<p class="desc">0 0 */1 * * php <?php echo $path; ?>/admin/cp-cron/backup.php</p>-->
        </fieldset>

    </div>
    <div class="clear"></div>

</div>

<div class="submit">
    <input type="button" onclick="window.location='<?php echo $url . '/admin'; ?>';" value="Access Administrative Control Panel" />
</div>

<h1>Queries Executed</h1>
<textarea style="width:100%;height:300px;">
<?php echo $queries; ?>
</textarea>

</form>

<?php
include "assets/footer.php";
exit;
