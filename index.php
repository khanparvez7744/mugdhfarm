<?php require_once('header.php') ?>
<?php
    $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row)
    {
        $cta_title = $row['cta_title'];
        $cta_content = $row['cta_content'];
        $cta_read_more_text = $row['cta_read_more_text'];
        $cta_read_more_url = $row['cta_read_more_url'];
        $cta_photo = $row['cta_photo'];
        $contact_map_iframe              = $row['contact_map_iframe'];
        $featured_product_title = $row['featured_product_title'];
        $featured_product_subtitle = $row['featured_product_subtitle'];
        $latest_product_title = $row['latest_product_title'];
        $latest_product_subtitle = $row['latest_product_subtitle'];
        $popular_product_title = $row['popular_product_title'];
        $popular_product_subtitle = $row['popular_product_subtitle'];
        $total_featured_product_home = $row['total_featured_product_home'];
        $total_latest_product_home = $row['total_latest_product_home'];
        $total_popular_product_home = $row['total_popular_product_home'];
        $home_service_on_off = $row['home_service_on_off'];
        $home_welcome_on_off = $row['home_welcome_on_off'];
        $home_featured_product_on_off = $row['home_featured_product_on_off'];
        $home_latest_product_on_off = $row['home_latest_product_on_off'];
        $home_popular_product_on_off = $row['home_popular_product_on_off'];
        $banner_home = $row['banner_home'];
    }
?>

<style type="text/css">
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        height: 50px;
        width: 50px;
        background-image: none;
    }

    .carousel-control-next-icon:after {
        content: '>';
        font-size: 35px;
        font-weight: bold;
        color: #14b5e3;
        position: absolute;
        right: -27px;
        top: 37%;
    }

    .carousel-control-prev-icon:after {
        content: '<';
        font-size: 35px;
        font-weight: bold;
        color: #14b5e3;
        position: absolute;
        left: -27px;
        top: 37%;
    }
</style>
<!-- whatsapp icon -->
<div class="whatsapp_img">
    <a href="https://wa.me/919667749141" target="_blank" class="whatsapp_btn"><img src="assets/uploads/WhatsApp.svg.png"
            width="50px" class="img-fluid"></a>
</div>
<!-- !whatsapp icon -->
<section class="homePage">
<div id="slider" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#slider" data-slide-to="0" class="active"></li>
    <li data-target="#slider" data-slide-to="1"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="images/mugdhBnr1.jpg" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="images/mugdhBnr2.jpg" alt="Second slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#slider" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#slider" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
    <div class="our-product">
        <div class="container">
            <h2 class="site-title text-center mb-4">OUR PRODUCTS</h2>
            <div class="row">
                <div class="col-sm-12 col-md-4 offset-md-4 col-lg-4 offset-lg-4">
                    <div class="card">
                        <img class="card-img-top" src="images/dairy.jpg" alt="Card image cap">
                        <div class="card-body">
                            <h2 class="site-title text-center">Dairy</h2>
                            <a href="product-category.php?category=7" class="site-button">Explore</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-light consuPart">
        <div class="container pt-1">
            <div style="margin: inherit; max-width: 800px;">
                <div class="row mt-5">
                    <div class="col-sm-12 col-lg-6 col-md-6 col-12">
                        <h2 class="">FOR CONSUMERS</h2>
                        <ul class="mt-3 mb-5">
                            <li class="p-2"><i class="fa fa-circle mr-2"></i>Recharge your Mugdh Wallet </li>
                            <li class="p-2"><i class="fa fa-circle mr-2"></i>Place order before 10pm</li>
                            <li class="p-2"><i class="fa fa-circle mr-2"></i>Receive the order next day Morning</li>
                        </ul>
                        <form action="product-category.php">
                            <button type="submit" class="btn btn-success px-5 mb-5">Buy now <i
                                    class="fa fa-shopping-bag mx-3"></i></button>
                        </form>
                    </div>
                    <div class="col-sm-12 col-lg-6 col-md-6 col-12">
                        <h2 class="">FOR PARTNERS</h2>
                        <ul class="mt-3 mb-5">
                            <li class="p-2"><i class="fa fa-circle mr-2"></i> Register with Us</li>
                            <li class="p-2"><i class="fa fa-circle mr-2"></i>Submit your Farm details</li>
                            <li class="p-2"><i class="fa fa-circle mr-2"></i>Helping Farmers in becoming Aatma- Nirbhar
                            </li>
                        </ul>
                        <button type="button" name="forpartners" class="btn btn-success px-2 mb-5" data-toggle="modal"
                            data-target="#Modal_partner">SIGN UP FOR PARTNERS <i
                                class="fa fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
            $title1= '';
            $description1='';
            $title2= '';
            $description2='';
            $title3= '';
            $description3='';
            $title4= '';
            $description4='';
            $m_image = '';

                      $statement = $pdo->prepare("SELECT * FROM tbl_home_content WHERE id=1");
                      $statement->execute();
                      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result as $row)
                      {
                        $title1= $row['title1'];
                        $description1=$row['description1'];
                        $title2= $row['title2'];
                        $description2=$row['description2'];
                        $title3= $row['title3'];
                        $description3=$row['description3'];
                        $title4= $row['title4'];
                        $description4=$row['description4'];
                      }
                      $statement = $pdo->prepare("SELECT * FROM tbl_home_content WHERE id=4");
                      $statement->execute();
                      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result as $row)
                      {
                        $m_image= $row['m_image'];
                      }
        ?>
    <div class="our-usp">
        <div class="container">
            <h2 class="site-title text-center text-white">OUR USP</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="usp-content-outer cus-margin left-arrow">
                        <img src="latest/images/usp-content-top2.png" class="img-fluid usp-content-top">
                        <div class="usp-content-inner">
                            <h4>
                                <?php echo $title1;?>
                            </h4>
                            <p>
                                <?php echo $description1; ?>
                            </p>
                        </div>
                    </div>
                    <div class="usp-content-outer left-arrow">
                        <img src="latest/images/usp-content-top1.png" class="img-fluid usp-content-top">
                        <div class="usp-content-inner">
                            <h4>
                                <?php echo $title2;?>
                            </h4>
                            <p>
                                <?php echo $description2; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="usp-img">
                        <!-- <img src="assets/uploads/<?php echo $m_image; ?>" class="img-fluid"> -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="usp-content-outer cus-margin right-arrow">
                        <img src="latest/images/usp-content-top3.png" class="img-fluid usp-content-top">
                        <div class="usp-content-inner">
                            <h4>
                                <?php echo $title3;?>
                            </h4>
                            <p>
                                <?php echo $description3; ?>
                            </p>
                        </div>
                    </div>
                    <div class="usp-content-outer right-arrow">
                        <img src="latest/images/usp-content-top4.png" class="img-fluid usp-content-top">
                        <div class="usp-content-inner">
                            <h4>
                                <?php echo $title4;?>
                            </h4>
                            <p>
                                <?php echo $description4; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
                      $statement = $pdo->prepare("SELECT * FROM tbl_home_content WHERE id=2");
                      $statement->execute();
                      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result as $row)
                      {
                        $m_image2= $row['m_image'];
                      }
        ?>
    <div class="delivery-section">
        <img src="assets/uploads/<?php echo $m_image2; ?>" class="img-fluid">
    </div>
    <div class="testimonial-section bg-light">
        <div class="container">
            <h3 class="site-title text-center">Our Customers Story</h3>
            <div class="owl-carousel owl-theme testimonial-slider">
                <?php
                      $statement = $pdo->prepare("SELECT * FROM tbl_customer_slider");
                      $statement->execute();
                      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result as $row)
                      {
                          ?>
                <div class="item">
                    <div class="testimonial-inner">
                        <img src="assets/uploads/<?php echo $row['photo']; ?>" class="img-fluid" alt="user">
                        <div class="testimonial-content">
                            <h4 class="person-title mt-4">
                                <?php echo $row['name']; ?>
                            </h4>
                            <p>
                                <?php echo $row['message']; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php
                      }
                    ?>

            </div>
        </div>
        <div class="testimonail-side-img">
            <img src="latest/images/testimonial-img.png" class="img-fluid">
        </div>
    </div>
    <div class="manage-app">
        <div class="container">
            <h3 class="site-title text-center">Manage Subscriptions by Yourself</h3>
            <h6 class="site-subtitle text-center">Changing your requirements can now be done in a few simple steps by
                the methods mentioned below-;</h6>
            <div class="row">
                <div class="col-md-8">
                    <div class="app-content">
                        <p>Use our Android/iOS App — Install Mugdh App from Playstore/Appstore and easily modify your
                            subscription for any given day. You can pause/resume, and manage your account.</p>
                        <p>Use our Website — Login on the website, go to the account section and you can make the
                            required modiﬁcations to your calendar.</p>
                        <p>Call / Whatsapp — You are just a call/ whatsapp away to make changes to your subscription.
                            Connect to us at our customer care Number minimum one day in advance if you want more/ less
                            quantity, or want to pause the deliveries</p>
                        <div class="app-btn d-flex mb-5">
                            <div class="android-btn">
                                <a href=".#" onClick="alert('Under Development')"><img src="latest/images/android.png"
                                        class="img-fluid"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                </div>
            </div>
        </div>
        <div class="app-phone">
            <img src="latest/images/app-phone.gif" class="img-fluid">
        </div>
    </div>
    <?php echo $contact_map_iframe; ?>
    <div class="catle-sec">
        <img src="latest/images/map-overlay.png" class="img-fluid" width="100%">
    </div>
</section>
<?php require_once('footer.php') ?>