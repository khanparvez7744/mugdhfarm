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
    <div class="banner-sec banner-contact">
      <div class="pogoSlider" id="js-main-slider2">
        <div class="pogoSlider-slide" data-transition="blocksReveal" data-duration="1000"
          style="background-image:url(assets/uploads/privacy-policy.jpg">
        </div>
      </div>
    </div>
    <div class="main-sec">
      <div class="container">
        <h2 class="site-title text-center my-4">Mugdh farm - Privacy Policy</h2>
        <p class="text-justify">
          Mugdh Farms reserves the right to change or update this policy at any time.
       	Such changes shall be effective immediately upon posting to the Site.
        We understand how much you value your every purchase. We are committed
        to making your shopping experience a delightful one.
        </p>
        <h4>MEMBERSHIP POLICY</h4>
        <p class="text-justify">To be eligible for the Mugdh farms membership, you should be competent to
        enter into a contract i.e. you should have attained the age of majority
        according to the Indian law. Mugdh Farms is not targeted towards, nor
        intended for use by anyone who has not attained the age of majority.</p>
        <h4>RETURN POLICY</h4>
		    <p class="text-justify">Payment Refunds are applicable only in case of damaged product or delivery
        of incorrect product delivery.</br>
        You can Email Us at care@mugdhfarm.com within 48 hours from date of
        delivery. The details of the same should be shared with the Customer Support
        by email.</br>
        Most importantly, the Product should be in original condition</p>
        <h2 class="site-title text-center my-4">Refund and Cancellation Policy</h2>
		    <p class="text-justify">Our focus is complete customer satisfaction. In the event, if you are
        dissatisfied with the services provided, we will refund the money, provided the
        reasons are genuine and proved after investigation. Please read the fine prints
        of each deal before buying it, it provides all the details about the services or
        the product you purchase.</br>
        In case of dissatisfaction from our services, clients have the liberty to cancel
        their projects and request a refund from us. Our Policy for the cancellation and
        refund will be as follows:</p>
        <h4>CANCELLATION POLICY</h4>
        <p class="text-justify">For Cancellations, please contact us via contact us link.</br>
        Requests received 1 day prior to the end of the current service period will be
        treated as cancellation of services for the next service period.</p>
        <h4>REFUND POLICY</h4>
        <p class="text-justify">The Refund will be reflected within 2-3 working days.</br>
        If paid by credit card, refunds will be issued to the original credit card provided
        at the time of purchase and in case of payment gateway name payments
        refund will be made to the same account.</p>
      </div>
    </div>
    <div class="catle-sec">
      <img src="latest/images/catle-img.png" class="img-responsive">
    </div>
  </section>
<?php require_once('footer.php'); ?>