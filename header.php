<!-- This is main configuration File -->
<?php
ob_start();
session_start();
include("admin/inc/config.php");
include("admin/inc/functions.php");
include("admin/inc/CSRF_Protect.php");
$csrf = new CSRF_Protect();
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';
// Getting all language variables into array as global variable
$i=1;
$statement = $pdo->prepare("SELECT * FROM tbl_language");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	define('LANG_VALUE_'.$i,$row['lang_value']);
	$i++;
}
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row)
{
	$logo = $row['logo'];
	$favicon = $row['favicon'];
	$contact_email = $row['contact_email'];
	$contact_phone = $row['contact_phone'];
	$meta_title_home = $row['meta_title_home'];
    $meta_keyword_home = $row['meta_keyword_home'];
    $meta_description_home = $row['meta_description_home'];
    $before_head = $row['before_head'];
    $after_body = $row['after_body'];
}
// Checking the order table and removing the pending transaction that are 24 hours+ old. Very important
$current_date_time = date('Y-m-d H:i:s');
$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=?");
$statement->execute(array('Pending'));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$ts1 = strtotime($row['payment_date']);
	$ts2 = strtotime($current_date_time);
	$diff = $ts2 - $ts1;
	$time = $diff/(3600);
	if($time>24) {
		// Return back the stock amount
		$statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
		$statement1->execute(array($row['payment_id']));
		$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result1 as $row1) {
			$statement2 = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
			$statement2->execute(array($row1['product_id']));
			$result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
			foreach ($result2 as $row2) {
				$p_qty = $row2['p_qty'];
			}
			$final = $p_qty+$row1['quantity'];

			$statement = $pdo->prepare("UPDATE tbl_product SET p_qty=? WHERE p_id=?");
			$statement->execute(array($final,$row1['product_id']));
		}
		// Deleting data from table
		$statement1 = $pdo->prepare("DELETE FROM tbl_order WHERE payment_id=?");
		$statement1->execute(array($row['payment_id']));

		$statement1 = $pdo->prepare("DELETE FROM tbl_payment WHERE id=?");
		$statement1->execute(array($row['id']));
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Mugdhfarm</title>
	<link rel="icon" href="images/logo.png" type="image/x-icon">
    <link href="latest/css/bootstrap.css" rel="stylesheet">
    <link href="latest/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="latest/css/owl.carousel.min.css">
    <link rel="stylesheet" href="latest/css/pogo-slider.min.css">
    <link href="latest/css/style.css" rel="stylesheet">
    <link href="latest/css/responsive.css" rel="stylesheet">
    <link href="latest/css/owncss.css" rel="stylesheet">
	<?php
	$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach ($result as $row) {
		$about_meta_title = $row['about_meta_title'];
		$about_meta_keyword = $row['about_meta_keyword'];
		$about_meta_description = $row['about_meta_description'];
		$faq_meta_title = $row['faq_meta_title'];
		$faq_meta_keyword = $row['faq_meta_keyword'];
		$faq_meta_description = $row['faq_meta_description'];
		$blog_meta_title = $row['blog_meta_title'];
		$blog_meta_keyword = $row['blog_meta_keyword'];
		$blog_meta_description = $row['blog_meta_description'];
		$contact_meta_title = $row['contact_meta_title'];
		$contact_meta_keyword = $row['contact_meta_keyword'];
		$contact_meta_description = $row['contact_meta_description'];
		$pgallery_meta_title = $row['pgallery_meta_title'];
		$pgallery_meta_keyword = $row['pgallery_meta_keyword'];
		$pgallery_meta_description = $row['pgallery_meta_description'];
		$vgallery_meta_title = $row['vgallery_meta_title'];
		$vgallery_meta_keyword = $row['vgallery_meta_keyword'];
		$vgallery_meta_description = $row['vgallery_meta_description'];
	}
	$cur_page = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
	if($cur_page == 'index.php' || $cur_page == 'login.php' || $cur_page == 'registration.php' || $cur_page == 'cart.php' || $cur_page == 'checkout.php' || $cur_page == 'forget-password.php' || $cur_page == 'reset-password.php' || $cur_page == 'product-category.php' || $cur_page == 'product.php') {
		?>
		<title><?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
		<?php
	}
	if($cur_page == 'about.php') {
		?>
		<title><?php echo $about_meta_title; ?></title>
		<meta name="keywords" content="<?php echo $about_meta_keyword; ?>">
		<meta name="description" content="<?php echo $about_meta_description; ?>">
		<?php
	}
	if($cur_page == 'faq.php') {
		?>
		<title><?php echo $faq_meta_title; ?></title>
		<meta name="keywords" content="<?php echo $faq_meta_keyword; ?>">
		<meta name="description" content="<?php echo $faq_meta_description; ?>">
		<?php
	}
	if($cur_page == 'contact.php') {
		?>
		<title><?php echo $contact_meta_title; ?></title>
		<meta name="keywords" content="<?php echo $contact_meta_keyword; ?>">
		<meta name="description" content="<?php echo $contact_meta_description; ?>">
		<?php
	}
	if($cur_page == 'product.php')
	{
		$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
		$statement->execute(array($_REQUEST['id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $row)
		{
		    $og_photo = $row['p_featured_photo'];
		    $og_title = $row['p_name'];
		    $og_slug = 'product.php?id='.$_REQUEST['id'];
			$og_description = substr(strip_tags($row['p_description']),0,200).'...';
		}
	}
	if($cur_page == 'dashboard.php') {
		?>
		<title>Dashboard - <?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
		<?php
	}
	if($cur_page == 'customer-profile-update.php') {
		?>
		<title>Update Profile - <?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
		<?php
	}
	if($cur_page == 'customer-billing-shipping-update.php') {
		?>
		<title>Update Billing and Shipping Info - <?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
		<?php
	}
	if($cur_page == 'customer-password-update.php') {
		?>
		<title>Update Password - <?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
		<?php
	}
	if($cur_page == 'customer-order.php') {
		?>
		<title>Orders - <?php echo $meta_title_home; ?></title>
		<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
		<meta name="description" content="<?php echo $meta_description_home; ?>">
		<?php
	}
	?>
	<?php if($cur_page == 'product.php'): ?>
		<meta property="og:title" content="<?php echo $og_title; ?>">
		<meta property="og:type" content="website">
		<meta property="og:url" content="<?php echo BASE_URL.$og_slug; ?>">
		<meta property="og:description" content="<?php echo $og_description; ?>">
		<meta property="og:image" content="assets/uploads/<?php echo $og_photo; ?>">
	<?php endif; ?>
   <?php echo $before_head; ?>
   <style>
   	ol.s li{
   		list-style: circle;
   	}
   </style>
   <script src="latest/js/jquery-3.1.0.min.js"></script>
   <script src="latest/js/sweetalert.min.js"></script>
</head>
<body>
<?php echo $after_body; ?>
      <header>
      	<div class="top" style="height: 8px;">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6" style="margin-top: -18px">
						<div class="left">
							<ul>
								<li onclick="openLocationModal()"><a style="color: #fff; cursor: pointer;"> <i class="fa fa-map-marker"></i> <span style="margin-left: 5px;" id="mugdha_select_location" >Select Location</span> </a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6" style="margin-top: -18px">
						<div class="right" style="float: right;">
							<ul>
								<?php
			                        if(isset($_SESSION['loggedin_userid']) && isset($_SESSION['loggedin_user_phone'])){
			                           ?>
											<li data-v-7d77ac60="" class="nav-item">
				                                 <div class="btn-group show-on-hover" style="margin-top: -5px; color: #fff;">
				                                  <a class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer;">
				                                   <i class="fa fa-user fa-lg"></i>
				                                  </a>
				                                  <ul class="dropdown-menu" role="menu">
				                                  	<li><a href="profile.php" style="padding:6px 12px; font-size: 14px;">My Profile</a></li>
				                                    <li><a href="logout.php" style="padding:6px 12px; font-size: 14px;">Logout</a></li>
				                                  </ul>
				                                </div>
				                             </li>
										<?php
			                        }
			                    ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
         <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="index.php"><img src="images/logo.png" alt="logo" class="img-fluid"></a>
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="collapse navbar-collapse myMenu" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto ml-5">
                        <li class="nav-item active mr-3"><a class="nav-link" href="about.php">About Us<span
                         class="sr-only">(current)</span></a></li>
                        <li class="nav-item mr-4"><a class="nav-link" href="how-we-do.php">Our Process</a></li>
						<li class="nav-item active mr-3"><a class="nav-link" href="product-category.php">Shop<span
                         class="sr-only">(current)</span></a></li>
                        <li class="nav-item mr-3"><a class="nav-link" href="contact.php">Contact Us</a></li>
                        <li class="nav-item mr-3"><a class="nav-link" href="blog.php">Blogs</a></li>
                    </ul>
                    <div class="cart-menu">
                        <a href="cart.php">
                        	<i class="fa fa-shopping-cart fa-flip-horizontal"></i>
                            <p class="cart_data_header" id="cart_data_header_icon"><span id="cart_count"></span></p>
						</a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="nav-content">
            <div class="container">
                <ol class="s">
                	<?php
                      $statement = $pdo->prepare("SELECT * FROM tbl_top_category");
                      $statement->execute();
                      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result as $row)
                      {
                          ?>
                            <li><a href="product-category.php?category=<?php echo $row['tcat_id']; ?>" style="color: #fff"><?php echo $row['tcat_name']; ?></a></li>
                          <?php
                      }
                    ?>
                </ol>
            </div>
        </div>
     </header>