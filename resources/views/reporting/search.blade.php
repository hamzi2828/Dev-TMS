<div class="card mb-3">
    <div class="card-header border-bottom pt-3 pb-3">
        <h5 class="card-title mb-0">Search</h5>
    </div>
    <div class="card-body mt-3">
        <form method="get" action="{{ $searchRoute }}">
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
                    <label class="form-label" for="sr-no">Sr.No</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">{{ env ('APP_NAME') }}-</span>
                        <input type="text" name="sr-no" class="form-control" id="sr-no"
                               value="{{ request ('sr-no') }}">
                    </div>
                </div>
                
                <div class="col-md-3 form-group mb-3">
                    <label class="form-label" for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name"
                           value="{{ request ('name') }}">
                </div>
                
                <div class="col-md-3 form-group mb-3">
                    <label class="form-label" for="mobile">Mobile</label>
                    <input type="text" name="mobile" class="form-control" id="mobile"
                           value="{{ request ('mobile') }}">
                </div>
                
                <div class="col-md-3 form-group mb-3">
                    <label class="form-label" for="cnic">CNIC</label>
                    <input type="text" name="cnic" class="form-control" id="cnic"
                           value="{{ request ('cnic') }}">
                </div>
                
                <div class="col-md-3 form-group">
                    <label class="form-label" for="passport">Passport No</label>
                    <input type="text" name="passport" class="form-control" id="passport"
                           value="{{ request ('passport') }}">
                </div>
                
                <div class="col-md-3 form-group">
                    <label class="form-label" for="job-id">Position Applied For</label>
                    <select name="job-id" class="form-control select2" data-placeholder="Select"
                            data-allow-clear="true"
                            id="job-id">
                        <option></option>
                        @if(count ($jobs) > 0)
                            @foreach($jobs as $job)
                                <option value="{{ $job -> id }}"
                                        @selected(request ('job-id') == $job -> id)>
                                    {{ $job -> title }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                
                <div class="col-md-3 form-group">
                    <label class="form-label" for="referral-id">Referral</label>
                    <select name="referral-id" class="form-control select2" data-placeholder="Select"
                            data-allow-clear="true"
                            id="referral-id">
                        <option></option>
                        @if(count ($referrals) > 0)
                            @foreach($referrals as $referral)
                                <option value="{{ $referral -> id }}"
                                        @selected(request ('referral-id') == $referral -> id)>
                                    {{ $referral -> name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                
                <div class="col-md-3 form-group">
                    <label class="form-label" for="interview-status">Interview Status</label>
                    <select name="interview-status" class="form-control select2" data-placeholder="Select"
                            data-allow-clear="true"
                            id="interview-status">
                        <option></option>
                        <option value="selected" @selected(request ('interview-status') == 'selected')>Selected</option>
                        <option value="rejected" @selected(request ('interview-status') == 'rejected')>Rejected</option>
                        <option value="standby" @selected(request ('interview-status') == 'standby')>StandBy</option>
                    </select>
                </div>
                
                <div class="col-md-3 form-group mb-3">
                    <label class="form-label" for="medical-status">Medical Status</label>
                    <select name="medical-status" class="form-control select2" data-placeholder="Select"
                            data-allow-clear="true"
                            id="medical-status">
                        <option></option>
                        <option value="fit" @selected(request ('medical-status') == 'fit')>Fit</option>
                        <option value="unfit" @selected(request ('medical-status') == 'unfit')>UnFit</option>
                        <option value="hold" @selected(request ('medical-status') == 'hold')>Hold</option>
                        <option value="0" @selected(request ('medical-status') == '0')>Pending</option>
                    </select>
                </div>
                
                <div class="col-md-3 form-group mb-3">
                    <label class="form-label" for="document-ready-status">Document Ready Status</label>
                    <select name="document-ready-status" class="form-control select2" data-placeholder="Select"
                            data-allow-clear="true"
                            id="document-ready-status">
                        <option></option>
                        <option value="yes" @selected(request ('document-ready-status') == 'yes')>Yes</option>
                        <option value="no" @selected(request ('document-ready-status') == 'no')>No</option>
                        <option value="0" @selected(request ('document-ready-status') == '0')>On Hold</option>
                    </select>
                </div>
                
                <div class="col-md-3 form-group mb-3">
                    <label class="form-label" for="documents-uploaded">Documents Uploads</label>
                    <select name="documents-uploaded" class="form-control select2" data-placeholder="Select"
                            data-allow-clear="true"
                            id="documents-uploaded">
                        <option></option>
                        <option value="yes" @selected(request ('documents-uploaded') == 'yes')>Yes</option>
                        <option value="no" @selected(request ('documents-uploaded') == 'no')>No</option>
                    </select>
                </div>
                
                <div class="col-md-3 form-group mb-3">
                    <label class="form-label" for="visa-status">Visa Status</label>
                    <select name="visa-status" class="form-control select2" data-placeholder="Select"
                            data-allow-clear="true"
                            id="visa-status">
                        <option></option>
                        <option value="in-process" @selected(request ('visa-status') == 'in-process')>In Process
                        </option>
                        <option value="issued" @selected(request ('visa-status') == 'issued')>Issued</option>
                        <option value="rejected" @selected(request ('visa-status') == 'rejected')>Rejected</option>
                    </select>
                </div>
                
                <div class="col-md-3 form-group">
                    <label class="form-label" for="protector-status">Protector Status</label>
                    <select name="protector-status" class="form-control select2" data-placeholder="Select"
                            data-allow-clear="true"
                            id="protector-status">
                        <option></option>
                        <option value="sent" @selected(request ('protector-status') == 'sent')>Sent</option>
                        <option value="done" @selected(request ('protector-status') == 'done')>Done</option>
                        <option value="hold" @selected(request ('protector-status') == 'hold')>Hold</option>
                        <option value="0" @selected(request ('protector-status') == '0')>In Process</option>
                    </select>
                </div>
                
                <div class="col-md-3 form-group mb-3">
                    <label class="form-label" for="ticket-status">Ticket Status</label>
                    <select name="ticket-status" class="form-control select2" data-placeholder="Select"
                            data-allow-clear="true"
                            id="ticket-status">
                        <option></option>
                        <option value="confirmed" @selected(request ('ticket-status') == 'confirmed')>Confirmed</option>
                        <option value="waiting" @selected(request ('ticket-status') == 'waiting')>Waiting</option>
                        <option value="travelled" @selected(request ('ticket-status') == 'travelled')>Travelled</option>
                        <option value="no-show" @selected(request ('ticket-status') == 'no-show')>No Show</option>
                    </select>
                </div>
                
                <div class="col-md-3 form-group">
                    <label class="form-label" for="payment-status">Payment Status</label>
                    <select name="payment-status" class="form-control select2" data-placeholder="Select"
                            data-allow-clear="true"
                            id="payment-status">
                        <option></option>
                        <option value="submitted" @selected(request ('payment-status') == 'submitted')>
                            Submitted
                        </option>
                        <option value="not-submitted" @selected(request ('payment-status') == 'not-submitted')>
                            Not Submitted
                        </option>
                    </select>
                </div>
                
                <div class="col-md-2 form-group">
                    <button type="submit" class="btn btn-primary w-100 mt-4">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>