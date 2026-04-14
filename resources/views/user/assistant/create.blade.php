@extends('layouts/contentNavbarLayout')

@section('title', 'Chat Assistant')

@section('page-script')
<script src="{{ asset('assets/js/form-basic-inputs.js') }}"></script>
@endsection

@section('content')
<style>
    .bg-cicon {
        background-color: #000000;
    }
</style>

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
                        <label for="exampleFormControlReadOnlyInput1" class="form-label">Chat Form Title
                            Text</label>
                        <input class="form-control" type="text" name="form_title"
                            id="exampleFormControlReadOnlyInput1" placeholder="Chat Plugin Floating Text" />
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Assistamt First Reply</label>
                        <textarea class="form-control" name="first_reply" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Chat Page Color</label>
                        <input class="form-control" type="color" name="chat_color" value="#666EE8"
                            id="html5-color-input">

                    </div>


                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="formFile" class="form-label">Select Chat Button Icon</label>


                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="chat_icon" id="flexRadioDefault1"
                                    value="chat-rect-white.png" checked>
                                <label class="bg-cicon rounded-circle"
                                    style="width:100px;height:100px;padding: 20px;margin-right:10px"
                                    for="flexRadioDefault1">
                                    <img src="{{ asset('assets/img/icons/hey-icons/chat-rect-white.png') }}"
                                        class="img-fluid" alt="Cinque Terre">
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="chat_icon"
                                    value="chat-round-white.png" id="flexRadioDefault2">
                                <label class="bg-cicon rounded-circle"
                                    style="width:100px;height:100px;padding: 20px;margin-right:10px"
                                    for="flexRadioDefault2">
                                    <img src="{{ asset('assets/img/icons/hey-icons/chat-round-white.png') }}"
                                        class="img-fluid" alt="Cinque Terre">
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="chat_icon" value="custom"
                                    id="flexRadioDefault22">
                                <label class="form-check-label" for="flexRadioDefault22">
                                    <span class="btn btn-dark">Upload Custom Icon</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="formFile" class="form-label">Current Icon</label>
                            <div class="bg-cicon rounded-circle"
                                style="width:100px;height:100px;padding: 20px;margin-right:10px"
                                for="flexRadioDefault2">
                                <img id="currIcon"
                                    src="{{ asset('assets/img/icons/hey-icons/chat-rect-white.png') }}"
                                    class="img-fluid" alt="Chat Button">
                            </div>
                        </div>


                        <input class="form-control d-none" type="file" name="cicon" id="chatIcon">
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlSelect1e" class="form-label">Type Effect</label>
                        <select class="form-select" name="type_effect" id="exampleFormControlSelect1e"
                            aria-label="Default select example">
                            <option value="1">Enabled</option>
                            <option value="0" selected>Disabled</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlSelect1e" class="form-label">Phone Number Input</label>
                        <select class="form-select" name="phone_field" id="exampleFormControlSelect1e"
                            aria-label="Default select example">
                            <option value="1">Enabled</option>
                            <option value="0" selected>Disabled</option>
                        </select>
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
@section('page-script')

<script>
    $('#flexRadioDefault22').on('click', function() {
        $('#chatIcon').click();
    });

    $('#chatIcon').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {

                $('#currIcon').attr('src', event.target.result).show(); // Show the image
            };
            reader.readAsDataURL(file);
        } else {
            $('#currIcon').hide(); // Hide if no file is selected
        }
    });


    $(document).ready(function() {
        $('#html5-color-input').on('input', function() {
            var selectedColor = $(this).val();
            console.log(selectedColor); // Log the selected color
            $('.bg-cicon').css('background-color', selectedColor);


        });
    });
</script>

@endsection