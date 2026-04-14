@extends('layouts/contentNavbarLayout')

@section('title', 'Subscriptions List')

@section('content')

<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Admin /</span> Subscriptions List

</h4>
<!-- Button trigger modal -->

<!-- Basic Bootstrap Table -->
<div class="card">

    @include('content.alerts')
    <div class="row">
        <div class="col-sm-6">

            <h5 class="card-header">ALL User Subscriptions</h5>
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
                    <th>User</th>
                    <th>Plan</th>
                    <th>Amount</th>
                    <th>Period</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($subscriptions as $subscription)
                <tr>
                    <td><a href="{{ route('user.view', $subscription->user->id) }}" target="_blank">{{ $subscription->user->email }}</a></td>
                    <td>{{ $subscription->plan->name }}</td>
                    <td>{{ get_settings('currency_sign') }}{{ $subscription->amount }}</td>
                    <td>Start: {{ $subscription->created_at->format('Y-m-d') }} <br> End:
                        {{ $subscription->due_date->format('Y-m-d') }}
                    </td>
                    <td>{!! $subscription->status == 1
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Not Active</span>' !!}</td>

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
<!--Embed Code starts-->
<script type="text/javascript"></script>
<!--Embed Code ends-->
@endsection