@extends('layouts/contentNavbarLayout')

@section('title', 'Training Data')

@section('content')
<h4 class="fw-bold py-3 mb-4 justify-content-center">
    <span class="text-muted fw-light">Assistant /</span> Train Assistant
    <a href="{{ route('manage.assistant') }}" class="btn btn-primary"><i class='bx bx-arrow-back bx-sm'></i></a>

    <button type="button" class="btn btn-primary float-end d-none d-lg-block" data-bs-toggle="modal" data-bs-target="#basicModal">
        Add Training Contents
    </button>

</h4>
<div class="text-center mb-3">
    <button type="button" class="btn btn-primary d-lg-none" data-bs-toggle="modal" data-bs-target="#basicModal">
        Add Training Contents
    </button>
</div>
<!-- Button trigger modal -->

<div class="row">
    @include('content.alerts')
</div>

<!-- Basic Bootstrap Table -->
<div class="card">
    <h5 class="card-header">Assistant Name: <strong class="primary">{{ $assistant->name }}</strong> <a
            class="btn btn-primary btn-sm" href="{{ route('manage.assistant') }}">Change</a></h5>




    <div class="table">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 85%">Training Content</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($trainDatas as $trainData)
                <tr>
                    <td style="white-space: pre-wrap">{{ $trainData->content }}</td>
                    <td>
                        <a class="btn btn-primary edit" href="javascript:javascript:void(0)" data-contents="{{ $trainData->content }}" data-id="{{ $trainData->id }}"><i class="bx bx-edit me-1"></i></a>
                        <a class="btn btn-danger delete" href="javascript:javascript:void(0)" data-url="<a href='{{ route('train.delete', $trainData->id) }}' style='color:white;'>Yes, delete it!</a>"><i
                                class="bx bx-trash me-1"></i></a>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2">No Training data added for this assistant!</td>
                </tr>
                @endforelse


            </tbody>
        </table>
    </div>
</div>
<!--/ Basic Bootstrap Table -->
<!-- Modal -->
<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Add Training Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('train.submit', $assistant->id) }}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Add Contents</label>
                            <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="8">{{old('content')}}</textarea>
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


<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Edit Training Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('train.update', $assistant->id) }}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Add Contents</label>
                            <textarea class="form-control" name="content" id="exampleFormControlTextarea1" rows="8"></textarea>
                        </div>

                    </div>
                    <input type="hidden" name="train_id">
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
    $('.edit').on('click', function() {

        $('#editModal').find('textarea[name=content]').val($(this).data('contents'))
        $('#editModal').find('input[name=train_id]').val($(this).data('id'))
        $('#editModal').modal('show')
    })
    $('.delete').on('click', function() {

        var link = $(this).data('url');

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: link
        })
    });
</script>
<!--Embed Code starts-->
<script type="text/javascript">
    window.c1 = window.c1 || {};
    window.c1.iframeWidth = '500px';
    window.c1.iframeHeight = '150px';
    (function() {
        var c1 = document.createElement('script');
        c1.type = 'text/javascript';
        c1.async = true;
        c1.src = 'https://localhost/chatbot/public/embed/abd6629e3b0813e981b5f4bce9fd38a51caa2166';
        c1.charset = 'UTF-8';
        c1.setAttribute('crossorigin', '*');
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(c1, s);
    })();
</script>
<!--Embed Code ends-->



@endsection