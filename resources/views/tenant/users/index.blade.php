@extends('layouts/contentNavbarLayout')

@section('title', 'Manage Users')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Manage Users <small class="text-muted">({{ $userCount }} / {{ $tenant->max_users }})</small></h5>
        <div>
          @if ($canAddUser)
            <button type="button" class="btn btn-outline-info me-2" data-bs-toggle="modal" data-bs-target="#inviteModal">
              <i class="bx bx-envelope me-1"></i> Invite
            </button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
              <i class="bx bx-plus me-1"></i> Add User
            </button>
          @else
            <span class="badge bg-label-warning">User limit reached</span>
          @endif
        </div>
      </div>

      <!-- Search -->
      <div class="card-body pb-0">
        <form method="GET" class="row g-3 mb-3">
          <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}">
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-outline-primary">Search</button>
          </div>
        </form>
      </div>

      <div class="table-responsive text-nowrap">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Credits</th>
              <th>Plan</th>
              <th>Status</th>
              <th>Joined</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($users as $user)
            <tr>
              <td><strong>{{ $user->name }}</strong></td>
              <td>{{ $user->email }}</td>
              <td>{{ number_format($user->credit_balance) }}</td>
              <td>{{ $user->subscription && $user->subscription->plan ? $user->subscription->plan->name : 'None' }}</td>
              <td>{!! $user->status ? '<span class="badge bg-label-success">Active</span>' : '<span class="badge bg-label-danger">Inactive</span>' !!}</td>
              <td>{{ $user->created_at->format('M d, Y') }}</td>
              <td>
                <a href="{{ route('tenant.users.show', $user->id) }}" class="btn btn-sm btn-outline-primary"><i class="bx bx-show"></i></a>
                <a href="{{ route('tenant.users.destroy', $user->id) }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this user?')"><i class="bx bx-trash"></i></a>
              </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center py-4">No users yet. Add your first user above.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if ($users->hasPages())
      <div class="card-footer">{{ $users->links() }}</div>
      @endif
    </div>
  </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('tenant.users.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Add New User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="text" name="password" class="form-control" value="{{ \Illuminate\Support\Str::random(10) }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Initial Credits</label>
            <input type="number" name="initial_credits" class="form-control" value="0" min="0">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Create User</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Invite Modal -->
<div class="modal fade" id="inviteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('tenant.users.invite') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Invite User by Email</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <p class="text-muted small">An invitation email will be sent with temporary login credentials.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info">Send Invitation</button>
        </div>
      </form>
    </div>
  </div>
</div>

@if (session('success'))
<script>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({ icon: 'success', title: 'Success', text: '{{ session("success") }}', timer: 4000, showConfirmButton: false });
  });
</script>
@endif
@if (session('error'))
<script>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({ icon: 'error', title: 'Error', text: '{{ session("error") }}' });
  });
</script>
@endif
@endsection
