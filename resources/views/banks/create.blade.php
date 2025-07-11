<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')

        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">{{ $title }}</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('myBookings.storeBank') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="bank_name">Bank Name <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ old('bank_name') }}" required />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="bank_code">Branch Code</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="bank_code" name="bank_code" value="{{ old('bank_code') }}" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="bank_branch">Bank Branch</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="bank_branch" name="bank_branch" value="{{ old('bank_branch') }}" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="account_title">Account Title <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="account_title" name="account_title" value="{{ old('account_title') }}" required />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="account_number">Account Number <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="account_number" name="account_number" value="{{ old('account_number') }}" required />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="iban">IBAN</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="iban" name="iban" value="{{ old('iban') }}" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="logo">Bank Logo</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="logo" name="logo" accept="image/*" />
                            <small class="text-muted">Supported formats: JPG, JPEG, PNG, GIF (Max: 2MB)</small>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('banks.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- / Content -->
</x-dashboard>
