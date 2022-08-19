<?php
ob_start();

	function Wo_ProductSize($product_id){
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
	function Wo_GetUserAllData($user_id){
		global $pdo;
		$statement = $pdo->prepare("SELECT * FROM tbl_user WHERE id=? LIMIT 1");
	    $statement->execute(array($user_id));
	    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
	    return $result;
	}
	function Wo_GetLastDeliveryAddress($user_id){
		global $pdo;
		$statement = $pdo->prepare("SELECT * FROM tbl_order WHERE user_id=? ORDER BY id DESC LIMIT 1");
	    $statement->execute(array($user_id));
	    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
	    return $result;
	}
	function Wo_GetUserCartData($user_id){
		global $pdo;
		$statement = $pdo->prepare("SELECT * FROM tbl_order WHERE user_id=? AND status=? ORDER BY id ASC");
	    $statement->execute(array($user_id, 'added_to_cart'));
	    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
	    return $result;
	}
	function Wo_ProductData($product_id){
		global $pdo;
		$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=? LIMIT 1");
	    $statement->execute(array($product_id));
	    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
	    return $result;
	}
	function Wo_ProductAttribute($request_id){
		global $pdo;
		$statement = $pdo->prepare("SELECT * FROM tbl_subscribed_order_date WHERE request_id=?");
	    $statement->execute(array($request_id));
	    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
	    return $result;
	}
	
	function Wo_SendSMS_RiddhiTech($sender,$msg,$templid){
	    $url = "http://103.225.76.43/sms/user/urlsms_json.php";
	    //$mobile=$sender;
	    $messageData= '{"data":[{"mobile":"'.$sender.'","message":"'.$msg.'"}]}';
	                        
	    $msgData = $messageData;//json_encode($messageData);
	    error_log($msgData);
	    $request ="";
	    $param[username] = "mugdhfarm";
	    $param[password] = "G3wL!_9t";
	    $param[senderid] = "MUGDHF";
	    $param[mtype] = "TXT";
	    $param[subdatatype] = "S";
	    $param[Response] = "Y";
	    $param[msgdata] = $msgData;
	    $param[dltentityid] = '110122940000054603';
	    $param[dltheaderid] = '1105162246353648455';
	    $param[dlttempid] = $templid;
	    foreach($param as $key=>$val) {
	        $request.= $key."=".urlencode($val);
	        $request.= "&";
	    }
	    $request = substr($request, 0, strlen($request)-1);
	    $ch = curl_init($url);
	       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	       curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
	       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $resp = curl_exec($ch);
	    error_log($resp);
	    if(curl_errno($ch))
	    {
	        $resp = '400';
	    }else{
	        $resp = '200';
	    }
	    curl_close($ch);
	    return $resp;
	}
	function Wo_prepare_pay_you_data($user_id,$amount){
	    
	    $MERCHANT_KEY = "uzCfH0ue";
	    $SALT = "GJRPbpDd34";
	    // Merchant Key and Salt as provided by Payu.

	    //$PAYU_BASE_URL = "https://sandboxsecure.payu.in";		// For Sandbox Mode
	    $PAYU_BASE_URL = "https://secure.payu.in";			// For Production Mode
	    
	    $action = '';
	    
	    $posted = array();
	    $_pay_txn_id = $user_id.rand(1111,9999);
	    $user_data = getUserDataById($user_id);
	    $cart_data = getUserCartData($user_id);
	    $_pay_user_name = $user_data[0]['full_name'];
	    $_pay_user_email = $user_data[0]['email'];
	    $_pay_user_phone = $user_data[0]['phone'];
	    $_pay_user_address = $user_data[0]['address'];
	    $_pay_service_provider = 'payu_paisa';
	    $_pay_prod_info = $cart_data[0]['product_id'];
	    $_pay_surl = "https://www.mugdhfarm.com/mugdha2/api/api.php?url=payment-success-payu-app";
	    $_pay_furl= "https://www.mugdhfarm.com/mugdha2/api/api.php?url=payment-failure-payu-app";
	    
	    $posted['key'] = $MERCHANT_KEY;
	    $posted['txnid'] = $_pay_txn_id;
	    $posted['amount'] = number_format($amount, 1);
	    $posted['firstname'] = explode(' ',$_pay_user_name)[0];
	    $posted['email'] = $_pay_user_email;
	    $posted['phone'] = $_pay_user_phone;
	    $posted['productinfo'] = $_pay_prod_info;
	    $posted['surl'] = $_pay_surl;
	    $posted['furl'] = $_pay_furl;
	    $posted['service_provider'] = $_pay_service_provider;
	    
	    $formError = 0;
	    
	    if(empty($posted['txnid'])) {
	        // Generate random transaction id
	        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
	    } else {
	        $txnid = $posted['txnid'];
	    }
	    $hash = '';
	    // Hash Sequence
	    $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
	    $hashVarsSeq = explode('|', $hashSequence);
	    $hash_string = '';
	    foreach($hashVarsSeq as $hash_var) {
	        $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
	        $hash_string .= '|';
	    }
	    
	    $hash_string .= $SALT;
	    error_log($hash_string);
	    
	    $hash = strtolower(hash('sha512', $hash_string));
	    $action = $PAYU_BASE_URL . '/_payment';

// 	    if(empty($posted['hash']) && sizeof($posted) > 0) {
// 	        if(
// 	            empty($posted['key'])
// 	            || empty($posted['txnid'])
// 	            || empty($posted['amount'])
// 	            || empty($posted['firstname'])
// 	            || empty($posted['email'])
// 	            || empty($posted['phone'])
// 	            || empty($posted['productinfo'])
// 	            || empty($posted['surl'])
// 	            || empty($posted['furl'])
// 	            || empty($posted['service_provider'])
// 	            ) {
// 	                $formError = 1;
// 	            } else {
// 	                //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
// 	                $hashVarsSeq = explode('|', $hashSequence);
// 	                $hash_string = '';
// 	                foreach($hashVarsSeq as $hash_var) {
// 	                    $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
// 	                    $hash_string .= '|';
// 	                }
	                
// 	                $hash_string .= $SALT;
	                
	                
// 	                $hash = strtolower(hash('sha512', $hash_string));
// 	                $action = $PAYU_BASE_URL . '/_payment';
// 	            }
// 	    } elseif(!empty($posted['hash'])) {
// 	        $hash = $posted['hash'];
// 	        $action = $PAYU_BASE_URL . '/_payment';
// 	    }
	    
	    $return_array = array();
	    $return_array['action']=$action;
	    $return_array['hash']=$hash;
	    $return_array['key']=$MERCHANT_KEY;
	    $return_array['txnid']=$txnid;
	    $return_array['data']=$posted;
	    return $return_array;
	    
	    
	}
	
	
?>