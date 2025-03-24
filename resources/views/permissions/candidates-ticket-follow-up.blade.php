<tr>
    <td colspan="2">
        <h5 class="mb-0">ticket Follow Up</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="candidates-ticket-follow-up"
                   id="candidates-ticket-follow-up" @checked(in_array ('candidates-ticket-follow-up', $role -> permissions()))>
            <label class="form-check-label" for="candidates-ticket-follow-up">ticket Follow Up</label>
        </div>
    </td>
</tr>