@extends('layouts/contentNavbarLayout')

@section('title', 'Pricing and Subscription Plans')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Subscription Plans</h4>

<!-- Tabs -->
<section class="section-py first-section-pt">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <h2 class="text-center mb-2">Pricing Plans</h2>
                <p class="text-center mb-4 pb-2"> All plans include 40+ advanced tools and features to boost your
                    product.<br>
                    Choose the best plan to fit your needs.</p>

                @include('content.alerts')
                <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills mb-3 justify-content-center" role="tablist">
                        @if ($mplans->count())
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true">{{ __('Monthly') }}</button>
                        </li>
                        @endif
                        @if ($yplans->count())
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile" aria-selected="false">{{ __('Yearly') }}
                                {{-- <span class="badge bg-success">{{ __('10% Discount') }}</span> --}}
                            </button>
                        </li>
                        @endif
                        @if ($cplans->count())
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-messages" aria-controls="navs-pills-top-messages" aria-selected="false">{{ __('Credits') }}</button>
                        </li>
                        @endif
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
                            <p>
                            <div class="row mx-0 gy-3 px-lg-5 justify-content-center">

                                @foreach ($mplans as $plan)
                                <!-- Pro -->
                                <div class="col-lg mb-md-0 mb-4">
                                    <div class="card border-primary border shadow-none">
                                        <div class="card-body position-relative">
                                            {{-- <div class="position-absolute end-0 me-4 top-0 mt-4">
                                            <span class="badge bg-label-primary">Popular</span>
                                          </div> --}}
                                            <h3 class="card-title text-center text-capitalize mb-1">
                                                {{ $plan->name }}
                                            </h3>
                                            <p class="text-center">{{ $plan->subtitle }}</p>
                                            <div class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <sup class="h6 pricing-currency mt-3 mb-0 me-1 text-primary">$</sup>
                                                    <h1 class="price-toggle price-yearly display-4 text-primary mb-0">
                                                        {{ $plan->price }}
                                                    </h1>
                                                    <h1 class="price-toggle price-monthly display-4 text-primary mb-0 d-none">
                                                        9</h1>
                                                    <sub class="h6 text-muted pricing-duration mt-auto mb-2 fw-normal">/{{ $plan->type }}</sub>
                                                </div>
                                            </div>

                                            <ul class="ps-0 my-4 pt-2 circle-bullets list-unstyled">

                                                @foreach (explode(',', $plan->features) as $item)
                                                <li class="mb-2"><i class='bx bx-check-circle me-2'></i>{{ $item }}
                                                </li>
                                                @endforeach


                                            </ul>

                                            @if (auth()->user()->hasActiveSubscription() && auth()->user()->subscription->plan_id == $plan->id)
                                            <a href="javascript" class="btn btn-default d-grid w-100 disabled">Current Plan</a>
                                            @else
                                            <a href="{{ route('subscription.checkout', $plan->id) }}" class="btn btn-primary d-grid w-100">Select Plan</a>
                                            @endif


                                        </div>
                                    </div>
                                </div>
                                @endforeach




                            </div>
                            </p>

                        </div>
                        <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
                            <p>
                            <div class="row mx-0 gy-3 px-lg-5 justify-content-center">

                                @foreach ($yplans as $plan)
                                <!-- Pro -->
                                <div class="col-lg-4 mb-md-0 mb-4">
                                    <div class="card border-primary border shadow-none">
                                        <div class="card-body position-relative">
                                            {{-- <div class="position-absolute end-0 me-4 top-0 mt-4">
                                            <span class="badge bg-label-primary">Popular</span>
                                          </div> --}}
                                            <h3 class="card-title text-center text-capitalize mb-1">
                                                {{ $plan->name }}
                                            </h3>
                                            <p class="text-center">{{ $plan->subtitle }}</p>
                                            <div class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <sup class="h6 pricing-currency mt-3 mb-0 me-1 text-primary">$</sup>
                                                    <h1 class="price-toggle price-yearly display-4 text-primary mb-0">
                                                        {{ $plan->price }}
                                                    </h1>
                                                    <h1 class="price-toggle price-monthly display-4 text-primary mb-0 d-none">
                                                        9</h1>
                                                    <sub class="h6 text-muted pricing-duration mt-auto mb-2 fw-normal">/{{ $plan->type }}</sub>
                                                </div>
                                            </div>

                                            <ul class="ps-0 my-4 pt-2 circle-bullets list-unstyled">

                                                @foreach (explode(',', $plan->features) as $item)
                                                <li class="mb-2"><i class='bx bx-check-circle me-2'></i>{{ $item }}
                                                </li>
                                                @endforeach


                                            </ul>

                                            @if (auth()->user()->hasActiveSubscription() && auth()->user()->subscription->plan_id == $plan->id)
                                            <a href="javascript" class="btn btn-default d-grid w-100 disabled">Current Plan</a>
                                            @else
                                            <a href="{{ route('subscription.checkout', $plan->id) }}" class="btn btn-primary d-grid w-100">Select Plan</a>
                                            @endif


                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            </p>

                        </div>
                        <div class="tab-pane fade" id="navs-pills-top-messages" role="tabpanel">
                            <p>
                            <div class="row mx-0 gy-3 px-lg-5 justify-content-center">

                                @foreach ($cplans as $plan)
                                <!-- Pro -->
                                <div class="col-lg-4 mb-md-0 mb-4">
                                    <div class="card border-primary border shadow-none">
                                        <div class="card-body position-relative">
                                            {{-- <div class="position-absolute end-0 me-4 top-0 mt-4">
                                            <span class="badge bg-label-primary">Popular</span>
                                          </div> --}}
                                            <h3 class="card-title text-center text-capitalize mb-1">
                                                {{ $plan->name }}
                                            </h3>
                                            <p class="text-center">{{ $plan->subtitle }}</p>
                                            <div class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    <sup class="h6 pricing-currency mt-3 mb-0 me-1 text-primary">$</sup>
                                                    <h1 class="price-toggle price-yearly display-4 text-primary mb-0">
                                                        {{ $plan->price }}
                                                    </h1>
                                                    <h1 class="price-toggle price-monthly display-4 text-primary mb-0 d-none">
                                                        9</h1>

                                                </div>
                                            </div>

                                            <ul class="ps-0 my-4 pt-2 circle-bullets list-unstyled">
                                                @if($plan->features)
                                                @foreach (explode(',', $plan->features) as $item)
                                                <li class="mb-2"><i class='bx bx-check-circle me-2'></i>{{ $item }}
                                                </li>
                                                @endforeach
                                                @else
                                                <li class="mb-2"><i class='bx bx-check-circle me-2'></i>{{ $plan->credits }} Credits
                                                </li>
                                                @endif
                                            </ul>

                                            @if (auth()->user()->hasActiveSubscription() && auth()->user()->subscription->plan_id == $plan->id)
                                            <a href="javascript" class="btn btn-default d-grid w-100 disabled">Current Plan</a>
                                            @else
                                            <a href="{{ route('subscription.checkout', $plan->id) }}" class="btn btn-primary d-grid w-100">Select Plan</a>
                                            @endif


                                        </div>
                                    </div>
                                </div>
                                @endforeach




                            </div>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- Pills -->
@endsection
