@extends('layouts/contentNavbarLayout')

@section('title', 'Content Settings')

@section('page-script')
    <script src="{{ asset('assets/js/form-basic-inputs.js') }}"></script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Settings /</span> Content Settings
    </h4>

    <div class="row">

                    @include('content.alerts')
        <!-- Form controls -->
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Core Settings</h5>
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">System Title</label>
                            <input type="text" name="system_title" class="form-control" value="{!! get_settings('system_title') !!}" placeholder="" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">System Currency Code</label>
                            <input type="text" name="currency_code" class="form-control" value="{!! get_settings('currency_code') !!}" placeholder="USD" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Currency Sign</label>
                            <input type="text" name="currency_sign" class="form-control" value="{!! get_settings('currency_sign') !!}" placeholder="$" />
                        </div>


                        <div class="mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">Email Verification</label>
                            <select class="form-select" id="exampleFormControlSelect1" name="email_verification"
                                aria-label="Default select">
                                <option value="1" {{ get_settings('email_verification') == '1' ? 'selected' : '' }}>Active
                                </option>
                                <option value="0" {{ get_settings('email_verification') == '0' ? 'selected' : '' }}>Deactivated
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">User Registration</label>
                            <select class="form-select" id="exampleFormControlSelect1" name="user_registration"
                                aria-label="Default select">
                                <option value="1" {{ get_settings('user_registration') == '1' ? 'selected' : '' }}>Active
                                </option>
                                <option value="0" {{ get_settings('user_registration') == '0' ? 'selected' : '' }}>Deactivated
                                </option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>

                    </form>



                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">OpenAI Settings</h5>
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="post">
                        @csrf

                        <div class="mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">Select OpenAI Model</label>
                            <select class="form-select" id="exampleFormControlSelect1" name="system_ai_model"
                                aria-label="Default select">
                                <option value="month">Select OpenAI Model</option>
                                @foreach (App\Models\AiModel::all() as $model)
                                    <option value="{{ $model->api_code }}" {{get_settings('system_ai_model') == $model->api_code?'selected':''}}>{{ $model->name }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">OpenAI API Key</label>
                            <input type="text" name="system_api_key" class="form-control" value="{!! get_settings('system_api_key') !!}" placeholder="" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">OpenAI Token Rate</label>
                            <small>How many characters will count as one token?</small>
                            <input type="text" name="token_rate" class="form-control" value="{!! get_settings('token_rate') !!}" placeholder="" />
                        </div>


                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>

                    </form>



                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Footer Settings</h5>
                <div class="card-body">
                    <form action="{{ route('settings.update') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Footer About Text</label>
                            <input type="text" name="footer_about_text" class="form-control" value="{!! get_settings('footer_about_text') !!}" placeholder="name@example.com" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Copyright Text</label>
                            <input type="text" name="copyright_text" class="form-control" value="{!! get_settings('copyright_text') !!}" placeholder="name@example.com" />
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
