@can('reporting', \App\Models\User::class)
    <li class="menu-item {{ (str_replace ('/', '', request () -> route () -> getPrefix ()) == 'reporting') ? 'active open' : '' }}">
        <a class="menu-link menu-toggle" href="javascript:void(0)">
            <i class="menu-icon tf-icons ti ti-report"></i>
            <div data-i18n="Reporting">Reporting</div>
        </a>
        <ul class="menu-sub">
            @can('status_check', \App\Models\User::class)
                <li class="menu-item {{ request () -> routeIs ('reporting.status-check') ? 'active' : '' }}">
                    <a href="{{ route ('reporting.status-check') }}" class="menu-link">
                        <div data-i18n="Status Check (Detail)">Status Check (Detail)</div>
                    </a>
                </li>
            @endcan
            @can('summary_report', \App\Models\User::class)
                <li class="menu-item {{ request () -> routeIs ('reporting.summary-report') ? 'active' : '' }}">
                    <a href="{{ route ('reporting.summary-report') }}" class="menu-link">
                        <div data-i18n="Summary Report">Summary Report</div>
                    </a>
                </li>
            @endcan
            @can('follow_up_report', \App\Models\User::class)
                <li class="menu-item {{ request () -> routeIs ('reporting.follow-up-report') ? 'active' : '' }}">
                    <a href="{{ route ('reporting.follow-up-report') }}" class="menu-link">
                        <div data-i18n="Follow Up Report">Follow Up Report</div>
                    </a>
                </li>
            @endcan
            @can('missing_docs_report', \App\Models\User::class)
                <li class="menu-item {{ request () -> routeIs ('reporting.missing-docs-report') ? 'active' : '' }}">
                    <a href="{{ route ('reporting.missing-docs-report') }}" class="menu-link">
                        <div data-i18n="Missing Docs Report">Missing Docs Report</div>
                    </a>
                </li>
            @endcan
            @can('gross_profit_report', \App\Models\User::class)
                <li class="menu-item {{ request () -> routeIs ('reporting.gross-profit-report') ? 'active' : '' }}">
                    <a href="{{ route ('reporting.gross-profit-report') }}" class="menu-link">
                        <div data-i18n="Gross Profit Report">Gross Profit Report</div>
                    </a>
                </li>
            @endcan
            @can('qj_medical_report', \App\Models\User::class)
                <li class="menu-item {{ request () -> routeIs ('reporting.qj-medical-report') ? 'active' : '' }}">
                    <a href="{{ route ('reporting.qj-medical-report') }}" class="menu-link">
                        <div data-i18n="QJ Medical Report">QJ Medical Report</div>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan
