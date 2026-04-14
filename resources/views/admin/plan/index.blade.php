@extends('layouts/contentNavbarLayout')

@section('title', 'Manage Plans')

@section('content')

<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Admin /</span> Manage Plans

    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#basicModal">
        Add New Plan
    </button>

</h4>
<!-- Button trigger modal -->

<!-- Basic Bootstrap Table -->
<div class="card">
    <h5 class="card-header">Plan List</h5>

    @include('content.alerts')
    <div class="table table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Plan Type</th>
                    <th>Credits</th>
                    <th>Cost</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($plans as $plan)
                <tr>
                    <td>{{ $plan->name }}</td>
                    <td>{{ ucfirst($plan->type) }}</td>
                    <td>{{ $plan->credits }}</td>
                    <td>{{ $plan->price }}</td>
                    <td>{!! $plan->status == 1
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Not Active</span>' !!}</td>
                    <td>
                        <a class="btn btn-primary btn-sm edit" href="javascript:void(0)" data-info="{{ $plan }}"><i class="bx bx-edit me-1"></i></a>
                        <a class="btn btn-danger btn-sm delete" href="javascript:void(0)" data-url="<a href='{{ route('plan.delete', $plan->id) }}' style='color:white;'>Yes, delete it!</a>"><i class="bx bx-trash me-1"></i></a>

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
                <h5 class="modal-title" id="exampleModalLabel1">Add New Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('plan.create') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Plan Title</label>
                        <input type="text" name="name" class="form-control" value="" id="exampleFormControlInput1" placeholder="Title" />
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Plan Subtitle</label>
                        <input type="text" name="subtitle" class="form-control" value="" id="exampleFormControlInput1" placeholder="Subtitle" />
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlSelect2" class="form-label">API Type</label>
                        <select class="form-select apiType" id="exampleFormControlSelect2" name="api_type" aria-label="Default select">
                            <option value="system" selected>System API</option>
                            <option value="user">User API</option>
                        </select>
                    </div>

                    <div class="mb-3 allowedCredit" id="allowedCredit">
                        <label for="exampleFormControlReadOnlyInput1" class="form-label">Allowed Credits</label>
                        <input class="form-control" type="text" name="credits" value="" id="exampleFormControlReadOnlyInput1" placeholder="Plan Credits" />
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlReadOnlyInput6" class="form-label">Assistant Create Limit</label>
                        <input class="form-control" type="number" name="max_bots" value="" id="exampleFormControlReadOnlyInput6" placeholder="Assistant Limit" />
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">Plan Type</label>
                        <select class="form-select" id="exampleFormControlSelect1" name="type" aria-label="Default select">
                            <option value="month" selected>Monthly</option>
                            <option value="year">Annually</option>
                            <option value="credit">Credit Plans</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlReadOnlyInput12" class="form-label">Price</label>
                        <input class="form-control" type="number" step="0.01" name="price" value="" id="exampleFormControlReadOnlyInput12" placeholder="Plan Price" />
                    </div>


                    <div class="mb-3">
                        <label for="tag-input1" class="form-label">Plan Features</label>
                        <small class="newline">Press Enter to add multiple features</small>
                        <hr>
                        <input class="form-control tagged" type="text" name="features" value="" id="taginput1" placeholder="Features" />
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



<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Update Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('plan.update') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Plan Title</label>
                        <input type="text" name="name" class="form-control" value="" id="exampleFormControlInput1" placeholder="Name" />
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Plan Subtitle</label>
                        <input type="text" name="subtitle" class="form-control" value="" id="exampleFormControlInput1" placeholder="Subtitle" />
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlSelect2" class="form-label">API Type</label>
                        <select class="form-select apiType" id="exampleFormControlSelect2" name="api_type" aria-label="Default select">
                            <option value="system" selected>System API</option>
                            <option value="user">User API</option>
                        </select>
                    </div>
                    <div class="mb-3 allowedCredit">
                        <label for="allowedCrediti" class="form-label">Allowed Credits</label>
                        <input class="form-control" type="text" name="credits" value="" id="allowedCrediti" placeholder="Plan Credits" />
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlReadOnlyInput6" class="form-label">Assistant Create
                            Limit</label>
                        <input class="form-control" type="number" name="max_bots" value="" id="exampleFormControlReadOnlyInput6" placeholder="Assistant Limit" />
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">Plan Type</label>
                        <select class="form-select" id="exampleFormControlSelect1" name="type" aria-label="Default select">
                            <option value="month">Monthly</option>
                            <option value="year">Annually</option>
                            <option value="credit">Credit Plans</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlReadOnlyInput12" class="form-label">Price</label>
                        <input class="form-control" type="number" step="0.01" name="price" value="" id="exampleFormControlReadOnlyInput12" placeholder="Plan Price" />
                    </div>

                    <div class="mb-3">
                        <label for="tag-input1" class="form-label">Plan Features</label>
                        <small class="newline">Press Enter to add multiple features</small>
                        <hr>
                        <input class="form-control" type="text" name="features" value="" id="taginput2" placeholder="Features" />
                    </div>
                    <input type="hidden" name="id">

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">update</button>
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

<script src="{{ asset('assets/js/tagify.js') }}"></script>
<script type="text/javascript">
    $('.apiType').on('change', function() {

        if ($(this).val() == 'user') {
            $('.allowedCredit').hide();
        } else {
            $('.allowedCredit').show();
        }
    });

    $('.edit').on('click', function() {

        tags2.clearTags()
        var features = "";
        var modal = $('#editModal');
        var data = $(this).data('info')

        features = data.features;

        console.log(data.features);
        modal.find('input[name=id]').val(data.id)
        modal.find('input[name=name]').val(data.name)
        modal.find('input[name=subtitle]').val(data.subtitle)
        modal.find('select[name=api_type]').val(data.api_type)
        if (data.api_type == 'user') {
            modal.find('.allowedCredit').hide();
        } else {
            modal.find('.allowedCredit').show();

        }
        modal.find('input[name=credits]').val(data.credits)

        modal.find('input[name=max_bots]').val(data.max_bots)
        modal.find('select[name=type]').val(data.type)
        modal.find('input[name=price]').val(data.price)

        if (features) {
            tags2.addTags(features.split(','));
        }
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




    // Use
    var tags = new Tags('.tagged');
    var tags2 = new Tags('#taginput2');




    // document.getElementById('get').addEventListener('click', function(e) {
    //   e.preventDefault();
    //   alert(tags.getTags());
    // });
    // document.getElementById('clear').addEventListener('click', function(e) {
    //   e.preventDefault();
    //   tags.clearTags();
    // });
    // document.getElementById('add').addEventListener('click', function(e) {
    //   e.preventDefault();
    //   tags.addTags('New');
    // });
    // document.getElementById('addArr').addEventListener('click', function(e) {
    //   e.preventDefault();
    //   tags.addTags(['Steam Machines', 'Nintendo Wii U', 'Shield Portable']);
    // });
    // document.getElementById('destroy').addEventListener('click', function(e) {
    //   e.preventDefault();
    //   if(this.textContent === 'destroy') {
    //     tags.destroy();
    //     this.textContent = 'reinit';
    //   } else {
    //     this.textContent = 'destroy';
    //     tags = new Tags('.tagged');
    //   }

    // });
</script>
<!--Embed Code ends-->
@endsection