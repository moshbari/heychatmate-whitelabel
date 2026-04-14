@foreach ($oldchats as $oldchat)
    @if ($oldchat->role == 'user')
        <li class="chat outgoing">
            <div>{{ $oldchat->content }}</div>
        </li>
    @else
        <li class="chat incoming">
            <img src="{{ asset('assets/img/avatars/' . $chat->assistant->avatar) }}" alt="" class="admin-icon">
            <div>{!! $oldchat->content !!}</div>
        </li>
    @endif
@endforeach
