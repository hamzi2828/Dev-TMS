@can('myBooking', \App\Models\MyBooking::class)
<li class="menu-item {{ request()->routeIs('myBookings.*') ? 'active open' : '' }}">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-ticket"></i>
        <div data-i18n="My Booking">My Booking</div>
    </a>
    <ul class="menu-sub">
        @can('bookTickets', \App\Models\MyBooking::class)
        <li class="menu-item {{ request()->routeIs('myBookings.index') ? 'active' : '' }}">
            <a href="{{ route('myBookings.index') }}" class="menu-link">
                <div data-i18n="Book Tickets">Book Tickets</div>
            </a>
        </li>
        @endcan
        @can('pendingBooking', \App\Models\MyBooking::class)
        <li class="menu-item {{ request()->routeIs('myBookings.pending') ? 'active' : '' }}">
            <a href="{{ route('myBookings.pending') }}" class="menu-link">
                <div data-i18n="Pending Booking">Pending Booking</div>
            </a>
        </li>
        @endcan
        @can('cancelledBooking', \App\Models\MyBooking::class)
        <li class="menu-item {{ request()->routeIs('myBookings.canceled') ? 'active' : '' }}">
            <a href="{{ route('myBookings.canceled') }}" class="menu-link">
                <div data-i18n="Canceled Booking">Canceled Booking</div>
            </a>
        </li>
        @endcan
        @can('confirmedBooking', \App\Models\MyBooking::class)
        <li class="menu-item {{ request()->routeIs('myBookings.completed') ? 'active' : '' }}">
            <a href="{{ route('myBookings.completed') }}" class="menu-link">
                <div data-i18n="Confirmed Booking">Confirmed Booking</div>
            </a>
        </li>
        @endcan

        @can('myLedger', \App\Models\MyBooking::class)
        <li class="menu-item {{ request()->routeIs('myBookings.myLedger') ? 'active' : '' }}">
            <a href="{{ route('myBookings.myLedger') }}" class="menu-link">
                <div data-i18n="My Ledger">My Ledger</div>
            </a>
        </li>
        @endcan
    </ul>
</li>
@endcan
