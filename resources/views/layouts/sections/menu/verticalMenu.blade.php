<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- ! Hide app brand if navbar-full -->
    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                @include('_partials.macros', ['width' => 25, 'withbg' => '#696cff'])
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">{{ config('variables.templateName') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-autod-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        {{-- Super Admin Menu --}}
        @if (auth()->user()->role == 'super_admin')
            @foreach ($menuDataSuperAdmin[0]->menu as $menu)
                @if (isset($menu->menuHeader))
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">{{ $menu->menuHeader }}</span>
                    </li>
                @else
                    @php
                        $activeClass = null;
                        $currentRouteName = Route::currentRouteName();
                        if ($currentRouteName === $menu->slug) {
                            $activeClass = 'active';
                        } elseif (isset($menu->submenu)) {
                            if (gettype($menu->slug) === 'array') {
                                foreach ($menu->slug as $slug) {
                                    if (str_contains($currentRouteName, $slug) and strpos($currentRouteName, $slug) === 0) {
                                        $activeClass = 'active open';
                                    }
                                }
                            } else {
                                if (str_contains($currentRouteName, $menu->slug) and strpos($currentRouteName, $menu->slug) === 0) {
                                    $activeClass = 'active open';
                                }
                            }
                        }
                    @endphp
                    <li class="menu-item {{ $activeClass }}">
                        <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
                            class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                            @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                            @isset($menu->icon)
                                <i class="{{ $menu->icon }}"></i>
                            @endisset
                            <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                        </a>
                        @isset($menu->submenu)
                            @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
                        @endisset
                    </li>
                @endif
            @endforeach
        @endif

        {{-- Tenant Owner Menu --}}
        @if (in_array(auth()->user()->role, ['tenant_owner', 'tenant_admin']))
            @foreach ($menuDataTenantOwner[0]->menu as $menu)
                @if (isset($menu->menuHeader))
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">{{ $menu->menuHeader }}</span>
                    </li>
                @else
                    @php
                        $activeClass = null;
                        $currentRouteName = Route::currentRouteName();
                        if ($currentRouteName === $menu->slug) {
                            $activeClass = 'active';
                        } elseif (isset($menu->submenu)) {
                            if (gettype($menu->slug) === 'array') {
                                foreach ($menu->slug as $slug) {
                                    if (str_contains($currentRouteName, $slug) and strpos($currentRouteName, $slug) === 0) {
                                        $activeClass = 'active open';
                                    }
                                }
                            } else {
                                if (str_contains($currentRouteName, $menu->slug) and strpos($currentRouteName, $menu->slug) === 0) {
                                    $activeClass = 'active open';
                                }
                            }
                        }
                    @endphp
                    <li class="menu-item {{ $activeClass }}">
                        <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
                            class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                            @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                            @isset($menu->icon)
                                <i class="{{ $menu->icon }}"></i>
                            @endisset
                            <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                        </a>
                        @isset($menu->submenu)
                            @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
                        @endisset
                    </li>
                @endif
            @endforeach
        @endif

        @if (auth()->user()->type == 'admin')
            @foreach ($menuDataAdmin[0]->menu as $menu)
                {{-- adding active and open class if child is active --}}

                {{-- menu headers --}}
                @if (isset($menu->menuHeader))
                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">{{ $menu->menuHeader }}</span>
                    </li>
                @else
                    {{-- active menu method --}}
                    @php
                        $activeClass = null;
                        $currentRouteName = Route::currentRouteName();
                        //dd($menu->slug);
                        if ($currentRouteName === $menu->slug) {
                            $activeClass = 'active';
                        } elseif (isset($menu->submenu)) {
                            if (gettype($menu->slug) === 'array') {
                                foreach ($menu->slug as $slug) {
                                    if (str_contains($currentRouteName, $slug) and strpos($currentRouteName, $slug) === 0) {
                                        $activeClass = 'active open';
                                    }
                                }
                            } else {
                                if (str_contains($currentRouteName, $menu->slug) and strpos($currentRouteName, $menu->slug) === 0) {
                                    $activeClass = 'active open';
                                }
                            }
                        }
                    @endphp

                    {{-- main menu --}}
                    <li class="menu-item {{ $activeClass }}">
                        <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
                            class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                            @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                            @isset($menu->icon)
                                <i class="{{ $menu->icon }}"></i>
                            @endisset
                            <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                        </a>

                        {{-- submenu --}}
                        @isset($menu->submenu)
                            @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
                        @endisset
                    </li>
                @endif
            @endforeach

        @endif




        @foreach ($menuData[0]->menu as $menu)
            {{-- adding active and open class if child is active --}}

            {{-- menu headers --}}
            @if (isset($menu->menuHeader))
                <li class="menu-header small text-uppercase">
                    <span class="menu-header-text">{{ $menu->menuHeader }}</span>
                </li>
            @else
                {{-- active menu method --}}
                @php
                    $activeClass = null;
                    $currentRouteName = Route::currentRouteName();
                    //dd($menu->slug);
                    if ($currentRouteName === $menu->slug) {
                        $activeClass = 'active';
                    } elseif (isset($menu->submenu)) {
                        if (gettype($menu->slug) === 'array') {
                            foreach ($menu->slug as $slug) {
                                if (str_contains($currentRouteName, $slug) and strpos($currentRouteName, $slug) === 0) {
                                    $activeClass = 'active open';
                                }
                            }
                        } else {
                            if (str_contains($currentRouteName, $menu->slug) and strpos($currentRouteName, $menu->slug) === 0) {
                                $activeClass = 'active open';
                            }
                        }
                    }
                @endphp

                {{-- main menu --}}
                <li class="menu-item {{ $activeClass }}">
                    <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
                        class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
                        @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
                        @isset($menu->icon)
                            <i class="{{ $menu->icon }}"></i>
                        @endisset
                        <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
                    </a>

                    {{-- submenu --}}
                    @isset($menu->submenu)
                        @include('layouts.sections.menu.submenu', ['menu' => $menu->submenu])
                    @endisset
                </li>
            @endif
        @endforeach

        @if (auth()->user()->hasActiveSubscription())
            @if (auth()->user()->subscription->plan->api_type === 'user')
                <li class="menu-item ">
                    <a href="{{ route('user.config') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-cog"></i>
                        <div>API Settings</div>
                    </a>
                </li>
            @endif

        @endif
    </ul>

</aside>
