<tr>
    <td colspan="2">
        <h5 class="mb-0">referrals</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="referrals"
                   id="referrals" @checked(in_array ('referrals', $role -> permissions()))>
            <label class="form-check-label" for="referrals">referrals</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">all referrals</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-referrals"
                   id="all-referrals" @checked(in_array ('all-referrals', $role -> permissions()))>
            <label class="form-check-label" for="all-referrals">all referrals</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-referrals"
                       id="edit-referrals" @checked(in_array ('edit-referrals', $role -> permissions()))>
                <label class="form-check-label" for="edit-referrals">edit referrals</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-referrals"
                       id="delete-referrals" @checked(in_array ('delete-referrals', $role -> permissions()))>
                <label class="form-check-label" for="delete-referrals">delete referrals</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add referrals</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-referrals"
                   id="add-referrals" @checked(in_array ('add-referrals', $role -> permissions()))>
            <label class="form-check-label" for="add-referrals">add referrals</label>
        </div>
    </td>
</tr>