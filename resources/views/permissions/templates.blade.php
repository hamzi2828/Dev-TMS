<tr>
    <td colspan="2">
        <h5 class="mb-0">templates</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="templates"
                   id="templates" @checked(in_array ('templates', $role -> permissions()))>
            <label class="form-check-label" for="templates">templates</label>
        </div>
    </td>
</tr>
@include('permissions.agreements')