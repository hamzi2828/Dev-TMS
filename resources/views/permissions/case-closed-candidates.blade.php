<tr>
    <td colspan="2">
        <h5 class="mb-0">case closed Candidates</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="case-closed-candidates"
                   id="case-closed-candidates" @checked(in_array ('case-closed-candidates', $role -> permissions()))>
            <label class="form-check-label" for="case-closed-candidates">case closed Candidates</label>
        </div>
    </td>
</tr>