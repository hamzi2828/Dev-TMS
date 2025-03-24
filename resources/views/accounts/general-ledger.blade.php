<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <div class="card-body pt-1 pb-1">
                        <form method="get" action="{{ route ('accounts.general-ledger') }}">
                            <div class="row">
                                <div class="form-group col-4">
                                    <label class="mb-50" for="account-head">Account Head</label>
                                    <select name="account-head-id" id="account-head"
                                            class="form-control chosen-select"
                                            data-placeholder="Select">
                                        <option></option>
                                        {!! $list !!}
                                    </select>
                                </div>
                                
                                <div class="form-group col-3 mb-1">
                                    <label class="mb-25" for="start-date">Start Date</label>
                                    <input type="text" class="form-control flatpickr-basic" id="start-date"
                                           name="start-date" value="{{ request ('start-date') }}">
                                </div>
                                
                                <div class="form-group col-3 mb-1">
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
                    </div>
                    
                    <div class="table-responsive mt-3">
                        <table class="table w-100 table-hover">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Invoice/Sale ID</th>
                                <th>Date</th>
                                <th>Voucher No</th>
                                <th>Account Head</th>
                                <th>Description</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Running Balance</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count ($ledgers) > 0)
                                <tr>
                                    <td colspan="8"></td>
                                    <td>
                                        <strong>{{ number_format ($running_balance, 2) }}</strong>
                                    </td>
                                </tr>
                                
                                @php
                                    $runningBalance = $running_balance;
                                    $netCredit = 0;
                                    $netDebit = 0;
                                @endphp
                                @foreach($ledgers as $ledger)
                                    @php
                                        if ( in_array ($ledger -> account_head -> account_type -> id, config ('constants.account_type_in')) )
                                            $runningBalance = $runningBalance + $ledger -> debit - $ledger -> credit;
                                        else
                                            $runningBalance = $runningBalance - $ledger -> debit + $ledger -> credit;

                                        $netCredit += $ledger -> credit;
                                        $netDebit += $ledger -> debit;
                                    
                                    @endphp
                                    <tr>
                                        <td>{{ $loop -> iteration }}</td>
                                        <td>
                                            @if($ledger -> payment_mode === 'opening-balance')
                                                <strong>Opening Balance</strong> <br />
                                                ID# {{ $ledger -> id }} <br />
                                            @else
                                                {{ $ledger -> invoice_no }}
                                            @endif
                                        </td>
                                        <td>{{ $ledger -> transaction_date }}</td>
                                        <td>
                                            <a href="{{ route ('accounts.search-transactions', ['voucher-no' => $ledger -> voucher_no]) }}"
                                               target="_blank" class="text-decoration-underline">
                                                {{ $ledger -> voucher_no }}
                                            </a>
                                        </td>
                                        <td>{{ $ledger -> account_head -> name }}</td>
                                        <td>{{ $ledger -> description }}</td>
                                        <td>{{ number_format ($ledger -> debit, 2) }}</td>
                                        <td>{{ number_format ($ledger -> credit, 2) }}</td>
                                        <td>{{ number_format ($runningBalance, 2) }}</td>
                                    </tr>
                                @endforeach
                                
                                <tr>
                                    <td colspan="6" align="right"></td>
                                    <td>
                                        <strong>{{ number_format ($netDebit, 2) }}</strong>
                                    </td>
                                    <td>
                                        <strong>{{ number_format ($netCredit, 2) }}</strong>
                                    </td>
                                    <td></td>
                                </tr>
                                
                                <tr>
                                    <td colspan="8" align="right">
                                        <strong>Closing Balance</strong>
                                    </td>
                                    <td>
                                        <strong>{{ number_format ($runningBalance, 2) }}</strong>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="9" align="center">No record found.</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard>
