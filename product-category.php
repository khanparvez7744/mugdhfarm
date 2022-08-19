<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $contact_map_iframe = $row['contact_map_iframe'];
    $contact_email = $row['contact_email'];
    $contact_phone = $row['contact_phone'];
    $contact_address = $row['contact_address'];
    $banner_contact  = $row['banner_home'];
    $banner_order    = $row['banner_order'];
}
if(isset($_POST['form_add_to_cart'])) {

  $p_product_id   =   $_POST['p_product_id'];
  $p_mode   =   $_POST['p_mode'];
  $p_product_qty = $_POST['p_product_qty'];

  // getting the currect stock of this product
  $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
  $statement->execute(array($p_product_id));
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    $current_p_qty = $row['p_qty'];
  }
  if($current_p_qty < 1):
    $temp_msg = 'Sorry! There are only '.$current_p_qty.' item(s) in stock';
    ?>
    <script type="text/javascript">alert('<?php echo $temp_msg; ?>');</script>
    <?php
  else:
    if(isset($_SESSION['cart_p_id']))
    {
        $arr_cart_p_id = array();
        $arr_cart_mode = array();
        $arr_cart_p_product_qty = array();

        $i=0;
        foreach($_SESSION['cart_p_id'] as $key => $value)
        {
            $i++;
            $arr_cart_p_id[$i] = $value;
        }

        $i=0;
        foreach($_SESSION['cart_p_mode'] as $key => $value)
        {
            $i++;
            $arr_cart_mode[$i] = $value;
        }

        $i=0;
        foreach($_SESSION['cart_p_product_qty'] as $key => $value)
        {
            $i++;
            $arr_cart_p_product_qty[$i] = $value;
        }


        $added = 0;

        for($i=1;$i<=count($arr_cart_p_id);$i++) {
            if( ($arr_cart_p_id[$i]==$p_product_id) && ($arr_cart_mode[$i]==$p_mode) ) {
                $added = 1;
                break;
            }
        }
        if($added == 1) {
           $error_message1 = 'This product is already added to the shopping cart.';
        } else {

            $i=0;
            foreach($_SESSION['cart_p_id'] as $key => $res)
            {
                $i++;
            }
            $new_key = $i+1;

            $_SESSION['cart_p_id'][$new_key] = $p_product_id;
            $_SESSION['cart_p_mode'][$new_key] = $p_mode;
            $_SESSION['cart_p_product_qty'][$new_key] = $p_product_qty;

            $success_message1 = 'Product is added to the cart successfully!';
        }

    }
    else
    {
        $_SESSION['cart_p_id'][1] = $p_product_id;
        $_SESSION['cart_p_mode'][1] = $p_mode;
        $_SESSION['cart_p_product_qty'][1] = $p_product_qty;

        $success_message1 = 'Product is added to the cart successfully!';
    }
  endif;
}
$arr_subs_cart_p_id_added  = array();
$arr_cart_p_id_added = array();
if(isset($_SESSION['cart_p_id']))
{
        $i=0;
        foreach($_SESSION['cart_p_id'] as $key => $value)
        {
            $i++;
            $arr_cart_p_id_added[$i] = $value;
        }
}
if(isset($_SESSION['subs_cart_p_id']))
{
        $i=0;
        foreach($_SESSION['subs_cart_p_id'] as $key => $value)
        {
            $i++;
            $arr_subs_cart_p_id_added[$i] = $value;
        }
}
?>
<section>

        <!-- Banner Sec -->
        <div class="banner-sec">

            <div class="pogoSlider" id="js-main-slider2">
                <?php if(isset($_GET['category']) && $_GET['category']== 7 ){ ?>
                <div class="pogoSlider-slide" data-transition="blocksReveal" data-duration="1000" style="background-image:url(assets/uploads/Mugdh-Dairy.jpg);">
            	<?php }elseif(isset($_GET['category']) && $_GET['category']== 9){ ?>
            		<div class="pogoSlider-slide" data-transition="blocksReveal" data-duration="1000" style="background-image:url(assets/uploads/vegetable-banner.jpg); background-size:cover!important">
            	<?php }elseif(isset($_GET['category']) && $_GET['category']== 8){ ?>
            		<div class="pogoSlider-slide" data-transition="blocksReveal" data-duration="1000" style="background-image:url(assets/uploads/fruits-banner.jpg); background-size:cover!important">
            	<?php }else{ ?>
            		<div class="pogoSlider-slide" data-transition="blocksReveal" data-duration="1000" style="background-image:url(assets/uploads/<?php echo $banner_order; ?>); background-size:cover!important">
            	<?php } ?>
                </div>
              </div>
        </div>
        <?php
          if($error_message1 != '') {
            echo "<script>swal('Oops!', 'This product is already added to the shopping cart.', 'error');</script>";
          }
          if($success_message1 != '') {
              echo "<script>
                    swal({
                      title: 'Success!!',
                      text: 'Product is added to the cart successfully.',
                      icon: 'success',
                      buttons: true,
                      dangerMode: true,
                    })
                    .then((willDelete) => {
                      if (willDelete) {
                        //window.location.href = 'cart.php';
                      } else {
                      }
                    });
                  </script>";
          }
          ?>
        <div class="fruit-veg-sec my-sec" style="padding-top: 35px;">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div id="recipeCarousel" class="carousel slide w-100" data-ride="carousel" data-interval="false">
                <div class="carousel-inner w-100 fv-cat d-flex justify-content-around align-items-center flex-wrap" role="listbox">
                    <div class="carousel-item row no-gutters active">

                      <?php
                        $i = 1;
                        if(isset($_GET['category'])){
                          $actual_link = "product-category.php?category=".$_GET['category']."&";
                        }else{
                          $actual_link = "product-category.php?";
                        }
                        $first_url = "product-category.php?category=".$_GET['category'];
                      ?>
                                  <div class="col-3 float-left">
                                    <a href="<?php echo $first_url; ?>">
                                      <input type="radio" name="tags_name" value="All" onclick="selectTag('<?php echo $first_url; ?>')" <?php if(!isset($_GET['tag'])) { echo "checked"; } ?> /> All
                                    </a>
                                  </div>
                      <?php
                        $statement = $pdo->prepare("SELECT * FROM tbl_tags");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                          $final_url = $actual_link.'tag='.$row['tags_id'];
                          if($i <= 3){
                              ?>
                                <div class="col-3 float-left">
                                    <a href="<?php echo $final_url; ?>">
                                      <input type="radio" name="tags_name" value="<?php echo $row['tags_name']; ?>" onclick="selectTag('<?php echo $final_url; ?>')" <?php if(isset($_GET['tag']) && $row['tags_id'] == $_GET['tag']) { echo "checked"; } ?> /> <?php echo $row['tags_name']; ?>
                                    </a>
                                  </div>
                              <?php
                          }
                          $i++;
                        }
                      ?>
                    </div>
                    <div class="carousel-item row no-gutters">
                        <?php
                        $i = 1;
                        $statement = $pdo->prepare("SELECT * FROM tbl_tags");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                          $final_url = $actual_link.'tag='.$row['tags_id'];
                          if($i > 3){
                              ?>
                                <div class="col-3 float-left">
                                    <a href="<?php echo $final_url; ?>">
                                      <input type="radio" name="tags_name" value="<?php echo $row['tags_name']; ?>" onclick="selectTag('<?php echo $final_url; ?>')" <?php if(isset($_GET['tag']) && $row['tags_id'] == $_GET['tag']) { echo "checked"; } ?> /> <?php echo $row['tags_name']; ?>
                                    </a>
                                  </div>
                              <?php
                          }
                          $i++;
                        }
                      ?>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#recipeCarousel" role="button" data-slide="prev" style="margin-left: -58px;width: 50px;">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#recipeCarousel" role="button" data-slide="next" style="margin-right: -35px;width: 50px;">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
              </div>
            </div>

            <div class="fv-listing">
              <ul class="d-flex justify-content-center flex-wrap">

              	<?php
                  if(isset($_GET['tag']) && isset($_GET['category'])){
                    $mid_level_arr = array();
                    $statement3 = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id = ".$_GET['category']);
                    $statement3->execute();
                    $result3 = $statement3->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result3 as $row2){
                      $mid_level_arr[] = $row2['mcat_id'];
                    }


                    $statement = $pdo->prepare("SELECT * FROM tbl_product_tags WHERE tags_id=".$_GET['tag']);
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row2){
                      $p_id = $row2['p_id'];
                      $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_active=1 AND p_id = ".$p_id);
                      $statement->execute();
                      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result as $row) {
                        if(in_array($row['mcat_id'], $mid_level_arr)){
                          ?>
                            <li>
                                    <div class="block">
                                      <div class="fv-img">
                                        <a href="product-details.php?id=<?php echo $row['p_id']; ?>"><img src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" class="img-responsive" alt="Image"></a>
                                      </div>

                                      <div class="fv-name" style="margin-bottom: 10px;">
                                         <b class="text-center"><h4><?php echo $row['p_name']; ?></h4></b>
                                         <b class="text-center"><h4>&#8377;<?php echo $row['p_current_price']; ?>
                                         &nbsp; <?php if($row['p_old_price'] != '') { echo "<del>&#8377;".$row['p_old_price']."</del>"; } ?></h4></b>
                                      </div>


                                      <div class="fv-btns"> <b>Price: &#8377;<?php echo $row['p_current_price']; ?></b>
                                        <?php
                                          $is_addedd = 0;
                                          if(isset($_SESSION['subs_cart_p_id'])) {
                                            if(in_array($row['p_id'], $arr_subs_cart_p_id_added)){
                                              $is_addedd = 1;
                                            }
                                          }
                                          if($is_addedd == 1){
                                            ?>
                                              <input type="button" class="my-btn" value="SUBSCRIBE" disabled="disabled" style="background: #a7a3a3;">
                                            <?php
                                          }else{
                                            ?>
                                              <a href="subscribed-product-attribute.php?id=<?php echo $row['p_id']; ?>&cat=<?php echo $_GET['category']; ?>" class="my-btn orange">Subscribe</a>
                                            <?php
                                          }
                                        ?>
                                        <?php
                                          $is_added = 0;
                                          if(isset($_SESSION['cart_p_id'])) {
                                            if(in_array($row['p_id'], $arr_cart_p_id_added)){
                                              $is_added = 1;
                                            }
                                          }
                                          if($is_added == 1){
                                            ?>
                                              <input type="button" class="my-btn" value="ADD TO CART" disabled="disabled" style="background: #a7a3a3;">
                                            <?php
                                          }else{
                                            ?>
                                              <form action="" method="post">
                                                <input type="hidden" name="p_product_id" value="<?php echo $row['p_id']; ?>">
                                                <input type="hidden" name="p_mode" value="Buy Once">
                                                <input type="hidden" name="p_product_qty" value="1">
                                                <input type="submit" class="my-btn" value="ADD TO CART" onclick="myCart()" name="form_add_to_cart">
                                              </form>
                                            <?php
                                          }
                                        ?>
                                      </div>
                                    </div>
                                  </li>
                          <?php
                        }
                      }
                    }
                  }else{
                    if(isset($_GET['category'])){
                      $product_cat = $_GET['category'];
                      $statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id = ".$product_cat);
                    }else{
                      $product_cat = 0;
                      $statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id > 0 ORDER BY FIELD(tcat_id,7,8,9)");
                    }

          					$statement->execute();
          					$result = $statement->fetchAll(PDO::FETCH_ASSOC);
          					foreach ($result as $row2){
          						$sub_cat_id = $row2['mcat_id'];
          						$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_active=1 AND mcat_id = ".$sub_cat_id);
          						$statement->execute();
          						$result = $statement->fetchAll(PDO::FETCH_ASSOC);
          						foreach ($result as $row) {
          						    ?>
          						    	<li>
          				                  <div class="block">
          				                    <!-- fv-img -->
          				                    <?php if($row['p_current_price']!="Inprocess"){?>
          				                    <div class="fv-img">
          				                      <a href="product-details.php?id=<?php echo $row['p_id']; ?>"><img src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" class="img-responsive" alt="Image"></a>
          				                    </div>
          				                    <div class="fv-name" style="margin-bottom: 10px;">
                                         <b class="text-center"><h4><?php echo $row['p_name']; ?></h4></b>
                                         <b class="text-center"><h4>&#8377;<?php echo $row['p_current_price']; ?>
                                         &nbsp; <?php if($row['p_old_price'] != '') { echo "<del>&#8377;".$row['p_old_price']."</del>"; } ?></h4></b>
                                      </div>

          				                    <div class="fv-btns">
                                        <?php
                                          $is_addedd = 0;
                                          if(isset($_SESSION['subs_cart_p_id'])) {
                                            if(in_array($row['p_id'], $arr_subs_cart_p_id_added)){
                                              $is_addedd = 1;
                                            }
                                          }
                                          if($is_addedd == 1){
                                            ?>
                                              <input type="button" class="my-btn" value="SUBSCRIBE" disabled="disabled" style="background: #a7a3a3;">
                                            <?php
                                          }else{
                                            ?>
                                              <a href="subscribed-product-attribute.php?id=<?php echo $row['p_id']; ?>&cat=<?php echo $_GET['category']; ?>" class="my-btn orange">Subscribe</a>
                                            <?php
                                          }
                                        ?>

                                        <?php
                                          $is_added = 0;
                                          if(isset($_SESSION['cart_p_id'])) {
                                            if(in_array($row['p_id'], $arr_cart_p_id_added)){
                                              $is_added = 1;
                                            }
                                          }
                                          if($is_added == 1){
                                            ?>
                                              <input type="button" class="my-btn" value="ADD TO CART" disabled="disabled" style="background: #a7a3a3;">
                                            <?php
                                          }else{
                                            ?>
                                              <form action="" method="post">
                                                <input type="hidden" name="p_product_id" value="<?php echo $row['p_id']; ?>">
                                                <input type="hidden" name="p_mode" value="Buy Once">
                                                <input type="hidden" name="p_product_qty" value="1">
                                                <input type="submit" class="my-btn" value="ADD TO CART" onclick="myCart()" name="form_add_to_cart">
                                              </form>
                                            <?php
                                          }
                                        ?>

          				                    </div>
          				                    <!-- fv-btns -->
          				                    <?php }else{  ?>
          				                    <div class="fv-img">
          				                      <a href="#"><img src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" class="img-responsive" alt="Image"></a>
          				                    </div>
          				                    	<!--<b class="text-center"><h4>Upcoming..</h4></b>-->
          				                    	<div class="fv-name" style="margin-bottom: 10px;">
                                         <b class="text-center"><h4><?php echo $row['p_name']; ?></h4></b>
                                         <b class="text-center"><h4>Upcoming..</h4></b>
                                      </div>
                                      <div class="fv-btns">
                                          <input type="button" class="my-btn" value="SUBSCRIBE" disabled="disabled" style="background: #a7a3a3;">
                                          <input type="button" class="my-btn" value="ADD TO CART" disabled="disabled" style="background: #a7a3a3;">
                                          </div>

          				                    <?php }?>
          				                  </div>
          				                  <!-- block -->
          				                </li>
          						    <?php
          						}
          					}
                  }
        				?>

              </ul>


            </div>
            <!-- fv-listing -->

          </div>
          <!-- container -->


        </div>
        <!-- fruit-veg-sec -->



        <!-- Catle Sec -->
        <div class="catle-sec">
            <img src="latest/images/catle-img.png" class="img-responsive">
        </div>
        <!-- //Catle Sec -->
</section>
<style type="text/css">
  .carousel-control-prev-icon,
  .carousel-control-next-icon {
    height: 50px;
    width: 50px;
    background-image: none;
  }

  .carousel-control-next-icon:after
  {
    content: '>';
    font-size: 35px;
    font-weight: bold;
    color: #14b5e3;
    position: absolute;
    top: 10%;
  }

  .carousel-control-prev-icon:after {
    content: '<';
    font-size: 35px;
    font-weight: bold;
    color: #14b5e3;
    position: absolute;
    top: 10%;
  }
</style>
<?php require_once('footer.php'); ?>