<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <!-- Sections List Table -->
        <div class="card">
            <div class="card-header border-bottom pt-3 pb-3">
                <h5 class="card-title mb-0">{{ $title }}</h5>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table" id="datatable">
                    <thead class="border-top">
                    <tr>
                        <th>Sr.No</th>
                        <th>Title</th>
                        <th>Trip Type</th>
                        <th>Trip Route</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(is_countable($sections) && count($sections) > 0)
                        @foreach($sections as $section)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <th>{{ $section->title }}   </th>
                                <td>
                                    <span class="badge bg-label-primary">
                                        {{ ucfirst($section->trip_type) }}
                                    </span>
                                </td>
                                <td>{{ $section->route_type ?? '' }}</td>
                                <td>{{ $section->originCity->title ?? '' }}</td>
                                <td>{{ $section->destinationCity->title ?? '' }}</td>
                                <td>{{ $section->created_at->format('d M, Y') }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{-- @can('edit', $section) --}}
                                            <a href="{{ route('sections.edit', ['section' => $section->id]) }}"
                                               class="text-body" data-bs-toggle="tooltip"
                                               data-bs-placement="top"
                                               data-bs-custom-class="tooltip-primary"
                                               title="Edit">
                                                <i class="ti ti-edit ti-sm me-2"></i>
                                            </a>
                                        {{-- @endcan --}}
                                        
                                        {{-- @can('edit', $section) --}}
                                            <form method="post" id="delete-record-form-{{ $section->id }}"
                                                  action="{{ route('sections.destroy', ['section' => $section->id]) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        data-bs-custom-class="tooltip-danger"
                                                        title="Delete"
                                                        class="text-body delete-record bg-transparent border-0 p-0"
                                                        onclick="delete_confirmation({{ $section->id }})">
                                                    <i class="ti ti-trash ti-sm mx-2"></i>
                                                </button>
                                            </form>
                                        {{-- @endcan --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- / Content -->
    @push('scripts')
        <script type="text/javascript">
            init_datatable('{{ route('sections.create') }}')
        </script>
    @endpush
</x-dashboard>