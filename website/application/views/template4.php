<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Roodabatoz</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url();?>assets/template4/asset/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome CSS -->
    <link href="<?php echo base_url();?>assets/template4/css/font-awesome.min.css" rel="stylesheet">
    
    
    <!-- Animate CSS -->
    <link href="<?php echo base_url();?>assets/template4/css/animate.css" rel="stylesheet" >
    
    <!-- Owl-Carousel -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template4/css/owl.carousel.css" >
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template4/css/owl.theme.css" >
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template4/css/owl.transitions.css" >

    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>assets/template4/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/template4/css/responsive.css" rel="stylesheet">
    
    <!-- Colors CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/template4/css/color/green.css">
    
    
    
    <!-- Colors CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/template4/css/color/green.css" title="green">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/template4/css/color/light-red.css" title="light-red">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/template4/css/color/blue.css" title="blue">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/template4/css/color/light-blue.css" title="light-blue">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/template4/css/color/yellow.css" title="yellow">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/template4/css/color/light-green.css" title="light-green">

    <!-- Custom Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    
    
    <!-- Modernizer js -->
    <script src="<?php echo base_url();?>assets/template4/js/modernizr.custom.js"></script>

    
    <!--[if lt IE 9]>
        <script src="<?php echo base_url();?>assets/template4/https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="<?php echo base_url();?>assets/template4/https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="index">
    
    
    <!-- Styleswitcher
================================================== -->
        <div class="colors-switcher">
            <a id="show-panel" class="hide-panel"><i class="fa fa-tint"></i></a>        
                <ul class="colors-list">
                    <li><a title="Light Red" onClick="setActiveStyleSheet('light-red'); return false;" class="light-red"></a></li>
                    <li><a title="Blue" class="blue" onClick="setActiveStyleSheet('blue'); return false;"></a></li>
                    <li class="no-margin"><a title="Light Blue" onClick="setActiveStyleSheet('light-blue'); return false;" class="light-blue"></a></li>
                    <li><a title="Green" class="green" onClick="setActiveStyleSheet('green'); return false;"></a></li>
                    
                    <li class="no-margin"><a title="light-green" class="light-green" onClick="setActiveStyleSheet('light-green'); return false;"></a></li>
                    <li><a title="Yellow" class="yellow" onClick="setActiveStyleSheet('yellow'); return false;"></a></li>
                    
                </ul>

        </div>  
<!-- Styleswitcher End
================================================== -->

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="<?php echo base_url();?>assets/template4/#page-top">
					<img src="<?php echo base_url();?>assets/template4/images/logo.png" alt="Roodabatoz" style="width: 123px;">
				</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="<?php echo base_url();?>assets/template4/#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="<?php echo base_url();?>assets/template4/#services">Services</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="<?php echo base_url();?>assets/template4/#products">Products</a>
                    </li>
                   
                    <li>
                        <a class="page-scroll" href="<?php echo base_url();?>assets/template4/#ads">Advertisment</a>
                    </li>
                  
                    <li>
                        <a class="page-scroll" href="<?php echo base_url();?>assets/template4/#contact">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    
    
    
    <!-- Start Home Page Slider -->
    <section id="page-top">
        <!-- Carousel -->
        <div id="main-slide" class="carousel slide" data-ride="carousel">

            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#main-slide" data-slide-to="0" class="active"></li>
                <li data-target="#main-slide" data-slide-to="1"></li>
                <li data-target="#main-slide" data-slide-to="2"></li>
            </ol>
            <!--/ Indicators end-->

            <!-- Carousel inner -->
            <div class="carousel-inner">
                <div class="item active">
                    <img class="img-responsive" src="<?php echo base_url();?>assets/template4/images/header-bg-1.jpg" alt="slider">
                    <div class="slider-content">
                        <div class="col-md-12 text-center">
                            <h1 class="animated3">
                                <span><strong>Fame</strong> for the highest</span>
                            </h1>
                            <p class="animated2">At vero eos et accusamus et iusto odio dignissimos<br> ducimus qui blanditiis praesentium voluptatum</p>	
                            <a href="<?php echo base_url();?>assets/template4/#feature" class="page-scroll btn btn-primary animated1">Read More</a>
                        </div>
                    </div>
                </div>
                <!--/ Carousel item end -->
                
                <div class="item">
                    <img class="img-responsive" src="<?php echo base_url();?>assets/template4/images/header-back.png" alt="slider">
                    
                    <div class="slider-content">
                        <div class="col-md-12 text-center">
                            <h1 class="animated1">
                    		  <span>Welcome to <strong>Fame</strong></span>
                    	    </h1>
                            <p class="animated2">Generate a flood of new business with the<br> power of a digital media platform</p>
                            <a href="<?php echo base_url();?>assets/template4/#feature" class="page-scroll btn btn-primary animated3">Read More</a>
                        </div>
                    </div>
                </div>
                <!--/ Carousel item end -->
                
                <div class="item">
                    <img class="img-responsive" src="<?php echo base_url();?>assets/template4/images//galaxy.jpg" alt="slider">
                    <div class="slider-content">
                        <div class="col-md-12 text-center">
                            <h1 class="animated2">
                                <span>The way of <strong>Success</strong></span>
                            </h1>
                            <p class="animated1">At vero eos et accusamus et iusto odio dignissimos<br> ducimus qui blanditiis praesentium voluptatum</p>	
                             <a class="animated3 slider btn btn-primary btn-min-block" href="<?php echo base_url();?>assets/template4/#">Get Now</a><a class="animated3 slider btn btn-default btn-min-block" href="<?php echo base_url();?>assets/template4/#">Live Demo</a>
                                
                        </div>
                    </div>
                </div>
                <!--/ Carousel item end -->
            </div>
            <!-- Carousel inner end-->

            <!-- Controls -->
            <a class="left carousel-control" href="<?php echo base_url();?>assets/template4/#main-slide" data-slide="prev">
                <span><i class="fa fa-angle-left"></i></span>
            </a>
            <a class="right carousel-control" href="<?php echo base_url();?>assets/template4/#main-slide" data-slide="next">
                <span><i class="fa fa-angle-right"></i></span>
            </a>
        </div>
        <!-- /carousel -->
    </section>
    <!-- End Home Page Slider -->

    
	 <!-- Start About Us Section -->
    <section id="services" class="about-us-section-1">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="section-title text-center">
                            <h3>Services</h3>
                            <p>We provides various services</p>
                        </div>
                </div>
            </div>
            <div class="row">
                
                <div class="col-md-4">
                    <div class="welcome-section text-center">
                        <img src="<?php echo base_url();?>assets/template4/images/about-01.jpg" class="img-responsive" alt="..">
                        <h4>Office Philosophy</h4>
                        <div class="border"></div>
                        <p>Duis aute irure dolor in reprehen derit in voluptate velit essecillum dolore eu fugiat nulla pariatur. Lorem reprehenderit</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="welcome-section text-center">
                        <img src="<?php echo base_url();?>assets/template4/images/about-02.jpg" class="img-responsive" alt="..">
                        <h4>Office Mission & Vission</h4>
                        <div class="border"></div>
                        <p>Duis aute irure dolor in reprehen derit in voluptate velit essecillum dolore eu fugiat nulla pariatur. Lorem reprehenderit</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="welcome-section text-center">
                        <img src="<?php echo base_url();?>assets/template4/images/about-03.jpg" class="img-responsive" alt="..">
                        <h4>Office Value & Rules</h4>
                        <div class="border"></div>
                        <p>Duis aute irure dolor in reprehen derit in voluptate velit essecillum dolore eu fugiat nulla pariatur. Lorem reprehenderit</p>
                    </div>
                </div>
                
            </div><!-- /.row -->            
            
        </div><!-- /.container -->
    </section>
    <!-- Services Section -->
	
    
    <!-- Start Call to Action Section -->
    <section class="call-to-action">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Libero tempore soluta nobis est eligendi</br> optio cumque nihil impedit minus id quod maxime </br>placeat facere possimus, omnis voluptas assumenda est</h1>
                    
                </div>
            </div>
        </div>
    </section>
    <!-- End Call to Action Section -->
      
    
    <!-- Start Products Section -->
        <section id="products" class="portfolio-section-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title text-center">
                            <h3>Our Products</h3>
                            <p>Duis aute irure dolor in reprehenderit in voluptate</p>
                        </div>                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        
                        <!-- Start Portfolio items -->
                        <ul id="portfolio-list">
                            <li>
                                <div class="portfolio-item">
                                    <img src="<?php echo base_url();?>assets/template4/images/portfolio/img1.jpg" class="img-responsive" alt="" />
                                    <div class="portfolio-caption">
                                        <h4>Portfolio Title</h4>
                                        <a href="<?php echo base_url();?>assets/template4/#portfolio-modal" data-toggle="modal" class="link-1"><i class="fa fa-magic"></i></a>
                                        <a href="<?php echo base_url();?>assets/template4/#" class="link-2"><i class="fa fa-link"></i></a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="portfolio-item">
                                    <img src="<?php echo base_url();?>assets/template4/images/portfolio/img2.jpg" class="img-responsive" alt="" />
                                    <div class="portfolio-caption">
                                        <h4>Portfolio Title</h4>
                                        <a href="<?php echo base_url();?>assets/template4/#portfolio-modal" data-toggle="modal" class="link-1"><i class="fa fa-magic"></i></a>
                                        <a href="<?php echo base_url();?>assets/template4/#" class="link-2"><i class="fa fa-link"></i></a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="portfolio-item">
                                    <img src="<?php echo base_url();?>assets/template4/images/portfolio/img3.jpg" class="img-responsive" alt="" />
                                    <div class="portfolio-caption">
                                        <h4>Portfolio Title</h4>
                                        <a href="<?php echo base_url();?>assets/template4/#portfolio-modal" data-toggle="modal" class="link-1"><i class="fa fa-magic"></i></a>
                                        <a href="<?php echo base_url();?>assets/template4/#" class="link-2"><i class="fa fa-link"></i></a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="portfolio-item">
                                    <img src="<?php echo base_url();?>assets/template4/images/portfolio/img4.jpg" class="img-responsive" alt="" />
                                    <div class="portfolio-caption">
                                        <h4>Portfolio Title</h4>
                                        <a href="<?php echo base_url();?>assets/template4/#portfolio-modal" data-toggle="modal" class="link-1"><i class="fa fa-magic"></i></a>
                                        <a href="<?php echo base_url();?>assets/template4/#" class="link-2"><i class="fa fa-link"></i></a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="portfolio-item">
                                    <img src="<?php echo base_url();?>assets/template4/images/portfolio/img5.jpg" class="img-responsive" alt="" />
                                    <div class="portfolio-caption">
                                        <h4>Portfolio Title</h4>
                                        <a href="<?php echo base_url();?>assets/template4/#portfolio-modal" data-toggle="modal" class="link-1"><i class="fa fa-magic"></i></a>
                                        <a href="<?php echo base_url();?>assets/template4/#" class="link-2"><i class="fa fa-link"></i></a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="portfolio-item">
                                    <img src="<?php echo base_url();?>assets/template4/images/portfolio/img6.jpg" class="img-responsive" alt="" />
                                    <div class="portfolio-caption">
                                        <h4>Portfolio Title</h4>
                                        <a href="<?php echo base_url();?>assets/template4/#portfolio-modal" data-toggle="modal" class="link-1"><i class="fa fa-magic"></i></a>
                                        <a href="<?php echo base_url();?>assets/template4/#" class="link-2"><i class="fa fa-link"></i></a>
                                    </div>
                                </div>
                            </li>
                            
                            
                        </ul>
                        <!-- End Portfolio items -->
                    </div>
                </div>
            </div>
        </section>
        <!-- End Products Section -->
    
    <!-- Start Product view Modal Section -->
        <div class="section-modal modal fade" id="portfolio-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
                
                <div class="container">
                    <div class="row">
                        <div class="section-title text-center">
                            <h3>Portfolio Details</h3>
                            <p>Duis aute irure dolor in reprehenderit in voluptate</p>
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="col-md-6">
                            <img src="<?php echo base_url();?>assets/template4/images/portfolio/img1.jpg" class="img-responsive" alt="..">
                        </div>
                        <div class="col-md-6">
                            <img src="<?php echo base_url();?>assets/template4/images/portfolio/img1.jpg" class="img-responsive" alt="..">
                        </div>
                        
                    </div><!-- /.row -->
                </div>                
            </div>
        </div>
        <!-- End Products view Modal Section -->
  
    
   

    <!-- Start Ads Section -->
    <section id="ads" class="team-member-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="section-title text-center">
                            <h3>Advertisement</h3>
                            <p>Duis aute irure dolor in reprehenderit in voluptate</p>
                        </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div id="team-section">
                    
                        
                
                

                                <div class="our-team">

                                    <div class="team-member">
                                        <img src="<?php echo base_url();?>assets/template4/images/team/manage-1.png" class="img-responsive" alt="">
                                        <div class="team-details">
                                            <h4>John Doe</h4>
                                            <p>Founder & Director</p>
                                            
                                        </div>
                                    </div>

                                    <div class="team-member">
                                        <img src="<?php echo base_url();?>assets/template4/images/team/manage-2.png" class="img-responsive" alt="">
                                        <div class="team-details">
                                            <h4>John Doe</h4>
                                            <p>Founder & Director</p>
                                            
                                        </div>
                                    </div>

                                    <div class="team-member">
                                        <img src="<?php echo base_url();?>assets/template4/images/team/manage-3.png" class="img-responsive" alt="">
                                        <div class="team-details">
                                            <h4>John Doe</h4>
                                            <p>Founder & Director</p>
                                            
                                        </div>
                                    </div>    

                                    <div class="team-member">
                                        <img src="<?php echo base_url();?>assets/template4/images/team/manage-4.png" class="img-responsive" alt="">
                                        <div class="team-details">
                                            <h4>John Doe</h4>
                                            <p>Founder & Director</p>
                                           
                                        </div>
                                    </div>

                                    <div class="team-member">
                                        <img src="<?php echo base_url();?>assets/template4/images/team/manage-1.png" class="img-responsive" alt="">
                                        <div class="team-details">
                                            <h4>John Doe</h4>
                                            <p>Founder & Director</p>
                                            
                                        </div>
                                    </div>

                                    <div class="team-member">
                                        <img src="<?php echo base_url();?>assets/template4/images/team/manage-2.png" class="img-responsive" alt="">
                                        <div class="team-details">
                                            <h4>John Doe</h4>
                                            <p>Founder & Director</p>
                                            
                                        </div>
                                    </div>


                                </div>

                    
                    </div>
                </div>
            </div>
                
        </div>
    </section>
    <!-- End Ads Section -->


  
    <section id="contact" class="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h3>Contact With Us</h3>
                        <p class="white-text">Duis aute irure dolor in reprehenderit in voluptate</p>
                    </div>
                </div>
            </div>
           
            <div class="row">
                <div class="col-md-12">
                    <div class="footer-contact-info">
                        <h4>Contact info</h4>
                        <ul>
                            <li><strong>E-mail :</strong> your-email@mail.com</li>
                            <li><strong>Phone :</strong> +8801-6778776</li>
                            <li><strong>Mobile :</strong> +8801-45565378</li>
                            <li><strong>Web :</strong> yourdomain.com</li>
                        </ul>
                    </div>
                </div>
               
            </div>
        </div>
        <footer class="style-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <span class="copyright">Copyright &copy; 2019 Roodabatoz</span>
                    </div>
                   
                   
                </div>
            </div>
        </footer>
    </section>


    <div id="loader">
        <div class="spinner">
            <div class="dot1"></div>
            <div class="dot2"></div>
        </div>
    </div>

    

    <!-- jQuery Version 2.1.1 -->
    <script src="<?php echo base_url();?>assets/template4/js/jquery-2.1.1.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url();?>assets/template4/asset/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/template4/js/jquery.easing.1.3.js"></script>
    <script src="<?php echo base_url();?>assets/template4/js/classie.js"></script>
    <script src="<?php echo base_url();?>assets/template4/js/count-to.js"></script>
    <script src="<?php echo base_url();?>assets/template4/js/jquery.appear.js"></script>
    <script src="<?php echo base_url();?>assets/template4/js/cbpAnimatedHeader.js"></script>
    <script src="<?php echo base_url();?>assets/template4/js/owl.carousel.min.js"></script>
	<script src="<?php echo base_url();?>assets/template4/js/jquery.fitvids.js"></script>
	<script src="<?php echo base_url();?>assets/template4/js/styleswitcher.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="<?php echo base_url();?>assets/template4/js/jqBootstrapValidation.js"></script>
    <script src="<?php echo base_url();?>assets/template4/js/contact_me.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url();?>assets/template4/js/script.js"></script>

</body>

</html>
