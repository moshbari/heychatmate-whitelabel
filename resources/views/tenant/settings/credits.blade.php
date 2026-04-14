@extends('layouts/contentNavbarLayout')

@section('title', 'Credits')

@section('content')
<div class="row">
  <div class="col-md-4 mb-4">
    <div class="card">
      <div class="card-body text-center">
        <h6>Credit Balance</h6>
        <h2 class="text-primary mb-3">{{ number_format($tenant->credit_balance) }}</h2>
        <p class="text-muted small">
          @if ($tenant->api_mode === 'own')
            You're using your own API key. Credits are not required.
          @else
            Credits are deducted when your users send messages.
          @endif
        </p>
      </div>
    </div>
  </div>

  <div class="col-md-8 mb-4">
    <div class="card">
      <div class="card-header"><h5 class="mb-0">Distribute Credits to User</h5></div>
      <div class="card-body">
        <form action="{{ route('tenant.credits.distribute') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Select User</label>
              <select name="user_id" class="form-select" required>
                <option value="">Choose a user...</option>
                @foreach (\App\Models\User::where('tenant_id', $tenant->id)->where('role', 'user')->get() as $user)
                  <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }}) — {{ number_format($user->credit_balance) }} credits</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Amount</label>
              <input type="number" name="amount" class="form-control" min="1" required>
            </div>
            <div class="col-md-2 mb-3">
              <label class="form-label">&nbsp;</label>
              <button type="submit" class="btn btn-primary d-block w-100">Send</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Transaction History -->
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header"><h5 class="mb-0">Transaction History</h5></div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead><tr><th>ID</th><th>Amount</th><th>Credits</th><th>Type</th><th>Details</th><th>Date</th></tr></thead>
          <tbody>
            @forelse ($transactions as $trx)
            <tr>
              <td><small>{{ $trx->trx_id }}</small></td>
              <td><span class="{{ $trx->type === '+' ? 'text-success' : 'text-danger' }}">${{ number_format($trx->amount, 2) }}</span></td>
              <td>{{ number_format($trx->credits) }}</td>
              <td>{{ $trx->remark }}</td>
              <td><small>{{ $trx->details }}</small></td>
              <td>{{ $trx->created_at->format('M d, Y H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center">No transactions yet</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if ($transactions->hasPages())
      <div class="card-footer">{{ $transactions->links() }}</div>
      @endif
    </div>
  </div>
</div>

@if (session('success'))
<script>document.addEventListener('DOMContentLoaded',function(){Swal.fire({icon:'success',title:'Success',text:'{{ session("success") }}',timer:3000,showConfirmButton:false});});</script>
@endif
@if (session('error'))
<script>document.addEventListener('DOMContentLoaded',function(){Swal.fire({icon:'error',title:'Error',text:'{{ session("error") }}'});});</script>
@endif
@endsection
