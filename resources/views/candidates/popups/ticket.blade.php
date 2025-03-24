<div class="modal fade" id="candidateStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered1 modal-simple">
        <div class="modal-content p-0">
            <div class="border-bottom modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-start mb-0">
                    <h3 class="mb-2">Bulk Status Update</h3>
                    <p class="text-muted mb-0">Update Candidates Status In Bulk</p>
                </div>
            </div>
            <form method="post" action="{{ route ('tickets.bulk-status-update') }}">
                @csrf
                <div class="modal-body pt-3">
                    <input type="hidden" name="candidates" id="selected-candidates">
                    <div class="col-12">
                        <label class="form-label" for="status">Status</label>
                        <select name="status" class="form-control select2" data-placeholder="Select"
                                data-allow-clear="true" required="required"
                                id="status">
                            <option></option>
                            <option value="confirmed" @selected(old ('status') == 'confirmed')>Confirmed</option>
                            <option value="travelled" @selected(old ('status') == 'travelled')>Travelled</option>
                            <option value="no-show" @selected(old ('status') == 'no-show')>No Show</option>
                        </select>
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