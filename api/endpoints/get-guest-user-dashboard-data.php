<?php
    header("Content-Type:application/json");
	$response_data   = array(
	    'api_status' => 400
	);
	$error_code = 0;
	
		$popular_products = Wo_GetAllProducts();
		$categories = Wo_GetAllCategoryList();
		$slider = Wo_GetAllSliders();
		$response_data = array(
	        'api_status' => 200,
	        'popular_products' => $popular_products,
	        'categories' => $categories,
	        'slider' => $slider
	    );
	    //var_dump($response_data);
	$json_response_data = json_encode($response_data, JSON_PRETTY_PRINT);       
	echo $json_response_data;
	exit();

?>