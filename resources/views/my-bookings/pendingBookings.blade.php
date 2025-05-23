<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        @include('my-bookings.search')

        <!-- Airline Groups Table -->
        <div class="card">
            <div class="card-header border-bottom pt-3 pb-3 d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">{{ $title }}</h5>
                <a href="javascript:void(0)" onclick="downloadExcel('My Booking List')" class="btn btn-sm btn-primary">
                    <i class="tf-icons ti ti-file-spreadsheet fs-6 me-1"></i>
                    Download Excel
                </a>
            </div>
            <div class="card-datatable table-responsive">
                <table class="table table-hover table-sm table-bordered" id="excel-table">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. No.</th>
                            <th style="min-width: 200px">Booking Ref</th>
                            <th style="min-width: 200px">Passengers</th>
                            <th style="min-width: 130px">Dep. Date</th>
                            <th style="min-width: 100px">Airline</th>
                            <th style="min-width: 100px">Flight No.</th>
                            <th style="min-width: 170px">Origin - Dest.</th>
                            <th style="min-width: 130px">Dep - Arr.</th>
                            <th style="min-width: 60px">Bag</th>
                            <th style="min-width: 60px">Meal</th>
                            <th style="min-width: 100px">Total <br> Price</th>
                            <th style="min-width: 100px">Expiry <br> Time</th>
                            <th style="min-width: 100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($myBookings as $booking)
                            @php $group = $booking->airlineGroup; @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div><strong>{{ $booking->booking_reference }}</strong></div>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y, H:i A') }}
                                    </small>
                                    <div>{{ \App\Models\Agent::find($booking->user->agent_id)->name ?? 'N/A' }}</div>
                                </td>
                                <td>
                                    @foreach($booking->passengers as $passenger)
                                        {{ $passenger->title }} {{ $passenger->surname }} {{ $passenger->given_name }}<br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($group->segments as $segment)
                                        <div>{{ \Carbon\Carbon::parse($segment->departure_date)->format('d M Y') }}</div>
                                    @endforeach
                                </td>
                                <td>
                                    @if(!empty(trim($booking->airline->file)))
                                        <img src="{{ $booking->airline->file }}" alt="Airline Logo" width="70" height="30">
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @foreach($group->segments as $segment)
                                        <div>{{ $segment->flight_number }}</div>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($group->segments as $segment)
                                        <div>{{ \App\Models\City::find($segment->origin)->title ?? 'N/A' }} - {{ \App\Models\City::find($segment->destination)->title ?? 'N/A' }}</div>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($group->segments as $segment)
                                        <div>{{ \Carbon\Carbon::parse($segment->departure_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($segment->arrival_time)->format('H:i') }}</div>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($group->segments as $segment)
                                        <div>{{ $segment->baggage }}</div>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($group->segments as $segment)
                                        <div>{{ ucfirst($segment->meal) }}</div>
                                    @endforeach
                                </td>
                                <td>
                                    @if($booking->total_price)
                                        {{ number_format($booking->total_price, 2) }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    <span id="timer-{{ $booking->id }}" class="badge bg-success fs-6">Loading... </span>
                                    <div class="text-muted small mt-1">
                                        {{ optional($booking->airlineGroup)->expire_datetime
                                            ? \Carbon\Carbon::parse($booking->airlineGroup->expire_datetime)->format('d M Y, H:i A')
                                            : 'N/A' }}
                                    </div>
                                </td>

                                <td>
                                    <a href="javascript:void(0)" onclick="confirmWithPNR('{{ route('myBookings.confirmBooking', ['id' => $booking->id, 'pnr' => '']) }}')" class="btn btn-sm btn-info" style="width: 70px;">
                                        Confirm
                                    </a>
                                    <a href="javascript:void(0)" onclick="confirmCancel('{{ route('myBookings.canceleBooking', ['id' => $booking->id]) }}')" class="btn btn-sm btn-danger mt-1" style="width: 70px;">
                                        Cancel
                                    </a>
                                    <a href="{{ route('myBookings.edit', ['myBooking' => $booking->id]) }}" class="btn btn-sm btn-primary mt-1" style="width: 70px;">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="15" class="text-center">No bookings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($myBookings, 'links'))
                <div class="mt-3">
                    {{ $myBookings->onEachSide(5)->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
    <!-- / Content -->

    @push('scripts')
    <script>
        function confirmWithPNR(baseUrl) {
            let pnr = prompt("Please enter the Airline PNR:");
            if (pnr !== null && pnr.trim() !== "") {
                window.location.href = baseUrl + encodeURIComponent(pnr);
            } else {
                alert("PNR is required to confirm the booking.");
            }
        }

        function confirmCancel(url) {
            if (confirm("Are you sure you want to cancel this booking?")) {
                window.location.href = url;
            }
        }

        function parseDateWithTimeZone(dateString) {
            // Parse the date string in the format 'YYYY-MM-DD HH:MM:SS'
            const parts = dateString.split(/[- :]/);
            if (parts.length >= 5) {
                // Create date in local time (assuming the input is in PKT)
                const localDate = new Date(parts[0], parts[1] - 1, parts[2], parts[3], parts[4], parts[5] || 0);

                // Get timezone offset in minutes and convert to milliseconds
                const timezoneOffset = localDate.getTimezoneOffset() * 60000;

                // Adjust for Pakistan Standard Time (UTC+5)
                const pktOffset = 5 * 60 * 60 * 1000; // 5 hours in milliseconds
                const pktDate = new Date(localDate.getTime() + timezoneOffset + pktOffset);

                console.log('Parsed PKT date:', pktDate.toString());
                return pktDate;
            }
            return new Date(dateString); // Fallback to default parsing
        }

        document.addEventListener('DOMContentLoaded', function () {
            @foreach($myBookings as $booking)
            (function () {
                let expireDatetimeStr = @json(optional($booking->airlineGroup)->expire_datetime);
                let timerId = "timer-{{ $booking->id }}";
                let element = document.getElementById(timerId);

                if (!element) return;

                if (!expireDatetimeStr) {
                    element.innerHTML = "N/A";
                    return;
                }

                // Parse the date with timezone handling
                let expireDate = parseDateWithTimeZone(expireDatetimeStr);

                if (isNaN(expireDate.getTime())) {
                    console.error('Invalid date format for booking {{ $booking->id }}:', expireDatetimeStr);
                    element.innerHTML = "Invalid date";
                    return;
                }

                const now = new Date();


                let distance = expireDate - now;

                updateCountdown();

                let interval = setInterval(updateCountdown, 1000);

                function updateCountdown() {
                    const now = new Date();
                    const distance = expireDate - now;

                    if (distance < 0) {
                        element.innerHTML = "Expired";
                        element.classList.remove("bg-success");
                        element.classList.add("bg-danger");
                        clearInterval(interval);
                    } else {
                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        const countdown = [];
                        if (days > 0) countdown.push(`${days}d`);
                        if (hours > 0 || days > 0) countdown.push(`${hours}h`);
                        if (minutes > 0 || hours > 0 || days > 0) countdown.push(`${minutes}m`);
                        countdown.push(`${seconds}s`);

                        element.innerHTML = countdown.join(' ');

                    }
                }
            })();
            @endforeach
        });
    </script>
    @endpush
</x-dashboard>
