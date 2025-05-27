<tr>
    <td colspan="2">
        <h5 class="mb-0"> Travel Agents</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="agents"
                   id="agents" @checked(in_array ('agents', $role -> permissions()))>
            <label class="form-check-label" for="agents"> Travel Agents</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">All Agents</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-agents"
                   id="all-agents" @checked(in_array ('all-agents', $role -> permissions()))>
            <label class="form-check-label" for="all-agents">All Agents</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-agents"
                       id="edit-agents" @checked(in_array ('edit-agents', $role -> permissions()))>
                <label class="form-check-label" for="edit-agents">edit agents</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-agents"
                       id="delete-agents" @checked(in_array ('delete-agents', $role -> permissions()))>
                <label class="form-check-label" for="delete-agents">delete agents</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add agents</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-agents"
                   id="add-agents" @checked(in_array ('add-agents', $role -> permissions()))>
            <label class="form-check-label" for="add-agents">add agents</label>
        </div>
    </td>
</tr>
