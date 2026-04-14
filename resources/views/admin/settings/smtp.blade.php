@extends('layouts/contentNavbarLayout')

@section('title', 'SMTP Configuration')

@section('page-script')
    <script src="{{ asset('assets/js/form-basic-inputs.js') }}"></script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Settings /</span> SMTP Configuration
    </h4>

    <div class="row">

                    @include('content.alerts')
        <!-- Form controls -->
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">SMTP Configuration</h5>
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="post">
                        @csrf

                        <div class="mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">Email Type</label>
                            <select class="form-select" id="exampleFormControlSelect1" name="email_type"
                                aria-label="Default select">
                                <option value="smtp" {{ get_settings('email_type') == 'smtp' ? 'selected' : '' }}>SMTP
                                </option>
                                <option value="php" {{ get_settings('emai_type') == 'php' ? 'selected' : '' }}>PHP Mail
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">SMTP Host</label>
                            <input type="text" name="smtp_host" class="form-control" value="{!! get_settings('smtp_host') !!}" placeholder="" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">SMTP Username</label>
                            <input type="text" name="smtp_user" class="form-control" value="{!! get_settings('smtp_user') !!}" placeholder="" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">SMTP Password</label>
                            <input type="text" name="smtp_pass" class="form-control" value="{!! get_settings('smtp_pass') !!}" placeholder="" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">SMTP Port</label>
                            <input type="text" name="smtp_port" class="form-control" value="{!! get_settings('smtp_port') !!}" placeholder="" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mail Entryption</label>
                            <input type="text" name="smtp_encryption" class="form-control" value="{!! get_settings('smtp_encryption') !!}" placeholder="" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">From Email</label>
                            <input type="text" name="email_from" class="form-control" value="{!! get_settings('email_from') !!}" placeholder="" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">From Name Password</label>
                            <input type="text" name="name_from" class="form-control" value="{!! get_settings('name_from') !!}" placeholder="" />
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
