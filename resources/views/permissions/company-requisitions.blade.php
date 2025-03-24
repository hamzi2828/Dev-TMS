<tr>
    <td colspan="2">
        <h5 class="mb-0">mrf</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="mrf"
                   id="mrf" @checked(in_array ('mrf', $role -> permissions()))>
            <label class="form-check-label" for="mrf">mrf</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">all mrf</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-mrf"
                   id="all-mrf" @checked(in_array ('all-mrf', $role -> permissions()))>
            <label class="form-check-label" for="all-mrf">all mrf</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-mrf"
                       id="edit-mrf" @checked(in_array ('edit-mrf', $role -> permissions()))>
                <label class="form-check-label" for="edit-mrf">edit mrf</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-mrf"
                       id="delete-mrf" @checked(in_array ('delete-mrf', $role -> permissions()))>
                <label class="form-check-label" for="delete-mrf">delete mrf</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add mrf</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-mrf"
                   id="add-mrf" @checked(in_array ('add-mrf', $role -> permissions()))>
            <label class="form-check-label" for="add-mrf">add mrf</label>
        </div>
    </td>
</tr>