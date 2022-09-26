<?php

use Facebook\Exceptions\FacebookSDKException;

class LoginFacebook extends Decorator
{
    public function __construct($action)
    {
        parent::__construct($action);
    }

    /**
     * @throws FacebookSDKException
     */
    public function callback()
    {

        $facebook = new Facebook\Facebook([
            'app_id' => '759351248655188', // Replace {app-id} with your app id
            'app_secret' => '8de01d92a631b2eb340496f219a3671f',
            'default_graph_version' => 'v2.2'
        ]);

        $facebook_helper = $facebook->getRedirectLoginHelper();

        if (isset($_GET['state'])) {

            $facebook_helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }

        if (isset($_SESSION['facebook_access_token'])) {
            $facebook->setDefaultAccessToken($_SESSION['facebook_access_token']);
        } else {
            $access_token = $facebook_helper->getAccessToken();

            $_SESSION['facebook_access_token'] = (string) $access_token;

            $facebook->setDefaultAccessToken($_SESSION['facebook_access_token']);
        }

        $graph_response = $facebook->get("/me?fields=id,name,picture{url}");

        $facebook_user_info = $graph_response->getGraphUser();


        return array(
            'name' => $facebook_user_info['name'],
            'email' => $facebook_user_info['email'],
            'avatar' => strchr($facebook_user_info['picture']['url'], "?"),
            'facebook_id' => $facebook_user_info['id']
        );
    }


}