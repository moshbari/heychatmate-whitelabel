@extends('layouts/front/master')

@section('title', 'Home')

@section('content')
    <!-- Start Hero Area -->
    <section class="hero-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-12 col-12">
                    <div class="hero-content">
                        <h4>{{get_settings('welcome_small_title')}}</h4>
                        <h1>{{get_settings('welcome_title')}}</h1>
                        <p>{{get_settings('welcome_subtitle')}}</p>
                        <div class="button">
                            <a href="{{route('login')}}" class="btn ">Get Started Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-12">
                    <div class="hero-image wow fadeInRight" data-wow-delay=".4s">
                        <video width="100%" autoplay="" muted="" loop="" playsinline="">
                            <source src="{{ asset('assets/front/images/home/'.get_settings('welcome_video')) }}" type="video/mp4">
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
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">{{get_settings('why_section_title')}}</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">{{get_settings('why_section_subtitle')}}</p>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-lg-4 col-md-6 col-12 wow fadeInUp" data-wow-delay=".2s">
                    <div class="single-service">
                        <div class="main-icon">
                                <img src="{{ asset('assets/front/images/home/icons8-grid-48.png')}}" alt="icon">
                        </div>
                        <h4 class="text-title">Brand Identity Design</h4>
                        <p>Invest in Bitcoin on the regular or save with one of the highest interest rates on the
                            market.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 col-12 wow fadeInUp" data-wow-delay=".4s">
                    <div class="single-service">
                        <div class="main-icon">
                            <i class="lni lni-keyword-research"></i>
                        </div>
                        <h4 class="text-title">Digital Marketing</h4>
                        <p>Invest in Bitcoin on the regular or save with one of the highest interest rates on the
                            market.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 wow fadeInUp" data-wow-delay=".6s">
                    <div class="single-service">
                        <div class="main-icon">
                            <i class="lni lni-vector"></i>
                        </div>
                        <h4 class="text-title">Design and Development</h4>
                        <p>Invest in Bitcoin on the regular or save with one of the highest interest rates on the
                            market.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 wow fadeInUp" data-wow-delay=".2s">
                    <div class="single-service">
                        <div class="main-icon">
                            <i class="lni lni-book"></i>
                        </div>
                        <h4 class="text-title">IT Consulting Service</h4>
                        <p>Invest in Bitcoin on the regular or save with one of the highest interest rates on the
                            market.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 wow fadeInUp" data-wow-delay=".4s">
                    <div class="single-service">
                        <div class="main-icon">
                            <i class="lni lni-cloud-network"></i>
                        </div>
                        <h4 class="text-title">Cloud Computing</h4>
                        <p>Invest in Bitcoin on the regular or save with one of the highest interest rates on the
                            market.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 wow fadeInUp" data-wow-delay=".6s">
                    <div class="single-service">
                        <div class="main-icon">
                            <i class="lni lni-display-alt"></i>
                        </div>
                        <h4 class="text-title">Graphics Design</h4>
                        <p>Invest in Bitcoin on the regular or save with one of the highest interest rates on the
                            market.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Services Area -->

    <style>

    </style>


    <section id="details" class="howitworks section details">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">{{get_settings('how_section_title')}}</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">{{get_settings('how_section_subtitle')}}
                        </p>
                    </div>
                </div>
            </div>

            <div class="row content wow fadeInUp" data-wow-delay=".4s">
                <div class="col-md-5">
                    <img src="{{ asset('assets/front/images/home/details-1.png') }}" class="img-fluid" alt="">
                </div>
                <div class="col-md-7 pt-4 aos-init aos-animate" data-aos="fade-up">
                    <h3>Voluptatem dignissimos provident quasi corporis voluptates sit assumenda.</h3>
                    <p class="fst-italic">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore
                        magna aliqua.

                        Voluptas nisi in quia excepturi nihil voluptas nam et ut. Expedita omnis eum consequatur non. Sed in
                        asperiores aut repellendus. Error quisquam ab maiores. Quibusdam sit in officia
                    </p>
                </div>
            </div>
            <div class="narrow">

                <div class="chevron"></div>
                <div class="chevron"></div>
                <div class="chevron"></div>
            </div>

            <div class="row content">
                <div class="col-md-5 order-1 order-md-2 aos-init aos-animate" data-aos="fade-left">
                    <img src="{{ asset('assets/front/images/home/details-2.png') }}" class="img-fluid" alt="">
                </div>
                <div class="col-md-7 pt-5 order-2 order-md-1 aos-init aos-animate" data-aos="fade-up">
                    <h3>Corporis temporibus maiores provident</h3>
                    <p class="fst-italic">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore
                        magna aliqua.
                    </p>
                    <p>
                        Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                        voluptate
                        velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                        sunt in
                        culpa qui officia deserunt mollit anim id est laborum
                    </p>
                    <p>
                        Inventore id enim dolor dicta qui et magni molestiae. Mollitia optio officia illum ut cupiditate eos
                        autem. Soluta dolorum repellendus repellat amet autem rerum illum in. Quibusdam occaecati est nisi
                        esse. Saepe aut dignissimos distinctio id enim.
                    </p>
                </div>
            </div>
            <div class="narrow">

                <div class="chevron"></div>
                <div class="chevron"></div>
                <div class="chevron"></div>
            </div>
            <div class="row content">
                <div class="col-md-4 aos-init aos-animate" data-aos="fade-right">
                    <img src="{{ asset('assets/front/images/home/details-3.png') }}" class="img-fluid" alt="">
                </div>
                <div class="col-md-8 pt-5 aos-init aos-animate" data-aos="fade-up">
                    <h3>Sunt consequatur ad ut est nulla consectetur reiciendis animi voluptas</h3>
                    <p>Cupiditate placeat cupiditate placeat est ipsam culpa. Delectus quia minima quod. Sunt saepe odit aut
                        quia voluptatem hic voluptas dolor doloremque.</p>
                    <ul>
                        <li><i class="bi bi-check"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
                        <li><i class="bi bi-check"></i> Duis aute irure dolor in reprehenderit in voluptate velit.</li>
                        <li><i class="bi bi-check"></i> Facilis ut et voluptatem aperiam. Autem soluta ad fugiat.</li>
                    </ul>
                    <p>
                        Qui consequatur temporibus. Enim et corporis sit sunt harum praesentium suscipit ut voluptatem. Et
                        nihil magni debitis consequatur est.
                    </p>
                    <p>
                        Suscipit enim et. Ut optio esse quidem quam reiciendis esse odit excepturi. Vel dolores rerum soluta
                        explicabo vel fugiat eum non.
                    </p>
                </div>
            </div>
            <div class="narrow">

                <div class="chevron"></div>
                <div class="chevron"></div>
                <div class="chevron"></div>
            </div>
            <div class="row content">
                <div class="col-md-4 order-1 order-md-2 aos-init aos-animate" data-aos="fade-left">
                    <img src="{{ asset('assets/front/images/home/details-4.png') }}" class="img-fluid" alt="">
                </div>
                <div class="col-md-8 pt-5 order-2 order-md-1 aos-init aos-animate" data-aos="fade-up">
                    <h3>Quas et necessitatibus eaque impedit ipsum animi consequatur incidunt in</h3>
                    <p class="fst-italic">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore
                        magna aliqua.
                    </p>
                    <p>
                        Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                        voluptate
                        velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                        sunt in
                        culpa qui officia deserunt mollit anim id est laborum
                    </p>
                    <ul>
                        <li><i class="bi bi-check"></i> Et praesentium laboriosam architecto nam .</li>
                        <li><i class="bi bi-check"></i> Eius et voluptate. Enim earum tempore aliquid. Nobis et sunt
                            consequatur. Aut repellat in numquam velit quo dignissimos et.</li>
                        <li><i class="bi bi-check"></i> Facilis ut et voluptatem aperiam. Autem soluta ad fugiat.</li>
                    </ul>
                </div>
            </div>

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
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12 wow fadeInUp" data-wow-delay=".4s">
                    <!-- Single Table -->
                    <div class="single-table">
                        <!-- Table Head -->
                        <div class="table-head">
                            <h4 class="title">Individual</h4>
                            <p class="sub-title">Powerful & Awesome Elements</p>
                            <div class="price">
                                <h2 class="amount"><span class="currency">$</span>19<span class="duration">/month</span>
                                </h2>
                            </div>
                        </div>
                        <!-- End Table Head -->
                        <!-- Start Table Content -->
                        <div class="table-content">
                            <!-- Table List -->
                            <ul class="table-list">
                                <li>Commercial License</li>
                                <li>100+ HTML UI Elements</li>
                                <li>01 Domain Support</li>
                                <li class="disable">6 Month Premium Support</li>
                                <li class="disable">Lifetime Updates</li>
                            </ul>
                            <!-- End Table List -->
                        </div>
                        <!-- End Table Content -->
                        <div class="button">
                            <a href="javascript:void(0)" class="btn">Start free trial <i
                                    class="lni lni-arrow-right"></i></a>
                        </div>
                        <p class="no-card">No credit card required</p>
                    </div>
                    <!-- End Single Table-->
                </div>
                <div class="col-lg-4 col-md-6 col-12 wow fadeInUp" data-wow-delay=".6s">
                    <!-- Single Table -->
                    <div class="single-table middle">
                        <span class="popular">Most Popular</span>
                        <!-- Table Head -->
                        <div class="table-head">
                            <h4 class="title">Exclusive</h4>
                            <p class="sub-title">Powerful & Awesome Elements</p>
                            <div class="price">
                                <h2 class="amount"><span class="currency">$</span>49<span class="duration">/month</span>
                                </h2>
                            </div>
                        </div>
                        <!-- End Table Head -->
                        <!-- Start Table Content -->
                        <div class="table-content">
                            <!-- Table List -->
                            <ul class="table-list">
                                <li>Commercial License</li>
                                <li>100+ HTML UI Elements</li>
                                <li>01 Domain Support</li>
                                <li>6 Month Premium Support</li>
                                <li class="disable">Lifetime Updates</li>
                            </ul>
                            <!-- End Table List -->
                        </div>
                        <!-- End Table Content -->
                        <div class="button">
                            <a href="javascript:void(0)" class="btn btn-alt">Start free trial <i
                                    class="lni lni-arrow-right"></i></a>
                        </div>
                        <p class="no-card">No credit card required</p>
                    </div>
                    <!-- End Single Table-->
                </div>
                <div class="col-lg-4 col-md-6 col-12 wow fadeInUp" data-wow-delay=".8s">
                    <!-- Single Table -->
                    <div class="single-table">
                        <!-- Table Head -->
                        <div class="table-head">
                            <h4 class="title">Premium</h4>
                            <p class="sub-title">Powerful & Awesome Elements</p>
                            <div class="price">
                                <h2 class="amount"><span class="currency">$</span>99<span class="duration">/month</span>
                                </h2>
                            </div>
                        </div>
                        <!-- End Table Head -->
                        <!-- Start Table Content -->
                        <div class="table-content">
                            <!-- Table List -->
                            <ul class="table-list">
                                <li>Commercial License</li>
                                <li>100+ HTML UI Elements</li>
                                <li>01 Domain Support</li>
                                <li>6 Month Premium Support</li>
                                <li>Lifetime Updates</li>
                            </ul>
                            <!-- End Table List -->
                        </div>
                        <!-- End Table Content -->
                        <div class="button">
                            <a href="javascript:void(0)" class="btn">Start free trial <i
                                    class="lni lni-arrow-right"></i></a>
                        </div>
                        <p class="no-card">No credit card required</p>
                    </div>
                    <!-- End Single Table-->
                </div>
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
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">{{get_settings('testimonials_section_title')}}</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">{{get_settings('testimonials_section_subtitle')}}</p>
                    </div>
                </div>
            </div>
            <div class="row testimonial-slider">
                <div class="col-lg-6 col-12 ">
                    <!-- Start Single Testimonial -->
                    <div class="single-testimonial">
                        <div class="inner-content">
                            <div class="quote-icon">
                                <i class="lni lni-quotation"></i>
                            </div>
                            <div class="text">
                                <p>“A vast number of clients decide to create dedicated software is the
                                    online store. It is nothing but a website with a catalog of products and the
                                    possibility.”</p>
                            </div>
                            <div class="author">
                                <img src="https://via.placeholder.com/100x100" alt="#">
                                <h4 class="name">Somalia D Silva
                                    <span class="deg">Business Manager</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Testimonial -->
                </div>
                <div class="col-lg-6 col-12 ">
                    <!-- Start Single Testimonial -->
                    <div class="single-testimonial">
                        <div class="inner-content">
                            <div class="quote-icon">
                                <i class="lni lni-quotation"></i>
                            </div>
                            <div class="text">
                                <p>“A vast number of clients decide to create dedicated software is the
                                    online store. It is nothing but a website with a catalog of products and the
                                    possibility.”</p>
                            </div>
                            <div class="author">
                                <img src="https://via.placeholder.com/100x100" alt="#">
                                <h4 class="name">David Warner
                                    <span class="deg">Web Developer</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Testimonial -->
                </div>
                <div class="col-lg-6 col-12 ">
                    <!-- Start Single Testimonial -->
                    <div class="single-testimonial">
                        <div class="inner-content">
                            <div class="quote-icon">
                                <i class="lni lni-quotation"></i>
                            </div>
                            <div class="text">
                                <p>“A vast number of clients decide to create dedicated software is the
                                    online store. It is nothing but a website with a catalog of products and the
                                    possibility.”</p>
                            </div>
                            <div class="author">
                                <img src="https://via.placeholder.com/100x100" alt="#">
                                <h4 class="name">Jems Gilario
                                    <span class="deg">Graphics Designer</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Testimonial -->
                </div>
                <div class="col-lg-6 col-12 ">
                    <!-- Start Single Testimonial -->
                    <div class="single-testimonial">
                        <div class="inner-content">
                            <div class="quote-icon">
                                <i class="lni lni-quotation"></i>
                            </div>
                            <div class="text">
                                <p>“A vast number of clients decide to create dedicated software is the
                                    online store. It is nothing but a website with a catalog of products and the
                                    possibility.”</p>
                            </div>
                            <div class="author">
                                <img src="https://via.placeholder.com/100x100" alt="#">
                                <h4 class="name">David Warner
                                    <span class="deg">Web Developer</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Testimonial -->
                </div>
                <div class="col-lg-6 col-12 ">
                    <!-- Start Single Testimonial -->
                    <div class="single-testimonial">
                        <div class="inner-content">
                            <div class="quote-icon">
                                <i class="lni lni-quotation"></i>
                            </div>
                            <div class="text">
                                <p>“A vast number of clients decide to create dedicated software is the
                                    online store. It is nothing but a website with a catalog of products and the
                                    possibility.”</p>
                            </div>
                            <div class="author">
                                <img src="https://via.placeholder.com/100x100" alt="#">
                                <h4 class="name">Jems Gilario
                                    <span class="deg">Graphics Designer</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Testimonial -->
                </div>
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
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">{{get_settings('faq_section_title')}}</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">{{get_settings('faq_section_subtitle')}}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                    <span class="title">Can I cancel my subscription at anytime?</span><i
                                        class="lni lni-plus"></i>
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam consectetur sit
                                        amet ante nec vulputate. Nulla aliquam, justo auctor consequat tincidunt, arcu
                                        erat mattis lorem.</p>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam consectetur sit
                                        amet ante nec vulputate.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                    <span class="title">Can I change my plan later on?</span><i class="lni lni-plus"></i>
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                        richardson ad squid. 3 wolf moon officia aute. non cupidatat skateboard dolor
                                        brunch. Foosd truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
                                    </p>
                                    <p>
                                        sunt alqua put a bird on it squid single-origin coffee nulla assumenda
                                        shoreditch et. Nihil anim ke ffiyeh helvetica, Spark beer labore wes anderson
                                        cred nesciunt sapiente ea proident.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                    <span class="title">Will you renew my subscription automatically?</span><i
                                        class="lni lni-plus"></i>
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptas expedita,
                                        repellendus est nemo cum quibusdam optio, voluptate hic a tempora facere, nihil
                                        non itaque alias similique quas quam odit consequatur.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12 xs-margin">
                    <div class="accordion" id="accordionExample2">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading11">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                                    <span class="title">How many sites can I install the widgets of this app
                                        to?</span><i class="lni lni-plus"></i>
                                </button>
                            </h2>
                            <div id="collapse11" class="accordion-collapse collapse" aria-labelledby="heading11"
                                data-bs-parent="#accordionExample2">
                                <div class="accordion-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam consectetur sit
                                        amet ante nec vulputate. Nulla aliquam, justo auctor consequat tincidunt, arcu
                                        erat mattis lorem.</p>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam consectetur sit
                                        amet ante nec vulputate.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading22">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse22" aria-expanded="false" aria-controls="collapse22">
                                    <span class="title">Do you offer any discounts?</span><i class="lni lni-plus"></i>
                                </button>
                            </h2>
                            <div id="collapse22" class="accordion-collapse collapse" aria-labelledby="heading22"
                                data-bs-parent="#accordionExample2">
                                <div class="accordion-body">
                                    <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                        richardson ad squid. 3 wolf moon officia aute. non cupidatat skateboard dolor
                                        brunch. Foosd truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor.
                                    </p>
                                    <p>
                                        sunt alqua put a bird on it squid single-origin coffee nulla assumenda
                                        shoreditch et. Nihil anim ke ffiyeh helvetica, Spark beer labore wes anderson
                                        cred nesciunt sapiente ea proident.</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading33">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse33" aria-expanded="false" aria-controls="collapse33">
                                    <span class="title">Do I get updates for the app?</span><i class="lni lni-plus"></i>
                                </button>
                            </h2>
                            <div id="collapse33" class="accordion-collapse collapse" aria-labelledby="heading33"
                                data-bs-parent="#accordionExample2">
                                <div class="accordion-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptas expedita,
                                        repellendus est nemo cum quibusdam optio, voluptate hic a tempora facere, nihil
                                        non itaque alias similique quas quam odit consequatur.</p>
                                </div>
                            </div>
                        </div>
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
