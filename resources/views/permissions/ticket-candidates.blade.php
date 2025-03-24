<tr>
    <td colspan="2">
        <h5 class="mb-0">ticket Candidates</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="ticket-candidates"
                   id="ticket-candidates" @checked(in_array ('ticket-candidates', $role -> permissions()))>
            <label class="form-check-label" for="ticket-candidates">ticket Candidates</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">All ticket Candidates</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-ticket-candidates"
                   id="all-ticket-candidates" @checked(in_array ('all-ticket-candidates', $role -> permissions()))>
            <label class="form-check-label" for="all-ticket-candidates">All ticket Candidates</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-ticket-candidates"
                       id="edit-ticket-candidates" @checked(in_array ('edit-ticket-candidates', $role -> permissions()))>
                <label class="form-check-label" for="edit-ticket-candidates">Edit ticket Candidates</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="ticket-follow-up"
                       id="ticket-follow-up" @checked(in_array ('ticket-follow-up', $role -> permissions()))>
                <label class="form-check-label" for="ticket-follow-up">Ticket Follow Up</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">Add ticket Candidates</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-ticket-candidates"
                   id="add-ticket-candidates" @checked(in_array ('add-ticket-candidates', $role -> permissions()))>
            <label class="form-check-label" for="add-ticket-candidates">Add ticket Candidates</label>
        </div>
    </td>
</tr>