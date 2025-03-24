<tr>
    <td colspan="2">
        <h5 class="mb-0">provinces</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="provinces"
                   id="provinces" @checked(in_array ('provinces', $role -> permissions()))>
            <label class="form-check-label" for="provinces">provinces</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">all provinces</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-provinces"
                   id="all-provinces" @checked(in_array ('all-provinces', $role -> permissions()))>
            <label class="form-check-label" for="all-provinces">all provinces</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-provinces"
                       id="edit-provinces" @checked(in_array ('edit-provinces', $role -> permissions()))>
                <label class="form-check-label" for="edit-provinces">edit provinces</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-provinces"
                       id="delete-provinces" @checked(in_array ('delete-provinces', $role -> permissions()))>
                <label class="form-check-label" for="delete-provinces">delete provinces</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add provinces</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-provinces"
                   id="add-provinces" @checked(in_array ('add-provinces', $role -> permissions()))>
            <label class="form-check-label" for="add-provinces">add provinces</label>
        </div>
    </td>
</tr>