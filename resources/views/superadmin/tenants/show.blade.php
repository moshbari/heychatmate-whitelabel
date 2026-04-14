@extends('layouts/contentNavbarLayout')

@section('title', 'Tenant: ' . $tenant->name)

@section('content')
<div class="row">
  <div class="col-12 mb-4">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <div>
          <h5 class="mb-0">{{ $tenant->name }}</h5>
          <small class="text-muted">{{ $tenant->domain }}</small>
        </div>
        <div>
          @if ($tenant->status === 'active')
            <span class="badge bg-label-success me-2">Active</span>
          @elseif ($tenant->status === 'trial')
            <span class="badge bg-label-warning me-2">Trial</span>
          @elseif ($tenant->status === 'suspended')
            <span class="badge bg-label-danger me-2">Suspended</span>
          @endif
          <a href="{{ route('superadmin.tenants') }}" class="btn btn-sm btn-outline-secondary">Back</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Tenant Details -->
  <div class="col-md-8 mb-4">
    <div class="card">
      <div class="card-header"><h5 class="mb-0">Tenant Details</h5></div>
      <div class="card-body">
        <form action="{{ route('superadmin.tenants.update', $tenant->id) }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Business Name</label>
              <input type="text" name="name" class="form-control" value="{{ $tenant->name }}" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Status</label>
              <select name="status" class="form-select">
                <option value="active" {{ $tenant->status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="trial" {{ $tenant->status === 'trial' ? 'selected' : '' }}>Trial</option>
                <option value="suspended" {{ $tenant->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                <option value="cancelled" {{ $tenant->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Plan</label>
              <select name="plan_id" class="form-select">
                <option value="">No Plan</option>
                @foreach ($plans as $plan)
                  <option value="{{ $plan->id }}" {{ $tenant->plan_id == $plan->id ? 'selected' : '' }}>{{ $plan->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label">Max Users</label>
              <input type="number" name="max_users" class="form-control" value="{{ $tenant->max_users }}" min="1">
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label">Max Bots/User</label>
              <input type="number" name="max_bots_per_user" class="form-control" value="{{ $tenant->max_bots_per_user }}" min="1">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Credit Balance</label>
              <input type="number" name="credit_balance" class="form-control" value="{{ $tenant->credit_balance }}" step="0.01" min="0">
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Update Tenant</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Quick Info -->
  <div class="col-md-4 mb-4">
    <div class="card mb-4">
      <div class="card-body">
        <h6>Owner</h6>
        <p class="mb-1"><strong>{{ $tenant->owner->name ?? 'N/A' }}</strong></p>
        <p class="mb-3"><small>{{ $tenant->owner->email ?? '' }}</small></p>
        <h6>API Mode</h6>
        <p class="mb-3">{{ $tenant->api_mode === 'own' ? 'Own API Key' : 'Platform Credits' }}</p>
        <h6>Payment Processor</h6>
        <p class="mb-3">{{ ucfirst($tenant->payment_processor ?? 'Not Set') }}</p>
        <h6>Subdomain</h6>
        <p class="mb-1">{{ $tenant->slug }}.whitelabel.heychatmate.com</p>
        @if ($tenant->custom_domain)
        <h6 class="mt-3">Custom Domain</h6>
        <p>{{ $tenant->custom_domain }}
          @if ($tenant->domain_verified)
            <span class="badge bg-success">Verified</span>
          @else
            <span class="badge bg-warning">Pending</span>
          @endif
        </p>
        @endif
        <h6>Created</h6>
        <p>{{ $tenant->created_at->format('M d, Y') }}</p>
      </div>
    </div>
  </div>
</div>

<!-- Tenant Users -->
<div class="row">
  <div class="col-12 mb-4">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Users ({{ $tenant->users->count() }} / {{ $tenant->max_users }})</h5>
      </div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr><th>Name</th><th>Email</th><th>Role</th><th>Credits</th><th>Status</th><th>Joined</th></tr>
          </thead>
          <tbody>
            @foreach ($tenant->users as $user)
            <tr>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td><span class="badge bg-label-info">{{ $user->role }}</span></td>
              <td>{{ number_format($user->credit_balance) }}</td>
              <td>{!! $user->status ? '<span class="badge bg-label-success">Active</span>' : '<span class="badge bg-label-danger">Inactive</span>' !!}</td>
              <td>{{ $user->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@if (session('success'))
<script>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({ icon: 'success', title: 'Success', text: '{{ session("success") }}', timer: 3000, showConfirmButton: false });
  });
</script>
@endif
@endsection
