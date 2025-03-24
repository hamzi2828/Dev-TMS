<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="card mb-3">
            <div class="card-header border-bottom pt-3 pb-3">
                <h5 class="card-title mb-0">Search</h5>
            </div>
            <div class="card-body mt-3">
                <form method="get" action="{{ route ('reporting.follow-up-report') }}">
                    <div class="row">
                        <div class="col-md-2 form-group mb-3">
                            <label class="form-label" for="start-date">Start Date</label>
                            <input type="text" name="start-date" class="form-control flatpickr-basic" id="start-date"
                                   value="{{ request ('start-date') }}">
                        </div>
                        
                        <div class="col-md-2 form-group mb-3">
                            <label class="form-label" for="end-date">End Date</label>
                            <input type="text" name="end-date" class="form-control flatpickr-basic" id="end-date"
                                   value="{{ request ('end-date') }}">
                        </div>
                        
                        <div class="col-md-3 form-group mb-3">
                            <label class="form-label" for="follow-up">Follow Up</label>
                            <select name="follow-up" class="form-control select2" data-placeholder="Select"
                                    data-allow-clear="true" id="follow-up">
                                <option></option>
                                <option value="payment" @selected(request ('follow-up') == 'payment')>Payment</option>
                                <option value="visa" @selected(request ('follow-up') == 'visa')>Visa</option>
                                <option value="ticket" @selected(request ('follow-up') == 'ticket')>Ticket</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3 form-group mb-3">
                            <label class="form-label" for="status">Status</label>
                            <select name="status" class="form-control select2" data-placeholder="Select"
                                    required="required" data-allow-clear="true"
                                    id="status">
                                <option></option>
                                <option value="not-informed" @selected(request ('status') == 'not-informed')>
                                    Not Informed
                                </option>
                                <option value="informed" @selected(request ('status') == 'informed')>
                                    Informed
                                </option>
                                <option value="phone-off" @selected(request ('status') == 'phone-off')>
                                    Phone Off
                                </option>
                                <option value="not-responding" @selected(request ('status') == 'not-responding')>
                                    Not Responding
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2 form-group">
                            <button type="submit" class="btn btn-primary w-100 mt-4">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom pt-3 pb-3 d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">{{ $title }}</h5>
                <a href="javascript:void(0)" onclick="downloadExcel('Follow Up Report')"
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
                        <th>Referral</th>
                        <th>Status</th>
                        <th>Remarks</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count ($candidates) > 0)
                        @foreach($candidates as $candidate)
                            <tr>
                                <td>{{ $loop -> iteration }}</td>
                                <td>{{ $candidate -> SerialNo() }}</td>
                                <td>{{ $candidate -> job ?-> title }}</td>
                                <td>{{ $candidate -> fullName() }}</td>
                                <td>{{ $candidate -> father_name }}</td>
                                <td>{{ $candidate -> mobile }}</td>
                                <td>{{ $candidate -> cnic }}</td>
                                <td>{{ $candidate -> referral ?-> name }}</td>
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
                                        @if(request ('follow-up') == 'payment')
                                            {{ str () -> upper (str_replace ('-', ' ', $candidate -> payment_follow_up ?-> status)) }}
                                        @endif
                                        
                                        @if(request ('follow-up') == 'visa')
                                            {{ str () -> upper (str_replace ('-', ' ', $candidate -> visa_follow_up ?-> status)) }}
                                        @endif
                                        
                                        @if(request ('follow-up') == 'ticket')
                                            {{ str () -> upper (str_replace ('-', ' ', $candidate -> ticket_follow_up ?-> status)) }}
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    @if(request ('follow-up') == 'payment')
                                        {{ $candidate -> payment_follow_up ?-> description }}
                                    @endif
                                    
                                    @if(request ('follow-up') == 'visa')
                                        {{ $candidate -> visa_follow_up ?-> description }}
                                    @endif
                                    
                                    @if(request ('follow-up') == 'ticket')
                                        {{ $candidate -> ticket_follow_up ?-> description }}
                                    @endif
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
</x-dashboard>