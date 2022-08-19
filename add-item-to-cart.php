<?php
include('functions.php');
include('function2.php');
if (isset($_SESSION['loggedin_userid']))
{

    if (isset($_SESSION['cart_p_id']))
    {
        $user_id = $_SESSION['loggedin_userid'];
        $date = date('Y-m-d H:i:s');
        $request_id = time() . mt_rand();

        $arr_cart_p_id = array();
        if (isset($_SESSION['cart_p_id']))
        {
            $i = 0;
            foreach ($_SESSION['cart_p_id'] as $value)
            {
                $i++;
                $arr_cart_p_id[$i] = $value;
            }
            $arr_cart_mode = array();
            $i = 0;
            foreach ($_SESSION['cart_p_mode'] as $value)
            {
                $i++;
                $arr_cart_mode[$i] = $value;
            }
            $arr_cart_p_product_qty = array();
            $i = 0;
            foreach ($_SESSION['cart_p_product_qty'] as $value)
            {
                $i++;
                $arr_cart_p_product_qty[$i] = $value;
            }
            $statement1 = $pdo->prepare("DELETE FROM tbl_order WHERE user_id='$user_id' AND status='added_to_cart' or pre_post='Buy Once'");
            // $statement1->execute(array(
            //     $user_id,
            //     'added_to_cart',
            //     'Buy Once'
            //  ));
            $statement1->execute();
        }

        foreach ($arr_cart_p_id as $key => $value)
        {
            $product_details = Wo_ProductData($value)[0];
            if ($product_details)
            {
                $product_id = $product_details['p_id'];
                if ($product_id != '')
                {
                    $quantity = $arr_cart_p_product_qty[$key];
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
                        $product_details['p_name'],
                        $product_size[0]['size_name'],
                        $product_details['p_current_price'],
                        $quantity,
                        '',
                        $arr_cart_mode[$key],
                        $user_id,
                        'added_to_cart',
                        $date,
                        $date
                    ));
                }

            }
        }
        // unset($_SESSION['cart_p_id']);
        // unset($_SESSION['cart_p_mode']);
        // unset($_SESSION['cart_p_product_qty']);

    }
    if (isset($_SESSION['subs_cart_p_id']))
    {
        $user_id = $_SESSION['loggedin_userid'];
        $date = date('Y-m-d H:i:s');
        
        $subs_cart_p_id = array();
        $subs_cart_p_mode = array();
        $subs_cartschedule_type = array();
        $subs_cart_p_product_qty = array();
        $subs_cartdelivery_start_date = array();
        $subs_cartaltdays = array();
        $subs_customiseMquant = array();
        $subs_customiseTquant = array();
        $subs_customiseWquant = array();
        $subs_customiseTHquant = array();
        $subs_customiseFquant = array();
        $subs_customiseSATquant = array();
        $subs_customiseSUNquant = array();
        if(isset($_SESSION['subs_cart_p_id'])){
            $i=0;
            foreach($_SESSION['subs_cart_p_id'] as $value) 
            {
            $i++;
            $subs_cart_p_id[$i] = $value;
            }
            $i=0;
            foreach($_SESSION['subs_cart_p_mode'] as $value) 
            {
            $i++;
            $subs_cart_p_mode[$i] = $value;
            }
            $i=0;
            foreach($_SESSION['subs_cartschedule_type'] as $value) 
            {
            $i++;
            $subs_cartschedule_type[$i] = $value;
            }
            $i=0;
            foreach($_SESSION['subs_cart_p_product_qty'] as $value) 
            {
            $i++;
            $subs_cart_p_product_qty[$i] = $value;
            }
            $i=0;
            foreach($_SESSION['subs_cartdelivery_start_date'] as $value) 
            {
            $i++;
            $subs_cartdelivery_start_date[$i] = $value;
            }
            $i=0;
            foreach($_SESSION['subs_cartaltdays'] as $value) 
            {
            $i++;
            $subs_cartaltdays[$i] = $value;
            }
            $i=0;
            foreach($_SESSION['subs_customiseMquant'] as $value) 
            {
            $i++;
            $subs_customiseMquant[$i] = $value;
            }
            $i=0;
            foreach($_SESSION['subs_customiseTquant'] as $value) 
            {
            $i++;
            $subs_customiseTquant[$i] = $value;
            }
            $i=0;
            foreach($_SESSION['subs_customiseWquant'] as $value) 
            {
            $i++;
            $subs_customiseWquant[$i] = $value;
            }                          
            $i=0;
            foreach($_SESSION['subs_customiseTHquant'] as $value) 
            {
            $i++;
            $subs_customiseTHquant[$i] = $value;
            }
            $i=0;
            foreach($_SESSION['subs_customiseFquant'] as $value) 
            {
            $i++;
            $subs_customiseFquant[$i] = $value;
            }
            $i=0;
            foreach($_SESSION['subs_customiseSATquant'] as $value) 
            {
            $i++;
            $subs_customiseSATquant[$i] = $value;
            }
            $i=0;
            foreach($_SESSION['subs_customiseSUNquant'] as $value) 
            {
            $i++;
            $subs_customiseSUNquant[$i] = $value;
            }
            $statement1 = $pdo->prepare("DELETE FROM tbl_order WHERE user_id='$user_id' AND status='added_to_cart' or pre_post='Subscription'");
            // $statement1->execute(array(
            //     $user_id,
            //     'added_to_cart',
            //     'Subscription'
            // ));
            $statement1->execute();
            $statement1 = $pdo->prepare("DELETE FROM tbl_subscribed_order_date WHERE is_active=?");
            $statement1->execute(array(
                '0'
            ));
        }
        foreach($subs_cart_p_id as $key => $value){
            $product_details = Wo_ProductData($value)[0];
            $request_id = time() . mt_rand();

            if ($product_details)
            {
                $product_id = $product_details['p_id'];
                if ($product_id != '')
                {
                    $quantity = 0;
                    $product_size = Wo_GetProductSize($product_id);
                    $statement = $pdo->prepare("INSERT INTO tbl_order (
                                                    request_id,
                                                    product_id,
                                                    product_name,
                                                    size,
                                                    unit_price,
                                                    pre_post,
                                                    user_id,
                                                    status,
                                                    delivery_start_date,
                                                    updated_at,
                                                    created_at
                                                ) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
                    $statement->execute(array(
                        $request_id,
                        $product_id,
                        $product_details['p_name'],
                        $product_size[0]['size_name'],
                        $product_details['p_current_price'],
                        $subs_cart_p_mode[$key],
                        $user_id,
                        'added_to_cart',
                        $subs_cartdelivery_start_date[$key],
                        $date,
                        $date
                    ));
                    if($subs_cartschedule_type[$key] == 'everyday'){
                        $statement = $pdo->prepare("INSERT INTO tbl_subscribed_order_date (
                                                    request_id,  
                                                    schedule_type,   
                                                    day, 
                                                    quantity, 
                                                    created_at  
                                                ) VALUES (?,?,?,?,?)");
                        $statement->execute(array(
                            $request_id,
                            'everyday',
                            'everyday',
                            $subs_cart_p_product_qty[$key][1],
                            $date
                        ));

                    }elseif($subs_cartschedule_type[$key] == 'alternate'){
                        $statement = $pdo->prepare("INSERT INTO tbl_subscribed_order_date (
                                                    request_id,  
                                                    schedule_type,   
                                                    day, 
                                                    quantity,
                                                    alternate_day, 
                                                    created_at  
                                                ) VALUES (?,?,?,?,?,?)");
                        $statement->execute(array(
                            $request_id,
                            'alternate',
                            'alternate',
                            $subs_cart_p_product_qty[$key][1],
                            $subs_cartaltdays[$key],
                            $date
                        )); 
                    }elseif($subs_cartschedule_type[$key] == 'customise'){
                        $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
                        foreach ($days as $value) {
                            $quantity = '1';
                            if($value == 'monday'){
                                $quantity = $subs_customiseMquant[$key][1];
                            }elseif($value == 'tuesday'){
                                $quantity = $subs_customiseTquant[$key][1];
                            }elseif($value == 'wednesday'){
                                $quantity = $subs_customiseWquant[$key][1];                                
                            }elseif($value == 'thursday'){
                                $quantity = $subs_customiseTHquant[$key][1];                                
                            }elseif($value == 'friday'){
                                $quantity = $subs_customiseFquant[$key][1];                                
                            }elseif($value == 'saturday'){
                                $quantity = $subs_customiseSATquant[$key][1];                                
                            }elseif($value == 'sunday'){
                                $quantity = $subs_customiseSUNquant[$key][1];                                
                            }
                            $statement = $pdo->prepare("INSERT INTO tbl_subscribed_order_date (
                                                    request_id,  
                                                    schedule_type,   
                                                    day, 
                                                    quantity,
                                                    created_at  
                                                ) VALUES (?,?,?,?,?)");
                            $statement->execute(array(
                                $request_id,
                                'customise',
                                $value,
                                $quantity,
                                $date
                            )); 
                        }
                    }
                }

            }
        }

        // unset($_SESSION['subs_cart_p_id']);
        // unset($_SESSION['subs_cart_p_mode']);
        // unset($_SESSION['subs_cartschedule_type']);
        // unset($_SESSION['subs_cart_p_product_qty']);
        // unset($_SESSION['subs_cartdelivery_start_date']);
        // unset($_SESSION['subs_cartaltdays']);
        // unset($_SESSION['subs_customiseMquant']);
        // unset($_SESSION['subs_customiseTquant']);
        // unset($_SESSION['subs_customiseWquant']);
        // unset($_SESSION['subs_customiseTHquant']);
        // unset($_SESSION['subs_customiseFquant']);
        // unset($_SESSION['subs_customiseSATquant']);
        // unset($_SESSION['subs_customiseSUNquant']);
    }
}

header("Location: login.php");
?>
