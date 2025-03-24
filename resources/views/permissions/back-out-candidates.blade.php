<tr>
    <td colspan="2">
        <h5 class="mb-0">back out Candidates</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="back-out-candidates"
                   id="back-out-candidates" @checked(in_array ('back-out-candidates', $role -> permissions()))>
            <label class="form-check-label" for="back-out-candidates">back out Candidates</label>
        </div>
    </td>
<tr>
    <td colspan="2">
        <h5 class="mb-0">back out Candidates</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="un-back-out-candidates"
                   id="un-back-out-candidates" @checked(in_array ('un-back-out-candidates', $role -> permissions()))>
            <label class="form-check-label" for="un-back-out-candidates">unback Candidates</label>
        </div>
    </td>
</tr>