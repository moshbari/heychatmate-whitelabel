@extends('layouts/contentNavbarLayout')

@section('title', 'API Settings')

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header"><h5 class="mb-0">API Settings</h5></div>
      <div class="card-body">
        <form action="{{ route('tenant.api-settings.update') }}" method="POST">
          @csrf

          <div class="mb-4">
            <label class="form-label fw-bold">API Mode</label>
            <div class="row">
              <div class="col-md-6">
                <div class="form-check card p-3 {{ $tenant->api_mode === 'platform' ? 'border-primary' : '' }}">
                  <input class="form-check-input" type="radio" name="api_mode" value="platform" id="modePlatform" {{ $tenant->api_mode === 'platform' ? 'checked' : '' }}>
                  <label class="form-check-label" for="modePlatform">
                    <strong>Platform Credits</strong><br>
                    <small class="text-muted">Use the platform's OpenAI API key. Credits are deducted per usage. Buy credits from the platform owner.</small>
                  </label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-check card p-3 {{ $tenant->api_mode === 'own' ? 'border-primary' : '' }}">
                  <input class="form-check-input" type="radio" name="api_mode" value="own" id="modeOwn" {{ $tenant->api_mode === 'own' ? 'checked' : '' }}>
                  <label class="form-check-label" for="modeOwn">
                    <strong>Own API Key</strong><br>
                    <small class="text-muted">Use your own OpenAI API key. No credits needed — you pay OpenAI directly.</small>
                  </label>
                </div>
              </div>
            </div>
          </div>

          <div id="ownKeySection" style="{{ $tenant->api_mode === 'own' ? '' : 'display:none;' }}">
            <div class="mb-3">
              <label class="form-label">OpenAI API Key</label>
              <input type="password" name="openai_api_key" class="form-control" placeholder="sk-..." value="">
              <small class="text-muted">
                @if ($tenant->openai_api_key)
                  A key is already saved. Leave blank to keep the current key.
                @else
                  Enter your OpenAI API key from <a href="https://platform.openai.com/api-keys" target="_blank">platform.openai.com</a>
                @endif
              </small>
            </div>
            <div class="mb-3">
              <label class="form-label">AI Model</label>
              <select name="ai_model" class="form-select">
                <option value="gpt-3.5-turbo" {{ $tenant->ai_model === 'gpt-3.5-turbo' ? 'selected' : '' }}>GPT-3.5 Turbo</option>
                <option value="gpt-3.5-turbo-16k" {{ $tenant->ai_model === 'gpt-3.5-turbo-16k' ? 'selected' : '' }}>GPT-3.5 Turbo 16K</option>
                <option value="gpt-4" {{ $tenant->ai_model === 'gpt-4' ? 'selected' : '' }}>GPT-4</option>
                <option value="gpt-4-turbo" {{ $tenant->ai_model === 'gpt-4-turbo' ? 'selected' : '' }}>GPT-4 Turbo</option>
                <option value="gpt-4o" {{ $tenant->ai_model === 'gpt-4o' ? 'selected' : '' }}>GPT-4o</option>
                <option value="gpt-4o-mini" {{ $tenant->ai_model === 'gpt-4o-mini' ? 'selected' : '' }}>GPT-4o Mini</option>
              </select>
            </div>
          </div>

          <div id="platformSection" style="{{ $tenant->api_mode === 'platform' ? '' : 'display:none;' }}">
            <div class="alert alert-info">
              <i class="bx bx-info-circle me-1"></i>
              Your current credit balance: <strong>{{ number_format($tenant->credit_balance) }}</strong> credits.
              Credits are deducted based on token usage when your users send messages.
            </div>
          </div>

          <button type="submit" class="btn btn-primary">Save API Settings</button>
        </form>
      </div>
    </div>
  </div>
</div>

@section('page-script')
<script>
document.querySelectorAll('input[name="api_mode"]').forEach(function(radio) {
  radio.addEventListener('change', function() {
    document.getElementById('ownKeySection').style.display = this.value === 'own' ? '' : 'none';
    document.getElementById('platformSection').style.display = this.value === 'platform' ? '' : 'none';
  });
});
</script>
@endsection

@if (session('success'))
<script>document.addEventListener('DOMContentLoaded',function(){Swal.fire({icon:'success',title:'Success',text:'{{ session("success") }}',timer:3000,showConfirmButton:false});});</script>
@endif
@endsection
