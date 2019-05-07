<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="en" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="en" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="en" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
    <head>
    	<!-- meta charec set -->
        <meta charset="utf-8">
		<!-- Always force latest IE rendering engine or request Chrome Frame -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<!-- Page Title -->
        <title>Roodabatoz</title>		
		<!-- Meta Description -->
        <meta name="description" content="Blue One Page Creative HTML5 Template">
        <meta name="keywords" content="one page, single page, onepage, responsive, parallax, creative, business, html5, css3, css3 animation">
        <meta name="author" content="Muhammad Morshed">
		<!-- Mobile Specific Meta -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!-- Google Font -->
		
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>

		<!-- CSS
		================================================== -->
		<!-- Fontawesome Icon font -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/template3/css/font-awesome.min.css">
		<!-- Twitter Bootstrap css -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/template3/css/bootstrap.min.css">
		<!-- jquery.fancybox  -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/template3/css/jquery.fancybox.css">
		<!-- animate -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/template3/css/animate.css">
		<!-- Main Stylesheet -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/template3/css/main.css">
		<!-- media-queries -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/template3/css/media-queries.css">

		<!-- Modernizer Script for old Browsers -->
        <script src="<?php echo base_url();?>assets/template3/js/modernizr-2.6.2.min.js"></script>

    </head>
	
    <body id="body">
	
		<!-- preloader -->
		<div id="preloader">
			<img src="<?php echo base_url();?>assets/template3/img/preloader.gif" alt="Preloader">
		</div>
		<!-- end preloader -->

        <!-- 
        Fixed Navigation
        ==================================== -->
        <header id="navigation" class="navbar-fixed-top navbar">
            <div class="container">
                <div class="navbar-header">
                    <!-- responsive nav button -->
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-bars fa-2x"></i>
                    </button>
					<!-- /responsive nav button -->
					
					<!-- logo -->
                    <a class="navbar-brand" href="#body">
						<h1 id="logo">
							<img src="<?php echo base_url();?>assets/template3/img/logo.png" alt="Roodabatoz" style="width: 123px;">
						</h1>
					</a>
					<!-- /logo -->
                </div>

				<!-- main nav -->
                <nav class="collapse navbar-collapse navbar-right" role="navigation">
                    <ul id="nav" class="nav navbar-nav">
                        <li class="current"><a href="#body">Home</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#products">Products</a></li>
                        <li><a href="#ads">Ads</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </nav>
				<!-- /main nav -->
				
            </div>
        </header>
        <!--
        End Fixed Navigation
        ==================================== -->
		
		
		
        <!--
        Home Slider
        ==================================== -->
		
		<section id="slider">
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			
				<!-- Indicators bullet -->
				<ol class="carousel-indicators">
					<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
					<li data-target="#carousel-example-generic" data-slide-to="1"></li>
				</ol>
				<!-- End Indicators bullet -->				
				
				<!-- Wrapper for slides -->
				<div class="carousel-inner" role="listbox">
					
					<!-- single slide -->
					<div class="item active" style="background-image: url(img/banner.jpg);">
						<div class="carousel-caption">
							<h2 data-wow-duration="700ms" data-wow-delay="500ms" class="wow bounceInDown animated">Welcome to<span> Rodabatoz</span>!</h2>
							<h3 data-wow-duration="1000ms" class="wow slideInLeft animated"><span class="color"><?php echo $website;?></span> We are a team of professionals.</h3>
							<p data-wow-duration="1000ms" class="wow slideInRight animated">Provides various services</p>
							
							<ul class="social-links text-center">
								<li><a href="<?php echo base_url();?>assets/template3/"><i class="fa fa-twitter fa-lg"></i></a></li>
								<li><a href="<?php echo base_url();?>assets/template3/"><i class="fa fa-facebook fa-lg"></i></a></li>
								<li><a href="<?php echo base_url();?>assets/template3/"><i class="fa fa-google-plus fa-lg"></i></a></li>
								<li><a href="<?php echo base_url();?>assets/template3/"><i class="fa fa-dribbble fa-lg"></i></a></li>
							</ul>
						</div>
					</div>
					<!-- end single slide -->
					
					<!-- single slide -->
					<div class="item" style="background-image: url(img/banner.jpg);">
						<div class="carousel-caption">
							<h2 data-wow-duration="500ms" data-wow-delay="500ms" class="wow bounceInDown animated">Welcome to<span> Roodabatoz</span>!</h2>
							<h3 data-wow-duration="500ms" class="wow slideInLeft animated"><span class="color">Website name</span> Provide various Services.</h3>
							<p data-wow-duration="500ms" class="wow slideInRight animated">We are a team of professionals</p>
							
							<!--<ul class="social-links text-center">
								<li><a href="<?php echo base_url();?>assets/template3/"><i class="fa fa-twitter fa-lg"></i></a></li>
								<li><a href="<?php echo base_url();?>assets/template3/"><i class="fa fa-facebook fa-lg"></i></a></li>
								<li><a href="<?php echo base_url();?>assets/template3/"><i class="fa fa-google-plus fa-lg"></i></a></li>
								<li><a href="<?php echo base_url();?>assets/template3/"><i class="fa fa-dribbble fa-lg"></i></a></li>
							</ul>-->
						</div>
					</div>
					<!-- end single slide -->
					
				</div>
				<!-- End Wrapper for slides -->
				
			</div>
		</section>
		
        <!--
        End Home SliderEnd
        ==================================== -->
		
        <!--
        services
        ==================================== -->
		
		<section id="services" class="features">
			<div class="container">
				<div class="row">
				
					<div class="sec-title text-center mb50 wow bounceInDown animated" data-wow-duration="500ms">
						<h2>Services</h2>
						<div class="devider"><i class="fa fa-heart-o fa-lg"></i></div>
					</div>

					<!-- service item -->
					 <?php 

			          for($j=0;$j<count($service_details);$j++)
			          {
			          ?>
					<div class="col-md-4 wow fadeInLeft" data-wow-duration="500ms">
						<div class="service-item">
							<div class="">
								 <?php 
					                  echo '<img src="http://localhost/ag7dev.git/trunk/api/'.$service_details[$j]['service_image'].' " class="img-fluid" style="width:100%;">'; 
					                ?>
							</div>
							
							<div class="service-desc">
								<h3><?php echo $service_details[$j]['service_name'];?></h3>
								<p><?php echo $service_details[$j]['desc'];?></p>
							</div>
						</div>
					</div>
					 <?php } ?>
					<!-- end service item -->
					
						
				</div>
			</div>
		</section>
		
        <!--
        End Services
        ==================================== -->
		
		
        <!--
        Our Products
        ==================================== -->
		
		<section id="products" class="works clearfix">
			<div class="container">
				<div class="row">
				
					<div class="sec-title text-center">
						<h2>Products</h2>
						<div class="devider"><i class="fa fa-heart-o fa-lg"></i></div>
					</div>
					
					<div class="sec-sub-title text-center">
						<p>various products</p>
					</div>
					
					<!--<div class="work-filter wow fadeInRight animated" data-wow-duration="500ms">
						<ul class="text-center">
							<li><a href="<?php echo base_url();?>assets/template3/javascript:;" data-filter="all" class="active filter">All</a></li>
							<li><a href="<?php echo base_url();?>assets/template3/javascript:;" data-filter=".branding" class="filter">Branding</a></li>
							<li><a href="<?php echo base_url();?>assets/template3/javascript:;" data-filter=".web" class="filter">web</a></li>
							<li><a href="<?php echo base_url();?>assets/template3/javascript:;" data-filter=".logo-design" class="filter">logo design</a></li>
							<li><a href="<?php echo base_url();?>assets/template3/javascript:;" data-filter=".photography" class="filter">photography</a></li>
						</ul>
					</div> -->
					
				</div>
			</div>
			
			<div class="project-wrapper">
				 <?php
		          if(count($product_details)>0)
		          {
		            for($i=0;$i<count($product_details);$i++)
		              {
		                //echo $product_details[$i]['product_image'];
		                ?>
				<figure class="mix work-item branding">
					 <?php 
                        echo '<img src="http://localhost/ag7dev.git/trunk/api/'.$product_details[$i]['product_image'].' " class="img-fluid" style="width:100%;">'; 
                        ?>
					<figcaption class="overlay">
						<h3><?php echo $product_details[$i]['product_name'];?></a></h3>
									<p><?php echo $product_details[$i]['price'];?></p>
					</figcaption>
				</figure>
				<?php } 
						        } else
						        {?>
						        	<span class="portfolio-item">No Products found</span>
							<?php }?>
				
				
			</div>
		

		</section>
		
        <!--
        End Our Works
        ==================================== -->
		
        <!--
        ads
        ==================================== -->		
		
		<section id="ads" class="team">
			<div class="container">
				<div class="row">
		
					<div class="sec-title text-center wow fadeInUp animated" data-wow-duration="700ms">
						<h2>Advertisment</h2>
						<div class="devider"><i class="fa fa-heart-o fa-lg"></i></div>
					</div>
					
					<!-- <div class="sec-sub-title text-center wow fadeInRight animated" data-wow-duration="500ms">
						<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore</p>
					</div> -->
					
					<!-- single member -->
					 <?php 

			          for($k=0;$k<count($ad_details);$k++)
			          {
			          ?>
					<figure class="team-member col-md-3 col-sm-6 col-xs-12 text-center wow fadeInUp animated" data-wow-duration="500ms" data-wow-delay="600ms">
						<div class="member-thumb">
							<?php
							 if($ad_details[$k]['ad_type']==1)
				                  { 
				                      echo '<img src="http://localhost/ag7dev.git/trunk/api/'.$ad_details[$k]['uploads'].' " class="img-fluid" style="width:100%;height:210px;">'; 
				                  }
				                  else{
				                    echo '<video width="280" height="200" controls>
				                            <source src="http://localhost/ag7dev.git/trunk/api/'.$ad_details[$k]['uploads'].'" type="video/mp4">
				                          </video>';
				                  }
				                  ?>
							<figcaption class="overlay">
								<h5>voluptatem quia voluptas </h5>
								<p>sit aspernatur aut odit aut fugit,</p>
								
							</figcaption>
						</div>
						<h4>Steve Flaulkin</h4>
						<span>Sr. UI Designer</span>
					</figure>
				<?php } ?>
					<!-- end single member -->
					<!-- single member -->
					
				</div>
			</div>
		</section>
		
        <!--
        End Ads
        ==================================== -->
		
		
		
		
        <!--
        End Some fun facts
        ==================================== -->
		
		
		<!--
        Contact Us
        ==================================== -->		
		
		<section id="contact" class="contact">
			<div class="container">
				<div class="row mb50">
				
					<div class="sec-title text-center mb50 wow fadeInDown animated" data-wow-duration="500ms">
						<h2>Contact Us</h2>
						<div class="devider"><i class="fa fa-heart-o fa-lg"></i></div>
					</div>
					
					<div class="sec-sub-title text-center wow rubberBand animated" data-wow-duration="1000ms">
						<p>Address </p>
					</div>
					
					<!-- contact address -->
					<div class="col-lg-6 col-md-6 col-sm-4 col-xs-12 wow fadeInLeft animated" data-wow-duration="500ms">
						<div class="contact-address">
							<p><i class="fa fa-pencil"></i><?php echo $website;?>
								<span><?php echo $address;?></span><span>Australia</span></p><br>
								<p><i class="fa fa-phone"></i>Phone: <?php echo $mobile;?> </p>
								<p><i class="fa fa-envelope"></i><?php echo $mail;?></p>
						</div>
					</div>
					<!-- end contact address -->
					
					
					
					<!-- footer social links -->
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 wow fadeInRight animated" data-wow-duration="500ms" data-wow-delay="600ms">
						<ul class="footer-social">
							<li style="float: left; margin-right: 10px;"><a href="<?php echo base_url();?>assets/template3/https://www.behance.net/Themefisher"><i class="fa fa-behance fa-2x"></i></a></li>
							<li style="float: left; margin-right: 10px;"><a href="<?php echo base_url();?>assets/template3/https://www.twitter.com/Themefisher"><i class="fa fa-twitter fa-2x"></i></a></li>
							<li style="float: left; margin-right: 10px;"><a href="<?php echo base_url();?>assets/template3/https://dribbble.com/themefisher"><i class="fa fa-dribbble fa-2x"></i></a></li>
							<li style="float: left; margin-right: 10px;"><a href="<?php echo base_url();?>assets/template3/https://www.facebook.com/Themefisher"><i class="fa fa-facebook fa-2x"></i></a></li>
						</ul>
					</div>
					<!-- end footer social links -->
					
				</div>
			</div>
			
			
			
		</section>
		
        <!--
        End Contact Us
        ==================================== -->
		
		
		<footer id="footer" class="footer">
			<div class="container">
				
				<div class="row">
					<div class="col-md-12">
						<p class="copyright text-center">
							Copyright © 2019 Roodabatoz. All rights reserved.
						</p>
					</div>
				</div>
			</div>
		</footer>
		
		<a href="<?php echo base_url();?>assets/template3/javascript:void(0);" id="back-top"><i class="fa fa-angle-up fa-3x"></i></a>

		<!-- Essential jQuery Plugins
		================================================== -->
		<!-- Main jQuery -->
        <script src="<?php echo base_url();?>assets/template3/js/jquery-1.11.1.min.js"></script>
		<!-- Single Page Nav -->
        <script src="<?php echo base_url();?>assets/template3/js/jquery.singlePageNav.min.js"></script>
		<!-- Twitter Bootstrap -->
        <script src="<?php echo base_url();?>assets/template3/js/bootstrap.min.js"></script>
		<!-- jquery.fancybox.pack -->
        <script src="<?php echo base_url();?>assets/template3/js/jquery.fancybox.pack.js"></script>
		<!-- jquery.mixitup.min -->
        <script src="<?php echo base_url();?>assets/template3/js/jquery.mixitup.min.js"></script>
		<!-- jquery.parallax -->
        <script src="<?php echo base_url();?>assets/template3/js/jquery.parallax-1.1.3.js"></script>
		<!-- jquery.countTo -->
        <script src="<?php echo base_url();?>assets/template3/js/jquery-countTo.js"></script>
		<!-- jquery.appear -->
        <script src="<?php echo base_url();?>assets/template3/js/jquery.appear.js"></script>
		<!-- Contact form validation -->
		<script src="<?php echo base_url();?>assets/template3/http://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.32/jquery.form.js"></script>
		<script src="<?php echo base_url();?>assets/template3/http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.1/jquery.validate.min.js"></script>
		
		<!-- jquery easing -->
        <script src="<?php echo base_url();?>assets/template3/js/jquery.easing.min.js"></script>
		<!-- jquery easing -->
        <script src="<?php echo base_url();?>assets/template3/js/wow.min.js"></script>
		<script>
			var wow = new WOW ({
				boxClass:     'wow',      // animated element css class (default is wow)
				animateClass: 'animated', // animation css class (default is animated)
				offset:       120,          // distance to the element when triggering the animation (default is 0)
				mobile:       false,       // trigger animations on mobile devices (default is true)
				live:         true        // act on asynchronously loaded content (default is true)
			  }
			);
			wow.init();
		</script> 
		<!-- Custom Functions -->
        <script src="<?php echo base_url();?>assets/template3/js/custom.js"></script>
		
		<script type="text/javascript">
			$(function(){
				/* ========================================================================= */
				/*	Contact Form
				/* ========================================================================= */
				
				$('#contact-form').validate({
					rules: {
						name: {
							required: true,
							minlength: 2
						},
						email: {
							required: true,
							email: true
						},
						message: {
							required: true
						}
					},
					messages: {
						name: {
							required: "come on, you have a name don't you?",
							minlength: "your name must consist of at least 2 characters"
						},
						email: {
							required: "no email, no message"
						},
						message: {
							required: "um...yea, you have to write something to send this form.",
							minlength: "thats all? really?"
						}
					},
					submitHandler: function(form) {
						$(form).ajaxSubmit({
							type:"POST",
							data: $(form).serialize(),
							url:"process.php",
							success: function() {
								$('#contact-form :input').attr('disabled', 'disabled');
								$('#contact-form').fadeTo( "slow", 0.15, function() {
									$(this).find(':input').attr('disabled', 'disabled');
									$(this).find('label').css('cursor','default');
									$('#success').fadeIn();
								});
							},
							error: function() {
								$('#contact-form').fadeTo( "slow", 0.15, function() {
									$('#error').fadeIn();
								});
							}
						});
					}
				});
			});
		</script>
    </body>
</html>
