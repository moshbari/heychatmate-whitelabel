@extends('layouts/contentNavbarLayout')

@section('title', 'API Settings')

@section('page-script')

@endsection

@section('content')

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Dashboard / API Configutation
            <a href="{{ route('user.dashboard') }}" class="btn btn-primary"><i class='bx bx-arrow-back bx-sm'></i></a>
    </h4>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Open AI Configurations</h5>
                <div class="card-body">
                    @include('content.alerts')
                    <form action="{{ route('user.config.update', $config->id) }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">Select Model</label>
                            <select class="form-select" id="exampleFormControlSelect1" name="ai_model"
                                aria-label="Default select">
                                <option value="month">Select AI Model</option>
                                @foreach ($models as $model)
                                    <option value="{{ $model->api_code }}" {{$config->ai_model == $model->api_code?'selected':''}}>{{ $model->name }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Setup API Key</label>

                            <input type="text" class="form-control" value="{{ $config->api_key }}" name="api_key">
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Save Config</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
@endsection
