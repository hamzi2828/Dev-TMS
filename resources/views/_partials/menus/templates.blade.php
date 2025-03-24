@can('mainMenu', \App\Models\Agreement::class)
    <li class="menu-item {{ (str_replace ('/', '', request () -> route () -> getPrefix ()) == 'templates') ? 'active open' : '' }}">
        <a class="menu-link menu-toggle" href="javascript:void(0)">
            <i class="menu-icon tf-icons ti ti-template"></i>
            <div data-i18n="Templates">Templates</div>
        </a>
        <ul class="menu-sub">
            @can('mainMenu', \App\Models\Agreement::class)
                <li class="menu-item {{ request () -> routeIs ('agreements.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons ti ti-building-estate"></i>
                        <div data-i18n="Agreements">Agreements</div>
                    </a>
                    <ul class="menu-sub">
                        @can('all', \App\Models\Agreement::class)
                            <li class="menu-item {{ request () -> routeIs ('agreements.index') ? 'active' : '' }}">
                                <a href="{{ route ('agreements.index') }}" class="menu-link">
                                    <div data-i18n="All Agreements">All Agreements</div>
                                </a>
                            </li>
                        @endcan
                        
                        @can('create', \App\Models\Agreement::class)
                            <li class="menu-item {{ request () -> routeIs ('agreements.create') ? 'active' : '' }}">
                                <a href="{{ route ('agreements.create') }}" class="menu-link">
                                    <div data-i18n="Add Agreement">Add Agreement</div>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
        </ul>
    </li>
@endcan