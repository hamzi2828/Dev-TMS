<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header border-bottom pt-3 pb-2 mb-3">
                        <h5 class="offset-2">{{ $title }}</h5>
                    </div>
                    <form class="form" method="post"
                          action="{{ route ('accounts.process-add-multiple-transactions') }}">
                        @csrf
                        <input type="hidden" id="rows" value="0">
                        
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="offset-2 col-md-3 mb-3">
                                    <label class="form-label" for="voucher">Voucher</label>
                                    <select name="voucher-no" class="form-control chosen-select" id="voucher"
                                            onchange="toggleMultipleTransactions(this.value, '{{ route ('accounts.account-heads-dropdown') }}')"
                                            required="required" data-placeholder="Select">
                                        <option></option>
                                        <option value="cpv" @selected(old ('voucher-no') === 'cpv')>CPV
                                        </option>
                                        <option value="crv" @selected(old ('voucher-no') === 'crv')>CRV
                                        </option>
                                        <option value="bpv" @selected(old ('voucher-no') === 'bpv')>BPV
                                        </option>
                                        <option value="brv" @selected(old ('voucher-no') === 'brv')>BRV
                                        </option>
                                        <option value="jv" @selected(old ('voucher-no') === 'jv')>JV
                                        </option>
                                    </select>
                                </div>
                                <div class="col-2 mb-3">
                                    <label class="form-label" for="transaction-date">Transaction Date</label>
                                    <input type="text" class="form-control flatpickr-basic" id="transaction-date"
                                           value="{{ old ('transaction-date', date ('Y-m-d')) }}"
                                           name="transaction-date" placeholder="Transaction Date" />
                                </div>
                                <div class="col-2 mb-1">
                                    <label class="form-label" for="payment-mode">
                                        Payment Mode
                                    </label>
                                    <select name="payment-mode" class="form-control select2"
                                            id="payment-mode"
                                            required="required" data-placeholder="Select">
                                        <option></option>
                                        <option value="cash" @selected(old ('payment-mode') === 'cash')>
                                            Cash
                                        </option>
                                        <option value="cheque" @selected(old ('payment-mode') === 'cheque')>
                                            Cheque
                                        </option>
                                        <option value="online" @selected(old ('payment-mode') === 'online')>
                                            Online
                                        </option>
                                    </select>
                                    <input type="text" name="transaction-no" id="transaction-no"
                                           class="form-control d-none mt-2"
                                           placeholder="Cheque/Transaction No">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-7 offset-2">
                                    <h3 class="fw-bolder border-bottom">First Transaction</h3>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3 mb-3 offset-2">
                                    <label class="form-label" for="first-account-head">Account Head</label>
                                    <select name="account-heads[]" class="form-control chosen-select"
                                            required="required" data-placeholder="Select"
                                            id="first-account-head"
                                            onchange="get_account_head_type(this.value, 'transaction-type-0')">
                                        <option></option>
                                    </select>
                                </div>
                                
                                <div class="col-2 mb-3">
                                    <label class="form-label">Transaction Type</label>
                                    <ul class="list-unstyled d-flex pt-2 gap-2">
                                        <li>
                                            <input type="radio" name="transaction-type-0"
                                                   id="transaction-type-debit" value="debit"
                                                   required="required" onclick="toggleJVTransactions(this.value)"
                                                   class="float-start mt-1 me-1">
                                            <label for="transaction-type-0-debit">Debit</label>
                                        </li>
                                        <li>
                                            <input type="radio" name="transaction-type-0"
                                                   id="transaction-type-credit"
                                                   onclick="toggleJVTransactions(this.value)"
                                                   class="float-start  mt-1 me-1" value="credit">
                                            <label for="transaction-type-0-credit">Credit</label>
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="col-2 mb-3">
                                    <label class="form-label" for="amount">Amount</label>
                                    <input type="number" class="form-control initial-amount" id="amount"
                                           required="required" autofocus="autofocus" step="0.01"
                                           name="amount[]" placeholder="Amount" />
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-7 offset-2">
                                    <h3 class="fw-bolder border-bottom">Other Transactions</h3>
                                </div>
                            </div>
                            
                            <div id="add-more-transactions"></div>
                            
                            <div class="row mb-3">
                                <div class="col-7 offset-2">
                                    <label class="form-label" for="description">Description</label>
                                    <textarea name="description" class="form-control" id="description"
                                              rows="5">{{ old ('description') }}</textarea>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="offset-6 col-md-3 mb-2">
                                    <label class="form-label" for="first-transaction">First Transaction</label>
                                    <input type="number" class="form-control first-transaction" id="first-transaction"
                                           readonly="readonly">
                                </div>
                            </div>
                            <div class="row">
                                <div class="offset-6 col-md-3 mb-1">
                                    <label class="form-label" for="other-transactions">Other Transactions</label>
                                    <input type="number" class="form-control other-transactions" id="other-transactions"
                                           readonly="readonly">
                                </div>
                            </div>
                        
                        </div>
                        <div class="card-footer border-top pt-4">
                            <button type="submit" class="btn btn-primary me-50 offset-2" disabled="disabled"
                                    id="multiple-transactions-btn">
                                Save
                            </button>
                            <a href="javascript:void(0)"
                               onclick="addMoreTransactions('{{ route ('accounts.add-more-transactions') }}')"
                               class="btn btn-dark me-1">Add More</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard>
