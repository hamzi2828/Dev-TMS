<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        @include('candidates.search')
        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom pt-3 pb-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ $title }}</h5>
                <div>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#candidateStatusModal"
                            class="btn btn-primary btn-sm" disabled="disabled" id="bulkStatusBtn">
                        <i class="tf-icons ti ti-brand-redux fs-6 me-1"></i>
                        Bulk Status Update
                    </button>
                    <a href="javascript:void(0)" onclick="downloadExcel('Medical Candidates List')"
                       class="btn btn-sm btn-primary">
                        <i class="tf-icons ti ti-file-spreadsheet fs-6 me-1"></i>
                        Download Excel
                    </a>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table class="table table-hover table-sm table-bordered" id="excel-table">
                    <thead class="border-top">
                    <tr>
                        <th>
                            <div class="form-check form-check-success">
                                <label for="checkALL">
                                    <input class="form-check-input" type="checkbox" id="checkALL">
                                </label>
                            </div>
                        </th>
                        <th>#</th>
                        <th>Sr. No</th>
                        <th>Applied For</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Mobile</th>
                        <th>CNIC</th>
                        <th>Passport No</th>
                        <th>Referral</th>
                        <th>Payment Method</th>
                        <th>Transaction No</th>
                        <th>Status</th>
                        <th>Payment Follow Up</th>
                        <th>Date Added</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count ($candidates) > 0)
                        @foreach($candidates as $candidate)
                            <tr>
                                <td>
                                    <div class="form-check form-check-dark">
                                        <label for="checkbox-{{ $candidate -> id }}">
                                            <input class="form-check-input" type="checkbox"
                                                   value="{{ $candidate -> id }}"
                                                   {{ empty($candidate -> medical) ? 'disabled="disabled"' : '' }}
                                                   onchange="toggleBulkUpdateButton()"
                                                   id="checkbox-{{ $candidate -> id }}">
                                        </label>
                                    </div>
                                </td>
                                <td>{{ $loop -> iteration }}</td>
                                <td>
                                    <a href="{{ $candidate -> medical ? route ('candidates.medicals.edit', ['candidate' => $candidate -> id, 'medical' => $candidate -> medical -> id]) : route ('candidates.medicals.create', ['candidate' => $candidate -> id]) }}">
                                        {{ $candidate -> SerialNo() }}
                                    </a>
                                </td>
                                <td>{{ $candidate -> job ?-> title }}</td>
                                <td>
                                    {{ $candidate -> fullName() }}
                                    @if(empty($candidate -> medical))
                                        <span class="badge bg-danger">Payment not added.</span>
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
                                <td>{{ $candidate -> medical ?-> payment_method -> title }}</td>
                                <td>{{ $candidate -> medical ?-> transaction_no }}</td>
                                <td>
                                    @php
                                        $bg = 'warning';
                                        if ($candidate -> medical ?-> status == 'fit')
                                            $bg = 'success';
                                        if ($candidate -> medical ?-> status == 'unfit')
                                            $bg = 'danger';
                                    @endphp
                                    <span class="badge bg-{{ $bg }}">
                                        {{ !empty(trim ($candidate -> medical ?-> status)) ? str () -> upper ($candidate -> medical ?-> status) : 'Pending' }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $bg = 'warning';
                                        if ($candidate -> payment_follow_up ?-> status == 'informed')
                                            $bg = 'success';
                                        if ($candidate -> payment_follow_up ?-> status == 'phone-off')
                                            $bg = 'danger';
                                        if ($candidate -> payment_follow_up ?-> status == 'not-responding')
                                            $bg = 'danger';
                                    @endphp
                                    <span class="badge bg-{{ $bg }}">
                                        {{ !empty(trim ($candidate -> payment_follow_up ?-> status)) ? str () -> upper (str_replace ('-', ' ', $candidate -> payment_follow_up ?-> status)) : 'Not Informed' }}
                                    </span>
                                    
                                    @if(!empty(trim ($candidate -> payment_follow_up ?-> status)) && $candidate -> payment_follow_up ?-> user)
                                        <p class="mb-0 fs-tiny">
                                            <strong>Added By:</strong>
                                            {{ $candidate -> payment_follow_up ?-> user ?-> fullName() }}
                                        </p>
                                        <p class="mb-0 fs-tiny">
                                            {{ $candidate -> payment_follow_up ?-> updatedAt() }}
                                        </p>
                                    @endif
                                </td>
                                <td>{{ $candidate -> createdAt() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($candidate -> medical)
                                            @can('edit', $candidate -> medical)
                                                <a href="{{ route ('candidates.medicals.edit', ['candidate' => $candidate -> id, 'medical' => $candidate -> medical -> id]) }}"
                                                   class="text-body" data-bs-toggle="tooltip"
                                                   data-bs-placement="top"
                                                   data-bs-custom-class="tooltip-primary"
                                                   title="Edit">
                                                    <i class="ti ti-edit ti-sm me-2"></i>
                                                </a>
                                            @endcan
                                        
                                        @else
                                            @can('create', \App\Models\CandidateMedical::class)
                                                <a href="{{ route ('candidates.medicals.create', ['candidate' => $candidate -> id]) }}"
                                                   class="text-body" data-bs-toggle="tooltip"
                                                   data-bs-placement="top"
                                                   data-bs-custom-class="tooltip-primary"
                                                   title="Edit">
                                                    <i class="ti ti-edit ti-sm me-2"></i>
                                                </a>
                                            @endcan
                                        @endif
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
        {{ $candidates -> appends(request() -> query()) -> links('pagination::bootstrap-5') }}
        @include('candidates.popups.medical')
    </div>
    <!-- / Content -->
    @push('scripts')
        <script type="text/javascript">
            init_datatable ( '{{ route ('candidates.create') }}' )
            
            function toggleBulkUpdateButton () {
                let selectedValues                                           = [];
                let checkboxes                                               = document.querySelectorAll ( 'input[type="checkbox"]' );
                let checkedOne                                               = Array.prototype.slice.call ( checkboxes ).some ( x => x.checked );
                document.querySelectorAll ( '#bulkStatusBtn' )[ 0 ].disabled = !checkedOne;
                
                $ ( 'input[type="checkbox"]:checked' ).each ( function () {
                    selectedValues.push ( $ ( this ).val () );
                } );
                
                let selectedValuesString = selectedValues.join ( ', ' );
                let selected_leads       = $ ( '#selected-candidates' );
                selected_leads.val ( '' );
                selected_leads.val ( selectedValuesString );
            }
            
            $ ( "#checkALL" ).on ( 'click', function () {
                $ ( 'td input:checkbox' ).not ( this ).prop ( 'checked', this.checked );
                toggleBulkUpdateButton ();
            } );
        </script>
    @endpush
</x-dashboard>