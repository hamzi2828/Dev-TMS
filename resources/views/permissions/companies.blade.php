<tr>
    <td colspan="2">
        <h5 class="mb-0">companies</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="companies"
                   id="companies" @checked(in_array ('companies', $role -> permissions()))>
            <label class="form-check-label" for="companies">companies</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">all companies</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-companies"
                   id="all-companies" @checked(in_array ('all-companies', $role -> permissions()))>
            <label class="form-check-label" for="all-companies">all companies</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-companies"
                       id="edit-companies" @checked(in_array ('edit-companies', $role -> permissions()))>
                <label class="form-check-label" for="edit-companies">edit companies</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-companies"
                       id="delete-companies" @checked(in_array ('delete-companies', $role -> permissions()))>
                <label class="form-check-label" for="delete-companies">delete companies</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add companies</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-companies"
                   id="add-companies" @checked(in_array ('add-companies', $role -> permissions()))>
            <label class="form-check-label" for="add-companies">add companies</label>
        </div>
    </td>
</tr>