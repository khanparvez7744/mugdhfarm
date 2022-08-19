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
?>
<section>

        <!-- Banner Sec -->
        <div class="banner-sec banner-inner">

            <div class="pogoSlider" id="js-main-slider2">
                <div class="pogoSlider-slide" data-transition="blocksReveal" data-duration="1000"
                    style="background-image:url(assets/uploads/<?php echo $banner_order; ?>);">
                </div>
              </div>
        </div>

        <div class="fruit-veg-sec my-sec">
          <div class="container">
            <div class="fv-cat d-flex justify-content-around align-items-center flex-wrap">
              <h3>Category</h3>
              
              <label>
                <input type="radio" name="Category" value="Dairy" /> Dairy
              </label>

              <label>
                <input type="radio" name="Category" value="Fruits" /> Fruits
              </label>

              <label>
                <input type="radio" name="Category" value="Vegetables" /> Vegetables
              </label>

            </div>
            <!-- fv-cat -->

            <div class="fv-listing">
              <ul class="d-flex justify-content-center flex-wrap">

              	<?php
              		$statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id = 9");
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
        				                    <div class="fv-img">
        				                      <a href="product-details.php?id=<?php echo $row['p_id']; ?>"><img src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" class="img-responsive" alt="Image"></a>
        				                    </div>
        				                    <!-- fv-img -->

        				                    <div class="fv-btns">
        				                      <a href="#" class="my-btn orange">Subscribe</a>
        				                      <a href="#" class="my-btn">Add to Cart</a>
        				                    </div>
        				                    <!-- fv-btns -->
        				                  </div>
        				                  <!-- block -->
        				                </li>
        						    <?php
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
<?php require_once('footer.php'); ?>