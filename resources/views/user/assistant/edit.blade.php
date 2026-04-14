@extends('layouts/contentNavbarLayout')

@section('title', 'Chat Assistant')

@section('content')

<style>
    .bg-cicon {
        background-color: {
                {
                $assistant->chat_color
            }
        }

        ;
    }
</style>

<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Chat Assistant /</span> Update Assistant Data
    <a href="{{ route('manage.assistant') }}" class="btn btn-primary"><i class='bx bx-arrow-back bx-sm'></i></a>
</h4>

@include('content.alerts')
<div class="row">

    <!-- Form controls -->
    <div class="col-md-6">
        <div class="card mb-4">
            <h5 class="card-header">Update Assistant Details</h5>
            <div class="card-body">
                <form action="{{ route('assistant.update', $assistant->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="formFile" class="form-label">Current Avatar</label>
                        <img src="{{ asset('assets/img/avatars/' . $assistant->avatar) }}" class="rounded-circle"
                            alt="Cinque Terre" width="150" height="150">
                    </div>

                    <div class="mb-3">
                        <label for="formFile" class="form-label">Select New Avatar</label>
                        <input class="form-control" type="file" name="avatar" id="formFile">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Assistant Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $assistant->name }}"
                            id="exampleFormControlInput1" placeholder="Assistant Name" />
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlReadOnlyInput1" class="form-label">Chat Page Title</label>
                        <input class="form-control" type="text" name="page_title"
                            value="{{ $assistant->page_title }}" id="exampleFormControlReadOnlyInput1"
                            placeholder="Chat Page Title" />
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlReadOnlyInput1" class="form-label">Chat Conversation Title</label>
                        <input class="form-control" type="text" name="chat_title"
                            value="{{ $assistant->chat_title }}" id="exampleFormControlReadOnlyInput1"
                            placeholder="Chat Conversation Title" />
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlReadOnlyInput1" class="form-label">Chat Plugin Floating
                            Text</label>
                        <input class="form-control" type="text" name="floating_text"
                            value="{{ $assistant->floating_text }}" id="exampleFormControlReadOnlyInput1"
                            placeholder="Chat Plugin Floating Text" />
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlReadOnlyInput1" class="form-label">Chat Form Title
                            Text</label>
                        <input class="form-control" type="text" name="form_title"
                            value="{{ $assistant->form_title }}" id="exampleFormControlReadOnlyInput1"
                            placeholder="Chat Plugin Floating Text" />
                    </div>


                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Assistamt First Reply</label>
                        <textarea class="form-control" name="first_reply" rows="3" id="summernote">{{ $assistant->first_reply }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Chat Page Color</label>
                        <input class="form-control" type="color" name="chat_color"
                            value="{{ $assistant->chat_color }}" id="html5-color-input">

                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="formFile" class="form-label">Select Chat Button Icon</label>


                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="chat_icon"
                                    id="flexRadioDefault1" value="chat-rect-white.png" checked>
                                <label class="bg-cicon rounded-circle"
                                    style="width:100px;height:100px;padding: 20px;margin-right:10px"
                                    for="flexRadioDefault1">
                                    <img src="{{ asset('assets/img/icons/hey-icons/chat-rect-white.png') }}"
                                        class="img-fluid" alt="Cinque Terre">
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="chat_icon" value="chat-round-white.png"
                                    id="flexRadioDefault2">
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
                                    src="{{ $assistant->chat_icon != ""?asset('assets/img/icons/hey-icons/'.$assistant->chat_icon): asset('assets/img/icons/hey-icons/chat-rect-white.png')}}"
                                    class="img-fluid" alt="Chat Button">
                            </div>
                        </div>


                        <input class="form-control d-none" type="file" name="cicon" id="chatIcon">
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlSelect1e" class="form-label">Type Effect</label>
                        <select class="form-select" name="type_effect" id="exampleFormControlSelect1e"
                            aria-label="Default select example">
                            <option value="1" {{ $assistant->type_effect == 1 ? 'selected' : '' }}>Enabled
                            </option>
                            <option value="0" {{ $assistant->type_effect == 0 ? 'selected' : '' }}>Disabled
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlSelect1e2" class="form-label">Phone Number Input</label>
                        <select class="form-select" name="phone_field" id="exampleFormControlSelect1e2"
                            aria-label="Default select example">
                            <option value="1" {{ $assistant->phone_field == 1 ? 'selected' : '' }}>Enabled
                            </option>
                            <option value="0" {{ $assistant->phone_field == 0 ? 'selected' : '' }}>Disabled
                            </option>
                        </select>
                    </div>


                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Update Assistant Data</button>
                    </div>

                </form>



            </div>
        </div>
    </div>

    <!-- Form controls -->
    <div class="col-md-6">
        <div class="card mb-4">
            <h5 class="card-header">Chat Starter Form Fields</h5>
            <div class="card-body">
                {{-- <form action="{{ route('assistant.field.submit') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ass_id" value="{{ $assistant->id }}">
                <div class="mb-3">
                    <label for="exampleFormControlSelect1" class="form-label">Input Type</label>
                    <select class="form-select" id="exampleFormControlSelect1" name="type" aria-label="Default select example">
                        <option selected>Select Type</option>
                        <option value="input">Input</option>
                        <option value="textarea">Textarea</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlReadOnlyInput15" class="form-label">Input Label
                        Text</label>
                    <input class="form-control" type="text" name="label" value="" id="exampleFormControlReadOnlyInput15"
                        placeholder="Input Label" />
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlSelect1" class="form-label">Required</label>
                    <select class="form-select" name="required" id="exampleFormControlSelect1"
                        aria-label="Default select example">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Add Field</button>
                </div>

                </form>

                <hr>
                <h5>Current Fields</h5>
                <hr> --}}

                <div class="mb-3">
                    <input class="form-control" type="text" placeholder="Name" />
                </div>
                <div class="mb-3">
                    <input class="form-control" type="text" placeholder="Email" />
                </div>

                @if ($assistant->phone_field)

                <div class="mb-3">
                    <input class="form-control" type="text" placeholder="Phone Number" />
                </div>

                @endif


                @forelse ($assistant->formfields as $field)
                @if ($field->type == 'input')
                <div class="mb-3">
                    <label class="form-label">{{ $field->label }} </label>
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm float-end m-1 delete"
                        data-url="<a href='{{ route('assistant.field.delete', $field->id) }}' style='color:white;'>Yes, delete it!</a>"><i
                            class="bx bx-trash"></i></a>
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm float-end m-1 edit"
                        data-info="{{ $field }}"><i class="bx bx-edit"></i></a>
                    <input class="form-control" type="text" placeholder="{{ $field->label }}" />
                </div>
                @else
                <div class="mb-3">
                    <label class="form-label">{{ $field->label }} </label>
                    <a href="javascript:void(0)" class="btn btn-danger btn-sm float-end m-1 delete"
                        data-url="<a href='{{ route('assistant.field.delete', $field->id) }}' style='color:white;'>Yes, delete it!</a>"><i
                            class="bx bx-trash"></i></a>
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm float-end m-1 edit"
                        data-info="{{ $field }}"><i class="bx bx-edit"></i></a>
                    <textarea class="form-control" rows="3" placeholder="{{ $field->label }} "></textarea>
                </div>
                @endif


                @empty
                @endforelse



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
                <form action="{{ route('assistant.field.update') }}" method="post">
                    {{ csrf_field() }}
                    <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">Input Type</label>
                        <select class="form-select" id="exampleFormControlSelect1" name="type"
                            aria-label="Default select example">
                            <option selected>Select Type</option>
                            <option value="input">Input</option>
                            <option value="textarea">Textarea</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlReadOnlyInput15" class="form-label">Input Label
                            Text</label>
                        <input class="form-control" type="text" name="label" value=""
                            id="exampleFormControlReadOnlyInput15" placeholder="Input Label" />
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">Required</label>
                        <select class="form-select" name="required" id="exampleFormControlSelect1"
                            aria-label="Default select example">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <input type="hidden" name="field_id">
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

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Write Your Page Contents Here!',
            height: 500
        });
    });

    $('.edit').on('click', function() {
        var modal = $('#editModal');
        var data = $(this).data('info')
        modal.find('input[name=field_id]').val(data.id)
        modal.find('select[name=type]').val(data.type)
        modal.find('input[name=label]').val(data.label)
        modal.find('select[name=required]').val(data.required)
        modal.modal('show');
    });
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
    $(document).ready(function() {
        $('#html5-color-input').on('input', function() {
            var selectedColor = $(this).val();
            console.log(selectedColor); // Log the selected color
            $('.bg-cicon').css('background-color', selectedColor);


        });
    });
</script>

@endsection