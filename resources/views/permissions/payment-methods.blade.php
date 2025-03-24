<tr>
    <td colspan="2">
        <h5 class="mb-0">payment-methods</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="payment-methods"
                   id="payment-methods" @checked(in_array ('payment-methods', $role -> permissions()))>
            <label class="form-check-label" for="payment-methods">payment methods</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">all payment-methods</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-payment-methods"
                   id="all-payment-methods" @checked(in_array ('all-payment-methods', $role -> permissions()))>
            <label class="form-check-label" for="all-payment-methods">all payment methods</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-payment-methods"
                       id="edit-payment-methods" @checked(in_array ('edit-payment-methods', $role -> permissions()))>
                <label class="form-check-label" for="edit-payment-methods">edit payment methods</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-payment-methods"
                       id="delete-payment-methods" @checked(in_array ('delete-payment-methods', $role -> permissions()))>
                <label class="form-check-label" for="delete-payment-methods">delete payment methods</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add payment-methods</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-payment-methods"
                   id="add-payment-methods" @checked(in_array ('add-payment-methods', $role -> permissions()))>
            <label class="form-check-label" for="add-payment-methods">add payment methods</label>
        </div>
    </td>
</tr>