@can('airlineGroups', \App\Models\AirlineGroup::class)
    <li class="menu-item {{ request()->routeIs('airlineGroups.*') ? 'active open' : '' }}">
        <a class="menu-link menu-toggle" href="javascript:void(0)">
            <i class="menu-icon tf-icons ti ti-plane-departure"></i>
            <div data-i18n="Airline Groups">Airline Groups</div>
        </a>
        <ul class="menu-sub">
            @can('all-airline-groups', \App\Models\AirlineGroup::class)
                <li class="menu-item {{ request()->routeIs('airlineGroups.index') && !request()->has('inactive') ? 'active' : '' }}">
                    <a href="{{ route('airlineGroups.index') }}" class="menu-link">
                        <div data-i18n="All Airline Groups">All Airline Groups</div>
                    </a>
                </li>
            @endcan

            @can('inactive-airline-groups', \App\Models\AirlineGroup::class)
                <li class="menu-item {{ request()->routeIs('airlineGroups.index') && request()->query('inactive') === 'true' ? 'active' : '' }}">
                    <a href="{{ route('airlineGroups.index', ['inactive' => 'true']) }}" class="menu-link">
                        <div data-i18n="Airline Groups (Inactive)">Airline Groups (Inactive)</div>
                    </a>
                </li>
            @endcan

            @can('flown-airline-groups', \App\Models\AirlineGroup::class)
                <li class="menu-item {{ request()->routeIs('airlineGroups.flown') ? 'active' : '' }}">
                    <a href="{{ route('airlineGroups.flown') }}" class="menu-link">
                        <div data-i18n="Airline Groups (Flown)">Airline Groups (Flown)</div>
                    </a>
                </li>
            @endcan

            @can('add-airline-groups', \App\Models\AirlineGroup::class)
                <li class="menu-item {{ request()->routeIs('airlineGroups.create') ? 'active' : '' }}">
                    <a href="{{ route('airlineGroups.create') }}" class="menu-link">
                        <div data-i18n="Add Airline Group">Add Airline Group</div>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan
