<?php

	$response_data   = array(
	    'api_status' => 400
	);

	$error_code = 0;
	$user_id      = Wo_UserIdFromSessionId($_GET['access_token']);

	if($error_code == 0){
		if(!empty($user_id) && (int)$user_id > 0){
			$food_data     = Wo_GetPreviousUserOrder($user_id);
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