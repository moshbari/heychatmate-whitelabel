<!-- User Card -->
<div class="card mb-4">
    <div class="card-body">
        <div class="user-avatar-section">
            <div class=" d-flex align-items-center flex-column">
                <img class="img-fluid rounded my-4"
                    src="{{ $user->photo ? asset('assets/img/profile/' . $user->photo) : asset('assets/img/profile/no-photo.png') }}"
                    height="150" width="150" alt="User avatar" />
                <div class="user-info text-center">
                    <h4 class="mb-2">{{ $user->name }}</h4>
                    {{-- <h4 class="badge bg-label-secondary">Credit Balance: {{$user->credit_balance}}</h4> --}}
                </div>

                <div class="w-100 text-center text-primary mt-3">

                    <span>Credit Balance:</span>
                    <h4 class="mb-0 text-primary">{{ $user->credit_balance }}</h4>
                    <button class="btn btn-warning btn-xs" data-bs-toggle="modal"
                        data-bs-target="#upgradeBalanceModal"><i class="bx bx-cog"></i> Modify Balance</button>

                </div>
            </div>
        </div>
        <div class="d-flex justify-content-around flex-wrap mb-4 py-3">
            <div class="d-flex align-items-start mt-3 gap-3">
                <span class="badge bg-label-primary p-2 rounded"><i class='bx bx-user-pin bx-sm'></i></span>
                <div>
                    <h5 class="mb-0">{{ $user->assistant->count() }}</h5>
                    <span>Assistants</span>
                </div>
            </div>
            <div class="d-flex align-items-start me-4 mt-3 gap-3">
                <span class="badge bg-label-primary p-2 rounded"><i class='bx bx-chat bx-sm'></i></span>
                <div>
                    <h5 class="mb-0">{{ $user->chats->count() }}</h5>
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
                    <span>{!! $user->subscription
                        ? '<span class="badge bg-success">' . $user->subscription->plan->name . '</span>'
                        : '<span class="badge bg-primary">Not Subscribed</span>' !!}</span>
                </li>
                <li class="mb-3">
                    <span class="fw-medium me-2">Status:</span>
                    @if ($user->status == 1)
                        <span class="badge bg-label-success">Active</span>
                    @else
                        <span class="badge bg-label-danger">Suspended</span>
                    @endif

                </li>
                <li class="mb-3">
                    <span class="fw-medium me-2">Role:</span>
                    <span>{{ ucfirst($user->type) }}</span>
                </li>
                <li class="mb-3">
                    <span class="fw-medium me-2">Phone:</span>
                    <span>{{ $user->phone }}</span>
                </li>
                <li class="mb-3">
                    <span class="fw-medium me-2">Country:</span>
                    <span>{{ $user->countryData->name }}</span>
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



<div class="modal fade" id="upgradeBalanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple modal-upgrade-plan">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3>Manage Credit Balance</h3>
                </div>
                <form class="row g-3" action="{{ route('user.balance', $user->id) }}" method="post">
                    @csrf
                    <div class="col-sm-12">
                        <div class="mb-3">
                            <label class="form-label" for="chooseoperation">Modify Balance</label>
                            <select id="chooseoperation" name="operation" class="form-select"
                                aria-label="Modify Balance" required>
                                <option value="">Choose Operation</option>
                                <option value="add">Add</option>
                                <option value="subtract">Subtract</option>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Balance Amount</label>
                            <input type="number" name="amount" class="form-control" min="1" value="0"
                                id="exampleFormControlInput1" placeholder="Enter Amount to Modify" required />
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Change</button>
                    </div>
                </form>
            </div>
            <hr class="mx-md-n5 mx-n3">
            <div class="modal-body">
                <h6 class="mb-0">User current Balance:</h6>
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex justify-content-center me-2 mt-3">
                        <h1 class="display-3 mb-0 text-primary">{{ $user->credit_balance }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
