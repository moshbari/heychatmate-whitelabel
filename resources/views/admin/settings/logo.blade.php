@extends('layouts/contentNavbarLayout')

@section('title', 'Logo Settings')

@section('page-script')
    <script src="{{ asset('assets/js/form-basic-inputs.js') }}"></script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Settings /</span> Logo Settings
    </h4>

    <div class="row">

                    @include('content.alerts')
        <!-- Form controls -->
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Update Logo</h5>
                <div class="card-body">
                    <form action="{{ route('settings.update.image') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="formFile" class="form-label">Current Logo</label>
                            <img src="{{ asset('assets/front/images/home/' . get_settings('system_logo')) }}" class=""
                                alt="Cinque Terre" width="100%" height="auto">
                        </div>

                        <div class="mb-3">
                            <label for="formFile" class="form-label">Select New Logo</label>
                            <input class="form-control" type="file" name="logo" id="formFile1">
                        </div>


                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>

                    </form>



                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Update Favicon</h5>
                <div class="card-body">
                    <form action="{{ route('settings.update.image') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="formFile" class="form-label">Current Favicon</label>
                            <img src="{{ asset('assets/front/images/home/' . get_settings('system_favicon')) }}" class=""
                                alt="Cinque Terre" width="100%" height="auto">
                        </div>

                        <div class="mb-3">
                            <label for="formFile" class="form-label">Select New Favicon</label>
                            <input class="form-control" type="file" name="favicon" id="formFile2">
                        </div>


                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>

                    </form>



                </div>
            </div>
        </div>



    </div>
@endsection
