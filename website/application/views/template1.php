<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  $this->load->view('index.html');
  $path_url = $this->config->item('path_url');

  $login_url = $this->config->item('login_url');
  $image_path = $this->config->item('base_path');

  $last_slider_image = end($slider_image);
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Roodabatoz</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">
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
  </style>
 
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
        <a href="#intro" class="scrollto">
          <img src="<?php echo base_url();?>/assets/img/logo.png" alt="" title="">
        </a>
      </div>
      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="#intro">Home</a></li>
          <li><a href="#about"></a></li>
            <?php 
            if(count($contact_details)>0){ ?>
                <li><a href="#contact">My Contact</a></li>
                <?php 
            } 
            if(count($service_details)>0)
            {
              ?>
                <li><a href="#hotels">My Services</a></li>
              <?php 
            } 
            if(count($product_details)>0)
            {
              ?>
              <li><a href="#speakers">My Products</a></li>
              <?php 
            } if(count($myvideo_det)>0)
            {  ?>  
                <li><a href="#videosection">My videos</a></li>
               <?php
            }
            foreach ($all_details as $key => $value) 
            {
              ?>
            <li class=""><a href="#<?php echo $key;?>">
                <?php echo $key?>
              </a>
            </li>
         <?php } ?> 
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
        <img src="<?php echo $image_path.$last_slider_image['slider_image']; ?>" style="width:100%;">
        <?php 
      }else{ ?>
        <img src="assets/img/intro-bg.jpg" style="width:100%;">
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
                        <img src="<?php echo  $image_path.$contac_log_result[$ct]['image_name'];?>" style="width:80%; height: 400px;">
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
              echo '<img align="left" style="width:165px;height:180px;"src="'.$path_url.$image.'"/>'; 
              ?>
            </a>
          </div>           
          <div class="col-lg-6">
		 
            <h2>About Me 
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
              <inp
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
                      } ?>">Facebook
                    </a>
                  </p>
                  <p><a target="_blank" href="#">Twitter</a></p>
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
                    $prod_desc = "'".$product_details[$i]['long_desc']."'";
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
            } 
            else
            {?>
              <div class="col-lg-3 col-md-3">
                <div class="speaker">
                  <div class="details">
                    <h4>No Products Found</h4>
                    <p><?php //echo $product_details['price'];?></p>               
                  </div>
                </div>
              </div>
              <?php 
            }?>
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
    <!--==========================
      Service Section
    ============================-->
    <?php
      if(count($all_details)>0){}
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
                $image = "'".$child_value['preview_file']."'";
                $desc = "'".$child_value['description']."'";
                $service_id = "'".$child_value['section_item_id']."'";
                $weblink = "'".$child_value['file_name']."'";
                $media_type =$child_value['media_type'];

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
                <div class="col-lg-3 col-md-3">
                  <div class="hotel">
                    <div class="hotel-img">
                     <?php 
                       echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_section" onclick="servicepopupimage_section('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.')"><img src="'.$path.'" class="img-fluid" style="width:100%;"></a>'; 
                      ?>
                    </div>
                    <h3><?php echo $child_value['title'];?></h3>              
                    <p><?php echo $child_value['description'];?></p>
                    <p> <?php
                        // if($service_details[$j]['weblink']!=""){
                        //   echo "<p><a href='".$service_details[$j]['weblink']."' target='_blank'>Website Link</a></p>"; 
                        // }
                        ?>
                    </p>
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
              } 
            ?>
          </div>
           </div>
      </section>
        <?php 
      } 
    ?>
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
  <a target="_blank" href="https://roodabatoz.com/chat"><?php echo '<img src="'.$image.'" class="img-fluid">'; ?></a>
   
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
        &copy; Copyright <strong>Roodab</strong>. All Rights Reserved
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
  function servicepopupimage_section(name,image,desc,update_id,weblink,type,src_file)
  {
    $('#mtitle2_section').html(name);
      
      if(type==2)
      {
        $('#mimage2_section').html('<video width="400" controls><source src="'+image+'" type="video/mp4"></video>'); 
      }
      else if(type==1 || type==3 || type==4){
        $('#mimage2_section').html('<img src="'+src_file+'" width="400">');
      }else{
        $('#mimage2_section').html('<audio width="400" controls><source src="'+src_file+'" type="audio/mpeg"></audio>');
      }
      
      $('#desc2_section').html('<div class="description">"'+desc+'"</div><input type="hidden" value="'+update_id+'" id="service_id"><br><div><b>WebLink </b>: <a href="'+image+'" target="_blank">'+image+'</a></div>');

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
