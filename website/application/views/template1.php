<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo"<pre>"; print_r($myvideo_det);die;
//echo "<pre>";print_r($album_details);die;
$this->load->view('index.html');
$path_url = $this->config->item('path_url');

$login_url = $this->config->item('login_url');
$image_path = $this->config->item('base_path');

$last_slider_image = end($slider_image);



//echo "<pre>";print_r($all_details);die;

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
          <?php
            foreach ($all_details as $key => $value) {
          ?>
          <li class="menu-active"><a href="#<?php echo $key;?>">
            <?php echo $key?>
          </a></li>
         <?php } ?>

          <li><a href="<?php echo $login_url; ?>" target="_blank">Website login</a>
          </li>         
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
        </div>
      </div>
    </section>

   
    
    <!--==========================
      Service Section
    ============================-->
    <?php
    foreach ($all_details as $key => $value) {
     ?>
    <section id="<?php echo $key;?>" class="section-with-bg wow fadeInUp">

      <div class="container">
        <div class="section-header">
          <h2><?php echo $key;?></h2>

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


      </div>
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
                     echo '<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal2" onclick="servicepopupimage('.$name.','.$file_name_path.','.$desc.','.$service_id.','.$weblink.','.$media_type.','.$path_src.')"><img src="'.$path.'" class="img-fluid" style="width:100%;"></a>'; 
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
                      <img src="./assets/img/thumbs-up-circle-blue-512.png" id="likeservice1" style="width:22px;cursor: pointer;" onclick="likeService(<?php echo $name;?>,<?php echo $child_value['section_item_id'];?>)">
                      <input type="hidden" value="<?php echo $child_value['section_item_id']; ?>" id="service_id<?php echo $child_value['section_item_id']; ?>">
                      <span id="likeservicecount<?php echo $child_value['section_item_id'];?>"><?php echo $child_value['likes']; ?></span>
                  </div>
                </div>
               </div>
              <?php 
            } 
          ?>
        </div>
    </section>
	
    <?php } ?>

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
      <!-- <div class="credits">
       
        Designed by <a href="https://skillersglobalservice.com/">Skillers</a>
      </div> -->
    </div>
  </footer><!-- #footer -->
</main> 

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
   function likeService(name,id)
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
  
   function galleryPhots(albumcode)
   {
      window.open('http://www.smkproduction.eu5.org', '_blank');
   }
    
    
  function servicepopupimage(name,image,desc,update_id,weblink,type,src_file){
      
      $('#mtitle2').html(name);
      
      if(type==2)
      {
        $('#mimage2').html('<video width="400" controls><source src="'+image+'" type="video/mp4"></video>'); 
      }
      else if(type==1 || type==3 || type==4){
        $('#mimage2').html('<img src="'+src_file+'" width="400">');
      }else{
        $('#mimage2').html('<audio width="400" controls><source src="'+src_file+'" type="audio/mpeg"></audio>');
      }
      
      $('#desc2').html('<div class="description">"'+desc+'"</div><input type="hidden" value="'+update_id+'" id="service_id"><br><div><b>WebLink </b>: <a href="'+image+'" target="_blank">'+image+'</a></div>');

       var serviceid = update_id;
       $.ajax({
          type:'POST',
          url:'<?php echo base_url("index.php/website/updateviews"); ?>',
          data:{'id':serviceid,'field':'view','section':name},
           dataType:"JSON",                
          success:function(data){                 
              $('#viewservicecount').html(data.total_views);
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
