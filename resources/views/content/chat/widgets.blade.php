@extends('layouts/contentNavbarLayout')

@section('title', 'Chat Widgets')

@section('page-script')
<script src="{{asset('assets/js/form-basic-inputs.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Chat /</span> Widgets
</h4>

<div class="row">
  <div class="col-md-6">
    <div class="card mb-4">
      <h5 class="card-header">Chat Embed Code</h5>
      <div class="card-body">
        <div>
          <label for="exampleFormControlTextarea1" class="form-label">Copy and paste this code to footer of the page</label>
          <textarea class="form-control" id="exampleFormControlTextarea1" rows="17" disabled>

              <!--Embed Code starts-->
              <script type="text/javascript">
                window.mychat = window.mychat || {};
                          window.mychat.iframeWidth = '700px';
                          window.mychat.iframeHeight = '700px';
                          (function () {
                            var mychat = document.createElement('script'); mychat.type = 'text/javascript'; mychat.async = true;
                            mychat.src = '{{url('/')}}/embeds/widget.js';
                            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(mychat, s);
                          })();
              </script>
              <!--Embed Code ends-->
          </textarea>
        </div>
      </div>
    </div>
  </div>

  </div>
@endsection
