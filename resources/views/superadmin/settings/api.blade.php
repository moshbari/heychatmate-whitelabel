@extends('layouts/contentNavbarLayout')

@section('title', 'API & Credit Settings')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-0">API & Credit Settings</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('superadmin.settings.api.update') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-12 mb-3">
              <label class="form-label">OpenAI API Key</label>
              <input type="password" name="openai_api_key" class="form-control" placeholder="sk-... (leave blank to keep current)">
              <small class="text-muted">This key is encrypted at rest. Leave blank to keep the current key.</small>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Default AI Model</label>
              <select name="default_ai_model" class="form-select">
                <option value="gpt-4o-mini" {{ ($settings['default_ai_model'] ?? '') === 'gpt-4o-mini' ? 'selected' : '' }}>GPT-4o Mini</option>
                <option value="gpt-4o" {{ ($settings['default_ai_model'] ?? '') === 'gpt-4o' ? 'selected' : '' }}>GPT-4o</option>
                <option value="gpt-4" {{ ($settings['default_ai_model'] ?? '') === 'gpt-4' ? 'selected' : '' }}>GPT-4</option>
                <option value="gpt-3.5-turbo" {{ ($settings['default_ai_model'] ?? '') === 'gpt-3.5-turbo' ? 'selected' : '' }}>GPT-3.5 Turbo</option>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Token Rate (cost per 1K tokens)</label>
              <input type="number" name="token_rate" class="form-control" step="0.0001" value="{{ $settings['token_rate'] ?? '0.002' }}">
            </div>
            <div class="col-md-4 mb-3">
              <label class="form-label">Credits per Dollar</label>
              <input type="number" name="credits_per_dollar" class="form-control" step="1" value="{{ $settings['credits_per_dollar'] ?? '100' }}">
              <small class="text-muted">How many credits a tenant gets per $1 spent.</small>
            </div>
          </div>

          <div class="mt-3">
            <button type="submit" class="btn btn-primary">Save API Settings</button>
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
