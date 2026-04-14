@extends('layouts/contentNavbarLayout')

@section('title', 'Manage Account')

@section('content')

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Account /</span> Profile Information
    </h4>
    <!-- Button trigger modal -->


    <!-- Content -->

    <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">

            @include('user.includes.profile-side')
        </div>
        <!--/ User Sidebar -->


        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">

            @include('user.includes.profile-nav')

            <!-- Project table -->
            <div class="card mb-4">
                <h5 class="card-header">Update Account Informations</h5>
                <div class="card-body">

                    @include('content.alerts')
                    <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="formFile" class="form-label">Change Photo</label>
                            <input class="form-control" type="file" name="photo" id="formFile">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}"
                                id="exampleFormControlInput1" placeholder="Enter Full Name" required />
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" value="{{ $user->email }}"
                                id="exampleFormControlInput1" placeholder="name@example.com" required />
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}"
                                id="exampleFormControlInput1" placeholder="Enter Phone Number" required />
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">Country</label>
                            <select class="form-select" id="exampleFormControlSelect1" name="country" required>
                                <option value="">Select Country</option>
                                @foreach (allCountries() as $country)
                                    @if ($user->country == $country->id)
                                        <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                                    @else
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endif
                                @endforeach

                            </select>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>

                    </form>
                </div>

            </div>
            <!-- /Project table -->

        </div>
        <!--/ User Content -->
    </div>


    <!-- Content wrapper -->
@endsection
@section('page-script')
    <!--Embed Code starts-->
    <script type="text/javascript">

    </script>

@endsection
