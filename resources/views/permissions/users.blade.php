<tr>
    <td colspan="2">
        <h5 class="mb-0">users</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="users"
                   id="users" @checked(in_array ('users', $role -> permissions()))>
            <label class="form-check-label" for="users">users</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">All users</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-users"
                   id="all-users" @checked(in_array ('all-users', $role -> permissions()))>
            <label class="form-check-label" for="all-users">All users</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-users"
                       id="edit-users" @checked(in_array ('edit-users', $role -> permissions()))>
                <label class="form-check-label" for="edit-users">Edit users</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="status-users"
                       id="status-users" @checked(in_array ('status-users', $role -> permissions()))>
                <label class="form-check-label" for="status-users">
                    Change users Status
                </label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-users"
                       id="delete-users" @checked(in_array ('delete-users', $role -> permissions()))>
                <label class="form-check-label" for="delete-users">
                    Delete users
                </label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">Add Candidates</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-users"
                   id="add-users" @checked(in_array ('add-users', $role -> permissions()))>
            <label class="form-check-label" for="add-users">Add users</label>
        </div>
    </td>
</tr>