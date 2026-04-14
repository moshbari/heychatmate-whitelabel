@extends('layouts/contentNavbarLayout')
@php
    $section_title = 'FAQ';
    $ctype = 'faq';
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
                                    <th>Question</th>
                                    <th>Answer</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($faqs as $faq)
                                    <tr>
                                        <td>{{ $faq->question }}</td>
                                        <td>{{ $faq->answer }}</td>
                                        <td></td>
                                        <td>
                                            <a class="btn btn-primary btn-sm edit" href="javascript:void(0)"
                                                data-info="{{ $faq }}"><i class="bx bx-edit me-1"></i></a>
                                            <a class="btn btn-danger btn-sm delete" href="javascript:void(0)"
                                                data-url="<a href='{{ route('faq.delete', $faq->id) }}' style='color:white;'>Yes, delete it!</a>"><i
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
                    <form action="{{ route('faq.create') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">{{ $section_title }} Question</label>
                            <input type="text" name="question" class="form-control" value=""
                                id="exampleFormControlInput1" placeholder="Question" />
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">{{ $section_title }} Answer</label>

                            <textarea name="answer" rows="5"  class="form-control"placeholder="Answer"></textarea>
                        </div>

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

                    <form action="{{ route('faq.update') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">{{ $section_title }} Question</label>
                            <input type="text" name="question" class="form-control" value=""
                                id="exampleFormControlInput1" placeholder="Question" />
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">{{ $section_title }} Answer</label>
                            <textarea name="answer" rows="5"  class="form-control"placeholder="Answer"></textarea>
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
            modal.find('input[name=question]').val(data.question)
            modal.find('textarea[name=answer]').val(data.answer)

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
