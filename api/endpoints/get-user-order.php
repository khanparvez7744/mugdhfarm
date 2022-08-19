<?php

	$response_data   = array(
	    'api_status' => 400
	);

	$required_fields = array(
	    'hotel_id',
	    'qr_code'
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
	$hotel_id     = isset($_POST['hotel_id']) ? $_POST['hotel_id'] : '';
	$qr_code      = isset($_POST['qr_code']) ? $_POST['qr_code'] : '';
	//$request_id   = isset($_POST['request_id']) ? $_POST['request_id'] : '';

	if (strpos($qr_code, '/') !== false) {
	    $qr_array    = explode('/', $qr_code);
		$qr_code 	 = $qr_array[1];
	}
	
	$hotel_id     = Wo_Secure($hotel_id);
	$qr_code      = Wo_Secure($qr_code);
	//$request_id   = Wo_Secure($request_id);
	$user_id      = Wo_UserIdFromSessionId($_GET['access_token']);

	if($error_code == 0){
		if(!empty($hotel_id) && (int)$hotel_id > 0){
			$food_data     = Wo_GetUserOrder($hotel_id, $qr_code, $user_id);
			$order_summary['restro'] = Wo_GetHotelData($hotel_id);
			$total_bill = Wo_GetTotalBill($hotel_id, $qr_code, $user_id, 0);
			$amount = ($total_bill['total_payment'] * $total_bill['total_tax']) / 100;
			$order_summary['food_bill'] = $total_bill['total_payment'];
			$order_summary['total_bill'] = ($total_bill['total_payment'] + $amount);
			$order_summary['total_tax'] = $total_bill['total_tax'];
			$order_summary['item'] = $food_data;

			$final_order = $order_summary;
			$response_data = array(
		        'api_status' => 200,
		        'food_data' => $final_order,
		        'message' => 'Success.',
		    );
		}else{
			$response_data = array(
		        'api_status' => 400,
		        'message' => 'Oops!! Invalid request. Please contact to admin',
		    );
		}
	}

	

	$json_response_data = json_encode($response_data, JSON_PRETTY_PRINT);       
	echo $json_response_data;
	exit();

?>