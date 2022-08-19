<?php require_once('header.php'); ?>

<?php
include('function2.php');
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $banner_order    = $row['banner_order'];
}

?>

<section>

        <!-- Banner Sec -->
        <div class="banner-sec banner-inner banner-subscribe">

            <div class="pogoSlider" id="js-main-slider2">
                <div class="pogoSlider-slide" data-transition="blocksReveal" data-duration="1000"
                    style="background-image:url(assets/uploads/<?php echo $banner_order; ?>);">
                </div>
              </div>
        </div>

      <?php
      if(isset($_GET['id'])){
        $product_details = Wo_ProductData($_GET['id'])[0];
        if($product_details){
        ?>
          <div class="subscribe-sec my-sec">
            <div class="sub-pro my-sec">
              <div class="container">
                <div class="row align-items-center">
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 sub-pro-left">
                    <div class="block">
                      <img src="assets/uploads/<?php echo $product_details['p_featured_photo']; ?>" class="img-responsive" alt="Image">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 sub-pro-right">
                    <div class="block">
                      <h3><?php echo $product_details['p_name']; ?></h3>
                      <div class="sub-pro-text">
                          <?php
                      $product_size = Wo_ProductSize($_GET['id']);
                      ?>
                        Rs. <del><?php echo $product_details['p_old_price']; ?></del><br>
                        Offer price : <span><?php echo $product_details['p_current_price']; ?>/<?php echo $product_size[0]['size_unit']; ?></span>
                      </div>
                      <!-- sub-pro-text -->

                      <!--<div class="sub-pro-text">-->
                      <!--  <?php echo $product_details['p_short_description']; ?>-->
                      <!--</div>-->
                      <!-- sub-pro-text -->


                      <div class="sub-pro-text">
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
                      <!-- sub-pro-text -->

                      <!-- <div class="sub-pro-cart-sec">
                        <div class="qty_info">
                          <div class="qty_inner">
                            <div class="input-group">
                              <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus"
                                  data-field="quant[1]">
                                  <i class="fa fa-minus"></i>
                                </button>
                              </span>
                              <input type="text" name="quant[1]" class="input-number" value="1" min="1" max="10">
                              <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[1]">
                                  <i class="fa fa-plus"></i>
                                </button>
                              </span>
                            </div>
                          </div>
                        </div>

                      </div> -->
                      <!-- sub-pro-cart-sec -->

                    </div>
                    <!-- block -->
                  </div>
                  <!-- sub-pro-right -->

                </div>
              </div>
              <!-- container -->


            </div>
            <!-- sub-pro-sec -->
            <form action="subscribed-form.php" method="POST">
              <div class="schedule-sec">
                <div class="container">
                  <h4>Choose Delivery Schedule</h4>
                  <ul class="schedule-ul d-flex justify-content-between">
                    <li><label><input type="radio" name="Days" value="Every Day" class="my-radio" id="everyday" onclick="selectSchedule('everyday')" checked="checked" /> Every Day</label></li>
                    <li><label><input type="radio" name="Days" value="Alternate Days" class="my-radio" id="alternate" onclick="selectSchedule('alternate')" /> Alternate Days</label></li>
                    <li><label><input type="radio" name="Days" value="Customise" class="my-radio" id="customise" onclick="selectSchedule('customise')" /> Customise</label></li>
                    <input type="hidden" name="schedule_type" id="schedule_type" value="everyday">
                    <input type="hidden" name="p_product_id" id="p_product_id" value="<?php echo $product_details['p_id']; ?>">
                    <input type="hidden" name="p_product_category" id="p_product_category" value="<?php echo $_GET['cat']; ?>">
                  </ul>


                  <div class="schedule-cart-sec my-sec2" id="everyday_area">
                    <div class="qty_info">
                      <div class="qty_inner">
                        <div class="input-group justify-content-center">
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus"
                              data-field="everydayquant[1]">
                              <i class="fa fa-minus"></i>
                            </button>
                          </span>
                          <input type="text" name="everydayquant[1]" class="input-number" value="1" min="1" max="10">
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="everydayquant[1]">
                              <i class="fa fa-plus"></i>
                            </button>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>


                  <div class="customise-sec my-sec2" id="customise_area" style="display: none;">
                      <ul class="d-flex justify-content-between">
                        <li>
                          <div class="cust-days">
                            M
                          </div>
                          <!-- cust-days -->

                          <div class="cust-check">
                            <i class="fa fa-check-circle"></i>
                          </div>
                          <!-- cust-check -->

                          <div class="cust-qty">
                            <div class="qty_info">
                              <div class="qty_inner">
                                <div class="">
                                  <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus"
                                      data-field="customiseMquant[1]">
                                      <i class="fa fa-minus"></i>
                                    </button>
                                  </span>
                                  <br>
                                  <input type="text" name="customiseMquant[1]" class="input-number" value="1" min="1" max="10">
                                  <br>
                                  <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="customiseMquant[1]">
                                      <i class="fa fa-plus"></i>
                                    </button>
                                  </span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- cust-qty -->
                        </li>


                        <li>
                          <div class="cust-days">
                            T
                          </div>
                          <!-- cust-days -->

                          <div class="cust-check">
                            <i class="fa fa-check-circle"></i>
                          </div>
                          <!-- cust-check -->

                          <div class="cust-qty">
                            <div class="qty_info">
                              <div class="qty_inner">
                                <div class="">
                                  <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus"
                                      data-field="customiseTquant[1]">
                                      <i class="fa fa-minus"></i>
                                    </button>
                                  </span>
                                  <br>
                                  <input type="text" name="customiseTquant[1]" class="input-number" value="1" min="1" max="10">
                                  <br>
                                  <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="customiseTquant[1]">
                                      <i class="fa fa-plus"></i>
                                    </button>
                                  </span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- cust-qty -->
                        </li>


                        <li>
                          <div class="cust-days">
                            W
                          </div>
                          <!-- cust-days -->

                          <div class="cust-check">
                            <i class="fa fa-check-circle"></i>
                          </div>
                          <!-- cust-check -->

                          <div class="cust-qty">
                            <div class="qty_info">
                              <div class="qty_inner">
                                <div class="">
                                  <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus"
                                      data-field="customiseWquant[1]">
                                      <i class="fa fa-minus"></i>
                                    </button>
                                  </span>
                                  <br>
                                  <input type="text" name="customiseWquant[1]" class="input-number" value="1" min="1" max="10">
                                  <br>
                                  <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="customiseWquant[1]">
                                      <i class="fa fa-plus"></i>
                                    </button>
                                  </span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- cust-qty -->
                        </li>


                        <li>
                          <div class="cust-days">
                            T
                          </div>
                          <!-- cust-days -->

                          <div class="cust-check">
                            <i class="fa fa-check-circle"></i>
                          </div>
                          <!-- cust-check -->

                          <div class="cust-qty">
                            <div class="qty_info">
                              <div class="qty_inner">
                                <div class="">
                                  <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus"
                                      data-field="customiseTHquant[1]">
                                      <i class="fa fa-minus"></i>
                                    </button>
                                  </span>
                                  <br>
                                  <input type="text" name="customiseTHquant[1]" class="input-number" value="1" min="1" max="10">
                                  <br>
                                  <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="customiseTHquant[1]">
                                      <i class="fa fa-plus"></i>
                                    </button>
                                  </span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- cust-qty -->
                        </li>


                        <li>
                          <div class="cust-days">
                            F
                          </div>
                          <!-- cust-days -->

                          <div class="cust-check">
                            <i class="fa fa-check-circle"></i>
                          </div>
                          <!-- cust-check -->

                          <div class="cust-qty">
                            <div class="qty_info">
                              <div class="qty_inner">
                                <div class="">
                                  <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus"
                                      data-field="customiseFquant[1]">
                                      <i class="fa fa-minus"></i>
                                    </button>
                                  </span>
                                  <br>
                                  <input type="text" name="customiseFquant[1]" class="input-number" value="1" min="1" max="10">
                                  <br>
                                  <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="customiseFquant[1]">
                                      <i class="fa fa-plus"></i>
                                    </button>
                                  </span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- cust-qty -->
                        </li>


                        <li>
                          <div class="cust-days">
                            S
                          </div>
                          <!-- cust-days -->

                          <div class="cust-check">
                            <i class="fa fa-check-circle"></i>
                          </div>
                          <!-- cust-check -->

                          <div class="cust-qty">
                            <div class="qty_info">
                              <div class="qty_inner">
                                <div class="">
                                  <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus"
                                      data-field="customiseSATquant[1]">
                                      <i class="fa fa-minus"></i>
                                    </button>
                                  </span>
                                  <br>
                                  <input type="text" name="customiseSATquant[1]" class="input-number" value="1" min="1" max="10">
                                  <br>
                                  <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="customiseSATquant[1]">
                                      <i class="fa fa-plus"></i>
                                    </button>
                                  </span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- cust-qty -->
                        </li>


                        <li>
                          <div class="cust-days">
                            S
                          </div>
                          <!-- cust-days -->

                          <div class="cust-check">
                            <i class="fa fa-check-circle"></i>
                          </div>
                          <!-- cust-check -->

                          <div class="cust-qty">
                            <div class="qty_info">
                              <div class="qty_inner">
                                <div class="">
                                  <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus"
                                      data-field="customiseSUNquant[1]">
                                      <i class="fa fa-minus"></i>
                                    </button>
                                  </span>
                                  <br>
                                  <input type="text" name="customiseSUNquant[1]" class="input-number" value="1" min="1" max="10">
                                  <br>
                                  <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="customiseSUNquant[1]">
                                      <i class="fa fa-plus"></i>
                                    </button>
                                  </span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- cust-qty -->
                        </li>

                      </ul>
                  </div>
                    <!-- customise-sec  -->



                <div class="alt-days-sec my-sec2" id="alternate_area" style="display: none;">
                    <div class="alt-days-select">
                      <select name="altdays" id="altdays">
                        <option>Every 2nd Day</option>
                        <option>Every 3rd Day</option>
                        <option>Every 4th Day</option>
                      </select>
                    </div>
                    <div class="qty_info">
                      <div class="qty_inner">
                        <div class="input-group justify-content-center">
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus"
                              data-field="alternatequant[1]">
                              <i class="fa fa-minus"></i>
                            </button>
                          </span>
                          <input type="text" name="alternatequant[1]" class="input-number" value="1" min="1" max="10">
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="alternatequant[1]">
                              <i class="fa fa-plus"></i>
                            </button>
                          </span>
                        </div>
                      </div>
                    </div>
                </div>



                </div>

              </div>
              <!-- customise -->

              <div class="start-date-sec">
                <div class="container">
                  <ul class="schedule-ul d-flex justify-content-between">
                    <li>
                      <i class="fa fa-calendar"></i> Start Date
                    </li>

                    <li>
                      <!-- <i class="fa fa-edit"></i> -->
                      <input type="date" id="delivery_start_date" name="delivery_start_date" required="required">
                    </li>


                  </ul>
                </div>
                <!-- container -->
              </div>
              <!-- start-date-sec -->



            <div class="subs-btn-sec text-center">
              <div class="container">
                <button class="my-btn" type="submit" name="submit_subscribe">Continue</button>

              </div>
              <!-- container -->
            </div>
            <!-- subs-btn-sec -->

        </form>

          </div>
        <!-- subscribe-sec -->

        <?php
        }
      }
    ?>

        <!-- Catle Sec -->
        <div class="catle-sec catle-sec2">
            <img src="latest/images/catle-img.png" class="img-responsive">
        </div>
        <!-- //Catle Sec -->


    </section>

<?php require_once('footer.php'); ?>