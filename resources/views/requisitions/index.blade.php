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
                        <th>#</th>
                        <th>MRF. No</th>
                        <th>Principal</th>
                        <th>Profession</th>
                        <th>Demand</th>
                        <th>Used</th>
                        <th>Remaining</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count ($requisitions) > 0)
                        @foreach($requisitions as $requisition)
                            <tr>
                                <td>{{ $loop -> iteration }}</td>
                                <td>{{ env ('MRF_NO') . $requisition -> id }}</td>
                                <td>{{ $requisition -> principal ?-> name }}</td>
                                <td>
                                    @if(count ($requisition -> jobs))
                                        @foreach($requisition -> jobs as $job)
                                            {{ $job -> job ?-> title }} <br />
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if(count ($requisition -> jobs))
                                        @foreach($requisition -> jobs as $job)
                                            {{ $job -> quota }} <br />
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if(count ($requisition -> jobs))
                                        @foreach($requisition -> jobs as $job)
                                            @php
                                                $allocatedQuota = (new \App\Services\CandidateCompanyRequisitionJobService()) -> count_allocated_quota($job -> id);
                                            @endphp
                                            {{ $allocatedQuota }} <br />
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if(count ($requisition -> jobs))
                                        @foreach($requisition -> jobs as $job)
                                            @php
                                                $allocatedQuota = (new \App\Services\CandidateCompanyRequisitionJobService()) -> count_allocated_quota($job -> id);
                                                $availableQuota = $job -> quota - $allocatedQuota;
                                            @endphp
                                            {{ $availableQuota }} <br />
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ $requisition -> createdAt() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route ('invoices.company-requisitions', ['requisition' => $requisition -> id]) }}"
                                           class="text-body" data-bs-toggle="tooltip"
                                           data-bs-placement="top" target="_blank"
                                           data-bs-custom-class="tooltip-dark"
                                           title="Print">
                                            <i class="ti ti-printer ti-sm me-2"></i>
                                        </a>
                                        
                                        @can('edit', $requisition)
                                            <a href="{{ route ('company-requisitions.edit', ['company_requisition' => $requisition -> id]) }}"
                                               class="text-body" data-bs-toggle="tooltip"
                                               data-bs-placement="top"
                                               data-bs-custom-class="tooltip-primary"
                                               title="Edit">
                                                <i class="ti ti-edit ti-sm me-2"></i>
                                            </a>
                                        @endcan
                                        
                                        @can('delete', $requisition)
                                            <form method="post" id="delete-record-form-{{ $requisition -> id }}"
                                                  action="{{ route ('company-requisitions.destroy', ['company_requisition' => $requisition -> id]) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        data-bs-custom-class="tooltip-danger"
                                                        title="Delete"
                                                        class="text-body delete-record bg-transparent border-0 p-0"
                                                        onclick="delete_confirmation({{ $requisition -> id }})">
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
    </div>
    <!-- / Content -->
    @push('scripts')
        <script type="text/javascript">
            init_datatable ( '{{ route ('company-requisitions.create') }}' )
        </script>
    @endpush
</x-dashboard>