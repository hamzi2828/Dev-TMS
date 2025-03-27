<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')

        <!-- Airline Groups Table -->
        <div class="card">
            <div class="card-header border-bottom pt-3 pb-3">
                <h5 class="card-title mb-0">{{ $title }}</h5>
            </div>

            <div class="card-datatable table-responsive">
                <table class="datatables-users table" id="datatable">
                    <thead class="border-top">
                        <tr>
                            <th>Sr.No</th>
                            <th>Airline</th>
                            <th>Sector ID</th>
                            <th>Segments</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($airlineGroups as $group)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $group->airline->name ?? 'N/A' }}</td>
                                <td>{{ $group->sector_id }}</td>
                                <td>
                                    <ul class="list-unstyled mb-0">
                                        @foreach($group->segments as $segment)
                                            <li>
                                                <strong>{{ $segment->flight_number }}</strong> | 
                                                {{ $segment->origin }} → {{ $segment->destination }} | 
                                                {{ \Carbon\Carbon::parse($segment->departure_date)->format('d M Y') }} 
                                                ({{ $segment->departure_time }} - {{ $segment->arrival_time }})
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ $group->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('airlineGroups.edit', ['airlineGroup' => $group->id]) }}"
                                           class="text-body" data-bs-toggle="tooltip"
                                           data-bs-placement="top"
                                           data-bs-custom-class="tooltip-primary"
                                           title="Edit">
                                            <i class="ti ti-edit ti-sm me-2"></i>
                                        </a>

                                        <form method="POST"
                                              id="delete-record-form-{{ $group->id }}"
                                              action="{{ route('airlineGroups.destroy', ['airlineGroup' => $group->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    class="text-body delete-record bg-transparent border-0 p-0"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    data-bs-custom-class="tooltip-danger"
                                                    title="Delete"
                                                    onclick="delete_confirmation({{ $group->id }})">
                                                <i class="ti ti-trash ti-sm mx-2"></i>
                                            </button>
                                        </form>
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
            init_datatable('{{ route('airlineGroups.create') }}');
        </script>
    @endpush
</x-dashboard>
