@extends('layouts/contentNavbarLayout')

@section('title', 'User: ' . $user->name)

@section('content')
<div class="row">
  <div class="col-md-8 mb-4">
    <div class="card">
      <div class="card-header"><h5 class="mb-0">Edit User</h5></div>
      <div class="card-body">
        <form action="{{ route('tenant.users.update', $user->id) }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Full Name</label>
              <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Status</label>
              <select name="status" class="form-select">
                <option value="1" {{ $user->status ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$user->status ? 'selected' : '' }}>Inactive</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Credit Balance</label>
              <input type="number" name="credit_balance" class="form-control" value="{{ $user->credit_balance }}" step="0.01" min="0">
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Update User</button>
        </form>
      </div>
    </div>

    <!-- Change Password -->
    <div class="card mt-4">
      <div class="card-header"><h5 class="mb-0">Change Password</h5></div>
      <div class="card-body">
        <form action="{{ route('tenant.users.password', $user->id) }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">New Password</label>
              <input type="password" name="password" class="form-control" required minlength="6">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Confirm Password</label>
              <input type="password" name="password_confirmation" class="form-control" required>
            </div>
          </div>
          <button type="submit" class="btn btn-warning">Change Password</button>
        </form>
      </div>
    </div>
  </div>

  <!-- User Info Sidebar -->
  <div class="col-md-4 mb-4">
    <div class="card mb-4">
      <div class="card-body text-center">
        <div class="mx-auto mb-3" style="width:80px;height:80px;background:#696cff;border-radius:50%;display:flex;align-items:center;justify-content:center;">
          <span style="font-size:2rem;color:#fff;">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
        </div>
        <h5>{{ $user->name }}</h5>
        <p class="text-muted">{{ $user->email }}</p>
        <span class="badge {{ $user->status ? 'bg-label-success' : 'bg-label-danger' }}">{{ $user->status ? 'Active' : 'Inactive' }}</span>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <h6>Credit Balance</h6>
        <p class="mb-3"><strong>{{ number_format($user->credit_balance) }}</strong> credits</p>
        <h6>Chatbots</h6>
        <p class="mb-3">{{ $user->assistant->count() }} / {{ $tenant->max_bots_per_user }}</p>
        <h6>Subscription</h6>
        <p class="mb-3">{{ $user->subscription && $user->subscription->plan ? $user->subscription->plan->name : 'None' }}</p>
        <h6>Joined</h6>
        <p>{{ $user->created_at->format('M d, Y') }}</p>
      </div>
    </div>
  </div>
</div>

<!-- Credit History -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header"><h5 class="mb-0">Recent Credit History</h5></div>
      <div class="table-responsive">
        <table class="table">
          <thead><tr><th>ID</th><th>Amount</th><th>Type</th><th>Details</th><th>Date</th></tr></thead>
          <tbody>
            @forelse ($user->transactions as $trx)
            <tr>
              <td><small>{{ $trx->trx_id }}</small></td>
              <td><span class="{{ $trx->type === '+' ? 'text-success' : 'text-danger' }}">{{ $trx->type }}{{ $trx->amount }}</span></td>
              <td>{{ $trx->remark }}</td>
              <td><small>{{ $trx->details }}</small></td>
              <td>{{ $trx->created_at->format('M d, Y H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center">No transactions</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@if (session('success'))
<script>document.addEventListener('DOMContentLoaded',function(){Swal.fire({icon:'success',title:'Success',text:'{{ session("success") }}',timer:3000,showConfirmButton:false});});</script>
@endif
@endsection
