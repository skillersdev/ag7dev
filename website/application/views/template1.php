<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo"<pre>"; print_r($myvideo_det);die;
//echo "<pre>";print_r($album_details);die;
$this->load->view('index.html');
$path_url = $this->config->item('path_url');

$login_url = $this->config->item('login_url');
$image_path = $this->config->item('base_path');

$last_slider_image = end($slider_image);

//    for($ct=0;$ct<count($contac_log_result);$ct++)
//     {
//       echo $contac_log_result[$ct]['image_name'];
//     }
// die;
//print_r($last_slider_image['slider_image']);die;
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
  <style type="text/css">
    
    .mySlides {display: none;}
.pimage0{display:block;}
  </style>

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
        <a href="#intro" class="scrollto">
          <img src="<?php echo base_url();?>/assets/img/logo.png" alt="" title=""></a>
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="#intro">Home</a></li>
          <li><a href="#about"></a></li>
          <li><a href="#contact">My Contact</a></li>
          <li><a href="#hotels">My Services</a></li>
          <li><a href="#speakers">My Products</a></li>
          <li><a href="#videosection">My videos</a></li> 
          <li><a href="<?php echo $login_url; ?>" target="_blank">Website login</a></li>         
         <li>
            <a href="javascript:void(0);" data-toggle="modal" data-target="#searchModal"> 
              <img src="./assets/img/search.png" style="width:30px;cursor: pointer;">
            </a>
          </li>
          <!-- <li><a href="#sponsors">Clients</a></li> -->
          
         
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- #header -->

  <!--==========================
    Intro Section
  ============================-->

  <section id="introo" style="height:auto !important">
      <?php 
  if(count($slider_image)>0){ 
    ?>
    <img src="<?php echo $image_path.$last_slider_image['slider_image']; ?>" style="width:100%;">
  <?php }else{?>
     <img src="assets/img/intro-bg.jpg" style="width:100%;">
  <?php } ?>
    <div class="intro-container wow fadeIn">
      <!-- <h1 class="mb-4 pb-0">The Global<br><span>Service</span> Provide</h1>
      <p class="mb-4 pb-0">Expert in software development and staffing</p> -->
      
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
    <!-- Modal body -->
    <div class="modal" id="imagemyModal">
        <div class="modal-dialog">
          <div class="modal-content">
          <div class="modal-body">             
            <div class="form-group m-b-0">
                <div class="slideshow-container"> 
                  <?php
                    for($ct=0;$ct<count($contac_log_result);$ct++)
                    {?>
                      <div id="pimage<?php echo $ct;?>"  class="mySlides pimage<?php echo $ct;?>">
                        <img src="<?php echo  $image_path.$contac_log_result[$ct]['image_name'];?>" style="width:80%; height: 400px;">
                      </div>
                   <?php
                      //echo $contac_log_result[$ct]['image_name'];
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
                      //echo $contac_log_result[$ct]['image_name'];
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
         //echo "<pre>";print_r($contact_details);
         //die;
         if(isset($contact_details[0]['website_image']))
         {
            $image = $contact_details[0]['website_image'];
         }
         else{
          $image = ($profile_image!='')?$profile_image:'user_profile/default.png';
         }
          
        echo '<img align="left" style="width:165px;height:180px;"src="'.$path_url.$image.'"/>'; 
        ?>
      </a>
      </div>           
      <div class="col-lg-6">
       <h2>About Me</h2>
        <?php
$about_us=(isset($contact_details[0]['about_website']))?$contact_details[0]['about_website']:'Welcome to mysite';

            ?>
            <p>
              <?php echo $about_us; ?>
            </p>
          </div>

         <!--  <div class="col-lg-3">
            <h3>Address</h3>
            <?php 
            //$address =($address!='')?$address:'A108 Adam Street, NY 535022, USA';
            ?>

            <p><?php //echo $address;?></p>
      			 <p><?php //echo $mobile;?>,<br>042-898979989</p>
          </div> -->
          
        </div>
      </div>
    </section>

    <!--==========================
      Contact Section
    ============================-->
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

          <div class="col-md-3">
            <div class="contact-phone">
              <i class="ion-ios-telephone-outline"></i>
              <h3>Phone Number</h3>
              <!--<p><a href="tel:+155895548855"><?php //echo $mobile;?></a></p>-->
              <p><?php if(isset($contact_details[0]['phonenumber'])){
              echo "Phone :".$contact_details[0]['phonenumber'];
            } ?></p>
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
              } ?>">Facebook</a></p>
        <p><a target="_blank" href="#">Twitter</a></p>
        <p><a target="_blank" href="<?php
         if(isset($contact_details[0]['linked'])){
                echo $contact_details[0]['linked']; 
              }
         //echo $contact_details[0]['linked']; 

         ?>">LinkedIn</a></p>
        
        <p><?php if(isset($contact_details[0]['whatsapp'])){
          echo "Whatsapp :".$contact_details[0]['whatsapp'];
        } ?></p>
        <p><?php if(isset($contact_details[0]['telegram'])){
          echo "Telegram :".$contact_details[0]['telegram'];
        } ?></p>
        
            </div>
          </div>

        </div>

        

      </div>
    </section><!-- #contact -->
    
    <!--==========================
      Service Section
    ============================-->
    <section id="hotels" class="section-with-bg wow fadeInUp">

      <div class="container">
        <div class="section-header">
          <h2>My Service</h2>

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
 
          ?>
          <div class="col-lg-3 col-md-3">
            <div class="hotel">
              <div class="hotel-img">
               <?php 
                  echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal2" onclick="servicepopupimage('.$name.','.$image.','.$desc.','.$service_id.','.$weblink.')"><img src="'.$path_url.$service_details[$j]['service_image'].' " class="img-fluid"></a>'; 
                ?>
              </div>
              <h3><?php echo $service_details[$j]['service_name'];?></h3>
              
              <p><?php echo $service_details[$j]['desc'];?></p>
                <div class="image-container"  style="width:52%;">
                  <img src="./assets/img/eye-open.png" id="" style="width:60px;cursor: pointer;">
                  <span id=""><?php echo $service_details[$j]['views']; ?></span>
                  <img src="./assets/img/thumbs-up-circle-blue-512.png" id="likeservice1" style="width:22px;cursor: pointer;" onclick="likeService(<?php echo $service_details[$j]['id'];?>)">
                  <input type="hidden" value="<?php echo $service_details[$j]['id']; ?>" id="service_id<?php echo $service_details[$j]['id']; ?>">
                  <span id="likeservicecount<?php echo $service_details[$j]['id'];?>"><?php echo $service_details[$j]['likes']; ?></span>
                </div>
            </div>
          </div>
        <?php } ?>
		  

        </div>
      </div>

    </section>
	
    <!--==========================
      Speakers Section
    ============================-->
    <section id="speakers" class="wow fadeInUp">
      <div class="container">
        <div class="section-header">
          <h2>My Products</h2>
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
                $price = "'".$product_details[$i]['currency'].' '.$product_details[$i]['price']."'";
                $total_likes=$product_details[$i]['total_likes'];
                $total_views = $product_details[$i]['total_views'];
                $prod_desc = "'".$product_details[$i]['desc']."'";
                $prod_short_desc = "'".$product_details[$i]['short_desc']."'";
                ?>
                  <div class="col-lg-3 col-md-3">
                    <div class="speaker">
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
                           <img src="./assets/img/eye-open1.png" id="viewT" style="width:32px;cursor: pointer;">
                          <span id="viewcount" style="color: white;"><?php echo $product_details[$i]['total_views'];?></span>
                        <img src="./assets/img/thumbs-up-circle-blue-512.png" id="likesT1" style="width:22px;cursor: pointer;" onclick="likeProduct(<?php echo $product_details[$i]['id'];?>)">
                        <input type="hidden" value="<?php echo $product_details[$i]['id'];?>" id="product_id<?php echo $product_details[$i]['id'];?>">
                        <span id="likecount<?php echo $product_details[$i]['id'];?>" style="color: white;"><?php echo $product_details[$i]['total_likes'];?></span>
                        </div>              
                      </div>
                    </div>
                  </div>
        <?php } 
        } else
        {?>
            <div class="col-lg-3 col-md-3">
            <div class="speaker">
             <!--  <img src="<?php echo base_url();?>/assets/img/speakers/1.jpeg" alt="Speaker 1" class="img-fluid"> -->
              <div class="details">
                <h4>No Products Found</h4>
                <p><?php //echo $product_details['price'];?></p>               
              </div>
            </div>
          </div>
          <?php }?>

		  
		
          
          
        </div>
      </div>

    </section>

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
                 <!-- <img src="./assets/img/eye-open.png" id="adview" style="width:60px;cursor: pointer;">
                <span id="adviewcount"></span>
                <img src="./assets/img/thumbs-up-circle-blue-512.png" id="adlikes" style="width:22px;cursor: pointer;">
                <span id="adlikecount"></span> -->
              </div>
            </div>            
          </div>
        </div>

      <!--==========================
      Advertisement Section
    ============================-->
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
						echo '<video width="280" height="200" controls>
								<source src="'.$path_url.$ad_details[$k]['uploads'].'" type="video/mp4">
							  </video>';
					  }
					?>
					<!-- <img src="http://localhost/ag7dev.git/trunk/api/'.$product_details[$i]['product_image'].' " alt="Hotel 1" class="img-fluid"style="height: 205px;"> -->
				</div>
				<!-- <h3><?php //echo $ad_details[$k]['service_name'];?></h3>-->
				<?php 
				if($ad_details[$k]['desc']!=""){
					echo "<p>".$ad_details[$k]['desc']."</p>"; 
				}
				if($ad_details[$k]['weblink']!=""){
					echo "<p><a href='".$ad_details[$k]['weblink']."' target='_blank'>Website Link</a></p>"; 
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
        <?php } ?>
		  

        </div>
      </div>

    </section>
	
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
            //print_r($image);die;
          ?>
          <div class="col-lg-3 col-md-3">      
            <div class="hotel">
              <div class="hotel-img">
                <a href="<?php echo base_url('album/'.$album_details[$m]['album_code']); ?>" >
                  <img src="<?php echo $path_url.$album_details[$m]['album_image']?> " class="img-fluid">
                </a>
                <?php
                    // echo '<a href="javascript:void(0);" id="albumId" onclick="galleryPhots('.$album_details[$m]['album_code'].')">
                    // <img src="'.$path_url.$album_details[$m]['album_image'].' " class="img-fluid"></a>'; 
                ?>
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
	

    
      </div>

    
    

  </main>


  <!--==========================
    Footer
  ============================-->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

        <!--   <div class="col-lg-6 col-md-6 footer-info">
            <img src="<?php echo base_url();?>/assets/img/logo.png" alt="TheEvenet">
            <p>In alias aperiam. Placeat tempore facere. Officiis voluptate ipsam vel eveniet est dolor et totam porro. Perspiciatis ad omnis fugit molestiae recusandae possimus. Aut consectetur id quis. In inventore consequatur ad voluptate cupiditate debitis accusamus repellat cumque.</p>
          </div> -->       

         

    <!--       <div class="col-lg-6 col-md-6 footer-contact">
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

          </div> -->

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong>Roodab</strong>. All Rights Reserved
      </div>
      <!-- <div class="credits">
       
        Designed by <a href="https://skillersglobalservice.com/">Skillers</a>
      </div> -->
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
  <script>
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
   // $("#likesT1").click(function() {      
   //    var id = $('#product_id2').val();
   //       $.ajax({
   //              type:'POST',
   //              url:'<?php //echo base_url("index.php/website/updateproductmaster"); ?>',
   //              data:{'id':id,'field':'like'},
   //              dataType:"JSON",                
   //              success:function(data){                 
   //                  $('#likecount1').html(data.total_likes);
   //              }
   //          });
   //  });
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
   function galleryPhots(albumcode)
   {
      window.open('http://www.smkproduction.eu5.org', '_blank');
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
    // $("#likeservice1").click(function() {      
    //   var id = $('#service_id1').val();
    //      $.ajax({
    //             type:'POST',
    //             url:'<?php //echo base_url("index.php/website/updateservicemaster"); ?>',
    //             data:{'id':id,'field':'like'},
    //             dataType:"JSON",                
    //             success:function(data){                 
    //                 $('#likeservicecount1').html(data.total_likes);
    //             }
    //         });
    // });

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
    
  function servicepopupimage(name,image,desc,service_id,weblink){
      
      $('#mtitle2').html(name);
      $('#mimage2').html('<img src="'+image+'" width="460px" height="400px">');
      $('#desc2').append('<div class="description">"'+desc+'"</div><input type="hidden" value="'+service_id+'" id="service_id"><br><div><b>WebLink</b>:'+weblink+'</div>');

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
      $('#mimage').html('<img src="'+image+'"  width="460px" height="400px"><input type="hidden" value="'+p_id+'" id="product_id1"><br><span><b>Description</b>: '+desc1+'</span><br><span><b>Short Description</b>: '+short_desc+'</span>');
      
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
        
      $('#videoimage').html('<video width="280" height="200" controls><source src="'+video+'" type="video/mp4"></video><input type="hidden" value="'+id+'" id="adv_id">');
    }
     function popupimage1(image,ad_id){
      $('#mimage1').html('<img src="'+image+'" width="460px" height="400px"><input type="hidden" value="'+ad_id+'" id="adv_id">');
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
