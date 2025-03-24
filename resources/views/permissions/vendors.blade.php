<tr>
    <td colspan="2">
        <h5 class="mb-0">vendors</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="vendors"
                   id="vendors" @checked(in_array ('vendors', $role -> permissions()))>
            <label class="form-check-label" for="vendors">vendors</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">all vendors</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-vendors"
                   id="all-vendors" @checked(in_array ('all-vendors', $role -> permissions()))>
            <label class="form-check-label" for="all-vendors">all vendors</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-vendors"
                       id="edit-vendors" @checked(in_array ('edit-vendors', $role -> permissions()))>
                <label class="form-check-label" for="edit-vendors">edit vendors</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-vendors"
                       id="delete-vendors" @checked(in_array ('delete-vendors', $role -> permissions()))>
                <label class="form-check-label" for="delete-vendors">delete vendors</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add vendors</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-vendors"
                   id="add-vendors" @checked(in_array ('add-vendors', $role -> permissions()))>
            <label class="form-check-label" for="add-vendors">add vendors</label>
        </div>
    </td>
</tr>