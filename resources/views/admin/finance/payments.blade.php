@extends('layouts/contentNavbarLayout')

@section('title', 'User Payment')

@section('content')

<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Admin /</span> User Payments

</h4>
<!-- Button trigger modal -->

<!-- Basic Bootstrap Table -->
<div class="card">

  @include('content.alerts')

  <div class="row">
    <div class="col-sm-6">

      <h5 class="card-header">ALL User Payments</h5>
    </div>
    <div class="col-sm-6">

      <form action="" method="get">
        <div class="m-3 float-end">
          <label class="form-label">Search User</label>
          <input type="text" class="form-control search" name="search" placeholder="Enter Email" autocomplete="off">
        </div>

      </form>


    </div>

  </div>
  <div class="table table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Date</th>
          <th>User</th>
          <th>Amount</th>
          <th>Gateway</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($payments as $payment)
        <tr>
          <td>{{ $payment->created_at }}</td>
          <td><a href="{{ route('user.view', $payment->user->id) }}" target="_blank">{{ $payment->user->email }}</a>
          </td>
          <td>{{ get_settings('currency_sign') }}{{ $payment->amount }}</td>
          <td>{{ $payment->gateway->name }}</td>
          <td>{!! $payment->status == 1
            ? '<span class="badge bg-success">Completed</span>'
            : '<span class="badge bg-warning">Pending</span>' !!}</td>

        </tr>
        @empty
        <tr>
          <td colspan="7">No Data Found In the system.</td>
        </tr>
        @endforelse


      </tbody>
    </table>
  </div>
</div>
<!--/ Basic Bootstrap Table -->

@endsection
@section('page-script')

@endsection
