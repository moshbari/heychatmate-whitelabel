@extends('layouts/contentNavbarLayout')

@section('title', 'Login Section')

@section('page-script')
    <script src="{{ asset('assets/js/form-basic-inputs.js') }}"></script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">HomePage /</span> Login Section
    </h4>

    <div class="row">

        @include('content.alerts')
        <!-- Form controls -->
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Change Login Page Contents </h5>
                <div class="card-body">

                    <form action="{{ route('homepage.update') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <textarea class="form-control" name="login_page_title" rows="5">{!! get_settings('login_page_title') !!}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Subtitle</label>
                                    <textarea class="form-control" name="login_page_subtitle" rows="5">{!! get_settings('login_page_subtitle') !!}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Current Image</label>
                                    <img src="{{ asset('assets/front/images/home/' . get_settings('login_page_image')) }}" width="100%" alt="image">
                                </div>

                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Upload New Image</label>
                                    <input class="form-control" type="file" name="image" id="formFile">
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
