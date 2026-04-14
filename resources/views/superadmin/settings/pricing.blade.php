@extends('layouts/contentNavbarLayout')

@section('title', 'Minimum Pricing Rules')

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">Minimum Pricing Rules</h5>
        <small class="text-muted">Set the minimum prices tenants can charge their users. This prevents a race to the bottom.</small>
      </div>
      <div class="card-body">
        <form action="{{ route('superadmin.settings.pricing.update') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label">Min Monthly Plan Price ($)</label>
              <input type="number" name="min_plan_price_monthly" class="form-control" step="0.01" min="0" value="{{ $settings['min_plan_price_monthly'] ?? '0' }}">
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Min Yearly Plan Price ($)</label>
              <input type="number" name="min_plan_price_yearly" class="form-control" step="0.01" min="0" value="{{ $settings['min_plan_price_yearly'] ?? '0' }}">
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Min Credit Price ($)</label>
              <input type="number" name="min_credit_price" class="form-control" step="0.01" min="0" value="{{ $settings['min_credit_price'] ?? '0' }}">
            </div>
          </div>

          <div class="mt-3">
            <button type="submit" class="btn btn-primary">Save Pricing Rules</button>
          </div>
        </form>
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
