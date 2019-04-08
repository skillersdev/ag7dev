<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Roodabatoz</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="<?php echo base_url();?>/assets/img/favicon.png" rel="icon">
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


</head>

<body>

  <!--==========================
    Header
  ============================-->
  <header id="header">
    <div class="container">

      <div id="logo" class="pull-left">
        <!-- Uncomment below if you prefer to use a text logo -->
        <!-- <h1><a href="#main">C<span>o</span>nf</a></h1>-->
        <a href="#intro" class="scrollto"><img src="img/logo.png" alt="" title=""></a>
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="#intro">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#speakers">Products</a></li>
          <li><a href="#hotels">Services</a></li>
         
          <!-- <li><a href="#sponsors">Clients</a></li> -->
          <li><a href="#contact">Contact</a></li>
         
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->

  <!--==========================
    Intro Section
  ============================-->
  <section id="intro">
    <div class="intro-container wow fadeIn">
      <h1 class="mb-4 pb-0">The Global<br><span>Service</span> Provide</h1>
      <p class="mb-4 pb-0">Expert in software development and staffing</p>
      
    </div>
	
	<!--<div class="fb-profile">
        <img align="left" class="fb-image-lg" src="http://lorempixel.com/850/280/nightlife/5/" alt="Profile image example"/>
        <img align="left" class="fb-image-profile thumbnail" src="http://lorempixel.com/180/180/people/9/" alt="Profile image example"/>
        <div class="fb-profile-text">
            <h1>Eli Macy</h1>
            <p>Girls just wanna go fun.</p>
        </div>
    </div>-->
	
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
	</style>
	
  </section>

  <main id="main">

    <!--==========================
      About Section
    ============================-->
    <section id="about">
      <div class="container">
        <div class="row">
			<div class="col-lg-3">
				
					<img align="left" style="width: 165px; height: 180px;" src="http://www.professionalclick.com/images/upload/img_1528440325.jpg" alt="Profile image example"/>
					
					
				
			</div>
          <div class="col-lg-6">
            <h2>About Us</h2>
            <p>Sed nam ut dolor qui repellendus iusto odit. Possimus inventore eveniet accusamus error amet eius aut
              accusantium et. Non odit consequatur repudiandae sequi ea odio molestiae. Enim possimus sunt inventore in
              est ut optio sequi unde.</p>
          </div>
          <div class="col-lg-3">
            <h3>Address</h3>
            <p>City Center,Majestics Metro Station,Bangalore</p>
			 <p>9789176467,<br>042-898979989</p>
          </div>
          
        </div>
      </div>
    </section>

    <!--==========================
      Speakers Section
    ============================-->
    <section id="speakers" class="wow fadeInUp">
      <div class="container">
        <div class="section-header">
          <h2>Products</h2>
          <p>Various Products</p>
        </div>

        <div class="row">
          <div class="col-lg-3 col-md-3">
            <div class="speaker">
              <img src="<?php echo base_url();?>/assets/img/speakers/1.jpeg" alt="Speaker 1" class="img-fluid">
              <div class="details">
                <h4><a href="product-details.html">Laptop</a></h4>
                <p>Electronics- 1200$</p>
               
              </div>
            </div>
          </div>
		  
		  <div class="col-lg-3 col-md-3">
            <div class="speaker">
              <img src="<?php echo base_url();?>/assets/img/speakers/3.jpg" alt="Speaker 1" class="img-fluid">
              <div class="details">
                <h4><a href="product-details.html">USB Holder</a></h4>
                <p>Electronics- 20$</p>
               
              </div>
            </div>
          </div>
		  
		   <div class="col-lg-3 col-md-3">
            <div class="speaker">
              <img src="<?php echo base_url();?>/assets/img/speakers/4.jpg" alt="Speaker 1" class="img-fluid">
              <div class="details">
                <h4><a href="product-details.html">Touch Watch</a></h4>
                <p>Electronics- 200$</p>
               
              </div>
            </div>
          </div>
          
          <div class="col-lg-3 col-md-3">
            <div class="speaker">
              <img src="<?php echo base_url();?>/assets/img/speakers/5.jpg" alt="Speaker 1" class="img-fluid" style="height: 255px;">
              <div class="details">
                <h4><a href="product-details.html">Laptop</a></h4>
                <p>Electronics- 200$</p>
               
              </div>
            </div>
          </div>
         
          
          
        </div>
      </div>

    </section>

    

    <!--==========================
      Hotels Section
    ============================-->
    <section id="hotels" class="section-with-bg wow fadeInUp">

      <div class="container">
        <div class="section-header">
          <h2>Services</h2>
          
        </div>

        <div class="row">

          <div class="col-lg-3 col-md-3">
            <div class="hotel">
              <div class="hotel-img">
                <img src="<?php echo base_url();?>/assets/img/hotels/1.png" alt="Hotel 1" class="img-fluid"style="height: 205px;">
              </div>
              <h3>Web Development Service</h3>
              
              <p>Complete IT Solution provider</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-3">
            <div class="hotel">
              <div class="hotel-img">
                <img src="<?php echo base_url();?>/assets/img/hotels/2.jpg" alt="Hotel 2" class="img-fluid" style="height: 205px;">
              </div>
              <h3>Consultant</h3>
              
              <p>Provide staffing solution in diffrent domains</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-3">
            <div class="hotel">
              <div class="hotel-img">
                <img src="<?php echo base_url();?>/assets/img/hotels/3.jpg" alt="Hotel 3" class="img-fluid" style="height: 205px;">
              </div>
              <h3>Testing Service</h3>
              
              <p>Provides automated and manual testing </p>
            </div>
          </div>
		  
		  <div class="col-lg-3 col-md-3">
            <div class="hotel">
              <div class="hotel-img">
                <img src="<?php echo base_url();?>/assets/img/hotels/2.png" alt="Hotel 3" class="img-fluid" style="height: 205px;">
              </div>
              <h3>AI Service</h3>
              
              <p>Provides automated Robot arms in Industries </p>
            </div>
          </div>
		  

        </div>
      </div>

    </section>

    
      </div>

    
    <!--==========================
      Contact Section
    ============================-->
    <section id="contact" class="section-bg wow fadeInUp">

      <div class="container">

        <div class="section-header">
          <h2>Contact Us</h2>
          <p>Nihil officia ut sint molestiae tenetur.</p>
        </div>

        <div class="row contact-info">

          <div class="col-md-3">
            <div class="contact-address">
              <i class="ion-ios-location-outline"></i>
              <h3>Address</h3>
              <address>A108 Adam Street, NY 535022, USA</address>
            </div>
          </div>

          <div class="col-md-3">
            <div class="contact-phone">
              <i class="ion-ios-telephone-outline"></i>
              <h3>Phone Number</h3>
              <p><a href="tel:+155895548855">+1 5589 55488 55</a></p>
            </div>
          </div>

          <div class="col-md-3">
            <div class="contact-email">
              <i class="ion-ios-email-outline"></i>
              <h3>Email</h3>
              <p><a href="mailto:info@example.com">info@example.com</a></p>
            </div>
          </div>
		  
		  <div class="col-md-3">
            <div class="contact-email">
              <i class="ion-ios-email-outline"></i>
              <h3>Social</h3>
              <p><a href="#">Facebook</a></p>
			  <p><a href="#">Twitter</a></p>
			  <p><a href="#">LinkedIn</a></p>
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
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-6 col-md-6 footer-info">
            <img src="<?php echo base_url();?>/assets/img/logo.png" alt="TheEvenet">
            <p>In alias aperiam. Placeat tempore facere. Officiis voluptate ipsam vel eveniet est dolor et totam porro. Perspiciatis ad omnis fugit molestiae recusandae possimus. Aut consectetur id quis. In inventore consequatur ad voluptate cupiditate debitis accusamus repellat cumque.</p>
          </div>

          

         

          <div class="col-lg-6 col-md-6 footer-contact">
            <h4>Contact Us</h4>
            <p>
              A108 Adam Street <br>
              New York, NY 535022<br>
              United States <br>
              <strong>Phone:</strong> +1 5589 55488 55<br>
              <strong>Email:</strong> info@example.com<br>
            </p>

            <div class="social-links">
              <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
              <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
              <a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
              <a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
              <a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a>
            </div>

          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong>Website</strong>. All Rights Reserved
      </div>
      <div class="credits">
       
        Designed by <a href="https://skillersglobalservice.com/">Skillers</a>
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

  <!-- Template Main Javascript File -->
  <script src="<?php echo base_url();?>/assets/js/main.js"></script>
</body>

</html>