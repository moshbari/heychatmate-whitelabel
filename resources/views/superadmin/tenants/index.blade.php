@extends('layouts/contentNavbarLayout')

@section('title', 'Manage Tenants')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Manage Tenants</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTenantModal">
          <i class="bx bx-plus me-1"></i> Add Tenant
        </button>
      </div>

      <!-- Search -->
      <div class="card-body pb-0">
        <form method="GET" class="row g-3 mb-3">
          <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search by name, slug, or domain..." value="{{ request('search') }}">
          </div>
          <div class="col-md-3">
            <select name="status" class="form-select">
              <option value="">All Status</option>
              <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
              <option value="trial" {{ request('status') === 'trial' ? 'selected' : '' }}>Trial</option>
              <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
              <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-outline-primary">Filter</button>
          </div>
        </form>
      </div>

      <div class="table-responsive text-nowrap">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>Tenant</th>
              <th>Owner</th>
              <th>Plan</th>
              <th>Users</th>
              <th>Credits</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($tenants as $tenant)
            <tr>
              <td>{{ $tenant->id }}</td>
              <td>
                <strong>{{ $tenant->name }}</strong><br>
                <small class="text-muted">
                  @if ($tenant->domain_verified && $tenant->custom_domain)
                    {{ $tenant->custom_domain }}
                  @else
                    {{ $tenant->slug }}.whitelabel.heychatmate.com
                  @endif
                </small>
              </td>
              <td>{{ $tenant->owner->name ?? 'N/A' }}<br><small>{{ $tenant->owner->email ?? '' }}</small></td>
              <td>{{ $tenant->plan->name ?? 'No Plan' }}</td>
              <td>{{ $tenant->users->count() }} / {{ $tenant->max_users }}</td>
              <td>{{ number_format($tenant->credit_balance) }}</td>
              <td>
                @if ($tenant->status === 'active')
                  <span class="badge bg-label-success">Active</span>
                @elseif ($tenant->status === 'trial')
                  <span class="badge bg-label-warning">Trial</span>
                @elseif ($tenant->status === 'suspended')
                  <span class="badge bg-label-danger">Suspended</span>
                @else
                  <span class="badge bg-label-secondary">{{ ucfirst($tenant->status) }}</span>
                @endif
              </td>
              <td>
                <a href="{{ route('superadmin.tenants.show', $tenant->id) }}" class="btn btn-sm btn-outline-primary">
                  <i class="bx bx-show"></i>
                </a>
              </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center py-4">No tenants found. Create your first tenant above.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if ($tenants->hasPages())
      <div class="card-footer">
        {{ $tenants->links() }}
      </div>
      @endif
    </div>
  </div>
</div>

<!-- Add Tenant Modal -->
<div class="modal fade" id="addTenantModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('superadmin.tenants.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Add New Tenant</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Business Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Subdomain Slug</label>
            <div class="input-group">
              <input type="text" name="slug" class="form-control" placeholder="acme" required>
              <span class="input-group-text">.whitelabel.heychatmate.com</span>
            </div>
          </div>
          <div class="row">
            <div class="col-6 mb-3">
              <label class="form-label">Owner Name</label>
              <input type="text" name="owner_name" class="form-control" required>
            </div>
            <div class="col-6 mb-3">
              <label class="form-label">Owner Email</label>
              <input type="email" name="owner_email" class="form-control" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="text" name="password" class="form-control" value="{{ \Illuminate\Support\Str::random(10) }}">
          </div>
          <div class="row">
            <div class="col-6 mb-3">
              <label class="form-label">Plan</label>
              <select name="plan_id" class="form-select">
                <option value="">No Plan</option>
                @foreach ($plans as $plan)
                  <option value="{{ $plan->id }}">{{ $plan->name }} (${{ $plan->price }}/{{ $plan->billing_cycle }})</option>
                @endforeach
              </select>
            </div>
            <div class="col-6 mb-3">
              <label class="form-label">Status</label>
              <select name="status" class="form-select">
                <option value="trial">Trial</option>
                <option value="active">Active</option>
                <option value="suspended">Suspended</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Create Tenant</button>
        </div>
      </form>
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
