<?php

$response_data   = array(
    'api_status' => 400
);
$required_fields = array(
    'phone',
    'otp'
);
$error_code = 0;
foreach ($required_fields as $key => $value) {
    if (empty($_POST[$value]) && empty($error_code)) {
        $response_data = array(
            "api_status" => "401",
            "message" => $value . ' (POST) is missing',
            'food_data' => $food_data
        );
        $error_code    = 3;
    }
}
if (empty($error_code)) {
    $phone          = $_POST['phone'];
    $otp          = $_POST['otp'];
    $user_id        = Wo_UserIdForLogin($phone);
    if($user_id == 0){
        $response_data = array(
            "api_status" => "401",
            "message" => 'Oops!! user seems not registered with us',
            'food_data' => $food_data
        );
    }
    else {
        $login = Wo_VerifyOTP($phone, $otp);
        if (!$login) {
            $error_code    = 5;
            $response_data = array(
                "api_status" => "401",
                "message" => 'Invalid OTP. Please try again.'
            );
        } else {
                $create_session = Wo_CreateLoginSession($user_id, 'phone');       

                if ($create_session) {
                    $response_data = array(
                        'api_status' => 200,
                        'access_token' => $create_session
                    );
                }
            }
    }
}