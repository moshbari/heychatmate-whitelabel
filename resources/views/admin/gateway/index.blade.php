@extends('layouts/contentNavbarLayout')

@section('title', 'Manage Gateways')

@section('content')

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Admin /</span> Manage Gateways

    </h4>
    <!-- Button trigger modal -->

    <!-- Basic Bootstrap Table -->
    <div class="row">

        @include('content.alerts')
        @foreach ($gateways as $gateway)
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header">{{ $gateway->name }} Configurations</h5>
                    <div class="card-body">
                        <form action="{{ route('gateway.update', $gateway) }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Gateway Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $gateway->name }}"
                                    id="exampleFormControlInput1" placeholder="Title" />
                            </div>


                            @if ($gateway->information != null)
                                @foreach ($gateway->convertAutoData() as $pkey => $pdata)
                                    @if ($pkey != 'sandbox_check')
                                        <div class="mb-3">
                                            <label for=""
                                                class="form-label">{{ __($gateway->name . ' ' . ucwords(str_replace('_', ' ', $pkey))) }}</label>
                                            <input type="text"class="form-control" name="pkey[{{ __($pkey) }}]"
                                                value="{{ $pdata }}" {{ $pdata == 1 ? 'checked' : '' }}
                                                id="" placeholder="Subtitle" />
                                        </div>
                                    @endif
                                @endforeach
                                @foreach ($gateway->convertAutoData() as $pkey => $pdata)
                                    @if ($pkey == 'sandbox_check')
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" name="pkey[{{ __($pkey) }}]"
                                                value="1" id="defaultCheck3" {{ $pdata == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="defaultCheck3">
                                                {{ __($gateway->name . ' ' . ucwords(str_replace('_', ' ', $pkey))) }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            <div class="mb-3">
                                <label for="exampleFormControlSelect1" class="form-label">{{ $gateway->name }}
                                    Status</label>
                                <select name="status" class="form-select">
                                    <option value="1" {{ $gateway->status == 1 ? 'selected' : '' }}>
                                        @lang('Active')</option>
                                    <option value="0" {{ $gateway->status == 0 ? 'selected' : '' }}>
                                        @lang('Inactive')</option>
                                </select>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        @endforeach


    </div>

    <!--/ Basic Bootstrap Table -->



@endsection
@section('page-script')
    <script type="text/javascript"></script>
    <!--Embed Code ends-->
@endsection
