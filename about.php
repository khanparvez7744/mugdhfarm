<?php require_once('header.php'); ?>

<?php
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
?>
  <section>
<img src="images/mugdhBnr2.jpg" alt="" class="img-fluid">

    <div class="main-sec">
      <div class="container">
        <h2 class="site-title text-center mt-4">ABOUT US</h2>
        <p class="text-justify">
          <?php echo $about_content; ?>
        </p>
      </div>
      <!-- container -->
    </div>
    <!-- main-sec -->


    <div class="main-sec">
      <div class="container">
        <h2 class="site-title text-center">Our Mission</h2>

        <p class="text-justify"><?php echo $about_mission; ?></p>


      </div>
      <!-- container -->
    </div>


    <div class="main-sec founder-sec">
      <div class="container">


        <div class="row">
          <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 founder-left">
            <div class="block">
              <img src="latest/images/about/boy.png" class="img-responsive" alt="Image">
            </div>
            <!-- block -->
          </div>
          <!-- founder-left -->

          <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 founder-right">
            <h2 class="site-title">Founder's Message</h2>
            <div class="block">
              <p><?php echo $founder_message; ?></p>
            </div>
            <!-- block -->
          </div>
          <!-- founder-right -->

        </div>
        <!-- row -->


      </div>
      <!-- container -->
    </div>


    <!-- Catle Sec -->
    <div class="catle-sec">
      <img src="latest/images/catle-img.png" class="img-responsive">
    </div>
    <!-- //Catle Sec -->


  </section>
<?php require_once('footer.php'); ?>