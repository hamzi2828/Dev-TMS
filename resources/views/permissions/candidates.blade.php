<tr>
    <td colspan="2">
        <h5 class="mb-0">Candidates</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="candidates" id="candidates" @checked(in_array ('candidates', $role -> permissions()))>
            <label class="form-check-label" for="candidates">Candidates</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">All Candidates</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-candidates"
                   id="all-candidates" @checked(in_array ('all-candidates', $role -> permissions()))>
            <label class="form-check-label" for="all-candidates">All Candidates</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="print-candidates-test-receipt"
                       id="print-candidates-test-receipt" @checked(in_array ('print-candidates-test-receipt', $role -> permissions()))>
                <label class="form-check-label"
                       for="print-candidates-test-receipt">
                    Print Candidates Test Receipt
                </label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="print-candidates-bio-data-form"
                       id="print-candidates-bio-data-form" @checked(in_array ('print-candidates-bio-data-form', $role -> permissions()))>
                <label class="form-check-label"
                       for="print-candidates-bio-data-form">
                    Print Candidates Bio-Data Form
                </label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="print-candidates-ticket"
                       id="print-candidates-ticket" @checked(in_array ('print-candidates-ticket', $role -> permissions()))>
                <label class="form-check-label" for="print-candidates-ticket">Print Candidates Ticket</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-candidates"
                       id="edit-candidates" @checked(in_array ('edit-candidates', $role -> permissions()))>
                <label class="form-check-label" for="edit-candidates">Edit Candidates</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="view-candidates"
                       id="view-candidates" @checked(in_array ('view-candidates', $role -> permissions()))>
                <label class="form-check-label" for="view-candidates">View Candidates</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-candidates"
                       id="delete-candidates" @checked(in_array ('delete-candidates', $role -> permissions()))>
                <label class="form-check-label" for="delete-candidates">Delete Candidates</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="candidates-attachments"
                       id="candidates-attachments" @checked(in_array ('candidates-attachments', $role -> permissions()))>
                <label class="form-check-label" for="candidates-attachments">Attachments</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="candidates-medical-status"
                       id="candidates-medical-status" @checked(in_array ('candidates-medical-status', $role -> permissions()))>
                <label class="form-check-label" for="candidates-medical-status">Medical Status</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="change-candidate-status"
                       id="change-candidate-status" @checked(in_array ('change-candidate-status', $role -> permissions()))>
                <label class="form-check-label" for="change-candidate-status">Active/Inactive Status</label>
            </div>
        </div>
    </td>
</tr> 
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">Add Candidates</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-candidates"
                   id="add-candidates" @checked(in_array ('add-candidates', $role -> permissions()))>
            <label class="form-check-label" for="add-candidates">Add Candidates</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">Candidates Billing</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="billing-candidates"
                   id="billing-candidates" @checked(in_array ('billing-candidates', $role -> permissions()))>
            <label class="form-check-label" for="billing-candidates">Candidates Billing</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">Discount (Flat)</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="candidate-discount-flat"
                   id="candidate-discount-flat" @checked(in_array ('candidate-discount-flat', $role -> permissions()))>
            <label class="form-check-label" for="candidate-discount-flat">Discount (Flat)</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">Trade Change</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="trade-change"
                   id="trade-change" @checked(in_array ('trade-change', $role -> permissions()))>
            <label class="form-check-label" for="trade-change">Trade Change</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">Documents Ready</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="documents-ready"
                   id="documents-ready" @checked(in_array ('documents-ready', $role -> permissions()))>
            <label class="form-check-label" for="documents-ready">Documents Ready</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">Accounts Clearance</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="candidate-clear-accounts"
                   id="candidate-clear-accounts" @checked(in_array ('candidate-clear-accounts', $role -> permissions()))>
            <label class="form-check-label" for="candidate-clear-accounts">Accounts Clearance</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">Proceed to Visa</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="proceed-to-visa"
                   id="proceed-to-visa" @checked(in_array ('proceed-to-visa', $role -> permissions()))>
            <label class="form-check-label" for="proceed-to-visa">Proceed to Visa</label>
        </div>
    </td>
</tr>