<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>{{$assistant->name}}</title>
  <link rel="stylesheet" href="{{asset('assets/css/embed.css')}}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Google Fonts Link For Icons -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>

<body>
  <a href="{{route('chat.embed',$assistant->slug)}}" target="_blank" class="widgetLabel moveFromRightLabel-enter-done" type="button" style=""><span>{{$assistant->floating_text}} <img
        src="https://cdnjs.cloudflare.com/ajax/libs/twemoji/12.1.1/72x72/1f44b.png" alt=""
        class="emoji"></span></a>
  <a href="{{route('chat.embed',$assistant->slug)}}" target="_blank" class="chatbot-toggler">

    <span class="material-symbols-rounded">mode_comment</span>
    <span class="material-symbols-outlined">close</span>
  </a>


</body>

<script>

</script>
</html>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>{{$assistant->name}}</title>
  <link rel="stylesheet" href="{{asset('assets/css/embed.css')}}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Google Fonts Link For Icons -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>
<style>
  .chatboxx{
    display: none;
  }
  object{
    height: 656px;
    width: 414px;
    position: absolute;
    right: 0;
    bottom: 20px;
  }
</style>

<body>

<div id="chatBoxx" class="chatboxx">
ddd
</div>


  <button class="widgetLabel moveFromRightLabel-enter-done showBox" onclick="load_home()" type="button" style=""><span>{{$assistant->floating_text}} <img
        src="https://cdnjs.cloudflare.com/ajax/libs/twemoji/12.1.1/72x72/1f44b.png" alt=""
        class="emoji"></span></button>
  <button href="javascript.void(0);" onclick="load_home()" class="chatbot-toggler showBox">

    <span class="material-symbols-rounded">mode_comment</span>
    <span class="material-symbols-outlined">close</span>
  </button>


</body>

<script>
  function showDiv() {
    if (document.getElementsByTagName('object').innerHTML === "") {
      document.getElementById('chatBoxx').style.display = "block";
      document.getElementById("chatBoxx").innerHTML='<object type="text/html" data="{{route('chat.embed',$assistant->slug)}}" ></object>';
    }else{

      document.getElementById('chatBoxx').style.display = "block";
    }
}

function load_home() {
     document.getElementById("chatBoxx").innerHTML='<object type="text/html" data="{{route('chat.embed',$assistant->slug)}}" ></object>';
}
</script>
</html>
