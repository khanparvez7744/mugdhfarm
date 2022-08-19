<?php

	$response_data   = array(
	    'api_status' => 400
	);

	$error_code = 0;
	$user_id    = Wo_UserIdFromSessionId($_POST['access_token']);
	$cart_data  = array();

	if(!empty($user_id) && (int)$user_id > 0){
		$cart_data     = getUserCartData($user_id);
		$fianl_amount= 0;
		foreach ($cart_data as  $value) {
		    // $arr[3] will be updated with each value from $arr...
		    if (is_numeric($value['unit_price'])){
		        $fianl_amount += $value['unit_price'];
		    }
		}
		$response_data = array(
	        'api_status' => 200,
		    'delivery_address'=>$cart_data[0]['delivery_address'],
		    'delivery_date'=>$cart_data[0]['delivery_date'],
		    'amount'=> $fianl_amount,
	        'cart_data' => $cart_data,
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