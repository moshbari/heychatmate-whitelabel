@extends('layouts/contentNavbarLayout')

@section('title', 'Manage Account')

@section('content')

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Account /</span> Security
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
                <h5 class="card-header">Change Account Password</h5>
                <div class="card-body">
                    @include('content.alerts')
                    <form action="{{ route('password.update') }}" method="post">
                        @csrf

                        <div class="mb-3">
                            <label for="exampleFormControlReadOnlyInput1" class="form-label">OLD Password</label>
                            <input class="form-control" type="password" name="cpass" value=""
                                id="exampleFormControlReadOnlyInput1" placeholder="Enter Password" required />
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlReadOnlyInput1" class="form-label">New Password</label>
                            <input class="form-control" type="password" name="newpass" value=""
                                id="exampleFormControlReadOnlyInput1" placeholder="Enter new Password" required />
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlReadOnlyInput1" class="form-label">Repeat New Password</label>
                            <input class="form-control" type="password" name="renewpass" value=""
                                id="exampleFormControlReadOnlyInput1" placeholder="Re-Enter new Password..." required />
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
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
