<x-dashboard :title="$title">
    @push('styles')
        <link rel="stylesheet" href="{{ asset ('/assets/chosen/chosen.css') }}"></script>
    @endpush
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header border-bottom pt-3 pb-2 mb-3">
                        <h5 class="offset-2">{{ $title }}</h5>
                    </div>
                    <form class="pt-0" method="post"
                          action="{{ route ('accounts.process-add-transactions') }}">
                        @csrf
                        <div class="card-body pt-0">
                            
                            <div class="row border-bottom mb-3 pb-2">
                                <div class="col-md-3 offset-2 mb-1">
                                    <label class="form-label" for="voucher">Voucher</label>
                                    <select name="voucher-no" class="form-control select2" id="voucher"
                                            onchange="toggleSingleTransactions(this.value, '{{ route ('accounts.account-heads-dropdown') }}')"
                                            required="required" data-placeholder="Select">
                                        <option></option>
                                        @if(request () -> filled('sr-no'))
                                            <option value="crv" @selected(old ('voucher-no') === 'crv')>CRV</option>
                                            <option value="brv" @selected(old ('voucher-no') === 'brv')>BRV</option>
                                        @else
                                            <option value="cpv" @selected(old ('voucher-no') === 'cpv')>CPV</option>
                                            <option value="crv" @selected(old ('voucher-no') === 'crv')>CRV</option>
                                            <option value="bpv" @selected(old ('voucher-no') === 'bpv')>BPV</option>
                                            <option value="brv" @selected(old ('voucher-no') === 'brv')>BRV</option>
                                            <option value="jv" @selected(old ('voucher-no') === 'jv')>JV</option>
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-1">
                                    <label class="form-label" for="transaction-date">Transaction Date</label>
                                    <input type="text" class="form-control flatpickr-basic" id="transaction-date"
                                           name="transaction-date" placeholder="Transaction Date"
                                           value="{{ old ('transaction-date', date('Y-m-d')) }}" />
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3 mb-3 offset-2">
                                    <label class="form-label" for="first-account-head">Account Head</label>
                                    <select name="account-head-id" class="form-control select2"
                                            required="required" id="first-account-head"
                                            data-placeholder="Select">
                                        <option></option>
                                    </select>
                                </div>
                                
                                <div class="col-2 mb-3">
                                    <label class="form-label">Transaction Type</label>
                                    <ul class="list-unstyled d-flex pt-2 gap-2">
                                        <li>
                                            <input type="radio" name="transaction-type" value="debit"
                                                   required="required" id="transaction-type-debit"
                                                   onclick="toggleJVTransactions(this.value)"
                                                   class="float-start mt-1 me-1" @checked(old ('transaction-type') === 'debit')>
                                            <label for="transaction-type-debit">Debit</label>
                                        </li>
                                        <li>
                                            <input type="radio" name="transaction-type"
                                                   class="float-start mt-1 me-1"
                                                   id="transaction-type-credit"
                                                   onclick="toggleJVTransactions(this.value)"
                                                   value="credit" @checked(old ('transaction-type') === 'credit')>
                                            <label for="transaction-type-credit">Credit</label>
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="col-2 mb-3">
                                    <label class="form-label" for="amount">Amount</label>
                                    <input type="number" class="form-control" step="0.01"
                                           required="required" autofocus="autofocus"
                                           name="amount" placeholder="Amount" id="amount"
                                           value="{{ old ('amount') }}" />
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3 mb-3 offset-2">
                                    <label class="form-label"
                                           for="account-head-id-2">Account Head</label>
                                    <select name="account-head-id-2" class="form-control select2"
                                            required="required" id="account-head-id-2"
                                            data-placeholder="Select">
                                        <option></option>
                                        {!! $list !!}
                                    </select>
                                </div>
                                
                                <div class="col-2 mb-3">
                                    <label class="form-label">Transaction Type</label>
                                    <ul class="list-unstyled d-flex pt-2 gap-2">
                                        <li>
                                            <input type="radio" name="transaction-type-2" value="debit"
                                                   required="required" id="transaction-type-2-debit"
                                                   class="float-start mt-1 me-1" @checked(old ('transaction-type-2') === 'debit')>
                                            <label for="transaction-type-2-debit">Debit</label>
                                        </li>
                                        <li>
                                            <input type="radio" name="transaction-type-2"
                                                   class="float-start mt-1 me-1"
                                                   id="transaction-type-2-credit"
                                                   value="credit" @checked(old ('transaction-type-2') === 'credit')>
                                            <label for="transaction-type-2-credit">Credit</label>
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="col-2 mb-3">
                                    <label class="form-label" for="payment-mode">Payment Mode</label>
                                    <select name="payment-mode" class="form-control select2" id="payment-mode"
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
                            
                            <div id="transaction-dropdown"></div>
                            
                            <div class="row">
                                <div class="col-7 mb-3 offset-2">
                                    <label class="form-label" for="description">Description</label>
                                    <textarea name="description" rows="5" id="description"
                                              class="form-control">{{ request() -> filled('sr-no') ? env ('APP_NAME').'-'.request ('sr-no') : old ('description') }}</textarea>
                                </div>
                            </div>
                        
                        </div>
                        <div class="card-footer border-top pt-4">
                            <button type="submit" class="btn btn-primary me-1 offset-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard>
