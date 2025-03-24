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
                    <button type="button"
                            onclick="loadBulkVisaDetailsPopup('{{ route ('bulk-visa-details-popup') }}')"
                            class="btn btn-primary btn-sm" disabled="disabled" id="bulkStatusBtn">
                        <i class="tf-icons ti ti-brand-redux fs-6 me-1"></i>
                        Bulk Status Update
                    </button>
                    <a href="javascript:void(0)" onclick="downloadExcel('Visa Candidates List')"
                       class="btn btn-sm btn-primary">
                        <i class="tf-icons ti ti-file-spreadsheet fs-6 me-1"></i>
                        Download Excel
                    </a>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <input type="hidden" id="selected-candidates">
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
                        <th>T.G.I.D</th>
                        <th>Applied For</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Mobile</th>
                        <th>CNIC</th>
                        <th>Passport No</th>
                        <th>Referral</th>
                        <th>Documents Uploaded</th>
                        <th>Status</th>
                        <th>Visa Follow Up</th>
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
                                                   onchange="toggleBulkUpdateButton()"
                                                   id="checkbox-{{ $candidate -> id }}">
                                        </label>
                                    </div>
                                </td>
                                <td>{{ $loop -> iteration }}</td>
                                <td>
                                    @can('follow_up', \App\Models\CandidateVisa::class)
                                        <a href="javascript:void(0)">
                                            {{ $candidate -> SerialNo() }}
                                        </a>
                                    @else
                                        <a href="{{ $candidate -> visa ? route ('candidates.visas.edit', ['candidate' => $candidate -> id, 'visa' => $candidate -> visa -> id]) : route ('candidates.visas.create', ['candidate' => $candidate -> id]) }}">
                                            {{ $candidate -> SerialNo() }}
                                        </a>
                                    @endcan
                                </td>
                                <td>{{ $candidate -> visa ?-> tgid }}</td>
                                <td>{{ $candidate -> job ?-> title }}</td>
                                <td>
                                    {{ $candidate -> fullName() }}
                                    @if($candidate -> back_out)
                                        <span class="badge bg-dark">Back out</span>
                                    @endif
                                </td>
                                <td>{{ $candidate -> father_name }}</td>
                                <td>{{ $candidate -> mobile }}</td>
                                <td>{{ $candidate -> cnic }}</td>
                                <td>{{ $candidate -> passport }}</td>
                                <td>{{ $candidate -> referral ?-> name }}</td>
                                <td>
                                    @php $bg = !empty(trim ($candidate -> visa ?-> tgid)) ? 'success' : 'warning'; @endphp
                                    <span class="badge bg-{{ $bg }}">
                                        {{ !empty(trim ($candidate -> visa ?-> tgid)) ? 'Documents Uploaded' : 'No documents attached' }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $bg = 'primary';
                                        if ($candidate -> visa ?-> status === 'in-process')
                                            $bg = 'warning';
                                        else if ($candidate -> visa ?-> status === 'issued')
                                            $bg = 'success';
                                        else if ($candidate -> visa ?-> status === 'rejected')
                                            $bg = 'danger';
                                    @endphp
                                    <span class="badge bg-{{ $bg }}">
                                        {{ !empty(trim ($candidate -> visa ?-> status)) ? str () -> upper ($candidate -> visa ?-> status) : 'In Process' }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $bg = 'warning';
                                        if ($candidate -> visa_follow_up ?-> status == 'informed')
                                            $bg = 'success';
                                        if ($candidate -> visa_follow_up ?-> status == 'phone-off')
                                            $bg = 'danger';
                                        if ($candidate -> visa_follow_up ?-> status == 'not-responding')
                                            $bg = 'danger';
                                    @endphp
                                    <span class="badge bg-{{ $bg }}">
                                        {{ !empty(trim ($candidate -> visa_follow_up ?-> status)) ? str () -> upper (str_replace ('-', ' ', $candidate -> visa_follow_up ?-> status)) : 'Not Informed' }}
                                    </span>
                                    
                                    @if(!empty(trim ($candidate -> visa_follow_up ?-> status)) && $candidate -> visa_follow_up ?-> user)
                                        <p class="mb-0 fs-tiny">
                                            <strong>Added By:</strong>
                                            {{ $candidate -> visa_follow_up ?-> user ?-> fullName() }}
                                        </p>
                                        <p class="mb-0 fs-tiny">
                                            {{ $candidate -> visa_follow_up ?-> updatedAt() }}
                                        </p>
                                    @endif
                                </td>
                                <td>{{ $candidate -> createdAt() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @can('follow_up', \App\Models\CandidateVisa::class)
                                            @if($candidate -> visa_follow_up)
                                                <a href="{{ route ('candidates.visa-follow-up.edit', ['candidate' => $candidate -> id, 'visa_follow_up' => $candidate -> visa_follow_up -> id]) }}"
                                                   class="text-body" data-bs-toggle="tooltip"
                                                   data-bs-placement="top"
                                                   data-bs-custom-class="tooltip-primary"
                                                   title="Visa Follow Up">
                                                    <i class="ti ti-growth ti-sm me-2"></i>
                                                </a>
                                            @else
                                                <a href="{{ route ('candidates.visa-follow-up.create', ['candidate' => $candidate -> id]) }}"
                                                   class="text-body" data-bs-toggle="tooltip"
                                                   data-bs-placement="top"
                                                   data-bs-custom-class="tooltip-primary"
                                                   title="Visa Follow Up">
                                                    <i class="ti ti-growth ti-sm me-2"></i>
                                                </a>
                                            @endif
                                        @endcan
                                        
                                        @if($candidate -> visa)
                                            @can('edit', $candidate -> visa)
                                                <a href="{{ route ('candidates.visas.edit', ['candidate' => $candidate -> id, 'visa' => $candidate -> visa -> id]) }}"
                                                   class="text-body" data-bs-toggle="tooltip"
                                                   data-bs-placement="top"
                                                   data-bs-custom-class="tooltip-primary"
                                                   title="Edit">
                                                    <i class="ti ti-edit ti-sm me-2"></i>
                                                </a>
                                            @endcan
                                        @else
                                            @can('create', \App\Models\CandidateVisa::class)
                                                <a href="{{ route ('candidates.visas.create', ['candidate' => $candidate -> id]) }}"
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