<tr>
    <td colspan="2">
        <h5 class="mb-0">dashboard</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="dashboard" id="dashboard" @checked(in_array ('dashboard', $role -> permissions()))>
            <label class="form-check-label" for="dashboard">dashboard</label>
        </div>
    </td>
</tr>