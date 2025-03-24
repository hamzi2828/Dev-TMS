<div class="modal fade" id="candidateStatusModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
     data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered1 modal-lg">
        <div class="modal-content p-0">
            <div class="border-bottom modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-start mb-0">
                    <h3 class="mb-2">Bulk Status Update</h3>
                    <p class="text-muted mb-0">Update Candidates Status In Bulk</p>
                </div>
            </div>
            <form method="post" action="{{ route ('visas.bulk-status-update') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body pt-3">
                    <div class="col-12 mb-3">
                        <label class="form-label" for="status">Status</label>
                        <select name="status" class="form-control select2" data-placeholder="Select"
                                data-allow-clear="true" required="required"
                                id="status">
                            <option></option>
                            <option value="in-process" @selected(old ('status') == 'in-process')>In Process</option>
                            <option value="issued" @selected(old ('status') == 'issued')>Issued</option>
                            <option value="rejected" @selected(old ('status') == 'rejected')>Rejected</option>
                        </select>
                    </div>
                    
                    <div class="col-md-12">
                        <table class="table table-hover table-sm table-bordered">
                            <thead class="border-top">
                            <tr>
                                <th width="5%">#</th>
                                <th width="20%">Name</th>
                                <th width="20%">Father Name</th>
                                <th width="55%">Visa Copy</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count ($candidates) > 0)
                                @foreach($candidates as $candidate)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="candidates[]" value="{{ $candidate -> id }}">
                                            {{ $loop -> iteration }}
                                        </td>
                                        <td>{{ $candidate -> fullName() }}</td>
                                        <td>{{ $candidate -> father_name }}</td>
                                        <td>
                                            <label class="form-label w-100" for="ticket-no">
                                                <input type="file" name="file-{{ $candidate -> id }}"
                                                       class="form-control"
                                                       id="ticket-no">
                                            </label>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer border-top pb-1">
                    <div class="col-12 text-start">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                        <button type="reset" class="btn btn-label-secondary btn-reset" data-bs-dismiss="modal"
                                aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>