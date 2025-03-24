@can('settings', \App\Models\User::class)
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Settings</span>
    </li>
@endcan

@include('_partials.menus.users')

@can('settings', \App\Models\User::class)
    <li class="menu-item {{ (str_replace ('/', '', request () -> route () -> getPrefix ()) == 'settings') ? 'active open' : '' }}">
        <a class="menu-link menu-toggle" href="javascript:void(0)">
            <i class="menu-icon tf-icons ti ti-settings"></i>
            <div data-i18n="Settings">Settings</div>
        </a>
        <ul class="menu-sub">
            @can('mainMenu', \App\Models\Job::class)
                <li class="menu-item {{ request () -> routeIs ('jobs.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-building-estate"></i>
                        <div data-i18n="Professions">Professions</div>
                    </a>
                    <ul class="menu-sub">
                        @can('all', \App\Models\Job::class)
                            <li class="menu-item {{ request () -> routeIs ('jobs.index') ? 'active' : '' }}">
                                <a href="{{ route ('jobs.index') }}" class="menu-link">
                                    <div data-i18n="All Professions">All Professions</div>
                                </a>
                            </li>
                        @endcan
                        
                        @can('create', \App\Models\Job::class)
                            <li class="menu-item {{ request () -> routeIs ('jobs.create') ? 'active' : '' }}">
                                <a href="{{ route ('jobs.create') }}" class="menu-link">
                                    <div data-i18n="Add Profession">Add Profession</div>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            
            @can('mainMenu', \App\Models\Qualification::class)
                <li class="menu-item {{ request () -> routeIs ('qualifications.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-building-estate"></i>
                        <div data-i18n="Qualifications">Qualifications</div>
                    </a>
                    <ul class="menu-sub">
                        @can('all', \App\Models\Qualification::class)
                            <li class="menu-item {{ request () -> routeIs ('qualifications.index') ? 'active' : '' }}">
                                <a href="{{ route ('qualifications.index') }}" class="menu-link">
                                    <div data-i18n="All Qualifications">All Qualifications</div>
                                </a>
                            </li>
                        @endcan
                        
                        @can('create', \App\Models\Qualification::class)
                            <li class="menu-item {{ request () -> routeIs ('qualifications.create') ? 'active' : '' }}">
                                <a href="{{ route ('qualifications.create') }}" class="menu-link">
                                    <div data-i18n="Add Qualification">Add Qualification</div>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            
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
            
            @can('mainMenu', \App\Models\Vendor::class)
                <li class="menu-item {{ request () -> routeIs ('vendors.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-building-estate"></i>
                        <div data-i18n="Medical Vendors">Medical Vendors</div>
                    </a>
                    <ul class="menu-sub">
                        @can('all', \App\Models\Vendor::class)
                            <li class="menu-item {{ request () -> routeIs ('vendors.index') ? 'active' : '' }}">
                                <a href="{{ route ('vendors.index') }}" class="menu-link">
                                    <div data-i18n="All Medical Vendors">All Medical Vendors</div>
                                </a>
                            </li>
                        @endcan
                        
                        @can('create', \App\Models\Vendor::class)
                            <li class="menu-item {{ request () -> routeIs ('vendors.create') ? 'active' : '' }}">
                                <a href="{{ route ('vendors.create') }}" class="menu-link">
                                    <div data-i18n="Add Medical Vendor">Add Medical Vendor</div>
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
            
            @can('mainMenu', \App\Models\Principal::class)
                <li class="menu-item {{ request () -> routeIs ('principals.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-building-estate"></i>
                        <div data-i18n="Principals">Principals</div>
                    </a>
                    <ul class="menu-sub">
                        @can('all', \App\Models\Principal::class)
                            <li class="menu-item {{ request () -> routeIs ('principals.index') ? 'active' : '' }}">
                                <a href="{{ route ('principals.index') }}" class="menu-link">
                                    <div data-i18n="All Principals">All Principals</div>
                                </a>
                            </li>
                        @endcan
                        
                        @can('create', \App\Models\Principal::class)
                            <li class="menu-item {{ request () -> routeIs ('principals.create') ? 'active' : '' }}">
                                <a href="{{ route ('principals.create') }}" class="menu-link">
                                    <div data-i18n="Add Principal">Add Principal</div>
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
                        <div data-i18n="Companies">Companies</div>
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
            
            @can('mainMenu', \App\Models\Fee::class)
                <li class="menu-item {{ request () -> routeIs ('fees.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-building-estate"></i>
                        <div data-i18n="Fees">Fees</div>
                    </a>
                    <ul class="menu-sub">
                        @can('all', \App\Models\Fee::class)
                            <li class="menu-item {{ request () -> routeIs ('fees.index') ? 'active' : '' }}">
                                <a href="{{ route ('fees.index') }}" class="menu-link">
                                    <div data-i18n="All Fees">All Fees</div>
                                </a>
                            </li>
                        @endcan
                        
                        @can('create', \App\Models\Fee::class)
                            <li class="menu-item {{ request () -> routeIs ('fees.create') ? 'active' : '' }}">
                                <a href="{{ route ('fees.create') }}" class="menu-link">
                                    <div data-i18n="Add Fee">Add Fee</div>
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
                <li class="menu-item {{ request () -> routeIs ('countries.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-building-estate"></i>
                        <div data-i18n="Countries">Countries</div>
                    </a>
                    <ul class="menu-sub">
                        @can('all', \App\Models\Country::class)
                            <li class="menu-item {{ request () -> routeIs ('countries.index') ? 'active' : '' }}">
                                <a href="{{ route ('countries.index') }}" class="menu-link">
                                    <div data-i18n="All Countries">All Countries</div>
                                </a>
                            </li>
                        @endcan
                        
                        @can('create', \App\Models\Country::class)
                            <li class="menu-item {{ request () -> routeIs ('countries.create') ? 'active' : '' }}">
                                <a href="{{ route ('countries.create') }}" class="menu-link">
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
            
            @can('mainMenu', \App\Models\Province::class)
                <li class="menu-item {{ request () -> routeIs ('provinces.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-building-estate"></i>
                        <div data-i18n="Provinces">Provinces</div>
                    </a>
                    <ul class="menu-sub">
                        @can('all', \App\Models\Province::class)
                            <li class="menu-item {{ request () -> routeIs ('provinces.index') ? 'active' : '' }}">
                                <a href="{{ route ('provinces.index') }}" class="menu-link">
                                    <div data-i18n="All Provinces">All Provinces</div>
                                </a>
                            </li>
                        @endcan
                        
                        @can('create', \App\Models\Province::class)
                            <li class="menu-item {{ request () -> routeIs ('provinces.create') ? 'active' : '' }}">
                                <a href="{{ route ('provinces.create') }}" class="menu-link">
                                    <div data-i18n="Add Province">Add Province</div>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            
            @can('mainMenu', \App\Models\District::class)
                <li class="menu-item {{ request () -> routeIs ('districts.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-building-estate"></i>
                        <div data-i18n="Districts">Districts</div>
                    </a>
                    <ul class="menu-sub">
                        @can('all', \App\Models\District::class)
                            <li class="menu-item {{ request () -> routeIs ('districts.index') ? 'active' : '' }}">
                                <a href="{{ route ('districts.index') }}" class="menu-link">
                                    <div data-i18n="All Districts">All Districts</div>
                                </a>
                            </li>
                        @endcan
                        
                        @can('create', \App\Models\District::class)
                            <li class="menu-item {{ request () -> routeIs ('districts.create') ? 'active' : '' }}">
                                <a href="{{ route ('districts.create') }}" class="menu-link">
                                    <div data-i18n="Add District">Add District</div>
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
        </ul>
    </li>
@endcan