@extends('layouts/contentNavbarLayout')

@section('title', 'Training Data')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">AI /</span> Specify Purpose and Data

  <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#basicModal">
    Add Secific Contens
  </button>

</h4>
<!-- Button trigger modal -->

<!-- Basic Bootstrap Table -->
<div class="card">
  <h5 class="card-header">Instruction Datas</h5>
  <div class="table">
    <table class="table">
      <thead>
        <tr>
          <th>Instruction Content</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach ($trainDatas as $trainData)
          <tr>
            <td>{{$trainData->content}}</td>
            <td>
              <a class="dropdown-item" href="{{route('instruct-delete',$trainData->id)}}"><i class="bx bx-trash me-1"></i> Delete</a>

            </td>
          </tr>
        @endforeach


      </tbody>
    </table>
  </div>
</div>
<!--/ Basic Bootstrap Table -->
<!-- Modal -->
          <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel1">Add Training Data</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="{{route('instruct-submit')}}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                      <div class="col-12 mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Add Contents</label>
                        <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="3"></textarea>
                      </div>

                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>

                  </form>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>

                </div>
              </div>
            </div>
          </div>
@endsection
@section('page-script')
<!--Embed Code starts-->
<script type="text/javascript">
  window.mychat = window.mychat || {};
                                              window.mychat.iframeWidth = '700px';
                                              window.mychat.iframeHeight = '700px';
                                              (function () {
                                                var mychat = document.createElement('script'); mychat.type = 'text/javascript'; mychat.async = true;
                                                mychat.src = 'http://localhost/moshfinal/public/embeds/widget.js';
                                                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(mychat, s);
                                              })();
</script>
<!--Embed Code ends-->
@endsection
