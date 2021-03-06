<?php
//echo "<pre>";print_r($product_details);die;
$this->load->view('index.html');
$path_url = $this->config->item('path_url');
$login_url = $this->config->item('login_url');
$image_path = $this->config->item('base_path');
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html lang="en" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html lang="en" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html lang="en" class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
    <head>
    	<!-- meta character set -->
        <meta charset="utf-8">
		<!-- Always force latest IE rendering engine or request Chrome Frame -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Roodabatoz</title>		
		<!-- Meta Description -->
        <meta name="description" content="Roodabatoz">
        <meta name="keywords" content="Roodabatoz">
        <meta name="author" content="skillers">
		
		<!-- Mobile Specific Meta -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!-- CSS
		================================================== -->
		
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
		
		<!-- Fontawesome Icon font -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/template2/css/font-awesome.min.css">
		<!-- bootstrap.min -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/template2/css/jquery.fancybox.css">
		<!-- bootstrap.min -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/template2/css/bootstrap.min.css">
		<!-- bootstrap.min -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/template2/css/owl.carousel.css">
		<!-- bootstrap.min -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/template2/css/slit-slider.css">
		<!-- bootstrap.min -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/template2/css/animate.css">
		<!-- Main Stylesheet -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/template2/css/main.css">

		<!-- Modernizer Script for old Browsers -->
        <script src="<?php echo base_url();?>assets/template2/js/modernizr-2.6.2.min.js"></script>

    </head>
	
    <body id="body">

		<!-- preloader -->
		<div id="preloader">
            <div class="loder-box">
            	<div class="battery"></div>
            </div>
		</div>
		<!-- end preloader -->

        <!--
        Fixed Navigation
        ==================================== -->
        <header id="navigation" class="navbar-inverse navbar-fixed-top animated-header">
            <div class="container">
                <div class="navbar-header">
                    <!-- responsive nav button -->
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
                    </button>
					<!-- /responsive nav button -->
					
					<!-- logo -->
					<h1 class="navbar-brand">
						<a href="#body"><img src="<?php echo base_url();?>assets/template2/img/logo.png" style="width: 134px;" /></a>
					</h1>
					<!-- /logo -->
                </div>

				<!-- main nav -->
                <nav class="collapse navbar-collapse navbar-right" role="navigation">
                    <ul id="nav" class="nav navbar-nav">
						<li><a href="#body">Home</a></li>
						<li><a href="#contact">My Contact</a></li>
                        <li><a href="#service">My Service</a></li>
                        <li><a href="#portfolio">My Products</a></li>
                        <li><a href="#testimonials">My Ads</a></li> 
                        <li><a href="#videosection">My videos</a></li> 
                        <li><a href="<?php echo $login_url; ?>" target="_blank">Website login</a></li> 
                         <li>
				            <a href="javascript:void(0);" data-toggle="modal" data-target="#searchModal"> 
				              <img src="./assets/img/search.png" style="width:30px;cursor: pointer;">
				            </a>
				          </li>                      
                    </ul>
                </nav>
				<!-- /main nav -->
				
            </div>
        </header>
        <!--
        End Fixed Navigation
        ==================================== -->
		
		<main class="site-content" role="main">
		
        <!--
        Home Slider
        ==================================== -->
		
		<section id="home-slider">
            <div id="slider" class="sl-slider-wrapper">

				<div class="sl-slider">
					<?php 
					if(count($slider_image)>0)
                	{
                    	for($j=0;$j<count($slider_image);$j++)
                    	{
                    		?>
                    		<div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
								<div class="bg-img bg-img-1">
									<img src="<?php echo $image_path.$slider_image[$j]['slider_image']; ?>" style="width:1349px; height: 591px; max-width: 1349px;max-height: 591px;" />
								</div>
							</div>
						<?php 
						} 
					}
					else{
					?>

					<div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
						<div class="bg-img bg-img-1">
							<img src="<?php //echo base_url();?>assets/template2/img/slider/banner.jpg" style="width:1349px; height: 591px; max-width: 1349px;max-height: 591px;" />
						</div>
					</div>
					
					<div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
						<div class="bg-img bg-img-2">
							<img src="<?php echo base_url();?>assets/template2/img/slider/affinity.jpeg"  style="width:1349px; height: 591px; max-width: 1349px;max-height: 591px;" />
						</div>
					</div>
				<?php } ?>
				</div><!-- /sl-slider -->

               
                
                <nav id="nav-arrows" class="nav-arrows hidden-xs hidden-sm visible-md visible-lg">
                    <a href="javascript:;" class="sl-prev">
                        <i class="fa fa-angle-left fa-3x"></i>
                    </a>
                    <a href="javascript:;" class="sl-next">
                        <i class="fa fa-angle-right fa-3x"></i>
                    </a>
                </nav>
                

				<nav id="nav-dots" class="nav-dots visible-xs visible-sm hidden-md hidden-lg">
					<span class="nav-dot-current"></span>
					<span></span>
					<span></span>
				</nav>

			</div><!-- /slider-wrapper -->
		</section>
		
        <!--
        End Home SliderEnd
        ==================================== -->
			
			<!-- about section -->
			<section id="about" >
				<div class="container">
					<div class="row">
						<!--<div class="col-md-4 wow animated fadeInLeft">
							<div class="recent-works">
								<h3>Recent Works</h3>
								<div id="works">
									<div class="work-item">
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. <br> <br> There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
									</div>
									<div class="work-item">
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. <br><br> There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
									</div>
									<div class="work-item">
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. <br><br> There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
									</div>
								</div>
							</div>
						</div>-->
						<div class="col-md-12 col-md-offset-1 wow animated fadeInRight">
							<div class="welcome-block">
								<h3>Welcome To <?php echo $website;?></h3>								
						     	 <div class="message-body">
									 <?php 

								           if(isset($contact_details[0]['website_image'])&&($contact_details[0]['website_image']!=''))
									         {
									            $image = $contact_details[0]['website_image'];
									         }
									         else{
									          $image = ($profile_image!='')?$profile_image:'user_profile/default.png';
									         }
								          echo '<img align="left" style="width: 165px; height: 180px;" src="'.$path_url.$image.'" alt="Profile image example"/>';
								         ?>
								          <?php 
								              $about_us=(isset($contact_details[0]['about_website']) && ($contact_details[0]['about_website']!=''))?$contact_details[0]['about_website']:'Welcome to mysite';

								            ?>
						       		<p><?php echo $about_us; ?> </p>
						     	 </div>
						       	
						    </div>
						</div>
					</div>
				</div>
			</section>
			<!-- end about section -->
			
			<!-- Contact section -->
			<section id="contact" >
				<div class="container">
					<div class="row">
						
						<div class="sec-title text-center wow animated fadeInDown">
							<h2>My Contact</h2>
							
						</div>
						
						
						<!--<div class="col-md-7 contact-form wow animated fadeInLeft">
							<form action="#" method="post">
								<div class="input-field">
									<input type="text" name="name" class="form-control" placeholder="Your Name...">
								</div>
								<div class="input-field">
									<input type="email" name="email" class="form-control" placeholder="Your Email...">
								</div>
								<div class="input-field">
									<input type="text" name="subject" class="form-control" placeholder="Subject...">
								</div>
								<div class="input-field">
									<textarea name="message" class="form-control" placeholder="Messages..."></textarea>
								</div>
						       	<button type="submit" id="submit" class="btn btn-blue btn-effect">Send</button>
							</form>
						</div>-->
						
						<div class="col-md-12 wow animated fadeInRight">
							<address class="contact-details">
								<h3>My Contact</h3>						
								<p><i class="fa fa-pencil"></i><?php echo $website;?>
								<span>
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
									</span></p><br>
								<p><i class="fa fa-phone"></i>Phone: <?php echo $mobile;?>,
									<?php 
									if(isset($contact_details[0]['phonenumber'])&&$contact_details[0]['phonenumber']!='')
									{
										echo "Phone :".$contact_details[0]['phonenumber'];
									} ?>,
								<?php if(isset($contact_details[0]['homenumber'])){
								echo "Home :".$contact_details[0]['homenumber'];
								} ?>,
								<?php if(isset($contact_details[0]['officenumber'])){
								echo "Office :".$contact_details[0]['officenumber'];
								} ?>,
								<?php if(isset($contact_details[0]['faxnumber'])){
								echo "Fax :".$contact_details[0]['faxnumber'];
								} ?> </p>
								
								<p><i class="fa fa-envelope"></i>
									 <?php 
                 
						                if(isset($contact_details[0]['email'])&&($contact_details[0]['email']!=''))
						                {
						                  echo $contact_details[0]['email']; 
						                }
						                else
						                {
						                  echo $mail;
						                }
						                 
						                ?>
								</p>
							</address>
						</div>
			
					</div>
				</div>
			</section>
			<!-- end Contact section -->
			
			<!-- Service section -->
			<section id="service">
				<div class="container">
					<div class="row">

					
          <!-- Modal -->
		  <div class="modal fade" id="myModal2" role="dialog">
          <div class="modal-dialog">          
            <!-- Modal content-->
            <div class="modal-content">           
              <div class="modal-header">
              <h4 class="modal-title" id="mtitle2"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>               
              </div>
              <div class="modal-body" id="mimage2">                
              </div>
              <div class="modal-footer" id="desc2">
                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
              </div>
            </div>            
          </div>
        </div>
          
        </div>


					
						<div class="sec-title text-center">
							<h2 class="wow animated bounceInLeft">My service</h2>
							<p class="wow animated bounceInRight">Provide Various Service in diffrent domain</p>
						</div>
						<?php 

				          for($j=0;$j<count($service_details);$j++)
				          {
							$name = "'".$service_details[$j]['service_name']."'";
							$image = "'".$path_url.$service_details[$j]['service_image']."'";
							$desc = "'".$service_details[$j]['desc']."'";
				          ?>
						<div class="col-md-3 col-sm-6 col-xs-12 text-center wow animated zoomIn">
							<div class="service-item">
								<div class="">
									 <?php 
						                  echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal2" onclick="servicepopupimage('.$name.','.$image.','.$desc.')"><img src="'.$path_url.$service_details[$j]['service_image'].'" class="img-fluid" style="width:100%;"></a>'; 
						                ?>
								</div>
								<h3><?php echo $service_details[$j]['service_name'];?></h3>
								<p><?php echo $service_details[$j]['desc'];?></p>
							</div>
						</div>
						<?php } ?>
					
						
					</div>
				</div>
			</section>
			<!-- end Service section -->
			
			<!-- Product section -->
			<section id="portfolio">
				<div class="container">
					<div class="row">

					 <!-- Modal -->
					 <div class="modal fade" id="myModal" role="dialog">
						<div class="modal-dialog">          
							<!-- Modal content-->
							<div class="modal-content">           
							<div class="modal-header">
							<h5 class="modal-title" id="mtitle"></h5>
							<button type="button" class="close" data-dismiss="modal">&times;</button>  
							</div>
							<div class="modal-header">
							<h6 >Category Name : </h6><h6 class="modal-title" id="cname"></h6> <br>
							<!-- <h6 >Sub Category : </h6><h6 class="modal-title" id="scname"></h6> <br> -->               
							</div>
							<h4 class="modal-title" id="mtitle"></h4> 
							<div class="modal-body" id="mimage">   
							           
							</div>
							<div class="modal-footer" id="mfooter">
								<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
							</div>
							</div>            
						</div>
						</div>
					
						<div class="sec-title text-center wow animated fadeInDown">
							<h2>My PRODUCTS</h2>
							<p>Latest Products.</p>
						</div>
						

						<ul class="project-wrapper wow animated fadeInUp">
							 <?php
					          if(count($product_details)>0)
					          {
					            for($i=0;$i<count($product_details);$i++)
					              {
									$name = "'".$product_details[$i]['product_name']."'";
									$cname = "'".$product_details[$i]['category_name']."'";
									$scname = "'".$product_details[$i]['sub_category_name']."'";
									$product_image = "'".$path_url.$product_details[$i]['product_image']."'";
									$price = "'".$product_details[$i]['currency'].' '.$product_details[$i]['price']."'";
					                //echo $product_details[$i]['product_image'];
					                ?>
							<li class="portfolio-item">
								 <?php 
			                        echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" onclick="popupimage('.$name.','.$product_image.','.$cname.','.$scname.','.$price.')"><img src="'.$path_url.$product_details[$i]['product_image'].'" class="img-fluid" style="width:100%;"></a>'; 
			                        ?>
								<figcaption class="mask">
									<h3><?php echo $product_details[$i]['product_name'];?></a></h3>
									<p><?php echo $product_details[$i]['price'];?></p>
									<span>Category:<?php echo $product_details[$i]['category_name'];?></span>
								</figcaption>
								<ul class="external">
									<li><a class="fancybox" title="Araund The world" data-fancybox-group="works" href="img/portfolio/item.jpg"><i class="fa fa-search"></i></a></li>
									
								</ul>
							</li>
							<?php } 
						        } else
						        {?>
						        	<li class="portfolio-item">No Products found</li>
							<?php }?>
						</ul>
						
					</div>
				</div>
			</section>
			<!-- end product section -->
			 <div class="modal fade" id="videomodal" role="dialog">
	          <div class="modal-dialog">          
	            <!-- Modal content-->
	            <div class="modal-content">           
	              <div class="modal-header">
	              <h4 class="modal-title" id="mtitle1"></h4>
	                <button type="button" class="close" data-dismiss="modal">&times;</button>               
	              </div>
	              <div class="modal-body" id="videoimage">                
	              </div>
	              <div class="modal-footer" style="display: block;">
	                 <!-- <img src="./assets/img/eye-open.png" id="adview" style="width:60px;cursor: pointer;">
	                <span id="adviewcount"></span>
	                <img src="./assets/img/thumbs-up-circle-blue-512.png" id="adlikes" style="width:22px;cursor: pointer;">
	                <span id="adlikecount"></span> -->
	              </div>
	            </div>            
	          </div>
	        </div>
	        <section id="videosection" class="section-with-bg wow fadeInUp">

      <div class="container">
        <div class="section-header">
          <h2>My videos</h2>
          
        </div>

        <div class="row">
          <?php 

          for($mv=0;$mv<count($myvideo_det);$mv++)
          {
            $name = "";
            $image = $path_url.$myvideo_det[$mv]['preview_image'];
            $video = "'".$path_url.$myvideo_det[$mv]['video_file']."'";
            $id="'".$myvideo_det[$mv]['id']."'"
          ?>
          <div class="col-lg-3 col-md-3">
      
            <div class="hotel">
        <div class="hotel-img">
          <?php 
             
              echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#videomodal" onclick="videopreviewimage('.$video.','.$id.')"><img src="'.$image.'" class="img-fluid"></a>'; 
            // }
            // else{
            // echo '<video width="280" height="200" controls>
            //     <source src="'.$path_url.$ad_details[$k]['uploads'].'" type="video/mp4">
            //     </video>';
            // }
          ?>
          <!-- <img src="http://localhost/ag7dev.git/trunk/api/'.$product_details[$i]['product_image'].' " alt="Hotel 1" class="img-fluid"style="height: 205px;"> -->
        </div>
        <!-- <h3><?php //echo $ad_details[$k]['service_name'];?></h3>-->
        <?php 
        if($myvideo_det[$mv]['description']!=""){
          echo "<p>".$myvideo_det[$mv]['description']."</p>"; 
        }
       
        ?>
        <!--  <div class="image-container"  style="width:52%;">
              <img src="./assets/img/eye-open.png" id="" style="width:60px;cursor: pointer;">
              <span id=""><?php //echo $ad_details[$k]['views']; ?></span>
              <img src="./assets/img/thumbs-up-circle-blue-512.png" id="likeservice1" style="width:22px;cursor: pointer;" onclick="likeAd(<?php //echo $ad_details[$k]['id'];?>)">
              <input type="hidden" value="<?php //echo $ad_details[$k]['id']; ?>" id="adv_id<?php echo $ad_details[$k]['id']; ?>">
              <span id="adlikecount<?php //echo $ad_details[$k]['id'];?>"><?php //echo $ad_details[$k]['likes']; ?></span>
            </div> -->
      </div>

          </div>
        <?php } ?>
      

        </div>
      </div>

    </section>
	
			<!-- Advertisment section -->
			<section id="testimonials" class="parallax">
				<div class="overlay">
					<div class="container">
						<div class="row">

											<!-- Modal -->
						<div class="modal fade" id="myModal1" role="dialog">
							<div class="modal-dialog">          
								<!-- Modal content-->
								<div class="modal-content">           
								<div class="modal-header">
								<h4 class="modal-title" id="mtitle1"></h4>
									<button type="button" class="close" data-dismiss="modal">&times;</button>               
								</div>
								<div class="modal-body" id="mimage1">                
								</div>
								<div class="modal-footer">
									<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
								</div>
								</div>            
							</div>
							</div>
						
							<div class="sec-title text-center wow animated fadeInDown">
								<h2>My Advertisment</h2>
								
							</div>
						
							<ul class="project-wrapper wow animated fadeInUp">
								 <?php 

					          for($k=0;$k<count($ad_details);$k++)
					          {
								$image = "'".$path_url.$ad_details[$k]['uploads']."'";
					          ?>
							<li class="portfolio-item">
								<?php
								 if($ad_details[$k]['ad_type']==1)
				                  { 
				                      echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal1" onclick="popupimage1('.$image.')"><img src="'.$path_url.$ad_details[$k]['uploads'].' " class="img-fluid" style="width:100%;height:210px;"></a>'; 
				                  }
				                  else{
				                    echo '<video width="280" height="200" controls>
				                            <source src="'.$path_url.$ad_details[$k]['uploads'].'" type="video/mp4">
				                          </video>';
				                  }
				                  ?>
								 <figcaption style="color:white;">
									<!--<h3>Wall street</h3>
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting ndustry. </p>-->
									<?php 
										if($ad_details[$k]['desc']!=""){
											echo "<p>".$ad_details[$k]['desc']."</p>"; 
										}
										if($ad_details[$k]['weblink']!=""){
											echo "<p><a style='color:white;' href='".$ad_details[$k]['weblink']."' target='_blank'>Website Link</a></p>"; 
										}
										?>
				
								</figcaption>
								
							</li>
							<?php } ?>
							
						</ul>
						
						
						</div>
					</div>
				</div>
			</section>
			<!-- end Advertisment section -->
			
			
			
			<!-- Social section -->
			<section id="social" class="parallax">
				<div class="overlay">
					<div class="container">
						<div class="row">
						
							<div class="sec-title text-center white wow animated fadeInDown">
								<h2>FOLLOW US</h2>
								<p>Beautifully simple follow buttons to help you get followers on</p>
							</div>
							
							<ul class="social-button">
								<li class="wow animated zoomIn"><a href="#"><i class="fa fa-thumbs-up fa-2x"></i></a></li>
								<li class="wow animated zoomIn" data-wow-delay="0.3s"><a href="#"><i class="fa fa-twitter fa-2x"></i></a></li>
								<li class="wow animated zoomIn" data-wow-delay="0.6s"><a href="#"><i class="fa fa-dribbble fa-2x"></i></a></li>
								
								<li><?php if(isset($contact_details[0]['whatsapp'])){
								echo "Whatsapp :".$contact_details[0]['whatsapp'];
								} ?></li>
								<li><?php if(isset($contact_details[0]['telegram'])){
								echo "Telegram :".$contact_details[0]['telegram'];
								} ?></li>							
							</ul>
							
						</div>
					</div>
				</div>
			</section>
			<!-- end Social section -->
			
			
			
			<section id="google-map">
				<div id="map-canvas" class="wow animated fadeInUp"></div>
			</section>
		
		</main>
		
		<footer id="footer">
			<div class="container">
				<div class="row text-center">
					<div class="footer-content">
						
						
						<div class="footer-social">
							<ul>
								<li class="wow animated zoomIn"><a href="#"><i class="fa fa-thumbs-up fa-3x"></i></a></li>
								<li class="wow animated zoomIn" data-wow-delay="0.3s"><a href="#"><i class="fa fa-twitter fa-3x"></i></a></li>
								<li class="wow animated zoomIn" data-wow-delay="0.6s"><a href="#"><i class="fa fa-skype fa-3x"></i></a></li>
								<li class="wow animated zoomIn" data-wow-delay="0.9s"><a href="#"><i class="fa fa-dribbble fa-3x"></i></a></li>
								<li class="wow animated zoomIn" data-wow-delay="1.2s"><a href="#"><i class="fa fa-youtube fa-3x"></i></a></li>
							</ul>
						</div>
						
						<p> &copy; Copyright <strong>Roodab</strong>. All Rights Reserved</p>
					</div>
				</div>
			</div>
		</footer>
		
		<!-- Essential jQuery Plugins
		================================================== -->
		<!-- Main jQuery -->
        <script src="<?php echo base_url();?>assets/template2/js/jquery-1.11.1.min.js"></script>
		<!-- Twitter Bootstrap -->
        <script src="<?php echo base_url();?>assets/template2/js/bootstrap.min.js"></script>
		<!-- Single Page Nav -->
        <script src="<?php echo base_url();?>assets/template2/js/jquery.singlePageNav.min.js"></script>
		<!-- jquery.fancybox.pack -->
        <script src="<?php echo base_url();?>assets/template2/js/jquery.fancybox.pack.js"></script>
		
		<!-- Owl Carousel -->
        <script src="<?php echo base_url();?>assets/template2/js/owl.carousel.min.js"></script>
        <!-- jquery easing -->
        <script src="<?php echo base_url();?>assets/template2/js/jquery.easing.min.js"></script>
        <!-- Fullscreen slider -->
        <script src="<?php echo base_url();?>assets/template2/js/jquery.slitslider.js"></script>
        <script src="<?php echo base_url();?>assets/template2/js/jquery.ba-cond.min.js"></script>
		<!-- onscroll animation -->
        <script src="<?php echo base_url();?>assets/template2/js/wow.min.js"></script>
		<!-- Custom Functions -->
        <script src="<?php echo base_url();?>assets/template2/js/main.js"></script>
		<script>
  
  function servicepopupimage(name,image,desc){
      
      $('#mtitle2').html(name);
      $('#mimage2').html('<img src="'+image+'" width="400px" height="400px">');
      $('#desc2').html(desc);
     }

	 function popupimage(name,image,cname,scname,price){
      
      $('#mtitle').html(name);
      $('#cname').html(cname);
      $('#scname').html(scname);
      $('#mfooter').html(price);
      $('#mimage').html('<img src="'+image+'" width="100%" height="400px">');
     }

     function popupimage1(image){
      $('#mimage1').html('<img src="'+image+'" width="400px" height="400px">');
     }
      function videopreviewimage(video,id){
        
      $('#videoimage').html('<video width="280" height="200" controls><source src="'+video+'" type="video/mp4"></video><input type="hidden" value="'+id+'" id="adv_id">');
    }
  </script>
    </body>
</html>