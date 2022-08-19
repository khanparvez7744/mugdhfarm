<?php

	$response_data   = array(
	    'api_status' => 400 
	);

	$required_fields = array(
		'product'
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
	
	$user_id    = Wo_UserIdFromSessionId($_POST['access_token']);

	if(!empty($user_id) && (int)$user_id > 0){
		$product       = isset($_POST['product']) ? $_POST['product'] : '';
		$product_parse = json_decode($product);
		$delete_data = deletePreviousDataFromCart($user_id);
		foreach ($product_parse as $key => $value) {
			if($value->pre_post == 'Buy Once'){
				$request_id = addDataToCartAPI($user_id, $value->product, 'Buy Once');
				if($request_id){
				    addAddressToOrderAPI($user_id, $request_id);
				    $response_data = array(
					    'api_status' => 200,
					    'message' => 'Order added successfully.'
					);
				}
			}elseif($value->pre_post == 'Subscription'){
				$request_id = addDataToCartAPI($user_id, $value->product, 'Subscription');
				if($request_id){
				    $response_data = array(
					    'api_status' => 200,
					    'message' => 'Order added successfully.'
					);
				}
			}
		}

	}

	$json_response_data = json_encode($response_data, JSON_PRETTY_PRINT);       
	echo $json_response_data;
	exit();

?>