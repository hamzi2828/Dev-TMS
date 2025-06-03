<tr>
    <td colspan="2">
        <h5 class="mb-0">Airline Groups</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="airlineGroups"
                   id="airlineGroups" @checked(in_array ('airlineGroups', $role -> permissions()))>
            <label class="form-check-label" for="airlineGroups">Airline Groups</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">all airline groups</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-airline-groups"
                   id="all-airline-groups" @checked(in_array ('all-airline-groups', $role -> permissions()))>
            <label class="form-check-label" for="all-airline-groups">all airline groups</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-all-airline-groups"
                       id="edit-all-airline-groups" @checked(in_array ('edit-all-airline-groups', $role -> permissions()))>
                <label class="form-check-label" for="edit-all-airline-groups">Edit</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="status-all-airline-groups"
                       id="status-all-airline-groups" @checked(in_array ('status-all-airline-groups', $role -> permissions()))>
                <label class="form-check-label" for="status-all-airline-groups">Status</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-all-airline-groups"
                       id="delete-all-airline-groups" @checked(in_array ('delete-all-airline-groups', $role -> permissions()))>
                <label class="form-check-label" for="delete-all-airline-groups">Delete</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0"> airline groups (Inactive)</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="inactive-airline-groups"
                   id="inactive-airline-groups" @checked(in_array ('inactive-airline-groups', $role -> permissions()))>
            <label class="form-check-label" for="inactive-airline-groups">Inactive</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-inactive-airline-groups"
                       id="edit-inactive-airline-groups" @checked(in_array ('edit-inactive-airline-groups', $role -> permissions()))>
                <label class="form-check-label" for="edit-inactive-airline-groups">Edit</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="status-inactive-airline-groups"
                       id="status-inactive-airline-groups" @checked(in_array ('status-inactive-airline-groups', $role -> permissions()))>
                <label class="form-check-label" for="status-inactive-airline-groups">Status</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-inactive-airline-groups"
                       id="delete-inactive-airline-groups" @checked(in_array ('delete-inactive-airline-groups', $role -> permissions()))>
                <label class="form-check-label" for="delete-inactive-airline-groups">Delete</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0"> airline groups (Flown)</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="flown-airline-groups"
                   id="flown-airline-groups" @checked(in_array ('flown-airline-groups', $role -> permissions()))>
            <label class="form-check-label" for="flown-airline-groups">Flown</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-flown-airline-groups"
                       id="edit-flown-airline-groups" @checked(in_array ('edit-flown-airline-groups', $role -> permissions()))>
                <label class="form-check-label" for="edit-flown-airline-groups">Edit</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="status-flown-airline-groups"
                       id="status-flown-airline-groups" @checked(in_array ('status-flown-airline-groups', $role -> permissions()))>
                <label class="form-check-label" for="status-flown-airline-groups">Status</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-flown-airline-groups"
                       id="delete-flown-airline-groups" @checked(in_array ('delete-flown-airline-groups', $role -> permissions()))>
                <label class="form-check-label" for="delete-flown-airline-groups">Delete</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">Add airline groups</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-airline-groups"
                   id="add-airline-groups" @checked(in_array ('add-airline-groups', $role -> permissions()))>
            <label class="form-check-label" for="add-airline-groups">Add Airline Groups</label>
        </div>
    </td>
</tr>
