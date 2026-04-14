@extends('layouts/contentNavbarLayout')

@section('title', 'Chat Assistant')

@section('page-script')
    <script src="{{ asset('assets/js/form-basic-inputs.js') }}"></script>
@endsection

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Chat Assistant /</span> Create New Assistant
        <a href="{{ route('manage.assistant') }}" class="btn btn-primary"><i class='bx bx-arrow-back bx-sm'></i></a>
    </h4>

    <div class="row justify-content-center">

        <!-- Form controls -->
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Enter Assistant Details</h5>
                <div class="card-body">
                    @include('content.alerts')
                    <form action="{{ route('assistant.submit') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="formFile" class="form-label">Assistant Avatar</label>
                            <input class="form-control" type="file" name="avatar" id="formFile">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Assistant Name</label>
                            <input type="text" name="name" class="form-control" value=""
                                id="exampleFormControlInput1" placeholder="Assistant Name" />
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlReadOnlyInput1" class="form-label">Chat Page Title</label>
                            <input class="form-control" type="text" name="page_title" value=""
                                id="exampleFormControlReadOnlyInput1" placeholder="Chat Page Title" />
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlReadOnlyInput1" class="form-label">Chat Conversation Title</label>
                            <input class="form-control" type="text" name="chat_title" value=""
                                id="exampleFormControlReadOnlyInput1" placeholder="Chat Conversation Title" />
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlReadOnlyInput1" class="form-label">Chat Plugin Floating
                                Text</label>
                            <input class="form-control" type="text" name="floating_text" value=""
                                id="exampleFormControlReadOnlyInput1" placeholder="Chat Plugin Floating Text" />
                        </div>


                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Assistamt First Reply</label>
                            <textarea class="form-control" name="first_reply" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Chat Page Color</label>
                            <input class="form-control" type="color" name="chat_color" value="#666EE8" id="html5-color-input">

                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Create New Assistant</button>
                        </div>

                    </form>



                </div>
            </div>
        </div>


    </div>
@endsection
