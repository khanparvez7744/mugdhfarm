<?php
// modal popup file is here
require_once("homepopup.php");
    $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row)
    {
        $footer_about = $row['footer_about'];
        $contact_email = $row['contact_email'];
        $contact_phone = $row['contact_phone'];
        $contact_address = $row['contact_address'];
        $footer_copyright = $row['footer_copyright'];
        $total_recent_post_footer = $row['total_recent_post_footer'];
        $total_popular_post_footer = $row['total_popular_post_footer'];
        $newsletter_on_off = $row['newsletter_on_off'];
        $before_body = $row['before_body'];
    }
?>

    <footer>
        <div class="footer_detail">
            <div class="container">
                <div class="inner">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="footer-logo">
                                <a href="#"><img src="latest/images/logo.png" class="img-fluid"></a>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <h3 class="text-uppercase">Contact Us</h3>
                            <ul class="ft_link">
                                <li><?php echo $contact_address; ?></li>
                                <li>Phone: <a href="tel:<?=$contact_phone;?>"><?=$contact_phone; ?></a></li>
                                <li>Email: <a href="mailto:<?=$contact_email;?>"><?=$contact_email; ?></a></li>
                            </ul>
                        </div>

                        <div class="col-md-3">
                            <h3 class="text-uppercase">Links</h3>
                            <ul class="ft_link">
                                <li><a href="about.php">About Mugdh</a></li>
                                <li><a href="how-we-do.php">Our Process</a></li>
                                <li><a href="contact.php">Contact</a></li>
                                <li><a href="privacy-policy.php">Privacy Policy</a></li>
                                <li><a href="t&c.php">Terms & Conditions</a></li>
                            </ul>
                        </div>

                       <div class="col-md-3">
                            <h3 class="text-white">Connect with us</h3>
                            <ul class="ft_social d-flex">
                                <li><a href="https://www.facebook.com/mugdhfarm" class="iconFB" target="_blank"><i class="fa fa-facebook"></i></a></li>
<!--                                 <li><a href="https://www.twitter.com/mugdha" class="iconTwitter" target="_blank"><i class="fa fa-twitter"></i></a></li> -->
                                <li><a href="https://instagram.com/mugdhfarm?igshid=1tcfu4kwdf6p1" class="iconLinked" target="_blank"><i class="fa fa-instagram"></i></a></li>
                                <!-- <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                                <li><a href="#" class="iconInsta"><i class="fa fa-instagram"></i></a></li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
               <div class="row">
                  <div class="col sm-6">
                     <small>Copyright © Mugdhfarm. All Rights Reserved.</small>
                  </div>
                  <div class="col sm-6 text-right">
                  <small>Website designed & developed by <a href="https://sociapa.com/" class="text-white" target="_blank">Sociapa.</a></small>
                  </div>
                </div>
        </div>
    </footer>
    <div id="bv-modal-address___BV_modal_outer_" style="position: absolute; z-index: 1040;display: none;">
                  <div id="bv-modal-address" role="dialog" aria-labelledby="bv-modal-address___BV_modal_title_" aria-describedby="bv-modal-address___BV_modal_body_" class="modal fade show" aria-modal="true" style="display: block;">
                     <div class="modal-dialog modal-xl">
                        <span tabindex="0"></span>
                        <div role="document" id="bv-modal-address___BV_modal_content_" tabindex="-1" class="modal-content">
                           <header id="bv-modal-address___BV_modal_header_" class="modal-header">
                              <button type="button" aria-label="Close" class="close" onclick="closeLocationModal()" style="z-index: 1111; padding: 20px;">×</button>
                           </header>
                           <div id="bv-modal-address___BV_modal_body_" class="modal-body">
                              <div data-v-7d77ac60="" class="row">
                                 <div data-v-7d77ac60="" class="col-12 col-sm-12 col-md-12">
                                    <div data-v-7d77ac60="" class="userAddress-block text-center ui-front">
                                       <div data-v-7d77ac60="" class="headerAddressSection">
                                          <div data-v-7d77ac60="" class="row">
                                             <div data-v-7d77ac60="" class="col-12 col-sm-12 col-md-12">
                                                <p data-v-7d77ac60="" style="float: right;"><a data-v-7d77ac60="" class="underlineText edit_location" onclick="clearUserAddress()" style="cursor: pointer;">Clear Address</a></p>
                                                <form id="search_area_form">
                                                   <input id="userAddress" placeholder="Search Location" class="form-control pac-target-input" autocomplete="off" style="width: 100%;" onkeyup="getSuggestedLocations()">
                                                   <input id="userLatLong" autocomplete="off" style="display: none;">
                                                   <div data-v-7d77ac60="" id="madal-error-address" class="error-address"></div>
                                                </form>
                                             </div>
                                          </div>
                                          <br data-v-7d77ac60="">
                                          <div data-v-7d77ac60="" class="row">
                                            <div data-v-7d77ac60="" class="col-3 col-sm-3 col-md-3 "> </div>
                                             <div data-v-7d77ac60="" class="col-6 col-sm-6 col-md-6 ">
                                                <button data-v-7d77ac60="" mat-raised-button="" value="" class="mat-raised-button ng-star-inserted btn btn-lg btn-block userAddress" onclick="getLocation()" style="font-size: 15px;">
                                                   Pick Current Location
                                                   <div data-v-7d77ac60="" matripple="" class="mat-button-ripple mat-ripple"></div>
                                                   <div data-v-7d77ac60="" class="mat-button-focus-overlay"></div>
                                                </button>
                                             </div>
                                             <div data-v-7d77ac60="" class="col-3 col-sm-3 col-md-3 "> </div>
                                          </div>
                                          <!---->
                                       </div>
                                    </div>
                                    <br data-v-7d77ac60="">
                                    <div data-v-7d77ac60="" class="row">
                                       <div data-v-7d77ac60="" class="col-12 col-sm-12 col-md-12 ">
                                          <div data-v-7d77ac60="" fxlayoutalign="center center" class="dv-btn" style="place-content: center; align-items: center; flex-direction: row; box-sizing: border-box; display: flex;">
                                             <button data-v-7d77ac60="" mat-raised-button="" value="" class="mat-raised-button btn btn-info btn-round btn-lg btn-block dv-primary-btn" onclick="saveAndContinue()" style="background-color: #14b5e3; border-color: #14b5e3;">
                                                <span data-v-7d77ac60="" class="mat-button-wrapper">Save &amp; Continue</span>
                                                <div data-v-7d77ac60="" matripple="" class="mat-button-ripple mat-ripple"></div>
                                                <div data-v-7d77ac60="" class="mat-button-focus-overlay"></div>
                                             </button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!---->
                        </div>
                        <span tabindex="0"></span>
                     </div>
                  </div>
                  <div id="bv-modal-address___BV_modal_backdrop_" class="modal-backdrop"></div>
               </div>


    <script src="latest/js/popper.min.js"></script>
    <script src="latest/js/bootstrap.min.js"></script>
    <script src="latest/js/main.js"></script>
    <script src="latest/js/owl.carousel.js"></script>
    <script src="latest/js/jquery.pogo-slider.min.js"></script>
    <script src="latest/js/scripts.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyDgv2kbPBSP1qzq3wKIWrgcyV24P-_BFSk"></script>
    <script>
        var owl = $('.testimonial-slider');
        owl.owlCarousel({
            margin: 0,
            loop: true,
            dots:true,
            nav: false,
            autoplay: false,
            items: 1,
            center:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1,
                }
            }
        })
    </script>
    <script src="assets/js/jquery.cookie.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
    <script src="assets/js/jquery.redirect.js"></script>
    <script>
        $(document).ready(function(){
            $('.customer-logos').slick({
                slidesToShow: 6,
                slidesToScroll: 1,
                autoplay: false,
                autoplaySpeed: 1500,
                arrows: false,
                dots: false,
                pauseOnHover: false,
                responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 4
                    }
                }, {
                    breakpoint: 520,
                    settings: {
                        slidesToShow: 3
                    }
                }]
            });
        });
        function selectTag(url){
            location.href = url;
        }
    </script>
    <style>
        .fv-listing .my-btn {
            width: 100%;
        }
        .cart_data_header{
            color: red;
            font-weight: bold;
        }
    </style>
    <script>
       function getSuggestedLocations() {
          initialize();
       }
       function redirectToActualLink(actual_link){
          window.location.href = actual_link;
       }
       function saveAndContinue(){
          var address = $("#userAddress").val();
                $("#searchAddress").text(address);
                $("#mugdha_select_location").text(address.substr(0, 50));
                closeLocationModal();
       }
       function initialize() {
         var input = document.getElementById('userAddress');
         var autocomplete = new google.maps.places.Autocomplete(input);
                google.maps.event.addListener(autocomplete, 'place_changed', function () {
                    var place = autocomplete.getPlace();
                    console.log(place);
                    $("#userAddress").attr('value', place.name);
                    $("#userLatLong").attr('value',  place.geometry.location.lat()+','+ place.geometry.location.lng());
                });
       }
        function confirmDelete()
        {
            return confirm("Do you sure want to delete this data?");
        }
        function openLocationModal(){
            $('#bv-modal-address___BV_modal_outer_').css('display', 'block');
        }
        function closeLocationModal(){
            $('#bv-modal-address___BV_modal_outer_').css('display', 'none');
        }
        function getLocation() {
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
          } else {
             $("#madal-error-address").text('Geolocation is not supported by this browser.');
          }
        }
       function clearUserAddress(){
          $("#userLatLong").attr('value', '');
          $("#userAddress").attr('value', '');
          $("#mugdha_select_location").text();
       }

        function showPosition(position) {
          $("#userLatLong").attr('value', position.coords.latitude+","+position.coords.longitude);
          url = "https://maps.googleapis.com/maps/api/geocode/json?latlng="+position.coords.latitude+","+position.coords.longitude+"&key=AIzaSyDgv2kbPBSP1qzq3wKIWrgcyV24P-_BFSk";
          $.ajax({
            type: "POST",
            url: url,
            data: {action: 'test'},
            dataType:'JSON',
            success: function(response){
                console.log("google api");
                console.log(response);
              //console.log(response.results[0].formatted_address);
                $("#userAddress").attr('value', response.results[0].formatted_address);
                $("#searchAddress").text(response.results[0].formatted_address);
                $("#mugdha_select_location").text(response.results[0].formatted_address.substr(0, 50));
            }
          });
        }
        $(function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
             } else {
                $("#madal-error-address").text('Geolocation is not supported by this browser.');
             }
        });
        $("#mugdha_login_form").submit(function(e){
              e.preventDefault();
               $("#mugdha_login_form_btn").attr('disabled', 'disabled');
               $("#mugdha_login_form_btn_text").text('Loading....');
              var mobile = $("#mobile").val();
              var random_number = Math.floor(100000 + Math.random() * 900000);
              if(mobile == '9876543210'){
                 $.ajax({
                    type: "POST",
                    url: "ajax-call.php",
                    data: {action: 'send_dummy_otp', mobile : mobile, otp: random_number},
                    cache: false,
                    success: function(response)
                    {
                       console.log(response);
                       if(response.status == '200'){
                          $("#login_invalid_area").text(response.message);
                          $("#login_invalid_area").css('color', 'green');
                          $("#login_invalid_area").css('display', 'block');
                          setTimeout(function() {
                             $("#mugdha_login_area").css('display', 'none');
                             $("#mugdha_otp_area").css('display', 'block');
                          }, 500);
                       }else{
                          $("#login_invalid_area").text(response.message);
                          $("#login_invalid_area").css('color', '#dc3545');
                          $("#login_invalid_area").css('display', 'block');
                       }
                    }
                 });
              }else{
                 $.ajax({
                    type: "POST",
                    url: "ajax-call.php",
                    data: {action: 'send_otp', mobile : mobile, otp: random_number},
                    cache: false,
                    success: function(response)
                    {
                       console.log(response);
                       if(response.status == '200'){
                          $("#login_invalid_area").text(response.message);
                          $("#login_invalid_area").css('color', 'green');
                          $("#login_invalid_area").css('display', 'block');
                          setTimeout(function() {
                             $("#mugdha_login_area").css('display', 'none');
                             $("#mugdha_otp_area").css('display', 'block');
                          }, 500);
                       }else{
                          $("#login_invalid_area").text(response.message);
                          $("#login_invalid_area").css('color', '#dc3545');
                          $("#login_invalid_area").css('display', 'block');
                       }
                    }
                 });
              }
           });
           $("#mugdha_otp_form").submit(function(e){
              e.preventDefault();
              var otp = $("#u-otp").val();
              var mobile = $("#mobile").val();
              $.ajax({
                    type: "POST",
                    url: "ajax-call.php",
                    data: {action: 'verify_otp', mobile : mobile, otp: otp},
                    cache: false,
                    success: function(response)
                    {
                       if(response.status == '200'){
                          $("#otp_invalid_area").text(response.message);
                          $("#otp_invalid_area").css('color', 'green');
                          $("#otp_invalid_area").css('display', 'block');
                          // addOrderDataToCart(mobile);
                          window.location.href = "add-item-to-cart.php";
                       }else{
                          $("#otp_invalid_area").text(response.message);
                          $("#otp_invalid_area").css('color', '#dc3545');
                          $("#otp_invalid_area").css('display', 'block');
                       }
                    }
              });
           });
           function resendOtp(){
              e.preventDefault();
              var mobile = $("#mobile").val();
              var random_number = Math.floor(100000 + Math.random() * 900000);
              $.ajax({
                    type: "POST",
                    url: "ajax-call.php",
                    data: {action: 'send_otp', mobile : mobile, otp: random_number},
                    cache: false,
                    success: function(response)
                    {
                       if(response.status == '200'){
                          $("#otp_invalid_area").text(response.message);
                          $("#otp_invalid_area").css('color', 'green');
                          $("#otp_invalid_area").css('display', 'block');
                       }else{
                          $("#otp_invalid_area").text(response.message);
                          $("#otp_invalid_area").css('color', '#dc3545');
                          $("#otp_invalid_area").css('display', 'block');
                       }
                    }
              });
           }
           function editLocation(){
              openLocationModal();
           }
           // function openAddressArea(){
           //    $("#mugdha_address_area").css('display', 'block');
           // }
           // function AddDataToAddressForm(mobile){
           //    if(mobile){
           //       $.ajax({
           //          type: "POST",
           //          url: "ajax-call.php",
           //          data: {action: 'fetch_user_data', mobile : mobile},
           //          cache: false,
           //          success: function(response)
           //          {
           //             console.log(response);
           //             if(response.status == '200'){
           //                if(response.user_data.address != ''){
           //                   $("#searchAddress").html(response.user_data.address);
           //                }
           //                $("#profile_name").val(response.user_data.full_name);
           //                $("#profile_email").val(response.user_data.email);
           //                $("#address1_house_num").val(response.user_data.house_number);
           //                $("#address2_landmark").val(response.user_data.locality);
           //             }
           //          }
           //       });
           //    }
           // }
           function addOrderDataToCart(mobile){
              var product_data = JSON.parse($.cookie('product_data'));

              if(product_data){
                 $.ajax({
                    type: "POST",
                    url: "ajax-call.php",
                    data: {action: 'add_data_to_cart', mobile : mobile, product_list: product_data['product_list'], pre_post: product_data['pre_post'], delivery_date: product_data['delivery_date']},
                    cache: false,
                    success: function(response)
                    {
                       if(response.status == '200'){
                          $.cookie('request_id', response.request_id);
                          //$.cookie('product_data', '');
                       }else{
                          $.cookie('request_id', '');
                       }
                    }
                 });
              }
           }
           $("#address_submit_form").submit(function(e){
              console.log('calling submit address');
              e.preventDefault();

              var searchAddress = $("#searchAddress").text();
              var profile_name = $("#profile_name").val();
              var profile_email = $("#profile_email").val();
              var address1_house_num = $("#address1_house_num").val();
              var address2_landmark = $("#address2_landmark").val();

              if(searchAddress == '' || searchAddress == undefined){
                 $("#searchAddress").addClass('invalid_input_area');
              }
              else if(profile_name == '' || profile_name == undefined){
                 $("#profile_name").addClass('invalid_input_area');
              }
              else if(address1_house_num == '' || address1_house_num == undefined){
                 $("#address1_house_num").addClass('invalid_input_area');
              }else{
                    $.ajax({
                       type: "POST",
                       url: "ajax-call.php",
                       data: {action: 'submit_address_form', searchAddress: searchAddress, profile_name: profile_name, profile_email: profile_email, address1_house_num: address1_house_num, address2_landmark: address2_landmark },
                       cache: false,
                       success: function(response)
                       {
                          window.location.href = "order.php";
                       }
                    });
              }
           });
           function selectSchedule(id){
            var area = id+'_area';
            $("#schedule_type").val(id);
            $("#everyday_area").css('display', 'none');
            $("#alternate_area").css('display', 'none');
            $("#customise_area").css('display', 'none');

            $("#"+area).css('display', 'block');
           }
        //   function increaseQuantity(key){
        //     var exampleInputQuantity = $("#exampleInputQuantity").val();
        //             $.ajax({
        //               type: "POST",
        //               url: "ajax-call.php",
        //               data: {action: 'increase_decrease_quantity', key: key, exampleInputQuantity: exampleInputQuantity },
        //               cache: false,
        //               success: function(response)
        //               {
        //                   window.location.href = "cart.php";
        //               }
        //             });
        //   }


        //quantity decrese
        function dec_quantity(key,id){
            let $box=$('#qty_input_'+key);
            let $p_price=$('#p_total_'+key);
            if($box.val()>1){
             $($box).val(function(i,oldval){
                        return --oldval;
                     });
            }
            $.ajax({
                      type: "POST",
                      url: "ajax-call.php",
                      data: {action: 'inc_dec_quantity', key: key, id: id, value: $box.val()},
                      success: function(data,success)
                      {
                          let value=JSON.parse(data);
                          $($p_price).html(value[0]);
                          $('#sub_total').html(value[1]);
                          $('#total_cost').html(value[1]);
                      }
                    });
        }
            //quantity increase new code by dhiraj
        function inc_quantity(key,id){
            let $box=$('#qty_input_'+key);
            let $p_price=$('#p_total_'+key);
             $($box).val(function(i,oldval){
                        return ++oldval;
                     });
            $.ajax({
                      type: "POST",
                      url: "ajax-call.php",
                      data: {action: 'inc_dec_quantity', key: key, id: id, value: $box.val()},
                      success: function(data,success)
                      {
                          let value=JSON.parse(data);
                          $($p_price).html(value[0]);
                          $('#sub_total').html(value[1]);
                          $('#total_cost').html(value[1]);
                      }
                    });
        }

           //update cart count new code by dhiraj
           function myCart(){
            var cart_trigger="cart_trigger";
       $.ajax({
        url:"ajax-call.php",
        type:"POST",
        data:{cart_trigger:cart_trigger},
        success:function(data,status){
            $('#cart_count').html(data);
        }
    });
           }

           $(document).ready(function() {
               //for date desible
               $(function(){
                  var dt= new Date();
                  var month = dt.getMonth() + 1;
                  var day = dt.getDate() + 1;
                  var year = dt.getFullYear();
                  if(month<10)
                   month = '0'+ month.toString();
                  if(day<10)
                  day='0' + day.toString();
                  var maxDate = year +'-'+month+'-'+day;
                  $('#delivery_start_date').attr('min', maxDate);
               });
            myCart();
            inc_quantity(key,id);
            dec_quantity(key,id);
        });
        // !update cart count
           function applyCoupan(){
            var coupan_code_area = $("#coupan_code_area").val();
                    $.ajax({
                       type: "POST",
                       url: "ajax-call.php",
                       data: {action: 'verify_coupan_code', coupan_code_area: coupan_code_area },
                       cache: false,
                       success: function(response)
                       {
                          console.log(response);
                          if(response.status == 200){
                            $("#coupan_code_area"). css('border', '1px solid green');
                            $(".coupon-code-applied").css('color', 'green');
                            $(".coupon-code-applied").html('<i class="fa fa-check"></i>  Coupon Code apply');

                            var total_pay = $("#total_pay_amount").text();
                            var user_wallet_balance = $("#user_wallet_balance").text();
                            var discount_amount = ( parseInt(total_pay) * parseInt(response.discount) ) / 100;
                            if(parseInt(discount_amount) > 100){
                              discount_amount = 100;
                            }
                            $("#discount_area").html(response.discount);
                            total_pay = parseInt(total_pay) - parseInt(discount_amount);
                            $("#total_pay_amount").html(total_pay);
                            var btn_html = '';
                            if(parseInt(total_pay) > parseInt(user_wallet_balance)){
                              var remain_balance = parseInt(total_pay) - parseInt(user_wallet_balance);
                              btn_html += '<div><button class="my-btn">Add &#8377; '+remain_balance+' to continue</button></div>';
                            }else if(parseInt(total_pay) <= parseInt(user_wallet_balance)){
                              btn_html += '<div><button class="my-btn" onclick="placeUserOrder()" id="place_order_btn">Place Order</button></div>';
                            }

                            $("#submit_btn_proceed").html(btn_html);
                          }else{
                            $("#coupan_code_area").css('border', '1px solid red');
                            $(".coupon-code-applied").css('color', 'red');
                            $(".coupon-code-applied").html('<i class="fa fa-check"></i>  Invalid coupan');
                          }
                       }
                    });
           }
           function placeUserOrder(){
            $("#place_order_btn").html('<i class="fa fa-refresh fa-spin"></i>  Please Wait');
            $("#place_order_btn").attr('disabled', 'disabled');
            var coupan = $("#discount_area").text();
                    $.ajax({
                       type: "POST",
                       url: "ajax-call.php",
                       data: {action: 'place_user_order', coupan: coupan },
                       cache: false,
                       success: function(response)
                       {
                          console.log(response);
                          if(response.status == 200){
                            $("#cart_data_header_icon").css('display', 'none');
                            $("#order_contain_area").css('display', 'none');
                            $("#order_placed_area").css('display', 'block');
                          }else{
                            $("#place_order_btn").html('Place Order');
                            $("#place_order_btn").removeAttr('disabled');
                            $(".coupon-code-applied").css('color', 'red');
                            $(".coupon-code-applied").html(response.message);
                          }
                       }
                    });
              $("#place_order_btn").html('Place Order');
           }

           function addPaymentToWallet(amount){
            $("#add_pyment_to_wallet").html('<i class="fa fa-refresh fa-spin"></i>  Please Wait');
            $("#add_pyment_to_wallet").attr('disabled', 'disabled');
            var coupan = $("#discount_area").text();
                    $.ajax({
                       type: "POST",
                       url: "ajax-call.php",
                       data: {action: 'add_pyment_to_wallet', amount: amount },
                       cache: false,
                       success: function(response)
                       {
                          console.log(response);
                          if(response.status == 200){
                          	$.redirect(response.data.action, {key: response.data.key, hash: response.data.hash,txnid: response.data.txnid,amount: response.data.data.amount,firstname: response.data.data.firstname,email: response.data.data.email,phone: response.data.data.phone,productinfo: response.data.data.productinfo,surl: response.data.data.surl,furl: response.data.data.furl,service_provider: response.data.data.service_provider});
                            //$("#cart_data_header_icon").css('display', 'none');
                            //$("#order_contain_area").css('display', 'none');
                            //$("#order_placed_area").css('display', 'block');
                          }else{
                            $("#place_order_btn").html('Place Order');
                            $("#place_order_btn").removeAttr('disabled');
                            $(".coupon-code-applied").css('color', 'red');
                            $(".coupon-code-applied").html(response.message);
                          }
                       }
                    });
              $("#place_order_btn").html('Place Order');
           }
    </script>




    <script>
        function openSelectedLink(evt, areaID) {
          var i, tabcontent, tablinks;
          tabcontent = document.getElementsByClassName("tabcontent");
          for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
          }
          tablinks = document.getElementsByClassName("tablinks");
          for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
          }
          document.getElementById(areaID).style.display = "block";
          evt.currentTarget.className += " active";
          if(areaID == 'add_wallet_balance'){
            document.getElementById('wallet_area').className += " active";
          }
        }

        // Get the element with id="defaultOpen" and click on it
        var myEle = document.getElementById("defaultOpen");
        if(myEle){
            document.getElementById("defaultOpen").click();
        }

    </script>
      <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>


      <script>
        $(document).ready(function() {
            $('#my_order_tab').DataTable({searching: false, "pageLength": 6 });
        });
        $(document).ready(function() {
            $('#history_tab').DataTable({searching: false, "pageLength": 2});
        });
        $(document).ready(function() {
            $('#wallet_tab').DataTable({searching: false, "pageLength": 6});
        });
      </script>


      <script>
      if ($(window).width() > '767')
    {
  $('.myLinkedDropdown .shopChild+i').mouseenter(function() {
    $('.myLinkedDropdown').addClass('show')
    $('.myLinkedDropdown').children('.dropdown-menu-wide').addClass('show');
  });
  $('.myLinkedDropdown .shopChild+i').click(function() {
    $('.myLinkedDropdown').removeClass('show');
    $('.myLinkedDropdown').children('.dropdown-menu-wide').removeClass('show');
  });
    }
     if ($(window).width() < '767')
    {
      $('.myLinkedDropdown .shopChild+i').click(function() {
    $('.myLinkedDropdown').addClass('show')
    $('.myLinkedDropdown').children('.dropdown-menu-wide').addClass('show');
  });
    }
</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!--/***********start owl carousel*************/-->
<script>
$(document).ready(function(){
    $('.owl-carousel').owlCarousel({
       items: 3,
       margin:50,
       loop:true,
       navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
       nav:true,
       dots: false,
       autoplay:true,
          responsive:{
              0:{
                  items:1
              },
              600:{
                  items:3
              },
              1000:{
                  items:3
              }
          }
    });

    $('.owlUl i').addClass('fa-2x p-2 text-light');
    $('.owlUl .owl-next').addClass('bg-warning2');
    $('.owlUl .owl-prev').addClass('bg-warning2');


    });
    </script>
    <!--************end owl carousel**************-->


