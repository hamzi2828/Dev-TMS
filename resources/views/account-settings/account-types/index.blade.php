<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="card">
            <div class="card-header border-bottom pt-3 pb-3">
                <h5 class="card-title mb-0">{{ $title }}</h5>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table" id="datatable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count ($types) > 0)
                        @foreach($types as $type)
                            <tr>
                                <td>{{ $loop -> iteration }}</td>
                                <td>{{ $type -> title }}</td>
                                <td>{{ $type -> type }}</td>
                                <td>
                                    <div class="align-content-start d-flex justify-content-start">
                                        @can('edit', $type)
                                            <a href="{{ route ('account-types.edit', ['account_type' => $type -> id]) }}"
                                               class="text-body" data-bs-toggle="tooltip"
                                               data-bs-placement="top"
                                               data-bs-custom-class="tooltip-primary"
                                               title="Edit">
                                                <i class="ti ti-edit ti-sm me-2"></i>
                                            </a>
                                        @endcan
                                        
                                        @can('delete', $type)
                                            <form method="post" id="delete-record-form-{{ $type -> id }}"
                                                  action="{{ route ('account-types.destroy', ['account_type' => $type -> id]) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        data-bs-custom-class="tooltip-danger"
                                                        title="Delete"
                                                        class="text-body delete-record bg-transparent border-0 p-0"
                                                        onclick="delete_confirmation({{ $type -> id }})">
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
    @push('scripts')
        <script type="text/javascript">
            init_datatable ( '{{ route ('account-types.create') }}' )
        </script>
    @endpush
</x-dashboard>