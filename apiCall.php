<?php

require_once(__DIR__ . '/vendor/autoload.php');
require 'admin/sd-system/config.php';
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Facades\Invoice;

session_start();

function makeAPICall()
{

    // Create SDK instance
    $config = QBConfig; //include('config.php');
    $dataService = DataService::Configure(array(
        'auth_mode' => 'oauth2',
        'ClientID' => $config['client_id'],
        'ClientSecret' =>  $config['client_secret'],
        'RedirectURI' => $config['oauth_redirect_uri'],
        'scope' => $config['oauth_scope'],
        'baseUrl' => "production"
    ));

    /*
     * Retrieve the accessToken value from session variable
     */
    $accessToken = $_SESSION['sessionAccessToken'];

    /*
     * Update the OAuth2Token of the dataService object
     */
    $dataService->updateOAuth2Token($accessToken);
    //$companyInfo = $dataService->getI
    //$address = "QBO API call Successful!! Response Company name: " . $companyInfo->CompanyName . " Company Address: " . $companyInfo->CompanyAddr->Line1 . " " . $companyInfo->CompanyAddr->City . " " . $companyInfo->CompanyAddr->PostalCode;
    $allInvoices = $dataService->FindAll('Invoice',1,1000);
    print_r($allInvoices);
    return $allInvoices;
}

$result = makeAPICall();

?>