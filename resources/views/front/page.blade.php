@extends('layouts/front/master')

@section('title', $page->title)

@section('content')

<!-- Start Services Area -->
<div class="pages section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <div class="section-title">
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">{{$page->name}}</h2>
                    <span class="devide"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <p>
                {!!$page->contents!!}
            </p>


        </div>
    </div>
</div>
<!-- End Services Area -->

@endsection
@section('page-script')
<!--Embed Code starts-->
<!-- <script src="https://state.kodecast.com/public/widgets/cbfaf7a17e668b5aca7ffa7de6fb6e36804efe98"></script> -->
<!--Embed Code ends-->
@endsection