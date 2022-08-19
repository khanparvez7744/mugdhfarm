<?php

	$response_data   = array(
	    'api_status' => 400
	);

	$error_code = 0;
	$categories  = array();

	if($error_code == 0){
		$categories     = Wo_GetAllCategoryList();
		$response_data = array(
	        'api_status' => 200,
	        'categories' => $categories
	    );
	}else{
		$response_data = array(
	        'api_status' => 400,
	        'categories' => $categories,
	        'message' => 'Oops!! Invalid request',
	    );
	}

	$json_response_data = json_encode($response_data, JSON_PRETTY_PRINT);       
	echo $json_response_data;
	exit();

?>