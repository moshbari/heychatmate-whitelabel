<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>@yield('title') | {{ get_settings('system_title') }}</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ asset('assets/front/images/home/' . get_settings('system_favicon')) }}" />

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/LineIcons.3.0.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/tiny-slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/glightbox.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/main.css') }}" />
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.min.css" rel="stylesheet">

</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- /End Preloader -->

    <!-- Start Header Area -->
    <header class="header navbar-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <div class="nav-inner">
                        <!-- Start Navbar -->
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="{{ route('front.index') }}">
                                <img src="{{ asset('assets/front/images/home/' . get_settings('system_logo')) }}"
                                    alt="Logo">
                            </a>
                            <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a href="{{ route('front.index') }}" class="active"
                                            aria-label="Toggle navigation">Home</a>
                                    </li>

                                    @foreach (systemPages('header_link') as $page)
                                        <li class="nav-item">
                                            <a href="{{ route('front.page', $page->slug) }}"
                                                aria-label="Toggle navigation">{{ $page->name }}</a>
                                        </li>
                                    @endforeach

                                </ul>
                            </div> <!-- navbar collapse -->
                            <div class="button home-btn">
                                @auth

                                    <a href="{{ route('user.dashboard') }}" class="btn">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn">Login</a>
                                @endauth

                            </div>
                        </nav>
                        <!-- End Navbar -->
                    </div>
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </header>
    <!-- End Header Area -->


    @yield('content')



    <!-- Start Footer Area -->
    <footer class="footer section">
        <!-- Start Footer Top -->
        <div class="footer-top">
            <div class="container">
                <div class="inner-content">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-about">
                                <div class="logo">
                                    <a href="{{ route('front.index') }}">
                                        <img src="{{ asset('assets/front/images/home/' . get_settings('system_logo')) }}"
                                            alt="#">
                                    </a>
                                </div>
                                <p>Making the world a better place through constructing elegant hierarchies.</p>
                                <h4 class="social-title">Follow Us On:</h4>
                                <ul class="social">
                                    <li><a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="lni lni-instagram"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="lni lni-linkedin-original"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="lni lni-pinterest"></i></a></li>
                                    <li><a href="javascript:void(0)"><i class="lni lni-youtube"></i></a></li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-4 col-md-6 col-12 text-center">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                                <h3>Usefull Links</h3>
                                <ul>
                                    @foreach (systemPages('footer_link') as $page)
                                        <li><a href="{{ route('front.page', $page->slug) }}">{{ $page->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer newsletter">
                                <h3>Subscribe</h3>
                                <p>Subscribe to our newsletter for the latest updates</p>
                                <form action="{{route('subscribe.submit')}}" method="post" id="myForm1" class="newsletter-form">
                                  @csrf
                                    <input name="email" placeholder="Email address" required="required"
                                        type="email">
                                    <div class="button">
                                        <button class="sub-btn"><i class="lni lni-envelope"></i>
                                        </button>
                                    </div>
                                <div id="output1"></div>
                                </form>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ End Footer Top -->
        <!-- Start Copyright Area -->
        <div class="copyright-area">
            <div class="container">
                <div class="inner-content">
                    <div class="row text-center">
                        <div class="col-lg-12 col-md-6 col-12">
                            <p class="copyright-text">{{ get_settings('copyright_text') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Copyright Area -->
    </footer>
    <!--/ End Footer Area -->

    <!-- ========================= scroll-top ========================= -->
    <a href="#" class="scroll-top">
        <i class="lni lni-chevron-up"></i>
    </a>

    <!-- ========================= JS here ========================= -->
    <script src="{{ asset('assets/front/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/tiny-slider.js') }}"></script>
    <script src="{{ asset('assets/front/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/count-up.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/main.js') }}"></script>
       <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.all.min.js"></script>
    <script>


$(document).ready(function() {
  var options = {
    target:        '#output1',   // target element(s) to be updated with server response
    //beforeSubmit:  showRequest,  // pre-submit callback
    success:       showResponse  // post-submit callback
  };

  // bind form using 'ajaxForm'
  $('#myForm1').ajaxForm(options);
});

// post-submit callback
function showResponse(responseText, statusText, xhr, $form)  {

}



        //========= testimonial
        tns({
            container: '.testimonial-slider',
            items: 3,
            slideBy: 'page',
            autoplay: false,
            mouseDrag: true,
            gutter: 0,
            nav: true,
            controls: false,
            responsive: {
                0: {
                    items: 1,
                },
                540: {
                    items: 1,
                },
                768: {
                    items: 2,
                },
                992: {
                    items: 2,
                },
                1170: {
                    items: 3,
                }
            }
        });

        //====== counter up
        var cu = new counterUp({
            start: 0,
            duration: 2000,
            intvalues: true,
            interval: 100,
            append: " ",
        });
        cu.start();

        //========= glightbox
        GLightbox({
            'href': 'https://www.youtube.com/watch?v=r44RKWyfcFw&fbclid=IwAR21beSJORalzmzokxDRcGfkZA1AtRTE__l5N4r09HcGS5Y6vOluyouM9EM',
            'type': 'video',
            'source': 'youtube', //vimeo, youtube or local
            'width': 900,
            'autoplayVideos': true,
        });
    </script>
    @yield('page-script')
</body>

</html>
