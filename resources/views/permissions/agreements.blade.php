<tr>
    <td colspan="2">
        <h5 class="mb-0">agreements</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="agreements"
                   id="agreements" @checked(in_array ('agreements', $role -> permissions()))>
            <label class="form-check-label" for="agreements">agreements</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">all agreements</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-agreements"
                   id="all-agreements" @checked(in_array ('all-agreements', $role -> permissions()))>
            <label class="form-check-label" for="all-agreements">all agreements</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-agreements"
                       id="edit-agreements" @checked(in_array ('edit-agreements', $role -> permissions()))>
                <label class="form-check-label" for="edit-agreements">edit agreements</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-agreements"
                       id="delete-agreements" @checked(in_array ('delete-agreements', $role -> permissions()))>
                <label class="form-check-label" for="delete-agreements">delete agreements</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add agreements</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-agreements"
                   id="add-agreements" @checked(in_array ('add-agreements', $role -> permissions()))>
            <label class="form-check-label" for="add-agreements">add agreements</label>
        </div>
    </td>
</tr>