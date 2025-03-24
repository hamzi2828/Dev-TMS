<tr>
    <td colspan="2">
        <h5 class="mb-0">professions</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="jobs"
                   id="jobs" @checked(in_array ('jobs', $role -> permissions()))>
            <label class="form-check-label" for="jobs">professions</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">all jobs</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-jobs"
                   id="all-jobs" @checked(in_array ('all-jobs', $role -> permissions()))>
            <label class="form-check-label" for="all-jobs">all professions</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-jobs"
                       id="edit-jobs" @checked(in_array ('edit-jobs', $role -> permissions()))>
                <label class="form-check-label" for="edit-jobs">edit professions</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-jobs"
                       id="delete-jobs" @checked(in_array ('delete-jobs', $role -> permissions()))>
                <label class="form-check-label" for="delete-jobs">delete professions</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add jobs</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-jobs"
                   id="add-jobs" @checked(in_array ('add-jobs', $role -> permissions()))>
            <label class="form-check-label" for="add-jobs">add professions</label>
        </div>
    </td>
</tr>