@extends('layouts/contentNavbarLayout')

@section('title', ' Assistant Chats')

@section('content')
<style>
    .assistants .card:hover {
        box-shadow: 0px 20px 40px rgba(0, 0, 0, 0.4);
        transform: scale(1.05, 1.05);
        transition: .3s;
    }
</style>

<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Dashboard /</span> Assistant Chats
</h4>
<!-- Button trigger modal -->

<!-- Basic Bootstrap Card -->
<div class="row assistants">
    @include('content.alerts')
    @forelse ($assistants as $assistant)
    <div class="col-md-4 col-lg-4 mb-3">
        <div class="card">
            <div class="card-body row">
                <div class="col-md-4">
                    @if ($assistant->avatar)
                    <img src="{{ asset('assets/img/avatars/' . $assistant->avatar) }}" class="rounded-circle" alt="Cinque Terre" width="80" height="80">
                    @else
                    <img src="{{ asset('assets/img/avatars/default-assistant.png') }}" class="rounded-circle" alt="Cinque Terre" width="80" height="80">
                    @endif
                </div>
                <div class="col-md-8">
                    <h5 class="card-title mb-1">{{ $assistant->name }}</h5>
                    <strong class="mb-1">Chats Completed: {{ $assistant->chat->where('status', 1)->count() }}</strong>
                    <a href="{{route('chat.support',$assistant->id)}}" class="btn btn-info btn-sm d-block"><i class="bx bx-show me-1"></i> View All</a>
                </div>

            </div>

        </div>
    </div>
    @empty
    <div class="col-md-6 col-lg-4 mb-3">
        <a href="{{ route('assistant.create') }}" class="card text-center cursor-pointer">
            <div class="card-body" style="opacity: 30%">
                <img src="{{ asset('assets/img/pages/plusicon.png') }}" class="rounded-circle m-3" alt="Cinque Terre" width="150" height="150">
                <h5 class="card-title">Create New Assistant</h5>
            </div>

        </a>
    </div>
    @endforelse

</div>

<!--/ Basic Bootstrap Card -->

@endsection
@section('page-script')
<script>
    $('.delete').on('click', function() {

        var link = $(this).data('url');

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this! All Data Related to this assistant will be removed permanently!",
            icon: "warning",
            timer: 3000,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: link
        })
    });
</script>
@endsection