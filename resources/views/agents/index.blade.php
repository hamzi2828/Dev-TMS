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
                    @if(count ($agents) > 0)
                        @foreach($agents as $agent)
                            <tr>
                                <td>{{ $loop -> iteration }}</td>
                                <td>{{ $agent -> name }}</td>
                                <td>{{ $agent -> contact }}</td>
                                <td>{{ $agent -> createdAt() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @can('edit', $agent)
                                            <a href="{{ route ('agents.edit', ['agent' => $agent -> id]) }}"
                                               class="text-body" data-bs-toggle="tooltip"
                                               data-bs-placement="top"
                                               data-bs-custom-class="tooltip-primary"
                                               title="Edit">
                                                <i class="ti ti-edit ti-sm me-2"></i>
                                            </a>
                                        @endcan
                                        
                                        @can('edit', $agent)
                                            <form method="post" id="delete-record-form-{{ $agent -> id }}"
                                                  action="{{ route ('agents.destroy', ['agent' => $agent -> id]) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        data-bs-custom-class="tooltip-danger"
                                                        title="Delete"
                                                        class="text-body delete-record bg-transparent border-0 p-0"
                                                        onclick="delete_confirmation({{ $agent -> id }})">
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
            init_datatable ( '{{ route ('agents.create') }}' )
        </script>
    @endpush
</x-dashboard>