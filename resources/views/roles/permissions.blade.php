<div class="row mb-2 mt-2 border-top pt-2">
    <div class="col-lg-8 d-flex align-items-center">
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" id="check-all" />
            <label class="form-check-label" for="check-all">Assign All Privileges</label>
        </div>
    </div>

    <div class="col-lg-4">
        <label for="search-privileges" class="w-100">
            <input type="text" class="form-control" id="search-privileges" placeholder="Search Privileges">
        </label>
    </div>
</div>

<table class="table table-bordered text-capitalize mb-2" id="privileges">
    <thead>
    <tr>
        <th width="30%">Modules</th>
        <th width="30%">Sub Modules</th>
        <th width="40%">Privileges</th>
    </tr>
    </thead>
    <tbody>
    @include('permissions.dashboard')
    @include('permissions.accounts')
    @include('permissions.accounts-reporting')
    @include('permissions.accounts-settings')
    @include('permissions.airline-group')
    @include('permissions.my-booking')
    @include('permissions.settings')
    @include('permissions.users')`
    </tbody>
</table>
