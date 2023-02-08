<!doctype html>
<html lang="zxx">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"/>
        <!-- Owl Carousel CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
        <!-- Owl Carousel Theme Default CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
        <!-- Box Icon CSS-->
        <link rel="stylesheet" href="{{ asset('assets/css/boxicon.min.css') }}">
        <!-- Flaticon CSS-->
        <link rel="stylesheet" href="{{ asset('assets/fonts/flaticon/flaticon.css') }}">
        <!-- Magnific CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
        <!-- Meanmenu CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/meanmenu.css') }}">
        <!-- Nice Select CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
        <!-- Style CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <!-- Responsive CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
        <!-- Title CSS -->
        <title>RUBI - {{ $title }}</title>
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">  
    </head>

    <body>
        <!-- Navbar Area Start -->
        <div class="navbar-area">
            <!-- Menu For Mobile Device -->
            <div class="mobile-nav">
                <a href="{{ route('client.home') }}" class="logo">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="logo">
                </a>
            </div>
        
            <!-- Menu For Desktop Device -->
            <div class="main-nav">
                <div class="container">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="{{ route('client.home') }}">
                            <img src="assets/img/logo.png" alt="logo">
                        </a>
                        <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                            <ul class="navbar-nav m-auto">
                                <li class="nav-item">
                                    <a href="{{ route('client.home') }}" class="nav-link">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('client.careers') }}" class="nav-link ">Careers</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('client.contact') }}" class="nav-link">Contact Us</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('client.about') }}" class="nav-link">About Us</a>
                                </li>
                            </ul>

                            <div class="other-option">
                                <a href="{{ route('client.registration') }}" class="signin-btn">Register My Business</a>
                                <a href="{{ route('client.signin') }}" class="signup-btn">Sign In</a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar Area End -->

        @yield('content')
    
        <!-- Subscribe Section Start -->
        <section class="subscribe-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="section-title">
                            <h2>Newsletter</h2>
                            <p>Subscribe & get all our updates</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <form class="newsletter-form" data-toggle="validator">
                            <input type="email" class="form-control" placeholder="Enter your email" name="EMAIL" required autocomplete="off">
    
                            <button class="default-btn sub-btn" type="submit">
                                Subscribe
                            </button>
    
                            <div id="validator-newsletter" class="form-result"></div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- Subscribe Section End -->

        <!-- Footer Section Start -->
		<footer class="footer-area pt-100 pb-70">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-sm-6">
						<div class="footer-widget">
							<div class="footer-logo">
								<a href="{{ route('client.home') }}">
									<img src="assets/img/logo.png" alt="logo">
								</a>
							</div>

							<p>We offer a comprehensive platform to manage IT, HR, marketing and finance operations.</p>

							<div class="footer-social">
								<a href="#"><i class='bx bxl-facebook'></i></a>
								<a href="#"><i class='bx bxl-linkedin'></i></a>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-sm-6">
						<div class="footer-widget pl-60">
							<h3>Quick Links</h3>
							<ul>
								<li>
									<a href="{{ route('client.home') }}">
										<i class='bx bx-chevrons-right bx-tada'></i>
										Home
									</a>
								</li>
								<li>
									<a href="{{ route('client.about') }}">
										<i class='bx bx-chevrons-right bx-tada'></i>
										About
									</a>
								</li>
								<li>
									<a href="">
										<i class='bx bx-chevrons-right bx-tada'></i>
										FAQ
									</a>
								</li>
								<li>
									<a href="">
										<i class='bx bx-chevrons-right bx-tada'></i>
										Privacy
									</a>
								</li>
								<li>
									<a href="{{ route('client.contact') }}">
										<i class='bx bx-chevrons-right bx-tada'></i>
										Contact
									</a>
								</li>
							</ul>
						</div>
					</div>

					<div class="col-lg-3 col-sm-6">
						<div class="footer-widget footer-info">
							<h3>Contact</h3>
							<ul>
								<li>
									<span>
										<i class='bx bxs-phone'></i>
										Phone:
									</span>
									<a href="#">
										+94 72 9353 066
									</a>
								</li>

								<li>
									<span>
										<i class='bx bxs-envelope'></i>
										Email:
									</span>
									<a href="#">
										bir06720@gmail.com
									</a>
								</li>

								<li>
									<span>
										<i class='bx bx-location-plus'></i>
										Address:
									</span>
									123, Denver, USA
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</footer>
        <div class="copyright-text text-center">
            <p>Copyright @2023 Rubi. All Rights Reserved</p>
        </div>
        <!-- Footer Section End -->

        <!-- Back To Top Start -->
		<div class="top-btn">
			<i class='bx bx-chevrons-up bx-fade-up'></i>
		</div>
		<!-- Back To Top End -->

		<!-- jQuery first, then Bootstrap JS -->
		<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
		<!-- Owl Carousel JS -->
		<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
		<!-- Nice Select JS -->
		<script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
		<!-- Magnific Popup JS -->
		<script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
		<!-- Subscriber Form JS -->
		<script src="{{ asset('assets/js/jquery.ajaxchimp.min.js') }}"></script>
		<!-- Form Velidation JS -->
		<script src="{{ asset('assets/js/form-validator.min.js') }}"></script>
		<!-- Contact Form -->
		<script src="{{ asset('assets/js/contact-form-script.js') }}"></script>
		<!-- Meanmenu JS -->
		<script src="{{ asset('assets/js/meanmenu.js') }}"></script>
		<!-- Custom JS -->
		<script src="{{ asset('assets/js/custom.js') }}"></script>
  	</body>
</html>