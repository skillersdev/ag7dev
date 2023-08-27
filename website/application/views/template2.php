<?php
//echo "<pre>";print_r($product_details);die;
$this->load->view('index.html');
$path_url = $this->config->item('path_url');
$login_url = $this->config->item('login_url');
$image_path = $this->config->item('base_path');
$logo_img_path = $this->config->item('logo_img_path');
$sectionItem_path=base_url().$website;
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
        <title><?php echo $website; ?></title>		
		<!-- Meta Description -->
        <meta name="description" content="<?php echo $website; ?>">
        <meta name="keywords" content="<?php echo $website; ?>">
        <meta name="author" content="<?php echo $website; ?>">
		
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

		<style>
			.mySlides {display: none;}
    		.pimage0{display:block;}
			#websiteLogo{
				width: auto;
				height: 35px;
				background: #f6f7fd;
				padding-top: 3px;
				padding-bottom: 3px;
				padding-right: 50px;
				/* border-radius: 40px 0 40px 0; */
				font-family: fantasy;
				color: #060c22;
				padding-left: 50px;
			}

			#websiteLogoImg{
				width: auto;
				height: auto;
				background: #f6f7fd;
				padding-top: 3px;
				padding-bottom: 3px;
				padding-right: 50px;
				/* border-radius: 40px 0 40px 0; */
				font-family: fantasy;
				color: #060c22;
				padding-left: 50px;
			}

			
			.slide-content {
			position: absolute;
			top: 50%; /* Position the content 50% from the top of the slide */
			left: 50%; /* Position the content 50% from the left of the slide */
			transform: translate(-50%, -50%); /* Center the content within the slide */
			text-align: center; /* Center the text horizontally */
			color: #e5e5e5; /* Text color */
			width: 100%; /* Make the content span the full width of the slide */
			z-index: 2; /* Place the content above the image */
			}

			.slide-content h1 {
			/* font-size: 24px;
			margin-bottom: 10px; */
			
			margin-top: 10px;
			color: #e5e5e5;
			font-size: 40px;
			font-weight: 600;
			line-height: 50px;
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			text-align: center;
			width: 40%;
			/* background: #1e243638; */
			background:#1e2436e8;
			padding: 10px;
			transition: opacity 0.5s ease;
			/* border-radius: 10px 80px 0px 87px;	 */
			}

			@media (max-width:768px)
			{
			.slide-content h1 {
				font-size: 30px; 
			}
			.sliderdesc{
				font-size: 15px;
			}
			#showpopupimg{
				max-width:300px !important;
			}
			}

			.sliderdesc{
			margin-top:10px;
			text-wrap:wrap;
			font-size: 20px;
			color: #e5e5e5;
			font-weight: 100;
			margin-bottom: 20px;

			}
			
			.slide-content p.sliderdesc {
			font-size: 18px;
			/* margin: 0; */
			}

		</style>

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
						<a href="#body">
							<?php if($logo_img=="" && $logo_name=="" ){ ?>
								<div id="websiteLogo"> <?php echo $website; ?> </div>
							<?php }else if($logo_img !=""){ ?>
								<div id="websiteLogoImg"><img src="<?php echo $logo_img_path;?><?php echo $logo_img; ?>" alt="<?php echo $website; ?>" title="<?php echo $website; ?>" style="max-width:125px; max-height:40px;"/></div>
							<?php }else{ ?>
								<div id="websiteLogo"> <?php echo $logo_name; ?> </div>
								<?php } ?>
						</a>	
							
					</h1>
					<!-- /logo -->
                </div>

				<!-- main nav -->
                <nav class="collapse navbar-collapse navbar-right" role="navigation">
                    <ul id="nav" class="nav navbar-nav">
						<li><a href="#body">Home</a></li>
						<?php 

						foreach ($all_details as $key => $value) 
						{
							if($value[0]['show_menu']==1){
						?>
							<li class="">
								<a href="#<?php echo $key;?>">
									<?php echo $key;?>
								</a>
							</li>
						<?php 
							}
						}

						if(count($service_details)>0)
						{
						?>
							<li><a href="#service">Service</a></li>
						<?php 
						} 
						
						if(count($product_details)>0)
						{
							
						?>
							<li><a href="#portfolio">Products </a></li>
						<?php 
						}
						if(count($myvideo_det)>0)
						{  ?>  
							<li><a href="#videosection">Videos</a></li>
						<?php
						}
						if(count($contact_details)>0){ ?>
							<li><a href="#contact">Contact</a></li>
						<?php 
						} 
						?>

                        <!-- <li><a href="#testimonials">My Ads</a></li>  -->
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
									<img src="<?php echo $image_path.$slider_image[$j]['slider_image']; ?>" style="width:100%; height: 591px;max-height: 591px;" />
									<?php if($slider_image[$j]['slider_title']){ ?>
										<div class="slide-content">
											<h1>
												<?php echo $slider_image[$j]['slider_title']; ?>
												<?php if( $slider_image[$j]['slider_desc']){ ?>
													<p class="sliderdesc"><?php echo $slider_image[$j]['slider_desc']; ?></p>
												<?php } ?>
												<?php if($slider_image[$j]['slider_link']){ ?>
													<a target="_blank" href="<?php echo $slider_image[$j]['slider_link']; ?>" style="margin-top:10px">	<button type="button" class="btn btn-default">View More</button></a>
												<?php } ?>   
											</h1>
										</div>
									<?php } ?>			
								</div>
							</div>
						<?php 
						} 
					}
					else{
					?>

					<div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
						<div class="bg-img bg-img-1">
							<img src="<?php echo base_url();?>assets/template2/img/slider/39632.jpg" style="width:100%; height: 591px;max-height: 591px;" />
						</div>
					</div>
					
					<div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
						<div class="bg-img bg-img-2">
							<img src="<?php echo base_url();?>assets/template2/img/slider/sample.jpg"  style="width:100%; height: 591px;max-height: 591px;" />
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
				
			<section id="about" >
				<div class="container">
					<div class="row">
						

						<div class="col-md-12 col-md-offset-1 wow animated fadeInRight">
							<div class="welcome-block">
								<h3>Welcome To <?php echo $website;?></h3>								
						     	 <div class="message-body">
								  	<a  href="javascript:void(0);" data-toggle="modal" data-target="#imagemyModal">
									 	<?php 

								           if(isset($contact_details[0]['website_image'])&&($contact_details[0]['website_image']!=''))
									         {
									            $image = $contact_details[0]['website_image'];
									         }
									         else{
									          $image = ($profile_image!='')?$profile_image:'user_profile/default.png';
									         }
								          echo '<img src="'.$path_url.$image.'" class="pull-left" />';
								         ?>
									</a>
										<?php if($websitename !=''){ ?>
												<p>
												<button type="button" class="btn btn-primary" onclick="flvwebsite('<?php echo $websitename; ?>','follow');">
													Follows <span class="badge badge-light" id="totalfollow"><?php echo $total_follows;?></span>
												</button>
												<button type="button" class="btn btn-primary" onclick="flvwebsite('<?php echo $websitename; ?>','like');">
													Like <span class="badge badge-light" id="totallike"><?php echo $total_likes;?></span>
												</button>
												<button type="button" class="btn btn-primary" >
													View <span class="badge badge-light" id="totalview"><?php echo $total_views;?></span>
													<input type="hidden" id="viewweb" name="" value="<?php echo $website; ?>">
												</button>
												</p>
											<?php } ?>
										 	
								          <?php 
								              $about_us=(isset($contact_details[0]['about_website']) && ($contact_details[0]['about_website']!=''))?$contact_details[0]['about_website']:'';

								            ?>
						       		<p style="margin-top: 15px;"><?php echo $about_us; ?> </p>
						     	 </div>
						       	
						    </div>
						</div>
					</div>
				</div>
			</section>
			<!-- end about section -->

			<!--==========================
			Dynamic Section
			============================-->
			<?php
			if(count($all_details)>0){}
			foreach ($all_details as $key => $value) 
			{
				?>
				<section id="<?php echo $key;?>" class="portfolio">
					<div class="container">
					<div class="row">
							<div class="sec-title text-center">
								<h2 class="wow animated bounceInLeft"><?php echo $key;?></h2>	
							</div>

							<!-- Modal -->
							<div class="modal fade" id="myModal_section" role="dialog">
								<div class="modal-dialog  modal-lg">   
									<div class="modal-content">           
										<div class="modal-header">
											<h4 class="modal-title" id="mtitle2_section"></h4>
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
										<div class="modal-body" id="mimage2_section">                
										</div>
										<div class="modal-footer tesdt" id="desc2_section" style="display: block;">
											<div class="image-container"  style="width:52%;">
												<img src="./assets/img/eye-open.png" id="viewservice" style="width:60px;cursor: pointer;">
												<span id="viewservicecount_section"></span>
												<img src="./assets/img/thumbs-up-circle-blue-512.png" id="likeservice" style="width:22px;cursor: pointer;">
												<span id="likeservicecount"></span>
											</div>
										</div>
									</div>            
								</div>
							</div>
								

							<ul class="project-wrapper wow animated fadeInUp">
								<?php
								foreach ($all_details[$key] as $child_key => $child_value) {

									$name = "'".$child_value['section_name']."'";
									$image = "'".$child_value['preview_file']."'";
									$desc = "'".$child_value['description']."'";
									$service_id = "'".$child_value['section_item_id']."'";
									$is_default_img = $child_value['is_default_img'];
									
									$media_type =$child_value['media_type'];
									$web_url = "'".$child_value['website_link']."'";
									$sectionItem_url="'".$sectionItem_path."/".$key."/".$child_value['section_item_id']."'"; //
									// echo $web_url;die;
									if(strpos($child_value['file_name'], ",") !== false) {               
										$mulp_img = explode (",", $child_value['file_name']);
									  }else{										
										$mulp_img = explode (" ", $child_value['file_name']);
									  }


									if($child_value['media_type']==1) {
										$path = $path_url.$mulp_img[$is_default_img];
										$file_name_path = "'".$path_url.$mulp_img[$is_default_img]."'";
										$path_src = "'".$path_url.$mulp_img[$is_default_img]."'";
										$weblink = "'".$mulp_img[$is_default_img]."'";
									} else{
										$path = $path_url.$child_value['preview_file'];
										$file_name_path = "'".$path_url.$mulp_img[$is_default_img]."'";
										$path_src = "'".$path_url.$child_value['preview_file']."'";
										$weblink = "'".$mulp_img[$is_default_img]."'";
									}
								?>	
								<?php 
									if($child_value['section_view'] ==1) { 
								?>
									<div class="col-sm-3 col-md-3 col-lg-3">	
										<li class="portfolio-item" style="height: 210px;width:100%;">
											<?php 
												echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_section" onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.','.$web_url.','.$sectionItem_url.')"><img src="'.$path.'" class="img-responsive" style="height: 210px;width: 100%;">'; 
											?>
											
											<figcaption class="mask">
												<h3><?php echo $child_value['title'];?></h3>
												<p><?php echo substr_replace($child_value['description'], "...", 60);?></p>
											</figcaption>
											<ul class="external">
												<li style="color:white;margin: 10px;">
													<img src="./assets/img/eye-open1.png" id="" style="width:20px;cursor: pointer;">
													<span id=""><?php echo $child_value['views']; ?></span>
													<img src="./assets/img/thumbs-up-circle-blue-512.png" id="likeservice1" style="width:20px;cursor: pointer;" onclick="likeServicesection(<?php echo $name;?>,<?php echo $child_value['section_item_id'];?>)">
													<input type="hidden" value="<?php echo $child_value['section_item_id']; ?>" id="service_id<?php echo $child_value['section_item_id']; ?>">
													<span id="likeservicecount<?php echo $child_value['section_item_id'];?>"><?php echo $child_value['likes']; ?></span>
												</li>
												
											</ul>
											</a>
										</li>
									</div>
								<?php } ?>

								<?php 
									if($child_value['section_view'] ==2) { 
								?>
									<div class="col-sm-6 col-md-6 col-lg-6">	
										<li class="portfolio-item" style="height: 210px;width:100%;">
											<?php 
												echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_section" onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.','.$web_url.','.$sectionItem_url.')"><img src="'.$path.'" class="img-responsive" style="height: 210px;width: 100%;">'; 
											?>
											
											<figcaption class="mask">
												<h3><?php echo $child_value['title'];?></h3>
												<p><?php echo substr_replace($child_value['description'], "...", 60);?></p>
											</figcaption>
											<ul class="external">
												<li style="color:white;margin: 10px;">
													<img src="./assets/img/eye-open1.png" id="" style="width:20px;cursor: pointer;">
													<span id=""><?php echo $child_value['views']; ?></span>
													<img src="./assets/img/thumbs-up-circle-blue-512.png" id="likeservice1" style="width:20px;cursor: pointer;" onclick="likeServicesection(<?php echo $name;?>,<?php echo $child_value['section_item_id'];?>)">
													<input type="hidden" value="<?php echo $child_value['section_item_id']; ?>" id="service_id<?php echo $child_value['section_item_id']; ?>">
													<span id="likeservicecount<?php echo $child_value['section_item_id'];?>"><?php echo $child_value['likes']; ?></span>
												</li>
												
											</ul>
											</a>
										</li>
									</div>
								<?php } ?>		
								

								<?php 
									if($child_value['section_view'] ==3 ) { 
								?>
									<div class="col-sm-12 col-md-12 col-lg-12 mb-5">
										<div class="col-sm-12 col-md-6 col-lg-6 mb-5">
											<div class="portfolio-item" style="height: 210px;width:100%;">
												<?php 
													echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_section" onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.','.$web_url.','.$sectionItem_url.')"><img src="'.$path.'" class="img-responsive" style="height: 210px;width: 100%;">'; 
												?>
												
												<ul class="external">
													<li style="color:white;margin: 10px;">
														<img src="./assets/img/eye-open1.png" id="" style="width:20px;cursor: pointer;">
														<span id=""><?php echo $child_value['views']; ?></span>
														<img src="./assets/img/thumbs-up-circle-blue-512.png" id="likeservice1" style="width:20px;cursor: pointer;" onclick="likeServicesection(<?php echo $name;?>,<?php echo $child_value['section_item_id'];?>)">
														<input type="hidden" value="<?php echo $child_value['section_item_id']; ?>" id="service_id<?php echo $child_value['section_item_id']; ?>">
														<span id="likeservicecount<?php echo $child_value['section_item_id'];?>"><?php echo $child_value['likes']; ?></span>
													</li>
													
												</ul>
												</a>
											</div>
										</div>	

										<div class="col-sm-12 col-md-6 col-lg-6 mb-5">
											<h3><?php echo $child_value['title'];?></h3>
											<p><?php echo substr_replace($child_value['description'], "...", 60);?></p>
										</div>
										
									</div>
								<?php } ?>	

								<?php 
									if($child_value['section_view'] ==4 ) { 
								?>
									<div class="col-sm-12 col-md-12 col-lg-12 mb-5">
										<div class="col-sm-12 col-md-6 col-lg-6 mb-5">
											<h3><?php echo $child_value['title'];?></h3>
											<p><?php echo substr_replace($child_value['description'], "...", 60);?></p>
										</div>
										<div class="col-sm-12 col-md-6 col-lg-6 mb-5">
											<div class="portfolio-item" style="height: 210px;width:100%;">
												<?php 
													echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_section" onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.','.$web_url.','.$sectionItem_url.')"><img src="'.$path.'" class="img-responsive" style="height: 210px;width: 100%;">'; 
												?>
												
												
												<ul class="external">
													<li style="color:white;margin: 10px;">
														<img src="./assets/img/eye-open1.png" id="" style="width:20px;cursor: pointer;">
														<span id=""><?php echo $child_value['views']; ?></span>
														<img src="./assets/img/thumbs-up-circle-blue-512.png" id="likeservice1" style="width:20px;cursor: pointer;" onclick="likeServicesection(<?php echo $name;?>,<?php echo $child_value['section_item_id'];?>)">
														<input type="hidden" value="<?php echo $child_value['section_item_id']; ?>" id="service_id<?php echo $child_value['section_item_id']; ?>">
														<span id="likeservicecount<?php echo $child_value['section_item_id'];?>"><?php echo $child_value['likes']; ?></span>
													</li>
													
												</ul>
												</a>
											</div>
										</div>	
									</div>
								<?php } ?>	



								<?php } ?>
							</ul>	
						</div>
					</div>
				</section>
				<?php 
			} 
			?>

			<!--==========================
			Dynamic Section
			============================-->

		


	

			
			<!-- Service section -->
			<?php if(count($service_details)>0){?>  
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
			<?php } ?>
			<!-- end Service section -->
			
			<!-- Product section -->
			<?php  if(count($product_details)>0){ ?>
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
							<h2>PRODUCTS</h2>
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
									$total_likes= "'".$product_details[$i]['total_likes']."'";
									$total_views =  "'".$product_details[$i]['total_views']."'";
									$prod_desc = "'".$product_details[$i]['long_desc']."'";
									$prod_short_desc = "'".$product_details[$i]['short_desc']."'";
					                //echo $product_details[$i]['product_image'];
					                ?>
							<li class="portfolio-item" style="height: 210px;">
								 <?php 
			                        echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" onclick="popupimage('.$prod_desc.','.$prod_short_desc.','.$name.','.$product_image.',
									'.$cname.',
									'.$scname.',
									'.$price.',
									'.$total_likes.',
									'.$total_views.',
									'.$product_details[$i]['id'].')"><img src="'.$path_url.$product_details[$i]['product_image'].'" class="img-fluid" style="width:100%;"></a>'; 
			                        ?>
								<figcaption class="mask">
									<h3><?php echo $product_details[$i]['product_name'];?></a></h3>
									<p><?php echo $product_details[$i]['price'];?></p>
									<span>Category:<?php echo $product_details[$i]['category_name'];?></span>
								</figcaption>
								<ul class="external">
									<li>
									<div>
										<img src="./assets/img/eye-open1.png" id="viewT" style="width:20px;cursor: pointer;">
										<span id="viewcount" style="color: white;"><?php echo $product_details[$i]['total_views'];?></span>
										<img src="./assets/img/thumbs-up-circle-blue-512.png" id="likesT1" style="width:20px;cursor: pointer;" onclick="likeProduct(<?php echo $product_details[$i]['id'];?>)">
										<input type="hidden" value="<?php echo $product_details[$i]['id'];?>" id="product_id<?php echo $product_details[$i]['id'];?>">
										<span id="likecount<?php echo $product_details[$i]['id'];?>" style="color: white;"><?php echo $product_details[$i]['total_likes'];?></span>
									</div>
									</li>  
									
								</ul>
							</li>
							<?php } }
						       ?>
						    
						</ul>
						
					</div>
				</div>
			</section>
			<?php } ?>
			<!-- end product section -->

			<!-- Album Section -->
			<?php if(count($album_details)>0){ ?>
			<section id="album" class="wow fadeInUp">
				<div class="container">

					<div class="sec-title text-center wow animated fadeInDown">
						<h2>Album</h2>
					</div>
			
					
					<ul class="project-wrapper wow animated fadeInUp">
						<?php 
						for($m=0;$m<count($album_details);$m++)
						{
							$name = "";
							$image = "'".$path_url.$album_details[$m]['album_image']."'";
							?>
							<li class="portfolio-item" style="height: 210px;">    
								<a href="<?php echo base_url('album/'.$album_details[$m]['album_code']); ?>" >
									<img src="<?php echo $path_url.$album_details[$m]['album_image']?> " class="img-fluid">
								</a>
								<figcaption class="mask">
									<?php 
										if($album_details[$m]['about']!=""){
											echo "<p>".$album_details[$m]['about']."</p>"; 
										}
									?>
								</figcaption>
									
								</div>
								</li>
							<?php 
						} 
						?>
					</ul>
				</div>
			</section>	
			<?php } ?>					





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
			<?php if(count($myvideo_det)>0){?> 
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
	<?php } ?>
	
			<!-- Advertisment section -->
			<?php if(count($ad_details)>0) {?> 
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
			<?php } ?>
			<!-- end Advertisment section -->
			
				
			<!-- Contact section -->
			<section id="contact" >
				<div class="container">
					<div class="row">
						 <?php 
					     	 if(count($contact_details)>0)
					      { ?>
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
													
								<p><i class="fa fa-home"></i><?php echo $website;?>
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
									</span></p>
								<p>
									<?php 
									if(isset($contact_details[0]['phonenumber'])&&$contact_details[0]['phonenumber']!='')
									{
										echo '<i class="fa fa-phone"></i>'."Phone :".$contact_details[0]['phonenumber'];
									} ?>
								<?php if(isset($contact_details[0]['homenumber'])){
								echo '<i class="fa fa-phone"></i>'."Home :".$contact_details[0]['homenumber'];
								} ?>
								<?php if(isset($contact_details[0]['officenumber'])){
								echo '<i class="fa fa-phone"></i>'."Office :".$contact_details[0]['officenumber'];
								} ?>
								<?php if(isset($contact_details[0]['faxnumber'])){
								echo '<i class="fa fa-phone"></i>'."Fax :".$contact_details[0]['faxnumber'];
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
						<?php } ?>
					</div>
				</div>
			</section>
			<!-- end Contact section -->
			
			
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
						
						<p> &copy; Copyright <strong>3ABC7</strong>. All Rights Reserved</p>
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
      $('#mimage2').html('<img src="'+image+'" id="showpopupimg" width="400px" height="400px">');
      $('#desc2').html(desc);
     }

	//  function popupimage(name,image,cname,scname,price){
      
    //   $('#mtitle').html(name);
    //   $('#cname').html(cname);
    //   $('#scname').html(scname);
    //   $('#mfooter').html(price);
    //   $('#mimage').html('<img src="'+image+'" width="100%" height="400px">');
    //  }

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

     function popupimage1(image){
      $('#mimage1').html('<img src="'+image+'" width="400px" height="400px">');
     }
      function videopreviewimage(video,id){
        
      $('#videoimage').html('<video width="280" height="200" controls><source src="'+video+'" type="video/mp4"></video><input type="hidden" value="'+id+'" id="adv_id">');
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

	function servicepopupimage_section(name,image,desc,update_id,weblink,type,src_file,web_url,viewUrl)
  	{
    	$('#mtitle2_section').html(name);
      
		if(type==2)
		{
			$('#mimage2_section').html('<video width="400" controls><source src="'+image+'" type="video/mp4"></video>'); 
		}
		else if(type==1 || type==3 || type==4){
			$('#mimage2_section').html('<img src="'+src_file+'"  id="showpopupimg" style="display: block; margin-left: auto; margin-right: auto;max-width:80%;">');
		}else{
			$('#mimage2_section').html('<audio width="400" controls><source src="'+image+'" type="audio/mpeg"></audio>');
		}
      
		var Websiteurl="https://"+web_url;
		$('#desc2_section').html('<div class="description">'+desc+'</div><input type="hidden" value="'+update_id+'" id="service_id"><br><div><a href="'+image+'" target="_blank">Click here to view</a></div><br><div><a href="'+Websiteurl+'" target="_blank"><b>Website Link</b></a></div><br><div><a  href='+viewUrl+'#enquirynow'+' tabindex="-1"><button type="button" class="btn btn-primary" tabindex="-1">Enquiry</button></a></div>');

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

	
  </script>
    </body>
</html>