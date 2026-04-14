@extends('layouts/contentNavbarLayout')

@section('title', 'Analytics')

@section('content')
<div class="row">
  <div class="col-md-3 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-muted mb-1">Total Users</h6>
            <h3 class="mb-0">{{ $totalUsers }}</h3>
          </div>
          <div class="avatar bg-label-primary rounded p-2">
            <i class="bx bx-user fs-4"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-muted mb-1">Total Chatbots</h6>
            <h3 class="mb-0">{{ $totalBots }}</h3>
          </div>
          <div class="avatar bg-label-info rounded p-2">
            <i class="bx bx-bot fs-4"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-muted mb-1">Chats Today</h6>
            <h3 class="mb-0">{{ $todayChats }}</h3>
          </div>
          <div class="avatar bg-label-success rounded p-2">
            <i class="bx bx-chat fs-4"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-3 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h6 class="text-muted mb-1">Chats This Month</h6>
            <h3 class="mb-0">{{ $monthlyChats }}</h3>
          </div>
          <div class="avatar bg-label-warning rounded p-2">
            <i class="bx bx-calendar fs-4"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6 mb-4">
    <div class="card">
      <div class="card-header"><h5 class="mb-0">Usage Overview</h5></div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <tbody>
              <tr><td>Total Conversations</td><td class="text-end fw-bold">{{ number_format($totalChats) }}</td></tr>
              <tr><td>Active Chatbots</td><td class="text-end fw-bold">{{ $totalBots }}</td></tr>
              <tr><td>Registered Users</td><td class="text-end fw-bold">{{ $totalUsers }}</td></tr>
              <tr><td>Credits Remaining</td><td class="text-end fw-bold">{{ number_format($creditBalance) }}</td></tr>
              <tr><td>Total Credits Used</td><td class="text-end fw-bold">{{ number_format($totalCreditsUsed) }}</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 mb-4">
    <div class="card">
      <div class="card-header"><h5 class="mb-0">Workspace Info</h5></div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <tbody>
              <tr><td>Workspace Name</td><td class="text-end fw-bold">{{ $tenant->app_name }}</td></tr>
              <tr><td>Status</td><td class="text-end"><span class="badge bg-{{ $tenant->status === 'active' ? 'success' : 'warning' }}">{{ ucfirst($tenant->status) }}</span></td></tr>
              <tr><td>API Mode</td><td class="text-end fw-bold">{{ $tenant->api_mode === 'own' ? 'Own API Key' : 'Platform Credits' }}</td></tr>
              <tr><td>Subdomain</td><td class="text-end"><code>{{ $tenant->slug }}.whitelabel.heychatmate.com</code></td></tr>
              @if ($tenant->custom_domain && $tenant->domain_verified)
              <tr><td>Custom Domain</td><td class="text-end"><code>{{ $tenant->custom_domain }}</code></td></tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
