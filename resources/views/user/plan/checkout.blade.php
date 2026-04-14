@extends('layouts/contentNavbarLayout')

@section('title', 'Plan Checkout')

@section('vendor-script')
<script src="{{ asset('assets/vendor/libs/masonry/masonry.js') }}"></script>
@endsection

@section('content')
<style>
    .card .selected {
        background-color: rgba(105, 108, 255, 0.16) !important;
    }
</style>
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Subscription /</span> Plan Checkout</h4>

<!-- Text alignment -->
<div class="row mb-5">
    <div class="col-md-6 col-lg-8">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Select Payment Method</h5>

                <div class="row">
                    <div class="col-md-6 col-xl-4">
                        <div class="card shadow-none bg-transparent border border-primary mb-3 cursor-pointer" id="paypal">
                            <div class="card-body">
                                <h5 class="card-title">Paypal</h5>
                                <p class="card-text">
                                    Pay With Paypal
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="card shadow-none bg-transparent border border-primary mb-3 cursor-pointer" id="stripe">
                            <div class="card-body">
                                <h5 class="card-title">Stripe</h5>
                                <p class="card-text">
                                    Pay with Stripe
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-12 text-center d-none" id="checkots">

                        <p class="m-5">

                        <h5>Total Amount To Pay</h5>
                        <h1>${{ $plan->price }}</h1>
                        </p>
                        <form action="{{ route('subscription.checkout.submit') }}" method="post">
                            @csrf
                            <input type="hidden" name="keyword">
                            <input type="hidden" name="planid" value="{{$plan->id}}">
                            <button type="submit" class="btn btn-primary d-grid w-100">Pay Now</button>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="card mb-3">
            <div class="card-body">
                <div class="col-lg mb-md-0 mb-4">
                    <div class="card shadow-none">
                        <div class="card-body position-relative">
                            {{-- <div class="position-absolute end-0 me-4 top-0 mt-4">
                <span class="badge bg-label-primary">Popular</span>
              </div> --}}
                            <h3 class="card-title text-center text-capitalize mb-1">{{ $plan->name }}</h3>
                            <p class="text-center">{{ $plan->subtitle }}</p>
                            <div class="text-center">
                                <div class="d-flex justify-content-center">
                                    <sup class="h6 pricing-currency mt-3 mb-0 me-1 text-primary">$</sup>
                                    <h1 class="price-toggle price-yearly display-4 text-primary mb-0">
                                        {{ $plan->price }}
                                    </h1>
                                    <h1 class="price-toggle price-monthly display-4 text-primary mb-0 d-none">9</h1>
                                    <sub class="h6 text-muted pricing-duration mt-auto mb-2 fw-normal">/month</sub>
                                </div>
                            </div>

                            <ul class="ps-0 my-4 pt-2 list-unstyled float-left">
                                @if($plan->features)
                                @foreach (explode(',', $plan->features) as $item)
                                <li class="mb-2"><i class='bx bx-check-circle me-2'></i>{{ $item }}
                                </li>
                                @endforeach
                                @endif

                            </ul>

                            <a href="{{ route('subscription.index') }}" class="btn btn-primary d-grid w-100">Change
                                Plan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Text alignment -->


<!--/ Card layout -->
@endsection

@section('page-script')
<!--Embed Code starts-->
<script type="text/javascript">
    $(function() {
        $("#paypal").click(function() {
            $(this).addClass("selected");
            $("#stripe").removeClass("selected");
            $("#checkots").removeClass("d-none");
            $("input[name='keyword']").val("paypal");
        });

        $("#stripe").click(function() {
            $(this).addClass("selected");
            $("#paypal").removeClass("selected");
            $("#checkots").removeClass("d-none");
            $("input[name='keyword']").val("stripe");
        });
    });
</script>
<!--Embed Code ends-->
@endsection