<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom pt-3 pb-3">
                <h5 class="card-title mb-0">{{ $title }}</h5>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table" id="datatable">
                    <thead class="border-top">
                    <tr>
                        <th>Sr.No</th>
                        <th>Added By</th>
                        <th>Code</th>
                        <th>Title</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count ($sources) > 0)
                        @foreach($sources as $source)
                            <tr>
                                <td>{{ $loop -> iteration }}</td>
                                <td>
                                    @if($source -> user_id > 0)
                                        <div class="d-flex justify-content-start align-items-center user-name">
                                            <div class="avatar-wrapper">
                                                <div class="avatar avatar-sm me-3">
                                                    <img src="{{ $source -> user ?-> image() }}" alt="Avatar"
                                                         class="rounded-circle">
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column user-info">
                                                <a href="{{ route ('users.edit', ['user' => $source -> user_id]) }}"
                                                   class="text-body text-truncate">
                                                    <span class="fw-semibold">{{ $source -> user ?-> name }}</span>
                                                </a>
                                                <small class="text-muted">{{ $source -> user ?-> email }}</small>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $source -> id }}</td>
                                <td>{{ $source -> title }}</td>
                                <td>{{ $source -> createdAt() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route ('lead-sources.edit', ['lead_source' => $source -> id]) }}"
                                           class="text-body" data-bs-toggle="tooltip"
                                           data-bs-placement="top"
                                           data-bs-custom-class="tooltip-primary"
                                           title="Edit">
                                            <i class="ti ti-edit ti-sm me-2"></i>
                                        </a>
                                        
                                        <form method="post" id="delete-record-form-{{ $source -> id }}"
                                              action="{{ route ('lead-sources.destroy', ['lead_source' => $source -> id]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="button" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    data-bs-custom-class="tooltip-danger"
                                                    title="Delete"
                                                    class="text-body delete-record bg-transparent border-0 p-0"
                                                    onclick="delete_confirmation({{ $source -> id }})">
                                                <i class="ti ti-trash ti-sm mx-2"></i>
                                            </button>
                                        </form>
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
            init_datatable ( '{{ route ('industries.create') }}' )
        </script>
    @endpush
</x-dashboard>