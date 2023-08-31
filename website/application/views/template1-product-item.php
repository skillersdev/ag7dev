<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  $this->load->view('index.html');
  $path_url = $this->config->item('path_url');

  $login_url = $this->config->item('login_url');
  $image_path = $this->config->item('base_path');
  $logo_img_path = $this->config->item('logo_img_path');

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title><?php echo $website; ?></title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="<?php echo $website; ?>" name="keywords">
  <meta content="<?php echo $website; ?>" name="description">
  <style>
    .fb-profile img.fb-image-lg{
      z-index: 0;
      width: 100%;  
      margin-bottom: 10px;
    }

    .fb-image-profile
    {
      margin: -90px 10px 0px 50px;
      z-index: 9;
      width: 20%; 
    }

    @media (max-width:768px)
    {
      
    .fb-profile-text>h1{
      font-weight: 700;
      font-size:16px;
    }

    .fb-image-profile
    {
      margin: -45px 10px 0px 25px;
      z-index: 9;
      width: 20%; 
    }
    }
    video {
      width: 100%;
      height: auto;
    }

    #mimage2 img {
      width: 100%;
      height: auto;
    } 

   

    
    @media (max-width:768px)
    {
      .slide h1 {
        font-size: 30px; 
      }
      .sliderdesc{
        font-size: 15px;
      }
    }


    #speakers-details {
      padding: 60px 0;
      margin-top: 50px
    }

    
/*--------- 23. Login page ---------*/
.login-form-container {
  background: transparent none repeat scroll 0 0;
  border: 1px solid #ddd;
  padding: 60px 40px;
  text-align: left;
}
.login-text {
  margin-bottom: 30px;
  text-align: center;
}
.login-text h2 {
  color: #444;
  font-size: 30px;
  margin-bottom: 5px;
  text-transform: capitalize;
}
.login-text span {
  font-size: 15px;
}
.login-form-container input {
  background: #ffffff none repeat scroll 0 0;
  border: 1px solid #ddd;
  border-radius: 3px;
  box-shadow: none;
  color: #999;
  font-size: 14px;
  height: 40px;
  margin-bottom: 20px;
  padding-left: 10px;
  padding-right: 10px;
  width: 100%;
}
.login-form-container input::-moz-placeholder {
  color: #999;
  opacity: 1;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
}
.login-toggle-btn {
  padding-top: 10px;
}
.login-form-container input[type="checkbox"] {
  height: 15px;
  margin: 0;
  position: relative;
  top: 1px;
  width: 17px;
}
.login-form-container label {
  color: #777;
  font-size: 15px;
  font-weight: 400;
}
.login-toggle-btn > a {
  color: #777;
  float: right;
  -webkit-transition: all 0.3s ease 0s;
  transition: all 0.3s ease 0s;
}
.login-toggle-btn > a:hover {
  color: #000;
}
.button-box .default-btn {
  background: transparent none repeat scroll 0 0;
  border: 1px solid #ddd;
  color: #777;
  font-size: 14px;
  line-height: 1;
  margin-top: 25px;
  padding: 12px 36px 10px;
  text-transform: uppercase;
  -webkit-transition: all 0.3s ease 0s;
  transition: all 0.3s ease 0s;
}
.button-box .default-btn:hover {
  background-color: #ee3333;
  border: 1px solid #ee3333;
  color: #fff;
}

 
  </style>
 
  <!-- Favicons -->
  <!-- <link href="<?php //echo base_url();?>/assets/img/favicon.png" rel="icon"> -->
  <link href="<?php echo base_url();?>/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="<?php echo base_url();?>/assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="<?php echo base_url();?>/assets/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>/assets/lib/animate/animate.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>/assets/lib/venobox/venobox.css" rel="stylesheet">
  <link href="<?php echo base_url();?>/assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="<?php echo base_url();?>/assets/css/style.css" rel="stylesheet">
  <style type="text/css">    
    .mySlides {display: none;}
    .pimage0{display:block;}
    #websiteLogo{
    width: auto;
    height: 35px;
    background: #f6f7fd;
    padding: 5px;
    padding-right: 50px;
    border-radius: 40px 0 40px 0;
    font-family: fantasy;
    color: #060c22;
    padding-left: 50px;
    }

    #websiteLogoImg{
    width: auto;
    height: auto;
    background: #f6f7fd;
    padding: 5px;
    padding-right: 50px;
    border-radius: 40px 0 40px 0;
    font-family: fantasy;
    color: #060c22;
    padding-left: 50px;
    }

     /* Add custom CSS styles for arrow icons and positioning */
     .slider {
      /* position: relative; */
      /* max-height: 80vh; */
    }

    .slider {
      display: flex;
      /* overflow-x: auto; */
      position: relative; /* Add position relative to the slider container */
      max-height:85%;
    }

    .slide {
      flex: 0 0 auto;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center; /* Center elements vertically and horizontally */
      position: relative; /* Add position relative to each slide */
    }

    .slide img {
      width: 100%; /* Make the image take the full width of the slide */
      height: 100%; /* Allow the height to adjust automatically based on the image aspect ratio */
    }

    .slide h1 {
      margin-top: 10px;
      color: #f82249; /* Set the color of the title */
      font-size: 40px; /* Set the font size of the title */
      font-weight:600;
      line-height: 28px;
      position: absolute;
      top: 50%; /* Position the title 50% from the top of the slide */
      left: 50%; /* Position the title 50% from the left of the slide */
      transform: translate(-50%, -50%); /* Center the title within the slide */
      text-align: center; /* Center the text horizontally */
      width: 70%; /* Make the title take the full width of the slide */
      background:#1e243617;
      padding:10px;
      transition: opacity 0.5s ease;
      border-radius:10px 80px 0px 87px;
    }



    .slider .slick-arrow {
      font-size: 0; 
      color: #fff;
      background-color: rgba(0, 0, 0, 0.5);
      /* border-radius: 50%; */
      width: 40px;
      height: 40px;
      text-align: center;
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      z-index: 1;
    }

    .slider .slick-arrow:hover {
      background:rgb(10 15 36);
    }

    .slider .slick-prev {
      left: 10px;
    }

    .slider .slick-next {
      right: 10px;
    }

    /* Hide default slick dots */
    .slick-dots {
      display: none;
    }

    .slider img {
      max-width: 100%;
      max-height: 100%;
      object-fit:cover;
    }
    .slick-list{
      background:#070d23;
    }
  </style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
  
</head>

<body>

  <!--==========================
    Header
  ============================-->
  <header id="header" style="background: rgba(6, 12, 34, 0.98) !important;">
    <div class="container">
      <div id="logo" class="pull-left">        
        <a href="<?php echo base_url();?><?php echo $website; ?>#intro" class="scrollto">
          
          <?php if($logo_img=="" && $logo_name=="" ){ ?>
            <div id="websiteLogo"> <?php echo $website; ?> </div>
          <?php }else if($logo_img !=""){ ?>
            <div id="websiteLogoImg"><img src="<?php echo $logo_img_path;?><?php echo $logo_img; ?>" alt="<?php echo $website; ?>" title="<?php echo $website; ?>" style="max-width:125px; max-height:40px;"/></div>
          <?php }else{ ?>
            <div id="websiteLogo"> <?php echo $logo_name; ?> </div>
            <?php } ?>
        </a>
      </div>
      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class=""><a href="<?php echo base_url();?><?php echo $website; ?>#intro">Home</a></li>
          <!-- <li><a href="#about"></a></li> -->
            <?php 
            foreach ($section_menu_list as $key => $value) 
            {
              if($value[0]['show_menu']==1){
              ?>
                <li  class=<?php echo ($currentsectionName==$key)?"menu-active":""; ?>>
                  <a href="<?php echo base_url();?><?php echo $website; ?>#<?php echo $key;?>">
                    <?php echo $key;?> 
                  </a>
                </li>
              <?php 
              }
            }

          
            if(count($service_details)>0)
            {
              ?>
                <li><a href="<?php echo base_url();?><?php echo $website; ?>#hotels">Services</a></li>
              <?php 
            } 
            if(count($product_details)>0)
            {
              ?>
              <li><a href="<?php echo base_url();?><?php echo $website; ?>#speakers">Products</a></li>
              <?php 
            } 
            if(count($myvideo_det)>0)
            {  ?>  
                <li><a href="<?php echo base_url();?><?php echo $website; ?>#videosection">Videos</a></li>
               <?php
            }

            if(count($contact_details)>0){ ?>
              <li><a href="<?php echo base_url();?><?php echo $website; ?>#contact">Contact</a></li>
              <?php 
            }
            ?> 

          <li><a href="<?php echo $login_url; ?>" target="_blank">Website login</a></li>         
          <li>
            <a href="javascript:void(0);" data-toggle="modal" data-target="#searchModal"> 
              <img src="../.././assets/img/search.png" style="width:30px;cursor: pointer;">
            </a>
          </li>
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->

  <main id="main">
  
    <!-- Section Item --->
    <?php
      
      if(count($product_details)>0){
      foreach ($product_details as $key => $value) 
      {
        $service_id = $value['id'];
        ?>
        <section id="speakers-details" class="wow fadeIn">
        
          <div class="container">
            <div class="section-header">
              <h2>Products</h2>
              <p><?php echo $website; ?></p>
            </div>

            <?php
           
           
            ?>

            <div class="row">
              <div class="col-md-6">                
                <div class="slider">    
               
                  <div class="slide">                 
                      <img src="<?php echo $path_url.$value['product_image'];?>" alt="" class="img-fluid">                      
                  </div> 
                  <?php  ?>
                </div>
              </div>

              <div class="col-md-6">
                <div class="details">
                  <h2><?php echo $value['product_name'];?></h2>
                  <div class="social">
                    <input type="hidden" value="<?php echo $value['id']; ?>" id="service_id<?php echo $value['id']; ?>">
                    <!-- <a href="" style="border-radius: 10%; width: 90px;" onclick="likeServicesection(<?php echo $name;?>,<?php echo $value['id'];?>)">
                      <i class="fa fa-thumbs-up"></i> <?php echo $value['likes']; ?>
                    </a> -->
                    <!-- <a href="" style="border-radius: 10%; width: 90px;">
                      <i class="fa fa-eye"></i>
                      <?php //echo $value['views']; ?>
                    </a>
                     -->
                  </div>
                  <p><?php echo $value['long_desc'];?></p>
                    <!--<p><?php //echo $web_url;?></p>-->
                  
    
                  
                </div>
              </div>
              
            </div>
            <?php 
              } }
            ?>

          </div>

        </section>
     

    <!-- section Item ends-->


    <!--==========================
      About Section
    ============================-->
    <!-- Modal body -->
    <div class="modal" id="imagemyModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">             
            <div class="form-group m-b-0">
              <div class="slideshow-container"> 
                <?php
                  for($ct=0;$ct<count($contac_log_result);$ct++)
                    { ?>
                      <div id="pimage<?php echo $ct;?>"  class="mySlides pimage<?php echo $ct;?>">
                        <img src="<?php echo  $image_path.$contac_log_result[$ct]['image_name'];?>" style="width:100%; max-height: 400px;">
                      </div>
                      <?php
                    }
                  ?>                
                  <a class="prev" style="cursor: pointer;" onclick="plusSlides(-1, 1);">&#10094;</a>
                  <a class="next" style="cursor: pointer;" onclick="plusSlides(1,1);">&#10095;</a>
              </div>
              <div >
                <?php
                  for($cti=0;$cti<count($contac_log_result);$cti++)
                    {?>
                      <span onclick="currentSlide(<?php echo $cti+1; ?>);">
                      <img src="<?php echo  $image_path.$contac_log_result[$cti]['image_name'];?>" style="cursor:pointer;width:40px; height: 40px;"></span> 
                      <?php
                    }
                ?>  
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <section id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-3">
             <a  href="javascript:void(0);" data-toggle="modal" data-target="#imagemyModal">
              <?php 
                 if(isset($contact_details[0]['website_image']))
                 {
                    $image = $contact_details[0]['website_image'];
                 }
                 else{
                  $image = ($profile_image!='')?$profile_image:'user_profile/default.png';
                 }          
              echo '<img align="left" style="width:165px;height:180px;border-radius: 56px 12px;"src="'.$path_url.$image.'"/>'; 
              ?>
            </a>
          </div>           
          <div class="col-lg-6">
     
            <h2>About Us 
      </h2>
      <!-- follow like view button code starts here-->
      <?php if($websitename !=''){ ?>
        <p>
          <button type="button" class="btn btn-primary" onclick="flvwebsite('<?php echo $websitename; ?>','follow');">
            Follows <span class="badge badge-light" id="totalfollow"><?php echo $total_follows;?></span>
          </button>
          <button type="button" class="btn btn-secondary" onclick="flvwebsite('<?php echo $websitename; ?>','like');">
            Like <span class="badge badge-light" id="totallike"><?php echo $total_likes;?></span>
          </button>
          <button type="button" class="btn btn-primary" >
            View <span class="badge badge-light" id="totalview"><?php echo $total_views;?></span>
            <input type="hidden" id="viewweb" name="" value="<?php echo $website; ?>">
          </button>
        </p>
      <?php } ?>
      <!-- follow like view button code ends here-->
      
            <?php
              $about_us=(isset($contact_details[0]['about_website']))?$contact_details[0]['about_website']:'Welcome to mysite';
            ?>
            <p><?php echo $about_us; ?></p>
          </div>
        </div>
      </div>
    </section>

   
  </div>
  </main>

   


 <!--==========================
      Contact Section
    ============================-->
    <?php 
      if(count($contact_details)>0)
      { ?>
        <section id="contact" class="section-bg wow fadeInUp">
          <div class="container">
            <div class="section-header">
              <h2>My Contact</h2>
              <p><?php echo $website;?></p>
            </div>
            <div class="row contact-info">
              <div class="col-md-3">
                <div class="contact-address">
                  <i class="ion-ios-location-outline"></i>
                    <h3>Address</h3>
                    <address>
                      <?php
                      if(isset($contact_details[0]['address'])&&($contact_details[0]['address']!=''))
                      {
                        echo $contact_details[0]['address']; 
                      }
                      else
                      {
                        echo $address;
                      }
                      ?>
                    </address>
                </div>
              </div>
              <?php 
                if(isset($contact_details[0]['phonenumber']) || isset($contact_details[0]['homenumber']) || isset($contact_details[0]['officenumber']) || isset($contact_details[0]['faxnumber'])){
                ?>
              <div class="col-md-3">
                <div class="contact-phone">
                  <i class="ion-ios-telephone-outline"></i>
                  <h3>Phone Number</h3>
                      <p>
                        <?php if(isset($contact_details[0]['phonenumber'])){
                            echo "Phone :".$contact_details[0]['phonenumber'];
                          } ?>                            
                      </p>
                    <p><?php if(isset($contact_details[0]['homenumber'])){
                      echo "Home :".$contact_details[0]['homenumber'];
                    } ?></p>
                    <p><?php if(isset($contact_details[0]['officenumber'])){
                      echo "Office :".$contact_details[0]['officenumber'];
                    } ?></p>
                    <p><?php if(isset($contact_details[0]['faxnumber'])){
                      echo "Fax :".$contact_details[0]['faxnumber'];
                    } ?></p>
                </div>
              </div>
            <?php }?>
              <div class="col-md-3">
                <div class="contact-email">
                  <i class="ion-ios-email-outline"></i>
                  <h3>Email</h3>
                  <p><a href="mailto:info@example.com">
                    <?php 
                     
                    if(isset($contact_details[0]['email'])&&($contact_details[0]['email']!=''))
                    {
                      echo $contact_details[0]['email']; 
                    }
                    else
                    {
                      echo $mail;
                    }
                     
                    ?></a></p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="contact-email">
                  <i class="ion-ios-email-outline"></i>
                  <h3>Social</h3>
                  <p><a target="_blank" href="<?php 
                      if(isset($contact_details[0]['fb'])){
                        echo $contact_details[0]['fb']; 
                      } ?>">Facebook
                    </a>
                  </p>
                  <!-- <p><a target="_blank" href="#">Twitter</a></p> -->
                  <p>
                    <a target="_blank" href="<?php
                       if(isset($contact_details[0]['linked'])){
                          echo $contact_details[0]['linked']; 
                        }
                      ?>">LinkedIn
                    </a>
                  </p>
                  <p>
                    <?php if(isset($contact_details[0]['whatsapp'])){
                      echo "Whatsapp :".$contact_details[0]['whatsapp'];
                    } ?>                    
                  </p>
                  <p>
                      <?php if(isset($contact_details[0]['telegram'])){
                      echo "Telegram :".$contact_details[0]['telegram'];
                    } ?>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </section><!-- #contact -->
        <?php 
      } 
    ?> 

    <!-- Enquiry Form start -->
    <div class="register-area ptb-100 section-bg wow fadeInUp" id="enquirynow1">
      <div class="container-fluid">
          <div class="row">
              <div class="col-md-12 col-12 col-lg-8 col-xl-8 ml-auto mr-auto" id="enquirynow">
              
              <div class="section-header">
                <h2>Enquiry</h2>
              </div>

                  <div class="login" style="margin-bottom: 10px;">
                      <div class="login-form-container">
                          <div class="login-form">
                              <form id="enquiryform">
                                <input type="hidden" value="<?php echo $service_id; ?>" name="section_item" id="section_item">
                                <input type="hidden" id="currentweb" name="currentweb" value="<?php echo $website; ?>">
                                <input type="hidden" id="type" name="type" value="2">
                                <div class="row">
                                  <div class="form-group col-lg-4 col-sm-12 col-xl-4 ">
                                    <input type="text" name="name" id="name" placeholder="Name*">
                                    <span id="usercheck" style="color: red;">
                                        *Name is required
                                    </span>
                                  </div>
                                  
                                  <div class="form-group col-lg-4 col-xl-4 col-sm-12">  
                                    <input type="text" name="country"  id="country" placeholder="Country">
                                  
                                  </div>  
                                  <div class="form-group col-lg-4 col-xl-4 col-sm-12">  
                                    <input type="text" name="state" id="state" placeholder="State">
                                  </div> 
                                  <div class="form-group col-lg-12 col-xl-12 col-sm-12"> 
                                    <textarea name="description" class="form-control" rows="7" id="description"  placeholder="Description*"></textarea>
                                    <span id="descriptioncheck" style="color: red;">
                                        *Description is required
                                    </span>
                                  </div>
                                  
                                  <div class="button-box ml-auto mr-auto">
                                      <button type="button" class="default-btn floatright"  id="submitbtn">Send Enquiry</button>
                                  </div>

                                </div> 
                            
                              </form>

                              <div class="alert alert-success" role="alert" id="success-alert">
                                Enquiry has been submitted. we will get back to you shortly !!
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
    <!-- Enquiry Form end -->


  <!--==========================
    Footer
  ============================-->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">
        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong>3ABC7</strong>. All Rights Reserved
      </div>
    </div>
  </footer><!-- #footer -->

  <a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>

  <!-- JavaScript Libraries -->
  <script src="<?php echo base_url();?>/assets/lib/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url();?>/assets/lib/jquery/jquery-migrate.min.js"></script>
  <script src="<?php echo base_url();?>/assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url();?>/assets/lib/easing/easing.min.js"></script>
  <script src="<?php echo base_url();?>/assets/lib/superfish/hoverIntent.js"></script>
  <script src="<?php echo base_url();?>/assets/lib/superfish/superfish.min.js"></script>
  <script src="<?php echo base_url();?>/assets/lib/wow/wow.min.js"></script>
  <script src="<?php echo base_url();?>/assets/lib/venobox/venobox.min.js"></script>
  <script src="<?php echo base_url();?>/assets/lib/owlcarousel/owl.carousel.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
  <script>
   
    $(document).ready(function() {
      $("#usercheck").hide();$("#descriptioncheck").hide();$("#mobilecheck").hide();
      $("#success-alert").hide();
    
      $('.slider').slick({
        autoplay: true,
        autoplaySpeed: 3000, // Change slide every 3 seconds (adjust as needed)
        arrows: true, // Show navigation arrows
        dots: false,  // Hide navigation dots
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1
      });

      $('.slider-prev').on('click', function() {
        $('.slider').slick('slickPrev');
      });

      $('.slider-next').on('click', function() {
        $('.slider').slick('slickNext');
      });

    });
    $("#submitbtn").click(function () {
      let usernameError = true;      
      let nameValue = $("#name").val();
      let descriptionValue = $("#description").val();
      //let mobileValue = $("#mobile").val();
       
      $("#usercheck").hide();$("#descriptioncheck").hide();$("#mobilecheck").hide();
       
        

        if ( nameValue != "" && descriptionValue!="") {
          $.ajax({
            type:'POST',
            url:'<?php echo base_url("index.php/website/updateenquiry"); ?>',
            data:$("#enquiryform").serialize(),
            dataType:"JSON",                
            success:function(data){  
              $("#success-alert").show();  
              setTimeout(function(){
                  window.location.reload(1);
                }, 5000);
             
            }
          });
        } else {
          
          if (nameValue.length == "") {
              $("#usercheck").show();
              usernameError = false;  
          }  
          if (descriptionValue.length == "" || descriptionValue.length == 0) {
              $("#descriptioncheck").show();
              usernameError = false;
          }
          
        }
    });
  </script>


  <!-- Template Main Javascript File -->
  <script src="<?php echo base_url();?>/assets/js/main.js"></script>
  <script>
    $(document).ready(function(){
     // $("#totalview").click(function(){
        var web = $('#viewweb').val();
        //alert(web);
         $.ajax({
          type:'POST',
          url:'<?php echo base_url("index.php/website/addwebsitefollow"); ?>',
          data:{'website':web,'type':'views'},
           dataType:"JSON",                
          success:function(data){                 
              $('#totalview').html(data.totalviews);
          }
        });
     // })
      
    });


    $("#likesT").click(function() {      
      var id = $('#product_id1').val();
        $.ajax({
          type:'POST',
          url:'<?php echo base_url("index.php/website/updateproductmaster"); ?>',
          data:{'id':id,'field':'like'},
          dataType:"JSON",                
          success:function(data){                 
              $('#likecount').html(data.total_likes);
          }
        });
    });

   function likeProduct(id)
   {
      var id = $('#product_id'+id).val();
       $.ajax({
          type:'POST',
          url:'<?php echo base_url("index.php/website/updateproductmaster"); ?>',
          data:{'id':id,'field':'like'},
          dataType:"JSON",                
          success:function(data){                 
              $('#likecount'+id).html(data.total_likes);
          }
      });
   }
    function likeServicesection(name,id)
   {
      var id = $('#service_id'+id).val();
         $.ajax({
                type:'POST',
                url:'<?php echo base_url("index.php/website/updatesectionitemlike"); ?>',
                data:{'id':id,'field':'like','section':name},
                dataType:"JSON",                
                success:function(data){                 
                    $('#likeservicecount'+id).html(data.total_likes);
                }
            });
   }
   function likeService(id)
   {
      var id = $('#service_id'+id).val();
         $.ajax({
            type:'POST',
            url:'<?php echo base_url("index.php/website/updateservicemaster"); ?>',
            data:{'id':id,'field':'like'},
            dataType:"JSON",                
            success:function(data){                 
                $('#likeservicecount'+id).html(data.total_likes);
            }
        });
   }
   function likeAd(id)
   {
      var id = $('#adv_id'+id).val();
         $.ajax({
                type:'POST',
                url:'<?php echo base_url("index.php/website/updateadmaster"); ?>',
                data:{'id':id,'field':'like'},
                dataType:"JSON",                
                success:function(data){                 
                    $('#adlikecount'+id).html(data.total_likes);
                }
            });
   }
  
    $("#likeservice").click(function() {      
      var id = $('#service_id').val();
         $.ajax({
                type:'POST',
                url:'<?php echo base_url("index.php/website/updateservicemaster"); ?>',
                data:{'id':id,'field':'like'},
                dataType:"JSON",                
                success:function(data){                 
                    $('#likeservicecount').html(data.total_likes);
                }
            });
    });
   
    $("#adlikes").click(function() {      
      var id = $('#adv_id').val();
         $.ajax({
                type:'POST',
                url:'<?php echo base_url("index.php/website/updateadmaster"); ?>',
                data:{'id':id,'field':'like'},
                dataType:"JSON",                
                success:function(data){                 
                    $('#adlikecount').html(data.total_likes);
                }
            });
    });
  function servicepopupimage_section(name,image,desc,update_id,weblink,type,src_file,web_url)
  {
    $('#mtitle2_section').html(name);
      
      if(type==2)
      {
        $('#mimage2_section').html('<video width="400" controls><source src="'+image+'" type="video/mp4"></video>'); 
      }
      else if(type==1 || type==3 || type==4){
        $('#mimage2_section').html('<img src="'+src_file+'" width="400" style="display: block; margin-left: auto; margin-right: auto;">');
      }else{
        $('#mimage2_section').html('<audio width="400" controls><source src="'+image+'" type="audio/mpeg"></audio>');
      }
      
      var Websiteurl="https://"+web_url;
      $('#desc2_section').html('<div class="description">"'+desc+'"</div><input type="hidden" value="'+update_id+'" id="service_id"><br><div><a href="'+image+'" target="_blank">Click here to view</a></div><br><div><a href="'+Websiteurl+'" target="_blank"><b>Website Link</b></a></div>');

       var serviceid = update_id;
       $.ajax({
          type:'POST',
          url:'<?php echo base_url("index.php/website/updateviews"); ?>',
          data:{'id':serviceid,'field':'view','section':name},
           dataType:"JSON",                
          success:function(data){                 
              $('#viewservicecount_section').html(data.total_views);
          }
      });
  }
  function servicepopupimage(name,image,desc,service_id,weblink,type){
      
      $('#mtitle2').html(name);
      if(type==1)
      {
        $('#mimage2').html('<video width="400" controls><source src="'+image+'" type="video/mp4"></video>'); 
      }else{
        $('#mimage2').html('<img src="'+image+'" width="400">');
      }
      
      $('#desc2').html('<div class="description">"'+desc+'"</div><input type="hidden" value="'+service_id+'" id="service_id"><br><div><b>WebLink</b>:'+weblink+'</div>');

       var serviceid = service_id;
       $.ajax({
          type:'POST',
          url:'<?php echo base_url("index.php/website/updateservicemaster"); ?>',
          data:{'id':serviceid,'field':'view'},
           dataType:"JSON",                
          success:function(data){                 
              $('#viewservicecount').html(data.total_views);
          }
      });
     }

    function popupimage(desc1,short_desc,name,image,cname,scname,price,likes,views,p_id){
      
      $('#mtitle').html(name);
      $('#cname').html(cname);
      $('#scname').html(scname);
      $('#likecount').html(likes);
      $('#viewcount').html(views);
      //$('#mfooter').html('<img src="'+image+'"  width="460px" height="400px">');
      $('#mimage').html('<img src="'+image+'"  width="100%" height="400px"><input type="hidden" value="'+p_id+'" id="product_id1"><br><span><b>Description</b>: '+desc1+'</span><br><span><b>Short Description</b>: '+short_desc+'</span>');
      
      var id = p_id;
       $.ajax({
          type:'POST',
          url:'<?php echo base_url("index.php/website/updateproductmaster"); ?>',
          data:{'id':id,'field':'view'},
           dataType:"JSON",                
          success:function(data){                 
              $('#viewcount').html(data.total_views);
          }
      });
     }
      function videopreviewimage(video,id){
        
      $('#videoimage').html('<video width="400"  controls><source src="'+video+'" type="video/mp4"></video><input type="hidden" value="'+id+'" id="adv_id">');
    }
     function popupimage1(image,ad_id){
      $('#mimage1').html('<img src="'+image+'" width="400" ><input type="hidden" value="'+ad_id+'" id="adv_id">');
      var id = ad_id;
       $.ajax({
          type:'POST',
          url:'<?php echo base_url("index.php/website/updateadmaster"); ?>',
          data:{'id':id,'field':'view'},
           dataType:"JSON",                
          success:function(data){                 
              $('#adviewcount').html(data.total_views);
          }
      });
     }
 var slideIndex =1;
  function plusSlides(n,m){
    
     showSlides(slideIndex += n);
  }

  function currentSlide(n) {
    showSlides(slideIndex = n);
  }
  function flvwebsite(website,type)
  {
    $.ajax({
          type:'POST',
          url:'<?php echo base_url("index.php/website/addwebsitefollow"); ?>',
          data:{'website':website,'type':type},
           dataType:"JSON",                
          success:function(data){ 
          if(type=='like')  
          {
              $('#totallike').html(data.totallikes);
          } else{
            $('#totalfollow').html(data.totalfollow);
          }             
              
          }
      });
  }

  function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    if (n > slides.length) {this.slideIndex = 1}    
    if (n < 1) {this.slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
       // slides[i].style.display = "none";  
        $('.pimage'+i).css('display','none'); 
    }
    for (i = 0; i < dots.length; i++) {
       // dots[i].className = dots[i].className.replace(" active", "");
    }
    //slides[this.slideIndex-1].style.display = "block"; 
    var all_val = this.slideIndex-1; 
    $('.pimage'+all_val).css('display','block');
    //dots[this.slideIndex-1].className += " active";
  }
  </script>
</body>

</html>
