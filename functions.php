<?php
ob_start();
session_start();
include("admin/inc/config.php");
//include 'function2.php';


	function isPhoneNumberExist($phone){
		global $pdo;
		$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE phone=? LIMIT 1");
	    $statement->execute(array($phone));                         
	    $total_pages = $statement->rowCount();
	    if($total_pages > 0){
	    	return true;
	    }else{
	    	return false;
	    }
	}
	function getUserDataByPhone($phone){
		global $pdo;
		$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE phone=? LIMIT 1");
	    $statement->execute(array($phone));                         
	    $total_pages = $statement->rowCount();
	    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
	    return $result;
	}
	function getUserDataById($user_id){
		global $pdo;
		$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE id=? LIMIT 1");
	    $statement->execute(array($user_id));                         
	    $total_pages = $statement->rowCount();
	    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
	    return $result;
	}
	function getProductDetailByID($product_id){
		global $pdo;
		$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=? LIMIT 1");
	    $statement->execute(array($product_id));                         
	    $total_pages = $statement->rowCount();
	    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
	    return $result;
	}
	function registerNewUser($phone, $otp){
		global $pdo;
		$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE phone=? LIMIT 1");
	    $statement->execute(array($phone));                         
	    $total_pages = $statement->rowCount();
	    $random_string = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 5).rand(1111,9999);
	    if($total_pages == 0){
	    	$date = date('Y-m-d H:i:s');
	    	$statement = $pdo->prepare("INSERT INTO tbl_user (
	                            phone,
	                            role,
	                            otp,
	                            personal_referral_code,
	                            created_at,
	                            status
	                        ) VALUES (?,?,?,?,?,?)");
	    	$statement->execute(array(
	                            $phone,
	                            'User',
	                            $otp,
	                            $random_string,
	                            $date,
	                            'Inactive'
	                        ));

	    	return true;

	    }
	    return false;
	}
	function sendNewOtp($phone, $otp){
		global $pdo;
		$statement = $pdo->prepare("UPDATE tbl_user SET otp=? WHERE phone=?");
        $statement->execute(array($otp, $phone));
	    return true;
	}
	function verifyNewUser($phone, $otp){
		global $pdo;
		$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE phone=? AND otp=? LIMIT 1");
	    $statement->execute(array($phone, $otp));                         
	    $total_pages = $statement->rowCount();
	    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
	    $user_id = '';
	    if($total_pages > 0){
	    	$statement = $pdo->prepare("UPDATE tbl_user SET status=? WHERE phone=? AND otp=?");
            $statement->execute(array('Active',$phone, $otp));
            foreach ($result as $row)
		    {
		        $user_id = $row['id'];
		    }
	    	return $user_id;
	    }
	    return false;
	}
	function addDataToCart($mobile, $product_list, $pre_post, $delivery_date){
		global $pdo;
			
		$user_data = getUserDataByPhone($mobile);
		$user_id = $user_data[0]['id'];

		$date = date('Y-m-d H:i:s');
		$request_id = time().mt_rand();

		$my_arr = explode(',', $product_list);
		$second_array = array_unique($my_arr);

		$statement1 = $pdo->prepare("DELETE FROM tbl_order WHERE user_id=? AND status=?");
		$statement1->execute(array($user_id, 'added_to_cart'));

		foreach ($second_array as $product_id){
			if($product_id != ''){
				$quantity = substr_count($product_list, $product_id);
				$product_data = getProductDetailByID($product_id);
				$product_size = Wo_GetProductSize($product_id);
		    	$statement = $pdo->prepare("INSERT INTO tbl_order (
	    						request_id,
	                            product_id,
	                            product_name,
								size,
								unit_price,
	                            quantity,
	                            delivery_date,
	                            pre_post,
	                            user_id,
	                            status,
	                            updated_at,
	                            created_at
	                        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
	    		$statement->execute(array(
	                            $request_id,
	                            $product_id,
	                            $product_data[0]['p_name'],
	                            $product_size[0]['size_name'],
	                            $product_data[0]['p_current_price'],
	                            $quantity,
	                            $delivery_date,
	                            $pre_post,
	                            $user_id,
	                            'added_to_cart',
	                            $date,
	                            $date
	                        ));
			}
		    
		}	    	

	    return $request_id;
	}
	function addAddressToOrder($user_id, $searchAddress, $address1_house_num, $address2_landmark){
		global $pdo;
 
		$statement = $pdo->prepare("UPDATE tbl_order SET delivery_address=?, house_number=?, landmark=? WHERE user_id=? AND status=?");
        $statement->execute(array($searchAddress, $address1_house_num, $address2_landmark,$user_id,'added_to_cart'));

	    return true;
	}
	function getCartData($request_id){ 
		global $pdo;
		$statement = $pdo->prepare("SELECT * FROM tbl_order WHERE request_id=?");
	    $statement->execute(array($request_id));                         
	    $total_pages = $statement->rowCount();
	    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
	    return $result;
	}
	function getUserCartData($user_id){
		global $pdo;
		$statement = $pdo->prepare("SELECT * FROM tbl_order WHERE user_id=? AND status=?");
	    $statement->execute(array($user_id, 'added_to_cart'));                         
	    $total_pages = $statement->rowCount();
	    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
	    return $result;
	}
	function placeUserOrder($user_id, $coupan,$payment_id=NULL){
		global $pdo;
		$user_data = getUserDataById($user_id);
		$cart_data = getUserCartData($user_id);
		$total_cost = 0;
		$date = date('Y-m-d H:i:s');
		if($payment_id==NULL){
		  $payment_id = $user_id.rand(1111,9999);
		}
		$payment_method_type = '';
		$delivery_date   =   '';
		$request_id = '';

		if(isset($cart_data) && isset($user_data)){
			$wallet_balance = $user_data[0]['wallet'];
			foreach ($cart_data as $key => $value){
				$product_details = getProductDetailByID($value['product_id']);
				
				if($value['pre_post'] == 'Buy Once'){
					$total_cost += $product_details[0]['p_current_price']*$value['quantity'];
					$payment_method_type = 'Buy Once';
				}

				if($value['pre_post'] == 'Subscription'){
						$current_request_id = $value['request_id'];
					    $statement = $pdo->prepare("INSERT INTO tbl_subscribed_order SELECT * FROM tbl_order WHERE user_id=? AND pre_post=? AND status=?");
					    $statement->execute(array($user_id, 'Subscription', 'added_to_cart'));

					    $statement1 = $pdo->prepare("UPDATE tbl_subscribed_order SET status=? WHERE user_id=? AND pre_post=? AND status=?");
				        $statement1->execute(array('subscribed', $user_id, 'Subscription', 'added_to_cart'));

				        $statement3 = $pdo->prepare("UPDATE tbl_subscribed_order_date SET is_active=? WHERE request_id=?");
				        $statement3->execute(array('1', $current_request_id));

				        $statement2 = $pdo->prepare("DELETE FROM tbl_order WHERE user_id=? AND pre_post=? AND status=?");
						$statement2->execute(array($user_id, 'Subscription', 'added_to_cart'));
				}
			}
			if($payment_method_type == 'Buy Once'){
				if((int)$total_cost <= (int)$wallet_balance){
					$discount_amount = ((int)$total_cost * (int)$coupan) / 100;
					if($discount_amount > 100){
						$discount_amount = 100;
					}
					$final_amount = (int)$total_cost - (int)$discount_amount;
					$remaining_balance = (int)$wallet_balance - (int)$final_amount;
					$statement = $pdo->prepare("INSERT INTO tbl_payment (
		    						customer_id,
		    						customer_name,
		    						customer_email,
		                            payment_date,
		                            coupan_code,
		                            total_amount,
		                            wallet_amount,
		                            paid_amount,
		                            payment_method,
		                            payment_status,
		                            shipping_status,
		                            payment_id
		                        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
		    		$statement->execute(array(
		                            $user_id,
		                            $user_data[0]['full_name'],
		                            $user_data[0]['email'],
		                            $date,
		                            $discount_amount,
		                            $total_cost,
		                            $final_amount,
		                            $final_amount,
		                            'wallet',
		                            'Completed',
		                            'order_placed',
		                            $payment_id
		                        ));
					$statement1 = $pdo->prepare("UPDATE tbl_order SET status=?, payment_id=? WHERE user_id=? AND status=?");
			        $statement1->execute(array('order_placed', $payment_id, $user_id, 'added_to_cart'));

			        $statement2 = $pdo->prepare("UPDATE tbl_user SET wallet=? WHERE id=?");
			        $statement2->execute(array($remaining_balance, $user_id));

			        updateWalletHistory($user_id, $final_amount, 'debit', $payment_id);
				    return true;
				}
			}		
			
			return true;
		}

		return false;
		
	}
	function updateWalletHistory($user_id, $amount, $transaction_type, $payment_id){
		global $pdo;
		$date = date('Y-m-d H:i:s');
		$statement = $pdo->prepare("INSERT INTO tbl_wallet_history (
								user_id,
								amount,
								transaction_type,
								payment_id,
								created_at
	                        ) VALUES (?,?,?,?,?)");
	    	$statement->execute(array(
	                            $user_id,
	                            $amount,
	                            $transaction_type,
	                            $payment_id,
	                            $date
	                        ));

	    	return true;
	}
	function Wo_UpdateUserData($user_id, $update_data) {
	    global $pdo;   
	    
	    $update = array();
	    foreach ($update_data as $field => $data) {
	        $update[] = '`' . $field . '` = \'' . $data . '\'';
	    }
	    $impload   = implode(', ', $update);
	    
	    $statement1 = $pdo->prepare("UPDATE tbl_user SET {$impload} WHERE id={$user_id}");
		$statement1->execute();

		return true;
	}
	function Wo_GetProductSize($product_id){
		global $pdo;
		$statement = $pdo->prepare("SELECT * FROM tbl_product_size WHERE p_id=? LIMIT 1");
	    $statement->execute(array($product_id));
	    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
	    $size_id = $result[0]['size_id'];
	    $statement = $pdo->prepare("SELECT * FROM tbl_size WHERE size_id=? LIMIT 1");
	    $statement->execute(array($size_id));
	    $result2 = $statement->fetchAll(PDO::FETCH_ASSOC);
	    return $result2;
	}
	function isCoupanValid($user_id, $coupan_code_area){
		global $pdo;
		$statement = $pdo->prepare("SELECT * FROM tbl_coupan WHERE coupan_name=? LIMIT 1");
	    $statement->execute(array($coupan_code_area));
	    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
	    $coupan_count = $statement->rowCount();
	    if($coupan_count > 0){
	    	$coupan_id = $result[0]['id'];

		    $statement = $pdo->prepare("SELECT * FROM tbl_user_coupan WHERE coupan_id=? AND user_id=? LIMIT 1");
		    $statement->execute(array($coupan_id, $user_id));
		    $total_pages = $statement->rowCount();
		    if($total_pages > 0){
		    	return $result[0]['coupan_value'];
		    }
	    }

	    return false;
	}
?>