<!DOCTYPE html>
<html>
	<head>
		<title>
			Bluedot Foods
		</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link href="{{asset('images/fav.png')}}" rel="shortcut icon" type="image/png" />
		<!-- Stylesheets -->
		<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" />
		<!-- bootstrap grid -->
		<link rel="stylesheet" href="{{asset('css/bootstrap-theme.min.css')}}" />
		<!-- bootstrap theme -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<!--- font-awesome --->
		<link rel="stylesheet" href="{{asset('css/style.css')}}" />
		<!-- template styles -->
		<link rel="stylesheet" href="{{asset('css/viewbox.css')}}">
		<link rel="stylesheet" href="{{asset('css/retina.css')}}" />
		<!-- retina ready styles -->
		<link rel="stylesheet" href="{{asset('css/responsive.css')}}" />
		<!-- responsive styles -->
		<link rel="stylesheet" href="{{asset('css/animate.css')}}" />
		<!-- animation for content -->
		<link rel="stylesheet" href="{{asset('css/owl.carousel.css')}}" />
		<!-- Events carousel -->
		<link rel="stylesheet" href="{{asset('css/owl.theme.css')}}" />
		<!-- Events carousel -->
		<!-- Magnific Popup - image lightbox -->
		<link rel="stylesheet" href="{{asset('css/magnific-popup.css')}}" />
		<!-- Google Web fonts -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
		<link href="https://fonts.googleapis.com/css?family=Suranna" rel="stylesheet" type="text/css" />
		<link href="https://fonts.googleapis.com/css?family=Montez" rel="stylesheet" type="text/css" />
		<link href="https://fonts.googleapis.com/css?family=Crimson+Text" rel="stylesheet" />
		<!-- Font icons -->
		<link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
		<!-- Font awesome icons -->
		<link href="{{asset('css/bluedot.css')}}" rel="stylesheet" />
		<link
			rel="stylesheet"
			href="https://unpkg.com/swiper/swiper-bundle.min.css"
			/>
		<link rel="stylesheet" href="{{asset('css/nivo-slider.css')}}"/>
    @yield('css')
		<!-- Nivo Slider styles -->
		<style>
			@media (min-width: 768px) {
			.navbar-nav>li>a  {
			padding-top: 2px!important;
			padding-bottom: 10px!important;
			}
			}
			#header .navbar-default .navbar-nav > .current-menu-item > a:before, #header .navbar-default .navbar-nav > li > a:hover:before {
			top:3px!important;
			}
			#header .navbar-default .navbar-nav > li > a {
			font-family: 'Crimson Text', serif;
			font-size:17px;
			}
		</style>
		<style>
			.palign{
			text-align:justify!important;
			}
			@media only screen and (max-width: 479px) and (min-width: 320px)
			{
			.menu-item-description{
			width:342px!important;
			}
			.colpad{
			padding:90px 0px 90px 0px!important;
			}
			.menu-style-2 .menu-item-description p, .menu-left-shadow .menu-style-2 .menu-item-description p{
			margin-right:57px!important;
			}
			}
			.menu-style-1 .menu-item-description {
			width:360px;
			}
		</style>
	</head>
	<body>
			<section id="main-menu">
				<div id="header-wrapper">
					<!-- #header start -->
					<header id="header">
						<!-- Main navigation and logo container -->
						<div class="header-inner" style="background:rgba(0,0,0,0.5)">
							<!-- .container start -->
							<div class="container">
								<!-- .main-nav start -->
								<div class="main-nav">
									<!-- .row start -->
									<div class="row">
										<div class="col-md-12">
											<!-- .navbar start -->
											<nav class="navbar navbar-default nav-left" style="margin:10px 0px 10px 0px;">
												<!-- .navbar-header start -->
												<div class="navbar-header">
													<!-- .logo start -->
													<div class="logo" style="margin:0px;">
														<a href="/">
														<img src="{{asset('images/logo.png')}}" alt="Bluedot">
														</a>
													</div>
													<!-- logo end -->
												</div>
												<!-- .navbar-header end -->
												<!-- Collect the nav links, forms, and other content for toggling -->
												<div class="collapse navbar-collapse">
													<ul class="nav navbar-nav pi-nav" style="margin-top:28px;">
														<a href="javascript:;" onclick="$.data.load(1);"></a>
														<a href="javascript:;" onclick="$.data.load(2);"></a>
														<li class="current-menu-item dropdown">
															<a href="#main-menu">Home</a>
														</li>
														<li class="dropdown"><a href="#about">About</a>
														</li>
														<li class="dropdown">
															<a href="#menu-top">Menu</a>
														</li>
														<li>
															<a href="#client">Client</a>
														</li>
														<li>
															<a href="#copyright-container">Contact</a>
														</li>
													</ul>
													<!-- .nav.navbar-nav.pi-nav end -->
													<!-- Responsive menu start -->
													<div id="dl-menu" class="dl-menuwrapper">
														<button class="dl-trigger">
															<!-- Open Menu -->
														</button>
														<ul class="dl-menu">
															<li>
																<a href="#main-menu">Home</a>
															</li>
															<!-- Home li end -->
															<li>
																<a href="#about">About</a>
															</li>
															<!-- About li end -->
															<li>
																<a href="#menu-top">Menu</a>
															</li>
															<!-- Menu li end -->
															<li>
																<a href="#client">Client</a>
															</li>
															<!-- Gallery li end -->
															<li>
																<a href="#copyright-container">Contact</a>
															</li>
															<!-- Contact li end -->
														</ul>
														<!-- .dl-menu end -->
													</div>
													<!-- (Responsive menu) #dl-menu end -->
												</div>
												<!-- .navbar.navbar-collapse end -->
											</nav>
											<!-- .navbar end -->
										</div>
										<!-- .col-md-12 end -->
									</div>
									<!-- .row end -->
								</div>
								<!-- .main-nav end -->
							</div>
							<!-- .container end -->
						</div>
						<!-- .header-inner end -->
					</header>
					<!-- #header end -->
				</div>
			</section>

      <div class="wrapper">
    @yield('content')
  </div>


      <div id="footer-wrapper">
				<!-- #footer start -->
				<footer id="footer">
					<!-- .container start -->
					<div class="container">
						<!-- .row start -->
						<div class="row mb-60">
							<!-- .col-md-3 start -->
							<div class="col-md-3 centered">
								<a href="/">
								<img src="{{asset('images/logo.png')}}" style="max-width: 220px" alt="Bluedot">
								</a>
								<ul class="contact-info-list" style="padding: 0px">
									<li>
										Jajpur road nahaka bypass opp- bank of  baroda taioff komal restaurant  pin 755019
									<li>
										<span><i class="fa fa-envelope-o" aria-hidden="true" style="color: rgb(219, 68, 55) !important; font-size: 18px;"></i> </span>  <a href="mailto:bdot891@gmail.com" style="color: #acb8c4"> bdot891@gmail.com</a>
									</li>
								</ul>
								<ul class="social-links">
									<li><a href="https://www.facebook.com/BluedotTheHookahLounge/" target="_blank"><i class="fa fa-facebook"></i></a></li>
									<!-- <li><a href="#"><i class="fa fa-twitter"></i></a></li>
										<li><a href="#"><i class="fa fa-instagram"></i></a></li>
										<li><a href="#"><i class="fa fa-linkedin"></i></a></li> -->
								</ul>
							</div>
							<!-- .col-md-3 end -->
							<!-- .col-md-5 start -->
							<div class="col-md-5">
								<div class="map">
									<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7452.042534591676!2d86.12695357273533!3d20.951661063659973!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a195227bc2961ef%3A0x6b776df1f588b2c9!2sBank%20Of%20Baroda!5e0!3m2!1sen!2sin!4v1632749022013!5m2!1sen!2sin" width="100%" height="310" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
								</div>
							</div>
							<!-- .col-md-5 end-->
							<!-- .col-md-4 start -->
							<div class="col-md-4 text-center">
								<h3 class="heading_3">Contact Us</h3>
								<div class="social_area">
									<div class="call">
										<div class="call-image">
											<img src="{{asset('images/call.png')}}" style="max-width: 70px;">
										</div>
										<div class="call-content">
											<h1>+91 94376 75105</h1>
										</div>
									</div>
									<div class="whatsapp">
										<div class="whatsapp-image">
											<img src="{{asset('images/whatsapp.png')}}" style="max-width: 70px;">
										</div>
										<div class="whatsapp-content">
											<h1>+91 94376 75105</h1>
										</div>
									</div>
								</div>
							</div>
							<!-- .col-md-5 end-->
						</div>
						<!-- .row end -->
					</div>
					<!-- .container end -->
				</footer>
				<!-- #footer end -->
			</div>
			<div id="copyright-container">
				<!-- .container start -->
				<div class="container-fluid">
					<!-- .row start -->
					<div class="row">
						<!-- .col-md-3 start -->
						<div class="col-md-3">
							<p> &copy;  Bluedot Foods  All rights reserved.
							</p>
						</div>
						<!-- .col-md-3 end -->
						<!-- .col-md-6 start -->
						<div class="col-md-6">
							<ul class="breadcrumb">
								<li class="active"><a href="#main-menu">Home</a></li>
								<li><a href="#about">About</a></li>
								<li><a href="#menu-top">Menu</a></li>
								<li><a href="#client">Client</a></li>
								<li><a href="#copyright-container">Contact</a></li>
								<li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
								<li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
							</ul>
						</div>
						<!-- .col-md-6 end -->
						<!-- .col-md-3 start -->
						<div class="col-md-3">
							<p style="padding-top: 8px; text-align: right;"> Developed By <span><a href="http://www.webappssol.com/" target="_blank" style="color: #41e3ec"> &nbsp; webappsSOL</a></span></p>
						</div>
						<!-- .col-md-3 end -->
					</div>
					<!-- .row end -->
				</div>
				<!-- .container end -->
				<a href="#" class="scroll-up"><i class="fa fa-angle-double-up"></i></a>
			</div>
		<script src="{{asset('js/jquery-2.1.4.min.js')}}"></script><!-- jQuery library -->
		<script src="{{asset('js/bootstrap.min.js')}}"></script><!-- .bootstrap script -->
		<script src="{{asset('js/jquery.scripts.min.js')}}"></script><!-- modernizr, retina, stellar for parallax -->
		<script src="{{asset('js/jquery.magnific-popup.min.js')}}"></script><!-- used for image lightbox -->
		<script src="{{asset('js/owl.carousel.min.js')}}"></script><!-- Carousels script -->
		<script src="{{asset('js/jquery.dlmenu.min.js')}}"></script><!-- for responsive menu -->
		<script src="{{asset('js/include.js')}}"></script><!-- custom js functions -->
		<script src="{{asset('js/TweenMax.min.js')}}"></script> <!-- Plugin for smooth scrolling-->
		<script src="{{asset('js/ScrollToPlugin.min.js')}}"></script> <!-- Plugin for smooth scrolling-->
		<script src="{{asset('js/jquery.nivo.slider.pack.js')}}"></script><!-- Nivo Slider script -->
		<script src="{{asset('js/jquery.viewbox.js')}}"></script>
		<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
		<script>
			/* <![CDATA[ */
			jQuery(document).ready(function ($) {
			  'use strict';
			
			  //GALLERY LIGHTBOX
			  $('.triggerZoom').magnificPopup({
			    type: 'image',
			    gallery: {
			      enabled: true
			    }
			  });
			
			
			});
			/* ]]> */
		</script>
		<script>
			var swiper = new Swiper(".mySwiper", {
			  loop: true,
			  slidesPerView: 1,
			  autoplay: {
			        delay: 5000,
			        
			        disableOnInteraction: false,
			      },
			  navigation: {
			    nextEl: ".swiper-button-next",
			    prevEl: ".swiper-button-prev",
			  },
			  pagination: {
			        el: ".swiper-pagination",
			      },
			});
		</script>
		<script>
			/* <![CDATA[ */
			jQuery(document).ready(function ($) {
			  'use strict';
			
			  $('#featured-menu-nivo-slider').nivoSlider({
			    controlNav: false
			  });
			
			  // FEATURED MENU CAROUSEL START
			  $('#featured-menu-carousel').owlCarousel({
			    items: 3, //3 items above 1000px browser width
			    itemsCustom: [[0, 1], [600, 2], [1000, 3]],
			    autoPlay: true,
			    pagination: false,
			    navigation: true
			  });
			
			  // FANCY TESTIMONIAL CAROUSEL START
			  $('#fancy-testimonial-carousel').owlCarousel({
			    singleItem: true,
			    autoPlay: true,
			    pagination: false,
			    navigation: false
			  });
			  // TESTIMONIAL STYLE 1 CAROUSEL START
			  $('#testimonial-style-1-carousel').owlCarousel({
			    singleItem: true,
			    autoPlay: true,
			    pagination: false,
			    navigation: false
			  });
			
			  // TESTIMONIAL STYLE 2 CAROUSEL START
			  $('#testimonial-style-2-carousel').owlCarousel({
			    singleItem: true,
			    autoPlay: true,
			    pagination: false,
			    navigation: false
			  });
			  // TESTIMONIAL STYLE 3 CAROUSEL START
			  $('#testimonial-style-3-carousel').owlCarousel({
			    singleItem: true,
			    autoPlay: true,
			    pagination: false,
			    navigation: false
			  });
			
			});
			/* ]]> */
		</script>
		<script>
			$(function(){
			  $('.image-link').viewbox({
			    setTitle: true,
			    margin: 20,
			    resizeDuration: 300,
			    openDuration: 200,
			    closeDuration: 200,
			    closeButton: true,
			    navButtons: true,
			    closeOnSideClick: true,
			    nextOnContentClick: true
			  });
			});
		</script>
		<script>
			// Select all links with hashes
			$('a[href*="#"]')
			// Remove links that don't actually link to anything
			.not('[href="#"]')
			.not('[href="#0"]')
			.click(function(event) {
			  // On-page links
			  if (
			    location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
			    &&
			    location.hostname == this.hostname
			  ) {
			    // Figure out element to scroll to
			    var target = $(this.hash);
			    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
			    // Does a scroll target exist?
			    if (target.length) {
			      // Only prevent default if animation is actually gonna happen
			      event.preventDefault();
			      console.log(target.offset().top);
			      $('html, body').animate({
			        scrollTop: target.offset().top - 65
			      }, 1500, function() {
			        // Callback after animation
			        // Must change focus!
			        var $target = $(target);
			        $target.focus();
			        if ($target.is(":focus")) { // Checking if the target was focused
			          return false;
			        } else {
			          //$target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
			          //$target.focus(); // Set focus again
			        };
			      });
			    }
			  }
			});
		</script>
		<script>
			$('li > a').click(function() {
			  $('.nav li').removeClass();
			  $(this).parent().addClass('active');
			});
		</script>
	</body>
</html>