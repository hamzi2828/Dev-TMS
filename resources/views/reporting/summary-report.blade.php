<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="card mb-3">
            <div class="card-header border-bottom pt-3 pb-3">
                <h5 class="card-title mb-0">Search</h5>
            </div>
            <div class="card-body mt-3">
                <form method="get" action="{{ route ('reporting.summary-report') }}">
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
                <a href="javascript:void(0)" onclick="downloadExcel('Summary Report')"
                   class="btn btn-sm btn-primary">
                    <i class="tf-icons ti ti-file-spreadsheet fs-6 me-1"></i>
                    Download Excel
                </a>
            </div>
            <div class="card-datatable table-responsive">
                <table class="table table-hover table-sm table-bordered" style="vertical-align: top" id="excel-table">
                    <thead class="border-top">
                    <tr>
                        <th></th>
                        <th class="text-center" colspan="2">Interview</th>
                        <th class="text-center" colspan="2">Medical</th>
                        <th class="text-center" colspan="2">Document Ready</th>
                        <th class="text-center" colspan="2">Documents Uploaded</th>
                        <th class="text-center" colspan="2">Visa</th>
                        <th class="text-center" colspan="2">Protector</th>
                        <th class="text-center" colspan="2">Ticket</th>
                        <th class="text-center">BackOut</th>
                    </tr>
                    </thead>
                    <tr>
                        <td>#</td>
                        <td>Selected</td>
                        <td>Rejected</td>
                        <td>Fit</td>
                        <td>Un-Fit</td>
                        <td>Yes</td>
                        <td>No</td>
                        <td>Yes</td>
                        <td>No</td>
                        <td>Issued</td>
                        <td>Rejected</td>
                        <td>Sent</td>
                        <td>Done</td>
                        <td>Confirmed</td>
                        <td>Travelled</td>
                        <td align="center">No. of Candidates</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td align="center">{{ $selected_interviews }}</td>
                        <td align="center">{{ $rejected_interviews }}</td>
                        <td align="center">{{ $fit_medicals }}</td>
                        <td align="center">{{ $unfit_medicals }}</td>
                        <td align="center">{{ $documents_ready }}</td>
                        <td align="center">{{ $not_documents_ready }}</td>
                        <td align="center">{{ $documents_uploaded }}</td>
                        <td align="center">{{ $not_documents_uploaded }}</td>
                        <td align="center">{{ $issued_visas }}</td>
                        <td align="center">{{ $rejected_visas }}</td>
                        <td align="center">{{ $sent_protectors }}</td>
                        <td align="center">{{ $done_protectors }}</td>
                        <td align="center">{{ $confirmed_tickets }}</td>
                        <td align="center">{{ $travelled_tickets }}</td>
                        <td align="center">{{ $back_out }}</td>
                    </tr>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- / Content -->
</x-dashboard>