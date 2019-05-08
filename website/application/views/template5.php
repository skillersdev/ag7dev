<!DOCTYPE html>
<html lang="en">
<head>
  <?php $path_url = $this->config->item('path_url'); ?>
  <meta charset="utf-8">
  <title>Roodabatoz</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="<?php echo base_url();?>assets/template5/img/favicon.png" rel="icon">
  <link href="<?php echo base_url();?>assets/template5/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="<?php echo base_url();?>assets/template5/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="<?php echo base_url();?>assets/template5/lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/template5/lib/animate/animate.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/template5/lib/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/template5/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>assets/template5/lib/lightbox/css/lightbox.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="<?php echo base_url();?>assets/template5/css/style.css" rel="stylesheet">


</head>

<body>

  <!--==========================
  Header
  ============================-->
  <header id="header" class="fixed-top">
    <div class="container">

      <div class="logo float-left">
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <h1 class="text-light"><a href="#header"><span>NewBiz</span></a></h1> -->
        <a href="#intro" class="scrollto"><img src="<?php echo base_url();?>assets/template5/img/logo.png" alt="" class="img-fluid"></a>
      </div>

      <nav class="main-nav float-right d-none d-lg-block">
        <ul>
          <li class="active"><a href="#intro">Home</a></li>
          <li><a href="#about">About Us</a></li>
          <li><a href="#services">Services</a></li>
          <li><a href="#portfolio">Products</a></li>
          <li><a href="#team">Ads</a></li>
          <li><a href="#contact">Contact Us</a></li>
        </ul>
      </nav><!-- .main-nav -->
      
    </div>
  </header><!-- #header -->

  <!--==========================
    Intro Section
  ============================-->
  <section id="intro" class="clearfix">
    <div class="container">

      <div class="intro-img">
        <img src="<?php echo base_url();?>assets/template5/img/intro-img.svg" alt="" class="img-fluid">
      </div>

      <div class="intro-info">
        <h2>We provide<br><span>solutions</span><br>for your business!</h2>
        
      </div>

    </div>
  </section><!-- #intro -->

  <main id="main">

    <!--==========================
      About Us Section
    ============================-->
    <section id="about">
      <div class="container">

        <header class="section-header">
          <h3>About Us</h3>
          <p><?php 
              $about_us =($about_me!='')?$about_me:'Welcome to mysite';

            ?></p>
        </header>

        <div class="row about-container">

          <div class="col-lg-6 content order-lg-1 order-2">
            <p>
            <?php echo $about_us; ?>
            </p>

            <!-- <div class="icon-box wow fadeInUp">
              <div class="icon"><i class="fa fa-shopping-bag"></i></div>
              <h4 class="title"><a href="">Eiusmod Tempor</a></h4>
              <p class="description">Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi</p>
            </div>

            <div class="icon-box wow fadeInUp" data-wow-delay="0.2s">
              <div class="icon"><i class="fa fa-photo"></i></div>
              <h4 class="title"><a href="">Magni Dolores</a></h4>
              <p class="description">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
            </div>

            <div class="icon-box wow fadeInUp" data-wow-delay="0.4s">
              <div class="icon"><i class="fa fa-bar-chart"></i></div>
              <h4 class="title"><a href="">Dolor Sitema</a></h4>
              <p class="description">Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat tarad limino ata</p>
            </div> -->

          </div>

          <div class="col-lg-6 background order-lg-2 order-1 wow fadeInUp">
          <?php 
          $profile_image = ($profile_image!='')?$profile_image:'user_profile/default.png';
          echo '<img align="left" style="width: 165px; height: 180px;" src="'.$path_url.$profile_image.'" alt="Profile image example"/>';
         ?>  
          <!-- <img src="<?php echo base_url();?>assets/template5/img/about-img.svg" class="img-fluid" alt=""> -->
          </div>
        </div>

        
     
      </div>
    </section><!-- #about -->

    <!--==========================
      Services Section
    ============================-->
    <section id="services" class="section-bg">
      <div class="container">

        <header class="section-header">
          <h3>Services</h3>
          
        </header>

        <div class="row">
        <?php 
        for($j=0;$j<count($service_details);$j++)
        {
        ?>
          <div class="col-md-6 col-lg-5 offset-lg-1 wow bounceInUp" data-wow-duration="1.4s">
            <div class="box">
              <div class="icon"><i class="ion-ios-paper-outline" style="color: #ff689b;"></i></div>
              <h4 class="title"><a href=""><?php echo $service_details[$j]['service_name'];?></a></h4>
              <p class="description"><?php echo $service_details[$j]['desc'];?></p>
            </div>
          </div>
          <?php } ?>

         

        </div>

      </div>
    </section><!-- #services -->

   
    <!--==========================
      Product Section
    ============================-->
    <section id="portfolio" class="clearfix">
      <div class="container">

        <header class="section-header">
          <h3 class="section-title">Our Products</h3>
        </header>


        <div class="row portfolio-container">

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
          <?php
           if(count($product_details)>0)
            {
                for($i=0;$i<count($product_details);$i++){
                                    //echo $product_details[$i]['product_image'];
            ?>

            <div class="portfolio-wrap">
            <?php 
                echo '<img src="'.$path_url.$product_details[$i]['product_image'].' " class="img-fluid" style="width:100%;">'; 
            ?>
              <div class="portfolio-info">
                <h4><a href="#"><?php echo $product_details[$i]['product_name'];?></a></h4>
                <p><?php echo $product_details[$i]['price'];?></p>
                <div>
                 <?php
                 echo  '<a href="'.$path_url.$product_details[$i]['product_image'].'" data-lightbox="portfolio" data-title="App 1" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>';
                 ?>
                  <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
                </div>
              </div>
            </div>

            <?php } 
                                } else
                                {?>
                                    <span class="portfolio-item">No Products found</span>
                            <?php }?>
          </div>

        

        </div>

      </div>
    </section><!-- #Products -->


    <!--==========================
      Team Section
    ============================-->
    <section id="team">
      <div class="container">
        <div class="section-header">
          <h3>Advertisment</h3>
         
        </div>

        <div class="row">


          <div class="col-lg-3 col-md-6 wow fadeInUp">
          <?php
                                      for($k=0;$k<count($ad_details);$k++)
                                      {
                                      ?>
            <div class="member">
            <?php
                                         if($ad_details[$k]['ad_type']==1)
                                              { 
                                                  echo '<img src="'.$path_url.$ad_details[$k]['uploads'].' " class="img-fluid" style="width:100%;height:210px;">'; 
                                              }
                                              else{
                                                echo '<video width="280" height="200" controls>
                                                        <source src="'.$path_url.$ad_details[$k]['uploads'].'" type="video/mp4">
                                                      </video>';
                                              }
                                              ?>
              <!-- <div class="member-info">
                <div class="member-info-content">
                  <h4>Ad1</h4>
                  <span>Ad description</span>
                 
                </div>
              </div> -->
            </div>
            <?php } ?>
          </div>

         
        </div>

      </div>
    </section><!-- #team -->

  

     

    <!--==========================
      Contact Section
    ============================-->
    <section id="contact">
      <div class="container-fluid">

        <div class="section-header">
          <h3>Contact Us</h3>
        </div>

        <div class="row wow fadeInUp">

          <div class="col-lg-4">
            <div class="map mb-4 mb-lg-0">
             <div class="social-links">
              <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
              <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
              <a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
              <a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
              <a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a>
            </div>
            </div>
          </div>

          <div class="col-lg-8">
            <div class="row">
              <div class="col-md-5 info">
                <i class="ion-ios-location-outline"></i>
                <p><?php echo $address;?></p>
              </div>
              <div class="col-md-4 info">
                <i class="ion-ios-email-outline"></i>
                <p><?php echo $mail;?></p>
              </div>
              <div class="col-md-3 info">
                <i class="ion-ios-telephone-outline"></i>
                <p><?php echo $mobile;?></p>
              </div>
            </div>

            
          </div>

        </div>

      </div>
    </section><!-- #contact -->

  </main>

  <!--==========================
    Footer
  ============================-->
  <footer id="footer">
    
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong>Roodabatoz</strong>. All Rights Reserved
      </div>
   
    </div>
  </footer><!-- #footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <!-- Uncomment below i you want to use a preloader -->
  <!-- <div id="preloader"></div> -->

  <!-- JavaScript Libraries -->
  <script src="<?php echo base_url();?>assets/template5/lib/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url();?>assets/template5/lib/jquery/jquery-migrate.min.js"></script>
  <script src="<?php echo base_url();?>assets/template5/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url();?>assets/template5/lib/easing/easing.min.js"></script>
  <script src="<?php echo base_url();?>assets/template5/lib/mobile-nav/mobile-nav.js"></script>
  <script src="<?php echo base_url();?>assets/template5/lib/wow/wow.min.js"></script>
  <script src="<?php echo base_url();?>assets/template5/lib/waypoints/waypoints.min.js"></script>
  <script src="<?php echo base_url();?>assets/template5/lib/counterup/counterup.min.js"></script>
  <script src="<?php echo base_url();?>assets/template5/lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="<?php echo base_url();?>assets/template5/lib/isotope/isotope.pkgd.min.js"></script>
  <script src="<?php echo base_url();?>assets/template5/lib/lightbox/js/lightbox.min.js"></script>

  <!-- Template Main Javascript File -->
  <script src="<?php echo base_url();?>assets/template5/js/main.js"></script>

</body>
</html>
