<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="card">
            <div class="card-header border-bottom pt-3 pb-3">
                <h5 class="card-title mb-0">{{ $title }}</h5>
            </div>
            <div class="card-body">
                <form method="get" action="{{ route ('accounts-reporting.vendor-payable-report') }}">
                    <div class="row mt-4">
                        <div class="form-group col-md-3 mb-1 offset-2">
                            <label class="mb-25">Start Date</label>
                            <input type="text" class="form-control flatpickr-basic"
                                   name="start-date" value="{{ request ('start-date') }}">
                        </div>
                        
                        <div class="form-group col-md-3 mb-1">
                            <label class="mb-25">End Date</label>
                            <input type="text" class="form-control flatpickr-basic"
                                   name="end-date" value="{{ request ('end-date') }}">
                        </div>
                        
                        <div class="form-group col-2 mt-4">
                            <button type="submit"
                                    class="btn w-100 btn-primary d-block ps-0 pe-0">Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="row">
                <div class="col-12 d-flex justify-content-end">
                    <a href="javascript:void(0)" onclick="downloadExcel('Vendor Payable')"
                       class="btn btn-sm btn-primary me-2 mb-1 btn-xs">
                        <i class="tf-icons ti ti-file-spreadsheet fs-6 me-1"></i>
                        Download Excel
                    </a>
                    <a href="{{ route ('invoices.vendor-payable-report', request () -> all ()) }}"
                       target="_blank"
                       class="btn btn-dark me-2 mb-1 btn-xs">
                        <i class="menu-icon tf-icons ti ti-printer"></i> Print
                    </a>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table w-100 table-hover table-responsive table-striped" id="excel-table">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Account Head</th>
                        <th>Opening Balance</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $net_debit = 0;
                        $net_credit = 0;
                        $netRB = 0;
                        $netOB = 0;
                    @endphp
                    @if(count ($account_heads) > 0)
                        @foreach($account_heads as $account_head)
                            @php
                                $net_debit += $account_head -> totalDebit;
                                $net_credit += $account_head -> totalCredit;
                                $opening_balance = (new \App\Services\GeneralLedgerService()) -> get_opening_balance_previous_than_searched_start_date(request ('start-date'), $account_head -> id);
                                $running_balance = (new \App\Services\GeneralLedgerService()) -> calculate_running_balance($opening_balance, $account_head -> totalCredit, $account_head -> totalDebit, $account_head);
                                $netRB += $running_balance;
                                $netOB += $opening_balance;
                            @endphp
                            
                            <tr>
                                <td>{{ $loop -> iteration }}</td>
                                <td>{{ $account_head -> name }}</td>
                                <td>{{ number_format ($opening_balance, 2) }}</td>
                                <td>{{ number_format ($account_head -> totalDebit, 2) }}</td>
                                <td>{{ number_format ($account_head -> totalCredit, 2) }}</td>
                                <td>{{ number_format ($running_balance, 2) }}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2"></td>
                        <td>
                            <strong>{{ number_format ($netOB, 2) }}</strong>
                        </td>
                        <td>
                            <strong>{{ number_format ($net_debit, 2) }}</strong>
                        </td>
                        <td>
                            <strong>{{ number_format ($net_credit, 2) }}</strong>
                        </td>
                        <td>
                            <strong>{{ number_format (($netOB + $net_credit - $net_debit), 2) }}</strong>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-dashboard>