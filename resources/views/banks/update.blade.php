<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')

        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">{{ $title }}</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('banks.update', $bank) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="bank_name">Bank Name <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ old('bank_name', $bank->bank_name) }}" required />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="bank_code">Bank Code</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="bank_code" name="bank_code" value="{{ old('bank_code', $bank->bank_code) }}" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="bank_branch">Bank Branch</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="bank_branch" name="bank_branch" value="{{ old('bank_branch', $bank->bank_branch) }}" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="account_title">Account Title <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="account_title" name="account_title" value="{{ old('account_title', $bank->account_title) }}" required />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="account_number">Account Number <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="account_number" name="account_number" value="{{ old('account_number', $bank->account_number) }}" required />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="iban">IBAN</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="iban" name="iban" value="{{ old('iban', $bank->iban) }}" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="logo">Bank Logo</label>
                        <div class="col-sm-10">
                            @if($bank->file)
                                <div class="mb-3">
                                    <img src="{{ $bank->file }}" alt="{{ $bank->bank_name }}" class="img-thumbnail" style="max-height: 100px;">
                                </div>
                            @endif
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
