@extends('layouts/contentNavbarLayout')

@section('title', 'Manage Pages')

@section('content')

<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Admin /</span> Manage Pages

    <a class="btn btn-primary float-end" href="{{ route('pages.create') }}">Add New Page</a>

</h4>
<!-- Button trigger modal -->

<!-- Basic Bootstrap Table -->
<div class="card">
    <h5 class="card-header">Page List

        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#basicModal">
            Change Menu Order
        </button>
    </h5>

    @include('content.alerts')

    <div class="table table-responsive">

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Footer</th>
                    <th>Header</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @csrf
                @foreach ($pages as $page)
                <tr>
                    <td>{{ $page->name }}</td>
                    <td>/{{ $page->slug }}</td>
                    <td>{!! $page->footer_link == 1
                        ? '<span class="badge bg-success">Shown</span>'
                        : '<span class="badge bg-danger">Hidden</span>' !!}
                    </td>
                    <td>{!! $page->header_link == 1
                        ? '<span class="badge bg-success">Shown</span>'
                        : '<span class="badge bg-danger">Hidden</span>' !!}
                    </td>
                    <td>
                        <a class="btn btn-primary btn-sm edit" href="{{ route('pages.edit', $page->id) }}"><i class="bx bx-edit me-1"></i></a>
                        @if ($page->type != 'default')
                        <a class="btn btn-danger btn-sm delete" href="javascript:void(0)" data-url="<a href='{{ route('pages.delete', $page->id) }}' style='color:white;'>Yes, delete it!</a>"><i class="bx bx-trash me-1"></i></a>
                        @endif
                        <a class="btn btn-primary btn-sm" href="{{ route('front.page', $page->slug) }}" target="_blank"><i class='bx bx-link-external'></i></i></a>

                    </td>
                </tr>
                @endforeach




            </tbody>
        </table>
    </div>

</div>
<!--/ Basic Bootstrap Table -->

<!-- Create Modal -->
<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Change Menu Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pages.order') }}" method="post">
                    @csrf
                    <div>





                        <div class="table">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Slug</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">

                                    @foreach (systemPages('header_link') as $page)
                                    <tr draggable='true' ondragstart='start()' ondragover='dragover()' class="cursor-move">
                                        <td>{{ $page->name }}</td>
                                        <td>/{{ $page->slug }}
                                            <input type="hidden" name="sorting[]" value="{{ $page->id }}">
                                        </td>

                                    </tr>
                                    @endforeach




                                </tbody>
                            </table>
                        </div>


                    </div>


                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>

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

    var row;

    function start() {
        row = event.target;
    }

    function dragover() {
        var e = event;
        e.preventDefault();

        let children = Array.from(e.target.parentNode.parentNode.children);
        if (children.indexOf(e.target.parentNode) > children.indexOf(row))
            e.target.parentNode.after(row);
        else
            e.target.parentNode.before(row);
    }
</script>
<!--Embed Code ends-->
@endsection