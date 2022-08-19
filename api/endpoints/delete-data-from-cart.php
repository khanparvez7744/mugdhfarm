<?php

	$response_data   = array( 
	    'api_status' => 400 
	);

	$required_fields = array(
		'id'
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
		$id      		= isset($_POST['id']) ? $_POST['id'] : '';
		$response    	= Wo_DeleteCartData($id, $user_id);
		if($response){
		    $response_data = array(
			    'api_status' => 200,
			    'message' => 'product deleted successfully.'
			);
		}else{
			$response_data = array(
			    'api_status' => 400,
			    'message' => 'Oops!! Failed to delete product.'
			);
		}
	}

	$json_response_data = json_encode($response_data, JSON_PRETTY_PRINT);       
	echo $json_response_data;
	exit();

?>