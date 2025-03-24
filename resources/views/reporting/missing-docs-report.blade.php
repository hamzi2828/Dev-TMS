<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="card mb-3">
            <div class="card-header border-bottom pt-3 pb-3">
                <h5 class="card-title mb-0">Search</h5>
            </div>
            <div class="card-body mt-3">
                <form method="get" action="{{ route ('reporting.missing-docs-report') }}">
                    <div class="row">
                        <div class="col-md-3 form-group mb-3">
                            <label class="form-label" for="start-date">Start Date</label>
                            <input type="text" name="start-date" class="form-control flatpickr-basic" id="start-date"
                                   value="{{ request ('start-date') }}">
                        </div>
                        
                        <div class="col-md-3 form-group mb-3">
                            <label class="form-label" for="end-date">End Date</label>
                            <input type="text" name="end-date" class="form-control flatpickr-basic" id="end-date"
                                   value="{{ request ('end-date') }}">
                        </div>
                        <div class="col-md-2 form-group">
                            <button type="submit" class="btn btn-primary w-100 mt-4">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom pt-3 pb-3 d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">{{ $title }}</h5>
                <a href="javascript:void(0)" onclick="downloadExcel('Missing Docs Report')"
                   class="btn btn-sm btn-primary">
                    <i class="tf-icons ti ti-file-spreadsheet fs-6 me-1"></i>
                    Download Excel
                </a>
            </div>
            <div class="card-datatable table-responsive">
                <table class="table table-hover table-sm table-bordered" id="excel-table">
                    <thead class="border-top">
                    <tr>
                        <th>#</th>
                        <th>Sr. No</th>
                        <th>Applied For</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>CNIC</th>
                        <th>Missing Docs</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count ($candidates) > 0)
                        @foreach($candidates as $candidate)
                            <tr>
                                <td>{{ $loop -> iteration }}</td>
                                <td>{{ $candidate -> SerialNo() }}</td>
                                <td>{{ $candidate -> job ?-> title }}</td>
                                <td>{{ $candidate -> fullName() }}</td>
                                <td>{{ $candidate -> mobile }}</td>
                                <td>{{ $candidate -> cnic }}</td>
                                <td>
                                    {!! (!$candidate -> document || empty(trim ($candidate -> document -> picture))) ? 'Picture <br/>' : '' !!}
                                    {!! (!$candidate -> document || empty(trim ($candidate -> document -> passport))) ? 'Passport <br/>' : '' !!}
                                    {!! (!$candidate -> document || empty(trim ($candidate -> document -> cnic_front))) ? 'CNIC Front <br/>' : '' !!}
                                    {!! (!$candidate -> document || empty(trim ($candidate -> document -> cnic_back))) ? 'CNIC Back <br/>' : '' !!}
                                    {!! (!$candidate -> document || empty(trim ($candidate -> document -> nicop_front))) ? 'NICOP Front <br/>' : '' !!}
                                    {!! (!$candidate -> document || empty(trim ($candidate -> document -> nicop_back))) ? 'NICOP Back <br/>' : '' !!}
                                    {!! (!$candidate -> document || empty(trim ($candidate -> document -> nok_1))) ? 'Next of kin# 1 <br/>' : '' !!}
                                    {!! (!$candidate -> document || empty(trim ($candidate -> document -> nok_2))) ? 'Next of kin# 2 <br/>' : '' !!}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- / Content -->
</x-dashboard>