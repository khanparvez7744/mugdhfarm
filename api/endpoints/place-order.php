<?php

	$response_data   = array(
	    'api_status' => 400 
	);

	$error_code = 0;
	
	$user_id    = Wo_UserIdFromSessionId($_POST['access_token']);

	if(!empty($user_id) && (int)$user_id > 0){

		$request_id 		= placeUserOrderAPI($user_id);
		if($request_id){			
		    $response_data = array(
			    'api_status' => 200,
			    'message' => 'Order placed successfully.'
			);
		}else{
			$response_data = array(
			    'api_status' => 400,
			    'message' => 'Oops!! Failed to place order.'
			);
		}
	}

	$json_response_data = json_encode($response_data, JSON_PRETTY_PRINT);       
	echo $json_response_data;
	exit();

?>