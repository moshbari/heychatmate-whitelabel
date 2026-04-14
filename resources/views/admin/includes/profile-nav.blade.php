<!-- User Pills -->
<ul class="nav nav-pills flex-column flex-md-row mb-3">
    <li class="nav-item"><a class="nav-link {{last(request()->segments()) == 'details'?'active':''}}" href="{{ route('user.view', $user->id) }}"><i
                class="bx bx-user me-1"></i>Account</a></li>
    <li class="nav-item"><a class="nav-link {{last(request()->segments()) == 'security'?'active':''}}" href="{{ route('user.security', $user->id) }}"><i
                class="bx bx-lock-alt me-1"></i>Security</a></li>
    <li class="nav-item"><a class="nav-link {{last(request()->segments()) == 'billing'?'active':''}}" href="{{ route('user.billing', $user->id) }}"><i
                class="bx bx-detail me-1"></i>Billing & Plans</a></li>
</ul>
<!--/ User Pills -->
