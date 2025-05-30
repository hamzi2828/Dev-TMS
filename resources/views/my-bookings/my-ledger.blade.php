<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <div class="card-body pt-1 pb-1">
                        <form method="get" action="{{ route ('myBookings.myLedger') }}">
                            <div class="row">
                                <div class="form-group col-4">
                                    <label class="mb-50" for="account-head">Account Head</label>
                                    <select name="account-head-id" id="account-head"
                                            class="form-control select2" disabled="disabled"
                                            data-placeholder="Select">
                                        <option></option>
                                        {!! $account_heads !!}
                                    </select>
                                </div>

                                <div class="form-group col-md-3 mb-1">
                                    <label class="mb-25" for="start-date">Start Date</label>
                                    <input type="text" class="form-control flatpickr-basic" id="start-date"
                                           name="start-date" value="{{ request ('start-date') }}">
                                </div>

                                <div class="form-group col-md-3 mb-1">
                                    <label class="mb-25" for="end-date">End Date</label>
                                    <input type="text" class="form-control flatpickr-basic" id="end-date"
                                           name="end-date" value="{{ request ('end-date') }}">
                                </div>

                                <div class="form-group col-2 mt-3">
                                    <button type="submit"
                                            class="btn w-100 mt-2 btn-primary d-block">Search
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="row mt-3">
                            <div class="col-12 d-flex justify-content-end">
                                <a href="javascript:void(0)" onclick="downloadExcel('General Ledger')"
                                   class="btn btn-xs btn-primary me-2 mb-1">
                                    <i class="tf-icons ti ti-file-spreadsheet me-1"></i>
                                    Download Excel
                                </a>

                                <a href="{{ route ('invoices.general-ledger', request () -> all ()) }}"
                                   target="_blank"
                                   class="btn btn-dark mb-1 btn-xs">
                                    <i class="menu-icon tf-icons ti ti-printer"></i> Print
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table w-100 table-hover" id="excel-table">
                            <thead class="table-light">
                            <tr>
                                <th> Sr. No</th>
                                <th> System. ID</th>
                                <th> Invoice/Sale ID</th>
                                <th> Chq/Trans. No</th>
                                <th> Voucher No.</th>
                                <th> Date</th>
                                <th> Description</th>
                                <th> Debit</th>
                                <th> Credit</th>
                                <th> Running Balance</th>
                            </tr>
                            </thead>
                            <tbody>
                            {!! $ledgers['html'] !!}
                            </tbody>
                            <tfoot>
                            <tr>
                                <td></td>
                                <td colspan="8" align="right">
                                    <strong style="font-size: 12pt; color: #000000;">Net Closing</strong>
                                </td>
                                <td>
                                    <strong style="font-size: 12pt; color: #000000;">
                                        {{ number_format ( $ledgers[ 'net_closing' ], 2 ) }}
                                    </strong>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard>
