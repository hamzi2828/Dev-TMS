<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="card mb-3">
            <div class="card-header border-bottom pt-3 pb-3">
                <h5 class="card-title mb-0">Search</h5>
            </div>
            <div class="card-body mt-3">
                <form method="get" action="{{ route ('reporting.gross-profit-report') }}">
                    <div class="row">
                        <div class="col-md-3 form-group mb-3">
                            <label class="form-label" for="start-date">Start Date</label>
                            <input type="text" name="start-date" class="form-control flatpickr-basic" id="start-date"
                                   value="{{ request ('start-date') }}">
                        </div>
                        
                        <div class="col-md-3 form-group mb-3">
                            <label class="form-label" for="end-date">End Date</label>
                            <input type="text" name="end-date" class="form-control flatpickr-basic" id="end-date"
                                   value="{{ request ('end-date') }}">
                        </div>
                        
                        <div class="col-md-3 form-group mb-3">
                            <label class="form-label" for="job-id">Applied For</label>
                            <select name="job-id" class="form-control select2" data-placeholder="Select"
                                    data-allow-clear="true" id="job-id">
                                <option></option>
                                @if(count ($jobs) > 0)
                                    @foreach($jobs as $job)
                                        <option value="{{ $job -> id }}" @selected(request ('job-id') == $job -> id)>
                                            {{ $job -> title }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                        <div class="col-md-3 form-group mb-3">
                            <label class="form-label" for="principal-id">Principal</label>
                            <select name="principal-id" class="form-control select2" data-placeholder="Select"
                                    data-allow-clear="true" id="principal-id">
                                <option></option>
                                @if(count ($principals) > 0)
                                    @foreach($principals as $principal)
                                        <option value="{{ $principal -> id }}" @selected(request ('principal-id') == $principal -> id)>
                                            {{ $principal -> name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                        <div class="col-md-3 form-group mb-3">
                            <label class="form-label" for="referral-id">Referral</label>
                            <select name="referral-id" class="form-control select2" data-placeholder="Select"
                                    data-allow-clear="true" id="referral-id">
                                <option></option>
                                @if(count ($referrals) > 0)
                                    @foreach($referrals as $referral)
                                        <option value="{{ $referral -> id }}" @selected(request ('referral-id') == $referral -> id)>
                                            {{ $referral -> name }}
                                        </option>
                                    @endforeach
                                @endif
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
                <a href="javascript:void(0)" onclick="downloadExcel('Gross Profit Report')"
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
                        <th>Sr.No</th>
                        <th>Applied For</th>
                        <th>Name</th>
                        <th>Principal</th>
                        <th>Referral</th>
                        <th>Test Fee (Income)</th>
                        <th>Medical Fee (Income)</th>
                        <th>Agreed Fee (Income)</th>
                        <th>Medical Paid (Vendor)</th>
                        <th>Protector Paid (Vendor)</th>
                        <th>Ticket Paid (Vendor)</th>
                        <th>Gross Profit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $netProfit = 0; @endphp
                    @if(count ($candidates) > 0)
                        @foreach($candidates as $candidate)
                            @php
                                $totalIncome    = 0;
                                $totalPayable   = 0;
                                $profit         = 0;
                                $testFee        = $candidate -> general_ledger () -> where(['account_head_id' => config ( 'constants.income_from_test' )]) -> first();
                                $medicalFee     = $candidate -> general_ledger () -> where(['account_head_id' => config ( 'constants.income_from_medical' )]) -> first();
                                $agreedFee      = $candidate -> general_ledger () -> where(['account_head_id' => $candidate -> account_head_id]) -> whereNull('voucher_no') -> first();
                                $totalIncome    += $testFee ?-> credit;
                                $totalIncome    += $medicalFee ?-> credit;
                                $totalIncome    += $agreedFee ?-> debit;
                                $totalPayable   += $candidate -> medical ?-> payable;
                                $totalPayable   += $candidate -> protector ?-> price;
                                $totalPayable   += $candidate -> ticket ?-> price;
                                $profit         = $totalIncome - $totalPayable;
                                $netProfit      += $profit;
                            @endphp
                            <tr>
                                <td>{{ $loop -> iteration }}</td>
                                <td>{{ env ('APP_NAME') . '-' . $candidate -> sr_no }}</td>
                                <td>
                                    {{ $candidate -> fullName() }}
                                    @if($candidate -> free_candidate == '1')
                                        <span class="badge bg-danger">No fee charged!</span>
                                    @endif
                                </td>
                                <td>{{ $candidate -> job ?-> title }}</td>
                                <td>{{ $candidate -> document_ready ?-> agreement ?-> principal ?-> name }}</td>
                                <td>{{ $candidate -> referral ?-> name }}</td>
                                <td>{{ number_format ($testFee ?-> credit, 2) }}</td>
                                <td>{{ number_format ($medicalFee ?-> credit, 2) }}</td>
                                <td>{{ number_format ($agreedFee ?-> debit, 2) }}</td>
                                <td>{{ number_format ($candidate -> medical ?-> payable, 2) }}</td>
                                <td>{{ number_format ($candidate -> protector ?-> price, 2) }}</td>
                                <td>{{ number_format ($candidate -> ticket ?-> price, 2) }}</td>
                                <td>{{ number_format ($profit, 2) }}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="12" align="right" class="text-end">Net Profit</th>
                        <th class="text-danger">
                            <strong>{{ number_format ($netProfit, 2) }}</strong>
                        </th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- / Content -->
</x-dashboard>