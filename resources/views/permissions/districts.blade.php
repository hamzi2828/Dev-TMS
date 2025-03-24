<tr>
    <td colspan="2">
        <h5 class="mb-0">districts</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="districts"
                   id="districts" @checked(in_array ('districts', $role -> permissions()))>
            <label class="form-check-label" for="districts">districts</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">all districts</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-districts"
                   id="all-districts" @checked(in_array ('all-districts', $role -> permissions()))>
            <label class="form-check-label" for="all-districts">all districts</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-districts"
                       id="edit-districts" @checked(in_array ('edit-districts', $role -> permissions()))>
                <label class="form-check-label" for="edit-districts">edit districts</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-districts"
                       id="delete-districts" @checked(in_array ('delete-districts', $role -> permissions()))>
                <label class="form-check-label" for="delete-districts">delete districts</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add districts</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-districts"
                   id="add-districts" @checked(in_array ('add-districts', $role -> permissions()))>
            <label class="form-check-label" for="add-districts">add districts</label>
        </div>
    </td>
</tr>