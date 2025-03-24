<tr>
    <td colspan="2">
        <h5 class="mb-0">visa Candidates</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="visa-candidates"
                   id="visa-candidates" @checked(in_array ('visa-candidates', $role -> permissions()))>
            <label class="form-check-label" for="visa-candidates">visa Candidates</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">All visa Candidates</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-visa-candidates"
                   id="all-visa-candidates" @checked(in_array ('all-visa-candidates', $role -> permissions()))>
            <label class="form-check-label" for="all-visa-candidates">All visa Candidates</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-visa-candidates"
                       id="edit-visa-candidates" @checked(in_array ('edit-visa-candidates', $role -> permissions()))>
                <label class="form-check-label" for="edit-visa-candidates">Edit visa Candidates</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="visa-follow-up"
                       id="visa-follow-up" @checked(in_array ('visa-follow-up', $role -> permissions()))>
                <label class="form-check-label" for="visa-follow-up">Visa Follow Up</label>
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
                   value="add-visa-candidates"
                   id="add-visa-candidates" @checked(in_array ('add-visa-candidates', $role -> permissions()))>
            <label class="form-check-label" for="add-visa-candidates">Add visa Candidates</label>
        </div>
    </td>
</tr>