<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo"<pre>"; print_r($contac_log_result);die;
//echo "<pre>";print_r($gallery_details);die;
$this->load->view('index.html');
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
        <title>Roodabatoz</title>
        <meta name="description" content="Roodab Image Gallery"/>
        <meta name="keywords" content="roodabatoz, gallery, image gallery, album"/>
        <meta name="author" content="Sridhar"/>
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="../assets/css/style.css"/>
		<script src="<?php echo base_url();?>assets/gallery1/js/modernizr.custom.70736.js"></script>
		<noscript><link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/gallery1/css/noJS.css"/></noscript>
		<!--[if lte IE 7]><style>.main{display:none;} .support-note .note-ie{display:block;}</style><![endif]-->
    </head>
    <body>
        <div class="container">
		
						
			<div class="main">
				<header class="clearfix">
				
					<h1>Album<span>&nbsp;&nbsp;&nbsp;<?php echo $gallery_details[0]['album'];?></span></h1>

					<div class="support-note">
						<span class="note-ie">Sorry, only modern browsers.</span>
					</div>
					
				</header>
				
				<div class="gamma-container gamma-loading" id="gamma-container">

					<ul class="gamma-gallery">


					<?php
						foreach ($gallery_details as $key => $value)
						{
							$image_scr = $image_path.$value['photos'];
						?>

                     
						<li>
							<div data-alt="img03" data-description="<h3>Sky high</h3>" data-max-width="1800" data-max-height="1350">
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
	</body>
</html>
