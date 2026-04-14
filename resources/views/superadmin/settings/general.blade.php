@extends('layouts/contentNavbarLayout')

@section('title', 'General Settings')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">General Platform Settings</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('superadmin.settings.general.update') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Platform Name</label>
              <input type="text" name="app_name" class="form-control" value="{{ $settings['app_name'] ?? '' }}">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Contact Email</label>
              <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? '' }}">
            </div>
          </div>

          <hr class="my-4">
          <h6 class="mb-3">Email Configuration</h6>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Global Email Address</label>
              <input type="email" name="global_email" class="form-control" value="{{ $settings['global_email'] ?? '' }}">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Email From Address</label>
              <input type="email" name="email_from" class="form-control" value="{{ $settings['email_from'] ?? '' }}">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Email From Name</label>
              <input type="text" name="name_from" class="form-control" value="{{ $settings['name_from'] ?? '' }}">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Email Type</label>
              <select name="email_type" class="form-select">
                <option value="smtp" {{ ($settings['email_type'] ?? '') === 'smtp' ? 'selected' : '' }}>SMTP</option>
                <option value="sendmail" {{ ($settings['email_type'] ?? '') === 'sendmail' ? 'selected' : '' }}>Sendmail</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">SMTP Host</label>
              <input type="text" name="smtp_host" class="form-control" value="{{ $settings['smtp_host'] ?? '' }}">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">SMTP User</label>
              <input type="text" name="smtp_user" class="form-control" value="{{ $settings['smtp_user'] ?? '' }}">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">SMTP Password</label>
              <input type="password" name="smtp_pass" class="form-control" value="{{ $settings['smtp_pass'] ?? '' }}">
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label">SMTP Port</label>
              <input type="number" name="smtp_port" class="form-control" value="{{ $settings['smtp_port'] ?? '587' }}">
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label">Encryption</label>
              <select name="smtp_encryption" class="form-select">
                <option value="tls" {{ ($settings['smtp_encryption'] ?? '') === 'tls' ? 'selected' : '' }}>TLS</option>
                <option value="ssl" {{ ($settings['smtp_encryption'] ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option>
                <option value="" {{ empty($settings['smtp_encryption'] ?? '') ? 'selected' : '' }}>None</option>
              </select>
            </div>
          </div>

          <div class="mt-3">
            <button type="submit" class="btn btn-primary">Save Settings</button>
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
