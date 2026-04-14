@extends('layouts/contentNavbarLayout')

@section('title', 'Live Chat')

@section('vendor-style')
<!--<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">-->
@endsection

@section('vendor-script')
<!--<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>-->
@endsection

@section('page-script')

<!--<script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>-->
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>

<script>
    $('#show-contacts').on('click', function() {
            $('#app-chat-contacts').addClass('show');
        });

        $('#close-contacts').on('click', function() {
            $('#app-chat-contacts').removeClass('show');
        });


        @if (!empty($chatData))
            const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                cluster: 'ap2'
            });
            const channel = pusher.subscribe('chat-{{ $chatData->id }}');

            //Receive messages
            channel.bind('event-{{ $chatData->id }}', function(data) {
                console.log(data);
                if (data.from == 'ai') {


                    $("#historyChat").append(`<li class="chat-message chat-message-right">
              <div class="d-flex overflow-hidden">
                <div class="chat-message-wrapper flex-grow-1">
                  <div class="chat-message-text">
                    <p class="mb-0">` + data.message + `</p>
                  </div>
                </div>
                <div class="user-avatar flex-shrink-0 ms-3">
                  <div class="avatar avatar-sm">
                    <span class="avatar-initial rounded-circle bg-label-info">AD</span>
                  </div>
                </div>
              </div>
            </li>`);
                } else {
                    $("#historyChat").append(`<li class="chat-message">
        <div class="d-flex overflow-hidden">
          <div class="user-avatar flex-shrink-0 me-3">
            <div class="avatar avatar-sm">
              <span class="avatar-initial rounded-circle bg-label-success">{{ substr($chatData->customer_name, 0, 2) }}</span>
            </div>
          </div>
          <div class="chat-message-wrapper flex-grow-1">
            <div class="chat-message-text">
              <p class="mb-0">` + data.message + `</p>
            </div>
          </div>
        </div>
      </li>`);
                }



                adjustScroll();

            });

            function adjustScroll() {
                var height = 0;
                $('.chat-history-body .chat-message').each(function(i, value) {
                    height += parseInt($(this).height());
                });

                height += '20';

                $('.chat-history-body').animate({
                    scrollTop: height
                });
            }

            $(document).ready(function() {
                adjustScroll();
            });
            //Broadcast messages
            $(document).on("submit", "#submit-form", function(event) {

                event.preventDefault();
                var inpt = $('#inputdata').val();

                if (inpt == "") {

                    return false;

                }


                $.ajax({
                    url: "{{ url('/') }}/broadcast",
                    method: 'POST',
                    headers: {
                        'X-Socket-Id': pusher.connection.socket_id
                    },
                    data: {
                        _token: '{{ csrf_token() }}',
                        message: $("#inputdata").val(),
                        chatid: '{{ $chatData->id }}',
                    },
                    success: function(data) {

                        $("#historyChat").append(`<li class="chat-message chat-message-right">
                          <div class="d-flex overflow-hidden">
                            <div class="chat-message-wrapper flex-grow-1">
                              <div class="chat-message-text">
                                <p class="mb-0">` + inpt + `</p>
                              </div>
                            </div>
                            <div class="user-avatar flex-shrink-0 ms-3">
                              <div class="avatar avatar-sm">
                                <span class="avatar-initial rounded-circle bg-label-info">AD</span>
                              </div>
                            </div>
                          </div>
                        </li>`);


                        $("#inputdata").val('');
                        adjustScroll();
                    }
                }).done(function(res) {




                });
            });
        @endif


        $("#filter").keyup(function() {

            // Retrieve the input field text and reset the count to zero
            var filter = $(this).val(),
                count = 0;

            // Loop through the comment list
            $('#chat-list li').each(function() {


                // If the list item does not contain the text phrase fade it out
                if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                    $(this).hide(); // MY CHANGE

                    // Show the list item if the phrase matches and increase the count by 1
                } else {
                    $(this).show(); // MY CHANGE
                    count++;
                }

            });

        });
</script>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Assiatant Chats / {{ $assistant->name }}</span>
            <a href="{{ route('chat.index') }}" class="btn btn-primary"><i class='bx bx-arrow-back bx-sm'></i></a>

        </h4>


    </div>
    <form action="" method="get">
        <div class="row mb-3">
            <div class="col-sm-3 mb-2">
                <input type="date" class="form-control" name="date" value="{{ request('date') }}"
                    placeholder="John Doe">
            </div>
            <div class="col-sm-3 mb-2">
                <select class="form-select" name="country">
                    <option value="">Select Country</option>
                    @foreach (allCountries() as $country)
                    @if (request('country') == $country->name)
                    <option value="{{ $country->name }}" selected>{{ $country->name }}</option>
                    @else
                    <option value="{{ $country->name }}">{{ $country->name }}</option>
                    @endif
                    @endforeach

                </select>
            </div>
            <div class="col-sm-3">
                <button class="btn btn-primary">Filter Chats</button>
                <a href="{{ route('chat.support', $assistant->id) }}" class="btn btn-primary">Reset Filter</a>
            </div>
        </div>
    </form>
</div>


<!-- Content wrapper -->
<div class="content-wrapper">
    <style>
        .chat-contact-list .active {
            background-color: rebeccapurple !important;
        }

        .chat-message-right .chat-message-text {
            background-color: rebeccapurple !important;
        }
    </style>
    <!-- Content -->

    <div class="flex-grow-1">


        <div class="app-chat overflow-hidden card">
            <div class="row g-0">


                <!-- Chat & Contacts -->
                <div class="col app-chat-contacts app-sidebar flex-grow-0 overflow-hidden border-end"
                    id="app-chat-contacts">
                    <div class="sidebar-header pt-3 px-3 mx-1">
                        <div class="d-flex align-items-center me-3 me-lg-0">

                            <div class="flex-grow-1 input-group input-group-merge rounded-pill ms-1">
                                <span class="input-group-text" id="basic-addon-search31"><i
                                        class="bx bx-search fs-4"></i></span>
                                <input type="text" class="form-control chat-search-input" placeholder="Search..."
                                    aria-label="Search..." aria-describedby="basic-addon-search31" id="filter">
                            </div>
                        </div>
                        <i class="bx bx-x cursor-pointer position-absolute top-0 end-0 mt-2 me-1 fs-4 d-lg-none d-block"
                            data-overlay data-bs-toggle="sidebar" data-target="#app-chat-contacts"
                            id="close-contacts"></i>
                    </div>
                    <hr class="container-m-nx mt-3 mb-0">
                    <div class="sidebar-body" style="overflow: auto;">

                        <!-- Chats -->
                        <ul class="list-unstyled chat-contact-list pt-1" id="chat-list">
                            <li class="chat-contact-list-item chat-contact-list-item-title">
                                <h5 class="text-primary mb-0">Customers</h5>
                            </li>

                            @forelse ($chats as $chat)
                            <li
                                class="chat-contact-list-item {{ !empty($chatData) ? ($chatData->id == $chat->id ? 'active' : '') : '' }}">
                                <a href="{{ route('chat.details', ['id' => $chat->id, 'ass_id' => $assistant->id]) }}{{ $_SERVER['QUERY_STRING'] != '' ? '?' . $_SERVER['QUERY_STRING'] : '' }}"
                                    class="d-flex align-items-center">
                                    <div class="flex-shrink-0 avatar avatar-online">
                                        <span class="avatar-initial rounded-circle bg-label-success">CUS</span>
                                    </div>
                                    <div class="chat-contact-info flex-grow-1 ms-3">
                                        @php
                                        $cdata = jsonConvert($chat->customer_data);
                                        @endphp
                                        <h6 class="chat-contact-name text-truncate m-0">
                                            {{ !empty($chat) ? $chat->customer_email : $chat->user_ip }}</h6>
                                        <p class="chat-contact-status text-truncate mb-0 text-muted">
                                            {{ $chat->created_at->diffForHumans() }}</p>
                                    </div>
                                    {{-- <small class="text-muted mb-auto">30 Minutes</small> --}}
                                </a>
                            </li>
                            @empty
                            <li class="chat-contact-list-item chat-list-item-0">
                                <h6 class="text-muted mb-0">No Chats Found</h6>
                            </li>
                            @endforelse

                        </ul>

                    </div>
                </div>
                <!-- /Chat contacts -->

                <!-- Chat History -->
                <div class="col app-chat-history">
                    <div class="chat-history-wrapper">
                        <div class="chat-history-header border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex overflow-hidden align-items-center cursor-pointer">
                                    <i class="bx bx-menu bx-sm cursor-pointer d-lg-none d-block me-2"
                                        data-bs-toggle="sidebar" data-overlay data-target="#app-chat-contacts"
                                        id="show-contacts"></i>
                                    <div class="flex-shrink-0 avatar" data-bs-toggle="modal" data-bs-target="#customerModal">
                                        <span class="avatar-initial rounded-circle bg-label-info">
                                            <i class="bx bx-show"></i></span>
                                    </div>
                                    <div class="chat-contact-info flex-grow-1 ms-3" data-bs-toggle="modal" data-bs-target="#customerModal">
                                        @php
                                        if (!empty($chatData)) {
                                        $cdata = jsonConvert($chatData->customer_data);
                                        }
                                        @endphp
                                        <h6 class="m-0">{{ !empty($chatData) ? $chatData->customer_email : '' }}
                                        </h6>
                                        <small class="user-status text-muted">{{ !empty($chatData) ?
                                            $chatData->created_at : '' }}</small>
                                    </div>
                                    {{-- modal button to show customer data not edit --}}


                                </div>
                                @if (!empty($chatData))
                                <div class="d-flex align-items-center">
                                    <strong style="margin-right:5px">AI Reply </strong>
                                    <div class="btn-group">
                                        <button type="button"
                                            class="btn btn-outline-{{ $chatData->ai_reply == 1 ? 'success' : 'danger' }} dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">{{ $chatData->ai_reply == 1
                                            ? 'ON' : 'OFF'
                                            }}</button>
                                        <ul class="dropdown-menu" style="">
                                            <li><a class="dropdown-item"
                                                    href="{{ route('chat-aistatus', ['id' => $chatData->id, 'status' => 1]) }}">ON</a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('chat-aistatus', ['id' => $chatData->id, 'status' => 0]) }}">OFF</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                @endif

                            </div>

                        </div>
                    </div>




                    <div class="chat-history-body" style="overflow: auto;">
                        <ul class="list-unstyled chat-history mb-0" id="historyChat">
                            @if (!empty($chatData))
                            <li class="chat-message">
                                <div class="d-flex overflow-hidden" style="width: 100%">

                                    <div class="chat-message-wrapper flex-grow-1">
                                        <div class="chat-message-text">
                                            <p class="mb-0">Customer Form Data:
                                                <hr>
                                                @if ($chatData->customer_data)
                                                @foreach (jsonConvert($chatData->customer_data) as $key => $value)
                                                <strong>{{ ucwords(str_replace('_', ' ', $key)) }}
                                                    :</strong>
                                                {{ $value }}<br>
                                                @endforeach
                                                @endif
                                                <strong>User IP :</strong>
                                                {{ $chatData->user_ip }}<br>
                                                @if ($chatData->ip_details != NULL)
                                                @php
                                                $ipData = jsonConvert($chatData->ip_details);
                                                @endphp
                                                @if ($ipData['status'] == 'success')
                                                <strong> Country :</strong> {{ $ipData['country'] }}<br>
                                                <strong> City :</strong> {{ $ipData['city'] }}<br>
                                                @endif

                                                @endif
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </li>
                            @endif
                            @foreach ($oldchats as $oldchat)
                            @if ($oldchat->role == 'user')
                            @include('receive')
                            @else
                            @include('broadcast')
                            @endif
                            @endforeach

                        </ul>
                    </div>


                    @if (!empty($chatData))
                    <!-- Chat message form -->
                    <div class="chat-history-footer">
                        <form class="form-send-message d-flex justify-content-between align-items-center" method="POST"
                            action="{{ route('chat-submit') }}" id="submit-form">
                            {{ csrf_field() }}
                            <input class="form-control message-input border-0 me-3 shadow-none"
                                placeholder="Type your message here..." name="content" id="inputdata">
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
                    @endif


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
<div class="modal" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="chatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="chatModalLabel">Customer Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
            <div class="modal-body pt-0">
                @if (!empty($chatData))
                <hr>
                @if ($chatData->customer_data)
                @foreach (jsonConvert($chatData->customer_data) as $key => $value)
                <strong>{{ ucwords(str_replace('_', ' ', $key)) }}
                    :</strong>
                {{ $value }}<br>
                @endforeach
                @endif
                <strong>User IP :</strong>
                {{ $chatData->user_ip }}<br>
                @if ($chatData->ip_details != NULL)
                @php
                $ipData = jsonConvert($chatData->ip_details);
                @endphp
                @if ($ipData['status'] == 'success')
                <strong> Country :</strong> {{ $ipData['country'] }}<br>
                <strong> City :</strong> {{ $ipData['city'] }}<br>
                @endif
@endif
                @endif
            </div>


        </div>
    </div>
</div>
@endsection