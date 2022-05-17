<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>FHP</title>
    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/front/css/style-freedom.css') ?>">
    <script src="<?= base_url('assets/front/js/jquery-3.3.1.min.js') ?>"></script>
    <script src="<?= base_url('assets/front/js/bootstrap.min.js') ?>"></script>
  </head>
  <body>
<meta name="robots" content="noindex">
<body>
<section class="w3l-bootstrap-header">
  <nav class="navbar navbar-expand-lg navbar-light sub-content">
    <div class="container">
      <a class="navbar-brand" href="index.html">
        <img src="assets/front/images/logo.png" alt="Your logo" title="Your logo" style="height:60px;" />
      </a>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.html">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#about">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#services">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#testi">Testimonial</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contact">Contact</a>
          </li>
        </ul>
      </div>
      <!-- Button trigger modal -->

    </div>
  </nav>
  
</section>
<section class="w3l-main-slider" id="home">
  <!-- main-slider -->
  <div class="companies20-content">
    <div class="companies-wrapper"></div>
    <div class="owl-one owl-carousel owl-theme">
      <div class="item">
        <li class="banner-view banner-top1 bg bg2">
          <div class="slider-info">
            <div class="banner-info">
              <div class="container">
                <div class="banner-info-bg">
                  <div class="row align-items-center py-lg-5 py-3">
                    <div class="col-lg-6 col-md-8 content-left">
                      <!-- <h3 lass="sub-title-top">Quality Windows </h3>
                      <h3 lass="sub-title-top">& Doors !</h3>
                      <p>Ut posuere aliquet erat, non interdum lectus. Donec enim lectus, elementum sit amet magna
                        faucibus.</p> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </li>
      </div>
      <div class="item">
        <li class="banner-view banner-top3 bg bg2">
          <div class="slider-info">
            <div class="banner-info">
              <div class="container">
                <div class="banner-info-bg">
                  <div class="row align-items-center py-lg-5 py-3">
                    <div class="col-lg-6 col-md-8 content-left">
                      <!-- <h3 lass="sub-title-top">Explore Premium</h3>
                      <h3 lass="sub-title-top"> Windows</h3>
                      <p>Ut posuere aliquet erat, non interdum lectus. Donec enim lectus, elementum sit amet magna
                        faucibus.</p> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </li>
      </div>
      <div class="item">
        <li class="banner-view banner-top2 bg bg2">
          <div class="slider-info">
            <div class="banner-info">
              <div class="container">
                <div class="banner-info-bg">
                  <div class="row align-items-center py-lg-5 py-3">
                    <div class="col-lg-6 col-md-8 content-left">
                       <!--  <h3 lass="sub-title-top">Windows & Doors </h3>
                        <h3 lass="sub-title-top"> Specialists! </h3>
                        <p>Ut posuere aliquet erat, non interdum lectus. Donec enim lectus, elementum sit amet magna
                          faucibus.</p> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>

  <script src="<?= base_url('assets/front/js/owl.carousel.js') ?>"></script>

  <!-- script for -->
  <script>
    $(document).ready(function () {
      $('.owl-one').owlCarousel({
        loop: true,
        margin: 0,
        nav: false,
        responsiveClass: true,
        autoplay: false,
        autoplayTimeout: 5000,
        autoplaySpeed: 1000,
        autoplayHoverPause: false,
        responsive: {
          0: {
            items: 1,
            nav: false
          },
          480: {
            items: 1,
            nav: false
          },
          667: {
            items: 1,
            nav: true
          },
          1000: {
            items: 1,
            nav: true
          }
        }
      })
    })
  </script>
  <!-- //script -->
  <!-- /main-slider -->
</section>
<section class="w3l-text-6 py-5" id="about">
  <div class="text-6-mian py-md-5">
    <div class="container">
      <div class="row top-cont-grid align-items-center">
        <div class="col-lg-6 left-img pr-lg-4">
          <img src="assets/front/images/index2.png" alt="" class="img-responsive img-fluid" />
        </div>
        <div class="col-lg-6 text-6-info mt-lg-0 mt-4">
          <h6>Welcome to FHP</h6>
          <h2>FHP is Ahmedabad based services provider Pletform , founded by <span>Harsh Patel And Brijesh Patel</span></h2>
          <p>With an idea of “Foreever Happy People ” FHP is home solution providing company. With FHP APP avalibale in Plystore you can book your desired home service like electrician, plumber, carpenter, cleaner, painter, AC repair, Washing machine repair, and so many other services which serve directly to your door step in your desired timeslot and on affordable prices. In this way ezhomerservices.in makes your life easy and full of comfort. Customer trust and safety is our profit so we have strict criteria for our vendors and supportive staff who are professionals and authenticated and verified by Police administration.</p>
          <p>We are available 24*7 to assist you any time anywhere.and book memebrship to conect with as</p>
          
        </div>
        <h3>Our Technicians</h3>
          <p>We know the value of customer and their relation with us so we used to maintain our contact through our customer for regular inspection of services that we had provide already.</p>
          <p>Our technicians are highly skilled well equipped and also verified by state police commission in this way we also take care of our customer and provide comfort and safe zone with trust and happiness.</p>
      </div>
    </div>

  </div>

</section>

<!-- index-block2 -->
<section class="w3l-index-block2" id="services">
  <div class="container py-3">
    <div class="heading text-center mx-auto">
      <h3 class="head">Services </h3>
    </div>
    <div class="row bottom_grids mt-5 pt-lg-3">
      <div class="col-lg-4 col-md-6">
        <div class="s-block">
          <img src="assets/front/images/electrical.jpg" alt="" class="img-fluid" />
          <div class="p-4">
            <h3 class="mb-3">Electric Service</h3>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 mt-md-0 mt-4">
        <div class="s-block">
          <img src="assets/front/images/plumbing.jpg" alt="" class="img-fluid" />
          <div class="p-4">
            <h3 class="mb-3">Plumbing Service</h3>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 mx-auto mt-lg-0 mt-4">
        <div class="s-block">
          <img src="assets/front/images/air.jpg" alt="" class="img-fluid" />
          <div class="p-4">
            <h3 class="mb-3">Air Conditioner Service</h3>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 mx-auto mt-lg-0 mt-4">
        <div class="s-block">
          <img src="assets/front/images/contractor.jpg" alt="" class="img-fluid" />
          <div class="p-4">
            <h3 class="mb-3">Carpenters Service</h3>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 mx-auto mt-lg-0 mt-4">
        <div class="s-block">
          <img src="assets/front/images/cleaning.jpg" alt="" class="img-fluid" />
          <div class="p-4">
            <h3 class="mb-3">Cleaning Services</h3>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 mx-auto mt-lg-0 mt-4">
        <div class="s-block">
          <img src="assets/front/images/salon.jpg" alt="" class="img-fluid" />
          <div class="p-4">
            <h3 class="mb-3">Salon Services</h3>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="w3l-index-block7">
  <div class="sub-content py-5">
    <div class="container py-md-5">
      <div class="row cwp17-two align-items-center">
        <div class="col-md-6 cwp17-text">
          <h2>“ We are available on ”</h2>
          <p>We are now at a stage where technology and human touch is getting more and more incorporate with each other. At FHP we believe in technology and offer multiple touch-point for customers to book service, track service status and get all service related information with the ease of Android.</p>
        </div>
        <div class="col-md-6 cwp17-image">
          <img src="assets/front/images/frame.png" class="img-fluid" alt="" />
        </div>
      </div>
    </div>
  </div>
</section>
<div class="w3l-cutomer-main-cont" id="testi">
    <div class="testimonials text-center py-5">
        <div class="container py-md-5">
            <div class="heading text-center mx-auto">
                <h3 class="head">Customers Say</h3>
            </div>
            <div class="row content-sec mt-md-5 mt-4">
                <div class="col-lg-4 col-md-6 testi-sections">
                    <div class="testimonials_grid">
                        <p class="sub-test"><span class="fa fa-quote-left mr-2" aria-hidden="true"></span>The technician did a good job. He repaired our AC properly.
                        </p>
                        <div class="d-grid sub-author-con">
                            <div class="testi-img-res">
                            </div>
                            <div class="testi_grid text-left">
                                <h5 class="mb-1">Adarsh</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt-md-0 mt-4 testi-sections">
                    <div class="testimonials_grid">
                        <p class="sub-test"><span class="fa fa-quote-left mr-2" aria-hidden="true"></span>I was using Urban Clap earlier, I used FHP  for last couple of times and I regret why I didn’t switched earlier. Quick execution and very reasonable price.
                        </p>
                        <div class="d-grid sub-author-con">
                            <div class="testi-img-res">
                            </div>
                            <div class="testi_grid text-left">
                                <h5 class="mb-1">Darshil</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt-lg-0 mt-4 testi-sections">
                    <div class="testimonials_grid">
                        <p class="sub-test"><span class="fa fa-quote-left mr-2" aria-hidden="true"></span>Keep it up ! Thanks for the quick, good and reliable service for carpentry.
                        </p>
                        <div class="d-grid sub-author-con">
                            <div class="testi-img-res">
                            </div>
                            <div class="testi_grid text-left">
                                <h5 class="mb-1">Bhavik</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- footer -->
<section class="w3l-footer-16" id="contact">
  <div class="w3l-footer-16-main">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-3 col-md-6 col-7 column pr-lg-0">
              <a class="logo" href="index.html"><span class="fa fa-window-restore logo-icon"
                  aria-hidden="true"></span><span class="ml-2"><span class="logo-let">F</span>HP</span></a></a>
              <p class="mt-4">With an idea of “Foreever Happy People ” FHP is home solution providing company. With FHP APP avalibale in Plystore you can book your desired home service like electrician, plumber, carpenter, cleaner, painter, AC repair, Washing machine repair, and so many other services which serve directly to your door step in your desired timeslot and on affordable prices. </p>
            </div>
            <div class="col-lg-2 col-md-6 col-5 column pr-lg-0">
              <h3>Pages</h3>
              <ul class="footer-gd-16">
                <li><a href="index.html">Home</a></li>
                <li><a href="#about">About Us</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#testi">Testimonial</a></li>
                <li><a href="#contact">Contact Us</a></li>
              </ul>
            </div>
            <div class="col-lg-3 col-md-6 col-7 column pr-lg-0 location">
              <h3>Contact Us</h3>
              <i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;
              <span>Shop no - 2 , Nilmani Shopping , sonal cross road , Gurukul Road, Memnagar ,Ahmedabad - 380052</span><br><br>
              <i class="fa fa-phone" aria-hidden="true"></i>&nbsp;
              <span>(+91) 99134 44200</span><br><br>
              <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;
              <span>Support@myfhp.in</span>
            </div>
            <div class="col-lg-4 col-md-6 column column4 mt-lg-0 mt-4">
              <h3>Get Download User Application </h3>
              <a href=""><img src="assets/front/images/play-store.png"></a><br><br>
              <h3>Get Download Partner Application </h3>
              <a href=""><img src="assets/front/images/play-store.png"></a>
            </div>
          </div>
        </div>
        
      </div>
      <div class="d-flex below-section justify-content-between align-items-center pt-4 mt-5">
        <div class="columns text-left">
          <p>@ 2020 FHP. All rights reserved.
          </p>
        </div>
        <div class="columns-2 mt-md-0 mt-3">
          <ul class="social">
            <li><a href="#facebook"><span class="fa fa-facebook" aria-hidden="true"></span></a>
            </li>
            <li><a href="#linkedin"><span class="fa fa-linkedin" aria-hidden="true"></span></a>
            </li>
            <li><a href="#twitter"><span class="fa fa-twitter" aria-hidden="true"></span></a>
            </li>
            <li><a href="#google"><span class="fa fa-google-plus" aria-hidden="true"></span></a>
            </li>
            <li><a href="#github"><span class="fa fa-github" aria-hidden="true"></span></a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- //footer -->
</body>
</html>