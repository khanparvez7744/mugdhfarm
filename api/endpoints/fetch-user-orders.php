<?php

	$response_data   = array(
	    'api_status' => 400
	);

	$error_code = 0;
	$user_id    = Wo_UserIdFromSessionId($_POST['access_token']);
	$order_data  = array();

	if(!empty($user_id) && (int)$user_id > 0){
		$order_data     = getUserOrderData($user_id);
		$response_data = array(
	        'api_status' => 200,
	        'order_data' => $order_data
	    );
	}else{
		$response_data = array(
	        'api_status' => 400,
	        'message' => 'Oops!! Failed to get data',
	    );
	}

	$json_response_data = json_encode($response_data, JSON_PRETTY_PRINT);       
	echo $json_response_data;
	exit();

?>