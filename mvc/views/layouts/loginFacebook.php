<?php
$fb = new Facebook\Facebook([
'app_id' => '759351248655188', // Replace {app-id} with your app id
'app_secret' => '8de01d92a631b2eb340496f219a3671f',
'default_graph_version' => 'v2.2',
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://site.test/basephp/User/loginFacebook', $permissions);

echo '<a href="https://site.test/basephp/User/loginFacebook">Log in with Facebook!</a>';