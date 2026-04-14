@extends('layouts/contentNavbarLayout')

@section('title', 'Manage Chat Assistants')

@section('content')
    <style>
        .assistants .card:hover {
            box-shadow: 0px 20px 40px rgba(0, 0, 0, 0.4);
            transform: scale(1.05, 1.05);
            transition: .3s;
        }
    </style>

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Dashboard /</span> Manage Chat Assistants
    </h4>
    <!-- Button trigger modal -->

    <!-- Basic Bootstrap Card -->
    <div class="row assistants">
        @include('content.alerts')
        @foreach ($assistants as $assistant)
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                            <a href="javascript:void(0)" data-url="<a href='{{ route('assistant.delete', $assistant->id) }}' style='color:white;'>Yes, delete it!</a>"  data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" data-bs-html="true" data-bs-original-title="<i class='bx bx-trash bx-xs' ></i> <span>Delete Assistant</span>" class="badge badge-center bg-label-danger float-end delete"><i
                                        class="bx bx-trash me-1"></i></a>

                        @if ($assistant->avatar)
                            <img src="{{ asset('assets/img/avatars/' . $assistant->avatar) }}" class="rounded-circle"
                                alt="Cinque Terre" width="150" height="150">
                        @else
                            <img src="{{ asset('assets/img/avatars/default-assistant.png') }}" class="rounded-circle"
                                alt="Cinque Terre" width="150" height="150">
                        @endif

                        <h5 class="card-title">{{ $assistant->name }}</h5>
                        <a href="{{route('assistant.edit',$assistant->id)}}" class="btn btn-primary">Edit</a>
                        <a href="{{route('train.assistant',$assistant->id)}}" class="btn btn-info">Train</a>
                        <a href="{{route('assistant.config',$assistant->id)}}" data-url="" class="btn btn-info">Configuration</a>
                    </div>

                </div>
            </div>
        @endforeach


        <div class="col-md-6 col-lg-4 mb-3">
            <a href="{{ route('assistant.create') }}" class="card text-center cursor-pointer">
                <div class="card-body" style="opacity: 30%">
                    <img src="{{ asset('assets/img/pages/plusicon.png') }}" class="rounded-circle m-3" alt="Cinque Terre"
                        width="150" height="150">
                    <h5 class="card-title">Create New Assistant</h5>
                </div>

            </a>
        </div>
    </div>

    <!--/ Basic Bootstrap Card -->
    <!-- Modal -->
    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Add Training Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('train-submit') }}" method="post">
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
@section('page-script')
    <script>

        $('.delete').on('click',function () {

          var link = $(this).data('url');

                      Swal.fire({
                      title: "Are you sure?",
                      text: "You won't be able to revert this! All Data Related to this assistant will be removed permanently!",
                      icon: "warning",
                      timer: 3000,
                      showCancelButton: true,
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      confirmButtonText: link
                    })
});

    </script>
@endsection
