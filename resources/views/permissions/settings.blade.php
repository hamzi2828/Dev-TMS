<tr>
    <td colspan="2">
        <h5 class="mb-0">settings</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="settings"
                   id="settings" @checked(in_array ('settings', $role -> permissions()))>
            <label class="form-check-label" for="settings">settings</label>
        </div>
    </td>
</tr>
@include('permissions.jobs')
@include('permissions.qualifications')
@include('permissions.banks')
@include('permissions.payment-methods')
@include('permissions.vendors')
@include('permissions.agents')
@include('permissions.principals')
@include('permissions.referrals')
@include('permissions.companies')
@include('permissions.fees')
@include('permissions.airlines')
@include('permissions.countries')
@include('permissions.cities')
@include('permissions.provinces')
@include('permissions.districts')
@include('permissions.roles')
@include('permissions.site-settings')