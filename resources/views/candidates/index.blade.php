<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        @include('candidates.search')
        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom pt-3 pb-3 d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">{{ $title }}</h5>
                <a href="javascript:void(0)" onclick="downloadExcel('All Candidates List')"
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
                        <th>Sr. No</th>
                        <th>Applied For</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Mobile</th>
                        <th>CNIC</th>
                        <th>Passport No</th>
                        <th>Referral</th>
                        <th>Transaction No</th>
                        <th>Docs Provided</th>
                        <th>Status</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count ($candidates) > 0)
                        @foreach($candidates as $candidate)
                            <tr>
                                <td>{{ $loop -> iteration }}</td>
                                <td>
                                    <a href="{{ route ('candidates.edit', ['candidate' => $candidate -> id]) }}">
                                        {{ $candidate -> SerialNo() }}
                                    </a>
                                </td>
                                <td>{{ $candidate -> job ?-> title }}</td>
                                <td>
                                    {{ $candidate -> fullName() }}
                                    @if($candidate -> free_candidate == '1')
                                        <span class="badge bg-danger">No fee charged!</span>
                                    @endif
                                    @if($candidate -> back_out)
                                        <span class="badge bg-dark">Back out</span>
                                    @endif
                                </td>
                                <td>{{ $candidate -> father_name }}</td>
                                <td>{{ $candidate -> mobile }}</td>
                                <td>{{ $candidate -> cnic }}</td>
                                <td>{{ $candidate -> passport }}</td>
                                <td>{{ $candidate -> referral ?-> name }}</td>
                                <td>{{ $candidate -> transaction_no }}</td>
                                <td>
                                    {{ !empty(trim ($candidate -> docs_provided)) ? str () -> title (str_replace ('-', ' ', $candidate -> docs_provided)) : '-' }}
                                </td>
                                <td>
                                    <div class="badge bg-{{ $candidate -> active == '1' ? 'success' : 'danger' }}">
                                        {{ $candidate -> active == '1' ? 'Active' : 'Inactive' }}
                                    </div>
                                    <br />
                                </td>
                                <td>
                                    <badge class="badge bg-warning">
                                        {{ $candidate -> user ?-> name }}
                                    </badge>
                                    <br />
                                    {{ $candidate -> createdAt() }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @can('status_change', $candidate)
                                            <a href="{{ route ('candidates.status', ['candidate' => $candidate -> id]) }}"
                                               class="text-body" data-bs-toggle="tooltip"
                                               data-bs-placement="top" onclick="return confirm('Are you sure?')"
                                               data-bs-custom-class="tooltip-danger"
                                               title="{{ $candidate -> active == '1' ? 'Deactivate' : 'Activate' }}">
                                                <i class="ti ti-power ti-sm me-2"></i>
                                            </a>
                                        @endcan

                                        @can('edit', $candidate)
                                            <a href="{{ route ('candidates.edit', ['candidate' => $candidate -> id]) }}"
                                               class="text-body" data-bs-toggle="tooltip"
                                               data-bs-placement="top"
                                               data-bs-custom-class="tooltip-primary"
                                               title="Edit">
                                                <i class="ti ti-edit ti-sm me-2"></i>
                                            </a>
                                        @endcan
                                        @include('candidates.action-buttons')
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        {{-- {{ $candidates -> appends(request() -> query()) -> onEachSide(5) -> links('pagination::bootstrap-5') }} --}}
    </div>
    <!-- / Content -->
    @push('scripts')
        <script type="text/javascript">
            init_datatable ( '{{ route ('candidates.create') }}' )
        </script>
    @endpush
</x-dashboard>