@extends('layouts/blankLayout')

@section('title', 'Create New Account')

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection

@section('content')


    <!-- Content -->

    <div class="authentication-wrapper authentication-cover">
        <div class="authentication-inner row m-0">
            <!-- /Left Text -->
            <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center">
                <div class="w-100 d-flex justify-content-center">
                    <img src="{{ asset('assets/front/images/home/' . get_settings('login_page_image')) }}" class="img-fluid"
                        alt="Login image" width="100%">
                </div>
            </div>
            <!-- /Left Text -->

            <!-- Login -->
            <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
                <div class="w-px-400 mx-auto">
                    <!-- Logo -->
                    <div class="app-brand mb-5 justify-content-center">
                        <a href="{{ route('front.index') }}" class="app-brand-link gap-2">
                            <span class="app-brand-logo">

                                <img src="{{ asset('assets/front/images/home/' . get_settings('system_logo')) }}"
                                    width="200px" alt="Logo">
                            </span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-2">Sign Up</h4>


                    @include('content.alerts')
                    <form class="mb-3" action="{{ route('user.register.submit') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="" class="form-label">Your Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter your Name"
                                autofocus required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email"
                                placeholder="Enter your email" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter your Password"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Your Password</label>
                            <input type="password" class="form-control" name="confirm_password"
                                placeholder="Confirm your Password" required>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Sign Up</button>
                        </div>
                    </form>


                    <p class="text-center">
                        <span>Already have an account?</span>
                        <a href="{{ route('login') }}">
                            <span>Sign In</span>
                        </a>
                    </p>

                    <div class="divider my-4">
                        <div class="divider-text">or</div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <a href="javascript:;" class="btn me-3">
                             <img src="{{asset('assets/img/icons/brands/googlesign.png')}}" width="80%" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <!-- /Login -->
        </div>
    </div>

    <!-- / Content -->




@endsection
@push('js')
    <script></script>
@endpush
