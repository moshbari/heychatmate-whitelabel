@extends('layouts/contentNavbarLayout')

@section('title', 'Tenant Subscriptions')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Tenant Subscriptions</h5>
      </div>
      <div class="table-responsive text-nowrap">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Tenant</th>
              <th>Plan</th>
              <th>Amount</th>
              <th>Cycle</th>
              <th>Due Date</th>
              <th>Payment Method</th>
              <th>Status</th>
              <th>Created</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($subscriptions as $sub)
            <tr>
              <td><strong>{{ $sub->tenant->app_name ?? 'N/A' }}</strong></td>
              <td>{{ $sub->plan->name ?? 'N/A' }}</td>
              <td>${{ number_format($sub->amount, 2) }}</td>
              <td>{{ ucfirst($sub->cycle) }}</td>
              <td>{{ $sub->due_date ? $sub->due_date->format('M d, Y') : '-' }}</td>
              <td>{{ ucfirst($sub->payment_method ?? '-') }}</td>
              <td>
                @if ($sub->status === 'active')
                  <span class="badge bg-label-success">Active</span>
                @elseif ($sub->status === 'cancelled')
                  <span class="badge bg-label-danger">Cancelled</span>
                @else
                  <span class="badge bg-label-warning">{{ ucfirst($sub->status) }}</span>
                @endif
              </td>
              <td>{{ $sub->created_at->format('M d, Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center py-4">No subscriptions yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if ($subscriptions->hasPages())
      <div class="card-footer d-flex justify-content-center">
        {{ $subscriptions->links() }}
      </div>
      @endif
    </div>
  </div>
</div>
@endsection
