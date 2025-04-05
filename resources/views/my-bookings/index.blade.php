<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        @include('my-bookings.search')
        <!-- Filter Form -->


        <!-- Airline Groups Table -->
        <div class="card">
            <div class="card-header border-bottom pt-3 pb-3 d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">{{ $title }}</h5>
                <a href="javascript:void(0)" onclick="downloadExcel('My Booking List')"
                   class="btn btn-sm btn-primary">
                    <i class="tf-icons ti ti-file-spreadsheet fs-6 me-1"></i>
                    Download Excel
                </a>
            </div>
            <div class="card-datatable table-responsive">
                <table class="table table-hover table-sm table-bordered" id="excel-table">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. No.</th>
                            <th style="min-width: 150px">Dep. Date</th>
                            <th>Airline</th>
                            <th style="min-width: 70px">Flight #</th>
                            <th>Origin</th>
                            <th>Destination</th>
                            <th>Dep. Time</th>
                            <th>Arrival Time</th>
                            <th>Baggage</th>
                            <th>Meal</th>
                            <th>Price Adult</th>
                            <th>Price Child</th>
                            <th>Price Infant</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($airlineGroups as $group)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @foreach($group->segments as $segment)
                                        <div>{{ \Carbon\Carbon::parse($segment->departure_date)->format('d M Y') }}</div>
                                    @endforeach
                                </td>
                                <td>{{ $group->airline->title ?? 'N/A' }}</td>
                                <td>
                                    @foreach($group->segments as $segment)
                                        <div>{{ $segment->flight_number }}</div>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($group->segments as $segment)
                                        <div>{{ \App\Models\City::find($segment->origin)->title ?? 'N/A' }}</div>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($group->segments as $segment)
                                        <div>{{ \App\Models\City::find($segment->destination)->title ?? 'N/A' }}</div>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($group->segments as $segment)
                                        <div>{{ $segment->departure_time }}</div>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($group->segments as $segment)
                                        <div>{{ $segment->arrival_time }}</div>
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
                                <td>{{ number_format($group->sale_per_adult, 2) }}</td>
                                <td>{{ number_format($group->sale_per_child, 2) }}</td>
                                <td>{{ number_format($group->sale_per_infant, 2) }}</td>
                                <td>
                                    <div class="d-flex align-items-center" style="min-width: 100px">
                                        <a href="{{ route('myBookings.create', ['airlineGroup' => $group->id]) }}"
                                           class="btn btn-primary btn-sm"
                                           title="Book Now">
                                            Book Now
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if(method_exists($airlineGroups, 'links'))
                {{ $airlineGroups->onEachSide(5)->links('pagination::bootstrap-5') }}
            @endif

        </div>

    </div>
    <!-- / Content -->

    @push('scripts')
        <script type="text/javascript">
            init_datatable('{{ route('myBookings.create') }}');
        </script>
    @endpush
</x-dashboard>
