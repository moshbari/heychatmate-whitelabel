@extends('layouts/contentNavbarLayout')

@section('title', 'Tenant Transactions')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Tenant Transactions</h5>
      </div>
      <div class="table-responsive text-nowrap">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>TRX ID</th>
              <th>Tenant</th>
              <th>Amount</th>
              <th>Credits</th>
              <th>Type</th>
              <th>Remark</th>
              <th>Status</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($transactions as $txn)
            <tr>
              <td><code>{{ $txn->trx_id }}</code></td>
              <td><strong>{{ $txn->tenant->app_name ?? 'N/A' }}</strong></td>
              <td>${{ number_format($txn->amount, 2) }}</td>
              <td>{{ number_format($txn->credits) }}</td>
              <td>
                @if ($txn->type === '+')
                  <span class="badge bg-label-success">Credit</span>
                @else
                  <span class="badge bg-label-danger">Debit</span>
                @endif
              </td>
              <td>{{ $txn->remark ?? '-' }}</td>
              <td>{!! $txn->status ? '<span class="badge bg-label-success">Complete</span>' : '<span class="badge bg-label-warning">Pending</span>' !!}</td>
              <td>{{ $txn->created_at->format('M d, Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center py-4">No transactions yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if ($transactions->hasPages())
      <div class="card-footer d-flex justify-content-center">
        {{ $transactions->links() }}
      </div>
      @endif
    </div>
  </div>
</div>
@endsection
