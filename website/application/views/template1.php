<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  $this->load->view('index.html');
  $path_url = $this->config->item('path_url');

  $login_url = $this->config->item('login_url');
  $image_path = $this->config->item('base_path');
  $logo_img_path = $this->config->item('logo_img_path');
  $sectionItem_path=base_url().$website;

  $last_slider_image = end($slider_image);
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title><?php echo $website; ?></title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="<?php echo $website; ?>" name="keywords">
  <meta content="<?php echo $website; ?>" name="description">
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
    video {
      width: 100%;
      height: auto;
    }

    #mimage2 img {
      width: 100%;
      height: auto;
    } 

   
    /* Add custom CSS styles for arrow icons and positioning */
    .slider {
      /* position: relative; */
      /* max-height: 80vh; */
    }

    .slider {
      display: flex;
      /* overflow-x: auto; */
      position: relative; /* Add position relative to the slider container */
      max-height:85%;
    }

    .slide {
      flex: 0 0 auto;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center; /* Center elements vertically and horizontally */
      position: relative; /* Add position relative to each slide */
    }

    .slide img {
      width: 100%; /* Make the image take the full width of the slide */
      height: 100%; /* Allow the height to adjust automatically based on the image aspect ratio */
    }

    .slide h1 {
      margin-top: 10px;
      color: #f82249; /* Set the color of the title */
      font-size: 40px; /* Set the font size of the title */
      font-weight:600;
      line-height: 28px;
      position: absolute;
      top: 50%; /* Position the title 50% from the top of the slide */
      left: 50%; /* Position the title 50% from the left of the slide */
      transform: translate(-50%, -50%); /* Center the title within the slide */
      text-align: center; /* Center the text horizontally */
      width: 70%; /* Make the title take the full width of the slide */
      background:#1e243617;
      padding:10px;
      transition: opacity 0.5s ease;
      border-radius:10px 80px 0px 87px;
    }

    
    @media (max-width:768px)
    {
      .slide h1 {
        font-size: 30px; 
      }
      .sliderdesc{
        font-size: 15px;
      }
    }

    .sliderdesc{
      margin-top:10px;
      text-wrap:wrap;
      font-size: 20px;
      color: #fff;
      font-weight: 300;
      margin-bottom: 20px;

    }




    .slider .slick-arrow {
      font-size: 0; 
      color: #fff;
      background-color: rgba(0, 0, 0, 0.5);
      /* border-radius: 50%; */
      width: 40px;
      height: 40px;
      text-align: center;
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      z-index: 1;
    }

    .slider .slick-arrow:hover {
      background:rgb(10 15 36);
    }

    .slider .slick-prev {
      left: 10px;
    }

    .slider .slick-next {
      right: 10px;
    }

    /* Hide default slick dots */
    .slick-dots {
      display: none;
    }

    .slider img {
      max-width: 100%;
      max-height: 100%;
      object-fit:cover;
    }
    .slick-list{
      background:#070d23;
    }
    /* .slick-slide{
      height:90% !important;
    } */
 
  </style>
 
  <!-- Favicons -->
  <!-- <link href="<?php //echo base_url();?>/assets/img/favicon.png" rel="icon"> -->
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
  <style type="text/css">    
    .mySlides {display: none;}
    .pimage0{display:block;}
    #websiteLogo{
    width: auto;
    height: 35px;
    background: #f6f7fd;
    padding: 5px;
    padding-right: 50px;
    border-radius: 40px 0 40px 0;
    font-family: fantasy;
    color: #060c22;
    padding-left: 50px;
    }

    #websiteLogoImg{
    width: auto;
    height: auto;
    background: #f6f7fd;
    padding: 5px;
    padding-right: 50px;
    border-radius: 40px 0 40px 0;
    font-family: fantasy;
    color: #060c22;
    padding-left: 50px;
    }

  </style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
  
</head>

<body>

  <!--==========================
    Header
  ============================-->
  <header id="header">
    <div class="container">
      <div id="logo" class="pull-left">        
        <a href="#intro" class="scrollto">
          
          <?php if($logo_img=="" && $logo_name=="" ){ ?>
            <div id="websiteLogo"> <?php echo $website; ?> </div>
          <?php }else if($logo_img !=""){ ?>
            <div id="websiteLogoImg"><img src="<?php echo $logo_img_path;?><?php echo $logo_img; ?>" alt="<?php echo $website; ?>" title="<?php echo $website; ?>" style="max-width:125px; max-height:40px;"/></div>
          <?php }else{ ?>
            <div id="websiteLogo"> <?php echo $logo_name; ?> </div>
            <?php } ?>
        </a>
      </div>
      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="#intro">Home</a></li>
          <!-- <li><a href="#about"></a></li> -->
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
                <li><a href="#hotels">Services</a></li>
              <?php 
            } 
            if(count($product_details)>0)
            {
              ?>
              <li><a href="#speakers">Products</a></li>
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

          <li><a href="<?php echo $login_url; ?>" target="_blank">Website login</a></li>         
          <li>
            <a href="javascript:void(0);" data-toggle="modal" data-target="#searchModal"> 
              <img src="./assets/img/search.png" style="width:30px;cursor: pointer;">
            </a>
          </li>
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->

  <!--==========================
    Intro Section
  ============================-->
  <section id="introo" style="height:auto !important">
    <?php 
      if(count($slider_image)>0)
      { 
        ?>
        <div class="slider">
          <?php 
          foreach ($slider_image as $key => $sliderData) 
          { ?>
            <div class="slide">
              <img src="<?php echo $image_path . $sliderData['slider_image']; ?>" alt="<?php echo $website; ?>"/>
              <?php if($sliderData['slider_title']){ ?>
                <h1>
                  <?php echo $sliderData['slider_title']; ?>
                  <?php if($sliderData['slider_desc']){ ?>
                    <p class="sliderdesc"><?php echo $sliderData['slider_desc']; ?></p>
                  <?php } ?>   
                  <?php if($sliderData['slider_link']){ ?>
                    <a target="_blank" href="<?php echo $sliderData['slider_link']; ?>"><button type="button" class="btn btn-default">View More</button></a>
                  <?php } ?>   
                </h1> 
              <?php } ?>                            
            </div>                       
          <?php }
          ?>
        </div>
        <button class="slick-arrow slick-prev" aria-label=""><i class="fas fa-chevron-left"></i></button>
        <button class="slick-arrow slick-next" aria-label=""><i class="fas fa-chevron-right"></i></button>

        <?php 
      }else{ ?>
        <img src="assets/img/stars-g5c8268e1e_1920.jpg" style="width:100%; height:100%;">
       
        <!-- <video autoplay muted loop id="myVideo">
          <source src="assets/img/particle_-_5189 (720p).mp4" type="video/mp4">
        </video> -->

        <?php 
      } ?>
    <div class="intro-container wow fadeIn"></div>
   
  </section>




  <main id="main">
    <!--==========================
      About Section
    ============================-->
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

    <section id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-3">
             <a  href="javascript:void(0);" data-toggle="modal" data-target="#imagemyModal">
              <?php 
                 if(isset($contact_details[0]['website_image']))
                 {
                    $image = $contact_details[0]['website_image'];
                 }
                 else{
                  $image = ($profile_image!='')?$profile_image:'user_profile/default.png';
                 }          
              echo '<img align="left" style="width:165px;height:180px;border-radius: 56px 12px;"src="'.$path_url.$image.'"/>'; 
              ?>
            </a>
          </div>           
          <div class="col-lg-6">
     
            <h2>About Us 
      </h2>
      <!-- follow like view button code starts here-->
      <?php if($websitename !=''){ ?>
        <p>
          <button type="button" class="btn btn-primary" onclick="flvwebsite('<?php echo $websitename; ?>','follow');">
            Follows <span class="badge badge-light" id="totalfollow"><?php echo $total_follows;?></span>
          </button>
          <button type="button" class="btn btn-secondary" onclick="flvwebsite('<?php echo $websitename; ?>','like');">
            Like <span class="badge badge-light" id="totallike"><?php echo $total_likes;?></span>
          </button>
          <button type="button" class="btn btn-primary" >
            View <span class="badge badge-light" id="totalview"><?php echo $total_views;?></span>
            <input type="hidden" id="viewweb" name="" value="<?php echo $website; ?>">
          </button>
        </p>
      <?php } ?>
      <!-- follow like view button code ends here-->
      
            <?php
              $about_us=(isset($contact_details[0]['about_website']))?$contact_details[0]['about_website']:'Welcome to mysite';
            ?>
            <p><?php echo $about_us; ?></p>
          </div>
        </div>
      </div>
    </section>

    
     <!--==========================
      Service Section
    ============================-->
    <?php
      if(count($all_details)>0){
      foreach ($all_details as $key => $value) 
      {
        ?>
        <section id="<?php echo $key;?>" class="section-with-bg wow fadeInUp">
          <div class="container">
            <div class="section-header">
              <h2><?php echo $key;?></h2>

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
         
          <!-- Modal -->
          <div class="modal fade" id="myModal_section" role="dialog">
            <div class="modal-dialog  modal-lg">          
              <!-- Modal content-->
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

          <div class="row">
            <?php
           
              foreach ($all_details[$key] as $child_key => $child_value) {

                $name = "'".$child_value['section_name']."'";
                $view_type = "'".$child_value['section_view']."'";
                $image = "'".$child_value['preview_file']."'";
                $desc = "'".$child_value['description']."'";
                $service_id = "'".$child_value['section_item_id']."'";
                $weblink = "'".$child_value['file_name']."'";
                $media_type =$child_value['media_type'];
                $web_url = "'".$child_value['website_link']."'";
                $sectionItem_url=$sectionItem_path."/".$key."/".$child_value['section_item_id']; //sectionItem URL
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
                    <!--==========================
                     Grid View
                    ============================-->
                  <?php 
                    if($child_value['section_view'] ==1) { ?>
                      <div class="col-lg-3 col-md-3">
                        <div class="hotel">
                          <div class="hotel-img">                   
                            <?php 
                            echo '<a href="'.$sectionItem_url.'" onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.','.$web_url.')"><img src="'.$path.'" class="img-fluid" style="width:100%;height: 50%;"></a>'
                            ?>
                          </div>
                          <h3 style="font-size: 20px; margin-top: 10px;"><?php echo $child_value['title'];?></h3>              
                          <!-- <p><?php echo $child_value['description'];?></p> -->
                          <!--<p><?php //echo $web_url;?></p>-->
                          <p style="margin-bottom: 5px;"><a href=<?php echo "https://".$child_value['website_link']; ?> target='_blank'>Website Link</a></p>
                          <div class="image-container"  style="width:52%;">
                              <img src="./assets/img/eye-open.png" id="" style="width:60px;cursor: pointer;">
                              <span id=""><?php echo $child_value['views']; ?></span>
                              <img src="./assets/img/thumbs-up-circle-blue-512.png" id="likeservice1" style="width:22px;cursor: pointer;" onclick="likeServicesection(<?php echo $name;?>,<?php echo $child_value['section_item_id'];?>)">
                              <input type="hidden" value="<?php echo $child_value['section_item_id']; ?>" id="service_id<?php echo $child_value['section_item_id']; ?>">
                              <span id="likeservicecount<?php echo $child_value['section_item_id'];?>"><?php echo $child_value['likes']; ?></span>
                          </div>
                        </div>
                      </div>
                  <?php 
                  }?>
                   <!--==========================
                     List View
                    ============================-->
                 <?php 
                  if($child_value['section_view'] ==2) { ?>
                    <div class="col-lg-6 col-md-6 mb-5">
                      <div class="hotel">
                        <div class="hotel-img col-lg-6 col-md-6 float-left">                   
                          <?php 
                          echo '<a href="'.$sectionItem_url.'" onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.','.$web_url.')"><img src="'.$path.'" class="img-fluid" style="width:100%;height: 100%;"></a>'
                          ?>
                        </div>
                        <div class="hotel-img col-lg-6 col-md-6 float-left"> 
                            <h3 style="font-size: 20px; margin-top: 10px;"><?php echo $child_value['title'];?></h3>              
                            <!-- <p><?php echo $child_value['description'];?></p> -->
                            <!--<p><?php //echo $web_url;?></p>-->
                            <p style="margin-bottom: 5px;"><a href=<?php echo "https://".$child_value['website_link']; ?> target='_blank'>Website Link</a></p>
                            
                            <!-- Social Icon section-->
                            <div class="image-container"  >
                            <img src="./assets/img/eye-open.png" id="" style="width:60px;cursor: pointer;">
                            <span id=""><?php echo $child_value['views']; ?></span>
                            <img src="./assets/img/thumbs-up-circle-blue-512.png" id="likeservice1" style="width:22px;cursor: pointer;" onclick="likeServicesection(<?php echo $name;?>,<?php echo $child_value['section_item_id'];?>)">
                            <input type="hidden" value="<?php echo $child_value['section_item_id']; ?>" id="service_id<?php echo $child_value['section_item_id']; ?>">
                            <span id="likeservicecount<?php echo $child_value['section_item_id'];?>"><?php echo $child_value['likes']; ?></span>
                        </div>
                        </div>

                        
                      </div>
                    </div>
                    <?php 
                  }?>
                   <!--==========================
                     Image left View
                    ============================-->
                <?php 
                  if($child_value['section_view'] ==3) { ?>
                   <div class="col-lg-12 col-md-12 mb-5">
                      <div class="hotel">
                        <div class="hotel-img col-lg-6 col-md-6 float-left">                   
                          <?php 
                          echo '<a href="'.$sectionItem_url.'" onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.','.$web_url.')"><img src="'.$path.'" class="img-fluid" style="width:100%;height: 100%;"></a>'
                          ?>
                        </div>
                        <div class="hotel-img col-lg-6 col-md-6 float-left"> 
                            <h3 style="font-size: 20px; margin-top: 10px;"><?php echo $child_value['title'];?></h3>              
                            <!-- <p><?php echo $child_value['description'];?></p> -->
                            <!--<p><?php //echo $web_url;?></p>-->
                            <p style="margin-bottom: 5px;"><a href=<?php echo "https://".$child_value['website_link']; ?> target='_blank'>Website Link</a></p>
                            
                            <!-- Social Icon section-->
                            <div class="image-container"  style="margin-top:27%;">
                            <img src="./assets/img/eye-open.png" id="" style="width:60px;cursor: pointer;">
                            <span id=""><?php echo $child_value['views']; ?></span>
                            <img src="./assets/img/thumbs-up-circle-blue-512.png" id="likeservice1" style="width:22px;cursor: pointer;" onclick="likeServicesection(<?php echo $name;?>,<?php echo $child_value['section_item_id'];?>)">
                            <input type="hidden" value="<?php echo $child_value['section_item_id']; ?>" id="service_id<?php echo $child_value['section_item_id']; ?>">
                            <span id="likeservicecount<?php echo $child_value['section_item_id'];?>"><?php echo $child_value['likes']; ?></span>
                        </div>
                        </div>                        
                      </div>
                    </div>
                <?php 
                  }?>
                  <!--==========================
                     Image right View
                    ============================-->
                <?php 
                  if($child_value['section_view'] ==4) { ?>
                   <div class="col-lg-12 col-md-12 mb-5">
                      <div class="hotel">                        
                        <div class="hotel-img col-lg-6 col-md-6 float-left"> 
                            <h3 style="font-size: 20px; margin-top: 10px;"><?php echo $child_value['title'];?></h3>              
                            <!-- <p><?php echo $child_value['description'];?></p> -->
                            <!--<p><?php //echo $web_url;?></p>-->
                            <p style="margin-bottom: 5px;"><a href=<?php echo "https://".$child_value['website_link']; ?> target='_blank'>Website Link</a></p>
                            
                            <!-- Social Icon section-->
                            <div class="image-container"  style="margin-top:27%;">
                                <img src="./assets/img/eye-open.png" id="" style="width:60px;cursor: pointer;">
                                <span id=""><?php echo $child_value['views']; ?></span>
                                <img src="./assets/img/thumbs-up-circle-blue-512.png" id="likeservice1" style="width:22px;cursor: pointer;" onclick="likeServicesection(<?php echo $name;?>,<?php echo $child_value['section_item_id'];?>)">
                                <input type="hidden" value="<?php echo $child_value['section_item_id']; ?>" id="service_id<?php echo $child_value['section_item_id']; ?>">
                                <span id="likeservicecount<?php echo $child_value['section_item_id'];?>"><?php echo $child_value['likes']; ?></span>
                            </div>
                        </div>   
                        <div class="hotel-img col-lg-6 col-md-6 float-left">                   
                          <?php 
                          echo '<a href="'.$sectionItem_url.'" onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.','.$web_url.')"><img src="'.$path.'" class="img-fluid" style="width:100%;height: 100%;"></a>'
                          ?>
                        </div>                     
                      </div>
                    </div>
                <?php 
                  }?>  

               <?php   
              } 
            ?>
          </div>
           </div>
      </section>
        <?php 
      } 
    }
    ?>




    <!--==========================
      Service Section
    ============================-->
    <?php if(count($service_details)>0){?>
      <section id="hotels" class="section-with-bg wow fadeInUp">
        <div class="container">
           <div class="section-header">
            <h2>My Service</h2>
            <!-- Modal -->
            <div class="modal fade" id="myModal2" role="dialog">
              <div class="modal-dialog  modal-lg">          
                <!-- Modal content-->
                <div class="modal-content">           
                  <div class="modal-header">
                  <h4 class="modal-title" id="mtitle2"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>               
                  </div>
                  <div class="modal-body" id="mimage2">                
                  </div>
                  <div class="modal-footer tesdt" id="desc2" style="display: block;">
                    <div class="image-container"  style="width:52%;">
                      <img src="./assets/img/eye-open.png" id="viewservice" style="width:60px;cursor: pointer;">
                      <span id="viewservicecount"></span>
                      <img src="./assets/img/thumbs-up-circle-blue-512.png" id="likeservice" style="width:22px;cursor: pointer;">
                      <span id="likeservicecount"></span>
                    </div>
                  </div>
                </div>            
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
                  $service_id = "'".$service_details[$j]['id']."'";
                  $weblink = "'".$service_details[$j]['weblink']."'";

                 if($service_details[$j]['type']==1){
                  $path = $path_url."videosection/video.png";
                 }else{
                  $path = $path_url.$service_details[$j]['service_image'];
                 }
                  ?>
                  <div class="col-lg-3 col-md-3">
                    <div class="hotel">
                      <div class="hotel-img">
                       <?php 
                          echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal2" onclick="servicepopupimage('.$name.','.$image.','.$desc.','.$service_id.','.$weblink.','.$service_details[$j]['type'].')"><img src="'.$path.'" class="img-fluid"></a>'; 
                        ?>
                      </div>
                      <h3><?php echo $service_details[$j]['service_name'];?></h3>              
                      <p><?php echo $service_details[$j]['desc'];?></p>
                      <p>
                        <?php
                          if($service_details[$j]['weblink']!=""){
                            echo "<p><a href='".$service_details[$j]['weblink']."' target='_blank'>Website Link</a></p>"; 
                          }
                          ?>
                       </p>
                      <div class="image-container"  style="width:52%;">
                        <img src="./assets/img/eye-open.png" id="" style="width:60px;cursor: pointer;">
                        <span id=""><?php echo $service_details[$j]['views']; ?></span>
                        <img src="./assets/img/thumbs-up-circle-blue-512.png" id="likeservice1" style="width:22px;cursor: pointer;" onclick="likeService(<?php echo $service_details[$j]['id'];?>)">
                        <input type="hidden" value="<?php echo $service_details[$j]['id']; ?>" id="service_id<?php echo $service_details[$j]['id']; ?>">
                        <span id="likeservicecount<?php echo $service_details[$j]['id'];?>"><?php echo $service_details[$j]['likes']; ?></span>
                      </div>
                    </div>
                  </div>
                  <?php 
                } 
              ?>
            </div>
        </div>
      </section>
    <?php } ?>
  
    <!--==========================
      Speakers Section
    ============================-->
    <?php if(count($product_details)>0) {?>
      <section id="speakers" class="wow fadeInUp">
        <div class="container">
          <div class="section-header">
            <h2>Products</h2>
            <p>Various Products</p>
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
                            
                </div>
                <div class="modal-footer" id="mfooter" style="display: block;">
                  <img src="./assets/img/eye-open.png" id="viewT" style="width:60px;cursor: pointer;">
                  <span id="viewcount"></span>
                  <img src="./assets/img/thumbs-up-circle-blue-512.png" id="likesT" style="width:22px;cursor: pointer;">
                  <span id="likecount"></span>
                 <!--  <i class="glyphicon glyphicon-plus"></i> -->
                  <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                </div>
              </div>            
            </div>
          </div>
          <div class="row">
            <?php
            if(count($product_details)>0)
            {
              //echo "<pre>"; print_r($product_details); 
                for($i=0;$i<count($product_details);$i++)
                  { 
                    //echo $product_details[$i]['product_image'];
                    $name = "'".$product_details[$i]['product_name']."'";
                    $cname = "'".$product_details[$i]['category_name']."'";
                    $scname = "'".$product_details[$i]['sub_category_name']."'";
                    $product_image = "'".$path_url.$product_details[$i]['product_image']."'";
                    $price = "'".$product_details[$i]['currency'].$product_details[$i]['price']."'";
                    $total_likes="'".$product_details[$i]['total_likes']."'";
                    $total_views = "'".$product_details[$i]['total_views']."'";
                    $prod_desc = "'".$product_details[$i]['long_desc']."'";
                    $prod_short_desc = "'".$product_details[$i]['short_desc']."'";
                    ?>
                      <div class="col-lg-4 col-md-4">
                        <div class="speaker" style="height: 200px;">
                          <input type="hidden" id="product_id" value="<?php echo $product_details[$i]['id'];?>">
                         <?php 
                            echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" onclick="popupimage('.$prod_desc.','.$prod_short_desc.','.$name.','.$product_image.',
                            '.$cname.',
                            '.$scname.',
                            '.$price.',
                            '.$total_likes.',
                            '.$total_views.',
                            '.$product_details[$i]['id'].'
                          )"><img src="'.$path_url.$product_details[$i]['product_image'].' " class="img-fluid"></a>'; 
                            ?>
                          <div class="details">
                            <h4>                          
                              <a href="javascript:void(0);">
                              <?php echo $product_details[$i]['product_name'];?></a>
                              <br><span style="color:white;font-size: 16px;">Category:<?php echo $product_details[$i]['category_name'];?></span>
                            </h4>
                            <p><?php echo $product_details[$i]['price']."(".$product_details[$i]['currency'].")";?></p> 
                            <div>
                                <img src="./assets/img/eye-open1.png" id="viewT" style="width:20px;cursor: pointer;">
                                <span id="viewcount" style="color: white;"><?php echo $product_details[$i]['total_views'];?></span>
                                <img src="./assets/img/thumbs-up-circle-blue-512.png" id="likesT1" style="width:20px;cursor: pointer;" onclick="likeProduct(<?php echo $product_details[$i]['id'];?>)">
                                <input type="hidden" value="<?php echo $product_details[$i]['id'];?>" id="product_id<?php echo $product_details[$i]['id'];?>">
                                <span id="likecount<?php echo $product_details[$i]['id'];?>" style="color: white;"><?php echo $product_details[$i]['total_likes'];?></span>
                            </div>              
                          </div>
                        </div>
                      </div>
                <?php } 
            } 
            ?>
              
          </div>
        </div>
      </section>
    <?php } ?>
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
            <div class="modal-footer" style="display: block;">
               <img src="./assets/img/eye-open.png" id="adview" style="width:60px;cursor: pointer;">
              <span id="adviewcount"></span>
              <img src="./assets/img/thumbs-up-circle-blue-512.png" id="adlikes" style="width:22px;cursor: pointer;">
              <span id="adlikecount"></span>
            </div>
          </div>            
        </div>
      </div>
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
            </div>
          </div>            
        </div>
      </div>
      <!--==========================
      Advertisement Section
    ============================-->  
    <?php if(count($ad_details)>0) {?>
      <section id="hotels" class="section-with-bg wow fadeInUp">
        <div class="container">
          <div class="section-header">
            <h2>My Advertisements</h2>
          </div>
          <div class="row">
            <?php 
              for($k=0;$k<count($ad_details);$k++)
              {
                $name = "";
                $image = "'".$path_url.$ad_details[$k]['uploads']."'";
                ?>
                <div class="col-lg-3 col-md-3">
                  <div class="hotel">
                    <div class="hotel-img">
                      <?php 
                        if($ad_details[$k]['ad_type']==1)
                        { 
                          echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal1" onclick="popupimage1('.$image.','.$ad_details[$k]['id'].')"><img src="'.$path_url.$ad_details[$k]['uploads'].' " class="img-fluid"></a>'; 
                        }
                        else{
                        echo '<video width="400" controls>
                            <source src="'.$path_url.$ad_details[$k]['uploads'].'" type="video/mp4">
                            </video>';
                        }
                      ?>
                    </div>
                    <?php 
                    if($ad_details[$k]['desc']!=""){
                      echo "<p>".$ad_details[$k]['desc']."</p>"; 
                    }
                    if($ad_details[$k]['weblink']!=""){
                        $link_var = "https://".$ad_details[$k]['weblink'];
                      echo "<p><a href='".$link_var."' target='_blank'>Website Link</a></p>"; 
                    }
                    ?>
                    <div class="image-container"  style="width:52%;">
                      <img src="./assets/img/eye-open.png" id="" style="width:60px;cursor: pointer;">
                      <span id=""><?php echo $ad_details[$k]['views']; ?></span>
                      <img src="./assets/img/thumbs-up-circle-blue-512.png" id="likeservice1" style="width:22px;cursor: pointer;" onclick="likeAd(<?php echo $ad_details[$k]['id'];?>)">
                      <input type="hidden" value="<?php echo $ad_details[$k]['id']; ?>" id="adv_id<?php echo $ad_details[$k]['id']; ?>">
                      <span id="adlikecount<?php echo $ad_details[$k]['id'];?>"><?php echo $ad_details[$k]['likes']; ?></span>
                    </div>
                  </div>
                </div>
                <?php 
              } ?>
          </div>
        </div>
      </section>
  <?php } if(count($album_details)>0){ ?>
     <section id="speakers" class="wow fadeInUp">
        <div class="container">
          <div class="section-header">
            <h2>My Album</h2>
          </div>
          <div class="row">
            <?php 
              for($m=0;$m<count($album_details);$m++)
              {
                $name = "";
                $image = "'".$path_url.$album_details[$m]['album_image']."'";
                ?>
                <div class="col-lg-3 col-md-3">      
                  <div class="hotel">
                    <div class="hotel-img">
                      <a href="<?php echo base_url('album/'.$album_details[$m]['album_code']); ?>" >
                        <img src="<?php echo $path_url.$album_details[$m]['album_image']?> " class="img-fluid">
                      </a>
                    </div>
                    <?php 
                      if($album_details[$m]['about']!=""){
                        echo "<p>".$album_details[$m]['about']."</p>"; 
                      }
                    ?>
                  </div>
                </div>
                <?php 
              } 
            ?>
          </div>
        </div>
    </section>
  <?php } if(count($myvideo_det)>0){?>
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
                      ?>
                    </div>
                    <?php 
                      if($myvideo_det[$mv]['description']!=""){
                        echo "<p>".$myvideo_det[$mv]['description']."</p>"; 
                      }       
                    ?>
                  </div>
                </div>
                <?php 
              } ?>
          </div>
      </div>
    </section>
  <?php } ?>
   
  </div>
  </main>

    <?php if(count($channel_array)>0){ ?>
    <section id="videosection1" class="section-with-bg wow fadeInUp">

<div class="container">
  <div class="section-header">
    <h2>My Channel</h2>
    
  </div>

  <div class="row">
    <?php 

    for($mv=0;$mv<count($channel_array);$mv++)
    {
      $group_name = $channel_array[$mv]['group_name'];
      $group_code = $channel_array[$mv]['group_code'];
      $count_mem = $channel_array[$mv]['count_mem'];
      $image = $path_url.$channel_array[$mv]['imagename'];
    ?>
    <div class="col-lg-3 col-md-3">

      <div class="hotel">
  <div class="hotel-img">
  <?php echo '<img src="'.$image.'" class="img-fluid">'; ?>
   
  </div>
  <!-- <h3><?php //echo $ad_details[$k]['service_name'];?></h3>-->
  <?php 
  if($group_name!=""){
    echo "<p>Group Name : ".$group_name."</p>"; 
  }
  if($count_mem!=""){
    ?>
    <img src="./assets/img/eye-open.png" id="" style="width:60px;cursor: pointer;">
                  
                  <?php
    echo "<span>".$count_mem."</span>"; 
  }
  ?>
 
</div>

    </div>
  <?php } ?>


  </div>
</div>

</section>
<?php } ?>
<?php if(count($group_array)>0){ ?>
<section id="videosection2" class="section-with-bg wow fadeInUp">

<div class="container">
  <div class="section-header">
    <h2>My Group</h2>
    
  </div>

  <div class="row">
    <?php 

    for($mv=0;$mv<count($group_array);$mv++)
    {
      $group_name = $group_array[$mv]['group_name'];
      $group_code = $group_array[$mv]['group_code'];
      $count_mem = $group_array[$mv]['count_mem'];
      $image = $path_url.$group_array[$mv]['imagename'];
    ?>
    <div class="col-lg-3 col-md-3">

      <div class="hotel">
  <div class="hotel-img">
  <a target="_blank" href="https://3ABC7.com/chat"><?php echo '<img src="'.$image.'" class="img-fluid">'; ?></a>
   
  </div>
  <!-- <h3><?php //echo $ad_details[$k]['service_name'];?></h3>-->
  <?php 
  if($group_name!=""){
    echo "<p>Group Name : ".$group_name."</p>"; 
  }
  if($count_mem!=""){
    ?>
    <img src="./assets/img/eye-open.png" id="" style="width:60px;cursor: pointer;">
                  
                  <?php
    echo "<span>".$count_mem."</span>"; 
  }
  ?>
 
</div>

    </div>
  <?php } ?>


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
        <section id="contact" class="section-bg wow fadeInUp">
          <div class="container">
            <div class="section-header">
              <h2>My Contact</h2>
              <p><?php echo $website;?></p>
            </div>
            <div class="row contact-info">
              <div class="col-md-3">
                <div class="contact-address">
                  <i class="ion-ios-location-outline"></i>
                    <h3>Address</h3>
                    <address>
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
                    </address>
                </div>
              </div>
              <?php 
                if(isset($contact_details[0]['phonenumber']) || isset($contact_details[0]['homenumber']) || isset($contact_details[0]['officenumber']) || isset($contact_details[0]['faxnumber'])){
                ?>
              <div class="col-md-3">
                <div class="contact-phone">
                  <i class="ion-ios-telephone-outline"></i>
                  <h3>Phone Number</h3>
                      <p>
                        <?php if(isset($contact_details[0]['phonenumber'])){
                            echo "Phone :".$contact_details[0]['phonenumber'];
                          } ?>                            
                      </p>
                    <p><?php if(isset($contact_details[0]['homenumber'])){
                      echo "Home :".$contact_details[0]['homenumber'];
                    } ?></p>
                    <p><?php if(isset($contact_details[0]['officenumber'])){
                      echo "Office :".$contact_details[0]['officenumber'];
                    } ?></p>
                    <p><?php if(isset($contact_details[0]['faxnumber'])){
                      echo "Fax :".$contact_details[0]['faxnumber'];
                    } ?></p>
                </div>
              </div>
            <?php }?>
              <div class="col-md-3">
                <div class="contact-email">
                  <i class="ion-ios-email-outline"></i>
                  <h3>Email</h3>
                  <p><a href="mailto:info@example.com">
                    <?php 
                     
                    if(isset($contact_details[0]['email'])&&($contact_details[0]['email']!=''))
                    {
                      echo $contact_details[0]['email']; 
                    }
                    else
                    {
                      echo $mail;
                    }
                     
                    ?></a></p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="contact-email">
                  <i class="ion-ios-email-outline"></i>
                  <h3>Social</h3>
                  <p><a target="_blank" href="<?php 
                      if(isset($contact_details[0]['fb'])){
                        echo $contact_details[0]['fb']; 
                      } ?>">Facebook
                    </a>
                  </p>
                  <!-- <p><a target="_blank" href="#">Twitter</a></p> -->
                  <p>
                    <a target="_blank" href="<?php
                       if(isset($contact_details[0]['linked'])){
                          echo $contact_details[0]['linked']; 
                        }
                      ?>">LinkedIn
                    </a>
                  </p>
                  <p>
                    <?php if(isset($contact_details[0]['whatsapp'])){
                      echo "Whatsapp :".$contact_details[0]['whatsapp'];
                    } ?>                    
                  </p>
                  <p>
                      <?php if(isset($contact_details[0]['telegram'])){
                      echo "Telegram :".$contact_details[0]['telegram'];
                    } ?>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </section><!-- #contact -->
        <?php 
      } 
    ?> 




  <!--==========================
    Footer
  ============================-->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">
        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong>3ABC7</strong>. All Rights Reserved
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.slider').slick({
        autoplay: true,
        autoplaySpeed: 3000, // Change slide every 3 seconds (adjust as needed)
        arrows: true, // Show navigation arrows
        dots: false,  // Hide navigation dots
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1
      });

      $('.slider-prev').on('click', function() {
        $('.slider').slick('slickPrev');
      });

      $('.slider-next').on('click', function() {
        $('.slider').slick('slickNext');
      });

    });

  </script>


  <!-- Template Main Javascript File -->
  <script src="<?php echo base_url();?>/assets/js/main.js"></script>
  <script>
    $(document).ready(function(){
     // $("#totalview").click(function(){
        var web = $('#viewweb').val();
        //alert(web);
         $.ajax({
          type:'POST',
          url:'<?php echo base_url("index.php/website/addwebsitefollow"); ?>',
          data:{'website':web,'type':'views'},
           dataType:"JSON",                
          success:function(data){                 
              $('#totalview').html(data.totalviews);
          }
        });
     // })
      
    });


    $("#likesT").click(function() {      
      var id = $('#product_id1').val();
        $.ajax({
          type:'POST',
          url:'<?php echo base_url("index.php/website/updateproductmaster"); ?>',
          data:{'id':id,'field':'like'},
          dataType:"JSON",                
          success:function(data){                 
              $('#likecount').html(data.total_likes);
          }
        });
    });

   function likeProduct(id)
   {
      var id = $('#product_id'+id).val();
       $.ajax({
          type:'POST',
          url:'<?php echo base_url("index.php/website/updateproductmaster"); ?>',
          data:{'id':id,'field':'like'},
          dataType:"JSON",                
          success:function(data){                 
              $('#likecount'+id).html(data.total_likes);
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
   function likeService(id)
   {
      var id = $('#service_id'+id).val();
         $.ajax({
            type:'POST',
            url:'<?php echo base_url("index.php/website/updateservicemaster"); ?>',
            data:{'id':id,'field':'like'},
            dataType:"JSON",                
            success:function(data){                 
                $('#likeservicecount'+id).html(data.total_likes);
            }
        });
   }
   function likeAd(id)
   {
      var id = $('#adv_id'+id).val();
         $.ajax({
                type:'POST',
                url:'<?php echo base_url("index.php/website/updateadmaster"); ?>',
                data:{'id':id,'field':'like'},
                dataType:"JSON",                
                success:function(data){                 
                    $('#adlikecount'+id).html(data.total_likes);
                }
            });
   }
  
    $("#likeservice").click(function() {      
      var id = $('#service_id').val();
         $.ajax({
                type:'POST',
                url:'<?php echo base_url("index.php/website/updateservicemaster"); ?>',
                data:{'id':id,'field':'like'},
                dataType:"JSON",                
                success:function(data){                 
                    $('#likeservicecount').html(data.total_likes);
                }
            });
    });
   
    $("#adlikes").click(function() {      
      var id = $('#adv_id').val();
         $.ajax({
                type:'POST',
                url:'<?php echo base_url("index.php/website/updateadmaster"); ?>',
                data:{'id':id,'field':'like'},
                dataType:"JSON",                
                success:function(data){                 
                    $('#adlikecount').html(data.total_likes);
                }
            });
    });
  function servicepopupimage_section(name,image,desc,update_id,weblink,type,src_file,web_url)
  {
    $('#mtitle2_section').html(name);
      
      if(type==2)
      {
        $('#mimage2_section').html('<video width="400" controls><source src="'+image+'" type="video/mp4"></video>'); 
      }
      else if(type==1 || type==3 || type==4){
        $('#mimage2_section').html('<img src="'+src_file+'" width="400" style="display: block; margin-left: auto; margin-right: auto;">');
      }else{
        $('#mimage2_section').html('<audio width="400" controls><source src="'+image+'" type="audio/mpeg"></audio>');
      }
      
      var Websiteurl="https://"+web_url;
      $('#desc2_section').html('<div class="description">"'+desc+'"</div><input type="hidden" value="'+update_id+'" id="service_id"><br><div><a href="'+image+'" target="_blank">Click here to view</a></div><br><div><a href="'+Websiteurl+'" target="_blank"><b>Website Link</b></a></div>');

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
      function videopreviewimage(video,id){
        
      $('#videoimage').html('<video width="400"  controls><source src="'+video+'" type="video/mp4"></video><input type="hidden" value="'+id+'" id="adv_id">');
    }
     function popupimage1(image,ad_id){
      $('#mimage1').html('<img src="'+image+'" width="400" ><input type="hidden" value="'+ad_id+'" id="adv_id">');
      var id = ad_id;
       $.ajax({
          type:'POST',
          url:'<?php echo base_url("index.php/website/updateadmaster"); ?>',
          data:{'id':id,'field':'view'},
           dataType:"JSON",                
          success:function(data){                 
              $('#adviewcount').html(data.total_views);
          }
      });
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
  </script>
</body>

</html>
