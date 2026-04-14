@php
    $containerNav = $containerNav ?? 'container-fluid';
    $navbarDetached = $navbarDetached ?? '';

@endphp

<!-- Navbar -->
@if (isset($navbarDetached) && $navbarDetached == 'navbar-detached')
    <nav class="layout-navbar {{ $containerNav }} navbar navbar-expand-xl {{ $navbarDetached }} align-items-center bg-navbar-theme"
        id="layout-navbar">
@endif
@if (isset($navbarDetached) && $navbarDetached == '')
    <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="{{ $containerNav }}">
@endif

<!--  (display only for navbar-full and hide on below xl) -->
@if (isset($navbarFull))
    <div class="navbar-brand app-brand d-none d-xl-flex py-0 me-4">
        <a href="{{ url('/') }}" class="app-brand-link gap-2">
            <span class="app-brand-logo">
                @include('_partials.macros', ['width' => 25, 'withbg' => '#696cff'])
            </span>
            <span class="app-brand-text menu-text fw-bolder">{{ config('variables.templateName') }}</span>
        </a>
    </div>
@endif

<!-- ! Not required for layout-without-menu -->
@if (!isset($navbarHideToggle))
    <div
        class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ? ' d-xl-none ' : '' }}">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>
@endif

<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <!-- Search -->
    <div class="navbar-nav align-items-center">
        <div class="nav-item d-flex align-items-center">
            <i class="bx bx-search fs-4 lh-0"></i>
            <input type="text" class="form-control border-0 shadow-none" id="tagsdd" placeholder="Search..."
                aria-label="Search...">

        </div>
        <div class="slists">
        </div>
    </div>
    <!-- /Search -->
    <ul class="navbar-nav flex-row align-items-center ms-auto">
        <li class="nav-item m-3"><span class="badge bg-label-dark" style="font-size: 16px">
                <img src="{{ asset('assets/img/icons/brands/credits.png') }}" alt="C" width="23px">
                {{ auth()->user()->credit_balance }}</span>
        </li>
        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                    <img src="{{ auth()->user()->photo ? asset('assets/img/profile/' . auth()->user()->photo) : asset('assets/img/profile/no-photo.png') }}"
                        alt class="w-px-40 h-auto rounded-circle">
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('user.profile') }}">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online">
                                    <img src="{{ auth()->user()->photo ? asset('assets/img/profile/' . auth()->user()->photo) : asset('assets/img/profile/no-photo.png') }}"
                                        alt class="w-px-40 h-auto rounded-circle">
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <span class="fw-semibold d-block">{{ auth()->user()->name }}</span>
                                @if (auth()->user()->type == 'admin')
                                    <small class="text-muted">Admin</small>
                                @endif
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('user.profile') }}">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('user.password') }}">
                        <i class='bx bx-key me-2'></i>
                        <span class="align-middle">Change Password</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('account.billing') }}">
                        <span class="d-flex align-items-center align-middle">
                            <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                            <span class="flex-grow-1 align-middle">Billing</span>
                            {{-- <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span> --}}
                        </span>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('user.logout') }}">
                        <i class='bx bx-power-off me-2'></i>
                        <span class="align-middle">Log Out</span>
                    </a>
                </li>
            </ul>
        </li>
        <!--/ User -->
    </ul>
</div>
@if (!isset($navbarDetached))
    </div>
@endif
</nav>
<!-- / Navbar -->
