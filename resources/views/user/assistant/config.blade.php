@extends('layouts/contentNavbarLayout')

@section('title', 'Chat Widgets')

@section('page-script')
<script src="{{ asset('assets/js/form-basic-inputs.js') }}"></script>

<script>
  function copyToClip(id, btn) {
            // Get the text field
            var copyText = document.getElementById(id);

            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the text field
            navigator.clipboard.writeText(copyText.value);
            $(btn).attr('data-bs-original-title', '<i class="bx bx-check-circle bx-xs"></i><span> Copied!</span>')
                .tooltip('show');

        }
</script>

@endsection

@section('content')

<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Assistant /</span> {{ $assistant->name }} / Configutation Codes
  <a href="{{ route('manage.assistant') }}" class="btn btn-primary"><i class='bx bx-arrow-back bx-sm'></i></a>
</h4>

<div class="row">
  {{-- <div class="col-md-6">
    @include('content.alerts')
    <div class="card mb-4">
      <h5 class="card-header">Chat Configurations</h5>
      <div class="card-body">

        <form action="{{ route('assistant.domain', $assistant->id) }}" method="post">
          @csrf
          <div class="mb-3">
            <label for="exampleFormC22" class="form-label">Allowed Domain</label>

            <textarea class="form-control" id="exampleForm22" name="allowed_domain"
              rows="5">{{ $assistant->allowed_domain }}</textarea>
          </div>

          <div class="mt-4">
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div> --}}

  <div class="col-md-6">
    <div class="card mb-4">
      <h5 class="card-header">Chat Widget Code</h5>
      <div class="card-body">
        <div class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label">Widget Code:</label>
          <button type="button" class="btn btn-dark mb-1 float-end"
            onclick="copyToClip('exampleFormControlTextarea1',this)" data-bs-toggle="tooltip" data-bs-offset="0,4"
            data-bs-placement="top" data-bs-html="true"
            data-bs-original-title="<i class='bx bx-copy bx-xs' ></i> <span>Copy Code</span>"><i
              class="bx bx-copy"></i></button>
          <small class="newline">Copy and paste this code to footer of
            the page</small>

          <textarea class="form-control" id="exampleFormControlTextarea1" rows="8" disabled readonly>
            <!--Heychatmate.com Widget Code starts-->
              <script src="{{ route('chat.widget.code', $assistant->slug) }}"></script>
            <!--Heychatmate.com Widget Code ends-->
          </textarea>
        </div>
        <div class="mb-3">
          <label for="pluginURL" class="form-label">Direct Chat Link:</label>
          <button type="button" class="btn btn-dark mb-1 float-end" onclick="copyToClip('pluginURL',this)"
            data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true"
            data-bs-original-title="<i class='bx bx-copy bx-xs' ></i> <span>Copy Code</span>"><i
              class="bx bx-copy"></i></button>
          <small class="newline">Copy and paste this URL to visit the
            chat Page Directly</small>
          <input type="text" class="form-control" id="pluginURL" value="{{ route('chat.embed', $assistant->slug) }}"
            readonly disabled>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
