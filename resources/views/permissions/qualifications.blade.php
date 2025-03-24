<tr>
    <td colspan="2">
        <h5 class="mb-0">qualifications</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="qualifications"
                   id="qualifications" @checked(in_array ('qualifications', $role -> permissions()))>
            <label class="form-check-label" for="qualifications">qualifications</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">all qualifications</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-qualifications"
                   id="all-qualifications" @checked(in_array ('all-qualifications', $role -> permissions()))>
            <label class="form-check-label" for="all-qualifications">all qualifications</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-qualifications"
                       id="edit-qualifications" @checked(in_array ('edit-qualifications', $role -> permissions()))>
                <label class="form-check-label" for="edit-qualifications">edit qualifications</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-qualifications"
                       id="delete-qualifications" @checked(in_array ('delete-qualifications', $role -> permissions()))>
                <label class="form-check-label" for="delete-qualifications">delete qualifications</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add qualifications</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-qualifications"
                   id="add-qualifications" @checked(in_array ('add-qualifications', $role -> permissions()))>
            <label class="form-check-label" for="add-qualifications">add qualifications</label>
        </div>
    </td>
</tr>