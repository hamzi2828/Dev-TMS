<tr>
    <td colspan="2">
        <h5 class="mb-0">principals</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="principals"
                   id="principals" @checked(in_array ('principals', $role -> permissions()))>
            <label class="form-check-label" for="principals">principals</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">all principals</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-principals"
                   id="all-principals" @checked(in_array ('all-principals', $role -> permissions()))>
            <label class="form-check-label" for="all-principals">all principals</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-principals"
                       id="edit-principals" @checked(in_array ('edit-principals', $role -> permissions()))>
                <label class="form-check-label" for="edit-principals">edit principals</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-principals"
                       id="delete-principals" @checked(in_array ('delete-principals', $role -> permissions()))>
                <label class="form-check-label" for="delete-principals">delete principals</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add principals</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-principals"
                   id="add-principals" @checked(in_array ('add-principals', $role -> permissions()))>
            <label class="form-check-label" for="add-principals">add principals</label>
        </div>
    </td>
</tr>