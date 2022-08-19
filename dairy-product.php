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
          	<div class="row">
          		<div class="col-md-12">
          			<div id="recipeCarousel" class="carousel slide w-100" data-ride="carousel" data-interval="false">
				        <div class="carousel-inner w-100 fv-cat d-flex justify-content-around align-items-center flex-wrap" role="listbox">
				            <div class="carousel-item row no-gutters active">
				            	<?php	
				            		$i = 1;				
						  			$statement = $pdo->prepare("SELECT * FROM tbl_tags");		
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
									foreach ($result as $row) {
										if($i <= 4){
										    ?>
										    	<div class="col-3 float-left">										    		
										      		<a href="dairy-product.php?tag=<?php echo $row['tags_id']; ?>">
										      			<input type="radio" name="tags_name" value="<?php echo $row['tags_name']; ?>" onclick="selectTag('<?php echo $row['tags_id']; ?>')" <?php if(isset($_GET['tag']) && $row['tags_id'] == $_GET['tag']) { echo "checked"; } ?> /> <?php echo $row['tags_name']; ?>
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
										if($i > 4){
										    ?>
										    	<div class="col-3 float-left">
										      		<a href="dairy-product.php?tag=<?php echo $row['tags_id']; ?>">
										      			<input type="radio" name="tags_name" value="<?php echo $row['tags_name']; ?>" onclick="selectTag('<?php echo $row['tags_id']; ?>')" <?php if(isset($_GET['tag']) && $row['tags_id'] == $_GET['tag']) { echo "checked"; } ?> /> <?php echo $row['tags_name']; ?>
										      		</a>
										      	</div>
										    <?php
										}
										$i++;
									}
								?>
				            </div>
				        </div>
				        <a class="carousel-control-prev" href="#recipeCarousel" role="button" data-slide="prev">
				            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
				            <span class="sr-only">Previous</span>
				        </a>
				        <a class="carousel-control-next" href="#recipeCarousel" role="button" data-slide="next">
				            <span class="carousel-control-next-icon" aria-hidden="true"></span>
				            <span class="sr-only">Next</span>
				        </a>
				    </div>
          		</div>
          	</div>

            <div class="fv-listing">
              <ul class="d-flex justify-content-center flex-wrap">

              	<?php
              		if(isset($_GET['tag'])){
              			$statement = $pdo->prepare("SELECT * FROM tbl_product_tags WHERE tags_id=".$_GET['tag']);
						$statement->execute();
						$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
						foreach ($result as $row2){
							$p_id = $row2['p_id'];
							$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_is_active=1 AND p_id = ".$p_id);
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);
							foreach ($result as $row) {
							    ?>
							    	<li>
					                  <div class="block">
					                    <div class="fv-img">
					                      <a href="product-details.php?id=<?php echo $row['p_id']; ?>"><img src="assets/uploads/<?php echo $row['p_featured_photo']; ?>" class="img-responsive" alt="Image"></a>
					                    </div>
 <b>Price: &#8377;<?php echo $row['p_current_price']; ?></b>
					                    <div class="fv-btns">										
					                      <a href="#" class="my-btn orange">Subscribe</a>
					                      <a href="#" class="my-btn">Add to Cart</a>
					                    </div>
					                  </div>
					                </li>
							    <?php
							}
						}
              		}else{
              			$statement = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id=7");
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

					                    <div class="fv-btns">
					                      <a href="#" class="my-btn orange">Subscribe</a>
					                      <a href="#" class="my-btn">Add to Cart</a>
					                    </div>
					                  </div>
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
	
	.slick-slide {
	    margin: 10px;
	    width: auto !important;
	}

	.slick-slider
	{
	    position: relative;
	    display: block;
	    box-sizing: border-box;
	    -webkit-user-select: none;
	    -moz-user-select: none;
	    -ms-user-select: none;
	            user-select: none;
	    -webkit-touch-callout: none;
	    -khtml-user-select: none;
	    -ms-touch-action: pan-y;
	        touch-action: pan-y;
	    -webkit-tap-highlight-color: transparent;
	}

	.slick-list
	{
	    position: relative;
	    display: block;
	    overflow: hidden;
	    margin: 0;
	    padding: 0;
	}
	.slick-list:focus
	{
	    outline: none;
	}
	.slick-list.dragging
	{
	    cursor: pointer;
	    cursor: hand;
	}

	.slick-slider .slick-track,
	.slick-slider .slick-list
	{
	    -webkit-transform: translate3d(0, 0, 0);
	       -moz-transform: translate3d(0, 0, 0);
	        -ms-transform: translate3d(0, 0, 0);
	         -o-transform: translate3d(0, 0, 0);
	            transform: translate3d(0, 0, 0);
	}

	.slick-track
	{
	    position: relative;
	    top: 0;
	    left: 0;
	    display: block;
	}
	.slick-track:before,
	.slick-track:after
	{
	    display: table;
	    content: '';
	}
	.slick-track:after
	{
	    clear: both;
	}
	.slick-loading .slick-track
	{
	    visibility: hidden;
	}

	.slick-slide
	{
	    display: none;
	    float: left;
	    height: 100%;
	    min-height: 1px;
	}
	[dir='rtl'] .slick-slide
	{
	    float: right;
	}
	.slick-slide img
	{
	    display: block;
	}
	.slick-slide.slick-loading img
	{
	    display: none;
	}
	.slick-slide.dragging img
	{
	    pointer-events: none;
	}
	.slick-initialized .slick-slide
	{
	    display: block;
	}
	.slick-loading .slick-slide
	{
	    visibility: hidden;
	}
	.slick-vertical .slick-slide
	{
	    display: block;
	    height: auto;
	    border: 1px solid transparent;
	}
	.slick-arrow.slick-hidden {
	    display: none;
	}
</style>

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
    right: -32px;
    top: 10%;
  }

  .carousel-control-prev-icon:after {
    content: '<';
    font-size: 35px;
    font-weight: bold;
    color: #14b5e3;
    position: absolute;
    left: -32px;
    top: 10%;
  }
</style>
<?php require_once('footer.php'); ?>