<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xl-12 mb-4 col-lg-12 col-12">
                <div class="card h-100">
                    <div class="card-header border-bottom pb-0 mb-4">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="card-title mb-0">Statistics</h5>
                            <small class="text-muted">Updated Real Time</small>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-md-2 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-primary me-3 p-2">
                                        <i class="ti ti-clipboard-typography ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0 income-from-test"><i class="ti ti-loader"></i></h5>
                                        <small>Income (Test)</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-info me-3 p-2">
                                        <i class="ti ti-heartbeat ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0 income-from-medical"><i class="ti ti-loader"></i></h5>
                                        <small>Income (Medical)</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-info me-3 p-2">
                                        <i class="ti ti-users-group ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0 income-from-candidates"><i class="ti ti-loader"></i></h5>
                                        <small>Income (Candidates)</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-danger me-3 p-2">
                                        <i class="ti ti-credit-card ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0 payable-count">
                                            <i class="ti ti-loader"></i>
                                        </h5>
                                        <small>Payable</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-success me-3 p-2">
                                        <i class="ti ti-currency-dollar ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0 receivable-count">
                                            <i class="ti ti-loader"></i>
                                        </h5>
                                        <small>Receivable</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-12">
                <div class="row">
                    <div class="col-xl-12 mb-4 col-lg-12 col-12">
                        <div class="card">
                            <div class="d-flex align-items-end row">
                                <div class="col-7">
                                    <div class="card-body text-nowrap">
                                        <h5 class="card-title mb-0">Welcome, {{ auth () -> user () -> fullName() }}
                                                                    🎉</h5>
                                        <p class="mb-2">
                                            @if(count (auth () -> user () -> get_user_roles()) > 0)
                                                <b>Roles</b>
                                                : {{ implode (',', auth () -> user () -> get_user_roles()) }}
                                            @endif
                                        </p>
                                        <h4 class="text-primary mb-1">0</h4>
                                        <a href="#" class="btn btn-primary btn-sm">
                                            View Candidates
                                        </a>
                                    </div>
                                </div>
                                <div class="col-5 text-center text-sm-left">
                                    <div class="card-body pb-0 px-0 px-md-4">
                                        <img src="{{ asset('/assets/img/illustrations/card-advance-sale.png') }}"
                                             height="140"
                                             alt="view candidates" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 mb-4 col-md-3 col-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Expenses</h5>
                                <small class="text-muted">Current Month</small>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center gap-3">
                                    <h1 class="card-title mb-0">
                                        <i class="tf-icons ti ti-wallet fs-1"></i>
                                        {{ (new \App\Http\Helpers\GeneralHelper()) -> format_currency (abs ($general_admin_expenses['net'])) }}
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 mb-4 col-md-3 col-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Profit</h5>
                                <small class="text-muted">Current Month</small>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center gap-3">
                                    <h1 class="mb-0">
                                        <i class="tf-icons ti ti-chart-dots-2 fs-1"></i>
                                        {{ (new \App\Http\Helpers\GeneralHelper()) -> format_currency (abs ($profit)) }}
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 mb-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-column">
                                        <div class="card-title mb-auto">
                                            <h5 class="mb-1 text-nowrap">Balances</h5>
                                            <small>Daily Closing's</small>
                                        </div>
                                        <div class="chart-statistics">
                                            <ol class="fs-tiny mb-1 mt-2 ps-3">
                                                @if(count ($daily_cash_balances['title']) > 0)
                                                    @foreach($daily_cash_balances['title'] as $title)
                                                        <li>{{ $title }}</li>
                                                    @endforeach
                                                @endif
                                            </ol>
                                            <h3 class="card-title mb-1">
                                                {{ number_format ($daily_cash_balances['sum'], 2) }}
                                            </h3>
                                        </div>
                                    </div>
                                    <div id="generatedLeadsChart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-8 mb-4">
                <div class="card">
                    <div class="card-header header-elements">
                        <h5 class="card-title mb-0">Banks Statistics (Current Month)</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="barChart" class="chartjs" data-height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header p-0">
                        <h5 class="card-header border-bottom pt-3 pb-2 mb-3">Interviews</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="card h-100 bg-gradient-light">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1 pt-1 fs-big">Selected</h5>
                                        <p class="mb-2 mt-1 fs-1 fw-bold text-success">
                                            {{ (new \App\Http\Helpers\GeneralHelper()) -> format_currency ($selected_interviews) }}
                                        </p>
                                        <small class="text-muted">Daily Candidates</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="card h-100 bg-gradient-light">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1 pt-1 fs-big">Rejected</h5>
                                        <p class="mb-2 mt-1 fs-1 fw-bold text-danger">
                                            {{ (new \App\Http\Helpers\GeneralHelper()) -> format_currency ($rejected_interviews) }}
                                        </p>
                                        <small class="text-muted">Daily Candidates</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header p-0">
                        <h5 class="card-header border-bottom pt-3 pb-2 mb-3">Medicals</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="card h-100 bg-gradient-light">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1 pt-1 fs-big">Fit</h5>
                                        <p class="mb-2 mt-1 fs-1 fw-bold text-success">
                                            {{ (new \App\Http\Helpers\GeneralHelper()) -> format_currency ($fit_medicals) }}
                                        </p>
                                        <small class="text-muted">Daily Candidates</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="card h-100 bg-gradient-light">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1 pt-1 fs-big">UnFit</h5>
                                        <p class="mb-2 mt-1 fs-1 fw-bold text-danger">
                                            {{ (new \App\Http\Helpers\GeneralHelper()) -> format_currency ($unfit_medicals) }}
                                        </p>
                                        <small class="text-muted">Daily Candidates</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header p-0">
                        <h5 class="card-header border-bottom pt-3 pb-2 mb-3">
                            Documents Ready <small>(Proceeding For Visa)</small>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="card h-100 bg-gradient-light">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1 pt-1 fs-big">Ready</h5>
                                        <p class="mb-2 mt-1 fs-1 fw-bold text-success">
                                            {{ (new \App\Http\Helpers\GeneralHelper()) -> format_currency ($documents_ready) }}
                                        </p>
                                        <small class="text-muted">Daily Candidates</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="card h-100 bg-gradient-light">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1 pt-1 fs-big">Not Ready</h5>
                                        <p class="mb-2 mt-1 fs-1 fw-bold text-danger">
                                            {{ (new \App\Http\Helpers\GeneralHelper()) -> format_currency ($not_documents_ready) }}
                                        </p>
                                        <small class="text-muted">Daily Candidates</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header p-0">
                        <h5 class="card-header border-bottom pt-3 pb-2 mb-3">
                            Documents Uploaded <small>(For Visa)</small>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="card h-100 bg-gradient-light">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1 pt-1 fs-big">Uploaded</h5>
                                        <p class="mb-2 mt-1 fs-1 fw-bold text-success">
                                            {{ (new \App\Http\Helpers\GeneralHelper()) -> format_currency ($documents_uploaded) }}
                                        </p>
                                        <small class="text-muted">Daily Candidates</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="card h-100 bg-gradient-light">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1 pt-1 fs-big">Not Uploaded</h5>
                                        <p class="mb-2 mt-1 fs-1 fw-bold text-danger">
                                            {{ (new \App\Http\Helpers\GeneralHelper()) -> format_currency ($not_documents_uploaded) }}
                                        </p>
                                        <small class="text-muted">Daily Candidates</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header p-0">
                        <h5 class="card-header border-bottom pt-3 pb-2 mb-3">Visas</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="card h-100 bg-gradient-light">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1 pt-1 fs-big">Issued</h5>
                                        <p class="mb-2 mt-1 fs-1 fw-bold text-success">
                                            {{ (new \App\Http\Helpers\GeneralHelper()) -> format_currency ($issued_visas) }}
                                        </p>
                                        <small class="text-muted">Daily Candidates</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="card h-100 bg-gradient-light">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1 pt-1 fs-big">Rejected</h5>
                                        <p class="mb-2 mt-1 fs-1 fw-bold text-danger">
                                            {{ (new \App\Http\Helpers\GeneralHelper()) -> format_currency ($rejected_visas) }}
                                        </p>
                                        <small class="text-muted">Daily Candidates</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header p-0">
                        <h5 class="card-header border-bottom pt-3 pb-2 mb-3">Protectors</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="card h-100 bg-gradient-light">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1 pt-1 fs-big">Sent</h5>
                                        <p class="mb-2 mt-1 fs-1 fw-bold text-warning">
                                            {{ (new \App\Http\Helpers\GeneralHelper()) -> format_currency ($sent_protectors) }}
                                        </p>
                                        <small class="text-muted">Daily Candidates</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="card h-100 bg-gradient-light">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1 pt-1 fs-big">Done</h5>
                                        <p class="mb-2 mt-1 fs-1 fw-bold text-success">
                                            {{ (new \App\Http\Helpers\GeneralHelper()) -> format_currency ($done_protectors) }}
                                        </p>
                                        <small class="text-muted">Daily Candidates</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header p-0">
                        <h5 class="card-header border-bottom pt-3 pb-2 mb-3">Tickets</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="card h-100 bg-gradient-light">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1 pt-1 fs-big">Confirmed</h5>
                                        <p class="mb-2 mt-1 fs-1 fw-bold text-success">
                                            {{ (new \App\Http\Helpers\GeneralHelper()) -> format_currency ($confirmed_tickets) }}
                                        </p>
                                        <small class="text-muted">Daily Candidates</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="card h-100 bg-gradient-light">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1 pt-1 fs-big">Travelled</h5>
                                        <p class="mb-2 mt-1 fs-1 fw-bold text-danger">
                                            {{ (new \App\Http\Helpers\GeneralHelper()) -> format_currency ($travelled_tickets) }}
                                        </p>
                                        <small class="text-muted">Daily Candidates</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 d-none">
        <div class="col-md-8">
            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="card">
                        <div class="card-header header-elements">
                            <h5 class="card-title mb-0">Status Statistics</h5>
                        </div>
                        <div class="card-body">
                            <div id="status-statistics"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
    @push('scripts')
        <script src="{{ asset('/assets/vendor/libs/chartjs/chartjs.js') }}"></script>
        <script src="{{ asset('/assets/vendor/js/charts/apexcharts.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/eligrey-classlist-js-polyfill@1.2.20171210/classList.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/findindex_polyfill_mdn"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        @include('dashboard.chartJS')
        @include('dashboard.apexChart')
        <script type="text/javascript">
            $ ( window ).on ( 'load', function () {
                get_payable_count ( '{{ route ('analytics.payable') }}' );
                get_receivable_count ( '{{ route ('analytics.receivable') }}' );
                get_test_income_count ( '{{ route ('analytics.income-from-test') }}' );
                get_medical_income_count ( '{{ route ('analytics.income-from-medical') }}' );
                get_candidate_income_count ( '{{ route ('analytics.income-from-candidate') }}' );
            } )
        </script>
    @endpush
</x-dashboard>