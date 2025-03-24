<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header border-bottom pt-3 pb-2 mb-3">
                        <h5 class="offset-2">{{ $title }}</h5>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <form method="get" action="{{ route ('accounts.search-transactions') }}"
                                  class="border-bottom pb-2 mb-2">
                                <div class="row">
                                    <div class="form-group offset-2 col-md-3 mb-1">
                                        <label class="mb-25" for="voucher-no">Voucher No</label>
                                        <input type="text" class="form-control" id="voucher-no"
                                               autofocus="autofocus"
                                               name="voucher-no" value="{{ request ('voucher-no') }}">
                                    </div>
                                    
                                    <div class="form-group col-md-3 mb-1">
                                        <label class="mb-25" for="transaction-id">Transaction ID</label>
                                        <input type="text" class="form-control" id="transaction-id"
                                               autofocus="autofocus"
                                               name="transaction-id" value="{{ request ('transaction-id') }}">
                                    </div>
                                    
                                    <div class="form-group col-2 mt-3">
                                        <button type="submit"
                                                class="btn w-100 mt-2 btn-primary d-block">Search
                                        </button>
                                    </div>
                                </div>
                            </form>
                            
                            @php $ledgersArray = []; @endphp
                            @if(count($ledgers) > 0)
                                @php
                                    $voucher = explode ('-', request ('voucher-no'));
                                    $voucher = $voucher[0];
                                @endphp
                                <form class="form" method="post" action="{{ route ('accounts.update-transactions') }}">
                                    @csrf
                                    
                                    <div class="row">
                                        <div class="form-group col-md-3 offset-2 mb-3 mt-3">
                                            <label class="mb-25" for="transaction-date">Transaction Date</label>
                                            <input type="text" class="form-control flatpickr-basic"
                                                   required="required" id="transaction-date"
                                                   name="transaction-date" placeholder="Transaction Date"
                                                   value="{{ date('Y-m-d', strtotime ($ledgers[0] -> transaction_date)) }}" />
                                        </div>
                                        
                                        <div class="form-group col-md-3 mb-3 mt-3">
                                            <label class="mb-25" for="payment-mode">
                                                Payment Mode
                                            </label>
                                            <select name="payment-mode" class="form-control select2"
                                                    id="payment-mode"
                                                    required="required" data-placeholder="Select">
                                                <option></option>
                                                <option value="cash" @selected(old ('payment-mode', $ledgers[0] -> payment_mode) === 'cash')>
                                                    Cash
                                                </option>
                                                <option value="cheque" @selected(old ('payment-mode', $ledgers[0] -> payment_mode) === 'cheque')>
                                                    Cheque
                                                </option>
                                                <option value="online" @selected(old ('payment-mode', $ledgers[0] -> payment_mode) === 'online')>
                                                    Online
                                                </option>
                                            </select>
                                            <input type="text" name="transaction-no" id="transaction-no"
                                                   class="form-control {{ empty(trim ($ledgers[0] -> transaction_no)) ? 'd-none' : '' }} mt-2"
                                                   placeholder="Cheque/Transaction No"
                                                   value="{{ old ('transaction-no', $ledgers[0] -> transaction_no) }}">
                                        </div>
                                    </div>
                                    
                                    @foreach($ledgers as $ledger)
                                        @php array_push ($ledgersArray, $ledger -> id) @endphp
                                        <input type="hidden" name="ledger-id[]" value="{{ $ledger -> id }}">
                                        
                                        @if(count ($ledgers) > 2 && $loop -> iteration == 1)
                                            <div class="row">
                                                <div class="col-7 offset-2">
                                                    <h3 class="fw-bolder border-bottom">First Transaction</h3>
                                                </div>
                                            </div>
                                        @elseif(count ($ledgers) > 2 && $loop -> iteration == 2)
                                            <div class="row">
                                                <div class="col-7 offset-2">
                                                    <h3 class="fw-bolder border-bottom">Other Transactions</h3>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <div class="row">
                                            <div class="col-md-3 mb-3 offset-2">
                                                <label class="form-label"
                                                       for="account-head">Account Head</label>
                                                <input type="text" class="form-control" readonly="readonly"
                                                       id="account-head"
                                                       value="{{ $ledger -> account_head -> name }}">
                                            </div>
                                            
                                            <div class="col-2 mb-3">
                                                <label class="form-label">
                                                    Transaction Type
                                                </label>
                                                <ul class="list-unstyled d-flex pt-2 gap-2">
                                                    <li>
                                                        <input type="radio"
                                                               id="transaction-type-debit--{{ $ledger -> id }}"
                                                               name="transaction-type-{{ $ledger -> id }}"
                                                               value="debit" required="required"
                                                               @checked($ledger -> debit > 0)
                                                               @if($loop -> iteration == 1 && in_array (strtolower ($voucher), ['crv', 'brv']))
                                                               @elseif($loop -> iteration == 1 && in_array (strtolower ($voucher), ['jv']))
                                                                   onclick="toggleJVTransactions(this.value, '{{ strtolower ($voucher) }}')"
                                                               @elseif($loop -> iteration == 1 && in_array (strtolower ($voucher), ['cpv', 'bpv']))
                                                                   disabled="disabled"
                                                               @elseif(in_array (strtolower ($voucher), ['crv', 'brv']))
                                                                   disabled="disabled"
                                                               @endif
                                                               class="float-start mt-1 me-1">
                                                        <label for="transaction-type-debit-{{ $ledger -> id }}">Debit</label>
                                                    </li>
                                                    <li>
                                                        <input type="radio"
                                                               id="transaction-type-credit-{{ $ledger -> id }}"
                                                               name="transaction-type-{{ $ledger -> id }}"
                                                               class="float-start mt-1 me-1"
                                                               @checked($ledger -> credit > 0)
                                                               @if($loop -> iteration == 1 && in_array (strtolower ($voucher), ['crv', 'brv']))
                                                                   disabled="disabled"
                                                               @elseif($loop -> iteration == 1 && in_array (strtolower ($voucher), ['jv']))
                                                                   onclick="toggleJVTransactions(this.value, '{{ strtolower ($voucher) }}')"
                                                               @elseif($loop -> iteration == 1 && in_array (strtolower ($voucher), ['cpv', 'bpv']))
                                                               @elseif(in_array (strtolower ($voucher), ['cpv', 'bpv']))
                                                                   disabled="disabled"
                                                               @endif
                                                               value="credit">
                                                        <label for="transaction-type-credit-{{ $ledger -> id }}">Credit</label>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                            <div class="col-2 mb-3">
                                                <label class="form-label" for="amount">Amount</label>
                                                <input type="number"
                                                       class="form-control amount @if(count ($ledgers) > 2 && $loop -> iteration == 1) first-transaction initial-amount @elseif(count ($ledgers) > 2 && $loop -> iteration > 1) other-amounts @endif"
                                                       id="amount"
                                                       required="required" autofocus="autofocus"
                                                       name="amount[]" placeholder="Amount"
                                                       @if(count ($ledgers) == 2)
                                                           onchange="setTransactionPrice(this.value)"
                                                       @endif
                                                       value="{{ ($ledger -> credit + $ledger -> debit) }}" />
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    <div class="row">
                                        <div class="col-7 offset-2">
                                            <label class="form-label" for="description">Description</label>
                                            <textarea name="description" class="form-control" id="description"
                                                      rows="5">{{ old ('description', $ledgers[0] -> description) }}</textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-3">
                                        <hr />
                                        <div class="col-12">
                                            <button type="submit"
                                                    class="btn btn-primary d-inline me-50 offset-2 w-auto">
                                                Save
                                            </button>
                                            
                                            <a href="{{ route ('invoices.transaction', ['voucher-no' => request ('voucher-no')]) }}"
                                               target="_blank" class="btn btn-dark me-50"> Print </a>
                                            
                                            @can('delete_transaction', \App\Models\Account::class)
                                                <a href="{{ route ('accounts.delete-transactions', ['ledgers' => $ledgersArray]) }}"
                                                   onclick="return confirm('Are you sure?')"
                                                   class="btn btn-danger me-50 d-inline w-auto"> Delete </a>
                                            @endcan
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard>