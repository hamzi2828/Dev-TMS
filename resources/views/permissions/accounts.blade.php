<tr>
    <td colspan="2">
        <h5 class="mb-0">accounts</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="accounts"
                   id="accounts" @checked(in_array ('accounts', $role -> permissions()))>
            <label class="form-check-label" for="accounts">accounts</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">chart of accounts</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="chart-of-accounts"
                   id="chart-of-accounts" @checked(in_array ('chart-of-accounts', $role -> permissions()))>
            <label class="form-check-label" for="chart-of-accounts">chart of accounts</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-account-heads"
                       id="edit-account-heads" @checked(in_array ('edit-account-heads', $role -> permissions()))>
                <label class="form-check-label" for="edit-account-heads">Edit account heads</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="active-inactive-account-heads"
                       id="active-inactive-account-heads" @checked(in_array ('active-inactive-account-heads', $role -> permissions()))>
                <label class="form-check-label" for="active-inactive-account-heads">active/inactive account heads</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-account-heads"
                       id="delete-account-heads" @checked(in_array ('delete-account-heads', $role -> permissions()))>
                <label class="form-check-label" for="delete-account-heads">
                    Delete account heads
                </label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add account heads</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-account-heads"
                   id="add-account-heads" @checked(in_array ('add-account-heads', $role -> permissions()))>
            <label class="form-check-label" for="add-account-heads">add account heads</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">general ledgers</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="general-ledgers"
                   id="general-ledgers" @checked(in_array ('general-ledgers', $role -> permissions()))>
            <label class="form-check-label" for="general-ledgers">general ledgers</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add transactions</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-transactions"
                   id="add-transactions" @checked(in_array ('add-transactions', $role -> permissions()))>
            <label class="form-check-label" for="add-transactions">add transactions</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">search transactions</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="search-transactions"
                   id="search-transactions" @checked(in_array ('search-transactions', $role -> permissions()))>
            <label class="form-check-label" for="search-transactions">search transactions</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add transactions (multiple)</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-transactions-multiple"
                   id="add-transactions-multiple" @checked(in_array ('add-transactions-multiple', $role -> permissions()))>
            <label class="form-check-label" for="add-transactions-multiple">add transactions (multiple)</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add opening balance</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-opening-balance"
                   id="add-opening-balance" @checked(in_array ('add-opening-balance', $role -> permissions()))>
            <label class="form-check-label" for="add-opening-balance">add opening balance</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">delete transaction</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="delete-transaction"
                   id="delete-transaction" @checked(in_array ('delete-transaction', $role -> permissions()))>
            <label class="form-check-label" for="delete-transaction">delete transaction</label>
        </div>
    </td>
</tr>