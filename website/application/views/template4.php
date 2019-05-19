<!DOCTYPE html>
<html lang="en">
<?php
$path_url = $this->config->item('path_url');

 ?>

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
                <a class="navbar-brand page-scroll" href="#page-top">
					<img src="<?php echo base_url();?>assets/template4/images/logo.png" alt="Roodabatoz" style="width: 123px;">
				</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#services">Services</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#products">Products</a>
                    </li>
                   
                    <li>
                        <a class="page-scroll" href="#ads">Advertisment</a>
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
                                <span><strong>Roodabatoz</strong> welcome to this site</span>
                            </h1>
                            <p class="animated2"> We are a team of professionals.</p>	
                            <!-- <a href="#feature" class="page-scroll btn btn-primary animated1">Read More</a> -->
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
                            <a href="#feature" class="page-scroll btn btn-primary animated3">Read More</a>
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
                             <a class="animated3 slider btn btn-primary btn-min-block" href="#">Get Now</a><a class="animated3 slider btn btn-default btn-min-block" href="#">Live Demo</a>
                                
                        </div>
                    </div>
                </div>
                <!--/ Carousel item end -->
            </div>
            <!-- Carousel inner end-->

            <!-- Controls -->
            <a class="left carousel-control" href="#main-slide" data-slide="prev">
                <span><i class="fa fa-angle-left"></i></span>
            </a>
            <a class="right carousel-control" href="#main-slide" data-slide="next">
                <span><i class="fa fa-angle-right"></i></span>
            </a>
        </div>
        <!-- /carousel -->
    </section>
    <!-- End Home Page Slider -->

     
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
                            
                            <li><strong>E-mail :</strong><?php echo $mail;?></li>
                            <li><strong>Phone :</strong><?php echo $mobile;?></li>
                            <li><strong>Web :</strong><?php echo $website;?></li>
                        </ul>
                    </div>
                </div>
               
            </div>
        </div>
       
    </section>

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
                 <?php 

                  for($j=0;$j<count($service_details);$j++)
                  {
                  ?>
                <div class="col-md-4">
                    <div class="welcome-section text-center">
                        <?php 
                          echo '<img src="'.$path_url.$service_details[$j]['service_image'].' " class="img-fluid" style="width:100%;">'; 
                        ?>
                        <h3><?php echo $service_details[$j]['service_name'];?></h3>
                                <p><?php echo $service_details[$j]['desc'];?></p>
                    </div>
                </div>
                <?php } ?>
               
                
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
                             <?php
                              if(count($product_details)>0)
                              {
                                for($i=0;$i<count($product_details);$i++)
                                  {
                                    //echo $product_details[$i]['product_image'];
                                    ?>
                            <li>
                                <div class="portfolio-item">
                                    <?php 
                                        echo '<img src="'.$path_url.$product_details[$i]['product_image'].' " class="img-fluid" style="width:100%;">'; 
                                        ?>
                                    <div class="portfolio-caption">
                                       <h3><?php echo $product_details[$i]['product_name'];?></a></h3>
                                    <p><?php echo $product_details[$i]['price'];?></p>
                                    </div>
                                </div>
                            </li>
                            <?php } 
                                } else
                                {?>
                                    <span class="portfolio-item">No Products found</span>
                            <?php }?>
                           
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
                            <!-- <p>Duis aute irure dolor in reprehenderit in voluptate</p> -->
                        </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div id="team-section">
                                <div class="our-team">
                                     <?php
                                      for($k=0;$k<count($ad_details);$k++)
                                      {
                                      ?>
                                    <div class="team-member">
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
                                        <!-- <div class="team-details">
                                            <h4>John Doe</h4>
                                            <p>Founder & Director</p>
                                            
                                        </div> -->
                                    </div>
                                    <?php } ?>
                                  


                                </div>

                    
                    </div>
                </div>
            </div>
                
        </div>
    </section>
    <!-- End Ads Section -->

<section>
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
