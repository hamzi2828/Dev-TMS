<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="card">
            <div class="card-header border-bottom pt-3 pb-3">
                <h5 class="card-title mb-0">{{ $title }}</h5>
            </div>
            <div class="card-body">
                <form method="get" action="{{ route ('accounts-reporting.profit-and-loss-report') }}">
                    <div class="row mt-4">
                        <div class="form-group offset-2 col-3 mb-1">
                            <label class="mb-25">Start Date</label>
                            <input type="text" class="form-control flatpickr-basic"
                                   name="start-date" value="{{ request ('start-date') }}">
                        </div>
                        
                        <div class="form-group col-3 mb-1">
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
                    <a href="javascript:void(0)" onclick="downloadExcel('Profit and Loss')"
                       class="btn btn-sm btn-primary me-2 mb-1 btn-xs">
                        <i class="tf-icons ti ti-file-spreadsheet fs-6 me-1"></i>
                        Download Excel
                    </a>
                    <a href="{{ route ('invoices.profit-and-loss-report', request () -> all ()) }}"
                       target="_blank"
                       class="btn btn-dark me-2 mb-1 btn-xs">
                        <i class="menu-icon tf-icons ti ti-printer"></i> Print
                    </a>
                </div>
            </div>
            
            @php
                $a = 0;
                $b = 0;
                $c = 0;
                $d = 0;
                $e = 0;
                $f = 0;
                $g = 0;
                $h = 0;
                $i = 0;
                $j = 0;
                $k = 0;
            @endphp
            
            <div class="table-responsive">
                <table class="table w-100 table-hover table-responsive table-striped" id="excel-table">
                    <thead class="table-light">
                    <tr>
                        <th>Account Head</th>
                        <th>Net Cash</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    {!! $sales['items'] !!}
                    @php
                        $a += $sales['net'];
                    @endphp
                    
                    <tr>
                        <td>
                            Sales Refund
                        </td>
                        <td>
                            {{ number_format ($sales_refund['net'], 2) }}
                            @php
                                $b += $sales_refund['net'];
                            @endphp
                        </td>
                    </tr>
                    {!! $sale_discounts['items'] !!}
                    @php
                        $c += $sale_discounts['net'];
                        $e = ($a - $b - $c);
                    @endphp
                    
                    <tr>
                        <td class="text-danger font-medium-3 fw-bolder">
                            <strong>Net Sale</strong>
                        </td>
                        <td class="text-danger font-medium-3 fw-bolder">
                            {{ number_format ($e, 2) }}
                        </td>
                    </tr>
                    
                    {!! $direct_costs['items'] !!}
                    @php
                        $f += $direct_costs['net'];
                        $g += $e - $f;
                    @endphp
                    <tr>
                        <td class="text-danger font-medium-3 fw-bolder">
                            <strong>Gross Profit/Loss</strong>
                        </td>
                        <td class="text-danger font-medium-3 fw-bolder">
                            {{ number_format ($g, 2) }}
                        </td>
                    </tr>
                    
                    {!! $general_admin_expenses['items'] !!}
                    @php
                        $h += $general_admin_expenses['net'];
                        $i = $g - $h;
                    @endphp
                    <tr>
                        <td class="text-danger font-medium-3 fw-bolder">
                            <strong>G.Total</strong>
                        </td>
                        <td class="text-danger font-medium-3 fw-bolder">
                            {{ number_format ($h, 2) }}
                        </td>
                    </tr>
                    
                    {!! $income['items'] !!}
                    
                    <tr>
                        <td class="text-danger font-medium-3 fw-bolder">
                            <strong>Net Profit/Loss (Without Tax)</strong>
                        </td>
                        <td class="text-danger font-medium-3 fw-bolder">
                            @php $i += $income['net'] @endphp
                            {{ number_format ($i, 2) }}
                        </td>
                    </tr>
                    
                    {!! $taxes['items'] !!}
                    @php
                        $j += $taxes['net'];
                        $k = $i > 0 ? $i - $j : $i + $j;
                    @endphp
                    
                    <tr>
                        <td class="text-danger font-medium-3 fw-bolder">
                            <strong>Net Profit/Loss (With Tax)</strong>
                        </td>
                        <td class="text-danger font-medium-3 fw-bolder">
                            {{ number_format ($k, 2) }}
                        </td>
                    </tr>
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dashboard>
