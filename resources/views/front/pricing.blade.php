@extends('layouts/front/master')

@section('title', $page->title)

@section('content')

    <!-- Start Services Area -->
    <div id="pricing" class="pricing-table pages section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2 class="wow fadeInUp" data-wow-delay=".6s">{{$page->name}}</h2>
                        <span class="devide"></span>
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
    </div>
    <!-- End Services Area -->

@endsection
