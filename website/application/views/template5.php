<!DOCTYPE html>
<html lang="en">
<head>
  <?php 
  $path_url = $this->config->item('path_url'); 
  $login_url = $this->config->item('login_url');
  $image_path = $this->config->item('base_path');
  $logo_img_path = $this->config->item('logo_img_path');
  $last_slider_image = end($slider_image);

  $this->load->view('index.html');
  ?>
  <meta charset="utf-8">
  <title><?php echo $website; ?></title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="<?php echo $website; ?>" name="keywords">
  <meta content="<?php echo $website; ?>" name="description">

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

      @media (max-width:768px)
			{
        #websiteLogoImg {
          margin-left: 10px;
        }
        #logo{
          margin-top:5px !important;
        }
			
			}

		</style>

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
        <a href="#intro" class="scrollto">
          <!-- <img src="<?php echo base_url();?>assets/template5/img/logo.png" alt="" class="img-fluid"> -->
          <?php if($logo_img=="" && $logo_name=="" ){ ?>
                  <div id="websiteLogo"> <?php echo $website; ?> </div>
          <?php }else if($logo_img !=""){ ?>
                  <div id="websiteLogoImg">
                      <h1 id="logo">
                          <img src="<?php echo $logo_img_path;?><?php echo $logo_img; ?>" alt="<?php echo $website; ?>" title="<?php echo $website; ?>" class="img-fluid"/>
                      </h1>
                  </div>
          <?php }else{ ?>
                <div id="websiteLogo"> <?php echo $logo_name; ?> </div>
          <?php } ?>
    </a>
      </div>

      <nav class="main-nav float-right d-none d-lg-block">
        <ul>
          <li class="active"><a href="#intro">Home</a></li>
          <?php 
						foreach ($all_details as $key => $value) 
						{
							if($value[0]['show_menu']==1){
							?>
								<li>
								<a href="#<?php echo $key;?>">
									<?php echo $key;?>
								</a>
								</li>
							<?php 
							}
						}
          ?>    

          <!-- <li><a href="#about">About Us</a></li> -->
          
          <?php if(count($service_details)>0){ ?>	  
            <li><a href="#services">Services</a></li>
          <?php } ?>
          <?php  if(count($product_details)>0){ ?>
            <li><a href="#portfolio">Products</a></li>
          <?php } ?>  
          <!-- <li><a href="#team">My Ads</a></li>  -->
          <?php   if(count($myvideo_det)>0){ ?>
            <li><a href="#videosection">Videos</a></li>
          <?php } ?>
          <?php if(count($contact_details)>0){ ?>
            <li><a href="#contact">Contact</a></li>
          <?php } ?>
          <li><a href="<?php echo $login_url; ?>" target="_blank">Website login</a></li>
           <li>
              <a href="javascript:void(0);" data-toggle="modal" data-target="#searchModal"> 
                <img src="./assets/img/search.png" style="width:30px;cursor: pointer;background-color: black;">
              </a>
            </li>          
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
        <?php if($last_slider_image['slider_image']){?>
          <img src="<?php echo $image_path.$last_slider_image['slider_image'];?>" alt="" class="img-fluid">
        <?php }else{?>  
        <img src="<?php echo base_url();?>assets/template5/img/intro-img.svg" alt="" class="img-fluid">
        <?php } ?>
      </div>

      <div class="intro-info">
        <?php if($last_slider_image['slider_title']){ ?>
        <h2><?php echo $last_slider_image['slider_title']; ?></h2>
        <?php } else {?>
          <h2>We provide<br><span>solutions</span><br>for your business!</h2>
        <?php } ?>
        <?php if($last_slider_image['slider_desc']){ ?>
          <p style="font-size:20px;text-wrap: wrap;width: 80%;color: blanchedalmond;"><?php echo $last_slider_image['slider_desc']; ?></p>
        <?php } ?>  


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
               $about_us=(isset($contact_details[0]['about_website']))?$contact_details[0]['about_website']:'';


            ?></p>
        </header>

        <div class="row about-container">

          <div class="col-lg-8 content order-lg-1 order-2">
            <p>
            <?php echo $about_us; ?>
            </p>
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
          </div>

          <div class="col-lg-4  order-lg-1 order-2 wow fadeInUp">
          <?php 
           if(isset($contact_details[0]['website_image']))
             {
                $image = $contact_details[0]['website_image'];
             }
             else{
              $image = ($profile_image!='')?$profile_image:'user_profile/default.png';
             }
            echo '<img align="left" style="width: auto; height: 180px;" src="'.$path_url.$image.'" alt="Profile image example"/>';
           ?>           
          </div>
        </div>

        
     
      </div>
    </section><!-- #about -->

    <!--==========================
    Dynamic Section
    ============================-->
    <?php
    if(count($all_details)>0){}
    foreach ($all_details as $key => $value) 
    {
        ?>
        <section id="<?php echo $key;?>" class="section-bg">
            <div class="container">
              <header class="section-header" id="<?php echo $key;?>">
                <h3  style="margin-top:10px; padding-top: 10px;"><?php echo $key;?></h3>     
              </header>
              
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
              <!--Modal-->
                      
            </div>
            
            <div class="row">
                <?php
                    foreach ($all_details[$key] as $child_key => $child_value) {

                        $name = "'".$child_value['section_name']."'";
                        $image = "'".$child_value['preview_file']."'";
                        $desc = "'".$child_value['description']."'";
                        $service_id = "'".$child_value['section_item_id']."'";
                        $weblink = "'".$child_value['file_name']."'";
                        $media_type =$child_value['media_type'];
                        $web_url = "'".$child_value['website_link']."'";
                        // echo $web_url;die;
                
                        if($child_value['media_type']==1) {
                            $path = $path_url.$child_value['file_name'];
                            $file_name_path = "'".$path_url.$child_value['file_name']."'";
                            $path_src = "'".$path_url.$child_value['file_name']."'";
                        } else{
                            $path = $path_url.$child_value['preview_file'];
                            $file_name_path = "'".$path_url.$child_value['file_name']."'";
                            $path_src = "'".$path_url.$child_value['preview_file']."'";
                        }
                    ?>	


                        <div class="col-sm-3 col-md-3 col-lg-3 offset-lg-1 wow bounceInUp" data-wow-duration="1.4s" style="padding-top: 10px;background:white;margin-bottom: 50px;border-radius: 10px;">
                          <div class="box" style="margin: 2px;">
                            <?php 
                                echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_section"   onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.','.$web_url.')"><img src="'.$path.'" class="img-responsive" style=" width:100%; height:200px; max-height: 200px;"></a>'; 
                            ?>
                            <h4 class="title" style="font-size: 20px;margin-top: 15px;">
                              <?php echo '<a href="javascript:void(0);" style="color:#515152 !important;" data-toggle="modal" data-target="#myModal_section"   onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.','.$web_url.')">';?> <?php echo $child_value['title'];?></a></h4>
                            <p class="description" style="margin-bottom:18px;font-size: 13px;color:#7f7b7b"><?php echo substr_replace($child_value['description'], "...", 60);?></p>
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
            </div>
        </section>
        <?php 
    } 
    ?>

    <!--==========================
    Dynamic Section
    ============================-->
    
    
  
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
          <?php  if(count($myvideo_det)>0){?>       
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
    
    <!--==========================
      Services Section
    ============================-->
    <?php if(count($service_details)>0){?>   
    <section id="services" class="section-bg">
      <div class="container">

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
    <?php } ?>


   
    <!--==========================
      Product Section
    ============================-->
    <?php if(count($product_details)>0) {?> 
    <section id="portfolio" class="section-with-bg wow fadeInUp">
      <div class="container">

        <header class="section-header">
          <h3 class="section-title">Products</h3>
        </header>

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
                <!-- <h6 >Sub Category : </h6><h6 class="modal-title" id="scname"></h6> <br>   -->           
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


        <div class="row portfolio-container">

          
          <?php
           if(count($product_details)>0)
            {
              for($i=0;$i<count($product_details);$i++){
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
              <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                <div class="portfolio-wrap" style="height:200px;">
                  <?php 
                      echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" onclick="popupimage('.$prod_desc.','.$prod_short_desc.','.$name.','.$product_image.',
                      '.$cname.',
                      '.$scname.',
                      '.$price.',
                      '.$total_likes.',
                      '.$total_views.',
                      '.$product_details[$i]['id'].')"><img src="'.$path_url.$product_details[$i]['product_image'].' " class="img-fluid" style="width:100%;height:200px;"></a>'; 
                  ?>
                  <div class="portfolio-info" style="height: 70%;margin-top: 30%;">
                    <span style="color: white;">Category:<?php echo $product_details[$i]['category_name'];?></span>
                    <br><br><h4><a href="#"><?php echo $product_details[$i]['product_name'];?></a></h4>
                    <p><?php echo $product_details[$i]['price'];?></p>
                    <div>
                        <img src="./assets/img/eye-open1.png" id="viewT" style="width:20px;margin-left:5px;cursor: pointer;">
                        <span id="viewcount" style="color: white;"><?php echo $product_details[$i]['total_views'];?></span>
                        <img src="./assets/img/thumbs-up-circle-blue-512.png" id="likesT1" style="width:20px;margin-left:5px;cursor: pointer;" onclick="likeProduct(<?php echo $product_details[$i]['id'];?>)">
                        <input type="hidden" value="<?php echo $product_details[$i]['id'];?>" id="product_id<?php echo $product_details[$i]['id'];?>">
                        <span id="likecount<?php echo $product_details[$i]['id'];?>" style="color: white;"><?php echo $product_details[$i]['total_likes'];?></span>
                    </div>
                    
                  <div>
                    <?php
                    echo  '<a href="'.$path_url.$product_details[$i]['product_image'].'" data-lightbox="portfolio" data-title="App 1" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>';
                    ?>
                    <a href="#" class="link-details" title="More Details"><i class="ion ion-android-open"></i></a>
                  </div>
                </div>
              </div>
            </div>    
            <?php } 
            }?>
          </div>

        

        

      </div>
    </section><!-- #Products -->
    <?php } ?>

    <!--==========================
      Team Section
    ============================-->
    <?php if(count($ad_details)>0) {?> 
    <section id="team">
      <div class="container">
        <div class="section-header">
          <h3>Advertisment</h3>
         
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


          <div class="col-lg-3 col-md-6 wow fadeInUp">
          <?php
                                      for($k=0;$k<count($ad_details);$k++)
                                      {
                                        $image = "'".$path_url.$ad_details[$k]['uploads']."'";
                                      ?>
            <div class="member">
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
    <?php } ?>
    
    
   <!-- Album Section -->
   <?php if(count($album_details)>0){ ?>
			<section id="album" class="section-with-bg wow fadeInUp">
				<div class="container">

					
					

          <div class="section-header">
            <h3 style="margin-top: 10px;">Album</h3>
          </div>
			
					
					<div class="project-wrapper">
						<?php 
						for($m=0;$m<count($album_details);$m++)
						{
							$name = "";
							$image = "'".$path_url.$album_details[$m]['album_image']."'";
							?>
							<figure class="mix work-item branding"> 
								
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



      <!--==========================
      Contact Section
    ============================-->
    <?php 
         if(count($contact_details)>0)
        { ?>
    <section id="contact">
      <div class="container-fluid">

        <div class="section-header">
          <h3>Contact</h3>
        </div>

        <div class="row wow fadeInUp">

          <div class="col-lg-4">
            <div class="map mb-4 mb-lg-0">
             <div class="social-links">
              <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
              <a href="<?php
              if(isset($contact_details[0]['fb']))
              {
                echo $contact_details[0]['fb']; 
              }
               ?>" class="facebook"><i class="fa fa-facebook"></i></a>
              
              <a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
              <a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
              <a href="<?php 
                 if(isset($contact_details[0]['linked']))

                  {
                    echo $contact_details[0]['linked']; 
                  }                 


                 ?>" class="linkedin"><i class="fa fa-linkedin"></i></a>
              
        <p><?php if(isset($contact_details[0]['whatsapp'])){
          echo "Whatsapp :".$contact_details[0]['whatsapp'];
        } ?></p>
        <p><?php if(isset($contact_details[0]['telegram'])){
          echo "Telegram :".$contact_details[0]['telegram'];
        } ?></p>
        
            </div>
            </div>
          </div>

          <div class="col-lg-8">
            <div class="row">
              <div class="col-md-5 info">
                <i class="ion-ios-location-outline"></i>
                <p><?php
                            if(isset($contact_details[0]['address'])&&($contact_details[0]['address']!=''))
                            {
                              echo $contact_details[0]['address']; 
                            }
                            else
                            {
                              echo $address;
                            }
                         ?> </p>
              </div>
              <div class="col-md-4 info">
                <i class="ion-ios-email-outline"></i>
                <p> <?php 
                 
                if(isset($contact_details[0]['email'])&&($contact_details[0]['email']!=''))
                {
                  echo $contact_details[0]['email']; 
                }
                else
                {
                  echo $mail;
                }
                 
                ?></p>
                  <i class="ion-ios-telephone-outline"></i>
                
                <p><?php if(isset($contact_details[0]['phonenumber'])){
                  echo "Phone :".$contact_details[0]['phonenumber'];
                } ?></p>
                <i class="ion-ios-telephone-outline"></i>
                <p><?php if(isset($contact_details[0]['homenumber'])){
                  echo "Home :".$contact_details[0]['homenumber'];
                } ?></p>
              </div>
              <div class="col-md-3 info">
              
            <i class="ion-ios-telephone-outline"></i>
            <p><?php if(isset($contact_details[0]['officenumber'])){
              echo "Office :".$contact_details[0]['officenumber'];
            } ?></p>
            <i class="ion-ios-telephone-outline"></i>
            <p><?php if(isset($contact_details[0]['faxnumber'])){
              echo "Fax :".$contact_details[0]['faxnumber'];
            } ?></p>
              </div>
            </div>

            
          </div>

        </div>

      </div>
    </section><!-- #contact -->
  <?php }?> 


    
  </main>

  <!--==========================
    Footer
  ============================-->
  <footer id="footer">
    
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong>3ABC7</strong>. All Rights Reserved
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
