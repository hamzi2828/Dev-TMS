<li class="menu-item {{ request () -> routeIs ('home') ? 'active' : '' }}">
    <a href="{{ route ('home') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-smart-home"></i>
        <div data-i18n="Home">Home</div>
    </a>
</li>
@can('dashboard', \App\Models\User::class)
    <li class="menu-item {{ request () -> routeIs ('dashboard') ? 'active' : '' }}">
        <a href="{{ route ('dashboard', ['current-month' => 'true', 'start-date' => date ('Y-m-d'), 'end-date' => date ('Y-m-d')]) }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-device-desktop-analytics"></i>
            <div data-i18n="Dashboard">Dashboard</div>
        </a>
    </li>
@endcan