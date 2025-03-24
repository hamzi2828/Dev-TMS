<tr>
    <td colspan="2">
        <h5 class="mb-0">MRF Candidate</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="mrf-candidates"
                   id="mrf-candidates" @checked(in_array ('mrf-candidates', $role -> permissions()))>
            <label class="form-check-label" for="mrf-candidates">MRF Candidate</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-mrf-candidates"
                       id="edit-mrf-candidates" @checked(in_array ('edit-mrf-candidates', $role -> permissions()))>
                <label class="form-check-label" for="edit-mrf-candidates">Edit MRF Candidate</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-mrf-candidates"
                       id="delete-mrf-candidates" @checked(in_array ('delete-mrf-candidates', $role -> permissions()))>
                <label class="form-check-label" for="delete-mrf-candidates">Delete MRF Candidate</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">Add MRF Candidates</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-mrf-candidates"
                   id="add-mrf-candidates" @checked(in_array ('add-mrf-candidates', $role -> permissions()))>
            <label class="form-check-label" for="add-mrf-candidates">Add MRF Candidate</label>
        </div>
    </td>
</tr>