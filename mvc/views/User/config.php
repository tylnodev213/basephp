<?php

require $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/ajax/Facebook/autoload.php';
$fb = new Facebook\Facebook ([
    'app_id' => '759351248655188', // ID ứng dụng
    'app_secret' => '8de01d92a631b2eb340496f219a3671f',
    'default_graph_version' => 'v12.0',
]);

$domain = DOMAIN.'facebook_login';
$helper = $fb->getRedirectLoginHelper();
if (isset($_GET['state'])) {
    $helper->getPersistentDataHandler()->set('state', $_GET['state']);
}

try {
    $accessToken = $helper->getAccessToken($domain);
//$accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if (! isset($accessToken)) {

    $permissions = array('public_profile','email'); // Optional permissions
    $loginUrl = $helper->getLoginUrl($domain,$permissions);
    header("Location: ".$loginUrl);
    exit;
}

try {
    // Returns a `Facebook\FacebookResponse` object
    $fields = array('id', 'name', 'email');
//  $response = $fb->get('/me?fields='.implode(',', $fields).'', $accessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}
$response = $fb->get('/me?fields=id,name,email,gender', $accessToken);
$fb_name = $response->getGraphUser()['name'];
$email = $response->getGraphUser()['email'];
$fb_id = $response->getGraphUser()['id'];
$sex = $response->getGraphUser()['sex'];

$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$api = mt_rand(10000, 99999).random($chars, 8);
$api = sha1($api);
$time = time();
$passmd5 = md5($fb_id);





?>