@extends('layouts/contentNavbarLayout')

@section('title', 'Manage Account')

@section('content')

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Account /</span> Billing & Plans
    </h4>
    <!-- Button trigger modal -->

    <!-- Content -->

    <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">

            @include('user.includes.profile-side')
        </div>
        <!--/ User Sidebar -->

        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">

            @include('user.includes.profile-nav')

            <!-- Project table -->
            <div class="card mb-4">
                <h5 class="card-header">My Subscription Details</h5>
                <div class="card-body">

                    @include('content.alerts')
                    <div class="row">
                        @if ($user->hasActiveSubscription())
                            <div class="col-xl-6 order-1 order-xl-0">
                                <div class="mb-4">
                                    <h6 class="mb-1">Your Current Plan is {{ $user->subscription->plan->name }}</h6>
                                    <p>{{ $user->subscription->plan->subtitle }}</p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="mb-1">Active until {{ $user->subscription->due_date->format('F dS Y') }}
                                    </h6>
                                    <p>We will send you an email upon Subscription expiration</p>
                                </div>
                                <div class="mb-4">
                                    <h6 class="mb-1"><span class="me-2">${{ $user->subscription->plan->price }} /
                                            {{ ucfirst($user->subscription->plan->type) }}</span>
                                        {{-- <span class="badge bg-label-primary">Popular</span> --}}</h6>
                                    <p>Plan Activated on {{ $user->subscription->created_at->format('F dS Y') }}</p>
                                </div>
                            </div>

                            <div class="col-12 order-2 order-xl-0">
                                <a href="{{ route('subscription.index') }}" class="btn btn-primary me-2 my-2">Change
                                    Plan</a>
                                {{-- <button class="btn btn-label-danger cancel-subscription">Cancel Subscription</button> --}}
                            </div>
                        @else
                            <div class="col-xl-6 order-1 order-xl-0">
                                <div class="mb-4">
                                    <h6 class="mb-1">You dont have any subscription.</h6>
                                </div>
                            </div>

                            <div class="col-12 order-2 order-xl-0">
                                <a href="{{ route('subscription.index') }}" class="btn btn-primary me-2 my-2">Add
                                    Subscription</a>
                                {{-- <button class="btn btn-label-danger cancel-subscription">Cancel Subscription</button> --}}
                            </div>
                        @endif


                    </div>

                </div>
                <!-- /Project table -->

            </div>
            <!--/ User Content -->
        </div>




        <!-- Content wrapper -->
    @endsection
    @section('page-script')
        <!--Embed Code starts-->
        <script type="text/javascript"></script>

    @endsection
