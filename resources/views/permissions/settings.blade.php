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
{{-- @include('permissions.jobs') --}}
{{-- @include('permissions.qualifications') --}}
@include('permissions.banks')
@include('permissions.payment-methods')

<tr>
    <td colspan="2">
        <h5 class="mb-0">Travel Agents</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="travel-agents"
                   id="travel-agents" @checked(in_array ('travel-agents', $role -> permissions()))>
            <label class="form-check-label" for="travel-agents">travel agents</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">all travel-agents</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="all-travel-agents"
                   id="all-travel-agents" @checked(in_array ('all-travel-agents', $role -> permissions()))>
            <label class="form-check-label" for="all-travel-agents">all travel agents</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="edit-travel-agents"
                       id="edit-travel-agents" @checked(in_array ('edit-travel-agents', $role -> permissions()))>
                <label class="form-check-label" for="edit-travel-agents">edit travel agents</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="permission[]"
                       value="delete-travel-agents"
                       id="delete-travel-agents" @checked(in_array ('delete-travel-agents', $role -> permissions()))>
                <label class="form-check-label" for="delete-travel-agents">delete travel agents</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h6 class="mb-0">add travel-agents</h6>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="permission[]"
                   value="add-travel-agents"
                   id="add-travel-agents" @checked(in_array ('add-travel-agents', $role -> permissions()))>
            <label class="form-check-label" for="add-travel-agents">add travel agents</label>
        </div>
    </td>
</tr>
@include('permissions.vendors')
@include('permissions.agents')
{{-- @include('permissions.principals') --}}
@include('permissions.referrals')
@include('permissions.companies')
{{-- @include('permissions.fees') --}}
@include('permissions.airlines')
@include('permissions.countries')
@include('permissions.cities')

@include('permissions.roles')
@include('permissions.site-settings')
