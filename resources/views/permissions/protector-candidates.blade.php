<tr>
    <td colspan="2">
        <h5 class="mb-0">protector Candidates</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="protector-candidates"
                   id="protector-candidates" @checked(in_array ('protector-candidates', $role -> permissions()))>
            <label class="form-check-label" for="protector-candidates">protector Candidates</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">All protector Candidates</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-protector-candidates"
                   id="all-protector-candidates" @checked(in_array ('all-protector-candidates', $role -> permissions()))>
            <label class="form-check-label" for="all-protector-candidates">All protector Candidates</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-protector-candidates"
                       id="edit-protector-candidates" @checked(in_array ('edit-protector-candidates', $role -> permissions()))>
                <label class="form-check-label" for="edit-protector-candidates">Edit protector Candidates</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">Add protector Candidates</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-protector-candidates"
                   id="add-protector-candidates" @checked(in_array ('add-protector-candidates', $role -> permissions()))>
            <label class="form-check-label" for="add-protector-candidates">Add protector Candidates</label>
        </div>
    </td>
</tr>