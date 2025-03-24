<tr>
    <td colspan="2">
        <h5 class="mb-0">accounts reporting</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="accounts-reporting"
                   id="accounts-reporting" @checked(in_array ('accounts-reporting', $role -> permissions()))>
            <label class="form-check-label" for="accounts-reporting">accounts reporting</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">trial balance sheet</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="trial-balance-sheet"
                   id="trial-balance-sheet" @checked(in_array ('trial-balance-sheet', $role -> permissions()))>
            <label class="form-check-label" for="trial-balance-sheet">trial balance sheet</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">profit & loss</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="profit-and-loss"
                   id="profit-and-loss" @checked(in_array ('profit-and-loss', $role -> permissions()))>
            <label class="form-check-label" for="profit-and-loss">profit & loss</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">balance sheet</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="balance-sheet"
                   id="balance-sheet" @checked(in_array ('balance-sheet', $role -> permissions()))>
            <label class="form-check-label" for="balance-sheet">balance sheet</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">customer receivable</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="customer-receivable"
                   id="customer-receivable" @checked(in_array ('customer-receivable', $role -> permissions()))>
            <label class="form-check-label" for="customer-receivable">customer receivable</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">vendor payable</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="vendor-payable"
                   id="vendor-payable" @checked(in_array ('vendor-payable', $role -> permissions()))>
            <label class="form-check-label" for="vendor-payable">vendor payable</label>
        </div>
    </td>
</tr>