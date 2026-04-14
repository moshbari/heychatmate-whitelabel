@extends('layouts/contentNavbarLayout')

@section('title', 'Chat Settings')

@section('page-script')
<script src="{{asset('assets/js/form-basic-inputs.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Admin /</span> Profile
</h4>

<div class="row">

  <!-- Form controls -->
  <div class="col-md-6">
    <div class="card mb-4">
      <h5 class="card-header">Update Profile</h5>
      <div class="card-body">
        @include('content.alerts')
        <form action="{{route('profile.update')}}" method="post">
              @csrf
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Login Email</label>
                <input type="text" name="email" class="form-control" value="{{auth()->user()->email}}"
                  id="exampleFormControlInput1" placeholder="name@example.com" required/>
              </div>

              <div class="mb-3">
                <label for="exampleFormControlReadOnlyInput1" class="form-label">OLD Password</label>
                <input class="form-control" type="password" name="cpass" value=""
                  id="exampleFormControlReadOnlyInput1" placeholder="Readonly input here..." required/>
              </div><div class="mb-3">
                <label for="exampleFormControlReadOnlyInput1" class="form-label">New Password</label>
                <input class="form-control" type="password" name="newpass" value=""
                  id="exampleFormControlReadOnlyInput1" placeholder="Readonly input here..." required/>
              </div>

              <div class="mb-3">
                <label for="exampleFormControlReadOnlyInput1" class="form-label">Repeat New Password</label>
                <input class="form-control" type="password" name="renewpass" value=""
                  id="exampleFormControlReadOnlyInput1" placeholder="Readonly input here..." required/>
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
