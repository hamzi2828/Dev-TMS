@can('menu', \App\Models\DataBank::class)
    <li class="menu-item {{ request () -> routeIs ('data-banks.*') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-database"></i>
            <div data-i18n="Data Banks">Data Banks</div>
        </a>
        <ul class="menu-sub">
            @can('all', \App\Models\DataBank::class)
                <li class="menu-item {{ request () -> routeIs ('data-banks.index') ? 'active' : '' }}">
                    <a href="{{ route ('data-banks.index') }}" class="menu-link">
                        <div data-i18n="All Data Banks">All Data Banks</div>
                    </a>
                </li>
            @endcan
            
            @can('create', \App\Models\DataBank::class)
                <li class="menu-item {{ request () -> routeIs ('data-banks.create') ? 'active' : '' }}">
                    <a href="{{ route ('data-banks.create') }}" class="menu-link">
                        <div data-i18n="Add Data Bank">Add Data Bank</div>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan
