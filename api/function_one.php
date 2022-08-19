<?php

include "../function2.php";

  function validateKey($server_key){
  	global $conn;
  	$key = '';
  	$sql = "SELECT * FROM `tbl_settings` WHERE `id` = '1'";
  	$result = mysqli_query($conn, $sql);
  	if($result){
  		$row = mysqli_fetch_assoc($result);
  		$key = $row['server_key'];
  		if($server_key == $key){
  			return true;
  		}else{
  			return false;
  		}
  	}else{
  		return false;
  	}
  }
  function Wo_Secure($string, $censored_words = 1, $br = true, $strip = 0) {
      global $conn;
      $string = trim($string);
      $string = cleanString($string);
      $string = mysqli_real_escape_string($conn, $string);
      $string = htmlspecialchars($string, ENT_QUOTES);
      if ($br == true) {
          $string = str_replace('\r\n', " <br>", $string);
          $string = str_replace('\n\r', " <br>", $string);
          $string = str_replace('\r', " <br>", $string);
          $string = str_replace('\n', " <br>", $string);
      } else {
          $string = str_replace('\r\n', "", $string);
          $string = str_replace('\n\r', "", $string);
          $string = str_replace('\r', "", $string);
          $string = str_replace('\n', "", $string);
      }
      if ($strip == 1) {
          $string = stripslashes($string);
      }
      $string = str_replace('&amp;#', '&#', $string);
      return $string;
  }
  function cleanString($string) {
    return $string = preg_replace("/&#?[a-z0-9]+;/i", "", $string); 
  }
  function Wo_UserIdForLogin($phone) {
      global $conn;
      if (empty($phone)) {
          return false;
      }
      $phone 	  = Wo_Secure($phone);
      $query    = mysqli_query($conn, "SELECT `id` FROM `tbl_user` WHERE `phone` = '{$phone}'");
      return Wo_Sql_Result($query, 0, 'id');
  }
  function Wo_Sql_Result($res, $row = 0, $col = 0) {
      $numrows = mysqli_num_rows($res);
      if ($numrows && $row <= ($numrows - 1) && $row >= 0) {
          mysqli_data_seek($res, $row);
          $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
          if (isset($resrow[$col])) {
              return $resrow[$col];
          }
      }
      return false;
  }
  function Wo_VerifyOTP($phone, $otp) {
      global $conn;
      if (empty($phone) || empty($otp)) {
          return false;
      }
      $phone            = Wo_Secure($phone);
      $otp              = Wo_Secure($otp);

      $query          = mysqli_query($conn, "SELECT COUNT(`id`) FROM `tbl_user` WHERE (`phone` = '{$phone}') AND `otp` = '{$otp}'");
      if (Wo_Sql_Result($query, 0) == 1) {
          return true;
      }
      return false;
  }
  function Wo_CreateLoginSession($user_id = 0, $platform = 'phone') {
      global $conn;
      if (empty($user_id)) {
          return false;
      }
      $user_id   = Wo_Secure($user_id);
      $hash      = sha1(rand(111111111, 999999999)) . md5(microtime()) . rand(11111111, 99999999) . md5(rand(5555, 9999));
      $query_one = mysqli_query($conn, "DELETE FROM `tbl_appssessions` WHERE `session_id` = '{$hash}'");
      $query_two = mysqli_query($conn, "DELETE FROM `tbl_appssessions` WHERE `user_id` = '{$user_id}' AND `platform` = '{$platform}'");
      if ($query_one) {
          $ua = serialize(getBrowser());
          $query_three = mysqli_query($conn, "INSERT INTO `tbl_appssessions` (`user_id`, `session_id`, `platform`, `platform_details`, `time`) VALUES('{$user_id}', '{$hash}', '{$platform}', '{$ua}'," . time() . ")");
          if ($query_three) {
              return $hash;
          }
      }
  }
  function getBrowser() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";
        $ub = "";
        // First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
          $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
          $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
          $platform = 'windows';
        } elseif (preg_match('/iphone|IPhone/i', $u_agent)) {
          $platform = 'IPhone Web';
        } elseif (preg_match('/android|Android/i', $u_agent)) {
          $platform = 'Android Web';
        } else if (preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $u_agent)) {
          $platform = 'Mobile';
        }
        // Next get the name of the useragent yes seperately and for good reason
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) {
          $bname = 'Internet Explorer';
          $ub = "MSIE";
        } elseif(preg_match('/Firefox/i',$u_agent)) {
          $bname = 'Mozilla Firefox';
          $ub = "Firefox";
        } elseif(preg_match('/Chrome/i',$u_agent)) {
          $bname = 'Google Chrome';
          $ub = "Chrome";
        } elseif(preg_match('/Safari/i',$u_agent)) {
          $bname = 'Apple Safari';
          $ub = "Safari";
        } elseif(preg_match('/Opera/i',$u_agent)) {
          $bname = 'Opera';
          $ub = "Opera";
        } elseif(preg_match('/Netscape/i',$u_agent)) {
          $bname = 'Netscape';
          $ub = "Netscape";
        }
        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
          // we have no matching number just continue
        }
        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
          //we will have two since we are not using 'other' argument yet
          //see if version is before or after the name
          if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
          } else {
            $version= $matches['version'][1];
          }
        } else {
          $version= $matches['version'][0];
        }
        // check if we have a number
        if ($version==null || $version=="") {$version="?";}
        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern,
            'ip_address' => get_ip_address()
        );
  }
  function get_ip_address() {
      if (!empty($_SERVER['HTTP_X_FORWARDED']) && validate_ip($_SERVER['HTTP_X_FORWARDED']))
          return $_SERVER['HTTP_X_FORWARDED'];
      if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
          return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
      if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
          return $_SERVER['HTTP_FORWARDED_FOR'];
      if (!empty($_SERVER['HTTP_FORWARDED']) && validate_ip($_SERVER['HTTP_FORWARDED']))
          return $_SERVER['HTTP_FORWARDED'];
      return $_SERVER['REMOTE_ADDR'];
  }
  function validate_ip($ip) {
      if (strtolower($ip) === 'unknown')
          return false;
      $ip = ip2long($ip);
      if ($ip !== false && $ip !== -1) {
          $ip = sprintf('%u', $ip);
          if ($ip >= 0 && $ip <= 50331647)
              return false;
          if ($ip >= 167772160 && $ip <= 184549375)
              return false;
          if ($ip >= 2130706432 && $ip <= 2147483647)
              return false;
          if ($ip >= 2851995648 && $ip <= 2852061183)
              return false;
          if ($ip >= 2886729728 && $ip <= 2887778303)
              return false;
          if ($ip >= 3221225984 && $ip <= 3221226239)
              return false;
          if ($ip >= 3232235520 && $ip <= 3232301055)
              return false;
          if ($ip >= 4294967040)
              return false;
      }
      return true;
  }
  function Wo_IsValidUser($access_token) {
      global $conn;
      if (empty($access_token)) {
          return false;
      }
      $access_token = Wo_Secure($access_token);
      $query = mysqli_query($conn, "SELECT COUNT(`user_id`) FROM `tbl_appssessions` WHERE `session_id` = '{$access_token}'");
      return (Wo_Sql_Result($query, 0) == 1) ? true : false;
  }
  function Wo_UserIdFromSessionId($access_token) {
      global $conn;
      if (empty($access_token)) {
          return false;
      }
      $access_token = Wo_Secure($access_token);
      $query = mysqli_query($conn, "SELECT `user_id` FROM `tbl_appssessions` WHERE `session_id` = '{$access_token}'");
      return Wo_Sql_Result($query, 0, 'user_id');
  }
  function Wo_GetUserData($user_id){
  	global $conn;
  	if (empty($user_id) || !is_numeric($user_id) || $user_id < 1) {
        return false;
    }
  	$data = array();
    $user_id = Wo_Secure($user_id);
    $query = mysqli_query($conn, "SELECT * FROM `tbl_user` WHERE `id` = '{$user_id}' LIMIT 1");
    if($query){
      $fetched_data = mysqli_fetch_assoc($query);  
    }else{
      return $data;
    }
    
    return $fetched_data;
  }
  function Wo_GetMenuDetails($hotel_id){
    global $conn;
    if (empty($hotel_id) || !is_numeric($hotel_id) || $hotel_id < 1) {
        return false;
    }
    $data = array();
    $sub_data = array();

    $hotel_id = Wo_Secure($hotel_id);    
    $all_category = array();
    $all_sub_category = array();

    $query = mysqli_query($conn, "SELECT * FROM `og_category`");
    if($query){
       // $all_category['id'] = 1;
       // $all_category['category'] = 'all';

      while($fetched_data = mysqli_fetch_assoc($query)) {
        $category_id = $fetched_data['id'];
        $subcat_data = Wo_GetCategorySubCategoryData($category_id, $hotel_id);
        if(!empty($subcat_data)){
          $sub_data['id'] = $category_id;
          $sub_data['category'] =  Wo_GetCategoryDetails($fetched_data['id'])['name'];
          $sub_data['data'] = Wo_GetCategorySubCategoryData($category_id, $hotel_id);
          
          $data[] = $sub_data;
        }        
      }
      // $all_sub_category['id'] = 1;
      // $all_sub_category['sub_category'] = 'all';
      // $all_sub_category['data'] = Wo_GetAllMenuData($hotel_id);

      // $all_category['data'][] = $all_sub_category;
      // $temp[] = $all_category;
      // $data = array_merge_recursive($temp, $data);
    }
    
    return $data;
  }
  function Wo_GetCategorySubCategoryData($category_id, $hotel_id){
    global $conn;
    if (empty($category_id) || $category_id < 1) {
        return false;
    }
    $data = array();
    $sub_data = array();
    $category_id = Wo_Secure($category_id);
    $hotel_id = Wo_Secure($hotel_id);
    $query = mysqli_query($conn, "SELECT id, name FROM `og_sub_category` WHERE `hotel_id` = '{$hotel_id}' AND `category_id` = '{$category_id}'");
    if($query){
      while($fetched_data2 = mysqli_fetch_assoc($query)){
        $s_category_id = $fetched_data2['id'];
        $sub_data['id'] = $s_category_id;
        $sub_data['sub_category'] = Wo_GetSubCategoryDetails($fetched_data2['id'])['name'];
        $sub_data['data'] = Wo_GetAllMenuList($category_id, $s_category_id, $hotel_id);


        $data[] = $sub_data;
      }
    }
    
    return $data;
  }
  function Wo_GetAllMenuList($category_id, $s_category_id, $hotel_id){
    global $conn;
    if (empty($s_category_id) || $s_category_id < 1) {
        return false;
    }
    $data = array();
    $category_id = Wo_Secure($category_id);
    $s_category_id = Wo_Secure($s_category_id);
    $hotel_id = Wo_Secure($hotel_id);
    $query = mysqli_query($conn, "SELECT * FROM `og_food_menu` WHERE `hotel_id` = '{$hotel_id}' AND `category` = '{$category_id}' AND `sub_category` = '{$s_category_id}' AND `active` = '1' ORDER BY `sub_category`");
    if($query){
      while($fetched_data2 = mysqli_fetch_assoc($query)){
        $data[] = $fetched_data2;
      }
    }
    
    return $data;
  }
  function Wo_GetAllMenuData($hotel_id){
    global $conn;
    if (empty($hotel_id) || $hotel_id < 1) {
        return false;
    }
    $data = array();
    $hotel_id = Wo_Secure($hotel_id);
    $query = mysqli_query($conn, "SELECT * FROM `og_food_menu` WHERE `hotel_id` = '{$hotel_id}' AND `active` = '1' ORDER BY `sub_category`,`position` ASC");
    if($query){
      while($fetched_data2 = mysqli_fetch_assoc($query)){
        $data[] = $fetched_data2;
      }
    }
    
    return $data;
  }
  function Wo_GetCategoryDetails($category_id){
    global $conn;
    if (empty($category_id) || $category_id < 1) {
        return false;
    }
    $data = array();
    $category_id = Wo_Secure($category_id);
    $query = mysqli_query($conn, "SELECT * FROM `og_category` WHERE `id` = '{$category_id}' LIMIT 1");
    if($query){
      $data = mysqli_fetch_assoc($query);
    }
    
    return $data;
  }
  function Wo_GetSubCategoryDetails($s_category_id){
    global $conn;
    if (empty($s_category_id) || $s_category_id < 1) {
        return false;
    }
    $data = array();
    $s_category_id = Wo_Secure($s_category_id);
    $query = mysqli_query($conn, "SELECT * FROM `og_sub_category` WHERE `id` = '{$s_category_id}' LIMIT 1");
    if($query){
      $data = mysqli_fetch_assoc($query);
    }
    
    return $data;
  }
  function sendDummyOTPtoUser($phone){
      global $conn;
      if (empty($phone)) {
          return false;
      }
      $phone          = Wo_Secure($phone);
      $otp = '123456';
      $query_three = mysqli_query($conn, "UPDATE `tbl_user` SET `otp` = '{$otp}', `status` = 'Active' WHERE `phone` = '{$phone}'");
      if ($query_three) {
          return true;
      }

      return false;
  }
  function sendOTPtoUser($phone,$msg=NULL,$templid=NULL) {
      global $conn;
      if (empty($phone)) {
          return false;
      }
      $phone          = Wo_Secure($phone);
      $otp = mt_rand(100000,999999);
      
      $sms_response = Wo_SendSMS_RiddhiTech($phone,$msg,$templid);
      if($sms_response=='400')
      {
          return false;
      }else{
          $query_three = mysqli_query($conn, "UPDATE `tbl_user` SET `otp` = '{$otp}', `status` = 'Active' WHERE `phone` = '{$phone}'");
            if ($query_three) {
              return true;
             }
      }
//       try{
//         $authKey = "Vbjlqv32WCYzQLnHPrcdDhxtF4Myf8pIuEosGg1aNZST75OeRXfnQMlbIhAOc2tGKgDiXvJ63mL4qSFP";
//         $mobileNumber = $phone;
//         $message = 'Your Mugdh Farm OTP is '.$otp;
//         $route = "q";
//         //Prepare you post parameters
//         $postData = array(
//             'authorization' => $authKey,
//             'numbers' => $mobileNumber,
//             'message' => $message,
//             'language' => 'english',
//             'route' => $route,
//             'flash' => 0
//         );
//         //API URL
//         $url="https://www.fast2sms.com/dev/bulkV2";
//         // init the resource
//         $ch = curl_init();
//         curl_setopt_array($ch, array(
//             CURLOPT_URL => $url,
//             CURLOPT_RETURNTRANSFER => true,
//             CURLOPT_POST => true,
//             CURLOPT_POSTFIELDS => $postData
//         ));
//         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//           'authorization: Vbjlqv32WCYzQLnHPrcdDhxtF4Myf8pIuEosGg1aNZST75OeRXfnQMlbIhAOc2tGKgDiXvJ63mL4qSFP'
//         ));

//         //Ignore SSL certificate verification
//         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

//         //get response
//         $output = curl_exec($ch);

//         //Print error if any
//         if(curl_errno($ch))
//         {
//           return false;
//         }else{
//           $query_three = mysqli_query($conn, "UPDATE `tbl_user` SET `otp` = '{$otp}', `status` = 'Active' WHERE `phone` = '{$phone}'");
//           if ($query_three) {
//             return true;
//           }
//         }

//         curl_close($ch);

//       }catch(Exception $e){
//         return false;
//       }
    //return false;
  }
  function Wo_RegisterUser($phone){
     global $conn;
      if (empty($phone)) {
          return false;
      }
      $phone             = Wo_Secure($phone);
      $date = date("Y-m-d h:i:s");
      $random_string = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 5).rand(1111,9999);
      $query_one = mysqli_query($conn, "INSERT INTO `tbl_user` (`phone`, `role`, `personal_referral_code`, `status`, `created_at`) VALUES('{$phone}', 'User', '{$random_string}', 'Inactive', '{$date}')");
         
      if ($query_one) {
        if($phone == '9876543210'){
            $response = sendDummyOTPtoUser($phone);
        }else{
           $response = sendOTPtoUser($phone); 
        }
        if($response){
          return true;
        }else{
          return false;
        }
      }

      return false;
  }
  function Wo_IsQrExist($qr_code){
    global $conn;
    if (empty($qr_code)) {
      return false;
    }
    $qr_code         = Wo_Secure($qr_code);
    $sql = "SELECT * FROM `og_hotel_qr` WHERE `qr_code` = '{$qr_code}' limit 1";
    $result = mysqli_query($conn, $sql);
    if($result){
      $row = mysqli_fetch_assoc($result);
      $key = $row['qr_code'];
      if($qr_code == $key){
        return true;
      }else{
        return false;
      }
    }else{
      return false;
    }
  }
  function Wo_GetHotelId($qr_code, $table_num){
    global $conn;
    if (empty($qr_code) || empty($table_num)) {
      return false;
    }
    $qr_code         = Wo_Secure($qr_code);
    $table_num       = Wo_Secure($table_num);
    $query = mysqli_query($conn, "SELECT `hotel_id` FROM `og_hotel_qr` WHERE `qr_code` = '{$qr_code}' AND `table_number` = '{$table_num}' LIMIT 1");
    return Wo_Sql_Result($query, 0, 'hotel_id');
  }

  function Wo_AddUserOrder($order_data){
    global $conn;
    if (empty($order_data)) {
        return false;
    }
    $date       = date("Y-m-d h:i:s");

      $keys = '';
      $values = '';
      foreach ($order_data as $key => $value) {
        $keys .= "`".$key."`, ";
        $values .= "'".$value."', ";
      }

      $keys = substr($keys, 0, -2);
      $values = substr($values, 0, -2);

      //return $keys;
      $query_three = mysqli_query($conn, "INSERT INTO `og_order_food` (".$keys.", `updated_at`, `created_at`) VALUES(".$values.", '{$date}',  '{$date}')");
      if ($query_three) {
          return true;
      }

    return false;
  }
  function Wo_GetFromSession($access_token) {
      global $conn;
      if (empty($access_token)) {
          return false;
      }
      $data = array();
      $access_token = Wo_Secure($access_token);
      $query = mysqli_query($conn, "SELECT * FROM `tbl_appssessions` WHERE `session_id` = '{$access_token}' LIMIT 1");
      if($query){
        $data = mysqli_fetch_assoc($query);
      }
      
      return $data;
  }
  function Wo_GetUserOrder($hotel_id, $qr_code, $user_id){
      global $conn, $free_items;
      if (empty($hotel_id) || empty($user_id) || empty($qr_code)) {
          return false;
      }
      $hotel_id     = Wo_Secure($hotel_id);
      $qr_code      = Wo_Secure($qr_code);
      $user_id      = Wo_Secure($user_id);
      $data = array();
      $temp_arr = array();

      $query = mysqli_query($conn, "SELECT * FROM `og_order_food` WHERE `hotel_id` = '{$hotel_id}' AND `qr_id` = '{$qr_code}'  AND `user_id` = '{$user_id}' AND `paid` = '0'");
      if($query){
        while($fetched_data = mysqli_fetch_assoc($query)) {
          if($fetched_data['is_free'] == '1'){
            $temp_arr['name'] = $free_items[$fetched_data['menu_id']];
            $temp_arr['menu_id'] = $fetched_data['menu_id'];
            $temp_arr['quantity'] = $fetched_data['quantity'];
            $temp_arr['plate_type'] = $fetched_data['plate_type'];
            $temp_arr['price'] = '0';
            $temp_arr['is_veg'] = '0';
            $temp_arr['is_free'] = $fetched_data['is_free'];
          }else{
            $menu_detail = Wo_GetFoodMenuDetail($fetched_data['menu_id']);
            $temp_arr['name'] = $menu_detail['menu'];
            $temp_arr['menu_id'] = $menu_detail['id'];
            $temp_arr['quantity'] = $fetched_data['quantity'];
            $temp_arr['plate_type'] = $fetched_data['plate_type'];
            $temp_arr['price'] = $menu_detail['price'];
            $temp_arr['is_veg'] = $menu_detail['is_veg'];
            $temp_arr['is_free'] = $fetched_data['is_free'];
          }
          

          $data[] = $temp_arr;
        } 
      }
      
      return $data;
  }
  function Wo_GetTotalBill($hotel_id, $qr_code, $user_id, $paid = 0){
    global $conn;
      if (empty($hotel_id) || empty($user_id) || empty($qr_code)) {
          return false;
      }
      $hotel_id     = Wo_Secure($hotel_id);
      $qr_code      = Wo_Secure($qr_code);
      $user_id      = Wo_Secure($user_id);
      $data = array();
      $total_payment = 0;
      $total_tax = 0;
      $total_item = 0;

      $query = mysqli_query($conn, "SELECT * FROM `og_order_food` WHERE `hotel_id` = '{$hotel_id}' AND `qr_id` = '{$qr_code}'  AND `user_id` = '{$user_id}' AND `paid` = '{$paid}'");
      if($query){
        while($fetched_data = mysqli_fetch_assoc($query)) {
          $menu_detail = Wo_GetFoodMenuDetail($fetched_data['menu_id']);
          if(!empty($menu_detail['price'])){
            $quantity = $fetched_data['quantity'];
            $total_payment = $total_payment + ((int)$menu_detail['price'] * (int)$quantity);
          }
          if(!empty($menu_detail['tax'])){
            $total_item = $total_item + 1;
            $total_tax = $total_tax + (int)$menu_detail['tax'];
          }
        } 
      }

      if($total_item > 0){
        $data['total_tax'] = $total_tax / $total_item;
      }else{
        $data['total_tax'] = $total_tax;
      }

      $data['total_payment'] = $total_payment;
      
      
      return $data;
  }
  function Wo_GetFoodMenuDetail($menu_id){
    global $conn;
    if (empty($menu_id) || !is_numeric($menu_id) || $menu_id < 1) {
        return false;
    }
    $data = array();
    $menu_id = Wo_Secure($menu_id);
    $query = mysqli_query($conn, "SELECT * FROM `og_food_menu` WHERE `id` = '{$menu_id}' LIMIT 1");
    if($query){
      $data = mysqli_fetch_assoc($query);
    }
    
    return $data;
  }
  function Wo_GetHotelData($hotel_id){
    global $conn;
    if(empty($hotel_id) || (int)$hotel_id <= 0){
      return false;
    }
    $hotel_id = Wo_Secure($hotel_id);
    $data = array();
      $selectSql = "Select * from `og_hotel` where `id` = ".$hotel_id." LIMIT 1";
      $selectQuery = mysqli_query($conn , $selectSql);
      if($selectQuery){
        while($fetched_data2 = mysqli_fetch_assoc($selectQuery)){
          $data = $fetched_data2;
        }
      }      
    return $data;
  }
  function Wo_UpdateSessionData($new_request_id, $access_token, $user_id) {
      global $conn;
      if (empty($user_id)) {
          return false;
      }
      $user_id          = Wo_Secure($user_id);
      $new_request_id   = Wo_Secure($new_request_id);
      $access_token     = Wo_Secure($access_token);

          $query_three = mysqli_query($conn, "UPDATE `tbl_appssessions` SET `request_id` = '{$new_request_id}' WHERE `session_id` = '{$access_token}' AND `user_id` = '{$user_id}'");
          if ($query_three) {
              return true;
          }
    return false;
  }
  function Wo_GetAllSubCategoryData($hotel_id){
     global $conn;
      $data = array();
      $hotel_id   =  Wo_Secure($hotel_id);
      $query = mysqli_query($conn, "SELECT * FROM `og_sub_category` WHERE `hotel_id` = '{$hotel_id}'");
      if($query){
        while ($row = mysqli_fetch_assoc($query)) {
         $data[] = $row;
        }
      }
      
      return $data; 
  }
  function Wo_GetAllCategoryList(){
    global $conn;
    $data = array();
    $data2 = array();
    $query = mysqli_query($conn, "SELECT * FROM `tbl_top_category`");
    if($query){
      while ($row = mysqli_fetch_assoc($query)) {
       $data['tcat_id'] = $row['tcat_id'];
       $data['tcat_name'] = $row['tcat_name'];
       $data['tcat_photo'] = isset($row['tcat_photo']) ? Wo_GetImagePath($row['tcat_photo']) : '';

       $data2[] = $data;
      }
    }
    
    return $data2;
  }
  function Wo_EmailExists($email) {
    global $conn;
      if (empty($email)) {
          return false;
      }
      $email = Wo_Secure($email);
      $query = mysqli_query($conn, "SELECT COUNT(`id`) FROM `tbl_user` WHERE `email` = '{$email}'");
      return (Wo_Sql_Result($query, 0) == 1) ? true : false;
  }
  function Wo_PhoneExists($phone) {
    global $conn;
      if (empty($phone)) {
          return false;
      }
      $phone = Wo_Secure($phone);
      $query = mysqli_query($conn, "SELECT COUNT(`id`) FROM `tbl_user` WHERE `phone` = '{$phone}'");
      return (Wo_Sql_Result($query, 0) == 1) ? true : false;
  }
  function Wo_HashPassword($password = '', $hashed_password) {
    if (empty($password)) {
        return '';
    }
    $hash = 'sha1';
    $password = $hash($password);
    if ($password == $hashed_password) {
        return true;
    }
    return false;
  }
  function Wo_UpdateUserData($user_id, $update_data) {
    global $conn;
    if (empty($user_id) || !is_numeric($user_id) || $user_id < 0) {
        return false;
    }
    if (empty($update_data)) {
        return false;
    }
    $user_id = Wo_Secure($user_id);
    $update = array();
    foreach ($update_data as $field => $data) {
      $update[] = '`' . $field . '` = \'' . Wo_Secure($data, 0) . '\'';
    }
    $impload   = implode(', ', $update);
    $query_one = " UPDATE `tbl_user` SET {$impload} WHERE `id` = {$user_id} ";
    $query1    = mysqli_query($conn, $query_one);
    if ($query1) {
        return true;
    } else {
        return false;
    }
  }

function Wo_RegisterSocialUser($user_data){
    global $conn;
    if (empty($user_data)) {
        return false;
    }
    $date       = date("Y-m-d h:i:s");

      $keys = '';
      $values = '';
      foreach ($user_data as $key => $value) {
        $keys .= "`".$key."`, ";
        $values .= "'".$value."', ";
      }

      $keys = substr($keys, 0, -2);
      $values = substr($values, 0, -2);

      //return $keys;
      $query_three = mysqli_query($conn, "INSERT INTO `tbl_user` (".$keys.", `updated_at`, `created_at`) VALUES(".$values.", '{$date}',  '{$date}')");
      if ($query_three) {
          return true;
      }

    return false;
}
function saveBase64ImagePng($base64Image, $imageDir)
{
      //set name of the image file
      $fileName =  md5(rand(1111, 9999)).'.png';
      $base64Image = trim($base64Image);
      $base64Image = str_replace('data:image/png;base64,', '', $base64Image);
      $base64Image = str_replace('data:image/jpg;base64,', '', $base64Image);
      $base64Image = str_replace('data:image/jpeg;base64,', '', $base64Image);
      $base64Image = str_replace('data:image/gif;base64,', '', $base64Image);
      $base64Image = str_replace(' ', '+', $base64Image);

      $imageData = base64_decode($base64Image);
      //Set image whole path here 
      $filePath = $imageDir . $fileName;


     file_put_contents($filePath, $imageData);

     $fileName = 'upload/user/'.$fileName;
     return $fileName;
}
function fetchDataFromURL($url = '') {
    if (empty($url)) {
        return false;
    }
    $ch = curl_init($url);
    curl_setopt( $ch, CURLOPT_POST, false );
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7");
    curl_setopt( $ch, CURLOPT_HEADER, false );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    return curl_exec( $ch );
}
function sendCustomeEmail($target_email, $target_name, $data){
      global $conn;
      $error = 0;
      if(empty($data)){
        $error = 1;
        return false;
      }
      if($error == 0){
        $subject = $data['subject'];
        $body_message = $data['body'];
        
        try{
              $mail = new PHPMailer;               
              $mail->isSMTP();                                           
              $mail->Host       = 'mail.ordergenie.store';                   
              $mail->SMTPAuth   = true;                                   
              $mail->Username   = 'support@ordergenie.store';                    
              $mail->Password   = 'Invictus1*';                              
              $mail->SMTPSecure = 'ssl';    
              $mail->CharSet  = 'UTF-8';    
              $mail->Port       = 465;                                    
              $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
              //Recipients
              $mail->setFrom('support@ordergenie.store', 'Ordergenie Admin');
              $mail->addAddress($target_email, $target_name);

              // Content
              $mail->isHTML(true);  
              $mail->Subject = $subject;
              $mail->Body    = $body_message;

              $mail->send();
              return true;

          }catch(Exception $e){
              return false;             
          }
      }
}
function Wo_GetPreviousUserOrder($user_id)
{
    global $conn;
      if (empty($user_id)) {
          return false;
      }
      $user_id      = Wo_Secure($user_id);
      $data = array();
      $temp_arr = array();

      $query = mysqli_query($conn, "SELECT * FROM `og_payment` WHERE `user_id` = '{$user_id}'");
      if($query){
        while($fetched_data = mysqli_fetch_assoc($query)) {
            $temp_arr['request_id'] = $fetched_data['request_id'];
            $temp_arr['user_id'] = $fetched_data['user_id'];
            $temp_arr['total_payment'] = $fetched_data['total_payment'];
            $temp_arr['payment_type'] = $fetched_data['payment_type'];
            $temp_arr['paid'] = $fetched_data['paid'];
            $temp_arr['created_at'] = $fetched_data['created_at'];
            $temp_arr['hotel_data'] = Wo_GetHotelData($fetched_data['hotel_id']);

            $data[] = $temp_arr;
        } 
      }
      
      return $data;
}


function Wo_IsOrderFinishNotified($hotel_id, $qr_code, $user_id) {
    global $conn;
      if (empty($user_id) || empty($qr_code) || empty($hotel_id)) {
          return false;
      }
      $user_id = Wo_Secure($user_id);
      $qr_code = Wo_Secure($qr_code);
      $hotel_id = Wo_Secure($hotel_id);

      $query = mysqli_query($conn, "SELECT COUNT(`id`) FROM `og_notify_hotel` WHERE `hotel_id` = '{$hotel_id}' AND `qr_id` = '{$qr_code}' AND `user_id` = '{$user_id}' AND `is_read` = '0'");
      return (Wo_Sql_Result($query, 0) == 1) ? true : false;
}

function Wo_NotifyHotelAdmin($order_data){
    global $conn;
    if (empty($order_data)) {
        return false;
    }
    $date       = date("Y-m-d h:i:s");

      $keys = '';
      $values = '';
      foreach ($order_data as $key => $value) {
        $keys .= "`".$key."`, ";
        $values .= "'".$value."', ";
      }

      $keys = substr($keys, 0, -2);
      $values = substr($values, 0, -2);

      $query_three = mysqli_query($conn, "INSERT INTO `og_notify_hotel` (".$keys.", `created_at`) VALUES(".$values.", '{$date}')");
      if ($query_three) {
          return true;
      }

    return false;
  }

function Wo_GetUserRunningOrderStatus($user_id){
      global $conn;
      if (empty($user_id)) {
          return false;
      }
      $user_id      = Wo_Secure($user_id);
      $data = array();

      $query = mysqli_query($conn, "SELECT * FROM `og_order_food` WHERE `user_id` = '{$user_id}' AND `paid` = '0' LIMIT 1");
      if($query){
        if(mysqli_num_rows($query) > 0){
          $fetched_data = mysqli_fetch_assoc($query);
          $data['hotel_id'] = $fetched_data['hotel_id'];
          $data['qr_code']  = $fetched_data['qr_id'];          
        }
      }

      return $data;
}

function Wo_GetAllProductFromCategory($category_id){
    global $conn;

    $data1 = array();
    $data2 = array();
    $data3 = array();
    $category_id    =   Wo_Secure($category_id);

    $query1 = mysqli_query($conn, "SELECT * FROM `tbl_mid_category` WHERE `tcat_id` = '{$category_id}'");
    if($query1){
      while($fetched_data1 = mysqli_fetch_assoc($query1)){
        $query = mysqli_query($conn, "SELECT * FROM `tbl_product` WHERE `p_is_active` = '1' AND `mcat_id` = '{$fetched_data1['mcat_id']}'");
        if($query){
          while($fetched_data3 = mysqli_fetch_assoc($query)){
                  $product_size = Wo_GetProductSize($fetched_data3['p_id']);
                  $product_tags = Wo_GetProductTags($fetched_data3['p_id']);
                  $data2['p_id'] = $fetched_data3['p_id'];
                  $data2['p_name'] = $fetched_data3['p_name'];
                  $data2['p_old_price'] = $fetched_data3['p_old_price'];
                  $data2['p_current_price'] = $fetched_data3['p_current_price'];
                  $data2['p_qty'] = $fetched_data3['p_qty'];
                  $data2['p_description'] = $fetched_data3['p_description'];
                  $data2['p_short_description'] = $fetched_data3['p_short_description'];
                  $data2['p_is_subscribe'] = $fetched_data3['p_is_subscribe'];
                  $data2['p_featured_photo'] = Wo_GetImagePath($fetched_data3['p_featured_photo']);
                  $data2['p_size'] = '';
                  if($product_size){
                    $data2['p_size'] = $product_size;
                  }
                  $data2['p_tags'] = $product_tags;
            $data3[] = $data2;
          }
        }
      }
    }
    return $data3;
}
function Wo_GetProductTags($product_id){
    global $conn;
    if (empty($product_id) || $product_id < 1) {
        return false;
    }
    $data = array();
    $product_id = Wo_Secure($product_id);     
    $query = mysqli_query($conn, "SELECT `tags_id` FROM `tbl_product_tags` WHERE `p_id` = '{$product_id}'");
    if($query){
      while($fetched_data3 = mysqli_fetch_assoc($query)){
        $query2 = mysqli_query($conn, "SELECT `tags_name` FROM `tbl_tags` WHERE `tags_id` = '{$fetched_data3['tags_id']}' LIMIT 1");
          if($query2){
            while($fetched_data4 = mysqli_fetch_assoc($query2)){
              $data[] = $fetched_data4;
            } 
          }                  
        }
      }
  return $data;
}    
        
function Wo_GetProductFromCategory($category_id){
    global $conn;

    $data1 = array();
    $data2 = array();
    $data3 = array();
    $category_id      = Wo_Secure($category_id);
    $sub_category_id = '';

    $query1 = mysqli_query($conn, "SELECT * FROM `tbl_mid_category` WHERE `tcat_id` = '{$category_id}'");
    if($query1){
      while($fetched_data1 = mysqli_fetch_assoc($query1)){
              $data1['sub_cat_id'] = $fetched_data1['mcat_id'];
              $data1['sub_cat_name'] = $fetched_data1['mcat_name'];
              $temp_arr = array();
              $query = mysqli_query($conn, "SELECT * FROM `tbl_product` WHERE `p_is_active` = '1' AND `mcat_id` = '{$fetched_data1['mcat_id']}'");
              if($query){
                while($fetched_data3 = mysqli_fetch_assoc($query)){
                  $product_size = Wo_GetProductSize($fetched_data3['p_id']);
                  $product_tags = Wo_GetProductTags($fetched_data3['p_id']);
                  $data2['p_id'] = $fetched_data3['p_id'];
                  $data2['p_name'] = $fetched_data3['p_name'];
                  $data2['p_old_price'] = $fetched_data3['p_old_price'];
                  $data2['p_current_price'] = $fetched_data3['p_current_price'];
                  $data2['p_qty'] = $fetched_data3['p_qty'];
                  $data2['p_description'] = $fetched_data3['p_description'];
                  $data2['p_short_description'] = $fetched_data3['p_short_description'];
                  $data2['p_is_subscribe'] = $fetched_data3['p_is_subscribe'];
                  $data2['p_featured_photo'] = Wo_GetImagePath($fetched_data3['p_featured_photo']);
                  $data2['p_size'] = '';
                  if($product_size){
                    $data2['p_size'] = $product_size;
                  }
                  $data2['p_tags'] = $product_tags;
                  $temp_arr[] = $data2;
                }
                $data1['sub_cat_data'] = $temp_arr;
              }
              $data3[] = $data1;
      }
    }

    
    
    return $data3;
}


function Wo_GetAllProducts(){
    global $conn;

    $data = array();
    $data2 = array();
    $query = mysqli_query($conn, "SELECT * FROM `tbl_product` WHERE `p_is_active` = '1' ORDER BY `p_id` DESC");
    if($query){
      while($fetched_data2 = mysqli_fetch_assoc($query)){
        $product_size = Wo_GetProductSize($fetched_data2['p_id']);
        $data['p_id'] = $fetched_data2['p_id'];
        $data['p_name'] = $fetched_data2['p_name'];
        $data['p_old_price'] = $fetched_data2['p_old_price'];
        $data['p_current_price'] = $fetched_data2['p_current_price'];
        $data['p_qty'] = $fetched_data2['p_qty'];
        $data['p_description'] = $fetched_data2['p_description'];
        $data['p_short_description'] = $fetched_data2['p_short_description'];
        $data['p_is_subscribe'] = $fetched_data2['p_is_subscribe'];
        $data['p_featured_photo'] = Wo_GetImagePath($fetched_data2['p_featured_photo']);
        $data['p_size'] = '';
        if($product_size){
          $data['p_size'] = $product_size;
        }

        $data2[] = $data;
      }
    }
    
    return $data2;
  }
  function Wo_GetImagePath($base_path){
    $full_path = BASE_URL.'assets/uploads/'.$base_path;
    return $full_path;
  }
  function Wo_GetProductSize($product_id){
    global $conn;
    if (empty($product_id) || $product_id < 1) {
        return false;
    }
    $data = array();
    $product_id = Wo_Secure($product_id);
    $query = mysqli_query($conn, "SELECT `size_name` FROM `tbl_size` WHERE `size_id` = (SELECT `size_id` FROM `tbl_product_size` WHERE `p_id` = '{$product_id}' LIMIT 1) LIMIT 1");
    if($query){
      $data = mysqli_fetch_assoc($query);
    }    
    return $data['size_name'];    
  }
  function Wo_GetAllSliders(){
    global $conn;

    $data = array();
    $data2 = array();
    $query = mysqli_query($conn, "SELECT * FROM `tbl_app_slider`");
    if($query){
      while($fetched_data = mysqli_fetch_assoc($query)){
        $data['id'] = $fetched_data['id'];
        $data['photo'] = Wo_GetImagePath($fetched_data['photo']);
        $data['position'] = $fetched_data['position'];

        $data2[] = $data;
      }
    }    
    return $data2;
  }
  function deletePreviousDataFromCart($user_id){
    global $conn;      
    $query = mysqli_query($conn, "SELECT * FROM `tbl_order` WHERE `user_id` = '{$user_id}' AND `status` = 'added_to_cart'");
    if($query){
      while($fetched_data = mysqli_fetch_assoc($query)){
        $request_id = $fetched_data['request_id'];
        $query_three = mysqli_query($conn, "DELETE FROM `tbl_subscribed_order_date` WHERE `request_id` = '{$request_id}'");
      }
    }  
    $query_two = mysqli_query($conn, "DELETE FROM `tbl_order` WHERE `user_id` = '{$user_id}' AND `status` = 'added_to_cart'");
    
    if($query_two){
      return true;
    }

    return false;
  }
  function addDataToCartAPI($user_id, $product_arr, $pre_post){
    global $conn;      

    $date = date('Y-m-d H:i:s');
    

    if($pre_post == 'Buy Once'){
      $request_id = time().mt_rand();

      foreach ($product_arr as $product_list){
        if($product_list->product_id != ''){
          $quantity = $product_list->quantity;
          $product_id = $product_list->product_id;
          $product_data = getProductDetailByIDAPI($product_list->product_id);
          $product_size = Wo_GetProductSize($product_list->product_id);
          
          $p_name = $product_data['p_name'];
          $p_current_price = $product_data['p_current_price'];
          $size_name = $product_size;

          $query_three = mysqli_query($conn, "INSERT INTO `tbl_order` (`request_id`, `product_id`, `product_name`, `size`, `unit_price`, `quantity`, `pre_post`, `user_id`, `status`, `updated_at`, `created_at`) VALUES('{$request_id}', '{$product_id}', '{$p_name}', '{$p_current_price}', '{$size_name}', '{$quantity}', '{$pre_post}', '{$user_id}', 'added_to_cart', '{$date}', '{$date}')");
          if ($query_three) {
            // true
          }
        }        
      }
      return $request_id;
    }elseif($pre_post == 'Subscription'){
      foreach ($product_arr as $product_list){
        if($product_list->product_id != ''){
          $request_id = time().mt_rand();          
          $product_id = $product_list->product_id;
          $product_data = getProductDetailByIDAPI($product_list->product_id);
          $product_size = Wo_GetProductSize($product_list->product_id);          
          $p_name = $product_data['p_name'];
          $p_current_price = $product_data['p_current_price'];
          $size_name = $product_size;

          $query_three = mysqli_query($conn, "INSERT INTO `tbl_order` (`request_id`, `product_id`, `product_name`, `size`, `unit_price`, `pre_post`, `user_id`, `status`, `updated_at`, `created_at`) VALUES('{$request_id}', '{$product_id}', '{$p_name}', '{$p_current_price}', '{$size_name}', '{$pre_post}', '{$user_id}', 'added_to_cart', '{$date}', '{$date}')");
          if ($query_three) {
            addAddressToOrderAPI($user_id, $request_id);
            if($product_list->schedule_type == 'everyday'){
              $quantity = $product_list->quantity;
              $query_three = mysqli_query($conn, "INSERT INTO `tbl_subscribed_order_date` (`request_id`, `schedule_type`, `day`, `quantity`, `is_active`, `created_at`) VALUES('{$request_id}', 'everyday', 'everyday', '{$quantity}', '0', '{$date}')");

            }elseif($product_list->schedule_type == 'alternate_day'){
              $quantity = $product_list->quantity;
              $days = $product_list->days;
              $query_three = mysqli_query($conn, "INSERT INTO `tbl_subscribed_order_date` (`request_id`, `schedule_type`, `day`, `quantity`, `alternate_day`, `is_active`, `created_at`) VALUES('{$request_id}', 'alternate_day', 'alternate_day', '{$quantity}', '{$days}', '0', '{$date}')");
            }elseif($product_list->schedule_type == 'customise'){
              if(!empty($product_list->days)){
                foreach ($product_list->days as $product_days){
                  $quantity = $product_days->quantity;
                  $day_name = $product_days->day_name;
                  $query_three = mysqli_query($conn, "INSERT INTO `tbl_subscribed_order_date` (`request_id`, `schedule_type`, `day`, `quantity`, `is_active`, `created_at`) VALUES('{$request_id}', 'customise', '{$day_name}', '{$quantity}', '0', '{$date}')");
                }                
              }
            }            
          }
        }        
      }

      return true;
    }
    
    return false;
  }
  function getProductDetailByIDAPI($product_id){
    global $conn;
    $data = array();
    $query = mysqli_query($conn, "SELECT * FROM `tbl_product` WHERE `p_id`='{$product_id}' LIMIT 1");
    if($query){
      $fetched_data = mysqli_fetch_assoc($query);
    } 
    return $fetched_data;
  }
  function addAddressToOrderAPI($user_id, $request_id){
    global $conn;
    if (empty($user_id)) {
      return false;
    }
    $user_data        = Wo_GetUserData($user_id);
    $searchAddress = $user_data['address'];
    $address1_house_num = $user_data['house_number'];
    $address2_landmark = $user_data['locality'];

    $query_one = " UPDATE `tbl_order` SET `delivery_address`='{$searchAddress}', `house_number`='{$address1_house_num}', `landmark`='{$address2_landmark}' WHERE `request_id`='{$request_id}' ";
    $query1    = mysqli_query($conn, $query_one);
    if ($query1) {
      return true;
    }

    return false;
  }
  function addUserFeedback($user_id, $f_quality_rating, $f_service_rating, $request_id, $f_suggestion){
     global $conn;
      if (empty($user_id)) {
          return false;
      }
      $user_id                      = Wo_Secure($user_id);
      $f_quality_rating             = Wo_Secure($f_quality_rating);
      $f_service_rating             = Wo_Secure($f_service_rating);
      $request_id                   = Wo_Secure($request_id);
      $f_suggestion                 = Wo_Secure($f_suggestion);

      $date = date('Y-m-d H:i:s');

      $query_one = mysqli_query($conn, "INSERT INTO `tbl_feedback` (`f_quality_rating`, `f_service_rating`, `f_suggestion`, `request_id`, `user_id`, `created_at`) VALUES('{$f_quality_rating}', '{$f_service_rating}', '{$f_suggestion}', '{$request_id}', '{$user_id}', '{$date}')");
         
      if ($query_one) {
         return true;
      }

      return false;
  }
  function getUserCartData($user_id){
    global $conn;
    $data4 = array();
    $query = mysqli_query($conn, "SELECT * FROM `tbl_order` WHERE `user_id`='{$user_id}' AND `status`='added_to_cart' ");
    if($query){
      while($fetched_data = mysqli_fetch_assoc($query)){
        $data = array();
        $data['id'] = $fetched_data['id'];
        $data['request_id'] = $fetched_data['request_id'];
        $data['product_id'] = $fetched_data['product_id'];
        $data['product_name'] = $fetched_data['product_name'];
        $data['size'] = $fetched_data['size'];
        $data['color'] = $fetched_data['color'];
        $data['quantity'] = $fetched_data['quantity'];
        $data['unit_price'] = $fetched_data['unit_price'];
        $data['payment_id'] = $fetched_data['payment_id'];
        $data['house_number'] = $fetched_data['house_number'];
        $data['landmark'] = $fetched_data['landmark'];
        $data['delivery_address'] = $fetched_data['delivery_address'];
        $data['delivery_date'] = $fetched_data['delivery_date'];
        $data['pre_post'] = $fetched_data['pre_post'];
        $data['user_id'] = $fetched_data['user_id'];
        $data['status'] = $fetched_data['status'];
        $data['delivery_start_date'] = $fetched_data['delivery_start_date'];
        $data['remark'] = $fetched_data['remark'];
        $data['updated_at'] = $fetched_data['updated_at'];
        $data['created_at'] = $fetched_data['created_at'];
        $data['subscribed_days'] = array();

        if($fetched_data['pre_post'] == 'Subscription'){
          $request_id_tmp = $fetched_data['request_id'];
          $data3 = array();
          $query2 = mysqli_query($conn, "SELECT * FROM `tbl_subscribed_order_date` WHERE `request_id`='{$request_id_tmp}'");
          if($query2){
            while($fetched_data2 = mysqli_fetch_assoc($query2)){
              $data3[] = $fetched_data2;
            }
          }
          $data['subscribed_days'] = $data3;
        }

        $data4[] = $data;
      }
    }
    return $data4;
  }
  function placeUserOrderAPI($user_id){
    global $conn;
    $user_data        = Wo_GetUserData($user_id);
    $cart_data        = getUserCartData($user_id);
    $total_cost = 0;
    $date = date('Y-m-d H:i:s');
    $payment_id = $user_id.rand(1111,9999);
    $payment_method_type = '';
    $delivery_date   =   '';
    $request_id = '';

    if(isset($cart_data) && isset($user_data)){
      $wallet_balance = $user_data['wallet'];
      foreach ($cart_data as $key => $value){
        $product_details = getProductDetailByIDAPI($value['product_id']);
        $total_cost += $product_details['p_current_price']*$value['quantity'];
        $payment_method_type = $value['pre_post'];
        $delivery_date   =   $value['delivery_date'];
        $request_id = $value['request_id'];
      }
      if($payment_method_type == 'Subscription'){
        if((int)$total_cost <= (int)$wallet_balance){

          $query_one = mysqli_query($conn, "INSERT INTO `tbl_subscribed_order` SELECT * FROM `tbl_order` WHERE `request_id`='{$request_id}'"); 

          $query_two = "UPDATE `tbl_subscribed_order` SET `status`='subscribed', `delivery_start_date`='{$delivery_date}' WHERE `request_id`='{$request_id}' AND `status`='added_to_cart' ";
          $query1    = mysqli_query($conn, $query_two);

          $query_two = mysqli_query($conn, "DELETE FROM `tbl_order` WHERE `request_id` = '{$request_id}' ");

          return true;
        }
      }else{
        if((int)$total_cost <= (int)$wallet_balance){
          $remaining_balance = (int)$wallet_balance - (int)$total_cost;
          $full_name = $user_data['full_name'];
          $email = $user_data['email'];
          $query_three = mysqli_query($conn, "INSERT INTO `tbl_payment` (`customer_id`, `customer_name`, `customer_email`, `payment_date`, `paid_amount`, `payment_method`, `payment_status`, `shipping_status`, `payment_id`) VALUES('{$user_id}', '{$full_name}', '{$email}', '{$date}', '{$total_cost}', 'wallet', 'Completed', 'order_placed', '{$payment_id}')");

          $query_two = "UPDATE `tbl_order` SET `status`='order_placed', `payment_id`='{$payment_id}' WHERE `user_id`='{$user_id}' AND `status`='added_to_cart' ";
          $query2    = mysqli_query($conn, $query_two);


          $query_two = "UPDATE `tbl_user` SET `wallet`='{$remaining_balance}' WHERE `id`='{$user_id}' ";
          $query2    = mysqli_query($conn, $query_two);
          
          return true;
        }
      }   
      
    }

    return false;
    
  }
  function getUserOrderDataOfDate($user_id, $date){
    global $conn; 
    $data = array();
    $query = mysqli_query($conn, "SELECT * FROM `tbl_order` WHERE `user_id` = '{$user_id}' AND `delivery_date` = '{$date}' ORDER by id DESC");
    if($query){       
      while($row = mysqli_fetch_assoc($query)){
        $data[] = $row;
      }
    }
    return $data;
  }
  function getUserOrderData($user_id){
    global $conn; 
    $data = array();
    $data2 = array();
    $query = mysqli_query($conn, "SELECT * FROM `tbl_payment` WHERE `customer_id` = '{$user_id}' ORDER by id DESC");
    if($query){
      $payment_mode = '';
      $request_id = '';         
      while($row = mysqli_fetch_assoc($query)){
        $data['id'] = $row['id'];
        $data['customer_id'] = $row['customer_id'];
        $data['customer_name'] = $row['customer_name'];
        $data['customer_email'] = $row['customer_email'];
        $data['payment_date'] = $row['payment_date'];
        $data['txnid'] = $row['txnid'];
        $data['paid_amount'] = $row['paid_amount'];
        $data['payment_method'] = $row['payment_method'];
        $data['payment_status'] = $row['payment_status'];
        $data['shipping_status'] = $row['shipping_status'];
        $data['payment_id'] = $row['payment_id'];
        $data['products'] = getOrderFromPaymentId($row['payment_id']);
        $data2[] = $data;
      }
    }
    return $data2;
  }
  function getOrderFromPaymentId($payment_id){
    global $conn;
    $data = array();
    $data2 = array();
    $query = mysqli_query($conn, "SELECT * FROM `tbl_order` WHERE `payment_id`='{$payment_id}' ");
    if($query){
      while($fetched_data = mysqli_fetch_assoc($query)){        
        $data['id'] = $fetched_data["id"];
        $data['request_id'] = $fetched_data["request_id"];
        $data['product_id'] = $fetched_data["product_id"];
        $data['product_name'] = $fetched_data["product_name"];
        $data['size'] = $fetched_data["size"];
        $data['color'] = $fetched_data["color"];
        $data['quantity'] = $fetched_data["quantity"];
        $data['unit_price'] = $fetched_data["unit_price"];
        $data['payment_id'] = $fetched_data["payment_id"];
        $data['house_number'] = $fetched_data["house_number"];
        $data['landmark'] = $fetched_data["landmark"];
        $data['delivery_address'] = $fetched_data["delivery_address"];
        $data['delivery_date'] = $fetched_data["delivery_date"];
        $data['delivery_start_date'] = $fetched_data["delivery_start_date"];
        $data['pre_post'] = $fetched_data["pre_post"];
        $data['status'] = $fetched_data["status"];
        $data['remark'] = $fetched_data["remark"];
        $data['updated_at'] = $fetched_data["updated_at"];
        $data['created_at'] = $fetched_data["created_at"];
        $data2[] = $data;
      }
    }
    return $data2;
  }
  function getSubscribedOrderData($user_id){
    global $conn;
    $data = array();
    $query = mysqli_query($conn, "SELECT * FROM `tbl_subscribed_order` WHERE `user_id`='{$user_id}' ");
    if($query){
      while($fetched_data = mysqli_fetch_assoc($query)){
        $data[] = $fetched_data;
      }
    }
    return $data;
  }
  
  function Wo_GetCoupanForUser($user_id){
    global $conn;
    $data = array();
    $query = mysqli_query($conn, "SELECT `coupan_id` FROM `tbl_user_coupan` WHERE `user_id`='{$user_id}' ");
    if($query){
      while($fetched_data = mysqli_fetch_assoc($query)){
        $coupan_id = $fetched_data['coupan_id'];
        $query2 = mysqli_query($conn, "SELECT * FROM `tbl_coupan` WHERE `id`='{$coupan_id}' ");
        if($query2){
          while($fetched_data2 = mysqli_fetch_assoc($query2)){
            $data[] = $fetched_data2;
          }
        }
      }
    }
    return $data;
  }

  function Wo_DeleteCartData($id, $user_id){
    global $conn;
      if (empty($id)) {
          return false;
      }
      $id   = Wo_Secure($id);
      $user_id   = Wo_Secure($user_id);
      $query_one = mysqli_query($conn, "DELETE FROM `tbl_order` WHERE `id` = '{$id}' AND  `user_id` = '{$user_id}'");
      if($query_one){
        return true;
      }

      return false;
  }

?>