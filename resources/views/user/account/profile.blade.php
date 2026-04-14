@extends('layouts/contentNavbarLayout')

@section('title', 'Profile Information')

@section('page-script')
    <script src="{{ asset('assets/js/form-basic-inputs.js') }}"></script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Account /</span> Profile Information
    </h4>

    <div class="row">

        <!-- Form controls -->
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Update Profile</h5>
                <div class="card-body">
                    @include('content.alerts')
                    <form action="{{ route('profile.update') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}"
                                id="exampleFormControlInput1" placeholder="Enter Full Name" required />
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" value="{{ auth()->user()->email }}"
                                id="exampleFormControlInput1" placeholder="name@example.com" required  {{auth()->user()->type == 'admin'?'':'disabled'}}/>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="{{ auth()->user()->phone }}"
                                id="exampleFormControlInput1" placeholder="Enter Phone Number" required />
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">Country</label>
                            <select class="form-select" id="exampleFormControlSelect1" name="country">
                                <option value="">Select Country</option>
                                @foreach (allCountries() as $country)
                                    @if (auth()->user()->country == $country->id)
                                        <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                                    @else
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endif
                                @endforeach

                            </select>
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
