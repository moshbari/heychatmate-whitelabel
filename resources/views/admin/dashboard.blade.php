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
            <h5 class="card-title text-primary">Weclome Back Admin! 🎉</h5>
            <p class="mb-4">The System has completed total <span class="fw-bold"> {{$todays}} </span> chats today.</p>

            <a href="{{route('chat.index')}}" class="btn btn-sm btn-outline-primary">View Chats</a>


          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left d-none d-sm-block">
          <div class="card-body pb-0 px-0 px-md-4">
            <img src="{{asset('assets/img/illustrations/3d-artificial-intelligence.png')}}" height="180" alt="View Badge User">
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
                <i class="dash-icons tf-icons bx bxs-conversation bx-lg"></i>
              </div>

            </div>
            <span class="fw-semibold d-block mb-1">Total Chat</span>
            <h1 class="card-title mb-2">{{$allchats}}</h1>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-12 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <i class="dash-icons tf-icons bx bxs-bot bx-lg"></i>
              </div>

            </div>
            <span class="fw-semibold d-block mb-1">Total Assistants</span>
            <h1 class="card-title text-nowrap mb-1">{{$allassistants}}</h1>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-12 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <i class="dash-icons tf-icons bx bx-group bx-lg"></i>
              </div>

            </div>
            <span class="fw-semibold d-block mb-1">Total Users</span>
            <h1 class="card-title text-nowrap mb-1">{{$allusers}}</h1>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-12 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                                    <img src="{{ asset('assets/img/icons/brands/credits.png') }}" alt="C">
              </div>

            </div>
            <span class="fw-semibold d-block mb-1">System User Credits</span>
            <h1 class="card-title mb-2">{{$allcredits}}</h1>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-12 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <i class="dash-icons tf-icons bx bx-dollar-circle bx-lg"></i>
              </div>

            </div>
            <span class="fw-semibold d-block mb-1">Subscribed Users</span>
            <h1 class="card-title mb-2">{{$allsubs}}</h1>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-12 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <i class="dash-icons tf-icons bx bx-dollar bx-lg"></i>
              </div>

            </div>
            <span class="fw-semibold d-block mb-1">Payments Collected</span>
            <h1 class="card-title text-nowrap mb-1">{{get_settings('currency_sign')}}{{$allpayments}}</h1>
          </div>
        </div>
      </div>
    </div>
  </div>


</div>
@endsection
