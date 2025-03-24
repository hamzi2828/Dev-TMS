<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="card mb-3">
            <div class="card-header border-bottom pt-3 pb-3">
                <h5 class="card-title mb-0">Search</h5>
            </div>
            <div class="card-body mt-3">
                <form method="get" action="{{ route ('reporting.qj-medical-report') }}">
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
                        
                        <div class="col-md-3 form-group mb-3">
                            <label class="form-label" for="filter">Filter</label>
                            <select id="filter" name="filter" class="form-control select2" data-placeholder="Select"
                                    data-allow-clear="true">
                                <option></option>
                                <option value="1" @selected(request ('filter') === '1')>Arrived</option>
                                <option value="0" @selected(request ('filter') === '0')>Not Arrived</option>
                            </select>
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
                <a href="javascript:void(0)" onclick="downloadExcel('QJ Medical Report')"
                   class="btn btn-sm btn-primary">
                    <i class="tf-icons ti ti-file-spreadsheet fs-6 me-1"></i>
                    Download Excel
                </a>
            </div>
            <div class="card-datatable table-responsive">
                <table class="table table-hover table-sm table-bordered" style="vertical-align: top" id="excel-table">
                    <thead class="border-top">
                    <tr>
                        <th>#</th>
                        <th>Sr. No</th>
                        <th>Payment Date</th>
                        <th>Applied For</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Mobile</th>
                        <th>CNIC</th>
                        <th>Passport No</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count ($candidates) > 0)
                        @foreach($candidates as $candidate)
                            @php
                                $paymentDate = $candidate -> general_ledger() -> where(['account_head_id' => config ( 'constants.income_from_medical' )]) -> first();
                            @endphp
                            <tr>
                                <td>{{ $loop -> iteration }}</td>
                                <td>{{ $candidate -> SerialNo() }}</td>
                                <td>{{ $paymentDate ?-> transaction_date }}</td>
                                <td>{{ $candidate -> job ?-> title }}</td>
                                <td>
                                    {{ $candidate -> fullName() }}
                                    @if(empty($candidate -> medical))
                                        <span class="badge bg-danger">Payment not added.</span>
                                    @endif
                                    @if($candidate -> back_out)
                                        <span class="badge bg-dark">Back out</span>
                                    @endif
                                </td>
                                <td>{{ $candidate -> father_name }}</td>
                                <td>{{ $candidate -> mobile }}</td>
                                <td>{{ $candidate -> cnic }}</td>
                                <td>{{ $candidate -> passport }}</td>
                                <td>
                                    <div class="d-flex flex-row">
                                        <form method="post" id="form-{{ $candidate -> id }}"
                                              class="d-flex flex-row fs-normal gap-1"
                                              action="{{ route ('candidates.arrived', ['candidate' => $candidate -> id]) }}">
                                            @csrf
                                            <input type="checkbox" name="arrived" value="1"
                                                   @checked($candidate -> arrived)
                                                   onclick="$('#form-{{ $candidate -> id }}').submit()"
                                                   id="arrived-{{ $candidate -> id }}">
                                            <label for="arrived-{{ $candidate -> id }}" class="w-100">Arrived</label>
                                        </form>
                                    </div>
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
