<?php

	$response_data   = array(
	    'api_status' => 400
	);

	$error_code = 0;
	$products  = array();

	$category_id     = isset($_POST['category_id']) ? $_POST['category_id'] : '';

	if(empty($category_id)){
		$error_code = 2;
		$response_data = array(
	        'api_status' => 401,
	        'message' => 'Oops!! Invalid category id.',
	    );
	}

	if($error_code == 0){
		if($error_code == 0){
			$products     = Wo_GetProductFromCategory($category_id);
			$all_product  = Wo_GetAllProductFromCategory($category_id); 
			$response_data = array(
		        'api_status' => 200,
		        'all_product' => $all_product,
		        'products' => $products,
		    );
		}
	}else{
		$response_data = array(
	        'api_status' => 400,
	        'message' => 'Oops!! Invalid category id',
	    );
	}

	$json_response_data = json_encode($response_data, JSON_PRETTY_PRINT);       
	echo $json_response_data;
	exit();

?>