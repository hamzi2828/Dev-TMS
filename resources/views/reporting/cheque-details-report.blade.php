<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="card mb-3">
            <div class="card-header border-bottom pt-3 pb-3">
                <h5 class="card-title mb-0">Search</h5>
            </div>
            <div class="card-body mt-3">
                <form method="get" action="{{ route ('accounts-reporting.cheque-details-report') }}">
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
                            <label class="form-label" for="account-head-id">Bank</label>
                            <select name="account-head-id" class="form-control select2" data-placeholder="Select"
                                    required="required"
                                    data-allow-clear="true" id="account-head-id">
                                <option></option>
                                {!! $banks !!}
                            </select>
                        </div>
                        
                        <div class="col-md-3 form-group mb-3">
                            <label class="form-label" for="filter">Filter</label>
                            <select name="filter" class="form-control select2" data-placeholder="Select"
                                    required="required"
                                    data-allow-clear="true" id="filter">
                                <option></option>
                                <option value="credit" @selected(request ('filter') == 'credit')>Credit</option>
                                <option value="debit" @selected(request ('filter') == 'debit')>Debit</option>
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
                <a href="javascript:void(0)" onclick="downloadExcel('Cheque Details Report')"
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
                        <th>Date</th>
                        <th>Cheque No.</th>
                        <th>Amount</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count ($ledgers) > 0)
                        @foreach($ledgers as $ledger)
                            <tr>
                                <td>{{ $loop -> iteration }}</td>
                                <td>{{ $ledger -> transactionDate() }}</td>
                                <td>
                                    {{ $ledger -> payment_mode == 'cheque' ? $ledger -> transaction_no : '-' }}
                                </td>
                                <td>
                                    {{ request ('filter') == 'credit' ? number_format ($ledger -> credit, 2) : number_format ($ledger -> debit, 2) }}
                                </td>
                                <td>{{ $ledger -> description }}</td>
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