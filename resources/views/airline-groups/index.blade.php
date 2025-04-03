<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')

        <!-- Filter Form -->
        <form method="GET" action="{{ route('airlineGroups.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-2">
                    <label for="departure_date">Departure Date</label>
                    <input type="date" name="departure_date" id="departure_date" class="form-control" value="{{ request('departure_date') }}">
                </div>
                <div class="col-md-2">
                    <label for="airline">Airline</label>
                    <select name="airline" id="airline" class="form-control select2">
                        <option value="">All Airlines</option>
                        @foreach($airlines as $airline)
                            <option value="{{ $airline->id }}" {{ request('airline') == $airline->id ? 'selected' : '' }}>{{ $airline->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="origin">Origin</label>
                    <select name="origin" id="origin" class="form-control select2">
                        <option value="">All Origins</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ request('origin') == $city->id ? 'selected' : '' }}>{{ $city->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="destination">Destination</label>
                    <select name="destination" id="destination" class="form-control select2">
                        <option value="">All Destinations</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ request('destination') == $city->id ? 'selected' : '' }}>{{ $city->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">

                    <button type="submit" class="btn btn-primary" style="margin-top: 22px;">Apply Filters</button>
                </div>
            </div>
        </form>

        <!-- Airline Groups Table -->
        <div class="card">
            <div class="card-header border-bottom pt-3 pb-3">
                <h5 class="card-title mb-0">{{ $title }}</h5>
            </div>

            <div class="card-datatable table-responsive">
                <table class="datatables-users table" id="datatable">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. No.</th>
                            <th style="min-width: 100px">Dep. Date</th>
                            <th style="min-width: 70px">Logo #</th>
                            <th>Airline</th>
                            <th style="min-width: 70px">Flight #</th>
                            <th>Origin</th>
                            <th>Destination</th>
                            <th>Dep. Time</th>
                            <th>Arrival Time</th>
                            <th>Baggage</th>
                            <th>Meal</th>
                            <th>Total Seats</th>
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
                                <td>
                                    @if(!empty(trim ($group->airline->file)))
                                        <img src="{{ $group->airline->file }}" alt="Airline Logo" width="50" height="50">
                                    @else
                                        N/A
                                    @endif
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
                                <td>{{ $group->total_seats }}</td>
                                <td>{{ number_format($group->sale_per_adult, 2) }}</td>
                                <td>{{ number_format($group->sale_per_child, 2) }}</td>
                                <td>{{ number_format($group->sale_per_infant, 2) }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('myBookings.create', ['airlineGroup' => $group->id]) }}"
                                           class="btn btn-primary btn-sm"
                                           title="Book Now">
                                            <i class="ti ti-ticket ti-sm me-2"></i> Book Now
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- / Content -->

    @push('scripts')
        <script type="text/javascript">
            init_datatable('{{ route('myBookings.create') }}');
        </script>
    @endpush
</x-dashboard>
