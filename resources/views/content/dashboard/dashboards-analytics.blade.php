@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12 mb-4 order-0">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-primary">Weclome Back {{auth()->user()->name}}! 🎉</h5>
            <p class="mb-4">System has completed total <span class="fw-bold"> {{$todays}} </span> chats today. Check them now.</p>

            <a href="{{route('chat-support')}}" class="btn btn-sm btn-outline-primary">View Chats</a>


          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-4">
            <img src="{{asset('assets/img/illustrations/3d-artificial-intelligence.png')}}" height="180" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-12 col-md-12 order-1">

    <div class="row">
      <div class="col-lg-4 col-md-12 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="{{asset('assets/img/icons/brands/credits.png')}}" alt="C">
              </div>

            </div>
            <span class="fw-semibold d-block mb-1">Credits Balance</span>
            <h1 class="card-title mb-2">{{auth()->user()->credit_balance}}</h1>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-12 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <i class="dash-icons tf-icons bx bxs-badge-dollar bx-lg"></i>
              </div>

            </div>
            <span class="fw-semibold d-block mb-1">Your Plan</span>
            <h1 class="card-title text-nowrap mb-1">{{$alls}}</h1>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-12 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <i class="dash-icons tf-icons bx bx-conversation bx-lg"></i>
              </div>

            </div>
            <span class="fw-semibold d-block mb-1">Credit Used(30 days)</span>
            <h1 class="card-title text-nowrap mb-1">{{$alls}}</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6 col-md-12 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <i class="dash-icons tf-icons bx bx-conversation bx-lg"></i>
              </div>

            </div>
            <span class="fw-semibold d-block mb-1">Today's Conversation</span>
            <h1 class="card-title mb-2">{{$todays}}</h1>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-12 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <i class="dash-icons tf-icons bx bx-conversation bx-lg"></i>
              </div>

            </div>
            <span class="fw-semibold d-block mb-1">All Conversation</span>
            <h1 class="card-title text-nowrap mb-1">{{$alls}}</h1>
          </div>
        </div>
      </div>
    </div>
  </div>


</div>
@endsection
