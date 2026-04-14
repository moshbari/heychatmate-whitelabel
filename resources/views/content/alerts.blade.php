<div class="col-md-12">

@if(session()->has('success'))

  <div class="alert alert-success alert-dismissible" role="alert">
    {{session()->get('success')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
    </button>
  </div>
@endif

@if(session()->has('error'))

<div class="alert alert-danger alert-dismissible" role="alert">
  {!!session()->get('error')!!}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
  </button>
</div>
@endif

@if(count($errors) > 0)
<div class="alert alert-danger  alert-dismissible">
	<ul class="text-left">
	@foreach($errors->all() as $error)
		<li>{{$error}}</li>
	@endforeach
	</ul>

  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
</div>
@endif



</div>
