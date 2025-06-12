<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')

        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $title }}</h5>
                    </div>
                </div>
            </div>
        </div>

        @if($banks->count() > 0)
            <div class="row">
                @foreach($banks as $bank)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    @if($bank->file)
                                        <div class="bank-logo-container bg-white rounded p-1 me-3">
                                            <img src="{{ $bank->file }}" alt="{{ $bank->bank_name }}" class="bank-logo" style="max-height: 40px; max-width: 80px; object-fit: contain;">
                                        </div>
                                    @endif
                                    <h5 class="text-white mb-0 fw-bold">{{ $bank->bank_name }}</h5>
                                </div>

                            </div>
                            <div class="card-body p-4">
                                <div class="row mb-3">
                                    <div class="col-5 text-muted">Account Title</div>
                                    <div class="col-7 fw-bold">{{ $bank->account_title }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-5 text-muted">Account Number</div>
                                    <div class="col-7 fw-bold">{{ $bank->account_number }}</div>
                                </div>
                                @if($bank->iban)
                                <div class="row mb-3">
                                    <div class="col-5 text-muted">IBAN</div>
                                    <div class="col-7">{{ $bank->iban }}</div>
                                </div>
                                @endif
                                <hr class="my-3">
                                <div class="row">
                                    @if($bank->bank_code)
                                    <div class="col-md-6 mb-2">
                                        <div class="text-muted small">Branch Code</div>
                                        <div>{{ $bank->bank_code }}</div>
                                    </div>
                                    @endif
                                    @if($bank->bank_branch)
                                    <div class="col-md-6 mb-2">
                                        <div class="text-muted small">Branch</div>
                                        <div>{{ $bank->bank_branch }}</div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center py-5">
                            <div class="mb-4">
                                <i class="bx bx-bank text-primary" style="font-size: 4rem;"></i>
                            </div>
                            <h4 class="mb-3">No bank details found</h4>
                            <p class="text-muted mb-4">You haven't added any bank details yet.</p>
                            <a href="{{ route('myBookings.createBank') }}" class="btn btn-primary">
                                <i class="bx bx-plus me-1"></i> Add Bank Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!-- / Content -->
</x-dashboard>
