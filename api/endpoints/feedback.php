<?php

	$response_data   = array(
	    'api_status' => 400 
	);
	$required_fields = array(
		'quality',
		'service'
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
	$user_data  = array();

	if(!empty($user_id) && (int)$user_id > 0){

		$quality       				= isset($_POST['quality']) ? $_POST['quality'] : '';
		$service      				= isset($_POST['service']) ? $_POST['service'] : '';
		$f_suggestion      			= isset($_POST['suggestion']) ? $_POST['suggestion'] : '';
		$request_id      			= isset($_POST['request_id']) ? $_POST['request_id'] : '';

		if((int)$quality > 5 || (int)$service > 5){
			$response_data = array(
				'api_status' => 400,
				'message' => 'Oops!! Invalid feedback inputs.'
			);
		}else{
			$response = addUserFeedback($user_id, $quality, $service, $request_id, $f_suggestion);
			if($response){
			    $response_data = array(
				    'api_status' => 200,
				    'message' => 'Feedback added successfully.'
				);
			}else{
				$response_data = array(
				    'api_status' => 400,
				    'message' => 'Oops!! Failed to add feedback.'
				);
			}
		}
	}

	$json_response_data = json_encode($response_data, JSON_PRETTY_PRINT);       
	echo $json_response_data;
	exit();

?>