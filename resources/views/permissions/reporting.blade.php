<tr>
    <td colspan="2">
        <h5 class="mb-0">reporting</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="reporting"
                   id="reporting" @checked(in_array ('reporting', $role -> permissions()))>
            <label class="form-check-label" for="reporting">reporting</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">status check (Detail)</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="status-check"
                   id="status-check" @checked(in_array ('status-check', $role -> permissions()))>
            <label class="form-check-label" for="status-check">status check (detail)</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">summary report</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="summary-report"
                   id="summary-report" @checked(in_array ('summary-report', $role -> permissions()))>
            <label class="form-check-label" for="summary-report">summary report</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">follow up report</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="follow-up-report"
                   id="follow-up-report" @checked(in_array ('follow-up-report', $role -> permissions()))>
            <label class="form-check-label" for="follow-up-report">follow up report</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">missing docs report</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="missing-docs-report"
                   id="missing-docs-report" @checked(in_array ('missing-docs-report', $role -> permissions()))>
            <label class="form-check-label" for="missing-docs-report">missing docs report</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">Cheque Details Report</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="cheque-details-report"
                   id="cheque-details-report" @checked(in_array ('cheque-details-report', $role -> permissions()))>
            <label class="form-check-label" for="cheque-details-report">Cheque Details Report</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">Gross Profit Report</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="gross-profit-report"
                   id="gross-profit-report" @checked(in_array ('gross-profit-report', $role -> permissions()))>
            <label class="form-check-label" for="gross-profit-report">Gross Profit Report</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">QJ Medical Report</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="qj-medical-report"
                   id="qj-medical-report" @checked(in_array ('qj-medical-report', $role -> permissions()))>
            <label class="form-check-label" for="QJ Medical Report">QJ Medical Report</label>
        </div>
    </td>
</tr>
