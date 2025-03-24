<tr>
    <td colspan="2">
        <h5 class="mb-0">Interview Candidates</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="interview-candidates"
                   id="interview-candidates" @checked(in_array ('interview-candidates', $role -> permissions()))>
            <label class="form-check-label" for="interview-candidates">Interview Candidates</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">All Interview Candidates</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-interview-candidates"
                   id="all-interview-candidates" @checked(in_array ('all-interview-candidates', $role -> permissions()))>
            <label class="form-check-label" for="all-interview-candidates">All Interview Candidates</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-interview-candidates"
                       id="edit-interview-candidates" @checked(in_array ('edit-interview-candidates', $role -> permissions()))>
                <label class="form-check-label" for="edit-interview-candidates">Edit Interview Candidates</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">Add Interview Candidates</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-interview-candidates"
                   id="add-interview-candidates" @checked(in_array ('add-interview-candidates', $role -> permissions()))>
            <label class="form-check-label" for="add-interview-candidates">Add Interview Candidates</label>
        </div>
    </td>
</tr>