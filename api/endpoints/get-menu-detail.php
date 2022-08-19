<?php

	$response_data   = array(
	    'api_status' => 400
	);

	$error_code = 0;
	// suppose qr text = (qr_code/table_name) (5689741298/table_1)
	$qr_text     = isset($_POST['qr_text']) ? $_POST['qr_text'] : '';
	$qr_array    = explode('/', $qr_text);
	$qr_code 	 = $qr_array[1];
	$table_num 	 = $qr_array[2];
	$hotel_id    = 0;
	$menu_data   = array();


	if(empty($qr_text)){
		$error_code = 2;
		$response_data = array(
	        'api_status' => 401,
	        'message' => 'Oops!! Invalid qr. Please scan again',
	    );
	}
	elseif(Wo_IsQrExist($qr_code) == true && !empty($qr_array)){
		$hotel_id    = Wo_GetHotelId($qr_code, $table_num);
	}else{
		$error_code = 2;
		$response_data = array(
	        'api_status' => 401,
	        'message' => 'Oops!! Invalid qr. Please contact to admin',
	    );
	}
	
	if($error_code == 0){
		if(!empty($hotel_id) && (int)$hotel_id > 0){
			$menu_data     = Wo_GetMenuDetails($hotel_id);
			$fetch 		   = Wo_GetHotelData($hotel_id);

			$user_id        = Wo_UserIdFromSessionId($_GET['access_token']);
			$user_data 		= Wo_GetFromSession($_GET['access_token']);

			if(empty($user_data['request_id'])){
				$new_request_id = sha1(rand(1111, 9999)) . md5(microtime()) . rand(1111, 9999) . md5(rand(11, 99));
				$store = Wo_UpdateSessionData($new_request_id, $_GET['access_token'], $user_id);
			}else{
				$new_request_id = $user_data['request_id'];
			}

			$response_data = array(
		        'api_status' => 200,
		        'request_id' => $new_request_id,
		        'hotel_id' => $hotel_id,
		        'hotel_data' => $fetch,
		        'menu_data' => $menu_data,
		    );
		}else{
			$response_data = array(
		        'api_status' => 400,
		        'message' => 'Oops!! Invalid qr. Please contact to admin',
		    );
		}
	}

	

	$json_response_data = json_encode($response_data, JSON_PRETTY_PRINT);       
	echo $json_response_data;
	exit();

?>