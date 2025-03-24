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
                        <th>Fee</th>
                        <th>Vendor Payable</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count ($vendors) > 0)
                        @foreach($vendors as $vendor)
                            <tr>
                                <td>{{ $loop -> iteration }}</td>
                                <td>{{ $vendor -> title }}</td>
                                <td>{{ $vendor -> contact }}</td>
                                <td>{{ number_format ($vendor -> fee, 2) }}</td>
                                <td>{{ number_format ($vendor -> vendor_payable, 2) }}</td>
                                <td>{{ $vendor -> createdAt() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @can('edit', $vendor)
                                            <a href="{{ route ('vendors.edit', ['vendor' => $vendor -> id]) }}"
                                               class="text-body" data-bs-toggle="tooltip"
                                               data-bs-placement="top"
                                               data-bs-custom-class="tooltip-primary"
                                               title="Edit">
                                                <i class="ti ti-edit ti-sm me-2"></i>
                                            </a>
                                        @endcan
                                        
                                        @can('edit', $vendor)
                                            <form method="post" id="delete-record-form-{{ $vendor -> id }}"
                                                  action="{{ route ('vendors.destroy', ['vendor' => $vendor -> id]) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        data-bs-custom-class="tooltip-danger"
                                                        title="Delete"
                                                        class="text-body delete-record bg-transparent border-0 p-0"
                                                        onclick="delete_confirmation({{ $vendor -> id }})">
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
            init_datatable ( '{{ route ('vendors.create') }}' )
        </script>
    @endpush
</x-dashboard>