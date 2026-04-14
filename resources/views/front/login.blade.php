@extends('layouts/blankLayout')

@section('title', 'Login')

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
                    <img src="{{ asset('assets/front/images/home/' . get_settings('login_page_image')) }}" class="img-fluid" alt="Login image"
                        width="100%">
                </div>
            </div>
            <!-- /Left Text -->

            <!-- Login -->
            <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
                <div class="w-px-400 mx-auto">
                    <!-- Logo -->
                    <div class="app-brand mb-5 justify-content-center">
                        <a href="{{route('front.index')}}" class="app-brand-link gap-2">
                            <span class="app-brand-logo">

                                <img src="{{ asset('assets/front/images/home/' . get_settings('system_logo')) }}"
                                    width="200px" alt="Logo">
                            </span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-2">{!! get_settings('login_page_title') !!}</h4>
                    <p class="mb-4">{!! get_settings('login_page_subtitle') !!}</p>

        @include('content.alerts')

                        <form class="mb-3" action="{{ route('user.login.submit') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="mb-3">
                                <label for="email" class="form-label">Email or Username</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter your email or username" autofocus>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    <a href="{{ route('forgot') }}">
                                        <small>Forgot Password?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me">
                                    <label class="form-check-label" for="remember-me">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>


                    <p class="text-center">
                        <span>New on our platform?</span>
                        <a href="{{route('register')}}">
                            <span>Create an account</span>
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
@section('page-script')

@endsection
