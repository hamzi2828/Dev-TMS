<tr>
    <td colspan="2">
        <h5 class="mb-0">Payment Follow Up</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="candidates-payment-follow-up"
                   id="candidates-payment-follow-up" @checked(in_array ('candidates-payment-follow-up', $role -> permissions()))>
            <label class="form-check-label" for="candidates-payment-follow-up">Payment Follow Up</label>
        </div>
    </td>
</tr>