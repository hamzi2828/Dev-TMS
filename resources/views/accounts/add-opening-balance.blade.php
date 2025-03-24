<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <form class="form" method="post"
                          action="{{ route ('accounts.process-add-opening-balance') }}">
                        @csrf
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-4 mb-3">
                                    <label class="form-label"
                                           for="account-head">Account Head</label>
                                    <select name="account-head-id" class="form-control chosen-select"
                                            required="required" id="account-head"
                                            onchange="get_account_head_type(this.value, 'transaction-type', '{{ route ('accounts.get-account-head-type') }}')"
                                            data-placeholder="Select">
                                        <option></option>
                                        {!! $list !!}
                                    </select>
                                </div>
                                
                                <div class="col-3 mb-3">
                                    <label class="form-label">Transaction Type</label>
                                    <ul class="list-unstyled d-flex pt-2 gap-2">
                                        <li>
                                            <input type="radio" name="transaction-type" value="debit"
                                                   required="required" id="transaction-type-debit"
                                                   class="float-start mt-1 me-1" @checked(old ('transaction-type') === 'debit')>
                                            <label for="transaction-type-debit">Debit</label>
                                        </li>
                                        <li>
                                            <input type="radio" name="transaction-type"
                                                   class="float-start mt-1 me-1"
                                                   id="transaction-type-credit"
                                                   value="credit" @checked(old ('transaction-type') === 'credit')>
                                            <label for="transaction-type-credit">Credit</label>
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="col-2 mb-3">
                                    <label class="form-label" for="amount">Amount</label>
                                    <input type="number" class="form-control" id="amount"
                                           required="required" autofocus="autofocus"
                                           name="amount" placeholder="Amount"
                                           value="{{ old ('amount') }}" />
                                </div>
                                
                                <div class="col-3 mb-3">
                                    <label class="form-label" for="transaction-date">Transaction Date</label>
                                    <input type="text" class="form-control flatpickr-basic" id="transaction-date"
                                           name="transaction-date" placeholder="Transaction Date"
                                           value="{{ old ('transaction-date', date('Y-m-d')) }}" />
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label"
                                           for="description">Description</label>
                                    <textarea name="description" class="form-control" id="description"
                                              rows="5">{{ old ('description') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-top pt-4">
                            <button type="submit" class="btn btn-primary me-1">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard>