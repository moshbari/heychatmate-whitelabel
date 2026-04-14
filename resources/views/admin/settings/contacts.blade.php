@extends('layouts/contentNavbarLayout')

@section('title', 'Contact Settings')

@section('page-script')
    <script src="{{ asset('assets/js/form-basic-inputs.js') }}"></script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Settings /</span> Contact Settings
    </h4>

    <div class="row">

                    @include('content.alerts')
        <!-- Form controls -->
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Contact Settings</h5>
                <div class="card-body">

                <small>Leave the field Empty to not show the section.</small>
                    <form action="{{ route('settings.update') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Contact Us Text</label>
                           <textarea class="form-control" name="contact_us_text" rows="5">{!! get_settings('contact_us_text') !!}</textarea>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Contact Us Phone</label>
                           <textarea class="form-control" name="contact_phone" rows="5">{!! get_settings('contact_phone') !!}</textarea>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Contact Us Email</label>
                           <textarea class="form-control" name="contact_email" rows="5">{!! get_settings('contact_email') !!}</textarea>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Contact Us Address</label>
                           <textarea class="form-control" name="contact_address" rows="5">{!! get_settings('contact_address') !!}</textarea>
                        </div>


                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>



                </div>
            </div>
        </div>

    </div>
@endsection
