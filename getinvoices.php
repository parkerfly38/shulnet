<?php
session_start();

require 'vendor/quickbooks/v3-php-sdk/src/config.php';
require 'admin/sd-system/config.php';

use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Core\OAuth\OAuth2\OAuth2AccessToken;
$config = QBConfig;
echo "<p>got this far</p>";
try {
echo "<p?>set dataservice start</p>";
$dataService = DataService::Configure(array(
    'auth_mode' => 'oauth2',
    'ClientID' => $config["client_id"],
    'ClientSecret' => $config['client_secret'],
    'RedirectURI' => $config['oauth_redirect_uri'],
    'scope' => $config['oauth_scope'],
    'baseUrl' => "production"
));
//print_r($dataService);
echo "<p>set dataservice end</p>";

$OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
$authUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();


// Store the url in PHP Session Object;
$_SESSION['authUrl'] = $authUrl;
echo "<p>set session</p>";
} catch (Exception $e)
{
    print_r($e);
}
catch (Throwable $t)
{
    print_r($t);
}
try {
//update from last db
$db = new db;
$arr = $db->get_array("SELECT * FROM ppSD_QBInvoicePull ORDER BY update_time DESC LIMIT 1");

if (!empty($arr))
{
    //$_SESSION["sessionAccessToken"] = "";
    $accessToken = new OAuth2AccessToken($config["client_id"], $config["client_secret"], $arr["lastAccessToken"], $arr["refreshToken"], strtotime($arr["expires_in"]), strtotime($arr["refreshTokenExpires"]), "bearer");
    $accessToken->setRealmID($arr["realmId"]);

    $_SESSION["sessionAccessToken"] = $accessToken;
}
} catch (Exception $e)
{
    print_r($e);
}
catch (Throwable $t)
{
    print_r($t);
}
//set the access token using the auth object
if (isset($_SESSION['sessionAccessToken'])) {

    $accessToken = $_SESSION['sessionAccessToken'];
    $accessTokenJson = array('token_type' => 'bearer',
        'access_token' => $accessToken->getAccessToken(),
        'refresh_token' => $accessToken->getRefreshToken(),
        'x_refresh_token_expires_in' => $accessToken->getRefreshTokenExpiresAt(),
        'expires_in' => $accessToken->getAccessTokenExpiresAt()
    );
    if (strtotime("now") > strtotime($accessToken->getAccessTokenExpiresAt()))
    {
        echo "<p>Token expired</p>";
        $dataService = DataService::Configure(array(
            'auth_mode' => 'oauth2',
            'ClientID' => $config["client_id"],
            'ClientSecret' => $config['client_secret'],
            'RedirectURI' => $config['oauth_redirect_uri'],
            'scope' => $config['oauth_scope'],
            'baseUrl' => "production",
            'refreshTokenKey' => $accessToken->getRefreshToken(),
            'QBORealmID' => $accessToken->getRealmID(),
        ));
        try {
            $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
            $refreshedAccessTokenObj = $OAuth2LoginHelper->refreshToken();
            $dataService->updateOAuth2Token($refreshedAccessTokenObj);

            $_SESSION['sessionAccessToken'] = $refreshedAccessTokenObj;
        
            $id = $db->insert("INSERT INTO ppSD_QBInvoicePull (lastAccessToken, refreshToken,refreshTokenExpires, expires_in, realmId, update_time)
                    VALUES ('".$refreshedAccessTokenObj->getAccessToken()."','".$refreshedAccessTokenObj->getRefreshToken()."','"
                    .$refreshedAccessTokenObj->getRefreshTokenExpiresAt()."','"
                    .$refreshedAccessTokenObj->getAccessTokenExpiresAt()."','"
                    .$refreshedAccessTokenObj->getRealmID()."',NOW());");
        } catch (Exception $e)
        {
            print_r($e);
            exit;
        }
        catch (Throwable $t)
        {
            print_r($t);
            exit;
        }
        echo "<p>Finished getting new token.</p>";
    }
    $dataService->updateOAuth2Token($accessToken);
    $oauthLoginHelper = $dataService -> getOAuth2LoginHelper();
    
    $customers = $db->run_query("SELECT member_id, first_name, last_name, quickbooks_customer_id FROM ppSD_member_data WHERE quickbooks_customer_id IS NOT NULL");
    $arrCustomers = $customers->fetchAll();
    echo "<p>Retrieved customers</p>";
    //insert invoices
    foreach($arrCustomers as $customer)
    {
        print_r($customer);
        echo "<br /><br />";
        $invoices = $dataService->Query("SELECT * FROM Invoice WHERE CustomerRef = '".$customer["quickbooks_customer_id"]."'");// AND TxnDate > '".$arr["update_time"]."'");
        foreach ($invoices as $invoice)
        {
            print_r($invoice);
            echo "<br /><br />";
            //does invoice exist
            
                // determine invoice status
                $due = $invoice->TotalAmt;
                $balance = $invoice->Balance;
                if ($due === $balance)
                {
                    $status = 0;
                }
                if ($due > $balance && $balance > 0)
                {
                    $status = 2;
                }
                if ($balance <= 0)
                {
                    $status = 1;
                }
                $insertSql = "INSERT INTO ppSD_invoices (id, date, date_due, member_id, member_type,`status`)
                VALUES (
                '".$invoice->Id."',
                '".$invoice->TxnDate."',
                '".$invoice->DueDate."',
                '".$customer["member_id"]."',
                'member',
                ".$status.")";
                $insertInvoice = $db->insert($insertSql);
                //we need to add invoice_data
                $insertInvoiceDataSql = "INSERT INTO ppSD_invoice_data (id, company_name, contact_name, address_line_1, address_line_2, city, `state`,`zip`,`email`,website,`memo`)
                    VALUES (
                    '".$invoice->Id."',
                    '".$customer["member_id"]."',
                    '".$customer["first_name"]." ".$customer["last_name"]."',
                    '".$invoice->BillAddr->Line1."',
                    '".$invoice->BillAddr->Line2."',
                    '".$invoice->BillAddr->City."',
                    '".$invoice->BillAddr->CountrySubDivisionCode."',
                    '".$invoice->BillAddr->PostalCode."',
                    '".$invoice->BillEmail->Address."',
                    '',
                    '".$invoice->CustomerMemo."');";
                    echo $insertInvoiceDataSql;
                $insertInvoiceData = $db->insert($insertInvoiceDataSql);
                foreach ($invoice->Line as $line)
                {
                    $insertLineSql = "INSERT INTO ppSD_invoice_components (invoice_id, `type`, `minutes`,hourly, product_id, qty, unit_price, `status`, `date`,`name`,`description`)
                    VALUES (
                    '".$invoice->Id."',
                    'product',
                    0,
                    0,
                    '',
                    ".$line->SalesItemLineDetail->Qty.",
                    ".$line->Amount.",
                    ".$status.",
                    '".$invoice->TxnDate."',
                    '".$line->DetailType."',
                    '".$line->Description."')";
                    $lineInsert = $db->insert($insertLineSql);
                    print($lineInsert);
                }
                $insertTotalsSql = "INSERT INTO ppSD_invoice_totals (id, paid, due, subtotal)
                                VALUES (
                                '".$invoice->Id."',
                                ".($due-$balance).",
                                ".$due.",
                                ".$balance.")";
                $insertTotals = $db->insert($insertTotalsSql);
            //}
        }
        echo "<h2>Receipts</h2>";
        $receipts = $dataService->Query("SELECT * FROM SalesReceipt WHERE CustomerRef = '".$customer["quickbooks_customer_id"]."'");// AND TxnDate > '".$arr["update_time"]."'");
        foreach ($receipts as $receipt)
        {
            print_r($receipt);
            echo "<br /><br />";
            
        }
        echo "<h2>Purchases</h2>";
        $purchases = $dataService->Query("SELECT * FROM Purchase WHERE CustomerRef = '".$customer["quickbooks_customer_id"]."'");// AND TxnDate > '".$arr["update_time"]."'");
        foreach ($purchases as $purchase)
        {
            print_r($purchase);
            echo "<br /><br />";
            
        }
        echo "<h2>Payments</h2>";
        $payments = $dataService->Query("SELECT * FROM Payment WHERE CustomerRef = '".$customer["quickbooks_customer_id"]."'");// AND TxnDate > '".$arr["update_time"]."'");
        foreach ($payments as $payment)
        {
            print_r($payment);
            echo "<br /><br />";
            
        }
    }
    echo "<br />finished processing.";
}?>