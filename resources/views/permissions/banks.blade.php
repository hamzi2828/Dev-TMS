<tr>
    <td colspan="2">
        <h5 class="mb-0">banks</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="banks"
                   id="banks" @checked(in_array ('banks', $role -> permissions()))>
            <label class="form-check-label" for="banks">banks</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">all banks</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-banks"
                   id="all-banks" @checked(in_array ('all-banks', $role -> permissions()))>
            <label class="form-check-label" for="all-banks">all banks</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-banks"
                       id="edit-banks" @checked(in_array ('edit-banks', $role -> permissions()))>
                <label class="form-check-label" for="edit-banks">edit banks</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-banks"
                       id="delete-banks" @checked(in_array ('delete-banks', $role -> permissions()))>
                <label class="form-check-label" for="delete-banks">delete banks</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add banks</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-banks"
                   id="add-banks" @checked(in_array ('add-banks', $role -> permissions()))>
            <label class="form-check-label" for="add-banks">add banks</label>
        </div>
    </td>
</tr>