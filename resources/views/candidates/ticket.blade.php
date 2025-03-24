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
                            onclick="loadBulkFlightDetailsPopup('{{ route ('bulk-flight-details-popup') }}')"
                            class="btn btn-primary btn-sm" disabled="disabled" id="bulkFlightDetailBtn">
                        <i class="tf-icons ti ti-plane-departure fs-6 me-1"></i>
                        Bulk Flight Detail Update
                    </button>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#candidateStatusModal"
                            class="btn btn-primary btn-sm" disabled="disabled" id="bulkStatusBtn">
                        <i class="tf-icons ti ti-brand-redux fs-6 me-1"></i>
                        Bulk Status Update
                    </button>
                    <a href="javascript:void(0)" onclick="downloadExcel('Ticket Candidates List')"
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
                        <th>Airline</th>
                        <th>Ticket No</th>
                        <th>Flight No</th>
                        <th>Departure Date</th>
                        <th>Vid Reg. No</th>
                        <th>Status</th>
                        <th>Ticket Follow Up</th>
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
                                    @can('follow_up', \App\Models\CandidateTicket::class)
                                        <a href="javascript:void(0)">
                                            {{ $candidate -> SerialNo() }}
                                        </a>
                                    @else
                                        <a href="{{ $candidate -> ticket ? route ('candidates.tickets.edit', ['candidate' => $candidate -> id, 'ticket' => $candidate -> ticket -> id]) : route ('candidates.tickets.create', ['candidate' => $candidate -> id]) }}">
                                            {{ $candidate -> SerialNo() }}
                                        </a>
                                    @endcan
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
                                <td>{{ $candidate ?-> ticket ?-> airline ?-> title }}</td>
                                <td>{{ $candidate ?-> ticket ?-> ticket_no }}</td>
                                <td>{{ $candidate ?-> ticket ?-> flight_no }}</td>
                                <td>{{ (new \App\Services\GeneralService()) -> only_date_formatter ($candidate ?-> ticket ?-> dept_date) }}</td>
                                <td>{{ $candidate -> protector ?-> reg_no }}</td>
                                <td>
                                    @php
                                        $bg = 'primary';
                                        if ($candidate ?-> ticket ?-> status === 'confirmed')
                                            $bg = 'success';
                                        else if ($candidate ?-> ticket ?-> status === 'waiting')
                                            $bg = 'warning';
                                        else if ($candidate ?-> ticket ?-> status === 'no-show')
                                            $bg = 'danger';
                                    @endphp
                                    <span class="badge bg-{{ $bg }}">
                                        {{ !empty(trim ($candidate -> ticket ?-> status)) ? str () -> upper ($candidate -> ticket ?-> status) : 'Waiting' }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $bg = 'warning';
                                        if ($candidate -> ticket_follow_up ?-> status == 'informed')
                                            $bg = 'success';
                                        if ($candidate -> ticket_follow_up ?-> status == 'phone-off')
                                            $bg = 'danger';
                                        if ($candidate -> ticket_follow_up ?-> status == 'not-responding')
                                            $bg = 'danger';
                                    @endphp
                                    <span class="badge bg-{{ $bg }}">
                                        {{ !empty(trim ($candidate -> ticket_follow_up ?-> status)) ? str () -> upper (str_replace ('-', ' ', $candidate -> ticket_follow_up ?-> status)) : 'Not Informed' }}
                                    </span>
                                    
                                    @if(!empty(trim ($candidate -> ticket_follow_up ?-> status)) && $candidate -> ticket_follow_up ?-> user)
                                        <p class="mb-0 fs-tiny">
                                            <strong>Added By:</strong>
                                            {{ $candidate -> ticket_follow_up ?-> user ?-> fullName() }}
                                        </p>
                                        <p class="mb-0 fs-tiny">
                                            {{ $candidate -> ticket_follow_up ?-> updatedAt() }}
                                        </p>
                                    @endif
                                </td>
                                <td>{{ $candidate -> createdAt() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @can('follow_up', \App\Models\CandidateTicket::class)
                                            @if($candidate -> ticket_follow_up)
                                                <a href="{{ route ('candidates.ticket-follow-up.edit', ['candidate' => $candidate -> id, 'ticket_follow_up' => $candidate -> ticket_follow_up -> id]) }}"
                                                   class="text-body" data-bs-toggle="tooltip"
                                                   data-bs-placement="top"
                                                   data-bs-custom-class="tooltip-primary"
                                                   title="Visa Follow Up">
                                                    <i class="ti ti-growth ti-sm me-2"></i>
                                                </a>
                                            @else
                                                <a href="{{ route ('candidates.ticket-follow-up.create', ['candidate' => $candidate -> id]) }}"
                                                   class="text-body" data-bs-toggle="tooltip"
                                                   data-bs-placement="top"
                                                   data-bs-custom-class="tooltip-primary"
                                                   title="Visa Follow Up">
                                                    <i class="ti ti-growth ti-sm me-2"></i>
                                                </a>
                                            @endif
                                        @endcan
                                        
                                        @if($candidate -> ticket)
                                            @can('edit', $candidate -> ticket)
                                                <a href="{{ route ('candidates.tickets.edit', ['candidate' => $candidate -> id, 'ticket' => $candidate -> ticket -> id]) }}"
                                                   class="text-body" data-bs-toggle="tooltip"
                                                   data-bs-placement="top"
                                                   data-bs-custom-class="tooltip-primary"
                                                   title="Edit">
                                                    <i class="ti ti-edit ti-sm me-2"></i>
                                                </a>
                                            @endcan
                                        @else
                                            @can('create', \App\Models\CandidateTicket::class)
                                                <a href="{{ route ('candidates.tickets.create', ['candidate' => $candidate -> id]) }}"
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
        @include('candidates.popups.ticket')
    </div>
    <!-- / Content -->
    @push('scripts')
        <script type="text/javascript">
            init_datatable ( '{{ route ('candidates.create') }}' )
            
            function toggleBulkUpdateButton () {
                let selectedValues                                                 = [];
                let checkboxes                                                     = document.querySelectorAll ( 'input[type="checkbox"]' );
                let checkedOne                                                     = Array.prototype.slice.call ( checkboxes ).some ( x => x.checked );
                document.querySelectorAll ( '#bulkStatusBtn' )[ 0 ].disabled       = !checkedOne;
                document.querySelectorAll ( '#bulkFlightDetailBtn' )[ 0 ].disabled = !checkedOne;
                
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