@extends('layouts/contentNavbarLayout')

@section('title', 'My Payment')

@section('content')

<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Account /</span> My Payments

</h4>
<!-- Button trigger modal -->

<!-- Basic Bootstrap Table -->
<div class="card">
    <h5 class="card-header">All Payments</h5>

    @include('content.alerts')
    <div class="table table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Plan</th>
                    <th>Amount</th>
                    <th>Gateway</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($payments as $payment)
                <tr>
                    <td>{{ $payment->created_at }}</td>
                    <td>{{ $payment->plan->name }}</td>
                    <td>{{get_settings('currency_sign')}}{{ $payment->amount }}</td>
                    <td>{{ $payment->gateway->name  }}</td>
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

    <div class="d-flex m-3 ">
        {!! $payments->links() !!}
    </div>
</div>
<!--/ Basic Bootstrap Table -->

@endsection
@section('page-script')
<!--Embed Code starts-->
<script type="text/javascript"></script>
<!--Embed Code ends-->
@endsection