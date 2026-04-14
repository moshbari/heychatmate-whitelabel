@extends('layouts/contentNavbarLayout')

@section('title', 'Manage Users')

@section('content')

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Dashboard /</span> Manage Users / Billing & Plans

        <a href="{{ route('manage.user') }}" class="btn btn-primary">
            <i class='bx bx-arrow-back bx-sm'></i>
        </a>

    </h4>
    <!-- Button trigger modal -->


    <!-- Content -->

    <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">

            @include('admin.includes.profile-side')
        </div>
        <!--/ User Sidebar -->


        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">

            @include('admin.includes.profile-nav')

            <!-- Project table -->
            <div class="card mb-4">
                <h5 class="card-header">User Subscription Details</h5>
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
                                    <h6 class="mb-1"><span class="me-2">{{get_settings('currency_sign')}}{{ $user->subscription->plan->price }} /
                                            {{ ucfirst($user->subscription->plan->type) }}</span>
                                        {{-- <span class="badge bg-label-primary">Popular</span> --}}</h6>
                                    <p>Plan Activated on {{ $user->subscription->created_at->format('F dS Y') }}</p>
                                </div>
                            </div>

                            <div class="col-12 order-2 order-xl-0">
                                <button class="btn btn-primary me-2 my-2" data-bs-toggle="modal"
                                    data-bs-target="#upgradePlanModal">Change Plan</button>
                                <button class="btn btn-label-danger cancel-subscription cancelSub" data-url="<a href='{{ route('user.subscription.cancel', $user->id) }}' style='color:white;'>Yes, Cancel Subscription!</a>">Cancel Subscription</button>
                            </div>
                        @else
                            <div class="col-xl-6 order-1 order-xl-0">
                                <div class="mb-4">
                                    <h6 class="mb-1">This User dont have any subscription.</h6>
                                </div>
                            </div>

                            <div class="col-12 order-2 order-xl-0">
                                <button class="btn btn-primary me-2 my-2" data-bs-toggle="modal"
                                    data-bs-target="#upgradePlanModal">Add Subscription</button>
                                {{-- <button class="btn btn-label-danger cancel-subscription">Cancel Subscription</button> --}}
                            </div>
                        @endif
                    </div>

                </div>
                <!-- /Project table -->

            </div>
            <!--/ User Content -->
        </div>

        <!-- Modal -->

        <!-- Add New Credit Card Modal -->
        <div class="modal fade" id="upgradePlanModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-simple modal-upgrade-plan">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-4">
                            <h3>Change User Plan</h3>
                            <p>Choose the best plan for user.</p>
                        </div>
                        <form class="row g-3" action="{{route('user.billing.update',$user->id)}}" method="post">
                          @csrf
                            <div class="col-sm-9">
                                <label class="form-label" for="choosePlan">Choose Plan</label>
                                <select id="choosePlan" name="choosePlan" class="form-select" aria-label="Choose Plan">
                                    <option selected>Choose Plan</option>

                                    @foreach ($plans as $plan)
                                        <option value="{{ $plan->id }}">{{ $plan->name }} -
                                            ${{ $plan->price }}/{{ $plan->type }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-sm-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Change</button>
                            </div>
                        </form>
                    </div>
                    <hr class="mx-md-n5 mx-n3">
                    <div class="modal-body">
                        @if ($user->hasActiveSubscription())
                        <h6 class="mb-0">User current plan is {{ $user->subscription->plan->name }}</h6>
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="d-flex justify-content-center me-2 mt-3">
                                <sup class="h5 pricing-currency pt-1 mt-3 mb-0 me-1 text-primary">{{get_settings('currency_sign')}}</sup>
                                <h1 class="display-3 mb-0 text-primary">{{ $user->subscription->plan->price }}</h1>
                                <sub class="h5 pricing-duration mt-auto mb-2">/{{ $user->subscription->plan->type }}</sub>
                            </div>
                        </div>
                        @else
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="d-flex justify-content-center me-2 mt-3">
                                    <h6 class="mb-1">This User dont have any subscription.</h6>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!--/ Add New Credit Card Modal -->

        <!-- /Modal -->




        <!-- Content wrapper -->
    @endsection
    @section('page-script')
        <!--Embed Code starts-->
        <script type="text/javascript">

            $('.cancelSub').on('click', function() {

                var link = $(this).data('url');

                Swal.fire({
                    title: "Are you sure?",
                    text: "This Action will remove this users Subscription!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: link
                })
            });
        </script>

    @endsection
