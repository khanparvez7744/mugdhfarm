<?php

	$response_data   = array(
	    'api_status' => 400
	);

	$error_code = 0;
	$user_id    = Wo_UserIdFromSessionId($_POST['access_token']);
	$user_data  = array();

	if(!empty($user_id) && (int)$user_id > 0){
		$user_data     = Wo_GetUserData($user_id);
		$response_data = array(
	        'api_status' => 200,
	        'user_data' => $user_data,
	    );
	}else{
		$response_data = array(
	        'api_status' => 400,
	        'user_data' => $user_data,
	        'message' => 'Invalid session..please login again',
	    );
	}

	$json_response_data = json_encode($response_data, JSON_PRETTY_PRINT);       
	echo $json_response_data;
	exit();

?>