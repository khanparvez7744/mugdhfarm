<?php
use Hybridauth\Hybridauth;
use Hybridauth\HttpClient;
$types = array(
    'Google',
    'Facebook',
    'Twitter',
    'LinkedIn',
    'Vkontakte',
    'Instagram'
);
if (isset($_GET['provider']) && in_array($_GET['provider'], $types)) {
    $provider = Wo_Secure($_GET['provider']);
    try {
        $hybridauth   = new Hybridauth($LoginWithConfig);
        $authProvider = $hybridauth->authenticate($provider);
        $tokens = $authProvider->getAccessToken();
        $user_profile = $authProvider->getUserProfile();
        if ($user_profile && isset($user_profile->identifier)) {
            $name = $user_profile->firstName;
            if ($provider == 'Google') {
                $notfound_email     = 'go_';
                $notfound_email_com = '@google.com';
            } else if ($provider == 'Facebook') {
                $notfound_email     = 'fa_';
                $notfound_email_com = '@facebook.com';
            } else if ($provider == 'Twitter') {
                $notfound_email     = 'tw_';
                $notfound_email_com = '@twitter.com';
            } else if ($provider == 'LinkedIn') {
                $notfound_email     = 'li_';
                $notfound_email_com = '@linkedIn.com';
            } else if ($provider == 'Vkontakte') {
                $notfound_email     = 'vk_';
                $notfound_email_com = '@vk.com';
            } else if ($provider == 'Instagram') {
                $notfound_email     = 'in_';
                $notfound_email_com = '@instagram.com';
                $name = $user_profile->displayName;
            }
            $user_name  = $notfound_email . $user_profile->identifier;
            $user_email = $user_name . $notfound_email_com;
            if (!empty($user_profile->email)) {
                $user_email = $user_profile->email;
            }
            if (Wo_EmailExists($user_email) === true) {
                $user_id        = Wo_UserIdForLogin($user_email);
                $create_session = Wo_CreateLoginSession($user_id, 'phone');

                $food_data      = Wo_GetUserRunningOrderStatus($user_id);   
                if(empty($food_data)){
                    $food_data     =  ''; 
                }             
                if ($create_session) {
                    $response_data = array(
                        'api_status' => 200,
                        'access_token' => $create_session,
                        'user_id' => $user_id,
                        'food_data' => $food_data
                    );
                }
                exit();
            } else {
                $social_url   = substr($user_profile->profileURL, strrpos($user_profile->profileURL, '/') + 1);
                $re_data      = array(
                    'username' => rand(11111, 99999),
                    'email' => Wo_Secure($user_email, 0),
                    'password' => Wo_Secure($user_email, 0),
                    'name' => Wo_Secure($name).' '.Wo_Secure($user_profile->lastName),
                    'active' => '1'
                );
                if ($provider == 'Google') {
                    $re_data['google'] = Wo_Secure($social_url);
                }
                if ($provider == 'Facebook') {
                    $fa_social_url       = @explode('/', $user_profile->profileURL);
                    $re_data['facebook'] = Wo_Secure($fa_social_url[4]);                    
                }
                if (Wo_RegisterSocialUser($re_data) === true) {
                    $wo['user'] = $re_data;
                    $user_id        = Wo_UserIdForLogin($user_email);
                    $create_session = Wo_CreateLoginSession($user_id, 'phone'); 

                    $food_data      = Wo_GetUserRunningOrderStatus($user_id);   
                    if(empty($food_data)){
                        $food_data     =  ''; 
                    } 

                    if ($create_session) {
                        $response_data = array(
                            'api_status' => 200,
                            'access_token' => $create_session,
                            'user_id' => $user_id,
                            'food_data' => $food_data
                        );
                    }
                    exit();
                }
            }
        }
    }
    catch (Exception $e) {
        switch ($e->getCode()) {
            case 0:
                echo "Unspecified error.";
                break;
            case 1:
                echo "Hybridauth configuration error.";
                break;
            case 2:
                echo "Provider not properly configured.";
                break;
            case 3:
                echo "Unknown or disabled provider.";
                break;
            case 4:
                echo "Missing provider application credentials.";
                break;
            case 5:
                echo "Authentication failed The user has canceled the authentication or the provider refused the connection.";
                break;
            case 6:
                echo "User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.";
                break;
            case 7:
                echo "User not connected to the provider.";
                break;
            case 8:
                echo "Provider does not support this feature.";
                break;
        }
        echo " an error found while processing your request!";
    }
} else {
    exit('Error found while loggin in, pleae try again later.');
}