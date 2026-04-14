@extends('layouts/contentNavbarLayout')

@section('title', 'Live Chat')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
@endsection

@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
<style>
  .active{
    background-color: rebeccapurple!important;
  }
.chat-message-right .chat-message-text{background-color: rebeccapurple!important;
}

</style>
  <!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">


    <div class="app-chat overflow-hidden card">
      <div class="row g-0">


        <!-- Chat & Contacts -->
        <div class="col app-chat-contacts app-sidebar flex-grow-0 overflow-hidden border-end" id="app-chat-contacts">
          <div class="sidebar-header pt-3 px-3 mx-1">
            <div class="d-flex align-items-center me-3 me-lg-0">
              <div class="flex-shrink-0 avatar avatar-online me-2" data-bs-toggle="sidebar"
                data-overlay="app-overlay-ex" data-target="#app-chat-sidebar-left">
                <span class="avatar-initial rounded-circle bg-label-success">CM</span>
              </div>
              <div class="flex-grow-1 input-group input-group-merge rounded-pill ms-1">
                <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search fs-4"></i></span>
                <input type="text" class="form-control chat-search-input" placeholder="Search..." aria-label="Search..."
                  aria-describedby="basic-addon-search31">
              </div>
            </div>
            <i class="bx bx-x cursor-pointer position-absolute top-0 end-0 mt-2 me-1 fs-4 d-lg-none d-block"
              data-overlay data-bs-toggle="sidebar" data-target="#app-chat-contacts"></i>
          </div>
          <hr class="container-m-nx mt-3 mb-0">
          <div class="sidebar-body">

            <!-- Chats -->
            <ul class="list-unstyled chat-contact-list pt-1" id="chat-list">
              <li class="chat-contact-list-item chat-contact-list-item-title">
                <h5 class="text-primary mb-0">Chats</h5>
              </li>
              <li class="chat-contact-list-item chat-list-item-0 d-none">
                <h6 class="text-muted mb-0">No Chats Found</h6>
              </li>

              <li class="chat-contact-list-item active">
                <a class="d-flex align-items-center">
                  <div class="flex-shrink-0 avatar avatar-online">
                   <span class="avatar-initial rounded-circle bg-label-success">CM</span>
                  </div>
                  <div class="chat-contact-info flex-grow-1 ms-3">
                    <h6 class="chat-contact-name text-truncate m-0">Felecia Rower</h6>
                    {{-- <p class="chat-contact-status text-truncate mb-0 text-muted">I will purchase it for sure. 👍</p> --}}
                  </div>
                  {{-- <small class="text-muted mb-auto">30 Minutes</small> --}}
                </a>
              </li>


              <li class="chat-contact-list-item">
                <a class="d-flex align-items-center">
                  <div class="flex-shrink-0 avatar avatar-online">
                    <span class="avatar-initial rounded-circle bg-label-success">CM</span>
                  </div>
                  <div class="chat-contact-info flex-grow-1 ms-3">
                    <h6 class="chat-contact-name text-truncate m-0">Calvin Moore</h6>
                    {{-- <p class="chat-contact-status text-truncate mb-0 text-muted">If it takes long you can mail inbox
                      user</p> --}}
                  </div>
                  {{-- <small class="text-muted mb-auto">1 Day</small> --}}
                </a>
              </li>

            </ul>

          </div>
        </div>
        <!-- /Chat contacts -->

        <!-- Chat History -->
        <div class="col app-chat-history">
          <div class="chat-history-wrapper">
            <div class="chat-history-header border-bottom">
              <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex overflow-hidden align-items-center">
                  <i class="bx bx-menu bx-sm cursor-pointer d-lg-none d-block me-2" data-bs-toggle="sidebar"
                    data-overlay data-target="#app-chat-contacts"></i>
                  <div class="flex-shrink-0 avatar">
                    <span class="avatar-initial rounded-circle bg-label-success">CM</span>
                  </div>
                  <div class="chat-contact-info flex-grow-1 ms-3">
                    <h6 class="m-0">Felecia Rower</h6>
                    {{-- <small class="user-status text-muted">NextJS developer</small> --}}
                  </div>
                </div>
                {{-- <div class="d-flex align-items-center">
                  <i class="bx bx-phone-call cursor-pointer d-sm-block d-none me-3 fs-4"></i>
                  <i class="bx bx-video cursor-pointer d-sm-block d-none me-3 fs-4"></i>
                  <i class="bx bx-search cursor-pointer d-sm-block d-none me-3 fs-4"></i>
                  <div class="dropdown">
                    <button class="btn p-0" type="button" id="chat-header-actions" data-bs-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false">
                      <i class="bx bx-dots-vertical-rounded fs-4"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="chat-header-actions">
                      <a class="dropdown-item" href="javascript:void(0);">View Contact</a>
                      <a class="dropdown-item" href="javascript:void(0);">Mute Notifications</a>
                      <a class="dropdown-item" href="javascript:void(0);">Block Contact</a>
                      <a class="dropdown-item" href="javascript:void(0);">Clear Chat</a>
                      <a class="dropdown-item" href="javascript:void(0);">Report</a>
                    </div>
                  </div> --}}
                </div>
              </div>
            </div>




            <div class="chat-history-body">
              <ul class="list-unstyled chat-history mb-0">

              </ul>
            </div>
            <!-- Chat message form -->
            <div class="chat-history-footer">
              <form class="form-send-message d-flex justify-content-between align-items-center ">
                <input class="form-control message-input border-0 me-3 shadow-none"
                  placeholder="Type your message here...">
                <div class="message-actions d-flex align-items-center">
                  {{-- <i class="speech-to-text bx bx-microphone bx-sm cursor-pointer"></i> --}}
                  {{-- <label for="attach-doc" class="form-label mb-0">
                    <i class="bx bx-paperclip bx-sm cursor-pointer mx-3"></i>
                    <input type="file" id="attach-doc" hidden>
                  </label> --}}
                  <button class="btn btn-primary d-flex send-msg-btn">
                    <i class="bx bx-paper-plane me-md-1 me-0"></i>
                    <span class="align-middle d-md-inline-block d-none">Send</span>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /Chat History -->






        <div class="app-overlay"></div>
      </div>
    </div>



  </div>
  <!-- / Content -->






  <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->

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
@endsection
