@can('create', \App\Models\SiteSetting::class)
    <li class="menu-item {{ request () -> routeIs ('site-settings.*') ? 'active' : '' }}">
        <a href="{{ route ('site-settings.create') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-settings-cog"></i>
            <div data-i18n="Site Settings">Site Settings</div>
        </a>
    </li>
@endcan