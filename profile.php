<?php require_once('header.php'); ?>

<?php
include('function2.php');
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
   $about_title = $row['about_title'];
    $about_content = $row['about_content'];
    $about_banner = $row['about_banner'];
    $about_mission = $row['about_mission'];
    $founder_message = $row['founder_message'];
}
$user_data = array();
if(isset($_SESSION['loggedin_userid']) && isset($_SESSION['loggedin_user_phone'])){
  $user_data = Wo_GetUserAllData($_SESSION['loggedin_userid']);
}else{
  header("Location: login.php");
} 
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <section>
    <div class="banner-sec banner-inner banner-about">
      <div class="pogoSlider" id="js-main-slider2">
        <div class="pogoSlider-slide" data-transition="blocksReveal" data-duration="1000"
          style="background-image:url(assets/uploads/<?php echo $about_banner; ?>);">
        </div>
      </div>
    </div>

    <div class="main-sec">
      <div class="container">  
        <div class="mr_profile_area" style="min-height: 100vh; width: 100%;background: #f1f1f1; box-shadow: 0px 10px 5px grey;">

            <div class="tab">
              <button class="tablinks" onclick="openSelectedLink(event, 'my_order')" id="defaultOpen" style="margin-top: 10%;">My Order</button>
              <button class="tablinks" onclick="openSelectedLink(event, 'history')">History</button>
              <button class="tablinks" onclick="openSelectedLink(event, 'wallet')" id="wallet_area">Wallet</button>
              <button class="tablinks" onclick="openSelectedLink(event, 'referral_code')">Referral Code</button>
            </div>

            <div id="my_order" class="tabcontent">
              <table id="my_order_tab" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Payment ID</th>
                        <th>Order Type</th>
                        <th>Status</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                      $statement = $pdo->prepare("SELECT * FROM tbl_order WHERE status != 'addd_to_cart' AND status != 'Completed' AND pre_post = 'Buy Once' AND user_id=".$user_data[0]['id']." ORDER BY id DESC");
                      $statement->execute();
                      $result = $statement->fetchAll(PDO::FETCH_ASSOC);    
                      $i = 1;                        
                      foreach ($result as $row) {
                         ?>
                           <tr>
                              <td><small><?php echo $i++; ?></small></td>
                              <td>
                                <small><?php echo $row['product_name']; ?> - <?php echo $row['size']; ?></small>
                              </td>
                              <td><small><?php echo $row['quantity']; ?></small></td>
                              <td><small>#<?php echo $row['payment_id']; ?></small></td>
                              <td><small><?php echo $row['pre_post']; ?></small></td>
                              <td><small><?php echo $row['status']; ?></small></td>
                              <td><small><?php echo $row['created_at']; ?></small></td>
                          </tr>
                         <?php
                       }
                    ?>
                </tbody>
              </table>
            </div>

            <div id="history" class="tabcontent">
            <table id="history_tab" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Product</th>
                        <th>Payment ID</th>
                        <th>Payment Date</th>
                        <th>Paid Amount</th>      
                        <th>Payment Method</th>                  
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                      $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE shipping_status != 'addd_to_cart' AND shipping_status = 'Completed' AND customer_id=".$user_data[0]['id']." ORDER BY id DESC");
                      $statement->execute();
                      $result = $statement->fetchAll(PDO::FETCH_ASSOC);    
                      $i = 1;                        
                      foreach ($result as $row) {
                        ?>
                             <tr>
                                <td><small><?php echo $i++; ?></small></td>
                                <td>
                            <?php
                                $statement2 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id =".$row['payment_id']." ORDER BY id DESC");
                                $statement2->execute();
                                $result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);                     
                                foreach ($result2 as $row2) {
                                   ?>
                                          <small>
                                            <small><?php echo $row2['product_name']; ?> - <?php echo $row2['size']; ?></small><br>
                                            <small>Quantity : <?php echo $row2['pre_post']; ?></small><br>
                                            <small>Mode : <?php echo $row2['pre_post']; ?></small>
                                          </small><br><br>
                                   <?php
                                 }

                             ?>
                                </td>
                                <td><small>#<?php echo $row['payment_id']; ?></small></td>
                                <td><small><?php echo $row['payment_date']; ?></small></td>
                                <td><small>Rs.<?php echo $row['paid_amount']; ?></small></td>
                                <td><small><?php echo $row['payment_method']; ?></small></td>
                                <td><small><?php echo $row['shipping_status']; ?></small></td>
                            </tr>
                           <?php
                       }
                    ?>
                </tbody>
            </table>
            </div>

            <div id="wallet" class="tabcontent">
              <p style="float: right;width: 100%; height: 50px;">Current Wallet Balance : Rs.<?php echo $user_data[0]['wallet']; ?></p> <br>
              <table id="wallet_tab" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Transaction Type</th>
                        <th>Payment ID</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_wallet_history WHERE user_id=".$user_data[0]['id']);
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);    
                    $i = 1;                        
                    foreach ($result as $row) {
                       ?>
                         <tr>
                            <td><?php echo $i++; ?></td>
                            <td>
                              <?php echo $row['transaction_type']; ?>
                              <?php
                                if( $row['transaction_type'] == 'debit'){
                                  echo '<i class="fa fa-arrow-up" aria-hidden="true" style="color: red"></i>';
                                }else{
                                  echo '<i class="fa fa-arrow-down" aria-hidden="true" style="color: green"></i>';
                                }
                              ?>
                            </td>
                            <td>#<?php echo $row['payment_id']; ?></td>
                            <td>Rs. <?php echo $row['amount']; ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                        </tr>
                       <?php
                     }
                  ?>
                    
                </tbody>
              </table>
              <div id="add_amount_area" style="margin-top: 20px;"> 
                <button type="button" class="btn btn-primary" onclick="openSelectedLink(event, 'add_wallet_balance')"> + Add Amount</button>
              </div>
            </div>

            <div id="referral_code" class="tabcontent">
              <h3>Referral Code</h3>
              <p>Your Referral code is : <?php echo $user_data[0]['personal_referral_code']; ?></p>
            </div>
            
            <div id="add_wallet_balance" class="tabcontent">
              <h3>Add Amount To Wallet</h3>
              <div class="row align-items-center" style="margin-top: 50px;">
                <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7">
                    <form action="" method="post">
                        <div class="block">
                           <br>
                            <input type="text" class="form-control" name="add_amount" placeholder="Enter Amount">
                           <br>
                           <div>
                                <input type="submit" value="Make Payment" class="btn btn-success pull-right" name="form_contact">
                           </div>

                        </div>
                    </form>
                     <br> <br>
                    <div style="margin-top: 20px;"> 
                      <button type="button" class="btn btn-primary"> + 100</button>
                      <button type="button" class="btn btn-primary"> + 500</button>
                      <button type="button" class="btn btn-primary"> + 1000</button>
                    </div>
                </div>
                </div>
            </div>

        </div>
      </div>
    </div>

    <div class="catle-sec catle-sec2">
      <img src="latest/images/catle-img.png" class="img-responsive">
    </div>

  </section>
  <style>
      .pagination{
        float: right;
      }
      #my_order_tab_length label{
        display: none;
      }
      #history_tab_length label{
        display: none;
      }
      #wallet_tab_length label{
        display: none;
      }
      .tab {
        float: left;
        background-color: #1bb7e3;
        width: 30%;
        height: 100vh;
      }
      .tab button {
        display: block;
        background-color: inherit;
        color: black;
        padding: 22px 16px;
        width: 100%;
        border: none;
        outline: none;
        text-align: left;
        cursor: pointer;
        transition: 0.3s;
        font-size: 17px;
      }
      .tab button:hover {
        background-color: #fff;
      }
      .tab button.active {
        background-color: #fff;
      }
      .tabcontent {
        float: left;
        padding: 50px 20px;
        width: 70%;
        border-left: none;
        height: 500px;
      }
  </style>
  
<?php require_once('footer.php'); ?>