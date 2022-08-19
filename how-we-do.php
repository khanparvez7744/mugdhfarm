<?php require_once('header.php') ?>
<?php
$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
   $about_title = $row['farm_title'];
    $about_content = $row['farm_content'];
    $about_banner = $row['farm_banner'];
    $founder_message = $row['founder_message'];
}
?>
<section>
    <div class="banner-sec banner-inner banner-how">
        <div class="pogoSlider" id="js-main-slider2">
            <div class="pogoSlider-slide" data-transition="blocksReveal" data-duration="1000"
                style="background-image:url(assets/uploads/<?php echo $about_banner; ?>);">
            </div>
        </div>
    </div>
    <div class="pro-sec">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-12 col-xl-12 col-sm-12">
                    <h2 class="site-title text-center my-sm-5 my-3">Fresh Products From Farm to Your Table In Just Few Hours</h2>
                </div>
            </div>
            <div class="row pro-arrow howWeBoxRo">
                <div class="col-md-10 col-lg-3 col-sm-10 col-xl-3 mx-auto block-col rightArr1">
                    <div class="text-center">
                        <div class="arrow-right"></div>
                        <h5 style="margin-top:15px;" class="text-center">Own Farm</h5>
                        <p>Unlike any other brands we don’t collect milk from other farmers where the cattle health is
                            not taken care of. We have our own farms which are fully equipped with a dedicated team to
                            take good care of our cattle. For their wellbeing, we always have a team present of trained
                            veterinarians.</p>
                    </div>
                    <div>
                        <img src="assets/uploads/2m.png" class="block-img" width="330" height="180">
                    </div>
                </div>
                <div class="col-md-10 col-lg-3 col-sm-10 col-xl-3 mx-auto block-col rightArr2">
                    <div class="text-center">
                        <div class="arrow-right"></div>
                        <h5 class="text-center" style="margin-top:15px;">Quality Checks</h5>
                        <p>We keep a strict check on the cattle quality, fodder and processes of farm. We don’t use any
                            chemicals, pesticides or toxins.</p>
                    </div>
                    <div>
                        <img src="assets/uploads/3m.png" class="block-img mt-4" width="300" height="200">
                    </div>
                </div>
                <div class="col-md-10 col-lg-3 col-sm-10 col-xl-3 mx-auto block-col">
                    <div class="text-center">

                        <h5 class="text-center" style="margin-top:15px;">Hygiene Milking</h5>
                        <p>We ensure dairy cattle sheds and steers are waited multiple times during the day, making sure
                            that the milking is done with the correct procedures.</p>
                    </div>
                    <div>
                        <img src="assets/uploads/4m.png" class="block-img mt-4" width="300" height="200">
                    </div>
                </div>
            </div>
            <div class="row howWeBoxRo">
                <div class="col-md-10 col-lg-3 col-sm-10 col-xl-3 mx-auto block-col rightArr3">
                    <div class="text-center">
                        <div class="arrow-right"></div>
                        <h5 class="text-center" style="margin-top:15px;">Natural Goodness</h5>
                        <p>To retain the natural goodness of milk without any harmful bacterial growth, we chill the
                            milk at 2 Degree Celsius in Bulk Milk Coolers, this temperature helps milk keep it’s actual
                            nutrients.</p>
                    </div>
                    <div>
                        <img src="assets/uploads/5m.png" class="block-img  mt-4" width="300" height="200">
                    </div>
                </div>
                <div class="col-md-10 col-lg-3 col-sm-10 col-xl-3 mx-auto block-col rightArr4">
                    <div class="text-center">
                        <div class="arrow-right"></div>
                        <h5 class="text-center" style="margin-top:15px;">Packaging and Bottling</h5>
                        <p>After chilling, the milk is pressed in glass bottles to make sure that the cool temperature
                            is held for a longer time span. We seal the bottles at the farm to guarantee that the milk
                            is delivered in carefully designed state.</p>
                    </div>
                    <div>
                        <img src="assets/uploads/7m.png" class="block-img mt-1" width="300" height="200">
                    </div>
                </div>
                <div class="col-md-10 col-lg-3 col-sm-10 col-xl-3 mx-auto block-col">
                    <div class="text-center">
                        <h5 style="margin-top:15px;">How We Deliver</h5>
                        <p>The milk bottles are then packed in the protected boxes in our farm and are dispatched to all
                            our customer family within 3-4 hours.</p>
                    </div>
                    <div>
                        <img src="assets/uploads/8m.png" height="230" width="300px" class="block-img  mt-1">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="catle-sec">
        <img src="latest/images/catle-img.png" class="img-responsive">
    </div>
</section>
<?php require_once('footer.php') ?>