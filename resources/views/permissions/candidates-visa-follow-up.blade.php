<tr>
    <td colspan="2">
        <h5 class="mb-0">visa Follow Up</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="candidates-visa-follow-up"
                   id="candidates-visa-follow-up" @checked(in_array ('candidates-visa-follow-up', $role -> permissions()))>
            <label class="form-check-label" for="candidates-visa-follow-up">visa Follow Up</label>
        </div>
    </td>
</tr>