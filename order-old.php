<?php require_once('header.php'); ?>
<?php include('function2.php'); ?>
<?php
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

      $last_location = Wo_GetLastDeliveryAddress($_SESSION['loggedin_userid']);
      if($last_location){
        $last_payment_mode = $last_location[0]['pre_post'];
      }
      $user_cart_datas = Wo_GetUserCartData($_SESSION['loggedin_userid']);
    }
?>
<div class="section" style="padding-top: 120px;">
   <div class="container ">
      <div class="row align-items-center">
         <div class="col-12 col-sm-12 col-md-6 desktop-view">
            <div role="region" id="carousel-1" aria-busy="false" class="carousel slide carousel-fade" style="background: rgb(255, 255, 255);">
               <div id="carousel-1___BV_inner_" role="list" class="carousel-inner">
                  <div role="listitem" class="carousel-item active" aria-current="true" aria-posinset="1" aria-setsize="1" id="__BVID__17" style="background: rgb(255, 255, 255);">
                     <img src="assets/uploads/<?php echo $banner_order; ?>" class="img-fluid w-100 d-block"><!---->
                  </div>
               </div>
               <!---->
               <!-- <ol id="carousel-1___BV_indicators_" aria-hidden="false" aria-label="Select a slide to display" aria-owns="carousel-1___BV_inner_" class="carousel-indicators">
                  <li role="button" id="carousel-1___BV_indicator_1_" tabindex="0" aria-current="true" aria-label="Goto Slide 1" aria-controls="carousel-1___BV_inner_" class="active" aria-describedby="__BVID__17"></li>
               </ol> -->
            </div>
         </div>
         <div class="col-12 col-sm-12 col-md-6 divider-left">
            <div fxlayout="row" fxlayoutalign="center center" class="container-banner" style="flex-direction: row; box-sizing: border-box; display: flex; place-content: center; align-items: center;">
            </div>
            <form id="product_area_form">
               <div id="mugdha_product_area"> 
                  <div class="product">Choose Product Plan</div>
                  <fieldset class="form-group" id="__BVID__18">
                     <!---->
                     <div tabindex="-1" role="group" class="bv-no-focus-ring">
                        <div id="btn-radios-3" role="radiogroup" tabindex="-1" aria-required="true" class="btn-group-toggle btn-group btn-group-sm bv-no-focus-ring">
                           <label class="btn btn-secondary btn-sm selectPrePad active" onclick="selectPrePostPad('pre')">
                              <input id="btn-radios-3__BV_option_0_" type="radio" name="pre_post_selector" autocomplete="off" value="Buy Once" checked="checked">
                              <span>Buy Once</span>
                           </label>
                           <label class="btn btn-secondary btn-sm selectPostPad" onclick="selectPrePostPad('post')">
                              <input id="btn-radios-3__BV_option_1_" type="radio" name="pre_post_selector" autocomplete="off" value="Subscription">
                              <span>Subscription</span>
                           </label>
                        </div>
                        <!----><!----><!---->
                     </div>
                  </fieldset>
                  <div class="row">
                     <div class="col">
                        <div class="row">
                           <div class="col-12 col-sm-12 col-md-12">
                              <div fxflex="50" fxlayoutalign="center start" fxlayoutalign.lt-md="center center" class="dv-products">
                                 <div fxflex="100" fxlayout="column" fxlayoutalign="center center" style="flex-direction: column;">
                                    <div id="dv-products" class="dv-products pd-bot-10 pd-top-10">
                                       <?php
                                         $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_active=?");
                                         $statement->execute(array(1)); 
                                         $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
                                         foreach ($result as $row) {
                                          $product_size = Wo_ProductSize($row['p_id']);
                                          ?>
                                             <div fxlayout="row" fxlayoutalign="center center" style="margin-bottom: 10px; flex-direction: row; box-sizing: border-box; display: flex; place-content: center; align-items: center;">
                                                <div fxflex="16" style="flex: 1 1 100%; box-sizing: border-box; max-width: 20%;"><img src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" style="height: 40px; width: 40px;"></div>
                                                <div fxflex="50" fxlayout="column" class="ml-10" style="flex-direction: column; box-sizing: border-box; display: flex; flex: 1 1 100%; max-width: 50%;">
                                                   <div class="product-name-txt"> <?php echo $row['p_name']; ?> - <?php echo $product_size[0]['size_name']; ?> </div>
                                                   <div>
                                                      <span class="discountedPrice">
                                                         ₹<span id="final_product_price_<?php echo $row['p_id']; ?>"><?php echo $row['p_current_price']; ?> </span>
                                                         <?php if($row['p_old_price'] != ''): ?>
                                                         <del>
                                                             ₹<?php echo $row['p_old_price']; ?>
                                                         </del>
                                                         <?php endif; ?>
                                                      </span>
                                                   </div>
                                                </div>
                                                <div fxflex="34" fxlayoutalign="end" style="place-content: stretch flex-end; align-items: stretch; flex-direction: row; box-sizing: border-box; display: flex; flex: 1 1 100%; max-width: 34%;">
                                                   <div>
                                                      <?php if($row['p_qty'] == 0): ?>
                                                         <div class="out-of-stock">
                                                             <div class="inner">
                                                                 Out Of Stock
                                                             </div>
                                                         </div>
                                                      <?php else: ?>
                                                         <div class="quantity-toggle" id="quantity-toggle-<?php echo $row['p_id']; ?>">
                                                            <div class="quantity-toggle">
                                                               <div class="dv-quantity-add-box" id="<?php echo $row['p_id']; ?>"  onclick="onAddBtnClick('<?php echo $row['p_id']; ?>')"><span>ADD</span><i class="now-ui-icons ui-1_simple-add12"></i></div>
                                                            </div>
                                                         </div>
                                                      <?php endif; ?>
                                                   </div>
                                                </div>
                                             </div>
                                          <?php
                                         }
                                       ?>
                                    </div>
                                    <div id="show-more-prod" fxlayoutalign="center center" class="product" style="place-content: center; align-items: center; flex-direction: row; box-sizing: border-box; display: flex;"><span>View More Products</span></div>
                                    <div class="product">Delivery Start Date</div>
                                    <div class="topMargin leftMargin" style="text-align: center;">
                                       <fieldset class="form-group" id="__BVID__22">
                                          <!---->
                                          <div tabindex="-1" role="group" class="bv-no-focus-ring">
                                             <div id="btn-radios-2" role="radiogroup" tabindex="-1" aria-required="true" class="btn-group-toggle btn-group btn-group-sm bv-no-focus-ring">
                                                <label class="btn btn-secondary btn-sm selectDeliveryCase1 active" onclick="selectDeliveryTime('case1')">
                                                   <input id="delivery_date_1" type="radio" name="delivery_date_selector" autocomplete="off" value="<?php echo date('Y-m-d', strtotime(' +1 day')); ?>" checked="checked">
                                                   <span>Tommorow</span>
                                                </label>
                                                <label class="btn btn-secondary btn-sm selectDeliveryCase2" onclick="selectDeliveryTime('case2')">
                                                   <input id="delivery_date_2" type="radio" name="delivery_date_selector" autocomplete="off" value="<?php echo date('Y-m-d', strtotime(' +2 day')); ?>">
                                                   <span><?php echo date('Y-m-d', strtotime(' +2 day')); ?></span>
                                                </label>
                                                <label class="btn btn-secondary btn-sm selectDeliveryCase3" onclick="selectDeliveryTime('case3')">
                                                   <input id="delivery_date_3" type="radio" name="delivery_date_selector" autocomplete="off" value="<?php echo date('Y-m-d', strtotime('+3 day', strtotime(date('Y-m-d')))); ?>">
                                                   <span><?php echo date('Y-m-d', strtotime('+3 day', strtotime(date('Y-m-d')))); ?></span>
                                                </label>
                                             </div>
                                          </div>
                                       </fieldset>
                                       <div class="dv-total"><span>Order Total </span> ₹ <span id="total_order_value">0</span></div>
                                       <div class="bottomMargin" style="clear: both;"></div>
                                       <input id="order_container" type="text" name="order_container" autocomplete="off" value="" style="display: none;">
                                       <input id="order_price_container" type="text" name="order_price_container" autocomplete="off" value="0" style="display: none;">
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col align-self-center">
                        <div fxlayoutalign="center center" class="dv-btn dv-btn-addon">
                           <button mat-raised-button="" value="" disabled="disabled" class="mat-raised-button btn btn-info btn-round btn-lg btn-block dv-primary-btn" id="proceed_button">
                              <span class="mat-button-wrapper">PROCEED</span>
                              <div matripple="" class="mat-button-ripple mat-ripple"></div>
                              <div class="mat-button-focus-overlay"></div>
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
            <div class="loginAndOtpAndAddressForm loginAndOtp" id="mugdha_login_otp_area">
                  <div id="mugdha_login_area">
                       <h3 class="login-section"> LOGIN </h3>
                       <form class="login-form" id="mugdha_login_form">
                           <div class="form-group">
                               <div class="vfl-has-label">
                                   <label class="vfl-label">
                                   Mobile Number*
                                   </label> <span class="input-group-addon">+91</span>
                                   <input id="mobile" required="required" oninput="javascript: if (this.value.length > 10) this.value = this.value.slice(0,10); this.value=this.value.replace(/[^0-9]/g,'');" placeholder="Mobile Number*" type="tel" class="profile_edit form-control">
                                   <div class="invalid-feedback" id="login_invalid_area">please enter 10 digit valid mobile number</div>
                               </div>
                           </div>
                           <div class="OTPForm">
                               <div class="w3-center">
                                   <div fxlayoutalign="center center" class="dv-btn dv-btn-addon">
                                       <button mat-raised-button="" class="mat-raised-button btn btn-info btn-round btn-lg btn-block dv-primary-btn" id="mugdha_login_form_btn">
                                           <span class="mat-button-wrapper"><b id="mugdha_login_form_btn_text">SEND OTP</b></span>
                                           <div matripple="" class="mat-button-ripple mat-ripple"></div>
                                           <div class="mat-button-focus-overlay"></div>
                                       </button>
                                   </div>
                               </div>
                           </div> 
                       </form>
                  </div>
                  <div id="mugdha_otp_area">
                      <h3 class="login-section"> OTP </h3>
                      <form class="login-form" id="mugdha_otp_form">
                          <div class="vfl-has-label">
                              <label class="vfl-label">
                              OTP*
                              </label> 
                              <div class="form-group">
                                  <input id="u-otp" required="required" placeholder="OTP*" oninput="javascript: if (this.value.length > 6) this.value = this.value.slice(0,6); this.value=this.value.replace(/[^0-9]/g,'');" type="tel" class="profile_edit form-control is-invalid">
                                  <div class="invalid-feedback" id="otp_invalid_area">please enter 6 digit valid OTP</div>
                              </div>
                          </div>
                          <div class="OTPForm">
                              <div class="w3-center">
                                  <div class="login-section" onclick="resendOtp()">
                                      <h6>Don't Recieve? <a class="underlineText"> Resend OTP</a></h6>
                                  </div>
                              </div>
                          </div>
                          <div class="OTPForm">
                               <div class="w3-center">
                                   <div fxlayoutalign="center center" class="dv-btn dv-btn-addon">
                                       <button mat-raised-button="" class="mat-raised-button btn btn-info btn-round btn-lg btn-block dv-primary-btn">
                                           <span class="mat-button-wrapper"><b>VERIFY OTP</b></span>
                                           <div matripple="" class="mat-button-ripple mat-ripple"></div>
                                           <div class="mat-button-focus-overlay"></div>
                                       </button>
                                   </div>
                               </div>
                           </div>
                      </form>
                  </div>
            </div>
            <div class="addressDiv" id="mugdha_address_area">
                   <div class="loginAndOtpAndAddressForm addressSection">
                       <form id="address_submit_form">
                           <div>
                              <h5 class="product"> Delivery Address 
                                 <a class="underlineText edit_location" onclick="editLocation()">Edit Location</a>
                              </h5>
                               <p id="searchAddress" class="address-form-searchAddress"><?php echo $loggedin_user_delivery_address; ?></p>
                           </div>
                           <div class="form-group">
                               <div class="vfl-has-label">
                                   <label class="vfl-label">
                                   Name*
                                   </label> <input id="profile_name" required="required" placeholder="Name*" class="profile_edit form-control" value="<?php echo $loggedin_user_name; ?>">
                                   <div class="invalid-feedback">name is required</div>
                               </div>
                           </div>
                           <div class="form-group">
                               <div class="vfl-has-label">
                                   <label class="vfl-label">
                                   Email
                                   </label> <input id="profile_email" required="required" placeholder="Email" class="profile_edit form-control" value="<?php echo $loggedin_user_email; ?>">
                                   <div class="invalid-feedback">please enter a valid email</div>
                               </div>
                           </div>
                           <div class="form-group">
                               <div class="vfl-has-label">
                                   <label class="vfl-label">
                                   H.No | Floor | Locality *
                                   </label> <input id="address1_house_num" required="required" placeholder="H.No | Floor | Locality *" class="profile_edit location_edit form-control" value="<?php echo $loggedin_user_locality; ?>">
                                   <div class="invalid-feedback">H.No | Floor | Locality is required</div>
                               </div>
                           </div>
                           <div>
                               <div class="vfl-has-label"><label class="vfl-label">
                                   Landmark
                                   </label> <input id="address2_landmark" placeholder="Landmark" class="profile_edit location_edit form-control" value="<?php echo $loggedin_user_landmark; ?>">
                               </div>
                           </div>
                           <br>
                           <div class="row">
                               <div class="col align-self-center">
                                   <div fxlayoutalign="center center" class="dv-btn dv-btn-addon">
                                       <button mat-raised-button="" class="mat-raised-button btn btn-info btn-round btn-lg btn-block dv-primary-btn" type="submit">
                                           <span class="mat-button-wrapper"><b>Save &amp; Continue</b></span>
                                           <div matripple="" class="mat-button-ripple mat-ripple"></div>
                                           <div class="mat-button-focus-overlay"></div>
                                       </button>
                                   </div>
                               </div>
                           </div>
                       </form>
                   </div>
            </div>
            <div class="payment_method_area"  id="mugdha_payment_area">
                   <div class="row finalcart" id="payment_final_cart">

                   </div>
            </div>
            <div class="order_placed_area"  id="order_placed_area">
                            <div>
                              <h5 class="product">
                                 <a class="underlineText edit_location" href="order.php">Go back to home</a>
                              </h5>
                               <p id="order_placed_area_inner" class="address-form-searchAddress" style="color: green;">Order Placed Successfully</p>
                           </div>
            </div>
         </div>
         <div class="col-12 col-sm-12">
            <div class="container short-products">
              <?php
                      $statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_active=1");
                      $statement->execute();
                      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result as $row)
                      {
                        ?>
                          <div class="row">
                            <div class="col-lg-3 col-md-5 col-sm-5 align-self-center">
                               <div fxflex="50" fxlayoutalign="center start" fxlayoutalign.lt-md="center center" class="dv-products">
                                  <div fxflex="100" fxlayout="column" fxlayoutalign="center center" class="text-center" style="flex-direction: column;"><strong><?php echo $row['p_name']; ?> </strong></div>
                               </div>
                            </div>
                            <div class="col-lg-9 col-md-7 col-sm-7 short-desc">
                               <p class="product__shortdesc"><?php echo $row['p_short_description']; ?></p>
                               <p class="product__description" style="text-align: justify;"><?php echo $row['p_description']; ?></p>
                            </div>
                          </div>
                        <?php
                      }
              ?>
            </div>
         </div>
      </div>
   </div>
</div>
<style>
   .input-group-addon {
       border: 0px solid #ccc !important;
       padding: 0px !important;
       font-size: 16px !important;
       color: #313232 !important;
       text-align: center !important;
       vertical-align: middle !important;
       display: table-cell !important;
       position: absolute !important;
       margin-top: 24px !important;
       padding-bottom: 0px !important;
       margin-left: 5px !important;
       font-family: Poppins Regular !important;
       background-color: #fff !important;
   }
   .loginAndOtpAndAddressForm .form-control{
      margin: 10px 0px;
   }
   #mugdha_login_otp_area{
    display:none;
   }
   #mugdha_login_area{
    display:none;
   }
   #mugdha_otp_area{
    display:none;
   }
   #mugdha_address_area{
    display:none;
   }
   #mugdha_payment_area{
    display:none;
   }
   .invalid_input_area{
      border: 2px solid red;
   }
</style>
<?php require_once('footer.php'); ?>