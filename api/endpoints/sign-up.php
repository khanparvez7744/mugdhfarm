<?php

$response_data   = array(
    'api_status' => 400
);
$required_fields = array(
    'phone'
);
$error_code = 0;
foreach ($required_fields as $key => $value) {
    if (empty($_POST[$value]) && empty($error_code)) {
        $response_data = array(
            "api_status" => "401",
            "message" => $value . ' (POST) is missing'
        );
        $error_code    = 3;
    }
}
if (empty($error_code)) {
    $phone          = $_POST['phone'];

    $user_id        = Wo_UserIdForLogin($phone);
    if($user_id > 0){
        if($phone == '9876543210'){
           
            $response = sendDummyOTPtoUser($phone);
        }else{
            $otp = mt_rand(100000,999999);
            $templid  = '1507162393980433736';
            $msg = "OTP for Login Transaction on MugdhFarm is ".$otp." and valid till 10 minutes. Do not share this OTP to anyone for security reasons.";
            
            $response = sendOTPtoUser($phone,$msg,$templid); 
        }
        
        if($response){
            $response_data = array(
                "api_status" => "200",
                "message" => 'OTP send successfully.'
            );
        }else{
            $response_data = array(
                "api_status" => "400",
                "message" => 'Oops!! Failed to register..Please try again.'
            );
        }
    }
    else {
        $response = Wo_RegisterUser($phone);
        if ($response) {
            $response_data = array(
                "api_status" => "200",
                "message" => 'OTP send successfully.'
            );
        } else {
                $response_data = array(
                    "api_status" => "400",
                    "message" => 'Oops!! Failed to register..Please try again.'
                );
        }
    }
}