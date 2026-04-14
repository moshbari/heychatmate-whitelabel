<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>{{$assistant->page_title}}</title>
  <link rel="stylesheet" href="{{asset('assets/css/embeds.css')}}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Google Fonts Link For Icons -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <style>
      .chatbot header{
        background: {{$assistant->chat_color}} !important;
      }
      .css-input{
        border-color: {{$assistant->chat_color}} !important;
      }
      .testbutton{
        background: {{$assistant->chat_color}} !important;
        border-color: {{$assistant->chat_color}} !important;
      }
      .testbutton:hover{
        opacity: 80%;
      }
    </style>
</head>

<body>
  <!--<button class="chatbot-toggler">-->
  <!--  <span class="material-symbols-rounded">mode_comment</span>-->
  <!--  <span class="material-symbols-outlined">close</span>-->
  <!--</button>-->


<div class="chatbot">
    <header>
      <h2>{{$assistant->chat_title}}</h2>
      <!--<span class="close-btn material-symbols-outlined">close</span>-->
    </header>

@if (session('InfoStatus'))
    <div id="Cbox">
      <ul class="chatbox">
        <li class="chat incoming">
          <img src="{{asset('assets/img/avatars/admin-thumb.jpg')}}" alt="" class="admin-icon">
          <p>{!!get_settings("first_reply")!!}</p>
        </li>

          @foreach ($oldchats as $oldchat)

            @if($oldchat->role == "user")
              <li class="chat outgoing">
                <p>{{$oldchat->content}}</p>
              </li>
            @else
              <li class="chat incoming">
                <img src="{{asset('assets/img/avatars/admin-thumb.jpg')}}" alt="" class="admin-icon">
                <p>{!!$oldchat->content!!}</p>
              </li>
            @endif

          @endforeach

      </ul>
      <form class="chat-input" id="chatfrom">

        <input placeholder="Enter a message..." name="reply" id="reply" spellcheck="false" type="text">
        <button type="submit" id="send-btn" class="material-symbols-rounded">send</button>


      </form>
    </div>

@else
  <div class="chatbox" id="infoBox">
    <form class="customer-input" id="infofrom">
      <h3>Enter Your Details!</h3>
      <input type="text" name="name" class="css-input" id="cname" placeholder="Your Name"><br>
      <input type="text" name="email" class="css-input" id="cemail" placeholder="Youe Email"><br>
      <span id="err" class="err"></span>
      <button type="submit" class="testbutton">Start Chat!</button>
    </form>
  </div>

  <div style="display:none" id="Cbox">
        <ul class="chatbox">

          <li class="chat incoming">
            <img src="{{asset('assets/img/avatars/admin-thumb.jpg')}}" alt="" class="admin-icon">
            <p>{{$assistant->first_reply}}</p>
          </li>

        </ul>
        <form class="chat-input" id="chatfrom">

          <input placeholder="Enter a message..." name="reply" id="reply" spellcheck="false" type="text">
          <button type="submit" id="send-btn" class="material-symbols-rounded">send</button>


        </form>
      </div>
@endif





  </div>

</body>

<script>

  var keys = "{{config('broadcasting.connections.pusher.key')}}";
  var channelID = "chat-{{$chat->id}}";
  var eventlID = "event-{{$chat->id}}";
  var csrf = "{{csrf_token()}}";
  var hostUrl = "{{url('/')}}/";





</script>
<script src="{{asset('assets/js/embed.js')}}" defer></script>
</html>
