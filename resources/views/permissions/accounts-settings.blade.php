<tr>
    <td colspan="2">
        <h5 class="mb-0">accounts settings</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="accounts-settings"
                   id="accounts-settings" @checked(in_array ('accounts-settings', $role -> permissions()))>
            <label class="form-check-label" for="accounts-settings">accounts settings</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">account types</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="account-types"
                   id="account-types" @checked(in_array ('account-types', $role -> permissions()))>
            <label class="form-check-label" for="account-types">account types</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">all account types</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-account-types"
                   id="all-account-types" @checked(in_array ('all-account-types', $role -> permissions()))>
            <label class="form-check-label" for="all-account-types">all account types</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-account-types"
                       id="edit-account-types" @checked(in_array ('edit-account-types', $role -> permissions()))>
                <label class="form-check-label" for="edit-account-types">edit account types</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-account-types"
                       id="delete-account-types" @checked(in_array ('delete-account-types', $role -> permissions()))>
                <label class="form-check-label" for="delete-account-types">delete account types</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add account types</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-account-types"
                   id="add-account-types" @checked(in_array ('add-account-types', $role -> permissions()))>
            <label class="form-check-label" for="add-account-types">add account types</label>
        </div>
    </td>
</tr>