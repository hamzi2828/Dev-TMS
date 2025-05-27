<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="app-brand demo">
        <a href="{{ route ('login') }}" class="app-brand-link">
            <img src="{{ asset ('/assets/tms_logo.png') }}" alt="JMS" class="w-px-50">
            <span class="app-brand-text demo menu-text fw-bold">{{ config('app.name') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        @include('_partials.menus.dashboard')
        @include('_partials.menus.accounts')

        @include('_partials.menus.accounts-reporting')
        @include('_partials.menus.accounts-settings')
        @include('_partials.menus.airline-groups')


        @include('_partials.menus.my-bookings')
        @include('_partials.menus.settings')


        @include('_partials.menus.site-settings')




    </ul>
</aside>
<!-- / Menu -->
