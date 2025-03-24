<tr>
    <td colspan="2">
        <h5 class="mb-0">roles</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="roles"
                   id="roles" @checked(in_array ('roles', $role -> permissions()))>
            <label class="form-check-label" for="roles">roles</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">all roles</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-roles"
                   id="all-roles" @checked(in_array ('all-roles', $role -> permissions()))>
            <label class="form-check-label" for="all-roles">all roles</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-roles"
                       id="edit-roles" @checked(in_array ('edit-roles', $role -> permissions()))>
                <label class="form-check-label" for="edit-roles">edit roles</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-roles"
                       id="delete-roles" @checked(in_array ('delete-roles', $role -> permissions()))>
                <label class="form-check-label" for="delete-roles">delete roles</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add roles</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-roles"
                   id="add-roles" @checked(in_array ('add-roles', $role -> permissions()))>
            <label class="form-check-label" for="add-roles">add roles</label>
        </div>
    </td>
</tr>