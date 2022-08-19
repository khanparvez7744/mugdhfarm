<?php require_once('header.php'); ?>
<?php include('function2.php'); ?>
<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_login = $row['banner_login'];
}
?>
<?php
if(isset($_POST['form1'])) {
        
    if(empty($_POST['cust_email']) || empty($_POST['cust_password'])) {
        $error_message = LANG_VALUE_132.'<br>';
    } else {
        
        $cust_email = strip_tags($_POST['cust_email']);
        $cust_password = strip_tags($_POST['cust_password']);

        $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_email=?");
        $statement->execute(array($cust_email));
        $total = $statement->rowCount();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row) {
            $cust_status = $row['cust_status'];
            $row_password = $row['cust_password'];
        }

        if($total==0) {
            $error_message .= LANG_VALUE_133.'<br>';
        } else {
            //using MD5 form
            if( $row_password != md5($cust_password) ) {
                $error_message .= LANG_VALUE_139.'<br>';
            } else {
                if($cust_status == 0) {
                    $error_message .= LANG_VALUE_148.'<br>';
                } else {
                    $_SESSION['customer'] = $row;
                    header("location: ".BASE_URL."dashboard.php");
                }
            }
            
        }
    }
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
<section>

        <!-- Banner Sec -->
        <div class="banner-sec banner-inner">

            <div class="pogoSlider" id="js-main-slider2">
                <div class="pogoSlider-slide" data-transition="blocksReveal" data-duration="1000"
                    style="background-image:url(assets/uploads/<?php echo $banner_login; ?>);">
                </div>
              </div>
        </div>

        <div class="contact-sec my-sec" style="margin-top: 0;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 contact-right">
                        <div class="block">
                            <div class="embed-container" style="background: #14b5e3;">
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/V8XsFfvcvnw?autoplay=1&mute=1" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                              </iframe>
                            </div>
                        </div>
                      </div>                     
                      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6  contact-left">
                        <?php
                          if(!isset($_SESSION['loggedin_userid'])){
                            ?>
                              <div id="mugdha_login_area" style="display: block;">
                                  <form id="mugdha_login_form">
                                      <div class="block">
                                         <h2 style="color: #14b5e3; font-weight: bold;">LOGIN</h2>

                                         <label style="margin-top: 20%;color: #14b5e3; font-weight: bold;">
                                           Phone Number* <br>
                                          <input class="form-control" id="mobile" required="required" oninput="javascript: if (this.value.length > 10) this.value = this.value.slice(0,10); this.value=this.value.replace(/[^0-9]/g,'');" type="tel" placeholder="Enter phone number">
                                         </label>
                                         <small id="login_invalid_area">Please enter 10 digit valid mobile number</small>
                                         
                                         <div style="text-align: center;margin-top: 10%;">
                                                <button mat-raised-button="" class="btn btn-primary pull-right" id="mugdha_login_form_btn" style="width: 100%;background: #14b5e3;border: 0px;">
                                                   <span class="mat-button-wrapper"><b id="mugdha_login_form_btn_text">SEND OTP</b></span>
                                                </button>
                                         </div>
                                         <div style="height: 40px;"> </div>
                                      </div>
                                  </form>
                              </div>
                              <div id="mugdha_otp_area" style="display: none;">
                                  <form id="mugdha_otp_form">
                                      <div class="block">
                                         <h2 style="color: #14b5e3; font-weight: bold;">OTP</h2>

                                         <label style="margin-top: 10%;color: #14b5e3; font-weight: bold;">
                                           OTP* <br>
                                          <input id="u-otp" required="required" class="form-control" placeholder="Enter 6 digit OTP" oninput="javascript: if (this.value.length > 6) this.value = this.value.slice(0,6); this.value=this.value.replace(/[^0-9]/g,'');" type="tel" >
                                         </label>
                                         <small id="otp_invalid_area"> Please Check Your Messages </small> <br>
                                          <div onclick="resendOtp()"  style="float: left; cursor: pointer;">
                                              <small>Don't Recieve? <a class="underlineText" style="color: #14b5e3; "> Resend OTP</a></small>
                                          </div>
                                         
                                         <div style="text-align: center;margin-top: 20%;">
                                              <input type="submit" value="Verify OTP" class="btn btn-primary pull-right" name="otp_form_contact" style="width: 100%;background: #14b5e3;border: 0px;">
                                         </div>
                                         <div style="height: 40px;"> </div>
                                      </div>
                                  </form>
                              </div>
                            <?php
                          }else{
                            ?>
                              <div id="address_submit_forms" style="display: block;">
                                <form id="address_submit_form">
                                    <div class="block">
                                       <span><h2 style="color: #14b5e3; font-weight: bold;">Address</h2> 
                                        <small><a class="underlineText" style="color: #14b5e3; float: right; cursor: pointer;" onclick="editLocation()"> Edit Location </a></small>
                                       </span>
                                       <p id="searchAddress" class="address-form-searchAddress"><?php echo $loggedin_user_delivery_address; ?></p>

                                          <input id="profile_name" required="required" placeholder="Name*" class="profile_edit form-control" value="<?php echo $loggedin_user_name; ?>"> <br>
                                          <input id="profile_email" required="required" placeholder="Email" class="profile_edit form-control" value="<?php echo $loggedin_user_email; ?>"> <br>
                                          <input id="address1_house_num" required="required" placeholder="H.No | Floor | Locality *" class="profile_edit location_edit form-control" value="<?php echo (isset($loggedin_user_locality)) ? $loggedin_user_locality : $loggedin_user_delivery_address; ?>"> <br>
                                          <input id="address2_landmark" placeholder="Landmark" class="profile_edit location_edit form-control" value="<?php echo $loggedin_user_landmark; ?>">

                                       <div style="text-align: center;margin-top: 10%;">
                                            <input type="submit" value="Save &amp; Continue" class="btn btn-primary pull-right" name="address_form_contact" style="width: 100%;background: #14b5e3;border: 0px;">
                                       </div>
                                       <div style="height: 40px;"> </div>
                                    </div>
                                </form>
                            </div>
                            <?php
                          }
                        ?>
                    </div>
                </div>
            </div>
        </div>



        <!-- Catle Sec -->
        <div class="catle-sec">
            <img src="latest/images/catle-img.png" class="img-responsive" width="100%">
        </div>
        <!-- //Catle Sec -->

        
</section>

<?php require_once('footer.php'); ?>