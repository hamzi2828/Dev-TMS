<tr>
    <td colspan="2">
        <h5 class="mb-0">data banks</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="data-banks"
                   id="data-banks" @checked(in_array ('data-banks', $role -> permissions()))>
            <label class="form-check-label" for="data-banks">data banks</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">all data banks</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-data-banks"
                   id="all-data-banks" @checked(in_array ('all-data-banks', $role -> permissions()))>
            <label class="form-check-label" for="all-data-banks">all data banks</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-data-banks"
                       id="edit-data-banks" @checked(in_array ('edit-data-banks', $role -> permissions()))>
                <label class="form-check-label" for="edit-data-banks">edit data banks</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-data-banks"
                       id="delete-data-banks" @checked(in_array ('delete-data-banks', $role -> permissions()))>
                <label class="form-check-label" for="delete-data-banks">delete data banks</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add data banks</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-data-banks"
                   id="add-data-banks" @checked(in_array ('add-data-banks', $role -> permissions()))>
            <label class="form-check-label" for="add-data-banks">add data banks</label>
        </div>
    </td>
</tr>