<tr>
    <td colspan="2">
        <h5 class="mb-0">medical Candidates</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="medical-candidates"
                   id="medical-candidates" 
                   @checked(in_array ('medical-candidates', $role -> permissions()))>
            <label class="form-check-label" for="medical-candidates">medical Candidates</label>
        </div>
    </td>
</tr>


<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="candidate-medical-payment-method"
                       id="candidate-medical-payment-method" 
                       @checked(in_array ('candidate-medical-payment-method', $role -> permissions()))>
                <label class="form-check-label" for="candidate-medical-payment-method">
                    Payment Method
                </label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="candidate-medical-vendor"
                       id="candidate-medical-vendor"
                        @checked(in_array ('candidate-medical-vendor', $role -> permissions()))>
                <label class="form-check-label" for="candidate-medical-vendor">Vendor</label>
            </div>


            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="medical-candidate-trasaction-no"
                       id="medical-candidate-trasaction-no" 
                       @checked(in_array ('medical-candidate-trasaction-no', $role -> permissions()))>
                <label class="form-check-label" for="medical-candidate-trasaction-no">Transaction No </label>
            </div>



            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="medical-candidate-status"
                       id="medical-candidate-status" 
                       @checked(in_array ('medical-candidate-status', $role -> permissions()))>
                <label class="form-check-label" for="medical-candidate-status">Status</label>
            </div>


            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="medical-candidate-test-result"
                       id="medical-candidate-test-result" 
                       @checked(in_array ('medical-candidate-test-result', $role -> permissions()))>
                <label class="form-check-label" for="medical-candidate-test-result">Test Result</label>
            </div>


            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="medical-candidate-blood-group"
                       id="medical-candidate-blood-group"
                        @checked(in_array ('medical-candidate-blood-group', $role -> permissions()))>
                <label class="form-check-label" for="medical-candidate-blood-group">Blood Group</label>
            </div>
        </div>
    </td>
</tr>



<tr>
    <td></td>
    <td>
        <h6 class="mb-0">All medical Candidates</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-medical-candidates"
                   id="all-medical-candidates" @checked(in_array ('all-medical-candidates', $role -> permissions()))>
            <label class="form-check-label" for="all-medical-candidates">All medical Candidates</label>
        </div>
    </td>
</tr>

<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="print-candidates-medical-receipt"
                       id="print-candidates-medical-receipt" @checked(in_array ('print-candidates-medical-receipt', $role -> permissions()))>
                <label class="form-check-label" for="print-candidates-medical-receipt">
                    Print Candidates Medical Receipt
                </label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-medical-candidates"
                       id="edit-medical-candidates" @checked(in_array ('edit-medical-candidates', $role -> permissions()))>
                <label class="form-check-label" for="edit-medical-candidates">Edit medical Candidates</label>
            </div>
        </div>
    </td>
</tr>

<tr>
    <td></td>
    <td>
        <h6 class="mb-0">Add medical Candidates</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-medical-candidates"
                   id="add-medical-candidates" @checked(in_array ('add-medical-candidates', $role -> permissions()))>
            <label class="form-check-label" for="add-medical-candidates">Add medical Candidates</label>
        </div>
    </td>
</tr>