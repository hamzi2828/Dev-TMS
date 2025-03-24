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
                                    <a href="{{ $candidate -> document_ready ? route ('candidates.document-ready.edit', ['candidate' => $candidate -> id, 'document_ready' => $candidate -> document_ready -> id]) : route ('candidates.document-ready.create', ['candidate' => $candidate -> id]) }}">
                                        {{ $candidate -> SerialNo() }}
                                    </a>
                                </td>
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
                                <td>{{ $candidate -> medical ?-> payment_method -> title }}</td>
                                <td>{{ $candidate -> medical ?-> transaction_no }}</td>
                                <td>
                                    @php
                                        $bg = 'warning';
                                        if ($candidate -> document_ready ?-> status == 'yes')
                                            $bg = 'success';
                                        if ($candidate -> document_ready ?-> status == 'no')
                                            $bg = 'danger';
                                    @endphp
                                    <span class="badge bg-{{ $bg }}">
                                        {{ !empty(trim ($candidate -> document_ready ?-> status)) ? str () -> upper ($candidate -> document_ready ?-> status) : 'On Hold' }}
                                    </span>
                                    @if($candidate -> proceed_to_visa == '1')
                                        <span class="badge bg-primary mt-2">Proceed to Visa</span>
                                    @endif
                                </td>
                                <td>{{ $candidate -> createdAt() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($candidate -> document_ready)
                                            <a href="{{ route ('candidates.document-ready.edit', ['candidate' => $candidate -> id, 'document_ready' => $candidate -> document_ready -> id]) }}"
                                               class="text-body" data-bs-toggle="tooltip"
                                               data-bs-placement="top"
                                               data-bs-custom-class="tooltip-primary"
                                               title="Edit">
                                                <i class="ti ti-edit ti-sm me-2"></i>
                                            </a>
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
        @include('candidates.popups.document-ready')
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