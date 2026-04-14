@extends('layouts/contentNavbarLayout')

@section('title', 'Update Page Data')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Admin /</span> Update Page Data
        <a href="{{ route('pages.index') }}" class="btn btn-primary"><i class='bx bx-arrow-back bx-sm'></i></a>
    </h4>

    <div class="row justify-content-center">

        <!-- Form controls -->
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Update Page Details</h5>
                <div class="card-body">
                    @include('content.alerts')
                    <form action="{{ route('pages.update',$page->id) }}" method="post">
                        @csrf


                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Page Name</label>
                                    <input type="text" name="name" class="form-control" value="{{$page->name}}"
                                        id="exampleFormControlInput1" placeholder="Page Name" />
                                </div>

                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">Page Title</label>
                                    <input type="text" name="title" class="form-control" value="{{$page->title}}"
                                        id="exampleFormControlInput1" placeholder="Page Title" />
                                </div>

                                <div class="mb-3">
                                    <label for="exampleFormControlReadOnlyInput1" class="form-label">Page URL Slug</label>
                                    <input class="form-control" type="text" name="slug" value="{{$page->slug}}"
                                        id="exampleFormControlReadOnlyInput1" placeholder="Page URL Slug" />
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="header_link" value="1"
                                        id="defaultCheck22" {{$page->header_link == 1?'checked':''}}>
                                    <label class="form-check-label" for="defaultCheck22">
                                        Show On Header
                                    </label>
                                </div>

                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="footer_link" value="1"
                                        id="defaultCheck1" {{$page->footer_link == 1?'checked':''}}>
                                    <label class="form-check-label" for="defaultCheck1">
                                        Show On Footer
                                    </label>
                                </div>
                            </div>

                            @if ($page->type != 'default')
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Page Contents</label>
                                        <textarea class="form-control" id="summernote" name="contents" id="exampleFormControlTextarea1" rows="20">{{$page->contents}}</textarea>
                                    </div>
                                </div>
                            @endif


                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Update Page</button>
                            </div>

                        </div>

                    </form>



                </div>
            </div>
        </div>


    </div>
@endsection

@section('page-script')
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Write Your Page Contents Here!',
                height: 500
            });
        });
    </script>
@endsection
