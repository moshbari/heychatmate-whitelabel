
@if($status === 1)
@if ($type_effect === 1)
{!!$message!!}
@else
<li class="chat incoming">
  <img src="{{asset('assets/img/avatars/'.$thumb)}}" alt="" class="admin-icon">
  <div>{!!$message!!}</div>
</li>
@endif

@endif
