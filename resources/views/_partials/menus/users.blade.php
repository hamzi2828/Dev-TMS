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