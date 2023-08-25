<!DOCTYPE html>
<html lang="en">
<?php
$path_url = $this->config->item('path_url');
$login_url = $this->config->item('login_url');
$image_path = $this->config->item('base_path');
$logo_img_path = $this->config->item('logo_img_path');
$this->load->view('index.html');
 ?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $website; ?>">
    <meta name="author" content="<?php echo $website; ?>">

    <title><?php echo $website; ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url();?>assets/template4/asset/css/bootstrap.min.css" rel="stylesheet"/>
    
    <!-- Font Awesome CSS -->
    <link href="<?php echo base_url();?>assets/template4/css/font-awesome.min.css" rel="stylesheet"/>
    
    
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
				/* margin-top:10px;
				margin-left:10px; */
                
			}
            .navbar-brand{
                padding:0px !important;
            }
            .about-us-section-1 {
                padding-top: 11px !important;
                padding-bottom: 5px !important;
            }
            .welcome-section {
                padding-bottom: 40px;
                background: #f6f6f6;
            }

            @media (max-width:768px)
			{
                #websiteLogoImg {
				    margin-left: 10px;
			    }
                #logo{
                    margin-top:5px !important;
                }
                #showpopupimg{
					max-width:300px !important;
				}
			
			}

            


		</style>


</head>

<body class="index">
    
    
    <!-- Styleswitcher
================================================== -->
<!--<div class="colors-switcher">
            <a id="show-panel" class="hide-panel"><i class="fa fa-tint"></i></a>        
                <ul class="colors-list">
                    <li><a title="Light Red" onClick="setActiveStyleSheet('light-red'); return false;" class="light-red"></a></li>
                    <li><a title="Blue" class="blue" onClick="setActiveStyleSheet('blue'); return false;"></a></li>
                    <li class="no-margin"><a title="Light Blue" onClick="setActiveStyleSheet('light-blue'); return false;" class="light-blue"></a></li>
                    <li><a title="Green" class="green" onClick="setActiveStyleSheet('green'); return false;"></a></li>
                    
                    <li class="no-margin"><a title="light-green" class="light-green" onClick="setActiveStyleSheet('light-green'); return false;"></a></li>
                    <li><a title="Yellow" class="yellow" onClick="setActiveStyleSheet('yellow'); return false;"></a></li>
                    
                </ul>

        </div>  -->
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
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>

                    <?php 
						foreach ($all_details as $key => $value) 
						{
							if($value[0]['show_menu']==1){
							?>
								<li class="">
								<a href="#<?php echo $key;?>" class="page-scroll">
									<?php echo $key;?>
								</a>
								</li>
							<?php 
							}
						}
                    ?>    

                    <?php if(count($contact_details)>0){ ?>
                        <li>
                            <a class="page-scroll" href="#contact">Contact</a>
                        </li>
                    <?php } ?>

                    <?php  if(count($product_details)>0){ ?>    
                        <li>
                            <a class="page-scroll" href="#products">Products</a>
                        </li>
                    <?php } ?>

                    <?php if(count($service_details)>0){ ?>	
                        <li>
                            <a class="page-scroll" href="#services">Service</a>
                        </li>
                    <?php } ?>
                   
    
                    <!-- <li>
                        <a class="page-scroll" href="#ads">My Advertisment</a>
                    </li> -->
                    <?php   if(count($myvideo_det)>0){ ?>
                      <li><a href="#videosection">Videos</a></li>
                    <?php } ?>   
                    <li><a href="<?php echo $login_url; ?>" target="_blank">Website login</a></li>
                     <li>
                            <a href="javascript:void(0);" data-toggle="modal" data-target="#searchModal"> 
                              <img src="./assets/img/search.png" style="width:30px;cursor: pointer;">
                            </a>
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
                <?php 
                    if(count($slider_image)>0){
                        for($j=0;$j<count($slider_image);$j++)
                        { ?>
                            <li data-target="#main-slide" data-slide-to="<?php echo $j; ?>" class="active"></li>
                    <?php   } 
					}else{?>	
                        <li data-target="#main-slide" data-slide-to="0" class="active"></li>
                        <li data-target="#main-slide" data-slide-to="1"></li>
				<?php } ?>	

               
            </ol>
            <!--/ Indicators end-->

            <!-- Carousel inner  slider part-->
            <div class="carousel-inner">
                <?php 
                if(count($slider_image)>0)
                {
                    for($j=0;$j<count($slider_image);$j++)
                    {
                    ?>
                        <div class="item <?php if($j==0){echo "active";} ?>">
                            <img class="img-responsive" src="<?php echo $image_path.$slider_image[$j]['slider_image']; ?>" alt="slider">
                            <div class="slider-content">
                                <div class="col-md-12 text-center">
                                    <?php if($slider_image[$j]['slider_title']){ ?>	
                                        <h1 class="animated3">
                                            <span><?php echo $slider_image[$j]['slider_title']; ?></span>
                                        </h1>
                                    <?php } ?>
                                    <?php if( $slider_image[$j]['slider_desc']){ ?>    
                                        <p class="animated2"><?php echo $slider_image[$j]['slider_desc']; ?></p>	
                                    <?php } ?> 
                                    <?php if($slider_image[$j]['slider_link']){ ?>   
                                        <a href="<?php echo $slider_image[$j]['slider_link']; ?>" class="page-scroll btn btn-primary animated1">Read More</a>
                                    <?php } ?>    
                                </div>
                            </div>
                        </div>
                <?php 
                    } 
                }else{
                      ?>
                      <div class="item active">
                        <img class="img-responsive" src="<?php echo base_url();?>assets/template4/images/galaxy.jpg" alt="slider">
                     </div>

                     <div class="item">
                        <img class="img-responsive" src="<?php echo base_url();?>assets/template4/images/header-back.png" alt="slider">
                     </div>
                     
                     <?php
                }
                ?>
                <!--/ Carousel item end -->
                
            
                <!--/ Carousel item end -->
                
              
            </div>
            <!-- Carousel inner slider part end-->

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

     <!-- Start About Us Section -->
    <section id="about" >
        <div class="container">
            <div class="row">
                <div class="col-md-12">
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
                                    echo '<img src="'.$path_url.$image.'" class="pull-left" style="max-width: 175px;margin: 0 38px 20px 10px;" />';
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
                            <p style="margin-top: 15px; text-align: justify;"><?php echo $about_us; ?> </p>
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <!--==========================
    Dynamic Section
    ============================-->
    <?php
    if(count($all_details)>0){}
    foreach ($all_details as $key => $value) 
    {
        ?>
        <section id="<?php echo $key;?>" class="about-us-section-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="section-title text-center">
                            <h3><?php echo $key;?></h3>
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
                    </div>
                    
                    <div class="row">
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
                                <div class="col-md-4">
                                    <div class="welcome-section text-center">
                                    <?php 
                                        echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_section"   onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.','.$web_url.')"><img src="'.$path.'" class="img-responsive" style="height:215px; max-height: 215px;"></a>'; 
                                    ?>
                                        <h4><?php echo $child_value['title'];?></h4>
                                        <div class="border"></div>
                                        <p><?php echo substr_replace($child_value['description'], "...", 60);?></p>
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
                                if($child_value['section_view'] ==2) { 
                            ?>
                                <div class="col-md-6" style="margin-bottom:12px;">
                                    <div class="welcome-section text-center">
                                    <?php 
                                        echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_section"   onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.','.$web_url.')"><img src="'.$path.'" class="img-responsive" style="height:215px; max-height: 215px;"></a>'; 
                                    ?>
                                        <h4><?php echo $child_value['title'];?></h4>
                                        <div class="border"></div>
                                        <p><?php echo substr_replace($child_value['description'], "...", 60);?></p>
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
                                if($child_value['section_view'] ==3) { 
                            ?>
                                <div class="col-md-12" style="margin-bottom:12px;">
                                    <div class="welcome-section text-center">
                                        <div class="col-lg-6 col-md-6 float-left">
                                            <?php 
                                                echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_section"   onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.','.$web_url.')"><img src="'.$path.'" class="img-responsive" style="height:215px; max-height: 215px;"></a>'; 
                                            ?>
                                        </div>
                                        <div class="col-lg-6 col-md-6 float-left">
                                            <h4><?php echo $child_value['title'];?></h4>
                                            <div class="border"></div>
                                            <p><?php echo substr_replace($child_value['description'], "...", 60);?></p>
                                            <p>
                                                <img src="./assets/img/eye-open1.png" id="" style="width:24px;cursor: pointer;">
                                                <span id=""><?php echo $child_value['views']; ?></span>
                                                <img src="./assets/img/thumbs-up-circle-blue-512.png" id="likeservice1" style="width:22px;cursor: pointer;" onclick="likeServicesection(<?php echo $name;?>,<?php echo $child_value['section_item_id'];?>)">
                                                <input type="hidden" value="<?php echo $child_value['section_item_id']; ?>" id="service_id<?php echo $child_value['section_item_id']; ?>">
                                                <span id="likeservicecount<?php echo $child_value['section_item_id'];?>"><?php echo $child_value['likes']; ?></span>

                                            </p>
                                        </div>
                                    </div>
                                </div> 
                            <?php } ?>

                            <?php 
                                if($child_value['section_view'] ==4) { 
                            ?>
                                <div class="col-md-12" style="margin-bottom:12px;padding-top: 10px;background: #f6f6f6;padding-bottom: 10px;">
                                    <div class="welcome-section text-center">
                                      
                                        <div class="col-lg-6 col-md-6 float-left">
                                            <h4><?php echo $child_value['title'];?></h4>
                                            <div class="border"></div>
                                            <p><?php echo substr_replace($child_value['description'], "...", 60);?></p>
                                            <p>
                                                <img src="./assets/img/eye-open1.png" id="" style="width:24px;cursor: pointer;">
                                                <span id=""><?php echo $child_value['views']; ?></span>
                                                <img src="./assets/img/thumbs-up-circle-blue-512.png" id="likeservice1" style="width:22px;cursor: pointer;" onclick="likeServicesection(<?php echo $name;?>,<?php echo $child_value['section_item_id'];?>)">
                                                <input type="hidden" value="<?php echo $child_value['section_item_id']; ?>" id="service_id<?php echo $child_value['section_item_id']; ?>">
                                                <span id="likeservicecount<?php echo $child_value['section_item_id'];?>"><?php echo $child_value['likes']; ?></span>

                                            </p>
                                        </div>
                                        <div class="col-lg-6 col-md-6 float-left">
                                            <?php 
                                                echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_section"   onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.','.$web_url.')"><img src="'.$path.'" class="img-responsive" style="height:215px; max-height: 215px;"></a>'; 
                                            ?>
                                        </div>
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
    

    <?php 
      if(count($contact_details)>0)
      { ?> 
        <section id="contact" class="contact">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title text-center">
                            <h3>Contact With Us</h3>
                        <!-- <p class="white-text">Duis aute irure dolor in reprehenderit in voluptate</p>-->
                        </div>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-md-12">
                        <div class="footer-contact-info">
                            <h4>Contact info</h4>
                            <ul>
                                
                                <li><strong>E-mail :</strong> <?php 
                    
                                    if(isset($contact_details[0]['email'])&&($contact_details[0]['email']!=''))
                                    {
                                    echo $contact_details[0]['email']; 
                                    }
                                    else
                                    {
                                    echo $mail;
                                    }
                                    
                                    ?></li>
                                <li><strong>Phone :</strong><?php if(isset($contact_details[0]['phonenumber'])){
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
                                    } ?> </li>
                                <li><strong>Web :</strong><?php echo $website;?></li>
                            </ul>
                        </div>
                    </div>
                
                </div>
            </div>
        
        </section>
    <?php } ?>


	 <!-- Start About Us Section -->
     <?php if(count($service_details)>0){?> 
        <section id="services" class="about-us-section-1">
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
                        $name = "'".$service_details[$j]['service_name']."'";
                        $image = "'".$path_url.$service_details[$j]['service_image']."'";
                        $desc = "'".$service_details[$j]['desc']."'";
                    ?>
                    <div class="col-md-4">
                        <div class="welcome-section text-center">
                            <?php 
                            echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal2" onclick="servicepopupimage('.$name.','.$image.','.$desc.')"><img src="'.$path_url.$service_details[$j]['service_image'].' " class="img-fluid" style="width:100%;"></a>'; 
                            ?>
                            <h3><?php echo $service_details[$j]['service_name'];?></h3>
                                    <p><?php echo $service_details[$j]['desc'];?></p>
                        </div>
                    </div>
                    <?php } ?>
                
                    
                </div><!-- /.row -->            
                
            </div><!-- /.container -->
        </section>
    <?php } ?>
    <!-- Services Section -->
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
   


    <!-- Start Call to Action Section -->
    <section class="call-to-action">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                   
                    
                </div>
            </div>
        </div>
    </section>
    <!-- End Call to Action Section -->
      
    
    <!-- Start Products Section -->
    <?php  if(count($product_details)>0){ ?> 
        <section id="products" class="portfolio-section-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title text-center">
                            <h3>Products</h3>
                            <p>Various Products</p>
                        </div>                        
                    </div>
                </div>

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
                    <div class="modal-body" id="mimage">   
                    <h4 class="modal-title" id="mtitle"></h4>             
                    </div>
                    <div class="modal-footer" id="mfooter">
                        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                    </div>
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
                            <li>
                                <div class="portfolio-item">
                                    <?php 
                                        echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" onclick="popupimage('.$prod_desc.','.$prod_short_desc.','.$name.','.$product_image.',
                                        '.$cname.',
                                        '.$scname.',
                                        '.$price.',
                                        '.$total_likes.',
                                        '.$total_views.',
                                        '.$product_details[$i]['id'].')"><img src="'.$path_url.$product_details[$i]['product_image'].' " class="img-fluid" style="width:100%;height: 210px;"></a>'; 
                                        ?>
                                    <div class="portfolio-caption" style="height: 70%;">
                                        <span>Category:<?php echo $product_details[$i]['category_name'];?></span>
                                        <h3><?php echo $product_details[$i]['product_name'];?></a></h3>
                                        <p><?php echo $product_details[$i]['price'];?></p>
                                        <div>
                                            <img src="./assets/img/eye-open1.png" id="viewT" style="width:20px;margin-left:5px;cursor: pointer;">
                                            <span id="viewcount" style="color: white;"><?php echo $product_details[$i]['total_views'];?></span>
                                            <img src="./assets/img/thumbs-up-circle-blue-512.png" id="likesT1" style="width:20px;margin-left:5px;cursor: pointer;" onclick="likeProduct(<?php echo $product_details[$i]['id'];?>)">
                                            <input type="hidden" value="<?php echo $product_details[$i]['id'];?>" id="product_id<?php echo $product_details[$i]['id'];?>">
                                            <span id="likecount<?php echo $product_details[$i]['id'];?>" style="color: white;"><?php echo $product_details[$i]['total_likes'];?></span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php } 
                                }?>
                           
                        </ul>
                        <!-- End Portfolio items -->
                    </div>
                </div>
            </div>
        </section>
        <?php } ?>
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
    <?php if(count($ad_details)>0) {?>  
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
  
            <div class="row">
                <div class="col-md-12">
                    <div id="team-section">
                                <div class="our-team">
                                     <?php
                                      for($k=0;$k<count($ad_details);$k++)
                                      {
                                        $image = "'".$path_url.$ad_details[$k]['uploads']."'";
                                      ?>
                                    <div class="team-member">
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
                                        <div>
                                            <!--<h4>John Doe</h4>
                                            <p>Founder & Director</p>-->
                                            
											<?php 
												if($ad_details[$k]['desc']!=""){
													echo "<p>".$ad_details[$k]['desc']."</p>"; 
												}
												if($ad_details[$k]['weblink']!=""){
													echo "<p><a href='".$ad_details[$k]['weblink']."' target='_blank'>Website Link</a></p>"; 
												}
											?>
								
                                        </div>
                                    </div>
                                    <?php } ?>
                                  


                                </div>

                    
                    </div>
                </div>
            </div>
                
        </div>
    </section>
    <?php } ?>
    <!-- End Ads Section -->

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
									<img src="<?php echo $path_url.$album_details[$m]['album_image']?> " style="height: 210px;" class="img-fluid">
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



<section>
<footer class="style-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <span class="copyright"> &copy; Copyright <strong>3ABC7</strong>. All Rights Reserved</span>
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
    <script>
  
  function servicepopupimage(name,image,desc){
      
      $('#mtitle2').html(name);
      $('#mimage2').html('<img src="'+image+'" width="400px" height="400px">');
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


    function servicepopupimage_section(name,image,desc,update_id,weblink,type,src_file,web_url)
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
		$('#desc2_section').html('<div class="description">'+desc+'</div><input type="hidden" value="'+update_id+'" id="service_id"><br><div><a href="'+image+'" target="_blank" style="color:black">Click here to view</a></div><br><div><a href="'+Websiteurl+'" target="_blank" style="color:black"><b>Website Link</b></a></div>');

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
