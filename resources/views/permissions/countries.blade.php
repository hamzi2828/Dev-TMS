<tr>
    <td colspan="2">
        <h5 class="mb-0">countries</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="countries"
                   id="countries" @checked(in_array ('countries', $role -> permissions()))>
            <label class="form-check-label" for="countries">countries</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">all countries</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-countries"
                   id="all-countries" @checked(in_array ('all-countries', $role -> permissions()))>
            <label class="form-check-label" for="all-countries">all countries</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-countries"
                       id="edit-countries" @checked(in_array ('edit-countries', $role -> permissions()))>
                <label class="form-check-label" for="edit-countries">edit countries</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-countries"
                       id="delete-countries" @checked(in_array ('delete-countries', $role -> permissions()))>
                <label class="form-check-label" for="delete-countries">delete countries</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add countries</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-countries"
                   id="add-countries" @checked(in_array ('add-countries', $role -> permissions()))>
            <label class="form-check-label" for="add-countries">add countries</label>
        </div>
    </td>
</tr>