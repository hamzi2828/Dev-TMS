<tr>
    <td colspan="2">
        <h5 class="mb-0">cities</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="cities"
                   id="cities" @checked(in_array ('cities', $role -> permissions()))>
            <label class="form-check-label" for="cities">cities</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">all cities</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-cities"
                   id="all-cities" @checked(in_array ('all-cities', $role -> permissions()))>
            <label class="form-check-label" for="all-cities">all cities</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-cities"
                       id="edit-cities" @checked(in_array ('edit-cities', $role -> permissions()))>
                <label class="form-check-label" for="edit-cities">edit cities</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-cities"
                       id="delete-cities" @checked(in_array ('delete-cities', $role -> permissions()))>
                <label class="form-check-label" for="delete-cities">delete cities</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add cities</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-cities"
                   id="add-cities" @checked(in_array ('add-cities', $role -> permissions()))>
            <label class="form-check-label" for="add-cities">add cities</label>
        </div>
    </td>
</tr>