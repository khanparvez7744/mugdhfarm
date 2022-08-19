<?php
	$response_data   = array(
	    'api_status' => 400
	);

	$error_code = 0; 
	$user_id               = Wo_UserIdFromSessionId($_POST['access_token']);
	if(!empty($user_id)){
		$popular_products = Wo_GetAllProducts();
		$categories = Wo_GetAllCategoryList();
		$slider = Wo_GetAllSliders();
		$response_data = array(
	        'api_status' => 200,
	        'popular_products' => $popular_products,
	        'categories' => $categories,
	        'slider' => $slider
	    );		
	}else{
		$response_data = array(
	        'api_status' => 400,
	        'message' => 'Invalid session..please login again',
	    );
	}

	$json_response_data = json_encode($response_data, JSON_PRETTY_PRINT);       
	echo $json_response_data;
	exit();

?>