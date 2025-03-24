@can('accounts_reporting', \App\Models\GeneralLedger::class)
    <li class="menu-item {{ (str_replace ('/', '', request () -> route () -> getPrefix ()) == 'accounts-reporting') ? 'active open' : '' }}">
        <a class="menu-link menu-toggle" href="javascript:void(0)">
            <i class="menu-icon tf-icons ti ti-report-search"></i>
            <div data-i18n="Accounts Reporting">Accounts Reporting</div>
        </a>
        <ul class="menu-sub">
            @can('trial_balance_sheet', \App\Models\GeneralLedger::class)
                <li class="menu-item {{ request () -> routeIs ('accounts-reporting.trial-balance-sheet') ? 'active' : '' }}">
                    <a href="{{ route ('accounts-reporting.trial-balance-sheet') }}" class="menu-link">
                        <div data-i18n="Trial Balance Sheet">Trial Balance Sheet</div>
                    </a>
                </li>
            @endcan
            
            @can('profit_and_loss', \App\Models\GeneralLedger::class)
                <li class="menu-item {{ request () -> routeIs ('accounts-reporting.profit-and-loss-report') ? 'active' : '' }}">
                    <a href="{{ route ('accounts-reporting.profit-and-loss-report') }}" class="menu-link">
                        <div data-i18n="Profit & Loss">Profit & Loss</div>
                    </a>
                </li>
            @endcan
            
            @can('balance_sheet', \App\Models\GeneralLedger::class)
                <li class="menu-item {{ request () -> routeIs ('accounts-reporting.balance-sheet') ? 'active' : '' }}">
                    <a href="{{ route ('accounts-reporting.balance-sheet') }}" class="menu-link">
                        <div data-i18n="Balance Sheet">Balance Sheet</div>
                    </a>
                </li>
            @endcan
            
            @can('customer_receivable', \App\Models\GeneralLedger::class)
                <li class="menu-item {{ request () -> routeIs ('accounts-reporting.customer-receivable-report') ? 'active' : '' }}">
                    <a href="{{ route ('accounts-reporting.customer-receivable-report') }}" class="menu-link">
                        <div data-i18n="Customer Receivable">Customer Receivable</div>
                    </a>
                </li>
            @endcan
            
            @can('vendor_payable', \App\Models\GeneralLedger::class)
                <li class="menu-item {{ request () -> routeIs ('accounts-reporting.vendor-payable-report') ? 'active' : '' }}">
                    <a href="{{ route ('accounts-reporting.vendor-payable-report') }}" class="menu-link">
                        <div data-i18n="Vendor Payable">Vendor Payable</div>
                    </a>
                </li>
            @endcan
            
            @can('cheque_details_report', \App\Models\User::class)
                <li class="menu-item {{ request () -> routeIs ('accounts-reporting.cheque-details-report') ? 'active' : '' }}">
                    <a href="{{ route ('accounts-reporting.cheque-details-report') }}" class="menu-link">
                        <div data-i18n="Cheque Details Report">Cheque Details Report</div>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcan