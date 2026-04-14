<!DOCTYPE html>
<html lang="en">

<head>
  <title>Chat Laravel Pusher | Edlin App</title>
  <link rel="icon" href="https://assets.edlin.app/favicon/favicon.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- JavaScript -->
  <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <!-- End JavaScript -->

  <!-- CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- End CSS -->
  <style>
    .message-candidate {
    background: rgba(223, 229, 121, 0.9);
    padding: 40px;
    max-width: 600px;
    margin-bottom: 10px;
    }

    .message-hiring-manager {
    background: rgba(0, 167, 204, 0.9);
    padding: 40px;
    max-width: 600px;
    margin-bottom: 10px;
    }

    .messaging {
    max-width: 600px;
    margin-top: 20px;
    }

    .message-text {
    margin-top: 10px;
    }

    .message-photo {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    object-position: center center;
    display: inline-block;
    }

    .message-name {
    margin-left: 10px;
    display: inline-block;
    }
  </style>
<style>


  /*# sourceMappingURL=style.css.map */
</style>
</head>

<body>
  <h2 class="text-center">Chat</h2>
  <div class="container">
    <div class="message-candidate center-block">
      <div class="row">
        <div class="col-xs-8 col-md-6">
          <img
            src=""
            class="message-photo">
          <h4 class="message-name">Mr. Minion</h4>
        </div>
        <div class="col-xs-4 col-md-6 text-right message-date">Date here</div>
      </div>
      <div class="row message-text">
        text over here text over here text over here text over here text over here text over here text over here text over
        here text over here
      </div>
    </div>
    <div class="message-hiring-manager center-block">
      <div class="row">
        <div class="col-xs-8 col-md-6">
          <img
            src=""
            class="message-photo">
          <h4 class="message-name">Mr. Minion</h4>
        </div>
        <div class="col-xs-4 col-md-6 text-right message-date">Date here</div>
      </div>
      <div class="row message-text ">
        text over here text over here text over here text over here text over here text over here text over here text over
        here text over here
      </div>
    </div>
    <div class="messaging center-block">
      <div class="row">
        <div class="col-md-12">
          <div class="input-group">
            <input type="text" class="form-control">
            <span class="input-group-btn">
              <button class="btn btn-default" type="button">Send</button>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

<script>
  // const pusher  = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {cluster: 'ap2'});
  // const channel = pusher.subscribe('public');

  // //Receive messages
  // channel.bind('chat', function (data) {
  //   $.post("/sneat-bootstrap/public/receive", {
  //     _token:  '{{csrf_token()}}',
  //     message: data.message,
  //   })
  //    .done(function (res) {
  //      $(".messages > .message").last().after(res);
  //      $(document).scrollTop($(document).height());
  //    });
  // });

  // //Broadcast messages
  // $("form").submit(function (event) {
  //   event.preventDefault();

  //   $.ajax({
  //     url:     "/sneat-bootstrap/public/broadcast",
  //     method:  'POST',
  //     headers: {
  //       'X-Socket-Id': pusher.connection.socket_id
  //     },
  //     data:    {
  //       _token:  '{{csrf_token()}}',
  //       message: $("form #message").val(),
  //     }
  //   }).done(function (res) {
  //     $(".messages > .message").last().after(res);
  //     $("form #message").val('');
  //     $(document).scrollTop($(document).height());
  //   });
  // });

</script>

</html>
