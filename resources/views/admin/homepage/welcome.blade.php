@extends('layouts/contentNavbarLayout')

@section('title', 'Welcome Section')

@section('page-script')
    <script src="{{ asset('assets/js/form-basic-inputs.js') }}"></script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">HomePage /</span> Welcome Section
    </h4>

    <div class="row">

        @include('content.alerts')
        <!-- Form controls -->
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Change Welcome Contents </h5>
                <div class="card-body">

                    <form action="{{ route('homepage.update') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Small Title</label>
                                    <textarea class="form-control" name="welcome_small_title" rows="5">{!! get_settings('welcome_small_title') !!}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <textarea class="form-control" name="welcome_title" rows="5">{!! get_settings('welcome_title') !!}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Subtitle</label>
                                    <textarea class="form-control" name="welcome_subtitle" rows="5">{!! get_settings('welcome_subtitle') !!}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Current Video</label>
                                    <video width="100%" autoplay="" muted="" loop="" playsinline="">
                                        <source src="{{ asset('assets/front/images/home/'.get_settings('welcome_video')) }}" type="video/mp4">
                                        Your browser does not support HTML video.
                                    </video>
                                </div>

                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Upload New Video</label>
                                    <input class="form-control" type="file" name="wvideo" id="formFile">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>

                    </form>



                </div>
            </div>
        </div>


    </div>
@endsection
