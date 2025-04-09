@can('settings', \App\Models\User::class)
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Settings</span>
    </li>
@endcan

{{-- @include('_partials.menus.users') --}}

@can('settings', \App\Models\User::class)
    <li class="menu-item {{ request()->is('settings*') || request()->is('users*') ? 'active open' : '' }}">
        <a class="menu-link menu-toggle" href="javascript:void(0)">
            <i class="menu-icon tf-icons ti ti-settings"></i>
            <div data-i18n="Settings">Settings</div>
        </a>
        <ul class="menu-sub">

            @can('mainMenu', \App\Models\Bank::class)
                <li class="menu-item {{ request () -> routeIs ('banks.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-building-estate"></i>
                        <div data-i18n="Banks">Banks</div>
                    </a>
                    <ul class="menu-sub">
                        @can('all', \App\Models\Bank::class)
                            <li class="menu-item {{ request () -> routeIs ('banks.index') ? 'active' : '' }}">
                                <a href="{{ route ('banks.index') }}" class="menu-link">
                                    <div data-i18n="All Banks">All Banks</div>
                                </a>
                            </li>
                        @endcan

                        @can('create', \App\Models\Bank::class)
                            <li class="menu-item {{ request () -> routeIs ('banks.create') ? 'active' : '' }}">
                                <a href="{{ route ('banks.create') }}" class="menu-link">
                                    <div data-i18n="Add Bank">Add Bank</div>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('mainMenu', \App\Models\PaymentMethod::class)
                <li class="menu-item {{ request () -> routeIs ('payment-methods.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-building-estate"></i>
                        <div data-i18n="Payment Methods">Payment Methods</div>
                    </a>
                    <ul class="menu-sub">
                        @can('all', \App\Models\PaymentMethod::class)
                            <li class="menu-item {{ request () -> routeIs ('payment-methods.index') ? 'active' : '' }}">
                                <a href="{{ route ('payment-methods.index') }}" class="menu-link">
                                    <div data-i18n="All Payment Methods">All Payment Methods</div>
                                </a>
                            </li>
                        @endcan

                        @can('create', \App\Models\PaymentMethod::class)
                            <li class="menu-item {{ request () -> routeIs ('payment-methods.create') ? 'active' : '' }}">
                                <a href="{{ route ('payment-methods.create') }}" class="menu-link">
                                    <div data-i18n="Add Payment Method">Add Payment Method</div>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan



            @can('mainMenu', \App\Models\Agent::class)
                <li class="menu-item {{ request () -> routeIs ('agents.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-building-estate"></i>
                        <div data-i18n="Travel Agents">Travel Agents</div>
                    </a>
                    <ul class="menu-sub">
                        @can('all', \App\Models\Agent::class)
                            <li class="menu-item {{ request () -> routeIs ('agents.index') ? 'active' : '' }}">
                                <a href="{{ route ('agents.index') }}" class="menu-link">
                                    <div data-i18n="All Travel Agents">All Travel Agents</div>
                                </a>
                            </li>
                        @endcan

                        @can('create', \App\Models\Agent::class)
                            <li class="menu-item {{ request () -> routeIs ('agents.create') ? 'active' : '' }}">
                                <a href="{{ route ('agents.create') }}" class="menu-link">
                                    <div data-i18n="Add Travel Agent">Add Travel Agent</div>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('mainMenu', \App\Models\Referral::class)
                <li class="menu-item {{ request () -> routeIs ('referrals.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-building-estate"></i>
                        <div data-i18n="Referrals">Referrals</div>
                    </a>
                    <ul class="menu-sub">
                        @can('all', \App\Models\Principal::class)
                            <li class="menu-item {{ request () -> routeIs ('referrals.index') ? 'active' : '' }}">
                                <a href="{{ route ('referrals.index') }}" class="menu-link">
                                    <div data-i18n="All Referrals">All Referrals</div>
                                </a>
                            </li>
                        @endcan

                        @can('create', \App\Models\Principal::class)
                            <li class="menu-item {{ request () -> routeIs ('referrals.create') ? 'active' : '' }}">
                                <a href="{{ route ('referrals.create') }}" class="menu-link">
                                    <div data-i18n="Add Referral">Add Referral</div>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('mainMenu', \App\Models\Company::class)
                <li class="menu-item {{ request () -> routeIs ('companies.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-building-estate"></i>
                        <div data-i18n="Companies">Airline GP Supplier</div>
                    </a>
                    <ul class="menu-sub">
                        @can('all', \App\Models\Company::class)
                            <li class="menu-item {{ request () -> routeIs ('companies.index') ? 'active' : '' }}">
                                <a href="{{ route ('companies.index') }}" class="menu-link">
                                    <div data-i18n="All Companies">All Companies</div>
                                </a>
                            </li>
                        @endcan

                        @can('create', \App\Models\Company::class)
                            <li class="menu-item {{ request () -> routeIs ('companies.create') ? 'active' : '' }}">
                                <a href="{{ route ('companies.create') }}" class="menu-link">
                                    <div data-i18n="Add Company">Add Company</div>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('mainMenu', \App\Models\Airline::class)
                <li class="menu-item {{ request () -> routeIs ('airlines.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-building-estate"></i>
                        <div data-i18n="Airlines">Airlines</div>
                    </a>
                    <ul class="menu-sub">
                        @can('all', \App\Models\Airline::class)
                            <li class="menu-item {{ request () -> routeIs ('airlines.index') ? 'active' : '' }}">
                                <a href="{{ route ('airlines.index') }}" class="menu-link">
                                    <div data-i18n="All Airlines">All Airlines</div>
                                </a>
                            </li>
                        @endcan

                        @can('create', \App\Models\Airline::class)
                            <li class="menu-item {{ request () -> routeIs ('airlines.create') ? 'active' : '' }}">
                                <a href="{{ route ('airlines.create') }}" class="menu-link">
                                    <div data-i18n="Add Airline">Add Airline</div>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('mainMenu', \App\Models\Country::class)
                <li class="menu-item {{ request()->routeIs('countries.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-building-estate"></i>
                        <div data-i18n="Countries">Countries</div>
                    </a>
                    <ul class="menu-sub">
                        @can('all', \App\Models\Country::class)
                            <li class="menu-item {{ request()->routeIs('countries.index') ? 'active' : '' }}">
                                <a href="{{ route('countries.index') }}" class="menu-link">
                                    <div data-i18n="All Countries">All Countries</div>
                                </a>
                            </li>
                        @endcan

                        @can('create', \App\Models\Country::class)
                            <li class="menu-item {{ request()->routeIs('countries.create') ? 'active' : '' }}">
                                <a href="{{ route('countries.create') }}" class="menu-link">
                                    <div data-i18n="Add Country">Add Country</div>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('mainMenu', \App\Models\City::class)
                <li class="menu-item {{ request () -> routeIs ('cities.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-building-estate"></i>
                        <div data-i18n="Cities">Cities</div>
                    </a>
                    <ul class="menu-sub">
                        @can('all', \App\Models\City::class)
                            <li class="menu-item {{ request () -> routeIs ('cities.index') ? 'active' : '' }}">
                                <a href="{{ route ('cities.index') }}" class="menu-link">
                                    <div data-i18n="All Cities">All Cities</div>
                                </a>
                            </li>
                        @endcan

                        @can('create', \App\Models\City::class)
                            <li class="menu-item {{ request () -> routeIs ('cities.create') ? 'active' : '' }}">
                                <a href="{{ route ('cities.create') }}" class="menu-link">
                                    <div data-i18n="Add City">Add City</div>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('mainMenu', \App\Models\User::class)
                <li class="menu-item {{ request () -> routeIs ('users.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-users"></i>
                        <div data-i18n="Users">Users</div>
                    </a>
                    <ul class="menu-sub">
                        @can('all', \App\Models\User::class)
                            <li class="menu-item {{ request () -> routeIs ('users.index') ? 'active' : '' }}">
                                <a href="{{ route ('users.index') }}" class="menu-link">
                                    <div data-i18n="All Users">All Users</div>
                                </a>
                            </li>
                        @endcan
                        
                        @can('create', \App\Models\User::class)
                            <li class="menu-item {{ request () -> routeIs ('users.create') ? 'active' : '' }}">
                                <a href="{{ route ('users.create') }}" class="menu-link">
                                    <div data-i18n="Add User">Add User</div>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('mainMenu', \App\Models\Role::class)
                <li class="menu-item {{ request () -> routeIs ('roles.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-settings"></i>
                        <div data-i18n="Roles">Roles</div>
                    </a>
                    <ul class="menu-sub">
                        @can('all', \App\Models\Role::class)
                            <li class="menu-item {{ request () -> routeIs ('roles.index') ? 'active' : '' }}">
                                <a href="{{ route ('roles.index') }}" class="menu-link">
                                    <div data-i18n="All Roles">All Roles</div>
                                </a>
                            </li>
                        @endcan

                        @can('create', \App\Models\Role::class)
                            <li class="menu-item {{ request () -> routeIs ('roles.create') ? 'active' : '' }}">
                                <a href="{{ route ('roles.create') }}" class="menu-link">
                                    <div data-i18n="Add Roles">Add Roles</div>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            {{-- @can('mainMenu', \App\Models\Section::class) --}}
                <li class="menu-item {{ request()->routeIs('sections.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-section"></i>
                        <div data-i18n="Sectors">Sector</div>
                    </a>
                    <ul class="menu-sub">
                        {{-- @can('all', \App\Models\Section::class) --}}
                            <li class="menu-item {{ request()->routeIs('sections.index') ? 'active' : '' }}">
                                <a href="{{ route('sections.index') }}" class="menu-link">
                                    <div data-i18n="All Sectors">All Sector</div>
                                </a>
                            </li>
                        {{-- @endcan --}}

                        {{-- @can('create', \App\Models\Section::class) --}}
                            <li class="menu-item {{ request()->routeIs('sections.create') ? 'active' : '' }}">
                                <a href="{{ route('sections.create') }}" class="menu-link">
                                    <div data-i18n="Add Sector">Add Sector</div>
                                </a>
                            </li>
                        {{-- @endcan --}}
                    </ul>
                </li>
            {{-- @endcan --}}
        </ul>
    </li>
@endcan