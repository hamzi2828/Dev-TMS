@can('accounts_settings', \App\Models\Account::class)
    <li class="menu-item {{ (str_replace ('/', '', request () -> route () -> getPrefix ()) == 'account-settings') ? 'active open' : '' }}">
        <a class="menu-link menu-toggle" href="javascript:void(0)">
            <i class="menu-icon tf-icons ti ti-settings-dollar"></i>
            <div data-i18n="Account Settings">Account Settings</div>
        </a>
        <ul class="menu-sub">
            @can('mainMenu', \App\Models\AccountType::class)
                <li class="menu-item {{ request () -> routeIs ('account-types.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-building-estate"></i>
                        <div data-i18n="Account Types">Account Types</div>
                    </a>
                    <ul class="menu-sub">
                        @can('all', \App\Models\AccountType::class)
                            <li class="menu-item {{ request () -> routeIs ('account-types.index') ? 'active' : '' }}">
                                <a href="{{ route ('account-types.index') }}" class="menu-link">
                                    <div data-i18n="All Account Types">All Account Types</div>
                                </a>
                            </li>
                        @endcan

                        @can('create', \App\Models\AccountType::class)
                            <li class="menu-item {{ request () -> routeIs ('account-types.create') ? 'active' : '' }}">
                                <a href="{{ route ('account-types.create') }}" class="menu-link">
                                    <div data-i18n="Add Account Types">Add Account Types</div>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
        </ul>
    </li>
@endcan
