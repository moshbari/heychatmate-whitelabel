<!-- User Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="user-avatar-section">
                        <div class=" d-flex align-items-center flex-column">
                            <img class="img-fluid rounded my-4" src="{{$user->photo?asset('assets/img/profile/'.$user->photo):asset('assets/img/profile/no-photo.png')}}" height="150"
                                width="150" alt="User avatar" />
                            <div class="user-info text-center">
                                <h4 class="mb-2">{{ $user->name }}</h4>
                                {{-- <h4 class="badge bg-label-secondary">Credit Balance: {{$user->credit_balance}}</h4> --}}
                            </div>

                        <div class="w-100 text-center text-primary mt-3">

                                <span>Credit Balance:</span>
                                <h4 class="mb-0 text-primary">{{$user->credit_balance}}</h4>

                        </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around flex-wrap mb-4 py-3">
                        <div class="d-flex align-items-start mt-3 gap-3">
                            <span class="badge bg-label-primary p-2 rounded"><i class='bx bx-user-pin bx-sm'></i></span>
                            <div>
                                <h5 class="mb-0">{{$user->assistant->count()}}</h5>
                                <span>Assistants</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-start me-4 mt-3 gap-3">
                            <span class="badge bg-label-primary p-2 rounded"><i class='bx bx-chat bx-sm'></i></span>
                            <div>
                                <h5 class="mb-0">{{$user->chats->count()}}</h5>
                                <span>Chats Done</span>
                            </div>
                        </div>
                    </div>
                    <h5 class="pb-2 border-bottom mb-4">Details</h5>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <span class="fw-medium me-2">Email:</span>
                                <span>{{ $user->email }}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-medium me-2">Subscription:</span>
                                <span>{!!$user->subscription?'<span class="badge bg-success">'.$user->subscription->plan->name.'</span>':'<span class="badge bg-primary">Not Subscribed</span>'!!}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-medium me-2">Status:</span>
                                @if ($user->status == 1)
                                    <span class="badge bg-label-success">Active</span>
                                @else
                                    <span class="badge bg-label-danger">Suspended</span>
                                @endif

                            </li>
                            
                        </ul>

                        {{-- <div class="d-grid w-100 mt-4 pt-2">
                        <button class="btn btn-primary" data-bs-target="#upgradePlanModal" data-bs-toggle="modal">Login To User
                            Plan</button>
                    </div> --}}

                    </div>
                </div>
            </div>
            <!-- /User Card -->
