@extends('layouts/contentNavbarLayout')

@section('title', 'Branding Settings')

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="card mb-4">
      <div class="card-header"><h5 class="mb-0">Branding Settings</h5></div>
      <div class="card-body">
        <form action="{{ route('tenant.branding.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label class="form-label">App Name</label>
            <input type="text" name="app_name" class="form-control" value="{{ $tenant->app_name }}" required>
            <small class="text-muted">This name will appear in the navbar, page titles, and emails.</small>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Primary Color</label>
              <div class="input-group">
                <input type="color" name="primary_color" class="form-control form-control-color" value="{{ $tenant->primary_color ?? '#696cff' }}" style="width:50px;">
                <input type="text" class="form-control" value="{{ $tenant->primary_color ?? '#696cff' }}" id="primaryColorText" readonly>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Secondary Color</label>
              <div class="input-group">
                <input type="color" name="secondary_color" class="form-control form-control-color" value="{{ $tenant->secondary_color ?? '#8592a3' }}" style="width:50px;">
                <input type="text" class="form-control" value="{{ $tenant->secondary_color ?? '#8592a3' }}" id="secondaryColorText" readonly>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Logo</label>
              @if ($tenant->logo)
                <div class="mb-2">
                  <img src="{{ tenant_asset('logo') }}" alt="Logo" style="max-height:50px;">
                </div>
              @endif
              <input type="file" name="logo" class="form-control" accept="image/png,image/jpeg,image/svg+xml">
              <small class="text-muted">PNG, JPG, or SVG. Max 2MB.</small>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Favicon</label>
              @if ($tenant->favicon)
                <div class="mb-2">
                  <img src="{{ tenant_asset('favicon') }}" alt="Favicon" style="max-height:32px;">
                </div>
              @endif
              <input type="file" name="favicon" class="form-control" accept="image/png,image/jpeg,image/x-icon">
              <small class="text-muted">PNG, JPG, or ICO. Max 1MB.</small>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Footer Text</label>
            <textarea name="footer_text" class="form-control" rows="2">{{ $tenant->footer_text }}</textarea>
          </div>

          <button type="submit" class="btn btn-primary">Save Branding</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Preview -->
  <div class="col-md-4">
    <div class="card">
      <div class="card-header"><h5 class="mb-0">Preview</h5></div>
      <div class="card-body">
        <div class="p-3 rounded mb-3" style="background: {{ $tenant->primary_color ?? '#696cff' }}; color: #fff;">
          <strong>{{ $tenant->app_name }}</strong>
        </div>
        <p class="text-muted small">Your subdomain:</p>
        <p><code>{{ $tenant->slug }}.whitelabel.heychatmate.com</code></p>
        @if ($tenant->custom_domain && $tenant->domain_verified)
          <p class="text-muted small">Custom domain:</p>
          <p><code>{{ $tenant->custom_domain }}</code> <span class="badge bg-success">Verified</span></p>
        @endif
      </div>
    </div>
  </div>
</div>

@if (session('success'))
<script>document.addEventListener('DOMContentLoaded',function(){Swal.fire({icon:'success',title:'Success',text:'{{ session("success") }}',timer:3000,showConfirmButton:false});});</script>
@endif
@endsection
