@extends('layouts/contentNavbarLayout')

@section('title', 'Change Password')

@section('page-script')
    <script src="{{ asset('assets/js/form-basic-inputs.js') }}"></script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Account /</span> Change Password
    </h4>

    <div class="row">

        <!-- Form controls -->
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Update Password</h5>
                <div class="card-body">
                    @include('content.alerts')
                    <form action="{{ route('profile.update') }}" method="post">
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
        </div>


    </div>
@endsection
