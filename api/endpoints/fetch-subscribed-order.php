<?php

	$response_data   = array(
	    'api_status' => 400
	);

	$error_code = 0;
	$user_id    = Wo_UserIdFromSessionId($_POST['access_token']);
	$subscribed_order_data  = array();

	if(!empty($user_id) && (int)$user_id > 0){
		$subscribed_order_data     = getSubscribedOrderData($user_id);
		$response_data = array(
	        'api_status' => 200,
	        'subscribed_order_data' => $subscribed_order_data,
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