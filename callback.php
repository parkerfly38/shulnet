<?php

require_once(__DIR__ . '/vendor/autoload.php');
require 'admin/sd-system/config.php';
use QuickBooksOnline\API\DataService\DataService;

session_start();

function processCode()
{

    // Create SDK instance
    $config = QBConfig; //include('config.php');
    $dataService = DataService::Configure(array(
        'auth_mode' => 'oauth2',
        'ClientID' => $config['client_id'],
        'ClientSecret' =>  $config['client_secret'],
        'RedirectURI' => $config['oauth_redirect_uri'],
        'scope' => $config['oauth_scope'],
        'baseUrl' => "development"
    ));

    $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
    $parseUrl = parseAuthRedirectUrl($_SERVER['QUERY_STRING']);

    /*
     * Update the OAuth2Token
     */
    $accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($parseUrl['code'], $parseUrl['realmId']);
    $db = new db;
    $db->insert("INSERT INTO ppSD_QBInvoicePull (lastAccesstoken, refreshToken, refreshTokenExpires, expires_in, realmId, update_time)
        VALUES ('".$accessToken->accessTokenKey."','".$accessToken->refresh_token."','".$accessToken->refeshTokenExpiresAt."','".$accessToken->accessTokenExpiresAt."','".$accessToken->realmID."',NOW())");
    $dataService->updateOAuth2Token($accessToken);

    /*
     * Setting the accessToken for session variable
     */
    $_SESSION['sessionAccessToken'] = $accessToken;
}

function parseAuthRedirectUrl($url)
{
    parse_str($url,$qsArray);
    return array(
        'code' => $qsArray['code'],
        'realmId' => $qsArray['realmId']
    );
}

$result = processCode();

?>