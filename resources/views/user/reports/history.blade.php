@extends('layouts/contentNavbarLayout')

@section('title', 'My Credit History')

@section('content')

<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Account /</span> My Credit History

</h4>
<!-- Button trigger modal -->

<!-- Basic Bootstrap Table -->
<div class="card">
    <h5 class="card-header">My Credit History</h5>

    @include('content.alerts')
    <div class="table table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Credit</th>
                    <th>Details</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->created_at }}</td>
                    <td><strong class="{{ $transaction->type == '+'?'text-success':'text-danger' }}">{{ $transaction->type }}</strong> {{ $transaction->amount }}</td>
                    <td>{{ $transaction->details  }}</td>
                    <td>{!! $transaction->status == 1
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
        {!! $transactions->links() !!}
    </div>
</div>
<!--/ Basic Bootstrap Table -->

@endsection
@section('page-script')
<!--Embed Code starts-->
<script type="text/javascript"></script>
<!--Embed Code ends-->
@endsection