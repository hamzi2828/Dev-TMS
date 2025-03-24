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
                        <th>Profession</th>
                        <th>Principal</th>
                        <th>Title</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count ($agreements) > 0)
                        @foreach($agreements as $agreement)
                            <tr>
                                <td>{{ $loop -> iteration }}</td>
                                <td>{{ $agreement -> job ?-> title }}</td>
                                <td>{{ $agreement -> principal ?-> name }}</td>
                                <td>{{ $agreement -> title }}</td>
                                <td>{{ $agreement -> createdAt() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @can('edit', $agreement)
                                            <a href="{{ route ('agreements.edit', ['agreement' => $agreement -> id]) }}"
                                               class="text-body" data-bs-toggle="tooltip"
                                               data-bs-placement="top"
                                               data-bs-custom-class="tooltip-primary"
                                               title="Edit">
                                                <i class="ti ti-edit ti-sm me-2"></i>
                                            </a>
                                        @endcan
                                        
                                        @can('delete', $agreement)
                                            <form method="post" id="delete-record-form-{{ $agreement -> id }}"
                                                  action="{{ route ('agreements.destroy', ['agreement' => $agreement -> id]) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        data-bs-custom-class="tooltip-danger"
                                                        title="Delete"
                                                        class="text-body delete-record bg-transparent border-0 p-0"
                                                        onclick="delete_confirmation({{ $agreement -> id }})">
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
            init_datatable ( '{{ route ('agreements.create') }}' )
        </script>
    @endpush
</x-dashboard>