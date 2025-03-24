@can('mainMenu', \App\Models\CompanyRequisition::class)
    <li class="menu-item {{ (request () -> routeIs ('company-requisitions.*')) ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti ti-align-box-bottom-right"></i>
            <div data-i18n="MRF">MRF</div>
        </a>
        <ul class="menu-sub">
            @can('all', \App\Models\CompanyRequisition::class)
                <li class="menu-item {{ request () -> routeIs ('company-requisitions.index') ? 'active' : '' }}">
                    <a href="{{ route ('company-requisitions.index') }}" class="menu-link">
                        <div data-i18n="All MRF">All MRF</div>
                    </a>
                </li>
            @endcan
            
            @can('create', \App\Models\CompanyRequisition::class)
                <li class="menu-item {{ request () -> routeIs ('company-requisitions.create') ? 'active' : '' }}">
                    <a href="{{ route ('company-requisitions.create') }}" class="menu-link">
                        <div data-i18n="Add MRF">Add MRF</div>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan