<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        @include('data-banks.search')
        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom pt-3 pb-3 d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">{{ $title }}</h5>
                <a href="javascript:void(0)" onclick="downloadExcel('All CV')"
                   class="btn btn-sm btn-primary">
                    <i class="tf-icons ti ti-file-spreadsheet fs-6 me-1"></i>
                    Download Excel
                </a>
            </div>
            <div class="card-datatable table-responsive">
                <table class="table table-hover table-sm table-bordered" id="excel-table">
                    <thead class="border-top">
                    <tr>
                        <th>#</th>
                        <th>Applied For</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Mobile</th>
                        <th>CNIC</th>
                        <th>Passport No</th>
                        <th>Referral</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count ($candidates) > 0)
                        @foreach($candidates as $candidate)
                            <tr>
                                <td>{{ $loop -> iteration }}</td>
                                <td>{{ $candidate -> job ?-> title }}</td>
                                <td>{{ $candidate -> fullName() }}</td>
                                <td>{{ $candidate -> father_name }}</td>
                                <td>{{ $candidate -> mobile }}</td>
                                <td>{{ $candidate -> cnic }}</td>
                                <td>{{ $candidate -> passport }}</td>
                                <td>{{ $candidate -> referral ?-> name }}</td>
                                <td>
                                    <badge class="badge bg-warning">
                                        {{ $candidate -> user ?-> name }}
                                    </badge>
                                    <br />
                                    {{ $candidate -> createdAt() }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @can('edit', $candidate)
                                            <a href="{{ route ('data-banks.edit', ['data_bank' => $candidate -> id]) }}"
                                               class="text-body" data-bs-toggle="tooltip"
                                               data-bs-placement="top"
                                               data-bs-custom-class="tooltip-primary"
                                               title="Edit">
                                                <i class="ti ti-edit ti-sm me-2"></i>
                                            </a>
                                        @endcan
                                        
                                        @can('delete', $candidate)
                                            <form method="post" id="delete-record-form-{{ $candidate -> id }}"
                                                  action="{{ route ('data-banks.destroy', ['data_bank' => $candidate -> id]) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        data-bs-custom-class="tooltip-danger"
                                                        title="Delete"
                                                        class="text-body delete-record bg-transparent border-0 p-0"
                                                        onclick="delete_confirmation({{ $candidate -> id }})">
                                                    <i class="ti ti-trash ti-sm"></i>
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
        {{ $candidates -> links('pagination::bootstrap-5') }}
    </div>
    <!-- / Content -->
    @push('scripts')
        <script type="text/javascript">
            init_datatable ( '{{ route ('data-banks.create') }}' )
        </script>
    @endpush
</x-dashboard>