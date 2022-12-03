@extends('layouts.app')

@section('content')
			<div class="swiper mySwiper">
				<div class="swiper-wrapper">
					<div class="swiper-slide"><img src="{{asset('images/banner-3.png')}}"></div>
					<div class="swiper-slide"><img src="{{asset('images/banner-2.png')}}"></div>
					<div class="swiper-slide"><img src="{{asset('images/banner-1.png')}}"></div>
				</div>
				<div class="swiper-pagination"></div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
			<div id="menu-top" class="page-content" style="padding:50px 0px 40px 0px;">
				<div class="container">
					<!-- .row start -->
					<div class="row mb-40">
						<!-- .col-md-12 start -->
						<div class="col-md-12 centered">
							<div class="custom-heading style-1">
								<h3><span>Tasty</span></h3>
								<h3>Bluedot Menu</h3>
								<!-- .divider.style-1 start -->
								<div class="divider style-1 center">
									<span class="hr-simple left"></span>
									<i class="fa fa-circle hr-icon"></i>
									<span class="hr-simple right"></span>
								</div>
							</div>
							<!-- .custom-heading.style-1 end -->
						</div>
						<!-- .col-md-12 end -->
					</div>
					<!-- .row end -->
					<!-- .row start -->
					<div class="row" style="margin-bottom:30px;">
						<!-- .col-md-6 start -->
						<div class="col-md-6">
							<ul class="menu-style-1">
								<li class="menu-item">
									<div class="menu-item-thumbnail"><img src="{{asset('images/indian.jpg')}}" alt="Bluedot" /></div>
									<div class="menu-item-description">
										<h5>Indian</h5>
										<p>Description of the Bluedot restaurant.</p>
									</div>
								</li>
								<li class="menu-item">
									<div class="menu-item-thumbnail"><img src="{{asset('images/pastry.jpg')}}" alt="" /></div>
									<div class="menu-item-description">
										<h5>Pastry</h5>
										<p>Description of the Bluedot restaurant.</p>
									</div>
								</li>
								<li class="menu-item">
									<div class="menu-item-thumbnail"><img src="{{asset('images/snack.jpg')}}" alt="Bluedot" /></div>
									<div class="menu-item-description">
										<h5>Snacks</h5>
										<p>Description of the Bluedot restaurant.</p>
									</div>
								</li>
								<li class="menu-item">
									<div class="menu-item-thumbnail"><img src="{{asset('images/pizza.jpg')}}" alt="" /></div>
									<div class="menu-item-description">
										<h5>Pizza</h5>
										<p>Description of the Bluedot restaurant.</p>
									</div>
								</li>
							</ul>
						</div>
						<!-- .col-md-6 end -->
						<!-- .col-md-6 start -->
						<div class="col-md-6">
							<ul class="menu-style-1">
								<li class="menu-item">
									<div class="menu-item-thumbnail"><img src="{{asset('images/pantry.jpg')}}" alt="" /></div>
									<div class="menu-item-description">
										<h5>Pantry</h5>
										<p>Description of the Bluedot restaurant.</p>
									</div>
								</li>
								<li class="menu-item">
									<div class="menu-item-thumbnail"><img src="{{asset('images/tandoor.png')}}" alt="" /></div>
									<div class="menu-item-description">
										<h5>Tandoor</h5>
										<p>Description of the Bluedot restaurant.</p>
									</div>
								</li>
								<li class="menu-item">
									<div class="menu-item-thumbnail"><img src="{{asset('images/chinese.jpg')}}" alt="" /></div>
									<div class="menu-item-description">
										<h5>Chinese</h5>
										<p>Description of the Bluedot restaurant.</p>
									</div>
								</li>
								<li class="menu-item">
									<div class="menu-item-thumbnail"><img src="{{asset('images/others.jpg')}}" alt="Bluedot" /></div>
									<div class="menu-item-description">
										<h5>Others</h5>
										<p>Description of the Bluedot restaurant.</p>
									</div>
								</li>
							</ul>
						</div>
						<!-- .col-md-6 end -->
					</div>
				</div>
				<!-- .container end -->
			</div>
			<div id="about" class="app_promotion" style="background: #ccc; padding: 65px 0">
				<div class="container">
					<div class="app-download-area">
						<div class="row align-items-center" style="margin: 0px">
							<div class="col-lg-6 col-sm-12">
								<div class="app_content_heading">
									<h1>DOWNLOAD APP</h1>
									<h2>Lets Get Your Free Copy From Play Store</h2>
									<p>Instant free download from store Cloud based storage for your data backup just log in with your mail account from play store and using whatever you want for your business purpose orem ipsum dummy text.</p>
									<a href="" class="playstore_btn">
										<!-- <img src="{{asset('images/play-store.png')}}"> -->
										<span>Download</span>
									</a>
								</div>
							</div>
							<div class="col-lg-6 col-sm-12">
								<img src="{{asset('images/app_promo.png')}}">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="page-content maxgin-0" style="margin-top:100px;">
				<div class="container">
					<!-- .row start -->
					<div class="row">
						<!-- .col-md-6 start -->
						<div class="col-md-6">
							<!-- .simple-gallery.row start -->
							<ul class="simple-gallery row">
								<!-- .col-md-6 start -->
								<li class="gallery-item col-md-6 triggerAnimation animated hidden-sm hidden-xs" data-animate='fadeIn'>
									<img src="{{asset('images/indian-street.jpg')}}" alt="Royal Plate - Restaurant & Catering HTML Template" style="height:365px;"/>
									<div class="hover-mask-container">
										<div class="hover-mask"></div>
										<div class="hover-zoom">
											<a href="{{asset('images/indian-street.jpg')}}" class="triggerZoom"></a>
										</div>
										<!-- .hover-details end -->
									</div>
									<!-- .hover-mask-container end -->
								</li>
								<!-- .col-md-6 end -->
								<!-- .col-md-6 start -->
								<li class="gallery-item col-md-6 triggerAnimation animated hidden-sm hidden-xs" data-animate='fadeIn'>
									<img src="{{asset('images/d5.png')}}" alt="Royal Plate - Restaurant & Catering HTML Template" style="height:365px;"/>
									<div class="hover-mask-container">
										<div class="hover-mask"></div>
										<div class="hover-zoom">
											<a href="{{asset('images/d5.png')}}" class="triggerZoom"></a>
										</div>
										<!-- .hover-details end -->
									</div>
									<!-- .hover-mask-container end -->
								</li>
								<!-- .col-md-6 end -->
								<!-- .col-md-6 start -->
								<li class="gallery-item col-md-6 triggerAnimation animated " data-animate='fadeIn'>
									<img src="{{asset('images/d12.png')}}" alt="Royal Plate - Restaurant & Catering HTML Template"style="height:365px;" />
									<div class="hover-mask-container">
										<div class="hover-mask"></div>
										<div class="hover-zoom">
											<a href="{{asset('images/d12.png')}}" class="triggerZoom"></a>
										</div>
										<!-- .hover-details end -->
									</div>
									<!-- .hover-mask-container end -->
								</li>
								<!-- .col-md-6 end -->
								<!-- .col-md-6 start -->
								<li class="gallery-item col-md-6 triggerAnimation animated hidden-sm hidden-xs" data-animate='fadeIn'>
									<img src="{{asset('images/Chicken.jpg')}}" alt="Royal Plate - Restaurant & Catering HTML Template"style="height:365px;" />
									<div class="hover-mask-container">
										<div class="hover-mask"></div>
										<div class="hover-zoom">
											<a href="{{asset('images/Chicken.jpg')}}" class="triggerZoom"></a>
										</div>
										<!-- .hover-details end -->
									</div>
									<!-- .hover-mask-container end -->
								</li>
								<!-- .col-md-6 end -->
							</ul>
						</div>
						<!-- .col-md-6 end -->
						<!-- .col-md-6 start -->
						<div class="col-md-6 content-padding-left">
							<div class="custom-heading style-2">
								<h3><span>From the menu</span></h3>
								<h3>Our specialities</h3>
								<div class="divider style-1">
									<i class="fa fa-circle hr-icon left"></i>
									<span class="hr-simple right"></span>
								</div>
							</div>
							<!-- .custom-heading.style-2 end -->
							<ul class="menu-style-1">
								<li class="menu-item">
									<div class="menu-item-thumbnail"><img src="{{asset('images/indian.jpg')}}" alt="" /></div>
									<div class="menu-item-description">
										<h5>INDIAN</h5>
										<p class="palign pad">Choose from a wide selection of Sauces, Vegetables, Meat, Rice and Noodles, just select and let the Chef take over and give you an experience of a lifetime.</p>
									</div>
								</li>
								<li class="menu-item">
									<div class="menu-item-thumbnail"><img src="{{asset('images/chinese.jpg')}}" alt="" /></div>
									<div class="menu-item-description">
										<h5>CHINESE</h5>
										<p class="palign pad">South Indian Non-vegetarian fare, Prawn Korma, Chicken Chettinad and Stew, Biryanis from Hyderabad all to surprise you. We offer you a never before experience.</p>
									</div>
								</li>
								<li class="menu-item">
									<div class="menu-item-thumbnail"><img src="{{asset('images/tandoor.png')}}" alt="" /></div>
									<div class="menu-item-description">
										<h5>TANDOOR</h5>
										<p class="palign pad">With Flavoured Hookah et al for the ultimate in causal, cool experience. Far the traditionalists, we bring wide choice of the ever-popular classic Tandoori and Chinese Items.</p>
									</div>
								</li>
								<li class="menu-item">
									<div class="menu-item-thumbnail"><img src="{{asset('images/pastry.jpg')}}" alt="" /></div>
									<div class="menu-item-description">
										<h5>PASTRY</h5>
										<p class="palign pad">For the Vegetarian, the food, will be prepared from Special Vegetarian Kitchen and would be devoid of Onion and Garlic except for a few delicacies by the Maharaj of Marwar served in Silverware Thalis.
										</p>
									</div>
								</li>
							</ul>
						</div>
						<!-- .col-md-6 end -->
					</div>
					<!-- .row end -->
				</div>
				<!-- .container end -->
			</div>
			<div id="client" class="page-content custom-img-background dark bkg-img4 custom-col-padding mb-100" style="padding:105px 0px 0px 0px!important;margin-bottom:0px!important;">
				<div class="container">
					<!-- .row start -->
					<div class="row">
						<!-- .col-md-12 start -->
						<div class="col-md-12 centered">
							<div class="fancy-testimonial-background">
								<h4>WHAT OUR CUSTOMERS SAY</h4>
								<!-- Fancy testimonial carousel start -->
								<div class="carousel-container">
									<div id="fancy-testimonial-carousel" class="owl-carousel owl-theme">
										<div class="item">
											<p >Really enjoyed our order at Bluedot. Delicious food, friendly staff and exquisite atmosphere. Recommend it!</p>
											<p class="testimonial-author">- Rahul, Odisha</p>
										</div>
										<div class="item">
											<p >Best customer support and response time I have ever seen... ! Great feeling from this pourchase.
												Thank you Bluedot!
											</p>
											<p class="testimonial-author">- Ranjan, Odisha</p>
										</div>
										<div class="item">
											<p >Really enjoyed our lunch at Bluedot. Delicious food, friendly staff and exquisite atmosphere. Recommend it!</p>
											<p class="testimonial-author">- Monoranjan, odisha</p>
										</div>
									</div>
									<!-- .owl-carousel.owl-theme end -->
								</div>
								<!-- .carousel-container end -->
								<!-- Fancy testimonial carousel end -->
							</div>
						</div>
						<!-- .col-md-12 end -->
					</div>
					<!-- .row end -->
				</div>
				<!-- .container end -->
			</div>
			@endsection