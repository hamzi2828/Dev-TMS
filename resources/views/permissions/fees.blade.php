<tr>
    <td colspan="2">
        <h5 class="mb-0">fees</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="fees"
                   id="fees" @checked(in_array ('fees', $role -> permissions()))>
            <label class="form-check-label" for="fees">fees</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">all fees</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-fees"
                   id="all-fees" @checked(in_array ('all-fees', $role -> permissions()))>
            <label class="form-check-label" for="all-fees">all fees</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-fees"
                       id="edit-fees" @checked(in_array ('edit-fees', $role -> permissions()))>
                <label class="form-check-label" for="edit-fees">edit fees</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-fees"
                       id="delete-fees" @checked(in_array ('delete-fees', $role -> permissions()))>
                <label class="form-check-label" for="delete-fees">delete fees</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add fees</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-fees"
                   id="add-fees" @checked(in_array ('add-fees', $role -> permissions()))>
            <label class="form-check-label" for="add-fees">add fees</label>
        </div>
    </td>
</tr>