<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Appnoko Web</title>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no">

		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/bootstrap-select.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<link href="css/color.css" rel="stylesheet">
		<link href="css/custom-responsive.css" rel="stylesheet">
		<link href="css/animate.css" rel="stylesheet">
		<link href="css/component.css" rel="stylesheet">
		<link href="css/default.css" rel="stylesheet">
	<!-- font awesome this template -->
		<link href="fonts/css/font-awesome.css" rel="stylesheet">
		<link href="fonts/css/font-awesome.min.css" rel="stylesheet">
	</head>
	<body>
		<div id="preloader">
			<div class="preloader-container">
				<img src="images/preloader.gif" class="preload-gif" alt="preload-image">
			</div>
		</div>
		<div class="map-wapper-opacity">

			<div class="container">
				<div class="row">
					<div class="row">
						<div class="col-sm-4">
							<div class="language-opt custom-select-box custom-select-box2 tec-domain-cat7" id="translateElements">
								<select class="selectpicker" data-live-search="false">
									<option>English</option>
									<option>Hausa</option>

								</select>
							</div>

							<div class="call-us">
								<span class="img-circle"><i class="fa fa-phone"></i></span>
								<p>Call Us Now at (080) 6829 5276</p>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="logo-wraper">
								<div class="logo">
									<a href="index.html">
										<img src="images/logo.png" alt="" width="100px">
									</a>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div id="languages" class="resister-social">

								<div class="login-register">
									<a href="#">Login</a>
									<a href="#">Register</a>
								</div>
								<div class="social-icon">
									<a href="#" class="img-circle">
										<i class="fa fa-facebook"></i>
									</a>
									<a href="#" class="img-circle">
										<i class="fa fa-twitter"></i>
									</a>
									<a href="#" class="img-circle">
										<i class="fa fa-tumblr"></i>
									</a>
								</div>
							</div>
						</div>
						<div class="col-sm-1">
							<div class="header-menu-wrap">
								<nav class="navbar navbar-default" role="navigation">
									<div class="main  collapse navbar-collapse">
										<div class="column">
											<div id="dl-menu" class="dl-menuwrapper">
												<a href="#" class="dl-trigger" data-toggle="dropdown"><i class="fa fa-align-justify"></i></a>
												<ul class="dl-menu">
													<li>
														<a href="#">Home Page Variants</a>
														<ul class="dl-submenu ">
															<li><a href="index.html">Home Variant 1</a></li>
															<li><a href="index2.html">Home Variant 2</a></li>
															<li><a href="index3.html">Home Variant 3</a></li>
															<li><a href="index4.html">Home Variant 4</a></li>
															<li><a href="index5.html">Home Variant 5</a></li>
															<li><a href="index6.html">Home Variant 6</a></li>
															<li><a href="index7.html">Home Variant 7</a></li>
															<li><a href="index8.html">Home Variant 8</a></li>
															<li><a href="index9.html">Home Variant 9</a></li>
															<li><a href="index10.html">Home Variant 10</a></li>
															<li><a href="index11.html">Home Variant 11</a></li>
															<li><a href="index12.html">Home Variant 12</a></li>
														</ul>
													</li>
													<li>
														<a href="#">Home Page Variants2</a>
														<ul class="dl-submenu ">
															<li><a href="index13.html">Home Variant 13</a></li>
															<li><a href="index14.html">Home Variant 14</a></li>
															<li><a href="index15.html">Home Variant 15</a></li>
															<li><a href="index16.html">Home Variant 16</a></li>
															<li><a href="index17.html">Home Variant 17</a></li>
															<li><a href="index18.html">Home Variant 18</a></li>
															<li><a href="index19.html">Home Variant 19</a></li>
															<li><a href="index20.html">Home Variant 20</a></li>
															<li><a href="index21.html">Home Variant 21</a></li>
															<li><a href="index22.html">Home Variant 22</a></li>
															<li><a href="index23.html">Home Variant 23</a></li>
															<li><a href="index24.html">Home Variant 24</a></li>
														</ul>
													</li>
													<li>
														<a href="#">Results Page Variants</a>
														<ul class="dl-submenu">
															<li><a href="Results_1.html">Result Variant 1</a></li>
															<li><a href="Results_2.html">Result Variant 2</a></li>
															<li><a href="Results_3.html">Result Variant 3</a></li>
															<li><a href="Results_4.html">Result Variant 4 </a></li>
														</ul>
													</li>
													<li>
														<a href="#">Booking Variants</a>
														<ul class="dl-submenu">
															<li><a href="Results_5.html">Booking Variants 1</a></li>
															<li><a href="Results_6.html">Booking Variants 2</a></li>
														</ul>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</nav>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="google-image">
			<div id="directions-panel"></div>
			<div id="map-canvas"></div>
		</div>


    @yield('content')


    		<!-- page20 html start -->
		<div class="page19-Featued-Drivers">
			<div class="page19-wrap stellar"  data-stellar-background-ratio="0.5" data-stellar-vertical-offset="" >
				<div class="container">
					<div class="row">
						<div class="page19-span"><h2>Featued Transport Companies</h2></div>
						<div class="page19-array2"><h4>Transport companies you can trust</h4></div>

						<div id="carousel-example-generic5" class="carousel slide" data-ride="carousel">
							<div class="slider-btn">
								<a class="right-cursor2" href="#carousel-example-generic5" data-slide="prev">
									<div class="featured-drivers"> <i class="fa fa-angle-left"></i></div>
								</a>
								<a class="left-cursor2" href="#carousel-example-generic5" data-slide="next">
									<div class="featured-drivers featured22"><i class="fa fa-angle-right"></i> </div>
								</a>
							</div>
							<div class="featured-drivers-wrapper">
								<div class="carousel-inner">
									<div class="item active">
										<div class="featured-drivers2">
											<div class="featured">
												<div class="featured-images"><a href=""><img src="images/gig.png" alt=""/></a></div>
												<div class="featured-hover"></div>
											</div>
											<div class="featured-text">
												<a href="">	<h4>God is good </h4></a>
												<span>Transport Company</span>
											</div>
										</div>
										<div class="featured-drivers2">
											<div class="featured">
												<div class="featured-images"><a href=""><img src="images/abc.png" alt=""/></a></div>
												<div class="featured-hover"></div>
											</div>
											<div class="featured-text">
												<a href="">	<h4>ABC Company</h4></a>
												<span>Transport Company</span>
											</div>
										</div>
										<div class="featured-drivers2">
											<div class="featured">
												<div class="featured-images"><a href=""><img src="images/guo.png" alt=""/></a></div>
												<div class="featured-hover"></div>
											</div>
											<div class="featured-text">
												<a href="">	<h4>GUO</h4></a>
												<span>Transport Company</span>
											</div>
										</div>
										<div class="featured-drivers2">
											<div class="featured">
												<div class="featured-images"><a href=""><img src="images/ccountry.png" alt=""/></a></div>
												<div class="featured-hover"></div>
											</div>
											<div class="featured-text">
												<a href="">	<h4>Cross Country</h4></a>
												<span>Transport Company</span>
											</div>
										</div>
										<div class="featured-drivers2 featured22">
											<div class="featured">
												<div class="featured-images"><a href=""><img src="images/cisco.png" alt=""/></a></div>
												<div class="featured-hover"></div>
											</div>
											<div class="featured-text">
												<a href="">	<h4>Chisco </h4></a>
												<span>Transport Company</span>
											</div>
										</div>
									</div>



								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<!-- page20 html exit -->



		<!-- label white html start -->
		<div class="label-white white-lable-m">
			<div class="container">
				<div class="row">
					<div class="col-sm-6" data-uk-scrollspy="{cls:'uk-animation-fade', delay:300, repeat: true}">
						<div class="row">
							<div class="label-item">
								<div class="containt-font">
									<a href="#" class="img-circle"><img src="images/lock.png" alt=""/></a>
								</div>
								<div class="containt-text">
									<h3>Secure Booking</h3>
									<span>We ensure safest booking!</span>
									<p>Morbi accumsan ipsum velit. Nam nec tellus a odio cidunt auctor a ornare odio. Sed non  mauris vitae erat consequat auctor eu in elit.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6" data-uk-scrollspy="{cls:'uk-animation-fade', delay:300, repeat: true}">
						<div class="row">
							<div class="label-item">
								<div class="containt-font">
									<a href="#" class="img-circle"><img src="images/reliable.png" alt=""/></a>
								</div>
								<div class="containt-text">
									<h3>Reliable Service</h3>
									<span>We ensure safest booking!</span>
									<p>Morbi accumsan ipsum velit. Nam nec tellus a odio cidunt auctor a ornare odio. Sed non  mauris vitae erat consequat auctor eu in elit.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6" data-uk-scrollspy="{cls:'uk-animation-fade', delay:300, repeat: true}">
						<div class="row">
							<div class="label-item">
								<div class="containt-font">
									<a href="#" class="img-circle"><img src="images/customer.png" alt=""/></a>
								</div>
								<div class="containt-text">
									<h3>Customer Service</h3>
									<span>We ensure safest booking!</span>
									<p>Morbi accumsan ipsum velit. Nam nec tellus a odio cidunt auctor a ornare odio. Sed non  mauris vitae erat consequat auctor eu in elit.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6 " data-uk-scrollspy="{cls:'uk-animation-fade', delay:300, repeat: true}">
						<div class="row float-right">
							<div class="label-item ">
								<div class="containt-font" >
									<a href="#" class="img-circle"><img src="images/hidden.png" alt=""/></a>
								</div>
								<div class="containt-text">
									<h3>No Hidden Charges</h3>
									<span>We ensure safest booking!</span>
									<p>Morbi accumsan ipsum velit. Nam nec tellus a odio cidunt auctor a ornare odio. Sed non  mauris vitae erat consequat auctor eu in elit.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- label white html exit -->

		<!-- label yellow html start -->
		<div class="yellow-label-wrapper2">
			<div class="label-yellow stellar"  data-stellar-background-ratio="0.5" data-stellar-vertical-offset="" >
				<div class="container">
					<div class="row">
						<div class="destination">
							<h2>Destinations You'd Love</h2>
							<h4>Look at the wonderful places</h4>
						</div>
						<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
							<div class="slider-btn">
								<a class="right-cursor1" href="#carousel-example-generic" data-slide="prev"></a>
								<a class="left-cursor1" href="#carousel-example-generic" data-slide="next"></a>
							</div>
							<div class="carousel-inner">
								<div class="item active">
									<div class="col-sm-4">
										<div class="row">
											<div class="slider-item ">
												<div class="slider-img"><img class="img-responsive" alt="First slide" src="images/slider/slider1.jpg"/></div>
												<div class="slider-text-hover">
													<div class="slider-hover-content"></div>
													<div class="Orange">
														<div class="slider-hover-content2">
															<h4>Orange Skies</h4>
															<p>Save upto 50%</p>
														</div>
														<div class="slider-hover-content3">
															<a href="#" class="btn slide-btn btn-lg">Avail Now</a>
														</div>
													</div>
												</div>
												<div class="slider-text">
													<div class="slider-text1">
														<h4>Orange Skies</h4>
														<p>Save upto 50%</p>
													</div>
													<div class="slider-text2">
														<a href="#" class="btn slide-btn btn-lg">Avail Now</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="row">
											<div class="slider-item ">
												<div class="slider-img"><img class="img-responsive" alt="First slide" src="images/slider/slider2.jpg"/></div>

												<div class="slider-text-hover">
													<div class="slider-hover-content"></div>
													<div class="Orange">
														<div class="slider-hover-content2">
															<h4>Orange Skies</h4>
															<p>Save upto 50%</p>
														</div>
														<div class="slider-hover-content3">
															<a href="#" class="btn slide-btn btn-lg">Avail Now</a>
														</div>
													</div>
												</div>


												<div class="slider-text">
													<div class="slider-text1">
														<h4>Orange Skies</h4>
														<p>Save upto 50%</p>
													</div>
													<div class="slider-text2">
														<a href="#" class="btn slide-btn btn-lg">Avail Now</a>
													</div>
												</div>

											</div>
										</div>
									</div>

									<div class="col-sm-4">
										<div class="row">
											<div class="slider-item homepage-sllider-m">
												<div class="slider-img"><img class="img-responsive" alt="First slide" src="images/slider/slider3.jpg"/></div>

												<div class="slider-text-hover">
													<div class="slider-hover-content"></div>
													<div class="Orange">
														<div class="slider-hover-content2">
															<h4>Orange Skies</h4>
															<p>Save upto 50%</p>
														</div>
														<div class="slider-hover-content3">
															<a href="#" class="btn slide-btn btn-lg">Avail Now</a>
														</div>
													</div>
												</div>


												<div class="slider-text">
													<div class="slider-text1">
														<h4>Orange Skies</h4>
														<p>Save upto 50%</p>
													</div>
													<div class="slider-text2">
														<a href="#" class="btn slide-btn btn-lg">Avail Now</a>
													</div>
												</div>

											</div>
										</div>
									</div>
								</div>

								<div class="item">
									<div class="col-sm-4">
										<div class="row">
											<div class="slider-item ">
												<div class="slider-img"><img class="img-responsive" alt="First slide" src="images/slider/slider4.jpg"/></div>
												<div class="slider-text-hover">
													<div class="slider-hover-content"></div>
													<div class="Orange">
														<div class="slider-hover-content2">
															<h4>Orange Skies</h4>
															<p>Save upto 50%</p>
														</div>
														<div class="slider-hover-content3">
															<a href="#" class="btn slide-btn btn-lg">Avail Now</a>
														</div>
													</div>
												</div>

												<div class="slider-text">
													<div class="slider-text1">
														<h4>Orange Skies</h4>
														<p>Save upto 50%</p>
													</div>
													<div class="slider-text2">
														<a href="#" class="btn slide-btn btn-lg">Avail Now</a>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="col-sm-4">
										<div class="row">
											<div class="slider-item ">
												<div class="slider-img"><img class="img-responsive" alt="First slide" src="images/slider/slider5.jpg"/></div>
												<div class="slider-text-hover">
													<div class="slider-hover-content"></div>
													<div class="Orange">
														<div class="slider-hover-content2">
															<h4>Orange Skies</h4>
															<p>Save upto 50%</p>
														</div>
														<div class="slider-hover-content3">
															<a href="#" class="btn slide-btn btn-lg">Avail Now</a>
														</div>
													</div>
												</div>
												<div class="slider-text">
													<div class="slider-text1">
														<h4>Orange Skies</h4>
														<p>Save upto 50%</p>
													</div>
													<div class="slider-text2">
														<a href="#" class="btn slide-btn btn-lg">Avail Now</a>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="col-sm-4">
										<div class="row">
											<div class="slider-item homepage-sllider-m">
												<div class="slider-img"><img class="img-responsive" alt="First slide" src="images/slider/slider6.jpg"/></div>

												<div class="slider-text-hover">
													<div class="slider-hover-content"></div>
													<div class="Orange">
														<div class="slider-hover-content2">
															<h4>Orange Skies</h4>
															<p>Save upto 50%</p>
														</div>
														<div class="slider-hover-content3">
															<a href="#" class="btn slide-btn btn-lg">Avail Now</a>
														</div>
													</div>
												</div>


												<div class="slider-text">
													<div class="slider-text1">
														<h4>Orange Skies</h4>
														<p>Save upto 50%</p>
													</div>
													<div class="slider-text2">
														<a href="#" class="btn slide-btn btn-lg">Avail Now</a>
													</div>
												</div>

											</div>
										</div>
									</div>
								</div>

								<div class="item">
									<div class="col-sm-4">
										<div class="row">
											<div class="slider-item ">
												<div class="slider-img"><img class="img-responsive" alt="First slide" src="images/slider/slider7.jpg"/></div>
												<div class="slider-text-hover">
													<div class="slider-hover-content"></div>
													<div class="Orange">
														<div class="slider-hover-content2">
															<h4>Orange Skies</h4>
															<p>Save upto 50%</p>
														</div>
														<div class="slider-hover-content3">
															<a href="#" class="btn slide-btn btn-lg">Avail Now</a>
														</div>
													</div>
												</div>


												<div class="slider-text">
													<div class="slider-text1">
														<h4>Orange Skies</h4>
														<p>Save upto 50%</p>
													</div>
													<div class="slider-text2">
														<a href="#" class="btn slide-btn btn-lg">Avail Now</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="row">
											<div class="slider-item ">
												<div class="slider-img"><img class="img-responsive" alt="First slide" src="images/slider/slider8.jpg"/></div>

												<div class="slider-text-hover">
													<div class="slider-hover-content"></div>
													<div class="Orange">
														<div class="slider-hover-content2">
															<h4>Orange Skies</h4>
															<p>Save upto 50%</p>
														</div>
														<div class="slider-hover-content3">
															<a href="#" class="btn slide-btn btn-lg">Avail Now</a>
														</div>
													</div>
												</div>


												<div class="slider-text">
													<div class="slider-text1">
														<h4>Orange Skies</h4>
														<p>Save upto 50%</p>
													</div>
													<div class="slider-text2">
														<a href="#" class="btn slide-btn btn-lg">Avail Now</a>
													</div>
												</div>

											</div>
										</div>
									</div>

									<div class="col-sm-4">
										<div class="row">
											<div class="slider-item homepage-sllider-m">
												<div class="slider-img"><img class="img-responsive" alt="First slide" src="images/slider/slider9.jpg"/></div>
												<div class="slider-text-hover">
													<div class="slider-hover-content"></div>
													<div class="Orange">
														<div class="slider-hover-content2">
															<h4>Orange Skies</h4>
															<p>Save upto 50%</p>
														</div>
														<div class="slider-hover-content3">
															<a href="#" class="btn slide-btn btn-lg">Avail Now</a>
														</div>
													</div>
												</div>
												<div class="slider-text">
													<div class="slider-text1">
														<h4>Orange Skies</h4>
														<p>Save upto 50%</p>
													</div>
													<div class="slider-text2">
														<a href="#" class="btn slide-btn btn-lg">Avail Now</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- label yellow html exit -->

		<!-- label white2 html start -->
		<div class="label-white2">
			<div class="container">
				<div class="row">
					<div class="car-item-wrap">
						<div class="car-type">
							<div class="car-wrap"><img class="private-car" src="images/private-car.png" alt=""/></div>
							<h5>Private Car</h5>
							<div class="car-type-btn">
								<a href="Results_4.html" class="btn car-btn btn-lg">BOOK NOW</a>
							</div>
						</div>

						<div class="car-type">
							 <div class="car-wrap"><img class="morotbike-car" src="images/motorbike.png" alt=""/></div>
							<h5>Motorbike</h5>
							<div class="car-type-btn">
								<a href="Results_4.html" class="btn car-btn btn-lg">BOOK NOW</a>
							</div>
						</div>

						<div class="car-type">
							<div class="car-wrap"> <img class="minicar-car" src="images/minicar.png" alt=""/></div>
							<h5>Minicar</h5>
							<div class="car-type-btn">
								<a href="Results_4.html" class="btn car-btn btn-lg">BOOK NOW</a>
							</div>
						</div>

						<div class="car-type">
							<div class="car-wrap"> <img class="mini-track-car" src="images/mini-track.png" alt=""/></div>
							<h5>Mini Truck</h5>
							<div class="car-type-btn">
								<a href="Results_4.html" class="btn car-btn btn-lg">BOOK NOW</a>
							</div>
						</div>

						<div class="car-type">
							<div class="car-wrap"> <img class="boat-car" src="images/boat.png" alt=""/></div>
							<h5>Boat</h5>
							<div class="car-type-btn">
								<a href="Results_4.html" class="btn car-btn btn-lg">BOOK NOW</a>
							</div>
						</div>

						<div class="car-type">
							<div class="car-wrap"> <img class="snow-car" src="images/snow-bike.png" alt=""/></div>
							<h5>Snow Bike</h5>
							<div class="car-type-btn">
								<a href="Results_4.html" class="btn car-btn btn-lg">BOOK NOW</a>
							</div>
						</div>

						<div class="car-type">
							<div class="car-wrap"> <img class="tractor-car" src="images/tractor.png" alt=""/></div>
							<h5>Tractor</h5>
							<div class="car-type-btn">
								<a href="Results_4.html" class="btn car-btn btn-lg">BOOK NOW</a>
							</div>
						</div>

						<div class="car-type">
							<div class="car-wrap"> <img class="vihicel-car" src="images/vihicel.png" alt=""/></div>
							<h5>Large Vehicle</h5>
							<div class="car-type-btn">
								<a href="Results_4.html" class="btn car-btn btn-lg">BOOK NOW</a>
							</div>
						</div>

						<div class="car-type">
							<div class="car-wrap"> <img class="morotbike-car" src="images/motorbike.png" alt=""/></div>
							<h5>Motorbike</h5>
							<div class="car-type-btn">
								<a href="Results_4.html" class="btn car-btn btn-lg">BOOK NOW</a>
							</div>
						</div>

						<div class="car-type">
							<div class="car-wrap"> <img class="big-track-car" src="images/big-track.png" alt=""/></div>
							<h5>Big Truck</h5>
							<div class="car-type-btn">
								<a href="Results_4.html" class="btn car-btn btn-lg">BOOK NOW</a>
							</div>
						</div>

					</div>

				</div>
			</div>
		</div>
		<!-- label white2 html Exit -->

	<!-- ================ footer html start ================ -->
		<div class="footer custom-footer">
			<div class="container">
				<div class="row">
					<div class="col-sm-7">
						<div class="row">
							<div class="menu-wrap">
								<div class="menu-col">
									<div class="menu-header"><p>About Us</p></div>
									<div class="menu-item">
										<ul>
											<li><a href="page26.html">About</a></li>
											<li><a href="page27.html">Services</a></li>
											<li><a href="page30.html">Career</a></li>
											<li><a href="index.html">Media</a></li>
											<li><a href="">Adverise </a></li>
											<li><a href="">Fleet</a></li>
											<li><a href="">Tariff</a></li>
											<li><a href="">Partners</a></li>
											<li><a href="">About</a></li>
										</ul>
									</div>
								</div>
								<div class="menu-col menu-col-margin">
									<div class="menu-item menu-item2">
										<ul>
											<li><a href="">My Account</a></li>
											<li><a href="">Print Notice</a></li>
											<li><a href="">Vehicle Guide</a></li>
											<li><a href="">Easy Cabs</a></li>
											<li><a href="">About </a></li>
											<li><a href="">Services</a></li>
											<li><a href="">Career</a></li>
											<li><a href="">Media</a></li>
										</ul>
									</div>
								</div>
								<div class="menu-col2">
									<div class="menu-header"><p>Melbourne</p></div>
									<div class="menu-item">
										<ul>
											<li><a href="">97-99 Isabella St</a></li>
											<li><a href="">London SE1 8DD</a></li>
											<li><a href="">United Kingdom</a></li>
											<li class="menu-header menu-item3"><p>Queensland</p></li>
											<li><a href="">Columbo House </a></li>
											<li><a href="">50-60 Blackfriars Rd</a></li>
											<li><a href="">Blackfriars, London</a></li>
										</ul>
									</div>
								</div>
								<div class="menu-col2 responsive-frame642">
									<div class="menu-header"><p>Sydney</p></div>
									<div class="menu-item">
										<ul>
											<li><a href="">14 Gambia St</a></li>
											<li><a href="">Waterloo</a></li>
											<li><a href="">London SE1 0XH, UK</a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-5">
						<div class="row">
							<div class="footer-map-bg">

							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="social-item">
						<a href="#" class="img-circle">
							<i class="fa fa-facebook"></i>
						</a>
						<a href="#" class="img-circle">
							<i class="fa fa-twitter"></i>
						</a>
						<a href="#" class="img-circle">
							<i class="fa fa-tumblr"></i>
						</a>
						<a href="#" class="img-circle">
							<i class="fa fa-twitter"></i>
						</a>
						<a href="#" class="img-circle">
							<i class="fa fa-tumblr"></i>
						</a>
					</div>
					<div class="copy-right">
						<p><span>TAKSI</span> &copy; Copyright 2014 | All Rights Rerved  | Designed by <a href="http://themeforest.net/user/vishnusathyan">Vishnu Sathyan</a> | Developed By <a href="http://www.themeskanon.com/">Themeskanon</a></p>
					</div>
				</div>
			</div>
		</div>
	<!-- ================ footer html Exit ================ -->
		<script src="js/jquery.js"></script>
		<script src="js/menu/jquery.min.js"></script>
		<script src="js/menu/modernizr.custom.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABZeNLu8UPzGj9lZscWP0Fjg--odVUU7I&v3.exp"></script>
		<script src="js/g-map/map.js" type="text/javascript"></script>
		<script src="js/uikit.js" type="text/javascript"></script>   <!-- -->
		<script src="js/jquery.stellar.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/bootstrap-select.js"></script>
		<script src="js/jquery-ui.min.js" type="text/javascript"></script>
		<script src="js/custom.js" type="text/javascript"></script>
		<script src="js/menu/jquery.dlmenu.js"></script>
		<script src="js/menu/custom-menu.js"></script>
	</body>
</html>
