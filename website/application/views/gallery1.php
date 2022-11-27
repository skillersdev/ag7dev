<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo"<pre>"; print_r($contac_log_result);die;
//echo "<pre>";print_r($gallery_details);die;
//$this->load->view('index.html');
$path_url = $this->config->item('path_url');

$login_url = $this->config->item('login_url');
$image_path = $this->config->item('base_path');

//$last_slider_image = end($slider_image);
//print_r($image_path."++".$path_url);die;

?>
<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>3ABC7</title>
        <meta name="description" content="3ABC7 Image Gallery"/>
        <meta name="keywords" content="3ABC7, gallery, image gallery, album"/>
        <meta name="author" content="Sridhar"/>
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/gallery1/css/style.css"/>
		<script src="<?php echo base_url();?>assets/gallery1/js/modernizr.custom.70736.js"></script>
		<noscript><link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/gallery1/css/noJS.css"/></noscript>
		<!--[if lte IE 7]><style>.main{display:none;} .support-note .note-ie{display:block;}</style><![endif]-->
		<style>
			.button {
			  background-color: #407fbb; /* Blue */
			  border: none;
			  color: white;
			  padding: 15px 32px;
			  text-align: center;
			  text-decoration: none;
			  display: inline-block;
			  font-size: 16px;
			  float: right;
			}
			.videoaudio {
				  display: grid;
				  grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
				   list-style-type: none;
				}
			.videoaudio li{ margin: 10px;}
		</style>
    </head>
    <body>
        <div class="container" style="background-color: #d8d8d8;">
			<div class="container demo">
			   <div class="content">
				  <div id="large-header" class="large-header">
					 <canvas id="demo-canvas"></canvas>
					 <h1 class="main-title"><span class="thin"> <?php echo $gallery_details[0]['album'];?> </span> </h1>
				  </div>
			   </div>
			</div>
						
			<div class="main">
				<!--<header class="clearfix">
				
					<h1>Album<span>&nbsp;&nbsp;&nbsp;<?php //echo $gallery_details[0]['album'];?></span></h1>

					<div class="support-note">
						<span class="note-ie">Sorry, only modern browsers.</span>
					</div>
					
				</header>-->
				<a href="<?php echo base_url();?><?php echo $gallery_details[0]['website'];?>" class="button">Goto Website</a>
				
				<div class="gamma-container gamma-loading" id="gamma-container">
					<h3>Album Photos</h3>

					<ul class="gamma-gallery">


					<?php
						foreach ($gallery_details as $key => $value)
						{
							$image_scr = $image_path.$value['photos'];
							$filetype= $value['filetype'];
							if($filetype=="jpg"||$filetype=="jpeg"||$filetype=="gif"||$filetype=="png"){
						?>

                     
						<li>
							<div data-alt="img03" data-description="<h3>View</h3>" data-max-width="1800" data-max-height="1350">
								<div data-src="<?php echo $image_scr;?>" data-min-width="1300"></div>
								<div data-src="<?php echo $image_scr;?>"></div>
								<div data-src="<?php echo $image_scr;?> data-min-width="700"></div>
								<div data-src="<?php echo $image_scr;?> data-min-width="300"></div>
								<div data-src="<?php echo $image_scr;?>" data-min-width="200"></div>
								<div data-src="<?php echo $image_scr;?>" data-min-width="140"></div>
								<div data-src="<?php echo $image_scr;?>"></div>
								<noscript>
									<img src="<?php echo $image_scr;?>" alt="img03"/>
								</noscript>
							</div>
						</li>
						<?php 
							}
						}
						?>
						
					</ul>
					
					
					<h3>Album Videos</h3>
					
					<ul class="videoaudio">
					<?php
						foreach ($gallery_details as $key => $value)
						{
							$image_scr = $image_path.$value['photos'];
							$filetype= $value['filetype'];
							if($filetype=="mp4"||$filetype=="ogg" ||$filetype=="WebM"){
						?>

                     
						<li>
							<video width="400" controls>
								<source src="<?php echo $image_scr; ?>" type="video/mp4">
							  </video>
						</li>
						<?php 
							}
						}
						?>
						
					</ul>
					
					
					<h3>Album Audios</h3>
					<ul class="videoaudio">
					<?php
						foreach ($gallery_details as $key => $value)
						{
							$image_scr = $image_path.$value['photos'];
							$filetype= $value['filetype'];
							if($filetype=="mp3"||$filetype=="ogg"){
						?>

                     
						<li>
							<audio controls>
							 
							  <source src="<?php echo $image_scr; ?>" type="audio/mpeg">
							  Your browser does not support the audio tag.
							</audio>							
						</li>
						<?php 
							}
						}
						?>
						
					</ul>
					
					

					<div class="gamma-overlay"></div>

				

				</div>

			</div><!--/main-->
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="<?php echo base_url();?>assets/gallery1/js/jquery.masonry.min.js"></script>
		<script src="<?php echo base_url();?>assets/gallery1/js/jquery.history.js"></script>
		<script src="<?php echo base_url();?>assets/gallery1/js/js-url.min.js"></script>
		<script src="<?php echo base_url();?>assets/gallery1/js/jquerypp.custom.js"></script>
		<script src="<?php echo base_url();?>assets/gallery1/js/gamma.js"></script>
		<script type="text/javascript">
			
			$(function() {

				var GammaSettings = {
						// order is important!
						viewport : [ {
							width : 1200,
							columns : 5
						}, {
							width : 900,
							columns : 4
						}, {
							width : 500,
							columns : 3
						}, { 
							width : 320,
							columns : 2
						}, { 
							width : 0,
							columns : 2
						} ]
				};

				Gamma.init( GammaSettings, fncallback );


				// Example how to add more items (just a dummy):

				var page = 0,
					items = ['<li><div data-alt="img03" data-description="<h3>Sky high</h3>" data-max-width="1800" data-max-height="1350"><div data-src="images/xxxlarge/3.jpg" data-min-width="1300"></div><div data-src="images/xxlarge/3.jpg" data-min-width="1000"></div><div data-src="images/xlarge/3.jpg" data-min-width="700"></div><div data-src="images/large/3.jpg" data-min-width="300"></div><div data-src="images/medium/3.jpg" data-min-width="200"></div><div data-src="images/small/3.jpg" data-min-width="140"></div><div data-src="images/xsmall/3.jpg"></div><noscript><img src="images/xsmall/3.jpg" alt="img03"/></noscript></div></li><li><div data-alt="img03" data-description="<h3>Sky high</h3>" data-max-width="1800" data-max-height="1350"><div data-src="images/xxxlarge/3.jpg" data-min-width="1300"></div><div data-src="images/xxlarge/3.jpg" data-min-width="1000"></div><div data-src="images/xlarge/3.jpg" data-min-width="700"></div><div data-src="images/large/3.jpg" data-min-width="300"></div><div data-src="images/medium/3.jpg" data-min-width="200"></div><div data-src="images/small/3.jpg" data-min-width="140"></div><div data-src="images/xsmall/3.jpg"></div><noscript><img src="images/xsmall/3.jpg" alt="img03"/></noscript></div></li><li><div data-alt="img03" data-description="<h3>Sky high</h3>" data-max-width="1800" data-max-height="1350"><div data-src="images/xxxlarge/3.jpg" data-min-width="1300"></div><div data-src="images/xxlarge/3.jpg" data-min-width="1000"></div><div data-src="images/xlarge/3.jpg" data-min-width="700"></div><div data-src="images/large/3.jpg" data-min-width="300"></div><div data-src="images/medium/3.jpg" data-min-width="200"></div><div data-src="images/small/3.jpg" data-min-width="140"></div><div data-src="images/xsmall/3.jpg"></div><noscript><img src="images/xsmall/3.jpg" alt="img03"/></noscript></div></li><li><div data-alt="img03" data-description="<h3>Sky high</h3>" data-max-width="1800" data-max-height="1350"><div data-src="images/xxxlarge/3.jpg" data-min-width="1300"></div><div data-src="images/xxlarge/3.jpg" data-min-width="1000"></div><div data-src="images/xlarge/3.jpg" data-min-width="700"></div><div data-src="images/large/3.jpg" data-min-width="300"></div><div data-src="images/medium/3.jpg" data-min-width="200"></div><div data-src="images/small/3.jpg" data-min-width="140"></div><div data-src="images/xsmall/3.jpg"></div><noscript><img src="images/xsmall/3.jpg" alt="img03"/></noscript></div></li><li><div data-alt="img03" data-description="<h3>Sky high</h3>" data-max-width="1800" data-max-height="1350"><div data-src="images/xxxlarge/3.jpg" data-min-width="1300"></div><div data-src="images/xxlarge/3.jpg" data-min-width="1000"></div><div data-src="images/xlarge/3.jpg" data-min-width="700"></div><div data-src="images/large/3.jpg" data-min-width="300"></div><div data-src="images/medium/3.jpg" data-min-width="200"></div><div data-src="images/small/3.jpg" data-min-width="140"></div><div data-src="images/xsmall/3.jpg"></div><noscript><img src="images/xsmall/3.jpg" alt="img03"/></noscript></div></li>']

				function fncallback() {

					$( '#loadmore' ).show().on( 'click', function() {

						++page;
						var newitems = items[page-1]
						if( page <= 1 ) {
							
							Gamma.add( $( newitems ) );

						}
						if( page === 1 ) {

							$( this ).remove();

						}

					} );

				}

			});

		</script>	
		
		
		
		

<style>
.large-header {
   position: relative;
   width: 100%;
   background: #111;
   overflow: hidden;
   background-size: cover;
   background-position: center center;
   z-index: 1;
}

.demo .large-header {
   background-image: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/499416/demo-bg.jpg");
}

.main-title {
   position: absolute;
   margin: 0;
   padding: 0;
   color: #F9F1E9;
   text-align: center;
   top: 50%;
   left: 50%;
   -webkit-transform: translate3d(-50%, -50%, 0);
   transform: translate3d(-50%, -50%, 0);
}

.demo .main-title {
   text-transform: uppercase;
   font-size: 4.2em;
   letter-spacing: 0.1em;
}

.main-title .thin {
   font-weight: 200;
}

@media only screen and (max-width: 768px) {
   .demo .main-title {
      font-size: 3em;
   }
}

</style>



	</body>
</html>
