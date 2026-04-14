@extends('layouts/contentNavbarLayout')

@section('title', 'Payment Gateway Settings')

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header"><h5 class="mb-0">Payment Gateway</h5></div>
      <div class="card-body">
        <p class="mb-4">Choose how your users will pay for subscriptions. Payments go directly to your account.</p>

        <form action="{{ route('tenant.payment-settings.update') }}" method="POST">
          @csrf

          <!-- Processor Selection -->
          <div class="mb-4">
            <label class="form-label fw-bold">Payment Processor</label>
            <div class="row g-3">
              <div class="col-md-4">
                <div class="form-check card p-3 text-center {{ $tenant->payment_processor === 'stripe' ? 'border-primary' : '' }}">
                  <input class="form-check-input mx-auto" type="radio" name="payment_processor" value="stripe" id="ppStripe" {{ $tenant->payment_processor === 'stripe' ? 'checked' : '' }}>
                  <label class="form-check-label" for="ppStripe">
                    <strong>Stripe</strong><br>
                    <small class="text-muted">Cards, Apple Pay, Google Pay</small>
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check card p-3 text-center {{ $tenant->payment_processor === 'jvzoo' ? 'border-primary' : '' }}">
                  <input class="form-check-input mx-auto" type="radio" name="payment_processor" value="jvzoo" id="ppJvzoo" {{ $tenant->payment_processor === 'jvzoo' ? 'checked' : '' }}>
                  <label class="form-check-label" for="ppJvzoo">
                    <strong>JVZoo</strong><br>
                    <small class="text-muted">Digital products & affiliates</small>
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check card p-3 text-center {{ $tenant->payment_processor === 'whop' ? 'border-primary' : '' }}">
                  <input class="form-check-input mx-auto" type="radio" name="payment_processor" value="whop" id="ppWhop" {{ $tenant->payment_processor === 'whop' ? 'checked' : '' }}>
                  <label class="form-check-label" for="ppWhop">
                    <strong>Whop</strong><br>
                    <small class="text-muted">SaaS & memberships</small>
                  </label>
                </div>
              </div>
            </div>
          </div>

          <!-- Stripe Fields -->
          <div id="stripeFields" style="{{ $tenant->payment_processor === 'stripe' ? '' : 'display:none;' }}">
            <h6 class="mb-3">Stripe Configuration</h6>
            <div class="mb-3">
              <label class="form-label">Publishable Key</label>
              <input type="text" name="stripe_key" class="form-control" placeholder="pk_live_..." value="">
              @if ($tenant->stripe_key) <small class="text-success">Key is saved</small> @endif
            </div>
            <div class="mb-3">
              <label class="form-label">Secret Key</label>
              <input type="password" name="stripe_secret" class="form-control" placeholder="sk_live_...">
              @if ($tenant->stripe_secret) <small class="text-success">Key is saved</small> @endif
            </div>
            <div class="mb-3">
              <label class="form-label">Webhook Secret (optional)</label>
              <input type="password" name="stripe_webhook_secret" class="form-control" placeholder="whsec_...">
            </div>
          </div>

          <!-- JVZoo Fields -->
          <div id="jvzooFields" style="{{ $tenant->payment_processor === 'jvzoo' ? '' : 'display:none;' }}">
            <h6 class="mb-3">JVZoo Configuration</h6>
            <div class="mb-3">
              <label class="form-label">JVZIPN Secret Key</label>
              <input type="password" name="jvzoo_secret_key" class="form-control" placeholder="Your JVZoo IPN secret">
              @if ($tenant->jvzoo_secret_key) <small class="text-success">Key is saved</small> @endif
            </div>
            <div class="mb-3">
              <label class="form-label">API Key (optional)</label>
              <input type="text" name="jvzoo_api_key" class="form-control">
            </div>
            <div class="alert alert-info">
              <i class="bx bx-info-circle me-1"></i>
              Set your JVZoo IPN URL to: <code>{{ url('/webhook/jvzoo/' . $tenant->slug) }}</code>
            </div>
          </div>

          <!-- Whop Fields -->
          <div id="whopFields" style="{{ $tenant->payment_processor === 'whop' ? '' : 'display:none;' }}">
            <h6 class="mb-3">Whop Configuration</h6>
            <div class="mb-3">
              <label class="form-label">API Key</label>
              <input type="password" name="whop_api_key" class="form-control" placeholder="Your Whop API key">
              @if ($tenant->whop_api_key) <small class="text-success">Key is saved</small> @endif
            </div>
            <div class="mb-3">
              <label class="form-label">Company ID</label>
              <input type="text" name="whop_company_id" class="form-control" value="{{ $tenant->whop_company_id }}" placeholder="biz_xxxxx">
            </div>
            <div class="mb-3">
              <label class="form-label">Webhook Secret (optional)</label>
              <input type="password" name="whop_webhook_secret" class="form-control">
            </div>
            <div class="alert alert-info">
              <i class="bx bx-info-circle me-1"></i>
              Set your Whop webhook URL to: <code>{{ url('/webhook/whop/' . $tenant->slug) }}</code>
            </div>
          </div>

          <button type="submit" class="btn btn-primary">Save Payment Settings</button>
        </form>
      </div>
    </div>
  </div>
</div>

@section('page-script')
<script>
document.querySelectorAll('input[name="payment_processor"]').forEach(function(radio) {
  radio.addEventListener('change', function() {
    document.getElementById('stripeFields').style.display = this.value === 'stripe' ? '' : 'none';
    document.getElementById('jvzooFields').style.display = this.value === 'jvzoo' ? '' : 'none';
    document.getElementById('whopFields').style.display = this.value === 'whop' ? '' : 'none';
  });
});
</script>
@endsection

@if (session('success'))
<script>document.addEventListener('DOMContentLoaded',function(){Swal.fire({icon:'success',title:'Success',text:'{{ session("success") }}',timer:3000,showConfirmButton:false});});</script>
@endif
@endsection
