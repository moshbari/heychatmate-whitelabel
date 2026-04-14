@extends('layouts/contentNavbarLayout')

@section('title', 'Manage Users')

@section('content')

<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Dashboard /</span> Manage Users

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
        Add New User
    </button>

</h4>
<!-- Button trigger modal -->

<!-- Basic Bootstrap Table -->
<div class="card">

    @include('content.alerts')
    <div class="row">
        <div class="col-sm-6">

            <h5 class="card-header">All Users</h5>
        </div>
        <div class="col-sm-6">

            <form action="" method="get">
                <div class="m-3 float-end">
                    <label class="form-label">Search User</label>
                    <input type="text" class="form-control search" name="search" placeholder="Enter Email">
                </div>

            </form>


        </div>

    </div>


    <div class="table  table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Credit Balance</th>
                    <th>Subscription</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->credit_balance }}</td>
                    <td>{{ $user->hasActiveSubscription() ? $user->subscription->plan->name : 'N/A' }}</td>
                    <td>{!! $user->status == 1
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Banned</span>' !!}</td>
                    <td>{{ $user->created_at->diffForHumans() }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('user.view', $user->id) }}"><i class="bx bx-show me-1"></i></a>
                        <a class="btn btn-danger btn-sm delete" href="javascript:void(0)" data-url="<a href='{{ route('user.view', $user->id) }}' style='color:white;'>Yes, delete it!</a>"><i class="bx bx-trash me-1"></i></a>

                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">No User Found In the system.</td>
                </tr>
                @endforelse


            </tbody>
        </table>

    </div>

    <div class="d-flex m-3 ">
        {!! $users->links() !!}
    </div>

</div>

</div>
<!--/ Basic Bootstrap Table -->
<!-- Create Modal -->
<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.create') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="" id="exampleFormControlInput1" placeholder="Enter Full Name" required />
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" value="" id="exampleFormControlInput1" placeholder="name@example.com" required />
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" value="" id="exampleFormControlInput1" placeholder="Enter Phone Number" required />
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">Country</label>
                        <select class="form-select" id="exampleFormControlSelect1" name="country" required>
                            <option value="">Select Country</option>
                            @foreach (allCountries() as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" value="" id="exampleFormControlInput1" placeholder="Enter Password" required />
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="basic-default-checkbox" required="">
                            <label class="form-check-label" for="basic-default-checkbox">Verify this email
                                automatically</label>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>

                </form>

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
                        <label for="exampleFormControlReadOnlyInput1" class="form-label">Allowed Credits</label>
                        <input class="form-control" type="text" name="credits" value="" id="exampleFormControlReadOnlyInput1" placeholder="Plan Credits" />
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlReadOnlyInput6" class="form-label">Assistant Create
                            Limit</label>
                        <input class="form-control" type="number" name="max_bots" value="" id="exampleFormControlReadOnlyInput6" placeholder="Assistant Limit" />
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">Plan Type</label>
                        <select class="form-select" id="exampleFormControlSelect1" name="type" aria-label="Default select">
                            <option value="monthly" selected>Monthly</option>
                            <option value="yearly">Annually</option>
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
<script type="text/javascript">
    $('.edit').on('click', function() {
        var modal = $('#editModal');
        var data = $(this).data('info')


        console.log(data.features);
        modal.find('input[name=id]').val(data.id)
        modal.find('input[name=name]').val(data.name)
        modal.find('input[name=subtitle]').val(data.subtitle)
        modal.find('input[name=credits]').val(data.credits)
        modal.find('input[name=max_bots]').val(data.max_bots)
        modal.find('select[name=type]').val(data.type)
        modal.find('input[name=price]').val(data.price)
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