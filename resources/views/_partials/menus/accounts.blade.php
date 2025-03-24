@can('mainMenu', \App\Models\Account::class)
    <li class="menu-item {{ request () -> routeIs ('accounts.*') ? 'active open' : '' }}">
        <a class="menu-link menu-toggle" href="javascript:void(0)">
            <i class="menu-icon tf-icons ti ti-wallet"></i>
            <div data-i18n="Accounts">Accounts</div>
        </a>
        <ul class="menu-sub">
            @can('all', \App\Models\Account::class)
                <li class="menu-item {{ request () -> routeIs ('accounts.chart-of-accounts') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route ('accounts.chart-of-accounts') }}">
                        <div data-i18n="Chart of Accounts">Chart of Accounts</div>
                    </a>
                </li>
            @endcan
            
            @can('create', \App\Models\Account::class)
                <li class="menu-item {{ request () -> routeIs ('accounts.create') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route ('accounts.create') }}">
                        <div data-i18n="Add Accounts Heads">Add Accounts Heads</div>
                    </a>
                </li>
            @endcan
            
            @can('all', \App\Models\GeneralLedger::class)
                <li class="menu-item {{ request () -> routeIs ('accounts.general-ledgers') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route ('accounts.general-ledgers') }}">
                        <div data-i18n="General Ledgers">General Ledgers</div>
                    </a>
                </li>
            @endcan
            
            @can('create', \App\Models\GeneralLedger::class)
                <li class="menu-item {{ request () -> routeIs ('accounts.add-transactions') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route ('accounts.add-transactions') }}">
                        <div data-i18n="Add Transactions">Add Transactions</div>
                    </a>
                </li>
            @endcan
            
            @can('search', \App\Models\GeneralLedger::class)
                <li class="menu-item {{ request () -> routeIs ('accounts.search-transactions') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route ('accounts.search-transactions') }}">
                        <div data-i18n="Search Transactions">Search Transactions</div>
                    </a>
                </li>
            @endcan
            
            @can('add_multiple', \App\Models\GeneralLedger::class)
                <li class="menu-item {{ request () -> routeIs ('accounts.add-multiple-transactions') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route ('accounts.add-multiple-transactions') }}">
                        <div data-i18n="Add Transactions (Multiple)">Add Transactions (Multiple)</div>
                    </a>
                </li>
            @endcan
            
            @can('add_opening_balance', \App\Models\GeneralLedger::class)
                <li class="menu-item {{ request () -> routeIs ('accounts.add-opening-balance') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route ('accounts.add-opening-balance') }}">
                        <div data-i18n="Add Opening Balance">Add Opening Balance</div>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan
