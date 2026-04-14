@extends('layouts/contentNavbarLayout')

@section('title', 'Super Admin Dashboard')

@section('content')
<div class="row">
  <!-- Total Tenants -->
  <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div class="card-info">
            <p class="card-text mb-1">Total Tenants</p>
            <div class="d-flex align-items-end mb-2">
              <h4 class="card-title mb-0 me-2">{{ $totalTenants }}</h4>
            </div>
            <small class="text-success">{{ $activeTenants }} active</small>
          </div>
          <div class="card-icon">
            <span class="badge bg-label-primary rounded p-2">
              <i class="bx bx-buildings bx-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Trial Tenants -->
  <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div class="card-info">
            <p class="card-text mb-1">On Trial</p>
            <div class="d-flex align-items-end mb-2">
              <h4 class="card-title mb-0 me-2">{{ $trialTenants }}</h4>
            </div>
            <small class="text-warning">pending conversion</small>
          </div>
          <div class="card-icon">
            <span class="badge bg-label-warning rounded p-2">
              <i class="bx bx-time bx-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Total Users -->
  <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div class="card-info">
            <p class="card-text mb-1">Total Users</p>
            <div class="d-flex align-items-end mb-2">
              <h4 class="card-title mb-0 me-2">{{ $totalUsers }}</h4>
            </div>
            <small>across all tenants</small>
          </div>
          <div class="card-icon">
            <span class="badge bg-label-info rounded p-2">
              <i class="bx bx-group bx-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Monthly Revenue -->
  <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div class="card-info">
            <p class="card-text mb-1">Monthly Revenue</p>
            <div class="d-flex align-items-end mb-2">
              <h4 class="card-title mb-0 me-2">${{ number_format($monthlyRevenue, 2) }}</h4>
            </div>
            <small>Total: ${{ number_format($totalRevenue, 2) }}</small>
          </div>
          <div class="card-icon">
            <span class="badge bg-label-success rounded p-2">
              <i class="bx bx-dollar-circle bx-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Recent Tenants -->
<div class="row">
  <div class="col-md-6 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0 me-2">Recent Tenants</h5>
        <a href="{{ route('superadmin.tenants') }}" class="btn btn-sm btn-primary">View All</a>
      </div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Name</th>
              <th>Owner</th>
              <th>Status</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($recentTenants as $tenant)
            <tr>
              <td><strong>{{ $tenant->name }}</strong><br><small class="text-muted">{{ $tenant->slug }}.whitelabel.heychatmate.com</small></td>
              <td>{{ $tenant->owner->name ?? 'N/A' }}</td>
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
              <td>{{ $tenant->created_at->format('M d, Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center">No tenants yet</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Recent Transactions -->
  <div class="col-md-6 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0 me-2">Recent Transactions</h5>
      </div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Tenant</th>
              <th>Amount</th>
              <th>Type</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($recentTransactions as $trx)
            <tr>
              <td>{{ $trx->tenant->name ?? 'N/A' }}</td>
              <td>
                <span class="{{ $trx->type === '+' ? 'text-success' : 'text-danger' }}">
                  {{ $trx->type }}${{ number_format($trx->amount, 2) }}
                </span>
              </td>
              <td><small>{{ $trx->remark }}</small></td>
              <td>{{ $trx->created_at->format('M d') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center">No transactions yet</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
