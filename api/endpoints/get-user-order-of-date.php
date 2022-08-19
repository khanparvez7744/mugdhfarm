<?php

	$response_data   = array(
	    'api_status' => 400
	);
	$required_fields = array(
		'date'
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
	$order_data  = array();

	if(!empty($user_id) && (int)$user_id > 0 && $error_code == 0){
		$date       	 = isset($_POST['date']) ? $_POST['date'] : '';

		$order_data      = getUserOrderDataOfDate($user_id, $date);
		$response_data   = array(
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