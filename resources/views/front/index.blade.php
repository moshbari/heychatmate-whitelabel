@extends('layouts/front/master')

@section('title', 'Home')

@section('content')
    <!-- Start Hero Area -->
    <section class="hero-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-12 col-12">
                    <div class="hero-content">
                        <h4>{{ get_settings('welcome_small_title') }}</h4>
                        <h1>{{ get_settings('welcome_title') }}</h1>
                        <p>{{ get_settings('welcome_subtitle') }}</p>
                        <div class="button">
                            <a href="{{ route('login') }}" class="btn ">Get Started Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-12">
                    <div class="hero-image wow fadeInRight" data-wow-delay=".4s">
                        <video width="100%" autoplay="" muted="" loop="" playsinline="">
                            <source src="{{ asset('assets/front/images/home/' . get_settings('welcome_video')) }}"
                                type="video/mp4">
                            Your browser does not support HTML video.
                        </video>

                        {{-- <img class="main-image" src="https://via.placeholder.com/700x1000" alt="#"> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero Area -->


    <!-- Start Services Area -->
    <div class="services section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">{{ get_settings('why_section_title') }}</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">{{ get_settings('why_section_subtitle') }}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($whys as $why)
                    <div class="col-lg-4 col-md-6 col-12 wow fadeInUp" data-wow-delay=".2s">
                        <div class="single-service">
                            <div class="main-icon">
                                <img src="{{ asset('assets/front/images/home/' . $why->icon) }}" alt="icon">
                            </div>
                            <h4 class="text-title">{{ $why->title }}</h4>
                            <p>{{ $why->text }}</p>
                        </div>
                    </div>
                @endforeach



            </div>
        </div>
    </div>
    <!-- End Services Area -->



    <section id="details" class="howitworks section details">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">{{ get_settings('how_section_title') }}</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">{{ get_settings('how_section_subtitle') }}
                        </p>
                    </div>
                </div>
            </div>
            @php
                $i = 1;
            @endphp

            @foreach ($hows as $how)
                @if ($i)
                    <div class="row content wow fadeInUp" data-wow-delay=".4s">
                        <div class="col-md-5">
                            <img src="{{ asset('assets/front/images/home/' . $how->image) }}" class="img-fluid"
                                alt="">
                        </div>
                        <div class="col-md-7 pt-4 aos-init aos-animate" data-aos="fade-up">
                            <h3>{{ $how->title }}</h3>
                            <p class="fst-italic">{{ $how->text }}</p>
                        </div>
                    </div>
                    @if ($loop->last)
                    @else
                        <div class="narrow">

                            <div class="chevron"></div>
                            <div class="chevron"></div>
                            <div class="chevron"></div>
                        </div>
                    @endif
                    @php
                        $i = 0;
                    @endphp
                @else
                    <div class="row content wow fadeInUp">
                        <div class="col-md-5 order-1 order-md-2" data-aos="fade-left">
                            <img src="{{ asset('assets/front/images/home/' . $how->image) }}" class="img-fluid"
                                alt="">
                        </div>
                        <div class="col-md-7 pt-5 order-2 order-md-1 aos-init aos-animate" data-aos="fade-up">

                            <h3>{{ $how->title }}</h3>
                            <p class="fst-italic">{{ $how->text }}</p>
                        </div>
                    </div>
                    @if ($loop->last)
                    @else
                        <div class="narrow">

                            <div class="chevron"></div>
                            <div class="chevron"></div>
                            <div class="chevron"></div>
                        </div>
                    @endif
                    @php
                        $i = 1;
                    @endphp
                @endif
            @endforeach




        </div>
    </section>


    {{--

    <!-- Start Features Area -->
    <section class="freatures section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-12">
                    <div class="image wow fadeInLeft" data-wow-delay=".3s">
                        <img src="https://via.placeholder.com/665x790" alt="#">
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="content">
                        <h3 class="heading wow fadeInUp" data-wow-delay=".5s"><span>Core Features</span>Designed & built
                            by
                            the<br> latest code
                            integration</h3>
                        <!-- Start Single Feature -->
                        <div class="single-feature wow fadeInUp" data-wow-delay=".6s">
                            <div class="f-icon">
                                <i class="lni lni-dashboard"></i>
                            </div>
                            <h4>Fast performance</h4>
                            <p>Get your blood tests delivered at
                                home collect a sample from the
                                news your blood tests</p>
                        </div>
                        <!-- End Single Feature -->
                        <!-- Start Single Feature -->
                        <div class="single-feature wow fadeInUp" data-wow-delay=".7s">
                            <div class="f-icon">
                                <i class="lni lni-pencil-alt"></i>
                            </div>
                            <h4>Prototyping</h4>
                            <p>Get your blood tests delivered at
                                home collect a sample from the
                                news your blood tests</p>
                        </div>
                        <!-- End Single Feature -->
                        <!-- Start Single Feature -->
                        <div class="single-feature wow fadeInUp" data-wow-delay="0.8s">
                            <div class="f-icon">
                                <i class="lni lni-vector"></i>
                            </div>
                            <h4>Vector Editing</h4>
                            <p>Get your blood tests delivered at
                                home collect a sample from the
                                news your blood tests</p>
                        </div>
                        <!-- End Single Feature -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Features Area --> --}}



    <!-- Start Pricing Table Area -->
    <section id="pricing" class="pricing-table section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Pricing & Plans</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">There are many variations of passages of Lorem
                            Ipsum available, but the majority have suffered alteration in some form.</p>
                    </div>
                </div>
            </div>

            <div class="nav nav-tabs mb-3 wow fadeInUp justify-content-center" id="nav-tab" role="tablist">
                @foreach ($plans as $type => $value)
                    <button class="nav-link {{ $type == 'month' ? 'active' : '' }}" id="nav-{{ $type }}-tab"
                        data-bs-toggle="tab" data-bs-target="#nav-{{ $type }}" type="button" role="tab"
                        aria-controls="nav-{{ $type }}"
                        aria-selected="true">{{ get_settings($type . '_plan_title') }}</button>
                @endforeach


                {{-- <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</button> --}}
                {{-- <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button> --}}
            </div>

            <div class="tab-content p-3 wow fadeInUp" id="nav-tabContent">
                @foreach ($plans as $type => $data)
                    <div class="tab-pane fade {{ $type == 'month' ? 'active show' : '' }}" id="nav-{{ $type }}"
                        role="tabpanel" aria-labelledby="nav-{{ $type }}-tab">

                        <div class="row">
                            @foreach ($data as $key => $plan)
                                <div class="col-lg-4 col-md-6 col-12" data-wow-delay=".4s">
                                    <!-- Single Table -->
                                    <div class="single-table">
                                        <!-- Table Head -->
                                        <div class="table-head">
                                            <h4 class="title">{{ $plan->name }}</h4>
                                            <p class="sub-title">{{ $plan->subtitle }}</p>
                                            <div class="price">
                                                <h2 class="amount"><span
                                                        class="currency">{{ get_settings('currency_sign') }}</span>{{$plan->price}}<span
                                                        class="duration">/{{ $type }}</span>
                                                </h2>
                                            </div>
                                        </div>
                                        <!-- End Table Head -->
                                        <!-- Start Table Content -->
                                        <div class="table-content">
                                            <!-- Table List -->
                                            <ul class="table-list">
                                                @if ($plan->features)
                                                    @foreach (explode(',', $plan->features) as $item)
                                                        <li>{{ $item }}</li>
                                                    @endforeach
                                                @endif

                                            </ul>
                                            <!-- End Table List -->
                                        </div>
                                        <!-- End Table Content -->
                                        <div class="button">
                                            @if ($type != 'credit')
                                                @auth()
                                                    @if (auth()->user()->hasActiveSubscription() && auth()->user()->subscription->plan_id == $plan->id)
                                                        <a href="javascript:void(0);" class="btn"
                                                            style="color: #fff;background-color: #081828;">Current
                                                            Plan</a>
                                                    @else
                                                        <a href="{{ route('subscription.checkout', $plan->id) }}"
                                                            class="btn">{{ auth()->user()->hasActiveSubscription()
                                                                ? 'Upgrade Now'
                                                                : "Get
                                                                                                                Started Now" }}
                                                            <i class="lni lni-arrow-right"></i></a>
                                                    @endif
                                                @else
                                                    <a href="{{ route('subscription.checkout', $plan->id) }}"
                                                        class="btn">Get
                                                        Started Now <i class="lni lni-arrow-right"></i></a>
                                                @endauth
                                            @else
                                                <a href="{{ route('subscription.checkout', $plan->id) }}"
                                                    class="btn">Get
                                                    Credits Now <i class="lni lni-arrow-right"></i></a>
                                            @endif


                                        </div>
                                        <p class="no-card">* Terms & Conditions Apply</p>
                                    </div>
                                    <!-- End Single Table-->
                                </div>
                            @endforeach

                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </section>
    <!--/ End Pricing Table Area -->

    <!-- Start Testimonials Area -->
    <section class="testimonials style2 section bg-white">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">{{ get_settings('testimonials_section_title') }}
                        </h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">{{ get_settings('testimonials_section_subtitle') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row testimonial-slider">
                @foreach ($testimonials as $testimonial)
                    <div class="col-lg-6 col-12 ">
                        <!-- Start Single Testimonial -->
                        <div class="single-testimonial">
                            <div class="inner-content">
                                <div class="quote-icon">
                                    <i class="lni lni-quotation"></i>
                                </div>
                                <div class="text">
                                    <p>“{{ $testimonial->text }}”</p>
                                </div>
                                <div class="author">
                                    <img src="{{ asset('assets/front/images/home/' . $testimonial->icon) }}"
                                        alt="#">
                                    <h4 class="name">{{ $testimonial->title }}
                                        <span class="deg">{{ $testimonial->image }}</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Testimonial -->
                    </div>
                @endforeach


            </div>
        </div>
    </section>
    <!-- End Testimonial Area -->

    <!-- Start Faq Area -->
    <section class="faq section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">{{ get_settings('faq_section_title') }}</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">{{ get_settings('faq_section_subtitle') }}</p>
                    </div>
                </div>
            </div>
            <div class="row">



                <div class="col-lg-6 col-md-12 col-12">
                    <div class="accordion" id="accordionExample">

                        @foreach ($faqdats[0] as $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $faq->id }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $faq->id }}" aria-expanded="false"
                                        aria-controls="collapse{{ $faq->id }}">
                                        <span class="title">{{ $faq->question }}</span><i class="lni lni-plus"></i>
                                    </button>
                                </h2>
                                <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse"
                                    aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>{{ $faq->answer }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>





                <div class="col-lg-6 col-md-12 col-12 xs-margin">
                    <div class="accordion" id="accordionExample2">

                        @foreach ($faqdats[1] as $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $faq->id }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $faq->id }}" aria-expanded="false"
                                        aria-controls="collapse{{ $faq->id }}">
                                        <span class="title">{{ $faq->question }}</span><i class="lni lni-plus"></i>
                                    </button>
                                </h2>
                                <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse"
                                    aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>{{ $faq->answer }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Faq Area -->

    <!-- Start Call Action Area -->
    {{-- <section class="call-action">
        <div class="container">
            <div class="inner-content">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-7 col-12">
                        <div class="text">
                            <h2>Download Our App &
                                <br> Start your free trial today.
                            </h2>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5 col-12">
                        <div class="button">
                            <a href="pricing.html" class="btn"><i class="lni lni-apple"></i> App Store
                            </a>
                            <a href="about-us.html" class="btn btn-alt"><i class="lni lni-play-store"></i> Google
                                Play</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- End Call Action Area -->

@endsection
