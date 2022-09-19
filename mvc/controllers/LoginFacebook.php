<?php

class LoginFacebook extends Decorator
{
    public function __construct($action) {
        parent::__construct($action);
    }

    public function fb_callback() {

        $fb = new Facebook\Facebook([
            'app_id' => APP_ID,
            'app_secret' => APP_SECRET,
            'default_graph_version' => 'v2.2',
        ]);

        $helper = $fb->getRedirectLoginHelper();
        if (isset($_GET['state'])) {
            $helper->getPersistentDataHandler()->set('state', $_GET['state']);
        }
        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (isset($accessToken)) {
            if (isset($_SESSION['facebook_access_token'])) {
                $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            } else {
            // getting short-lived access token
                $_SESSION['facebook_access_token'] = (string) $accessToken;
                // OAuth 2.0 client handler
                $oAuth2Client = $fb->getOAuth2Client();
                // Exchanges a short-lived access token for a long-lived one
                $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
                $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
                // setting default access token to be used in script
                $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
            }
            $profile_request = $fb->get('/me?fields=name,first_name,last_name,email');
            $profile = $profile_request->getGraphUser();
            $fbid = $profile->getProperty('id');           // To Get Facebook ID
            // redirect the user to the profile page if it has "code" GET variable
            if (isset($_GET['code'])) {
                setSessionUser('id',$fbid);
                header('Location: profile');
            }
            // getting basic info about user
            try {
                $fbfullname = $profile->getProperty('name');   // To Get Facebook full name
                $fbemail = $profile->getProperty('email');    //  To Get Facebook email
                $fbpic = 'https://graph.facebook.com/'.$fbid.'/picture?type=square';
                return array(
                    'facebook_id'=>$fbid,
                    'name'=>$fbfullname,
                    'email'=>$fbemail,
                    'avatar'=>$fbpic
                );
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                echo 'Graph returned an error: ' . $e->getMessage();
                session_destroy();
                // redirecting user back to app login page
                header("Location: ./");
                exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
        }
    }


}