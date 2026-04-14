@extends('layouts/contentNavbarLayout')

@section('title', 'Custom Domain')

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="card mb-4">
      <div class="card-header"><h5 class="mb-0">Custom Domain Setup</h5></div>
      <div class="card-body">
        <p class="mb-4">Connect your own domain so your users see your brand, not ours. Your default subdomain <code>{{ $tenant->slug }}.whitelabel.heychatmate.com</code> will always work as a fallback.</p>

        <form action="{{ route('tenant.domain.update') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label">Your Custom Domain</label>
            <input type="text" name="custom_domain" class="form-control" value="{{ $tenant->custom_domain }}" placeholder="app.yourdomain.com">
            <small class="text-muted">Enter the full domain (e.g., chat.yourbusiness.com)</small>
          </div>
          <button type="submit" class="btn btn-primary">Save Domain</button>
        </form>
      </div>
    </div>

    @if ($tenant->custom_domain)
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="mb-0">
          DNS Configuration
          @if ($tenant->domain_verified)
            <span class="badge bg-success ms-2">Verified</span>
          @else
            <span class="badge bg-warning ms-2">Pending Verification</span>
          @endif
        </h5>
      </div>
      <div class="card-body">
        @if (!$tenant->domain_verified)
          <p>Add these DNS records at your domain registrar:</p>

          <div class="table-responsive mb-4">
            <table class="table table-bordered">
              <thead><tr><th>Type</th><th>Name/Host</th><th>Value/Target</th></tr></thead>
              <tbody>
                <tr>
                  <td><span class="badge bg-primary">CNAME</span></td>
                  <td><code>{{ $tenant->custom_domain }}</code></td>
                  <td><code>whitelabel.heychatmate.com</code></td>
                </tr>
                <tr>
                  <td><span class="badge bg-info">TXT</span></td>
                  <td><code>_heychatmate-verify.{{ $tenant->custom_domain }}</code></td>
                  <td><code>{{ $tenant->domain_verification_token }}</code></td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="alert alert-info">
            <i class="bx bx-info-circle me-1"></i>
            DNS changes can take up to 24 hours to propagate. If verification fails, wait a bit and try again.
          </div>

          <form action="{{ route('tenant.domain.verify') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success"><i class="bx bx-check me-1"></i> Verify Domain</button>
          </form>
          <a href="{{ route('tenant.domain.remove') }}" class="btn btn-outline-danger ms-2" onclick="return confirm('Remove this domain?')">Remove Domain</a>
        @else
          <div class="alert alert-success">
            <i class="bx bx-check-circle me-1"></i>
            Your domain <strong>{{ $tenant->custom_domain }}</strong> is verified and active. Your users can access the platform at <strong>https://{{ $tenant->custom_domain }}</strong>
          </div>
          <a href="{{ route('tenant.domain.remove') }}" class="btn btn-outline-danger" onclick="return confirm('This will remove your custom domain. Are you sure?')">Remove Domain</a>
        @endif
      </div>
    </div>
    @endif
  </div>

  <div class="col-md-4">
    <div class="card">
      <div class="card-header"><h5 class="mb-0">How It Works</h5></div>
      <div class="card-body">
        <p><strong>Step 1:</strong> Enter your domain above and save.</p>
        <p><strong>Step 2:</strong> Go to your domain registrar (GoDaddy, Namecheap, Cloudflare, etc.) and add the two DNS records shown.</p>
        <p><strong>Step 3:</strong> Wait for DNS propagation (usually 5-30 minutes, sometimes up to 24 hours).</p>
        <p><strong>Step 4:</strong> Click "Verify Domain" to confirm everything is set up.</p>
        <p class="text-muted small">SSL certificates are automatically provisioned after verification.</p>
      </div>
    </div>
  </div>
</div>

@if (session('success'))
<script>document.addEventListener('DOMContentLoaded',function(){Swal.fire({icon:'success',title:'Success',text:'{{ session("success") }}',timer:3000,showConfirmButton:false});});</script>
@endif
@if (session('error'))
<script>document.addEventListener('DOMContentLoaded',function(){Swal.fire({icon:'error',title:'Verification Failed',text:'{{ session("error") }}'});});</script>
@endif
@endsection
