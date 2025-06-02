<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')

        <!-- Filter Form -->
        @include('airline-groups.search')

        <!-- Airline Groups Table -->
        <div class="card">
            <div class="card-header border-bottom pt-3 pb-3 d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">{{ $title }}</h5>
                <a href="javascript:void(0)" onclick="downloadExcel('All Airline Group List')" class="btn btn-sm btn-primary">
                    <i class="tf-icons ti ti-file-spreadsheet fs-6 me-1"></i> Download Excel
                </a>
            </div>
            <div class="card-datatable table-responsive">
                <table class="table table-hover table-sm table-bordered" id="excel-table">
                    <thead class="border-top">
                        <tr>
                            <th>Sr. No.</th>
                            <th style="min-width: 150px">Dep. Date</th>
                            <th>Airline</th>
                            <th style="min-width: 100px">FLT No.</th>
                            <th style="min-width: 180px">Origin- Dest.</th>
                            <th style="min-width: 140px">Dep - Arr.</th>
                            <th style="min-width: 50px">Bag</th>
                            <th style="min-width: 50px">Meal</th>
                            <th style="min-width: 50px">Total<br>Seats</th>
                            <th style="min-width: 50px">Avail<br>Seats</th>
                            <th style="min-width: 50px">Adult</th>
                            <th style="min-width: 50px">Child</th>
                            <th style="min-width: 50px">Infant</th>
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
                                    @if(!empty(trim($group->airline->file)))
                                        <img src="{{ $group->airline->file }}" alt="Airline Logo" width="70" height="30">
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
                                <td>{{ $group->total_seats }}</td>
                                <td>{{ ($group->total_seats ?? 0) - ($group->used_seats ?? 0) }}</td>
                                <td>{{ number_format($group->sale_per_adult, 2) }}</td>
                                <td>{{ number_format($group->sale_per_child, 2) }}</td>
                                <td>{{ number_format($group->sale_per_infant, 2) }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if(request()->query('inactive') == 'true')
                                            @can('editInactiveAirlineGroups', \App\Models\AirlineGroup::class)
                                                <a href="{{ route('airlineGroups.edit', $group->id) }}" class="text-body" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="ti ti-edit ti-sm me-2"></i>
                                                </a>
                                            @endcan
                                            @can('statusInactiveAirlineGroups', \App\Models\AirlineGroup::class)
                                                <form action="{{ route('airlineGroups.status', $group->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="text-body bg-transparent border-0 p-0" data-bs-toggle="tooltip" title="Change Status" onclick="return confirm('Are you sure you want to change the status?')">
                                                        <i class="ti ti-status-change ti-sm me-2"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                            @can('deleteInactiveAirlineGroups', \App\Models\AirlineGroup::class)
                                                <form method="POST" id="delete-record-form-{{ $group->id }}" action="{{ route('airlineGroups.destroy', $group->id) }}" class="mb-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="text-body delete-record bg-transparent border-0 p-0" data-bs-toggle="tooltip" title="Delete" onclick="delete_confirmation({{ $group->id }})">
                                                        <i class="ti ti-trash ti-sm mx-2"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        @else
                                            @can('editAllAirlineGroups', \App\Models\AirlineGroup::class)
                                                <a href="{{ route('airlineGroups.edit', $group->id) }}" class="text-body" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="ti ti-edit ti-sm me-2"></i>
                                                </a>
                                            @endcan
                                            @can('statusAllAirlineGroups', \App\Models\AirlineGroup::class)
                                                <form action="{{ route('airlineGroups.status', $group->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="text-body bg-transparent border-0 p-0" data-bs-toggle="tooltip" title="Change Status" onclick="return confirm('Are you sure you want to change the status?')">
                                                        <i class="ti ti-status-change ti-sm me-2"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                            @can('deleteAllAirlineGroups', \App\Models\AirlineGroup::class)
                                                <form method="POST" id="delete-record-form-{{ $group->id }}" action="{{ route('airlineGroups.destroy', $group->id) }}" class="mb-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="text-body delete-record bg-transparent border-0 p-0" data-bs-toggle="tooltip" title="Delete" onclick="delete_confirmation({{ $group->id }})">
                                                        <i class="ti ti-trash ti-sm mx-2"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{ $airlineGroups->appends(request()->query())->onEachSide(5)->links('pagination::bootstrap-5') }}
    </div>
    <!-- / Content -->

    @push('scripts')
        <script type="text/javascript">
            init_datatable('{{ route('airlineGroups.create') }}');
        </script>
    @endpush
</x-dashboard>
