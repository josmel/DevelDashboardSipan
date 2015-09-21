<?php

require '../../../includes/google-api-php-client/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfigFile('client_secrets.json');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/dashboardDev/modulos/Admin/controllers/oauth2callback.php');
$client->addScope(Google_Service_Calendar::CALENDAR_READONLY);

if (!isset($_GET['code'])) {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/dashboardDev/modulos/Admin/controllers/';
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}