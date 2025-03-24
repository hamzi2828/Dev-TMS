<div class="row">
    <div class="col-3 mb-3 offset-2">
        <label class="form-label" for="transaction-type-{{ $row }}">Account Head</label>
        <select name="account-heads[]" class="form-control chosen-select-{{ $row }}"
                required="required" data-placeholder="Select" id="transaction-type-{{ $row }}">
            <option></option>
            {!! $list !!}
        </select>
    </div>
    
    <div class="col-2 mb-3">
        <label class="form-label">Transaction Type</label>
        <ul class="list-unstyled d-flex pt-2 gap-2">
            <li>
                <input type="radio" name="transaction-type-{{ $row }}" value="debit"
                       required="required" id="transaction-type-{{ $row }}-debit"
                       class="float-start mt-1 me-1 other-transactions-debit">
                <label for="transaction-type-{{ $row }}-debit">Debit</label>
            </li>
            <li>
                <input type="radio" name="transaction-type-{{ $row }}" id="transaction-type-{{ $row }}-credit"
                       class="float-start mt-1 me-1 other-transactions-credit" value="credit">
                <label for="transaction-type-{{ $row }}-credit">Credit</label>
            </li>
        </ul>
    </div>
    
    <div class="col-2 mb-3">
        <label class="form-label" for="amount-{{ $row }}">Amount</label>
        <input type="number" class="form-control other-amounts" id="amount-{{ $row }}"
               required="required" autofocus="autofocus" step="0.01"
               name="amount[]" placeholder="Amount" />
    </div>
</div>
