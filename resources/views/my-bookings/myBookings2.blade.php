<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        @include('my-bookings.search', ['action' => route('myBookings.index')])

        @php
        // Group airlineGroups by sector_id (assuming sector_id is a property on $group or via relation)
        $groupedBySector = $airlineGroups->groupBy(function ($group) {
            // Assuming you have sector relation loaded on airlineGroup as 'section'
            return $group->section->id ?? 'N/A';
        });
    @endphp

    @foreach($groupedBySector as $sectorId => $groups)
        @php
            // Get the sector title to show as heading
            $sectorTitle = $groups->first()->section->title ?? 'Unknown Sector';
        @endphp

        <div class="card mb-4">
            <div class="card-header bg-primary text-center">
                <h4 class="mb-0 text-white fw-bold">
                    <i class="fa-solid fa-plane-departure"></i>
                    <span class="ms-2 me-2"></span>
                        {{ $sectorTitle }}
                    <span class="ms-2 me-2"></span>
                    <i class=" fa-solid fa-plane-arrival"></i>
                </h4>
            </div>
            @php
                // Group these sector groups by airline
                $airlines = $groups->groupBy(function($group) {
                    return $group->airline->title ?? 'N/A';
                });
            @endphp

            @foreach($airlines as $airlineName => $airlineGroupsSet)
                <div class="p-3 border-bottom d-flex justify-content-between align-items-center">

                    <div>
                        @php
                            $logo = $airlineGroupsSet->first()->airline->file ?? '';
                        @endphp
                        @if(!empty(trim($logo)))
                            <img src="{{ $logo }}" alt="{{ $airlineName }} Logo" width="100" height="50">
                        @endif
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Dep. Date</th>
                                <th>FLT No.</th>
                                <th style="min-width: 4rem">Origin - Dest.</th>
                                <th style="min-width: 5rem">Dep - Arr.</th>
                                <th style="min-width: 4.5rem">Bag</th>
                                <th style="min-width: 4.5rem">Meal</th>
                                <th style="min-width: 4.5rem">Seats</th>
                                <th>Adult</th>
                                <th>Child</th>
                                <th>Infant</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($airlineGroupsSet as $group)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @foreach($group->segments as $segment)
                                            <div>{{ \Carbon\Carbon::parse($segment->departure_date)->format('d M Y') }}</div>
                                        @endforeach
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
                                    <td>{{ ($group->total_seats ?? 0) - ($group->used_seats ?? 0) }}</td>
                                    <td>{{ number_format($group->sale_per_adult, 2) }}</td>
                                    <td>{{ number_format($group->sale_per_child, 2) }}</td>
                                    <td>{{ number_format($group->sale_per_infant, 2) }}</td>
                                    <td>
                                        @can('bookNowBookTickets', \App\Models\MyBooking::class)
                                        <a href="{{ route('myBookings.create', ['airlineGroup' => $group->id]) }}" class="btn btn-sm btn-primary" target="_blank">
                                            Book Now
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    @endforeach

    </div>
</x-dashboard>
