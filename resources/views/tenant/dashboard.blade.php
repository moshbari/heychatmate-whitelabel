@extends('layouts/contentNavbarLayout')

@section('title', 'Workspace Dashboard')

@section('content')
<div class="row">
  <div class="col-12 mb-4">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-primary">Welcome to {{ $tenant->app_name }}!</h5>
            <p class="mb-4">Your workspace is <strong class="text-success">{{ $tenant->status }}</strong>.
              @if ($tenant->api_mode === 'own')
                You're using your own OpenAI API key.
              @else
                You have <strong>{{ number_format($creditBalance) }}</strong> credits remaining.
              @endif
            </p>
            <a href="{{ route('tenant.users') }}" class="btn btn-sm btn-outline-primary">Manage Users</a>
            <a href="{{ route('tenant.branding.index') }}" class="btn btn-sm btn-outline-primary">Customize Branding</a>
          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-4">
            <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}" height="140" alt="Welcome">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Users -->
  <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div class="card-info">
            <p class="card-text mb-1">Users</p>
            <div class="d-flex align-items-end mb-2">
              <h4 class="card-title mb-0 me-2">{{ $totalUsers }} / {{ $maxUsers }}</h4>
            </div>
            <small><a href="{{ route('tenant.users') }}">Manage Users</a></small>
          </div>
          <div class="card-icon">
            <span class="badge bg-label-primary rounded p-2">
              <i class="bx bx-group bx-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Chatbots -->
  <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div class="card-info">
            <p class="card-text mb-1">Total Chatbots</p>
            <div class="d-flex align-items-end mb-2">
              <h4 class="card-title mb-0 me-2">{{ $totalBots }}</h4>
            </div>
            <small>across all users</small>
          </div>
          <div class="card-icon">
            <span class="badge bg-label-info rounded p-2">
              <i class="bx bx-bot bx-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Today's Chats -->
  <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div class="card-info">
            <p class="card-text mb-1">Today's Chats</p>
            <div class="d-flex align-items-end mb-2">
              <h4 class="card-title mb-0 me-2">{{ $todayChats }}</h4>
            </div>
            <small>Total: {{ number_format($totalChats) }}</small>
          </div>
          <div class="card-icon">
            <span class="badge bg-label-warning rounded p-2">
              <i class="bx bx-message-rounded bx-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Credits -->
  <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div class="card-info">
            <p class="card-text mb-1">
              @if ($apiMode === 'own')
                API Mode
              @else
                Credit Balance
              @endif
            </p>
            <div class="d-flex align-items-end mb-2">
              <h4 class="card-title mb-0 me-2">
                @if ($apiMode === 'own')
                  Own Key
                @else
                  {{ number_format($creditBalance) }}
                @endif
              </h4>
            </div>
            <small><a href="{{ route('tenant.api-settings') }}">API Settings</a></small>
          </div>
          <div class="card-icon">
            <span class="badge bg-label-success rounded p-2">
              <i class="bx bx-key bx-sm"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Recent Users -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title m-0">Recent Users</h5>
        <a href="{{ route('tenant.users') }}" class="btn btn-sm btn-primary">View All</a>
      </div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr><th>Name</th><th>Email</th><th>Credits</th><th>Status</th><th>Joined</th></tr>
          </thead>
          <tbody>
            @forelse ($recentUsers as $user)
            <tr>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ number_format($user->credit_balance) }}</td>
              <td>{!! $user->status ? '<span class="badge bg-label-success">Active</span>' : '<span class="badge bg-label-danger">Inactive</span>' !!}</td>
              <td>{{ $user->created_at->format('M d, Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center">No users yet. <a href="{{ route('tenant.users') }}">Add your first user</a></td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
