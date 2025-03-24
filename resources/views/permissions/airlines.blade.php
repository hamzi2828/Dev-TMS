<tr>
    <td colspan="2">
        <h5 class="mb-0">airlines</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="airlines"
                   id="airlines" @checked(in_array ('airlines', $role -> permissions()))>
            <label class="form-check-label" for="airlines">airlines</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">all airlines</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-airlines"
                   id="all-airlines" @checked(in_array ('all-airlines', $role -> permissions()))>
            <label class="form-check-label" for="all-airlines">all airlines</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-airlines"
                       id="edit-airlines" @checked(in_array ('edit-airlines', $role -> permissions()))>
                <label class="form-check-label" for="edit-airlines">edit airlines</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-airlines"
                       id="delete-airlines" @checked(in_array ('delete-airlines', $role -> permissions()))>
                <label class="form-check-label" for="delete-airlines">delete airlines</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add airlines</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-airlines"
                   id="add-airlines" @checked(in_array ('add-airlines', $role -> permissions()))>
            <label class="form-check-label" for="add-airlines">add airlines</label>
        </div>
    </td>
</tr>