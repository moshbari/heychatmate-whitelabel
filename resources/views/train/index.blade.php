@extends('layouts/contentNavbarLayout')

@section('title', 'Training Data')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">AI /</span> Training Center

  <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#basicModal">
    Add Training Data
  </button>

  <button type="button" class="btn btn-primary">
    Start Training
  </button>
</h4>
<!-- Button trigger modal -->

<!-- Basic Bootstrap Table -->
<div class="card">
  <h5 class="card-header">Training Datas</h5>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Prompt</th>
          <th>Completion</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach ($trainDatas as $trainData)
          <tr>
            <td>{{$trainData->prompt}}</td>
            <td>{{$trainData->completation}}</td>
            <td><span class="badge bg-label-primary me-1">{{$trainData->status == 1?"Not Trained":"Trained"}}</span></td>
            <td>
              <a class="dropdown-item" href="{{route('train-delete',$trainData->id)}}"><i class="bx bx-trash me-1"></i> Delete</a>

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
                  <form action="{{route('train-submit')}}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                      <div class="col-12 mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Prompt</label>
                        <textarea class="form-control" name="prompt" id="exampleFormControlTextarea1" rows="3"></textarea>
                      </div>
                      <div class="col-12 mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Completion</label>
                        <textarea class="form-control" name="comp" id="exampleFormControlTextarea1" rows="3"></textarea>
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

