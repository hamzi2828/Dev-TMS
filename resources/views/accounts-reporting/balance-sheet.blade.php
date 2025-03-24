<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="card">
            <div class="card-header border-bottom pt-3 pb-3">
                <h5 class="card-title mb-0">{{ $title }}</h5>
            </div>
            
            <div class="card-body">
                <form method="get" action="{{ route ('accounts-reporting.balance-sheet') }}">
                    <div class="row mt-4">
                        <div class="form-group col-md-3 mb-1 offset-4">
                            <label class="mb-25" for="start-date">Start Date</label>
                            <input type="text" class="form-control flatpickr-basic" id="start-date"
                                   name="start-date" value="{{ request ('start-date') }}">
                        </div>
                        
                        <div class="form-group col-1">
                            <button type="submit"
                                    class="btn w-100 mt-4 btn-primary d-block ps-0 pe-0">Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="row">
                <div class="col-12 d-flex justify-content-end">
                    <a href="javascript:void(0)" onclick="downloadExcel('Balance Sheet')"
                       class="btn btn-sm btn-primary me-2 mb-1 btn-xs">
                        <i class="tf-icons ti ti-file-spreadsheet fs-6 me-1"></i>
                        Download Excel
                    </a>
                    <a href="{{ route ('invoices.balance-sheet', request () -> all ()) }}"
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
                        <th>Account Head</th>
                        <th>Closing Balance</th>
                    </tr>
                    </thead>
                    <tbody style="vertical-align: baseline;">
                    <tr>
                        <td colspan="2">
                            <strong>
                                {{ \App\Models\Account::find(config ('constants.current_assets')) -> name }}
                            </strong>
                        </td>
                    </tr>
                    {!! $current_assets['html'] !!}
                    <tr>
                        <td></td>
                        <td>
                            <strong style="font-size: 16px; color: #FF0000">
                                {{ number_format ($current_assets['net'], 2) }}
                            </strong>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2">
                            <strong>
                                {{ \App\Models\Account::find(config ('constants.non_current_assets')) -> name }}
                            </strong>
                        </td>
                    </tr>
                    {!! $non_current_assets['html'] !!}
                    <tr>
                        <td></td>
                        <td>
                            <strong style="font-size: 16px; color: #FF0000">
                                {{ number_format ($non_current_assets['net'], 2) }}
                            </strong>
                        </td>
                    </tr>
                    
                    <tr>
                        <td align="right">
                            <strong>
                                Total Assets
                            </strong>
                        </td>
                        <td>
                            <strong style="font-size: 16px; color: #FF0000">
                                {{ number_format (($current_assets['net'] + $non_current_assets['net']), 2) }}
                            </strong>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2">
                            <strong>
                                {{ \App\Models\Account::find(config ('constants.liabilities')) -> name }}
                            </strong>
                        </td>
                    </tr>
                    {!! $liabilities['html'] !!}
                    <tr>
                        <td align="right">
                            <strong>
                                Total Liabilities
                            </strong>
                        </td>
                        <td>
                            <strong style="font-size: 16px; color: #FF0000">
                                {{ number_format ($liabilities['net'], 2) }}
                            </strong>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2">
                            <strong style="font-size: 16px; color:#FF0000">
                                Shareholder's Equity
                            </strong>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2">
                            <strong>
                                {{ \App\Models\Account::find(config ('constants.capital')) -> name }}
                            </strong>
                        </td>
                    </tr>
                    {!! $capital['html'] !!}
                    <tr>
                        <td></td>
                        <td>
                            <strong style="font-size: 16px; color: #FF0000">
                                {{ number_format ($capital['net'], 2) }}
                            </strong>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <strong>Net Profit (P&L)</strong>
                        </td>
                        <td>
                            <strong style="font-size: 16px; color: #FF0000">
                                {{ number_format ($profit, 2) }}
                            </strong>
                        </td>
                    </tr>
                    
                    <tr>
                        <td align="right">
                            <strong>
                                Total Equity
                            </strong>
                        </td>
                        <td>
                            <strong style="font-size: 16px; color: #FF0000">
                                {{ number_format (abs ($capital['net']) + $profit, 2) }}
                            </strong>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <strong style="font-size: 16px; color: #000000">
                                Total Assets = Total Liabilities + Total Capital
                            </strong>
                        </td>
                        <td>
                            <strong style="font-size: 16px; color: #FF0000">
                                {{ number_format (($current_assets['net'] + $non_current_assets['net']), 2) }}
                                =
                                {{ number_format (($liabilities['net'] + abs ($capital['net']) + $profit), 2) }}
                            </strong>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dashboard>
