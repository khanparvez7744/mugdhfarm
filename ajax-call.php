<?php
	include('functions.php');
	include('function2.php');

	if(isset($_POST['action']) && $_POST['action'] == 'send_otp'){
		$mobile = $_POST['mobile'];
		$otp = $_POST['otp'];
		$message = '';
		$status = '400';
		$is_phone_exist = isPhoneNumberExist($mobile);
		if($is_phone_exist){
			try{
			    
				$templid  = '1507162393980433736';
				$msg = "OTP for Login Transaction on MugdhFarm is ".$otp." and valid till 10 minutes. Do not share this OTP to anyone for security reasons.";
				$sms_response = Wo_SendSMS_RiddhiTech($mobile,$msg,$templid);

				//Print error if any
				if($sms_response=='400')
				{
				   $message = 'Failed to send OTP. Resend OTP1';
					$status = '400';
				}else{
					$new_otp_status = sendNewOtp($mobile, $otp);
					$message = 'OTP sent successfully2';
					$status = '200';
				}

				curl_close($ch);

			}catch(Exception $e){
				$message = 'Failed to send OTP. Resend OTP2';
				$status = '400';
			}
			
		}else{
			try{
				$templid  = '1507162393980433736';
				$msg = "OTP for Login Transaction on MugdhFarm is ".$otp." and valid till 10 minutes. Do not share this OTP to anyone for security reasons.";
				//Prepare you post parameters
				$is_user_registered = registerNewUser($mobile, $otp);
				$sms_response = Wo_SendSMS_RiddhiTech($mobile,$msg,$templid);
				error_log('new user registration:',$is_user_registered);
				
				if($sms_response=='400')
				{
				   $message = 'Failed to send OTP. Resend OTP3';
					$status = '400';
				}else{
					//$is_user_registered = registerNewUser($mobile, $otp);
					if($is_user_registered){
						$message = 'OTP sent successfully5';
						$status = '200';
					}
				}

			}catch(Exception $e){
			    error_log($e);
				$message = 'Failed to send OTP. Resend OTP4';
				$status = '400';
			}			
		}

		header('Content-Type: application/json');
		echo json_encode(array("status"=>$status, "message" => $message));  
		exit;
	}
	if(isset($_POST['action']) && $_POST['action'] == 'send_dummy_otp'){
		$mobile = $_POST['mobile'];
		$otp = '123456';
		$message = '';
		$status = '400';
		$is_phone_exist = isPhoneNumberExist($mobile);
		if($is_phone_exist){
			$new_otp_status = sendNewOtp($mobile, $otp);
			$message = 'OTP sent successfully';
			$status = '200';			
		}else{
			$is_user_registered = registerNewUser($mobile, $otp);
			if($is_user_registered){
				$message = 'OTP sent successfully';
				$status = '200';
			}		
		}

		header('Content-Type: application/json');
		echo json_encode(array("status"=>$status, "message" => $message));  
		exit;
	}
	if(isset($_POST['action']) && $_POST['action'] == 'verify_otp'){
		$mobile = $_POST['mobile'];
		$otp = $_POST['otp'];
		$message = '';
		$status = '400';

		$is_phone_exist = isPhoneNumberExist($mobile);
		if($is_phone_exist){
			$loggedin_user_id = verifyNewUser($mobile, $otp);
			if($loggedin_user_id != false){
				$message = 'OTP matched successfully';
				$status = '200';
				$_SESSION["loggedin_userid"] = $loggedin_user_id;
				$_SESSION["loggedin_user_phone"] = $mobile;
			}else{
				$message = 'Invalid OTP';
			}			
		}else{
			$message = 'Phone number does not exist';
		}

		header('Content-Type: application/json');
		echo json_encode(array("status"=>$status, "message" => $message));  
		exit;
	}
	if(isset($_POST['action']) && $_POST['action'] == 'add_data_to_cart'){
		$mobile = $_POST['mobile'];
		$product_list = $_POST['product_list'];
		$pre_post = $_POST['pre_post'];
		$delivery_date = $_POST['delivery_date'];

		$message = '';
		$status = '400';
		$request_id = '';

		$is_order_placed = addDataToCart($mobile, $product_list, $pre_post, $delivery_date);
		if($is_order_placed){
			$message = 'Order added successfully';
			$status = '200';	
			$request_id = $is_order_placed;			
		}else{
			$message = 'Failed to add order';
		}

		header('Content-Type: application/json');
		echo json_encode(array("status"=>$status, "message" => $message, "request_id" => $request_id));  
		exit;
	}
	if(isset($_POST['action']) && $_POST['action'] == 'submit_address_form'){
		$searchAddress = $_POST['searchAddress'];
		$profile_name = $_POST['profile_name'];
		$profile_email = $_POST['profile_email'];
		$address1_house_num = $_POST['address1_house_num'];
		$address2_landmark = $_POST['address2_landmark'];

		$user_id = '';
		if(isset($_SESSION['loggedin_userid']) && isset($_SESSION['loggedin_user_phone'])){
            $user_id = $_SESSION['loggedin_userid'];
        }
		$message = '';
		$status = '400';

		if($user_id != ''){
			$is_order_placed = addAddressToOrder($user_id, $searchAddress, $address1_house_num, $address2_landmark);
			if($is_order_placed){
			    $update_data_arr = array(
					'full_name' => $profile_name, 
					'email' => $profile_email,
                    'address' => $searchAddress,
                    'house_number' => $address1_house_num,
                    'locality' => $address2_landmark
                );
                Wo_UpdateUserData($user_id, $update_data_arr);
				$message = 'Order added successfully';
				$status = '200';
			}else{
				$message = 'Failed to add order';
			}
		}
 
		header('Content-Type: application/json');
		echo json_encode(array("status"=>$status, "message" => $message));  
		exit;
	}
	// if(isset($_POST['action']) && $_POST['action'] == 'display_payment_form'){
	// 	$searchAddress = $_POST['searchAddress'];
	// 	$request_id = $_POST['request_id'];

	// 	$user_id = '';
	// 	$mobile = '';
	// 	if(isset($_SESSION['loggedin_userid']) && isset($_SESSION['loggedin_user_phone'])){
 //            $user_id = $_SESSION['loggedin_userid'];
 //            $mobile = $_SESSION['loggedin_user_phone'];
 //        }
	// 	$message = '';
	// 	$status = '400';
	// 	$html = '';

	// 	$user_data = getUserDataByPhone($mobile);
	// 	$total_cost = 0;
	// 	$payment_mode = '';

	// 	$user_cart_data = getCartData($request_id);
	// 	if($user_cart_data){
	// 		$message = 'Order added successfully';
	// 		$status = '200';
	// 		$html .= '
	// 			<div class="col-12 col-sm-12 col-md-12">
	// 			    <div>
	// 			        <div class="product">Delivery Address</div>
	// 			        <p id="cart-address">'.$searchAddress.'</p>
	// 			    </div>
	// 			    <div style="display: grid;">
	// 			        <table border="0" cellpadding="0" cellspacing="0" class="cart-table">
	// 			            <tbody>
	// 			                <tr class="cart-table-header-row">
	// 			                    <th class="product">Order Summary</th>
	// 			                    <th></th>
	// 			                    <th></th>
	// 			                </tr>
	// 			                <tr class="active">
	// 			                    <th style="width: 70%;">Product Name</th>
	// 			                    <th style="width: 10%; text-align: center;">Mrp</th>
	// 			                    <th style="width: 10%; text-align: center;">Qty</th>
	// 			                    <th style="width: 10%; text-align: center;">Amt</th>
	// 			                </tr>
	// 		';
	// 		foreach ($user_cart_data as $key => $value) {
	// 			$product_details = getProductDetailByID($value['product_id']);
	// 			$total_cost += $product_details[0]['p_current_price']*$value['quantity'];
	// 			$payment_mode = $value['pre_post'];
	// 			$html .= '
	// 				<tr class="cart-table-content-row">
	//                     <td style="width: 70%;">'.$product_details[0]['p_name'].'</td>
	//                     <div>
	//                         <td style="width: 10%; text-align: center;"><del>₹'.$product_details[0]['p_old_price'].'</del> ₹'.$product_details[0]['p_current_price'].'</td>
	//                     </div>
	//                     <td style="width: 10%; text-align: center;">'.$value['quantity'].'</td>
	//                     <div>
	//                         <td style="width: 10%; text-align: center;">₹'.$product_details[0]['p_current_price']*$value['quantity'].'</td>
	//                     </div>
	//                 </tr>
	// 			';
	// 		}
	// 		$payement_msg = '';
	// 		$btn_text = 'Place Order';
	// 		if((int)$user_data[0]['wallet'] < (int)$total_cost){
	// 			$remain_ammount = (int)$total_cost - (int)$user_data[0]['wallet'];
	// 			$payement_msg1 = '<p>Insufficient balance in your wallet, continue to add ₹'.$remain_ammount.' in your wallet</p>';
	// 			$payement_msg = '
	// 					<div id="payment-method" class="row">
	// 				        <div class="col-12 col-sm-12 col-md-12">
	// 				            <div class="wallet-msg">
	// 				                '.$payement_msg1.'
	// 				            </div>
	// 				            <fieldset class="form-group payment-mode" id="__BVID__45">
	// 				                <div tabindex="-1" role="group" class="bv-no-focus-ring">
	// 				                    <div class="payment-mode-options custom-control custom-radio"><input type="radio" name="some-radios" autocomplete="off" class="custom-control-input" value="2" id="__BVID__46"><label class="custom-control-label" for="__BVID__46">Credit or Debit Card/Net Banking</label></div>
	// 				                    <div class="payment-mode-options custom-control custom-radio"><input type="radio" name="some-radios" autocomplete="off" class="custom-control-input" value="1" id="__BVID__47"><label class="custom-control-label" for="__BVID__47">Paytm Wallet / UPI</label></div>
	// 				                </div>
	// 				            </fieldset>
	// 				        </div>
	// 				    </div>
	// 			';
	// 			$btn_text = 'Add ₹ '.$remain_ammount.' &amp; Continue';
	// 		}
	// 		$html .= '
	// 								<tr class="cart-table-footer-row">
	// 			                    <td style="width: 70%;"><b>Order Total</b></td>
	// 			                    <td style="width: 10%; text-align: center;"></td>
	// 			                    <td style="width: 10%; text-align: center;"></td>
	// 			                    <td style="width: 10%; text-align: center;"><b>₹'.$total_cost.'</b></td>
	// 			                </tr>
	// 			            </tbody>
	// 			        </table>
	// 			    </div>
	// 			    <div class="row">
	// 			        <div class="col-12 col-sm-12 col-md-12">
	// 			        	<div class="coupon-applied-msg" id="order_res_msg">
	// 			            </div>
	// 			            <div class="coupon-applied-msg">
	// 			            </div>
	// 			        </div>
	// 			        <div class="col-5 col-sm-6 col-md-6">
	// 			            <div class="product payment-mode">Payment Mode</div>
	// 			        </div>
	// 			        <div class="col-5 col-sm-6 col-md-6 mod-bal-float-right" style="text-align:right;">
	// 			            <div id="subscription-type" class="product sub-type">'.$payment_mode.'</div>
	// 			        </div>
	// 			    </div>
	// 			    <div id="wallet-balance" class="row ">
	// 			        <div class="col-5 col-sm-6 col-md-6">
	// 			            <div class="product">Wallet Balance</div>
	// 			        </div>
	// 			        <div class="col-5 col-sm-6 col-md-6 mod-bal-float-right" style="text-align:right;">
	// 			            <div id="wallet-balanace" class="product">₹'.$user_data[0]['wallet'].' </div>
	// 			        </div>
	// 			    </div>
	// 			    '.$payement_msg.'				    
	// 			    <div class="row">
	// 			        <div class="col align-self-center">
	// 			            <div id="add-and-continue" fxlayoutalign="center center" class="dv-btn dv-btn-addon"> 
	// 			                <button mat-raised-button="" class="mat-raised-button btn btn-info btn-round btn-lg btn-block dv-primary-btn" onclick="PlaceUserOrder('.$user_data[0]['wallet'].', '.$total_cost.')" id="add-and-continue-button">
	// 			                    <span class="mat-button-wrapper">'.$btn_text.'</span>
	// 			                    <div matripple="" class="mat-button-ripple mat-ripple"></div>
	// 			                    <div class="mat-button-focus-overlay"></div>
	// 			                </button>
	// 			            </div>
	// 			        </div>
	// 			    </div>
	// 			</div>
	// 		';	
	// 	}else{
	// 		$message = 'Failed to get details';
	// 	}

	// 	header('Content-Type: application/json');
	// 	echo json_encode(array("status"=>$status, "message" => $message, "html_text" => $html));  
	// 	exit();
	// }
	if(isset($_POST['action']) && $_POST['action'] == 'place_user_order'){
		$user_id = '';
		if(isset($_SESSION['loggedin_userid']) && isset($_SESSION['loggedin_user_phone'])){
            $user_id = $_SESSION['loggedin_userid'];
        }
		$message = '';
		$status = '400';
		$coupan = $_POST['coupan'];

		if($user_id != ''){
			$is_order_placed = placeUserOrder($user_id, $coupan);
			if($is_order_placed){
				unset($_SESSION['cart_p_id']);
				unset($_SESSION['cart_p_mode']);
				unset($_SESSION['cart_p_product_qty']);
				
				unset($_SESSION['subs_cart_p_id']);
				unset($_SESSION['subs_cart_p_mode']);
				unset($_SESSION['subs_cartschedule_type']);
				unset($_SESSION['subs_cart_p_product_qty']);
				unset($_SESSION['subs_cartdelivery_start_date']);
				unset($_SESSION['subs_cartaltdays']);
				unset($_SESSION['subs_customiseMquant']);
				unset($_SESSION['subs_customiseTquant']);
				unset($_SESSION['subs_customiseWquant']);
				unset($_SESSION['subs_customiseTHquant']);
				unset($_SESSION['subs_customiseFquant']);
				unset($_SESSION['subs_customiseSATquant']);
				unset($_SESSION['subs_customiseSUNquant']);
				$message = 'Order placed successfully';
				$status = '200';	
			}else{
				$message = 'Failed to placed order';
			}
		}

		header('Content-Type: application/json');
		echo json_encode(array("status"=>$status, "message" => $message));  
		exit();
	}
	
	if(isset($_POST['action']) && $_POST['action'] == 'add_pyment_to_wallet'){
	    $user_id = '';
	    if(isset($_SESSION['loggedin_userid']) && isset($_SESSION['loggedin_user_phone'])){
	        $user_id = $_SESSION['loggedin_userid'];
	    }
	    error_log($_POST['amount']);
	    if(isset($_POST['amount'])){
	        $_amount =  $_POST['amount'];
	    }else{
	        $_amount = 0;
	    }
	    error_log($_amount);
	    $message = '';
	    $status = '400';
	    $coupan = $_POST['coupan'];
	    
	    if($user_id != ''){
	        $_pre_pament_data = Wo_prepare_pay_you_data($user_id,$_amount);
	        //$is_order_placed = placeUserOrder($user_id, $coupan);
	        if($_pre_pament_data){
// 	            unset($_SESSION['cart_p_id']);
// 	            unset($_SESSION['cart_p_mode']);
// 	            unset($_SESSION['cart_p_product_qty']);
	            
// 	            unset($_SESSION['subs_cart_p_id']);
// 	            unset($_SESSION['subs_cart_p_mode']);
// 	            unset($_SESSION['subs_cartschedule_type']);
// 	            unset($_SESSION['subs_cart_p_product_qty']);
// 	            unset($_SESSION['subs_cartdelivery_start_date']);
// 	            unset($_SESSION['subs_cartaltdays']);
// 	            unset($_SESSION['subs_customiseMquant']);
// 	            unset($_SESSION['subs_customiseTquant']);
// 	            unset($_SESSION['subs_customiseWquant']);
// 	            unset($_SESSION['subs_customiseTHquant']);
// 	            unset($_SESSION['subs_customiseFquant']);
// 	            unset($_SESSION['subs_customiseSATquant']);
// 	            unset($_SESSION['subs_customiseSUNquant']);
// 	            $message = 'Order placed successfully';
	            $_data = $_pre_pament_data;
	            $status = '200';
	        }else{
	            $message = 'Failed to placed order';
	        }
	    }
	    error_log(print_r( $_data, true ));
	    header('Content-Type: application/json');
	    echo json_encode(array("status"=>$status, "message" => $message,"data"=> $_data));
	    exit();
	}
	
	if(isset($_POST['action']) && $_POST['action'] == 'fetch_user_data'){
		$mobile = $_POST['mobile'];
		$message = '';
		$status = '400';
		$user_data = getUserDataByPhone($mobile);
		if($user_data){
			$message = 'Success!!';
			$status = '200';	
			$user_data = $user_data[0];		
		}

		header('Content-Type: application/json');
		echo json_encode(array("status"=>$status, "message" => $message, "user_data" => $user_data));  
		exit;
	}
// 	if(isset($_POST['action']) && $_POST['action'] == 'increase_decrease_quantity'){
// 		$key = $_POST['key'];
// 		$exampleInputQuantity = $_POST['exampleInputQuantity'];
// 		if($exampleInputQuantity>0)
// 		{
// 		$message = 'Success';
// 	    $_SESSION['cart_p_product_qty'][$key] = $exampleInputQuantity;
// 		}
// 		header('Content-Type: application/json');
// 		echo json_encode(array("status"=>200, "message" => $message));  
// 		exit;
// 	}
    //  quanatity inc dec by dk
	if(isset($_POST['action']) && $_POST['action'] == 'inc_dec_quantity'){
		$key = $_POST['key'];
		$value = $_POST['value'];
		$p_id = $_POST['id'];
		$_SESSION['cart_p_product_qty'][$key] = $value;
		$product_details = Wo_ProductData($p_id)[0];
		$p_price=$value*$product_details['p_current_price'];
		$message = 'Success';
		$arr_cart_p_id = array();
		$arr_cart_p_product_qty = array();
                        if(isset($_SESSION['cart_p_id'])){
                          $i=0;
                          foreach($_SESSION['cart_p_id'] as $value) 
                          {
                              $i++;
                              $arr_cart_p_id[$i] = $value;
                          }
                          $i=0;
                          foreach($_SESSION['cart_p_product_qty'] as $value) 
                          {
                              $i++;
                              $arr_cart_p_product_qty[$i] = $value;
                          }
                        }
		
	   $subs_cart_p_id = array();
	   $subs_cart_p_product_qty = array();
	   $subs_customiseMquant = array();
	   $subs_cartschedule_type = array();
	   if(isset($_SESSION['subs_cart_p_id'])){
                          $i=0;
                          foreach($_SESSION['subs_cart_p_id'] as $value) 
                          {
                              $i++;
                              $subs_cart_p_id[$i] = $value;
                          }
                        $i=0;
                          foreach($_SESSION['subs_cart_p_product_qty'] as $value) 
                          {
                              $i++;
                              $subs_cart_p_product_qty[$i] = $value;
                          }  
                          $i=0;
                          foreach($_SESSION['subs_customiseMquant'] as $value) 
                          {
                              $i++;
                              $subs_customiseMquant[$i] = $value;
                          }
                          $i=0;
                          foreach($_SESSION['subs_cartschedule_type'] as $value) 
                          {
                              $i++;
                              $subs_cartschedule_type[$i] = $value;
                          }
	   }
	   
	   //calculating total cost
	   $total_cost = 0;
                              foreach($arr_cart_p_id as $key => $value) 
                              {
                                $product_details = Wo_ProductData($value)[0];
                                if($product_details){
                                  $total_cost += $arr_cart_p_product_qty[$key] * $product_details['p_current_price'];
                                }
                              }
                              foreach($subs_cart_p_id as $key => $value) 
                              {
                                $product_details = Wo_ProductData($value)[0];
                                if($product_details){
                                if($subs_cartschedule_type[$key] == 'everyday'){
                                  $total_cost += $subs_cart_p_product_qty[$key][1] * $product_details['p_current_price'];
                                    }
                                if($subs_cartschedule_type[$key] == 'alternate'){
                                  $total_cost += $subs_cart_p_product_qty[$key][1] * $product_details['p_current_price'];
                                    }
                                if($subs_cartschedule_type[$key] == 'customise'){
                                  $total_cost += $subs_customiseMquant[$key][1] * $product_details['p_current_price'];
                                    }    
                                }
                              }
		$send=array($p_price,$total_cost);              
	   echo json_encode($send);
	}
// cart added update
	if(isset($_POST['cart_trigger'])){
	    if(isset($_SESSION['cart_p_id']) || isset($_SESSION['subs_cart_p_id'])) {
									$i=0;
									if(isset($_SESSION['cart_p_id'])){
										foreach($_SESSION['cart_p_id'] as $key => $value)
					                    {
					                        $i++;
					                    }
									}				                    
				                    if(isset($_SESSION['subs_cart_p_id'])){
				                    	foreach($_SESSION['subs_cart_p_id'] as $key => $value)
					                    {
					                        $i++;
					                    }
				                    }
				                    echo $i;
								}
	}
// 	*************!dk*******************
	if(isset($_POST['action']) && $_POST['action'] == 'verify_coupan_code'){
		$coupan_code_area = $_POST['coupan_code_area'];
		$user_id = $_SESSION['loggedin_userid'];
		$message = '';
		$status = 400;
		$is_valid = isCoupanValid($user_id, $coupan_code_area);
		if($is_valid){
			$message = 'Success!!';
			$status = 200;	
		}

		header('Content-Type: application/json');
		echo json_encode(array("status"=>$status, "message" => $message, "discount" => $is_valid));  
		exit;
	}
?>