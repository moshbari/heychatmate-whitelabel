@extends('layouts/contentNavbarLayout')
@php
    $section_title = 'Testimonials';
    $ctype = 'testimonials';
@endphp

@section('title', $section_title . ' Section')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">HomePage /</span> {{ $section_title }} Section
    </h4>

    <div class="row">

        @include('content.alerts')
        <!-- Form controls -->
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">{{ $section_title }} Titles </h5>
                <div class="card-body">

                    <form action="{{ route('homepage.update') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">{{ $section_title }} Title</label>
                            <textarea class="form-control" name="{{$ctype}}_section_title" rows="5">{!! get_settings($ctype.'_section_title') !!}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ $section_title }} Subtitle</label>
                            <textarea class="form-control" name="{{$ctype}}_section_subtitle" rows="5">{!! get_settings($ctype.'_section_subtitle') !!}</textarea>
                        </div>

                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>



                    </form>



                </div>
            </div>
        </div>
        <!-- Form controls -->
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">{{ $section_title }} Contents

                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                        data-bs-target="#basicModal">
                        Add {{ $section_title }}
                    </button>
                </h5>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name & Designation</th>
                                    <th>Details</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($testimonials as $why)
                                    <tr>
                                        <td>
                                            <img height="200px" src="{{ asset('assets/front/images/home/' . $why->icon) }}" alt="image">
                                        </td>
                                        <td>{{ $why->title }} <br><small>{{ $why->image }}</small></td>
                                        <td>{{ $why->text }}</td>
                                        <td></td>
                                        <td>
                                            <a class="btn btn-primary btn-sm edit" href="javascript:void(0)"
                                                data-info="{{ $why }}"><i class="bx bx-edit me-1"></i></a>
                                            <a class="btn btn-danger btn-sm delete" href="javascript:void(0)"
                                                data-url="<a href='{{ route('contents.delete', $why->id) }}' style='color:white;'>Yes, delete it!</a>"><i
                                                    class="bx bx-trash me-1"></i></a>

                                        </td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>




    </div>




    <!-- Create Modal -->
    <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Add New {{ $section_title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('contents.create') }}" method="post" enctype="multipart/form-data">
                        @csrf
                         <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Client Name</label>
                            <input type="text" name="title" class="form-control" value=""
                                id="exampleFormControlInput1" placeholder="Name" />
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Client Designation</label>
                            <input type="text" name="image" class="form-control" value=""
                                id="" placeholder="Designation" />
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Client Review</label>
                            <textarea name="details" rows="5"  class="form-control"placeholder="Details"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="formFile" class="form-label">Client Image</label>
                            <input class="form-control" type="file" name="icon" id="formFile2">
                        </div>
                        <input type="hidden" name="section" value="Why Choose">
                        <input type="hidden" name="type" value="{{$ctype}}">

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>



    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Update {{ $section_title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('contents.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Client Name</label>
                            <input type="text" name="title" class="form-control" value=""
                                id="exampleFormControlInput1" placeholder="Name" />
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Client Designation</label>
                            <input type="text" name="image" class="form-control" value=""
                                id="" placeholder="Designation" />
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Client Review</label>
                            <textarea name="details" rows="5"  class="form-control"placeholder="Details"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Current Client Image: </label>
                            <img id="wicon" height="400px" src="" alt="icon" class="bg-primary">
                        </div>

                        <div class="mb-3">
                            <label for="formFile" class="form-label">Change Client Image</label>
                            <input class="form-control" type="file" name="icon" id="formFile2">
                        </div>
                        <input type="hidden" name="section" value="{{$section_title}}">
                        <input type="hidden" name="type" value="{{$ctype}}">
                        <input type="hidden" name="id" value="">

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update</button>
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
        $('.edit').on('click', function() {
            var modal = $('#editModal');
            var data = $(this).data('info')

            modal.find('input[name=id]').val(data.id)
            modal.find('input[name=title]').val(data.title)
            modal.find('input[name=image]').val(data.image)
            modal.find('textarea[name=details]').val(data.text)
            modal.find('#wicon').attr('src', "{{ asset('assets/front/images/home/') }}/"+data.icon);

            modal.modal('show');


        });
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

@endsection
