<?php 
	include('functions.php');
	if(isset($_POST['submit_subscribe'])){

		$schedule_type = $_POST['schedule_type'];
		$delivery_start_date = $_POST['delivery_start_date'];
		$p_product_id   =   $_POST['p_product_id'];
		$p_product_category = $_POST['p_product_category'];

  		$p_product_qty = '';
  		$altdays = '';
  		$customiseMquant = '';
		$customiseTquant = '';
		$customiseWquant = '';
		$customiseTHquant = '';
		$customiseFquant = '';
		$customiseSATquant = '';
		$customiseSUNquant = '';

		if($schedule_type == 'everyday'){

			$p_product_qty = $_POST['everydayquant'];

		}elseif($schedule_type == 'alternate'){

			$p_product_qty = $_POST['alternatequant'];			
			$altdays = $_POST['altdays'];

		}elseif($schedule_type == 'customise'){
			$customiseMquant = $_POST['customiseMquant'];
			$customiseTquant = $_POST['customiseTquant'];
			$customiseWquant = $_POST['customiseWquant'];
			$customiseTHquant = $_POST['customiseTHquant'];
			$customiseFquant = $_POST['customiseFquant'];
			$customiseSATquant = $_POST['customiseSATquant'];
			$customiseSUNquant = $_POST['customiseSUNquant'];
		}

		if(isset($_SESSION['subs_cart_p_id']))
	    {
	        $arr_subs_cart_p_id = array();
	        $arr_cart_mode = array();

	        $i=0;
	        foreach($_SESSION['subs_cart_p_id'] as $key => $value) 
	        {
	            $i++;
	            $arr_subs_cart_p_id[$i] = $value;
	        }

	        $i=0;
	        foreach($_SESSION['subs_cart_p_mode'] as $key => $value) 
	        {
	            $i++;
	            $arr_cart_mode[$i] = $value;
	        }


	        $added = 0;
	        
	        for($i=1;$i<=count($arr_subs_cart_p_id);$i++) {
	            if( ($arr_subs_cart_p_id[$i]==$p_product_id) && ($arr_cart_mode[$i]==$p_mode) ) {
	                $added = 1;
	                break;
	            }
	        }
	        if($added == 1) {
	           $error_message1 = 'This product is already added to the shopping cart.';
	        } else {

	            $i=0;
	            foreach($_SESSION['subs_cart_p_id'] as $key => $res) 
	            {
	                $i++;
	            }
	            $new_key = $i+1;

	            $_SESSION['subs_cart_p_id'][$new_key] = $p_product_id;
		        $_SESSION['subs_cart_p_mode'][$new_key] = 'Subscription';
		        $_SESSION['subs_cartschedule_type'][$new_key] = $schedule_type;
		        $_SESSION['subs_cart_p_product_qty'][$new_key] = $p_product_qty;
		        $_SESSION['subs_cartdelivery_start_date'][$new_key] = $delivery_start_date;
		        $_SESSION['subs_cartaltdays'][$new_key] = $altdays;
		        $_SESSION['subs_customiseMquant'][$new_key] = $customiseMquant;
				$_SESSION['subs_customiseTquant'][$new_key] = $customiseTquant;
				$_SESSION['subs_customiseWquant'][$new_key] = $customiseWquant;
				$_SESSION['subs_customiseTHquant'][$new_key] = $customiseTHquant;
				$_SESSION['subs_customiseFquant'][$new_key] = $customiseFquant;
				$_SESSION['subs_customiseSATquant'][$new_key] = $customiseSATquant;
				$_SESSION['subs_customiseSUNquant'][$new_key] = $customiseSUNquant;

	            $success_message1 = 'Product is added to the cart successfully!';
	        }
	        
	    }
	    else
	    {
	        $_SESSION['subs_cart_p_id'][1] = $p_product_id;
	        $_SESSION['subs_cart_p_mode'][1] = 'Subscription';
	        $_SESSION['subs_cartschedule_type'][1] = $schedule_type;
	        $_SESSION['subs_cart_p_product_qty'][1] = $p_product_qty;
	        $_SESSION['subs_cartdelivery_start_date'][1] = $delivery_start_date;
	        $_SESSION['subs_cartaltdays'][1] = $altdays;

	        $_SESSION['subs_customiseMquant'][1] = $customiseMquant;
			$_SESSION['subs_customiseTquant'][1] = $customiseTquant;
			$_SESSION['subs_customiseWquant'][1] = $customiseWquant;
			$_SESSION['subs_customiseTHquant'][1] = $customiseTHquant;
			$_SESSION['subs_customiseFquant'][1] = $customiseFquant;
			$_SESSION['subs_customiseSATquant'][1] = $customiseSATquant;
			$_SESSION['subs_customiseSUNquant'][1] = $customiseSUNquant;

	        $success_message1 = 'Product is added to the cart successfully!';
	    }

	    if($error_message1 != '') {
            echo "<script>alert('".$error_message1."')</script>";
        }
        if($success_message1 != '') {
              echo "<script>alert('".$success_message1."')</script>";
        }
	    header('location: product-category.php?category='.$p_product_category);
	}
?>