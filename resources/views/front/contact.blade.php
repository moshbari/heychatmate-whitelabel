@extends('layouts/front/master')

@section('title', $page->title)

@section('content')

    <!-- Start Contact Area -->
    <div class="contact-us section pages">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">{{ $page->name }}</h2>
                        <span class="devide"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="contact-widget-wrapper">
                        <div class="main-title">
                            <h2>Contact Us</h2>
                            <p>{!! get_settings('contact_us_text') !!}</p>
                        </div>
                        <div class="contact-widget-block">
                            <h3 class="title">Call us</h3>
                            <p>{!! get_settings('contact_phone') !!}</p>
                        </div>
                        <div class="contact-widget-block">
                            <h3 class="title">Email us</h3>
                            <p>{!! get_settings('contact_email') !!}</p>
                        </div>
                        <div class="contact-widget-block">
                            <h3 class="title">Our Address</h3>
                            <p>{!! get_settings('contact_address') !!}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="contact-form">
                        <h3 class="form-title">Leave a message here</h3>
                        <form class="form" method="post" id="contactForm" action="{{ route('contact.submit') }}">
                          @csrf
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <input name="name" type="text" placeholder="Name*" required="required">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <input name="email" type="email" placeholder="Email*" required="required">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <input name="subject" type="text" placeholder="Subject*" required="required">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <input name="phone" type="text" placeholder="Phone*" required="required">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea placeholder="Message*" name="message" id="message-area" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="button">
                                        <button type="submit" class="btn ">Send Message</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Contact Area -->

@endsection
@section('page-script')

    <!--Embed Code starts-->
    <script type="text/javascript">
        $(document).ready(function() {
            var options = {
                //beforeSubmit:  showRequest,  // pre-submit callback
                success: showResponse // post-submit callback
            };

            // bind form using 'ajaxForm'
            $('#contactForm').ajaxForm(options);
        });

        // post-submit callback
function showResponse(responseText, statusText, xhr, $form)  {

                Swal.fire({
                html: responseText.message,
                icon: responseText.status,
                showCancelButton: false,
                confirmButtonColor: "#3085d6"
            })
}
    </script>
    <!--Embed Code ends-->

@endsection
