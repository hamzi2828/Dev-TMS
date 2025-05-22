<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        @include('my-bookings.search')

        @php
            $groupedFlights = $airlineGroups->groupBy(function ($group) {
                $firstSegment = $group->segments->first();
                $origin = \App\Models\City::find($firstSegment->origin)->title ?? 'N/A';
                $destination = \App\Models\City::find($firstSegment->destination)->title ?? 'N/A';
                return $origin . ' to ' . $destination;
            });
        @endphp

        @foreach($groupedFlights as $route => $groups)
            <!-- Route Header -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-center">
                    <h4 class="mb-0 text-white fw-bold"><i class="fa-solid fa-plane-departure" style="font-size: 1.2em; margin-right: 10px;"></i> {{ $route }}</h4>
                </div>

                @php
                    $airlines = $groups->groupBy(function($group) {
                        return $group->airline->title ?? 'N/A';
                    });
                @endphp

                @foreach($airlines as $airlineName => $airlineGroupsSet)
                    <!-- Airline Info -->
                    <div class="p-3 border-bottom">
                        <div class="d-flex align-items-center">
                            @php
                                $logo = $airlineGroupsSet->first()->airline->file ?? '';
                            @endphp
                            @if(!empty(trim($logo)))
                                <div class="me-3">
                                    <img src="{{ $logo }}" alt="{{ $airlineName }} Logo" width="100" height="50">
                                </div>
                            @endif

                        </div>
                    </div>

                    <!-- Flight Table -->
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Dep. Date</th>
                                    <th>FLT No.</th>
                                    <th>Origin - Dest.</th>
                                    <th>Dep - Arr. Time</th>
                                    <th>Bag</th>
                                    <th>Meal</th>
                                    <th> Seats</th>
                                    <th>Adult</th>
                                    <th>Child</th>
                                    <th>Infant</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($airlineGroupsSet as $group)
                                    @foreach($group->segments as $index => $segment)
                                        <tr>
                                            <td>{{ $loop->parent->parent->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($segment->departure_date)->format('d M Y') }}</td>
                                            <td>{{ $segment->flight_number }}</td>
                                            <td>{{ \App\Models\City::find($segment->origin)->title ?? 'N/A' }} - {{ \App\Models\City::find($segment->destination)->title ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($segment->departure_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($segment->arrival_time)->format('H:i') }}</td>
                                            <td>{{ $segment->baggage }}</td>
                                            <td>{{ ucfirst($segment->meal) }}</td>
                                            <td>{{ $group->total_seats }}</td>
                                            <td>£{{ number_format($group->sale_per_adult, 2) }}</td>
                                            <td>£{{ number_format($group->sale_per_child, 2) }}</td>
                                            <td>£{{ number_format($group->sale_per_infant, 2) }}</td>
                                            <td>
                                                <a href="{{ route('myBookings.create', ['airlineGroup' => $group->id]) }}" class="btn btn-sm btn-primary">
                                                    Book Now
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        @endforeach

    </div>
</x-dashboard>
