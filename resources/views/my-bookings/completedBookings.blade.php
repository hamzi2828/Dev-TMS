<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        @include('my-bookings.search', ['action' => route('myBookings.completed')])

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
                            <th style="min-width: 100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($myBookings as $booking)
                            @php
                                $group = $booking->airlineGroup;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div><strong>{{ $booking->booking_reference }}</strong></div>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y, H:i A') }}
                                    </small>
                                    <div>{{ \App\Models\Agent::find($booking->user->agent_id)->name ?? 'N/A' }}</div>

                                        <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" data-bs-placement="top">
                                            PNR-{{ $booking->pnr ?? 'N/A' }}
                                        </button>

                                </td>
                                <td>
                                    @foreach($booking->passengers as $passenger)
                                        <div>{{ $passenger->title }} {{ $passenger->surname }} {{ $passenger->given_name }}</div>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($group->segments as $segment)
                                        <div>{{ \Carbon\Carbon::parse($segment->departure_date)->format('d M Y') }}</div>
                                    @endforeach
                                </td>
                                <td>
                                    @if(!empty(trim($booking->airline->file)))
                                        <img src="{{ $booking->airline->file }}" alt="Airline Logo"  width="70" height="30">
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
                                        {{ number_format($booking->total_price - $booking->discount, 2 ) }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    <span  class="btn btn-sm btn-success mt-1" style="width: 110px;">Confirmed</span>

                                    @can('editConfirmedBooking', \App\Models\MyBooking::class)
                                    <a href="{{ route('myBookings.edit', ['myBooking' => $booking->id]) }}" class="btn btn-sm btn-primary mt-1" style="width: 110px;">
                                        Edit
                                    </a>
                                    @endcan
                                    @can('cancelBookingConfirmedBooking', \App\Models\MyBooking::class)
                                    <a href="javascript:void(0)" onclick="confirmCancel('{{ route('myBookings.canceleBooking', ['id' => $booking->id]) }}')" class="btn btn-sm btn-danger mt-1" style="width: 110px;">
                                        Cancel
                                    </a>
                                    @endcan
                                    @can('printTicketConfirmedBooking', \App\Models\MyBooking::class)
                                    <a href="{{ url('invoices/bookings/' . $booking->id) }}" target="_blank" class="btn btn-sm btn-warning mt-1" style="width: 110px;">
                                        Print Ticket
                                    </a>
                                    @endcan


                                </td>
                            </tr>
                        @endforeach
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
<script>
    function confirmCancel(url) {
        if (confirm("Are you sure you want to cancel this booking?")) {
            window.location.href = url;
        }
    }
</script>

</x-dashboard>
