<?php require_once('header.php'); ?>
 
<?php
  include('function2.php');
    $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row)
    {
        $banner_order = $row['banner_order'];
    }

    $loggedin_user_name = '';
    $loggedin_user_email = '';
    $loggedin_user_locality = '';
    $loggedin_user_landmark = '';
    $loggedin_user_delivery_address = '';
    $user_cart_datas = array();
    $user_data = array();
    $last_payment_mode = '';

    if(isset($_SESSION['loggedin_userid']) && isset($_SESSION['loggedin_user_phone'])){
      $user_data = Wo_GetUserAllData($_SESSION['loggedin_userid']);
      $loggedin_user_name = $user_data[0]['full_name'];
      $loggedin_user_email = $user_data[0]['email'];
      $loggedin_user_locality = $user_data[0]['house_number'];
      $loggedin_user_landmark = $user_data[0]['locality'];
      $loggedin_user_delivery_address = $user_data[0]['address'];

      $user_cart_datas = Wo_GetUserCartData($_SESSION['loggedin_userid']);
    }
?>

<section>

        <!-- Banner Sec -->
        <div class="banner-sec banner-inner">

            <div class="pogoSlider" id="js-main-slider2">
                <div class="pogoSlider-slide" data-transition="blocksReveal" data-duration="1000"
                    style="background-image:url(latest/images/delivery.jpg);">
                </div>
              </div>
        </div>

        <div class="order-sec my-sec">
          <div class="container">
            <div class="row">
              
              <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 order-sec-left">
                <div class="block">
                <div class="embed-container"><iframe width="560" height="315" src="https://www.youtube.com/embed/V8XsFfvcvnw?autoplay=1&mute=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                </div>
                <!-- block -->
              </div>
              <!-- order-sec-left -->
              
              
              <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 order-sec-right" id="order_contain_area">
                <div class="block d-flex justify-content-between">
                  <div><b>DELIVERY ADDRESS</b></div>
                </div>
                <!-- block -->


                <div class="block d-flex justify-content-between">
                  <!--<div><?php echo $loggedin_user_delivery_address; ?></div>-->
                  <div><?php echo (isset($loggedin_user_locality)) ? $loggedin_user_locality : $loggedin_user_delivery_address; ?></div>
                </div>
                <!-- block -->


                <div class="block d-flex justify-content-between">
                  <div><b>ORDER SUMMARY</b></div>
                  <div><a href="cart.php">Edit</a></div>
                </div>
                <!-- block -->


                <div class="block d-flex justify-content-between">
                  <div style="width: 170px;"><b>Product Name</b></div>
                  <div><b>MRP</b></div>
                  <div><b>Qty</b></div>
                  <div><b>Mode</b></div>
                  <div><b>Amt</b></div>
                </div>
                <!-- block -->

                <?php
                  $total_pay = 0;
                  foreach ($user_cart_datas as $key => $value) {
                    $product_attribute = array();
                    if($value['pre_post'] == 'Subscription'){
                      $product_attribute = Wo_ProductAttribute($value['request_id'])[0];
                    }
                    $quantity_val = $quantity_text = $value['quantity'];
                    ?>
                      <div class="block d-flex justify-content-between">
                        <div class="product_name_area" style="word-break: break-word;width: 170px;">
                          <small><?php echo $value['product_name']; ?> (<?php echo $value['size']; ?>) </small><br>
                          <small> <?php
                                              if($value['pre_post'] == 'Subscription'){                                                
                                                if($product_attribute['schedule_type'] == 'everyday'){
                                                    $quantity_val = $quantity_text = $product_attribute['quantity']; 
                                                  }elseif($product_attribute['schedule_type'] == 'alternate'){
                                                    echo 'Day : '.$product_attribute['alternate_day'];
                                                    $quantity_val = $quantity_text = $product_attribute['quantity']; 
                                                  }elseif($product_attribute['schedule_type'] == 'customise'){
                                                    echo 'Quantity : ';
                                                    $quantity_text = " M = ".$product_attribute['quantity'];
                                                    $quantity_val = $product_attribute['quantity'];
                                                         echo " M = ".$product_attribute['quantity'].", ";
                                                         echo " T = ".$product_attribute['quantity'].", ";
                                                         echo " W = ".$product_attribute['quantity'].", ";
                                                         echo " T = ".$product_attribute['quantity'].", ";
                                                         echo " F = ".$product_attribute['quantity'].", ";
                                                         echo " S = ".$product_attribute['quantity'].", ";
                                                         echo " S = ".$product_attribute['quantity'];
                                                }
                                              }
                                            ?>
                             </small>
                        </div>
                        <div>
                          <small>&#8377;<?php echo $value['unit_price']; ?></small>
                        </div>
                        <div><?php echo $quantity_text; ?></div>
                        <div><small><?php echo $value['pre_post']; ?></small></div>
                        <div><b>&#8377; <?php echo (int)$value['unit_price'] * (int)$quantity_val; $total_pay += (int)$value['unit_price'] * (int)$quantity_val; ?></b></div>
                      </div>
                    <?php
                  }

                ?>
                
                <!-- block -->


                <div class="block my-coupon-block d-flex justify-content-between">
                  <div class="my-coupon-div">
                    <input type="text" name="coupan_code_area" placeholder="Enter Coupon Code" class="my-input" id="coupan_code_area"  />
                  </div>
                  <div class="my-coupon-btn-div">
                    <input type="button" id="coupan_code_area_btn" value="Apply Code" class="my-btn" onclick="applyCoupan()" />
                  </div>
                </div>
                <!-- block -->


                <div class="block my-coupon-apply-div">
                    <div class="coupon-code-applied">
                      
                    </div>
                </div>
                <!-- block -->

                <div class="block d-flex justify-content-between">
                  <div><b>Total</b></div>
                  <div><b>&#8377; <span><?php echo $total_pay; ?></span></b></div>
                </div>

                <div class="block d-flex justify-content-between">
                  <div><b>Discount</b></div>
                  <div><b><span id="discount_area">0</span>%</b></div>
                </div>

                <div class="block d-flex justify-content-between">
                  <div><b>Final Amount</b></div>
                  <div><b>&#8377; <span id="total_pay_amount"><?php echo $total_pay; ?></span></b></div>
                </div>
                <!-- block -->

                <div class="block d-flex justify-content-between">
                  <div><b>Wallet Balance</b></div>
                  <div><b>&#8377; <span id="user_wallet_balance"><?php echo $user_data[0]['wallet']; ?></span></b></div>
                </div>
                <!-- block -->


                <div class="block" id="submit_btn_proceed">
                  <?php

                    if((int)$total_pay > (int)$user_data[0]['wallet']){
                      $remain_balance = (int)$total_pay - (int)$user_data[0]['wallet'];
                      ?>
                        <div><button class="my-btn" onclick="addPaymentToWallet(<?=$remain_balance; ?>)" id="add_pyment_to_wallet">Add &#8377;<?php echo $remain_balance; ?> to continue</button></div>
                      <?php
                    }elseif((int)$total_pay <= (int)$user_data[0]['wallet']){
                      ?>
                        <div><button class="my-btn" onclick="placeUserOrder()" id="place_order_btn">Place Order</button></div>
                      <?php
                    }
                  ?>                  
                </div>
                <!-- block -->


              </div>
              <!-- order-sec-right -->

              <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 order-sec-right" id="order_placed_area" style="display: none;">
                <div class="text-center">
                  <img src="latest/images/order-place.jpg" alt="order-place" style="text-align: center;">
                  <p>Your order is placed successfully. <a href="profile.php">Track your order here.</a></p>
                </div>
              </div>
            
            </div>
            <!-- row -->
            
          </div>
          <!-- container -->


        </div>
        <!-- order-sec -->



        <!-- Catle Sec -->
        <div class="catle-sec">
            <img src="latest/images/catle-img.png" class="img-responsive">
        </div>
        <!-- //Catle Sec -->

        
</section>

<?php require_once('footer.php'); ?>