<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="app-brand demo">
        <a href="{{ route ('login') }}" class="app-brand-link">
            <img src="{{ asset ('/assets/tms_logo.png') }}" alt="JMS" class="w-px-50">
            <span class="app-brand-text demo menu-text fw-bold">{{ config('app.name') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @include('_partials.menus.dashboard')
        @include('_partials.menus.accounts')

        @include('_partials.menus.accounts-settings')

        @include('_partials.menus.accounts-reporting')

                {{-- @can('mainMenu', \App\Models\AirlineGroup::class) --}}
                <li class="menu-item {{ request()->routeIs('airlineGroups.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-plane-departure"></i>
                        <div data-i18n="Airline Groups">Airline Groups</div>
                    </a>
                    <ul class="menu-sub">
                        {{-- @can('all', \App\Models\AirlineGroup::class) --}}
                            <li class="menu-item {{ request()->routeIs('airlineGroups.index') ? 'active' : '' }}">
                                <a href="{{ route('airlineGroups.index') }}" class="menu-link">
                                    <div data-i18n="All Airline Groups">All Airline Groups</div>
                                </a>
                            </li>
                        {{-- @endcan --}}

                        {{-- @can('create', \App\Models\AirlineGroup::class) --}}
                            <li class="menu-item {{ request()->routeIs('airlineGroups.create') ? 'active' : '' }}">
                                <a href="{{ route('airlineGroups.create') }}" class="menu-link">
                                    <div data-i18n="Add Airline Group">Add Airline Group</div>
                                </a>
                            </li>
                        {{-- @endcan --}}
                    </ul>
                </li>
            {{-- @endcan --}}

            <li class="menu-item {{ request()->routeIs('myBookings.*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-ticket"></i>
                    <div data-i18n="My Booking">My Booking</div>
                </a>
                <ul class="menu-sub">
                    {{-- @can('all', \App\Models\AirlineGroup::class) --}}
                        <li class="menu-item {{ request()->routeIs('myBookings.index') ? 'active' : '' }}">
                            <a href="{{ route('myBookings.index') }}" class="menu-link">
                                <div data-i18n="Book Tickets"> Book Tickets</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('myBookings.pending') ? 'active' : '' }}">
                            <a href="{{ route('myBookings.pending') }}" class="menu-link">
                                <div data-i18n="Pending Booking">Pending Booking</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('myBookings.canceled') ? 'active' : '' }}">
                            <a href="{{ route('myBookings.canceled') }}" class="menu-link">
                                <div data-i18n="Canceled Booking">Canceled Booking</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('myBookings.completed') ? 'active' : '' }}">
                            <a href="{{ route('myBookings.completed') }}" class="menu-link">
                                <div data-i18n="Confirmed Booking">Confirmed Booking</div>
                            </a>

                    {{-- @endcan --}}

                </ul>
            </li>
        @include('_partials.menus.settings')


        @include('_partials.menus.site-settings')




    </ul>
</aside>
<!-- / Menu -->
