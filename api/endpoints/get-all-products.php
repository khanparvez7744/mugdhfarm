<?php

	$response_data   = array(
	    'api_status' => 400
	);

	$error_code = 0;
	$products  = array();

	if($error_code == 0){
		$products     = Wo_GetAllProducts();
		$response_data = array(
	        'api_status' => 200,
	        'products' => $products,
	    );
	}else{
		$response_data = array(
	        'api_status' => 400,
	        'products' => $products,
	        'message' => 'Oops!! Invalid request',
	    );
	}

	$json_response_data = json_encode($response_data, JSON_PRETTY_PRINT);       
	echo $json_response_data;
	exit();

?>