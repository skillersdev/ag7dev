<?php 
$login_url = $this->config->item('login_url');
$image_path = $this->config->item('base_path');
$logo_img_path = $this->config->item('logo_img_path');
$this->load->view('index.html');
$sectionItem_path=base_url().$website;
?>
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
        <title><?php echo $website; ?></title>		
		<!-- Meta Description -->
        <meta name="description" content="<?php echo $website; ?>">
        <meta name="keywords" content="<?php echo $website; ?>">
        <meta name="author" content="<?php echo $website; ?>">
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

		<style>
			.mySlides {display: none;}
    		.pimage0{display:block;}
			#websiteLogo{
				width: auto;
				height: 35px;
				background: #f6f7fd;
				padding-top: 7px;
				padding-bottom: 3px;
				padding-right: 50px;
				/* border-radius: 40px 0 40px 0; */
				font-family: fantasy;
				color: #060c22;
				padding-left: 50px;
				margin-top:10px;
			}

			#websiteLogoImg{
				width: auto;
				height: auto;
				background: #f6f7fd;
				/* padding-top: 3px;
				padding-bottom: 3px;
				padding-right: 50px; */
				/* border-radius: 40px 0 40px 0; */
				font-family: fantasy;
				color: #060c22;
				/* padding-left: 50px; */
				margin-top:10px;
				margin-left:10px;
			}

			@media (max-width:768px)
			{
				#showpopupimg{
					max-width:300px !important;
				}
			}

		</style>

    </head>
	
    <body id="body">
		<?php $path_url = $this->config->item('path_url'); ?>
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
						<!-- <h1 id="logo">
							<img src="<?php echo base_url();?>assets/template3/img/logo.png" alt="<?php echo $website; ?>" style="width: 123px;">
						</h1> -->

						<?php if($logo_img=="" && $logo_name=="" ){ ?>
							<div id="websiteLogo"> <?php echo $website; ?> </div>
						<?php }else if($logo_img !=""){ ?>
							<div id="websiteLogoImg">
							<h1 id="logo" style="margin: 9px;">
								<img src="<?php echo $logo_img_path;?><?php echo $logo_img; ?>" alt="<?php echo $website; ?>" title="<?php echo $website; ?>" style="max-width:125px; max-height:40px;"/>
							</h1>
							</div>
						<?php }else{ ?>
								<div id="websiteLogo"> <?php echo $logo_name; ?> </div>
							<?php } ?>

					</a>
					<!-- /logo -->
                </div>

				<!-- main nav -->
                <nav class="collapse navbar-collapse navbar-right" role="navigation">
                    <ul id="nav" class="nav navbar-nav">
						<li class="current"><a href="#body">Home</a></li>
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
  						 ?>
						<?php   if(count($service_details)>0){ ?>	
                        	<li><a href="#services">Services</a></li>
						<?php } ?>
						<?php  if(count($product_details)>0){ ?>	
                        	<li><a href="#products">Products</a></li>
						<?php } ?>

                        <!-- <li><a href="#ads">My Ads</a></li> -->
						<?php   if(count($myvideo_det)>0){ ?>
						    <li><a href="#videosection">Videos</a></li> 
						<?php } if(count($contact_details)>0){ ?>
							<li><a href="#contact">Contact</a></li>
						<?php }?>	
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
		
		
		
        <!--
        Home Slider
        ==================================== -->

	
		<section id="slider" style="max-height:739px;">
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			
				<!-- Indicators bullet -->
				<ol class="carousel-indicators">
					<?php 
						if(count($slider_image)>0){
							for($j=0;$j<count($slider_image);$j++)
							{ ?>
								<li data-target="#carousel-example-generic" data-slide-to="<?php echo $j; ?>" class="active"></li>
					<?php   } 
						}else{?>	
							<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
							<li data-target="#carousel-example-generic" data-slide-to="1"></li>
						<?php } ?>	
						</ol>
				<!-- End Indicators bullet -->				
				
				<!-- Wrapper for slides -->
				<div class="carousel-inner" role="listbox" style="max-height:739px;">
					<?php 
					if(count($slider_image)>0)
                	{
                    	for($j=0;$j<count($slider_image);$j++)
                    	{
                    		?>
					<!-- single slide -->
					<div class="item <?php if($j==0){echo 'active'; }?>" style="background-image: url(<?php echo $image_path.$slider_image[$j]['slider_image'];?>); max-height:739px;">
					<?php if($slider_image[$j]['slider_title']){ ?>	
						<div class="carousel-caption">
							<h2 data-wow-duration="400ms" data-wow-delay="500ms" class="wow bounceInDown animated"><?php echo $slider_image[$j]['slider_title']; ?></h2>
							<?php if( $slider_image[$j]['slider_desc']){ ?>
								<h3 data-wow-duration="500ms" class="wow slideInLeft animated"><span class="color">
								<?php echo $slider_image[$j]['slider_desc']; ?>
								</span> </h3>
							<?php } ?>	
							<?php if($slider_image[$j]['slider_link']){ ?>
								<p data-wow-duration="600ms" class="wow slideInRight animated">
									<a target="_blank" href="<?php echo $slider_image[$j]['slider_link']; ?>" style="margin-top:10px">	<button type="button" class="btn btn-default">View More</button></a>
								</p>
							<?php } ?>	
						</div>
					<?php } ?>	
					</div>
					<?php 
						}	
					} else{?>
						<div class="item active" style="background-image: url(<?php echo base_url();?>assets/template3/img/banner.jpg);">
						</div>
						<!-- single slide -->
						<div class="item" style="background-image: url(<?php echo base_url();?>assets/template3/img/banner.jpg);">
						</div>
					<!-- end single slide -->
					<?php } ?>
					<!-- end single slide -->
					
					
					
				</div>
				<!-- End Wrapper for slides -->
				
			</div>
		</section>
		
        <!--
        End Home SliderEnd
        ==================================== -->

		
        <!--
        About Section
        ==================================== -->
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
		<?php if(isset($contact_details[0]['website_image'])){ ?>
			<section id="services" class="features">
				<div class="container">
					<div class="row">
					
						<div class="sec-title text-center mb50 wow bounceInDown animated" data-wow-duration="500ms">
							<h2>About Us</h2>
							<div class="devider"><i class="fa fa-heart-o fa-lg"></i></div>
						</div>

						<!-- service item -->
						<div class="col-md-4 col-sm-12 wow fadeInLeft" data-wow-duration="500ms" style="display: flex; justify-content: center;">
						<a  href="javascript:void(0);"  data-toggle="modal" data-target="#imagemyModal">
							<?php 
								if(isset($contact_details[0]['website_image']))
								{
									$image = $contact_details[0]['website_image'];
									echo '<img align="left" style="width:165px;max-height:200px;margin-bottom: 10px;"src="'.$path_url.$image.'"/>';
								}
							?>
						</a>
						</div>
						<!-- end service item -->
						
						<!-- service item -->
						<div class="col-md-8 col-sm-12 wow fadeInUp" data-wow-duration="500ms" data-wow-delay="500ms">
							<div class="service-item">
														
								<div class="service-desc">
									<h3>
									<?php if($websitename !=''){ ?>
										<p>
										<button type="button" class="btn btn-success" onclick="flvwebsite('<?php echo $websitename; ?>','follow');">
											Follows <span class="badge badge-light" id="totalfollow"><?php echo $total_follows;?></span>
										</button>
										<button type="button" class="btn btn-info" onclick="flvwebsite('<?php echo $websitename; ?>','like');">
											Like <span class="badge badge-light" id="totallike"><?php echo $total_likes;?></span>
										</button>
										<button type="button" class="btn btn-primary" >
											View <span class="badge badge-light" id="totalview"><?php echo $total_views;?></span>
											<input type="hidden" id="viewweb" name="" value="<?php echo $website; ?>">
										</button>
										</p>
									<?php } ?>

									</h3>
									<?php 
								              $about_us=(isset($contact_details[0]['about_website']) && ($contact_details[0]['about_website']!=''))?$contact_details[0]['about_website']:'';

								            ?>
						       		<p style="margin-top: 15px;"><?php echo $about_us; ?> </p>
									
								</div>
							</div>
						</div>
						<!-- end service item -->
						
						
							
					</div>
				</div>
			</section>
		<?php } ?>
        <!--
        End Services
        ==================================== -->

			<!--==========================
			Dynamic Section
			============================-->
			<?php
			if(count($all_details)>0){}
			foreach ($all_details as $key => $value) 
			{
				?>
				<section id="<?php echo $key;?>" class="works clearfix">
					<div class="container">
						<div class="row">
							<div class="sec-title text-center">
								<h2><?php echo $key;?></h2>
								<div class="devider"><i class="fa fa-heart-o fa-lg"></i></div>

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
									
							</div>	
							<div class="sec-sub-title text-center">
								<!-- <p>various sections</p> -->
							</div>
									
						
					
							<div class="project-wrapper">

								<?php
									foreach ($all_details[$key] as $child_key => $child_value) {

										$name = "'".$child_value['section_name']."'";
										$image = "'".$child_value['preview_file']."'";
										$desc = "'".$child_value['description']."'";
										$service_id = "'".$child_value['section_item_id']."'";
										$is_default_img = $child_value['is_default_img'];
										$media_type =$child_value['media_type'];
										$web_url = "'".$child_value['website_link']."'";
										// echo $web_url;die;
										if(strpos($child_value['file_name'], ",") !== false) {               
											$mulp_img = explode (",", $child_value['file_name']);
										}else{										
											$mulp_img = explode (" ", $child_value['file_name']);
										}
	
										$sectionItem_url=$sectionItem_path."/".$key."/".$child_value['section_item_id']; //
										$pop_url="'".$sectionItem_path."/".$key."/".$child_value['section_item_id']."'"; //

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
									<div class="col-md-3">		
										<figure class="mix work-item branding" style="width:100%;">
										<?php 
												echo '<a href="javascript:void(0);" onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.','.$web_url.','.$pop_url.')"><img src="'.$path.'" style="height: 253px;" class="img-responsive"><i class="fa fa-eye fa-lg"></i></a>'; 
											?>
											<figcaption class="overlay">
												<a class="fancybox"  href="javascript:void(0)" data-toggle="modal" data-target="#myModal_section"  <?php echo 'onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.','.$web_url.','.$pop_url.')"' ?> ><i class="fa fa-eye fa-lg"></i></a>
												<h4><?php echo $child_value['title'];?></h4>
												<p><?php echo substr_replace($child_value['description'], "...", 60);?></p>
												<p>
													<img src="./assets/img/eye-open1.png" id="" style="width:24px;cursor: pointer;">
													<span id=""><?php echo $child_value['views']; ?></span>
													<img src="./assets/img/thumbs-up-circle-blue-512.png" id="likeservice1" style="width:22px;cursor: pointer;" onclick="likeServicesection(<?php echo $name;?>,<?php echo $child_value['section_item_id'];?>)">
													<input type="hidden" value="<?php echo $child_value['section_item_id']; ?>" id="service_id<?php echo $child_value['section_item_id']; ?>">
													<span id="likeservicecount<?php echo $child_value['section_item_id'];?>"><?php echo $child_value['likes']; ?></span>

												</p>
											</figcaption>										
										</figure>
									</div>
									<?php } ?>
									
									<?php 
										if($child_value['section_view'] ==2) { 
									?>
									<div class="col-md-6 float-left">		
										<figure class="mix work-item branding" style="width:100%;left: 0% !important;">
										<?php 
												echo '<a href="javascript:void(0);" onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.','.$web_url.','.$pop_url.')"><img src="'.$path.'" style="width:100%;height: 253px;" class="img-responsive"><i class="fa fa-eye fa-lg"></i></a>'; 
											?>
											<figcaption class="overlay">
												<a class="fancybox"  href="javascript:void(0)" data-toggle="modal" data-target="#myModal_section"  <?php echo 'onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.','.$web_url.','.$pop_url.')"' ?> ><i class="fa fa-eye fa-lg"></i></a>
												
											</figcaption>										
										</figure>
										<div class="col-md-6 float-left" style="line-height: 35px;margin-top: 12px;">
											<h4><?php echo $child_value['title'];?></h4>
											<p style="line-height: 25px;margin-top:10px;"><?php echo substr_replace($child_value['description'], "...", 60);?></p>
											<p>
												<img src="./assets/img/eye-open1.png" id="" style="width:24px;cursor: pointer;">
												<span id=""><?php echo $child_value['views']; ?></span>
												<img src="./assets/img/thumbs-up-circle-blue-512.png" id="likeservice1" style="width:22px;cursor: pointer;" onclick="likeServicesection(<?php echo $name;?>,<?php echo $child_value['section_item_id'];?>)">
												<input type="hidden" value="<?php echo $child_value['section_item_id']; ?>" id="service_id<?php echo $child_value['section_item_id']; ?>">
												<span id="likeservicecount<?php echo $child_value['section_item_id'];?>"><?php echo $child_value['likes']; ?></span>
											</p>
										</div>
									</div>
									<?php } ?>
									
									<?php 
										if($child_value['section_view'] ==4) { 
									?>
									<div class="col-md-12 float-left">
										<div class="col-md-6" style="text-align: center;">
											<h4 style="line-height: 35px;text-align: center;margin-bottom: 10px;margin-top: 15px;"><?php echo $child_value['title'];?></h4>
											<p style="line-height: 25px;"><?php echo substr_replace($child_value['description'], "...", 60);?></p>
											<p style="margin-bottom:25px;margin-top:10px;">
												<img src="./assets/img/eye-open1.png" id="" style="width:24px;cursor: pointer;">
												<span id=""><?php echo $child_value['views']; ?></span>
												<img src="./assets/img/thumbs-up-circle-blue-512.png" id="likeservice1" style="width:22px;cursor: pointer;" onclick="likeServicesection(<?php echo $name;?>,<?php echo $child_value['section_item_id'];?>)">
												<input type="hidden" value="<?php echo $child_value['section_item_id']; ?>" id="service_id<?php echo $child_value['section_item_id']; ?>">
												<span id="likeservicecount<?php echo $child_value['section_item_id'];?>"><?php echo $child_value['likes']; ?></span>

											</p>
										</div>	
										<div class="col-md-6">
											<figure class="mix work-item branding" style="width:100%;">
											<?php 
													echo '<a href="javascript:void(0);" onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.','.$web_url.','.$pop_url.')"><img src="'.$path.'" style="height: 253px;width:100%;" class="img-responsive"><i class="fa fa-eye fa-lg"></i></a>'; 
												?>
												<figcaption class="overlay">
													<a class="fancybox"  href="javascript:void(0)" data-toggle="modal" data-target="#myModal_section"  <?php echo 'onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.','.$web_url.','.$pop_url.')"' ?> ><i class="fa fa-eye fa-lg"></i></a>
													
												</figcaption>										
											</figure>
										</div>	
											
										
									</div>
									<?php } ?>

									<?php 
										if($child_value['section_view'] ==3) { 
									?>
									<div class="col-md-12 float-left">
										<div class="col-md-6">
											<figure class="mix work-item branding" style="width:100%;">
											<?php 
													echo '<a href="javascript:void(0);" onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.','.$web_url.','.$pop_url.')"><img src="'.$path.'" style="height: 253px;width:100%;" class="img-responsive"><i class="fa fa-eye fa-lg"></i></a>'; 
												?>
												<figcaption class="overlay">
													<a class="fancybox"  href="javascript:void(0)" data-toggle="modal" data-target="#myModal_section"  <?php echo 'onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.','.$web_url.','.$pop_url.')"' ?> ><i class="fa fa-eye fa-lg"></i></a>
													
												</figcaption>										
											</figure>
										</div>

										<div class="col-md-6" style="text-align: center;">
											<h4 style="line-height: 35px;text-align: center;margin-bottom: 10px;margin-top: 15px;"><?php echo $child_value['title'];?></h4>
											<p style="line-height: 25px;"><?php echo substr_replace($child_value['description'], "...", 60);?></p>
											<p style="margin-bottom:25px;margin-top:10px;">
												<img src="./assets/img/eye-open1.png" id="" style="width:24px;cursor: pointer;">
												<span id=""><?php echo $child_value['views']; ?></span>
												<img src="./assets/img/thumbs-up-circle-blue-512.png" id="likeservice1" style="width:22px;cursor: pointer;" onclick="likeServicesection(<?php echo $name;?>,<?php echo $child_value['section_item_id'];?>)">
												<input type="hidden" value="<?php echo $child_value['section_item_id']; ?>" id="service_id<?php echo $child_value['section_item_id']; ?>">
												<span id="likeservicecount<?php echo $child_value['section_item_id'];?>"><?php echo $child_value['likes']; ?></span>

											</p>
										</div>	
											
											
										
									</div>
									<?php } ?>


									<?php } ?>
							</div>
						</div>
					</div>
				</section>
				<?php 
			} 
			?>

			<!--==========================
			Dynamic Section
			============================-->


		
		


        <!--
        services
        ==================================== -->
		<?php if(count($service_details)>0){?> 
		<section id="services" class="features">
			<div class="container">
				<div class="row">
				
					<div class="sec-title text-center mb50 wow bounceInDown animated" data-wow-duration="500ms">
						<h2>Service</h2>
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
						<div class="devider"><i class="fa fa-heart-o fa-lg"></i></div>
					</div>

					<!-- service item -->
					 <?php 

			          for($j=0;$j<count($service_details);$j++)
			          {
						$name = "'".$service_details[$j]['service_name']."'";
						$image = "'".$path_url.$service_details[$j]['service_image']."'";
						$desc = "'".$service_details[$j]['desc']."'";
			          ?>
					<div class="col-md-4 wow fadeInLeft" data-wow-duration="500ms">
						<div class="service-item">
							<div class="">
								 <?php 
					                  echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal2" onclick="servicepopupimage('.$name.','.$image.','.$desc.')"><img src="'.$path_url.$service_details[$j]['service_image'].' " class="img-fluid" style="width:100%;"></a>'; 
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
		<?php } ?>
        <!--
        End Services
        ==================================== -->
		
		
        <!--
        Our Products
        ==================================== -->
		<?php  if(count($product_details)>0){ ?>
			<section id="products" class="works clearfix">
				
				<div class="container">
					<div class="row">
					
						<div class="sec-title text-center">
							<h2>Products</h2>
							<div class="devider"><i class="fa fa-heart-o fa-lg"></i></div>
						</div>

						<!-- Modal -->
						<div class="modal fade" id="myModal" role="dialog">
						<div class="modal-dialog">          
							<!-- Modal content-->
							<div class="modal-content">           
							<div class="modal-header">
							<h4 class="modal-title" id="mtitle"></h4> 
							<h5 >Category Name : </h5><h5 class="modal-title" id="cname"></h5>
							<!-- <h5 >Sub Category : </h5><h5 class="modal-title" id="scname"></h5> -->
								<button type="button" class="close" data-dismiss="modal">&times;</button>               
							</div>
							<div class="modal-body" id="mimage">   
										
							</div>
							<div class="modal-footer" id="mfooter">
								<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
							</div>
							</div>            
						</div>
						</div>
						
						<div class="sec-sub-title text-center">
							<!-- <p>various products</p> -->
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
						
					
				
						<div class="project-wrapper">
							<?php
							if(count($product_details)>0)
							{
								for($i=0;$i<count($product_details);$i++)
								{
									//echo $product_details[$i]['product_image'];
									$name = "'".$product_details[$i]['product_name']."'";
									$cname = "'".$product_details[$i]['category_name']."'";
									$scname = "'".$product_details[$i]['sub_category_name']."'";
									$product_image = "'".$path_url.$product_details[$i]['product_image']."'";
									$price = "'".$product_details[$i]['currency'].' '.$product_details[$i]['price']."'";
									$total_likes= "'".$product_details[$i]['total_likes']."'";
									$total_views =  "'".$product_details[$i]['total_views']."'";
									$prod_desc = "'".$product_details[$i]['long_desc']."'";
									$prod_short_desc = "'".$product_details[$i]['short_desc']."'";
									$product_url="'".$sectionItem_path."/products/".$product_details[$i]['id']."'"; //
									?>
							<figure class="mix work-item branding" style="height: 210px;">
								<?php 
									echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" onclick="popupimage('.$prod_desc.','.$prod_short_desc.','.$name.','.$product_image.',
									'.$cname.',
									'.$scname.',
									'.$price.',
									'.$total_likes.',
									'.$total_views.',
									'.$product_details[$i]['id'].','.$product_url.')"><img src="'.$path_url.$product_details[$i]['product_image'].' " class="img-fluid" style="width:100%;height: 210px;"></a>'; 
									?>
								<figcaption class="overlay" style="height: 70%; !important">
									<h3 style="margin-top: 10px;"><?php echo $product_details[$i]['product_name'];?></a></h3>
									<h6 style="margin-top: 10px;">Category:<?php echo $product_details[$i]['category_name'];?></h6>
									<p style="margin-top: 10px;"><?php echo $product_details[$i]['price'];?></p>
									<div>
										<img src="./assets/img/eye-open1.png" id="viewT" style="width:20px;cursor: pointer;">
										<span id="viewcount" style="color: white;"><?php echo $product_details[$i]['total_views'];?></span>
										<img src="./assets/img/thumbs-up-circle-blue-512.png" id="likesT1" style="width:20px;cursor: pointer;" onclick="likeProduct(<?php echo $product_details[$i]['id'];?>)">
										<input type="hidden" value="<?php echo $product_details[$i]['id'];?>" id="product_id<?php echo $product_details[$i]['id'];?>">
										<span id="likecount<?php echo $product_details[$i]['id'];?>" style="color: white;"><?php echo $product_details[$i]['total_likes'];?></span>
									</div>

								</figcaption>
							</figure>
							<?php } 
											}?>
							
							
						</div>
					</div>
				</div>

			</section>
		<?php } ?>
        <!--
        End Our Works
        ==================================== -->
		
        <!--
        ads
        ==================================== -->		
		<?php if(count($ad_details)>0) {?> 
		<section id="ads" class="team">
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
						$image = "'".$path_url.$ad_details[$k]['uploads']."'";
			          ?>
					<figure class="team-member col-md-3 col-sm-6 col-xs-12 text-center wow fadeInUp animated" data-wow-duration="500ms" data-wow-delay="600ms">
						<div class="member-thumb">
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
							<figcaption >
								<!--<h5>voluptatem quia voluptas </h5>
								<p>sit aspernatur aut odit aut fugit,</p>-->
								<?php 
									if($ad_details[$k]['desc']!=""){
										echo "<p>".$ad_details[$k]['desc']."</p>"; 
									}
									if($ad_details[$k]['weblink']!=""){
										echo "<p><a  href='".$ad_details[$k]['weblink']."' target='_blank'>Website Link</a></p>"; 
									}
								?>
							</figcaption>
						</div>
						
					</figure>
				<?php } ?>
					<!-- end single member -->
					<!-- single member -->
					
				</div>
			</div>
		</section>
		<?php } ?>
        <!--
        End Ads
        ==================================== -->

		<!-- Album Section -->
		<?php if(count($album_details)>0){ ?>
			<section id="album">
				<div class="container">

					
					<div class="sec-title text-center wow fadeInUp animated" data-wow-duration="700ms">
						<h2>Album</h2>
						<div class="devider"><i class="fa fa-heart-o fa-lg"></i></div>
					</div>
			
					
					<div class="project-wrapper">
						<?php 
						for($m=0;$m<count($album_details);$m++)
						{
							$name = "";
							$image = "'".$path_url.$album_details[$m]['album_image']."'";
							?>
							<figure class="mix work-item branding" style="height: 210px;"> 
								
								<a href="<?php echo base_url('album/'.$album_details[$m]['album_code']); ?>" >
									<img src="<?php echo $path_url.$album_details[$m]['album_image']?> " style="height: 210px;max-width: 280px;" class="img-fluid">
								</a>
								<figcaption>
									<?php 
										if($album_details[$m]['about']!=""){
											echo "<p>".$album_details[$m]['about']."</p>"; 
										}
									?>
								</figcaption>
								
						
							</figure>
							<?php 
						} 
						?>
					</div>
				</div>
			</section>	
			<?php } ?>					
							







		<?php if(count($myvideo_det)>0){?> 	
		 <section id="videosection" class="section-with-bg wow fadeInUp">

      <div class="container">
        <div class="section-header">
          <h2>Videos</h2>
          
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
		
		
		
        <!--
        End Some fun facts
        ==================================== -->
		
	<!--
        Contact Us
        ==================================== -->		
		<?php 
	     	 if(count($contact_details)>0)
	      { ?>
		<section id="contact" class="contact">
			<div class="container">
				<div class="row mb50">
				
					<div class="sec-title text-center mb50 wow fadeInDown animated" data-wow-duration="500ms">
						<h2>Contact</h2>
						<div class="devider"><i class="fa fa-heart-o fa-lg"></i></div>
					</div>
					
					<div class="sec-sub-title text-center wow rubberBand animated" data-wow-duration="1000ms">
						<p>Address </p>
					</div>
					
					<!-- contact address -->
					<div class="col-lg-6 col-md-6 col-sm-4 col-xs-12 wow fadeInLeft animated" data-wow-duration="500ms">
						<div class="contact-address">
							<p><i class="fa fa-suitcase"></i>  <?php echo $website;?><br/>
							<i class="fa fa-address-book" aria-hidden="true"></i><span><?php
						                if(isset($contact_details[0]['address'])&&($contact_details[0]['address']!=''))
						                {
						                  echo $contact_details[0]['address']; 
						                }
						                else
						                {
						                  echo $address;
						                }
						             ?>	</span></p>
								<p><i class="fa fa-phone-square"></i> 
								<?php if(isset($contact_details[0]['phonenumber'])){
								echo "Phone :".$contact_details[0]['phonenumber'];
								} ?><br/><i class="fa fa-phone-square"></i> 
								<?php if(isset($contact_details[0]['homenumber'])){
								echo "Home :".$contact_details[0]['homenumber'];
								} ?><br/><i class="fa fa-phone-square"></i> 
								<?php if(isset($contact_details[0]['officenumber'])){
								echo "Office :".$contact_details[0]['officenumber'];
								} ?><br/><i class="fa fa-fax"></i> 
								<?php if(isset($contact_details[0]['faxnumber'])){
								echo "Fax :".$contact_details[0]['faxnumber'];
								} ?></p>
								<p><i class="fa fa-envelope"></i> <?php 
                 
					                if(isset($contact_details[0]['email'])&&($contact_details[0]['email']!=''))
					                {
					                  echo $contact_details[0]['email']; 
					                }
					                else
					                {
					                  echo $mail;
					                }
					                 
					                ?></p>
						</div>
					</div>
					<!-- end contact address -->
					
					
					
					<!-- footer social links -->
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 wow fadeInRight animated" data-wow-duration="500ms" data-wow-delay="600ms">
						<ul class="footer-social">
							
							<li style="float: left; margin-right: 10px;"><a href="#"><i class="fa fa-twitter fa-2x"></i></a></li>
							
							<li style="float: left; margin-right: 10px;"><a href="<?php 
							if(isset($contact_details[0]['fb']))
							{
								echo $contact_details[0]['fb'];
							}
							 ?>"><i class="fa fa-facebook fa-2x"></i></a></li>
						</ul>
					</div>
					<!-- end footer social links -->
					
				</div>
			</div>
			
			
			
		</section>
		<?php }?>
        <!--
        End Contact Us
        ==================================== -->
			
		
		
		<footer id="footer" class="footer">
			<div class="container">
				
				<div class="row">
					<div class="col-md-12">
						<p class="copyright text-center">
						&copy; Copyright <strong>3ABC7</strong>. All Rights Reserved
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
				mobile:       true,       // trigger animations on mobile devices (default is true)
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
		<script>
  
  function servicepopupimage(name,image,desc){
      
      $('#mtitle2').html(name);
      $('#mimage2').html('<img src="'+image+'" width="400px" height="400px">');
      $('#desc2').html(desc);
     }

    function videopreviewimage(video,id){
      $('#videoimage').html('<video width="280" height="200" controls><source src="'+video+'" type="video/mp4"></video><input type="hidden" value="'+id+'" id="adv_id">');
    }
	//  function popupimage(name,image,cname,scname,price){
      
    //   $('#mtitle').html(name);
    //   $('#cname').html(cname);
    //   $('#scname').html(scname);
    //   $('#mfooter').html(price);
    //   $('#mimage').html('<img src="'+image+'" width="100%" height="400px">');
    //  }

	function popupimage(desc1,short_desc,name,image,cname,scname,price,likes,views,p_id,product_url){
      
      $('#mtitle').html(name);
      $('#cname').html(cname);
      $('#scname').html(scname);
      $('#likecount').html(likes);
      $('#viewcount').html(views);
      //$('#mfooter').html('<img src="'+image+'"  width="460px" height="400px">');
      $('#mimage').html('<img src="'+image+'"  width="100%" height="400px"><input type="hidden" value="'+p_id+'" id="product_id1"><br><span><b>Description</b>: '+desc1+'</span><br><span><b>Short Description</b>: '+short_desc+'</span><div><a  href='+product_url+'#contact'+' tabindex="-1"><button type="button" class="btn btn-primary" tabindex="-1">Business Enquiry</button></a></div>');
      
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
		$('#desc2_section').html('<div class="description">'+desc+'</div><input type="hidden" value="'+update_id+'" id="service_id"><br><div><a href="'+image+'" target="_blank" style="color:black">Click here to view</a></div><br><div><a href="'+Websiteurl+'" target="_blank" style="color:black"><b>Website Link</b></a></div><br><div><a  href='+viewUrl+'#enquirynow'+' tabindex="-1"><button type="button" class="btn btn-primary" tabindex="-1">Enquiry</button></a></div>');

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

  	function servicepopupimage2(name,image,desc,service_id,weblink,type){
      
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
