@extends('layouts/contentNavbarLayout')

@section('title', 'AutoResponder Setup')

@section('page-script')

@endsection

@section('content')

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Dashboard / AutoResponder Setup
            <a href="{{ route('user.dashboard') }}" class="btn btn-primary"><i class='bx bx-arrow-back bx-sm'></i></a>
    </h4>

    <div class="row">
        @include('content.alerts')

        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">SendLane Configurations</h5>
                <div class="card-body">
                    <form action="{{ route('user.responder.update', $responder->id) }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">SendLane Status</label>
                            <select class="form-select" id="exampleFormControlSelect1" name="sendlane_status"
                                aria-label="Default select">
                                <option value="1" {{ $responder->sendlane_status == 1 ? 'selected' : '' }}>Enable</option>
                                <option value="0" {{ $responder->sendlane_status == 0 ? 'selected' : '' }}>Disabled
                                </option>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">SendLane List ID</label>

                            <input type="text" class="form-control" value="{{ $responder->sendlane_listid }}"
                                name="sendlane_listid">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">SendLane API Key</label>

                            <input type="text" class="form-control" value="{{ $responder->sendlane_apiKey }}"
                                name="sendlane_apiKey">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">SendLane API Hash</label>

                            <input type="text" class="form-control" value="{{ $responder->sendlane_apiHash }}"
                                name="sendlane_apiHash">
                        </div>

                        <input type="hidden" name="responder" value="SendLane">

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Save SendLane</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">GetResponse Configurations</h5>
                <div class="card-body">

                    <form action="{{ route('user.responder.update', $responder->id) }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">GetResponse Status</label>
                            <select class="form-select" id="exampleFormControlSelect1" name="getresponse_status"
                                aria-label="Default select">
                                <option value="1" {{ $responder->getresponse_status == 1 ? 'selected' : '' }}>Enable
                                </option>
                                <option value="0" {{ $responder->getresponse_status == 0 ? 'selected' : '' }}>Disabled
                                </option>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">GetResponse Campaign ID</label>

                            <input type="text" class="form-control" value="{{ $responder->getresponse_campaign_id }}"
                                name="getresponse_campaign_id">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">GetResponse API Token</label>

                            <input type="text" class="form-control" value="{{ $responder->getresponse_token }}"
                                name="getresponse_token">
                        </div>

                        <input type="hidden" name="responder" value="GetResponse">

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Save GetResponse</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">SystemIO Configurations</h5>
                <div class="card-body">

                    <form action="{{ route('user.responder.update', $responder->id) }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">SystemIO Status</label>
                            <select class="form-select" id="exampleFormControlSelect1" name="systemio_status"
                                aria-label="Default select">
                                <option value="1" {{ $responder->systemio_status == 1 ? 'selected' : '' }}>Enable
                                </option>
                                <option value="0" {{ $responder->systemio_status == 0 ? 'selected' : '' }}>Disabled
                                </option>

                            </select>
                        </div>


                        <div class="mb-3">
                            <label class="form-label">SystemIO API Key</label>

                            <input type="text" class="form-control" value="{{ $responder->systemio_apikey }}"
                                name="systemio_apikey">
                        </div>

                        <input type="hidden" name="responder" value="SystemIO">

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Save SystemIO</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
