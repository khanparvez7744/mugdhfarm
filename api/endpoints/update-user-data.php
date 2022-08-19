<?php

$response_data   = array(
    'api_status' => 400
);

$user_data = array();
if (!empty($_POST)) {
	$user_data = $_POST;
}

$escape = array('server_key');
$keys = array();
$user_id      = Wo_UserIdFromSessionId($_POST['access_token']);
$wo['user'] = Wo_GetUserData($user_id);

$remove_from_list = array('created_at', 'status', 'role', 'id', 'phone', 'otp', 'access_token', 'personal_referral_code');
foreach ($wo['user'] as $key => $value) {
	if (!in_array($key, $remove_from_list )) {
		$keys[] = $key;
	}
}

$keys = implode(', ', $keys);

if (!empty($user_data['email'])) {
	$is_exist = Wo_EmailExists($user_data['email']);
    if ($is_exist && $user_data['email'] != $wo['user']['email']) {
        $error_code    = 5;
        $error_message = 'E-mail is already exists';
    }
    if (!filter_var($user_data['email'], FILTER_VALIDATE_EMAIL)) {
        $error_code    = 6;
        $error_message = 'Invalid email characters';
    }
}

if (!empty($user_data['phone'])) {
	$is_exist = Wo_PhoneExists($user_data['phone']);
    if ($is_exist && $user_data['phone'] != $wo['user']['phone']) {
        $error_code    = 7;
        $error_message = 'Phone number already used';
    }
}

// if(!empty($_POST['photo'])){
//     $target_dir = "../upload/user/";
//     $img_result_path = saveBase64ImagePng($_POST['photo'], $target_dir);
//     $response_data['api_status'] = 200;
//     $user_data['photo'] = $img_result_path;
// }

if (isset($user_data['server_key'])) {
	unset($user_data['server_key']);
}

if (empty($error_code)) {
    foreach ($remove_from_list as $rkey => $rvalue) {
        unset($user_data[$rvalue]);
    }
	// foreach ($user_data as $key => $value) {
	// 	if ((!isset($wo['user'][$key]) || $wo['user'][$key] == '') && !in_array($key, $escape)) {
	// 		// $error_code = 1;
	// 		// $error_message = "Key #$key not found";
	// 		//unset($user_data[$key]);
	// 	}
	// }
}

if (empty($error_code)) {
    $update = Wo_UpdateUserData($wo['user']['id'], $user_data);
    if ($update) {
        $response_data['api_status'] = 200;
        $response_data['message'] = 'Your profile was updated';
    } 
}else{
    $response_data['api_status'] = 400;
    $response_data['message'] = $error_message;
}


    $json_response_data = json_encode($response_data, JSON_PRETTY_PRINT);       
    echo $json_response_data;
    exit();


?>