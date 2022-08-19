<?php
header("Content-Type:application/json");
require "dbconfig.php"; 
require "function_one.php";  

$server_key = isset($_POST['server_key']) ? $_POST['server_key'] : '';
$error = 0;

$url_without_accesstoken   = array('sign-up', 'verify-otp', 'get-guest-user-dashboard-data', 'get-all-categories', 'get-all-products', 'get-product-from-category','payment-success-payu-app','payment-failure-payu-app');
$url_with_accesstoken      = array('get-dashboard-data', 'update-user-data', 'feedback', 'add-order', 'place-order', 'fetch-user-cart-data', 'fetch-user-orders', 'fetch-subscribed-order', 'get-user-data', 'get-user-order-of-date', 'get-user-coupans', 'delete-data-from-cart');

if(empty($server_key)){
	$response_data = array(
		"api" => "404",
		"status" => 'Server Key not found'
	);
	$error = 1;
}
if(!empty($server_key)){
	$validate_key = validateKey($server_key);
	if($validate_key === false){
		$error = 1;
		$response_data = array(
			"api" => "401",
			"status" => 'Invalid Server Key'
		);
	}	
}

if($error == 0){
	$url = isset($_GET['url']) && !empty($_GET['url']) ? $_GET['url'] : '';
	if(!empty($url)){
		if(in_array($url, $url_with_accesstoken)){
			$access_token = isset($_POST['access_token']) && !empty($_POST['access_token']) ? $_POST['access_token'] : '';
			if(empty($access_token)){
				$response_data = array(
					"api" => "400",
					"status" => 'Invalid token, Please login again'
				);
				$error = 4;
			}else{
				$Wo_IsValidUser = Wo_IsValidUser($access_token);
				if(!$Wo_IsValidUser){
					$response_data = array(
						"api" => "404",
						'$access_token' => $access_token,
						"status" => 'Invalid session, Please login again'
					);
					$error = 4;
				}
			}
		}
		if($error == 0){
			include 'endpoints/'.$url.'.php';
		}		
	}
	else{
	 	$response_data = array(
			"api" => "401",
			"status" => 'Invalid url'
		);
	}
}


$json_response_data = json_encode($response_data, JSON_PRETTY_PRINT); 		
echo $json_response_data;
exit();
?>