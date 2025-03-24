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
                        <th>Title</th>
                        <th>Contact No</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count ($principals) > 0)
                        @foreach($principals as $principal)
                            <tr>
                                <td>{{ $loop -> iteration }}</td>
                                <td>{{ $principal -> name }}</td>
                                <td>{{ $principal -> contact }}</td>
                                <td>{{ $principal -> createdAt() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @can('edit', $principal)
                                            <a href="{{ route ('principals.edit', ['principal' => $principal -> id]) }}"
                                               class="text-body" data-bs-toggle="tooltip"
                                               data-bs-placement="top"
                                               data-bs-custom-class="tooltip-primary"
                                               title="Edit">
                                                <i class="ti ti-edit ti-sm me-2"></i>
                                            </a>
                                        @endcan
                                        
                                        @can('edit', $principal)
                                            <form method="post" id="delete-record-form-{{ $principal -> id }}"
                                                  action="{{ route ('principals.destroy', ['principal' => $principal -> id]) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        data-bs-custom-class="tooltip-danger"
                                                        title="Delete"
                                                        class="text-body delete-record bg-transparent border-0 p-0"
                                                        onclick="delete_confirmation({{ $principal -> id }})">
                                                    <i class="ti ti-trash ti-sm mx-2"></i>
                                                </button>
                                            </form>
                                        @endcan
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
            init_datatable ( '{{ route ('principals.create') }}' )
        </script>
    @endpush
</x-dashboard>