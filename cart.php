<?php require_once('header.php'); ?>

<?php
include('function2.php');
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_cart = $row['banner_cart'];
}

?>

<section>

        <!-- Banner Sec -->
        <div class="banner-sec banner-inner">

            <div class="pogoSlider" id="js-main-slider2">
                <div class="pogoSlider-slide" data-transition="blocksReveal" data-duration="1000"
                    style="background-image:url(assets/uploads/<?php echo $banner_cart; ?>);">
                </div>
              </div>
        </div>

        <div class="my-sec" style="width: 100%;overflow: scroll;">
          <div class="container">
            <div class="row">
              <div class="col-sm-12 col-md-12 col-md-offset-1">
                <?php
                  if(isset($_SESSION['cart_p_id']) || isset($_SESSION['subs_cart_p_id'])){
                        $arr_cart_p_id = array();
                        if(isset($_SESSION['cart_p_id'])){
                          $i=0;
                          foreach($_SESSION['cart_p_id'] as $value) 
                          {
                              $i++;
                              $arr_cart_p_id[$i] = $value;
                          }
                          $arr_cart_mode = array();
                          $i=0;
                          foreach($_SESSION['cart_p_mode'] as $value) 
                          {
                              $i++;
                              $arr_cart_mode[$i] = $value;
                          }
                          $arr_cart_p_product_qty = array();
                          $i=0;
                          foreach($_SESSION['cart_p_product_qty'] as $value) 
                          {
                              $i++;
                              $arr_cart_p_product_qty[$i] = $value;
                          }
                        }
                        
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
                        }
                        
                    ?>
                      <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Total</th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_cost = 0;
                              foreach($arr_cart_p_id as $key => $value) 
                              {
                                $product_details = Wo_ProductData($value)[0];
                                if($product_details){
                                  $total_cost += $arr_cart_p_product_qty[$key] * $product_details['p_current_price'];
                                  $product_current_price = $arr_cart_p_product_qty[$key] * $product_details['p_current_price'];
                                  ?>
                                    <tr>
                                      <td class="col-sm-6 col-md-5">
                                        <div class="media">
                                          <a class="thumbnail pull-left" href="#"> <img class="media-object" src="assets/uploads/<?php echo $product_details['p_featured_photo']; ?>" style="width: 72px; height: 72px;"> </a>
                                          <div class="media-body" style="margin-left: 30px;">
                                              <h4 class="media-heading"><a href="#"><?php echo $product_details['p_name']; ?></a></h4>
                                              <span>Mode : <?php echo $arr_cart_mode[$key]; ?></span><br>
                                              <span>Status: </span>
                                              <?php 
                                                if($product_details['p_qty'] >= 1){
                                                  ?>
                                                    <span class="text-success">
                                                      <strong>In Stock</strong>
                                                    </span>
                                                  <?php
                                                }else{
                                                  ?>
                                                    <span class="text-danger">
                                                      <strong>Out of Stock</strong>
                                                    </span>
                                                  <?php
                                                } 
                                              ?>
                                          </div>
                                        </div>
                                      </td>
                                      <!--style="text-align: center"-->
                                      <td class="col-sm-2 col-md-1">
                                        <!--<input type="number" class="form-control" id="exampleInputQuantity" name="exampleInputQuantity" value="<?php echo $arr_cart_p_product_qty[$key]; ?>" onchange="increaseQuantity('<?php echo $key; ?>')">-->
                                      <div class="d-flex">
                                        <button class="border bg-light px-2" onclick="dec_quantity('<?php echo $key; ?>','<?php echo $product_details['p_id']; ?>')">-</button>
                                        
                                        <input type="text" class="border bg-light" id="qty_input_<?php echo $key; ?>" style="width:50px; text-align: center;" disabled value="<?php echo $arr_cart_p_product_qty[$key];  ?>" placeholder="<?php echo $arr_cart_p_product_qty[$key]; ?>">

                                        <button class="border bg-light px-2" onclick="inc_quantity('<?php echo $key; ?>','<?php echo $product_details['p_id']; ?>')">+</button>
                                        
                                    </div>
                                      </td>
                                      <td class="col-sm-2 col-md-2 text-center"><span><strong>₹<?php echo $product_details['p_current_price']; ?> <?php if(!empty($product_details['p_old_price'])){ echo "<del>₹".$product_details['p_old_price']."</del>"; } ?></strong></span></td>
                                      <td class="col-sm-1 col-md-1 text-center"><strong id="p_total_<?php echo $key; ?>">₹<?php echo $product_current_price; ?></strong></td>
                                      <td class="col-sm-1 col-md-1">
                                        <a class="btn btn-danger" onclick="return confirmDelete();" href="cart-item-delete.php?id=<?php echo $product_details['p_id']; ?>">
                                            <span class="glyphicon glyphicon-remove"></span> Remove
                                        </a>
                                      </td>
                                    </tr>
                                  <?php
                                }
                              }
                              foreach($subs_cart_p_id as $key => $value) 
                              {
                                $product_details = Wo_ProductData($value)[0];
                                if($product_details){

                                                if($subs_cartschedule_type[$key] == 'everyday'){

                                                    $total_cost += $subs_cart_p_product_qty[$key][1] * $product_details['p_current_price'];
                                                    $product_current_price = $subs_cart_p_product_qty[$key][1] * $product_details['p_current_price'];

                                                  }elseif($subs_cartschedule_type[$key] == 'alternate'){

                                                    $total_cost += $subs_cart_p_product_qty[$key][1] * $product_details['p_current_price'];
                                                    $product_current_price = $subs_cart_p_product_qty[$key][1] * $product_details['p_current_price'];

                                                  }elseif($subs_cartschedule_type[$key] == 'customise'){

                                                    $total_cost += $subs_customiseMquant[$key][1] * $product_details['p_current_price'];
                                                    $product_current_price = $subs_customiseMquant[$key][1] * $product_details['p_current_price'];

                                                  }
                                  ?>
                                    <tr>
                                      <td class="col-sm-7 col-md-6">
                                        <div class="media">
                                          <a class="thumbnail pull-left" href="#"> <img class="media-object" src="assets/uploads/<?php echo $product_details['p_featured_photo']; ?>" style="width: 72px; height: 72px;"> </a>
                                          <div class="media-body" style="margin-left: 30px;">
                                              <h4 class="media-heading"><a href="#"><?php echo $product_details['p_name']; ?></a></h4> 
                                              <span>Mode : <?php echo $subs_cart_p_mode[$key]; ?></span><br>
                                              <span>Schedule Type : <?php echo $subs_cartschedule_type[$key]; ?></span><br>
                                              <?php if(!empty($subs_cartaltdays[$key])){ ?>  <span>Days : <?php echo $subs_cartaltdays[$key]; ?></span><br>  <?php }; ?>
                                              <span>Delivery Start Date : <?php echo $subs_cartdelivery_start_date[$key]; ?></span><br>
                                              <span>Quantity : 
                                                <?php
                                                  if($subs_cartschedule_type[$key] == 'everyday'){
                                                    echo $subs_cart_p_product_qty[$key][1]; 
                                                  }elseif($subs_cartschedule_type[$key] == 'alternate'){
                                                    echo $subs_cart_p_product_qty[$key][1]; 
                                                  }elseif($subs_cartschedule_type[$key] == 'customise'){
                                                         echo " M = ".$subs_customiseMquant[$key][1].", ";
                                                         echo " T = ".$subs_customiseTquant[$key][1].", ";
                                                         echo " W = ".$subs_customiseWquant[$key][1].", ";
                                                         echo " T = ".$subs_customiseTHquant[$key][1].", ";
                                                         echo " F = ".$subs_customiseFquant[$key][1].", ";
                                                         echo " S = ".$subs_customiseSATquant[$key][1].", ";
                                                         echo " S = ".$subs_customiseSUNquant[$key][1];
                                                  }
                                                ?>
                                              </span><br>
                                              <span>Status: </span>
                                              <?php 
                                                if($product_details['p_qty'] >= 1){
                                                  ?>
                                                    <span class="text-success">
                                                      <strong>In Stock</strong>
                                                    </span>
                                                  <?php
                                                }else{
                                                  ?>
                                                    <span class="text-danger">
                                                      <strong>Out of Stock</strong>
                                                    </span>
                                                  <?php
                                                } 
                                              ?>
                                          </div>
                                        </div>
                                      </td>
                                      <td class="col-sm-1 col-md-1" style="text-align: center">
                                                <?php
                                                  if($subs_cartschedule_type[$key] == 'everyday'){
                                                    echo $subs_cart_p_product_qty[$key][1]; 
                                                  }elseif($subs_cartschedule_type[$key] == 'alternate'){
                                                    echo $subs_cart_p_product_qty[$key][1]; 
                                                  }elseif($subs_cartschedule_type[$key] == 'customise'){
                                                         echo " Monday ( ".$subs_customiseMquant[$key][1]." )";
                                                  }
                                                ?>
                                      </td>
                                      <td class="col-sm-2 col-md-2 text-center"><span><strong>₹<?php echo $product_details['p_current_price']; ?> <?php if(!empty($product_details['p_old_price'])){ echo "<del>₹".$product_details['p_old_price']."</del>"; } ?></strong>/-</span></td>
                                      <td class="col-sm-1 col-md-1 text-center"><strong>₹<?php echo $product_current_price; ?></strong></td>
                                      <td class="col-sm-1 col-md-1">
                                        <a class="btn btn-danger" onclick="return confirmDelete();" href="cart-subs-item-delete.php?id=<?php echo $product_details['p_id']; ?>">
                                            <span class="glyphicon glyphicon-remove"></span> Remove
                                        </a>
                                      </td>
                                    </tr>
                                  <?php
                                }
                              }
                          ?> 
                            <tr>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
                                <td><p>Subtotal</p></td>
                                <td class="text-right"><p><strong id="sub_total">₹<?php echo $total_cost; ?></strong></p></td>
                            </tr>
                            <tr>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
                                <td><p>Estimated shipping</p></td>
                                <td class="text-right"><p><strong>₹0</strong></p></td>
                            </tr>
                            <tr>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
                                <td><h6>Total</h6></td>
                                <td class="text-right"><h6><strong id="total_cost">₹<?php echo $total_cost; ?></strong></h6></td>
                            </tr>
                            <tr>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
                                <td>
                                <a href="index.php" type="button" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-shopping-cart"></span> Continue Shopping
                                </a></td>
                                <td>
                                <?php
                                  $redirect_url = 'login.php';
                                  if(isset($_SESSION['loggedin_userid'])){
                                    $redirect_url = 'add-item-to-cart.php';
                                  }
                                ?>

                                <a href="<?php echo $redirect_url; ?>" class="btn btn-success">
                                    Checkout <span class="glyphicon glyphicon-play"></span>
                                </a></td>
                            </tr>
                        </tbody>
                    </table>
                    <?php
                  }else{
                    ?>
                    <div class="text-center">
                      <img src="latest/images/cart2.png">
                    </div>
                    <?php    
                  }
                ?>
                  
              </div>
          </div>
          </div>
        </div>
        <div class="catle-sec">
            <img src="latest/images/catle-img.png" class="img-responsive" width="100%">
        </div>
        <!-- //Catle Sec -->

        
    </section>


<?php require_once('footer.php'); ?>