<?php require_once('header.php') ?>
<?php
include('function2.php');
  if(isset($_GET['id'])){
    $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_active=1 AND p_id = ".$_GET['id']);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row)
    {
      $top_cat = 0;
      $top_cat_name = "";
      $statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE mcat_id = ".$row['mcat_id']);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      foreach ($result as $row2){
        $top_cat = $row2['tcat_id'];
      }
      $statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE tcat_id = ".$top_cat);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      foreach ($result as $row2){
        $top_cat_name = $row2['tcat_name'];
      }
//new code implemented from rupak start
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

    //new code implemented from rupak end
      ?>
        <section>
          <div class="breadcrumb-search-sec">
            <div class="container">
              <div class="block d-flex justify-content-between flex-wrap align-items-baseline bc-col">
                <div class="bc-sec">
                  <ul>
                    <li><a href="#">Home</a></li>
                    <li>/</li>
                    <li><a href="product-category.php?category=<?php echo $top_cat; ?>"><?php echo $top_cat_name; ?></a></li>
                    <li>/</li>
                    <li><a href="#"><?php echo $row['p_name']; ?></a></li>
                  </ul>
                </div>
              </div>
              <!-- block d-flex -->
            </div>
            <!-- container -->
          </div>
          <!-- breadcrumb-search-sec -->

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
                        window.location.href = 'cart.php';
                      } else {
                      }
                    });
                  </script>";
          }
          ?>
            <div class="main-product-sec my-sec">
              <div class="container">
                <div class="row align-items-center">
                  <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 mps-left">
                    <div class="block d-flex justify-content-between align-items-center">
                      <div class="mps-thumb">
                          <ul>
                            <li><a href="#"><img src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" alt="" style="max-height: 87px;"></a></li>
                            <li><a href="#"><img src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" alt="" style="max-height: 87px;"></a></li>
                            <li><a href="#"><img src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" alt="" style="max-height: 87px;"></a></li>
                          </ul>
                        </div>
                      <!-- mps-thumb -->

                      <div class="mps-img">
                        <a href="#"><img src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" class="img-responsive" alt="Image"></a>
                      </div>
                      <!-- mps-img -->


                    </div>
                    <!-- block -->
                  </div>
                  <!-- mps-left -->

                  <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 mps-right">
                    <div class="block">
                      <h3><?php echo $row['p_name']; ?></h3>
                      <div class="mps-text">
                        <b>MRP: <del>&#8377;<?php echo $row['p_old_price']; ?></del></b>
                      </div>
                      <!-- mps-text -->

                      <div class="mps-text">
                        <b>Price: &#8377;<?php echo $row['p_current_price']; ?></b>
                      </div>
                      <!-- mps-text -->

                      <div class="mps-text">
                        <b>Category: <?php echo $top_cat_name; ?></b>
                      </div>
                      <!-- mps-text -->
                       <!--new code by dhiraj-->
                      <?php
                      $product_size = Wo_ProductSize($_GET['id']);
                      ?>
                      <div class="mps-text">
                        <b>Quantity:<?php echo $product_size[0]['size_name']; ?></b>
                      </div>
                      <!-- mps-text -->

                      <div class="mps-cart-sec">

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
                                <input type="number" name="p_product_qty" value="1" min="1">
                                  <input type="submit" class="my-btn ml-3" value="ADD TO CART" name="form_add_to_cart">
                              </form>
                            <?php
                          }
                        ?>
                         </div>
                      <!-- mps-cart-sec -->

                    </div>
                    <!-- block -->
                  </div>
                  <!-- mps-right -->

                </div>
                <!-- row -->

              </div>
              <!-- container -->

            </div>
            <!-- main-product-sec -->

            <div class="mps-para">
              <div class="container">
                <h4>Description</h4>
                <?php echo $row['p_description']; ?>

                <h4>Benefits</h4>
                <ul>
                <?php echo $row['p_short_description']; ?>
                </ul>

              </div>
              <!-- container -->
            </div>
            <!-- mps-para -->


            <div class="fv-listing fv-listing2">
              <div class="container">
                <h2 class="text-center">Related Products</h2>
                <ul class="d-flex justify-content-center flex-wrap Related owl-carousel owl-theme owlUl m-0">
                  <?php
                    $i = 0;
                    $statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id = ".$top_cat);
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    shuffle($result);
                    $count = 0;
                    foreach ($result as $row2){
                      $sub_cat_id = $row2['mcat_id'];
                      $query = "SELECT * FROM tbl_product WHERE p_is_active=1 AND p_current_price !='Inprocess' AND mcat_id = ".$sub_cat_id. " AND p_id != ".$row['p_id'];
                      $statement2 = $pdo->prepare($query);
                      $statement2->execute();
                      $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
                      shuffle($result2);
                      foreach ($result2 as $row3) {
                        if($i < 5){
                          ?>
                            <li>
                              <div class="block item">
                                <div class="fv-img">
                                  <a href="product-details.php?id=<?php echo $row3['p_id']; ?>"><img src="assets/uploads/<?php echo $row3['p_featured_photo']; ?>" class="img-responsive" alt="Image"></a>
                                </div>
                                <!-- fv-img -->
                                <div class="fv-name" style="margin-bottom: 10px;">
                                         <b class="text-center"><h4><?php echo $row3['p_name']; ?></h4></b>
                                         <b class="text-center"><h4>&#8377;<?php echo $row3['p_current_price']; ?>
                                         &nbsp; <?php if($row3['p_old_price'] != '') { echo "<del>&#8377;".$row3['p_old_price']."</del>"; } ?></h4></b>
                                      </div>

                                <div class="fv-btns">
                                  <a href="subscribed-product-attribute.php?id=<?php echo $row3['p_id']; ?>&cat=<?php echo $top_cat; ?>" class="my-btn orange">Subscribe</a>
                                  <a href="product-details.php?id=<?php echo $row3['p_id']; ?>" class="my-btn">Add to Cart</a>
                                </div>
                                <!-- fv-btns -->
                              </div>
                              <!-- block -->
                            </li>
                          <?php
                        }elseif($i >= 5){
                          break;
                        }
                        $i++;
                      }
                    }
                  ?>

                </ul>
              </div>
            </div>
            <div class="catle-sec">
                <img src="latest/images/catle-img.png" class="img-responsive">
            </div>
        </section>

      <?php
    }
  }
?>
<?php require_once('footer.php'); ?>