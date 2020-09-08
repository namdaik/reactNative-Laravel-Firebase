<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Quick Order, Fire Team & Fpoly</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/logo.png')}}">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="{{asset('assets/home/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/home/css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/home/css/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('assets/home/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/home/css/aos.css')}}">
    <link rel="stylesheet" href="{{asset('assets/home/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{asset('assets/home/css/flaticon.css')}}">
    <link rel="stylesheet" href="{{asset('assets/home/css/meanmenu.css')}}">
    <link rel="stylesheet" href="{{asset('assets/home/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('assets/home/css/default.css')}}">
    <link rel="stylesheet" href="{{asset('assets/home/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/home/css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>

<body>

    <!-- preloader  -->
    <div id="preloader">
        <div id="ctn-preloader" class="ctn-preloader">
            <div class="animation-preloader">
                <div class="spinner"></div>
                <div class="txt-loading">
                    <span data-text-preloader="Q" class="letters-loading">
                        Q
                    </span>
                    <span data-text-preloader="U" class="letters-loading">
                        U
                    </span>
                    <span data-text-preloader="I" class="letters-loading">
                        I
                    </span>
                    <span data-text-preloader="C" class="letters-loading">
                        C
                    </span>
                    <span data-text-preloader="K" class="letters-loading">
                        K
                    </span>
                    <span data-text-preloader="O" class="letters-loading">
                        O
                    </span>
                    <span data-text-preloader="R" class="letters-loading">
                        R
                    </span>
                    <span data-text-preloader="D" class="letters-loading">
                        D
                    </span>
                    <span data-text-preloader="E" class="letters-loading">
                        E
                    </span>
                    <span data-text-preloader="R" class="letters-loading">
                        R
                    </span>
                </div>
            </div>
            <div class="loader">
                <div class="row">
                    <div class="col-3 loader-section section-left">
                        <div class="bg"></div>
                    </div>
                    <div class="col-3 loader-section section-left">
                        <div class="bg"></div>
                    </div>
                    <div class="col-3 loader-section section-right">
                        <div class="bg"></div>
                    </div>
                    <div class="col-3 loader-section section-right">
                        <div class="bg"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- preloader end -->

    <!-- header-start -->
    <header>
        <div class="header-top-wrap purple-bg d-none d-md-block">
            <div class="container-fluid header-container-p">
                <div class="row">
                    <div class="col-xl-6 col-lg-7 col-md-6">
                        <div class="header-contact">
                            <ul>
                                <li><i class="fas fa-headphones"></i>Call us +849 8491 8726 </li>
                                <li><i class="far fa-envelope"></i><a href="/cdn-cgi/l/email-protection"
                                        class="__cf_email__"
                                        data-cfemail="d685a2b7a4a2b7a5bd96bfb8b0b9f8b5b9bb">[&#160;quickorderteam@gmail.com]</a>
                                </li>
                                <li><i class="fas fa-map-marker"></i>Ha Noi-Viet Nam</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-5 col-md-6">
                        <div class="header-top-right d-flex justify-content-end align-items-center">
                            <div class="header-social">
                                <ul>
                                <li><a href="{{url('/')}}">Homepage</a></li>
                                </ul>
                            </div>
                            <div class="header-social">
                                <ul>
                                    <li><a href="{{url('/login')}}">Login</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header-start-end -->

    <!-- main-area -->
    <main>

        <!-- slider-area -->
        <section class="slider-area">
            <div class="slider-active">
                <div class="single-slider slider-bg d-flex align-items-center">
                    <div class="slider-overlay-bg"></div>
                    <div class="slider-bg-shape"></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-xl-10 col-lg-11">
                                <div class="slider-content text-center">
                                    <h2 data-animation="fadeInUpS" data-delay=".3s">Quick Order</h2>
                                    <p data-animation="fadeInUpS" data-delay=".6s">
                                        My team brings quick order service. Always aiming for customer satisfaction
                                        criteria</p>
                                    <div class="slider-form" data-animation="fadeInUpS" data-delay=".9s">
                                        <form method="post" action="{{url('search-order-blade')}}">
                                            @csrf
                                            <input type="text" name="order_id" placeholder="Enter way bill">
                                            <button type="submit" class="btn">Tracking</button>
                                        </form>
                                    </div>
                                    @error('order_id')
                                        <div class="text-danger mt-2 mb-3 h5">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="single-slider slider-bg slider-video-overlay d-flex align-items-center youtube-bg"
                    data-property="{videoURL:'enKKcVrPGs0',}">
                    <div class="slider-overlay-bg"></div>
                    <div class="slider-bg-shape"></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-xl-10 col-lg-11">
                                <div class="slider-content text-center">
                                    <h2 data-animation="fadeInUpS" data-delay=".3s">Quick Order</h2>
                                    <p data-animation="fadeInUpS" data-delay=".6s">
                                        My team brings quick order service. Always aiming for customer satisfaction
                                        criteria</p>
                                    <div class="slider-form" data-animation="fadeInUpS" data-delay=".9s">
                                        <form method="post" action="{{url('search-order-blade')}}">
                <input type="text" placeholder="Tracking id">
                <button type="submit" class="btn">Tracking</button>
                @error('order_id')
                <div class="text-danger mt-2 mb-3 h5">{{ $message }}</div>
                @enderror
                </form>
            </div>
            </div>
            </div>
            </div>
            </div>
            </div> --}}
            </div>
        </section>

        <!-- category-area -->
        <section class="category-area">
            <div class="container">
                <div class="category-bg">
                    <div class="row">
                        <div class="col-12">
                            <div class="category-list">
                                <ul>
                                    <li>
                                        <a href="#">
                                            <div class="category-icon">
                                                <i class="flaticon-cruise"></i>
                                            </div>
                                            <h5>Sea Freight</h5>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="service-air.html">
                                            <div class="category-icon">
                                                <i class="flaticon-air-freight"></i>
                                            </div>
                                            <h5>Air Freight</h5>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="category-icon">
                                                <i class="flaticon-delivery-1"></i>
                                            </div>
                                            <h5>Insurance</h5>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="category-icon">
                                                <i class="flaticon-warehouse"></i>
                                            </div>
                                            <h5>Warehousing</h5>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="category-icon">
                                                <i class="flaticon-package"></i>
                                            </div>
                                            <h5>Forwarding</h5>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- category-area-end -->

        <!-- about-area -->
        <section class="about-area about-bg">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="section-title text-center mb-0">
                        <h2>Order Progress</h2>
                        <p>
                            Follow the steps below and you will have a great experience with our system</p>
                    </div>
                </div>
            </div>
            <div class="page">
                <div class="timeline">
                    <div class="timeline__group">
                        <span class="timeline__year">Step 1: Create an order</span>
                        <div class="timeline__box">
                            <div class="timeline__date">
                                <span class="timeline__day"></span>
                                <span class="timeline__month">Home</span>
                            </div>
                            <div class="timeline__post">
                                <div class="timeline__content">
                                    <p>Enter the order specifications (length, width, height ...)
                                        and you are ready to confirm the order and bring it to the transaction point to
                                        confirm
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="timeline__box">
                            <div class="timeline__date">
                                <span class="timeline__day"></span>
                                <span class="timeline__month">Point</span>
                            </div>
                            <div class="timeline__post">
                                <div class="timeline__content">
                                    <p>Bring the order to the transaction point and all work will be performed by us
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="timeline__group">
                        <span class="timeline__year">Step 2: Confirm the order</span>
                        <div class="timeline__box">
                            <div class="timeline__date">
                                <span class="timeline__day">5</span>
                                <span class="timeline__month">Minute</span>
                            </div>
                            <div class="timeline__post">
                                <div class="timeline__content">
                                    <p>If your order has not been confirmed, please bring it to the transaction point
                                        immediately,
                                        we will confirm your shipping order in 2 steps.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="timeline__group">
                        <span class="timeline__year">Step 3: Check the order</span>
                        <div class="timeline__box">
                            <div class="timeline__date">
                                <span class="timeline__day"></span>
                                <span class="timeline__month">App</span>
                            </div>
                            <div class="timeline__post">
                                <div class="timeline__content">
                                    <p>Check orders on your own phone via our app,
                                        just enter the order code and you will know the exact location of the order
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="timeline__box">
                            <div class="timeline__date">
                                <span class="timeline__day"></span>
                                <span class="timeline__month">Website</span>
                            </div>
                            <div class="timeline__post">
                                <div class="timeline__content">
                                    <p>Go to the homepage, and enter your order id to check.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="timeline__group">
                        <span class="timeline__year">Step 4</span>
                        <div class="timeline__box">
                            <div class="timeline__date">
                                <span class="timeline__day"></span>
                                <span class="timeline__month">Done</span>
                            </div>
                            <div class="timeline__post">
                                <div class="timeline__content">
                                    <p>We will send you a notice. You will know if the order has arrived
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="timeline__box">
                            <div class="timeline__date">
                                <span class="timeline__day"></span>
                                <span class="timeline__month">Failed</span>
                            </div>
                            <div class="timeline__post">
                                <div class="timeline__content">
                                    <p>Don't worry, we will send your order back to you
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- about-area-end -->

        <!-- step-area -->


        </div>

        <!-- step-area-end -->

        <!-- brand-area -->
        <div class="brand-area pt-120 pb-120">
            <div class="container">
                <div class="row brand-active">
                    <div class="col-12">
                        <div class="signle-brand">
                            <img src="{{asset('assets/home/img/brand/brnad_logo01.png')}}" alt="img">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="signle-brand">
                            <img src="{{asset('assets/home/img/brand/brnad_logo02.png')}}" alt="img">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="signle-brand">
                            <img src="{{asset('assets/home/img/brand/brnad_logo03.png')}}" alt="img">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="signle-brand">
                            <img src="{{asset('assets/home/img/brand/brnad_logo04.png')}}" alt="img">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="signle-brand">
                            <img src="{{asset('assets/home/img/brand/brnad_logo05.png')}}" alt="img">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="signle-brand">
                            <img src="{{asset('assets/home/img/brand/brnad_logo03.png')}}" alt="img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- brand-area-end -->



    </main>
    <!-- main-area-end -->

    <!-- footer -->
    <footer>
        <div class="footer-wrap pt-190 pb-40" data-background="img/bg/footer_bg.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="footer-widget mb-50">
                            <div class="footer-logo mb-35">
                                <a href="index.html"><img src="{{asset('assets/images/logo.png')}}"
                                        alt="img" width="50px" height="50px"></a>
                            </div>
                            <div class="footer-text">
                                <p>Quick Order, easily, effective. Experience our service and you'll love it
                                </p>
                            </div>
                            <div class="footer-social">
                                <ul>
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="footer-widget mb-50">
                            <div class="fw-title mb-30">
                                <h5>UPDATE NEWS</h5>
                            </div>
                            <div class="f-rc-post">
                                <ul>
                                    <li>
                                        <div class="f-rc-content">
                                            <span>2 may, 2020</span>
                                            <h5><a href="#">Order progress</a></h5>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="footer-widget mb-50">
                            <div class="fw-title mb-30">
                                <h5>USEFUL LINKS</h5>
                            </div>
                            <div class="fw-link">
                                <ul>
                                <li><a href="{{url('/')}}"><i class="fas fa-caret-right"></i> Homepage</a></li>
                                    <li><a href="{{url('/login')}}"><i class="fas fa-caret-right"></i> Login</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="footer-widget mb-50">
                            <div class="fw-title mb-30">
                                <h5>Support & Downloads</h5>
                            </div>
                            <div class="f-support-content">
                                <p>Download android app and use it to order
                                </p>
                                <a href="#" class="f-download-btn"><img
                                        src="{{asset('assets/home/img/images/f_download_btn02.png')}}" alt="img"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-wrap">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-7">
                        <div class="copyright-text">
                            <p>Copyright© <span>Quick Order </span> | Fire Team</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5">
                        <div class="f-payment-method text-center text-md-right">
                            <img src="{{asset('assets/home/img/images/card_img.png')}}" alt="img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer-end -->




    <!-- JS here -->
    <script src="{{asset('assets/home/js/vendor/jquery-1.12.4.min.js')}}"></script>
    <script src="{{asset('assets/home/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/home/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/home/js/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('assets/home/js/slick.min.js')}}"></script>
    <script src="{{asset('assets/home/js/jquery.meanmenu.min.js')}}"></script>
    <script src="{{asset('assets/home/js/wow.min.js')}}"></script>
    <script src="{{asset('assets/home/js/aos.js')}}"></script>
    <script src="{{asset('assets/home/js/paroller.js')}}"></script>
    <script src="{{asset('assets/home/js/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('assets/home/js/jquery.counterup.min.js')}}"></script>
    <script src="{{asset('assets/home/js/jquery.nice-select.min.js')}}"></script>
    <script src="{{asset('assets/home/js/jquery.scrollUp.min.js')}}"></script>
    <script src="{{asset('assets/home/js/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{asset('assets/home/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('assets/home/js/plugins.js')}}"></script>
    <script src="{{asset('assets/home/js/main.js')}}"></script>
</body>

</html>
