@extends('layouts/contentNavbarLayout')

@section('title', 'Manage Users')

@section('content')

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Dashboard /</span> Manage Users / Security

        <a href="{{ route('manage.user') }}" class="btn btn-primary">
            <i class='bx bx-arrow-back bx-sm'></i>
        </a>

    </h4>
    <!-- Button trigger modal -->


    <!-- Content -->

    <div class="row">
                <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">

            @include('admin.includes.profile-side')
        </div>
        <!--/ User Sidebar -->


        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">

            @include('admin.includes.profile-nav')

            <!-- Project table -->
            <div class="card mb-4">
                <h5 class="card-header">Change User Password</h5>
                <div class="card-body">
                    @include('content.alerts')
                    <form action="{{ route('user.security.update', $user->id) }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">New Password</label>
                            <input type="password" name="pass" class="form-control" value=""
                                id="exampleFormControlInput1" placeholder="********" required />
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Confirm New Password</label>
                            <input type="password" name="repass" class="form-control" value=""
                                id="exampleFormControlInput1" placeholder="*******" required />
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
