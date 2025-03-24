<tr>
    <td colspan="2">
        <h5 class="mb-0">site settings</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="site-settings"
                   id="site-settings" @checked(in_array ('site-settings', $role -> permissions()))>
            <label class="form-check-label" for="site-settings">site settings</label>
        </div>
    </td>
</tr>