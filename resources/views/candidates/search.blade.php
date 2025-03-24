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
                
                @if(count ($candidates) > 0)
                    <div class="col-md-3 form-group">
                        <label class="form-label" for="candidates">JMS No</label>
                        <select name="candidates[]" class="form-control select2" multiple="multiple"
                                data-placeholder="Select"
                                id="candidates">
                            <option></option>
                            @foreach($candidates as $key => $candidate)
                                <option value="{{ $candidate -> id }}" {{ in_array ($candidate -> id, request ('candidates', [])) ? 'selected="selected"' : '' }}>
                                    {{ env ('APP_NAME') . '-' . $candidate -> sr_no }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
                
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
                
                @if(request () -> routeIs ('candidates.index'))
                    <div class="col-md-3 form-group mb-3">
                        <label class="form-label" for="docs-provided">Documents Provided</label>
                        <select name="docs-provided" class="form-control select2"
                                data-placeholder="Select" data-allow-clear="true" id="docs-provided">
                            <option></option>
                            <option value="only-cv"@selected(request ('docs-provided') == 'only-cv')>
                                Only CV
                            </option>
                            <option value="passport-provided"@selected(request ('docs-provided') == 'passport-provided')>
                                Passport Provided
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group mb-3">
                        <label class="form-label" for="free-candidate">Free Candidates</label>
                        <select name="free-candidate" class="form-control select2"
                                data-placeholder="Select" data-allow-clear="true" id="free-candidate">
                            <option></option>
                            <option value="1" @selected(request ('free-candidate') == '1')>Yes</option>
                            <option value="0" @selected(request ('free-candidate') == '0')>No</option>
                        </select>
                    </div>
                @endif
                
                @if(request () -> routeIs ('candidates.interview-candidates'))
                    <div class="col-md-3 form-group">
                        <label class="form-label" for="candidate-status">Status</label>
                        <select name="status" class="form-control select2" data-placeholder="Select"
                                data-allow-clear="true"
                                id="candidate-status">
                            <option></option>
                            <option value="selected" @selected(request ('status') == 'selected')>Selected</option>
                            <option value="rejected" @selected(request ('status') == 'rejected')>Rejected</option>
                            <option value="standby" @selected(request ('status') == 'standby')>StandBy</option>
                        </select>
                    </div>
                @endif
                
                @if(request () -> routeIs ('candidates.medical-candidates'))
                    <div class="col-md-3 form-group mb-3">
                        <label class="form-label" for="candidate-status">Status</label>
                        <select name="status" class="form-control select2" data-placeholder="Select"
                                data-allow-clear="true"
                                id="candidate-status">
                            <option></option>
                            <option value="fit" @selected(request ('status') == 'fit')>Fit</option>
                            <option value="unfit" @selected(request ('status') == 'unfit')>UnFit</option>
                            <option value="hold" @selected(request ('status') == 'hold')>Hold</option>
                            <option value="0" @selected(request ('status') == '0')>Pending</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="form-label" for="payment-follow-up">Payment Follow Up</label>
                        <select name="payment-follow-up" class="form-control select2" data-placeholder="Select"
                                data-allow-clear="true"
                                id="payment-follow-up">
                            <option></option>
                            <option value="not-informed" @selected(request ('payment-follow-up') == 'not-informed')>
                                Not Informed
                            </option>
                            <option value="informed" @selected(request ('payment-follow-up') == 'informed')>
                                Informed
                            </option>
                            <option value="phone-off" @selected(request ('payment-follow-up') == 'phone-off')>
                                Phone Off
                            </option>
                            <option value="not-responding" @selected(request ('payment-follow-up') == 'not-responding')>
                                Not Responding
                            </option>
                        </select>
                    </div>
                @endif
                
                @if(request () -> routeIs ('candidates.visa-candidates'))
                    <div class="col-md-3 form-group mb-3">
                        <label class="form-label" for="candidate-status">Status</label>
                        <select name="status" class="form-control select2" data-placeholder="Select"
                                data-allow-clear="true"
                                id="candidate-status">
                            <option></option>
                            <option value="in-process" @selected(request ('status') == 'in-process')>In Process</option>
                            <option value="issued" @selected(request ('status') == 'issued')>Issued</option>
                            <option value="rejected" @selected(request ('status') == 'rejected')>Rejected</option>
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
                        <label class="form-label" for="tgid">T.G.I.D</label>
                        <select name="tgid[]" class="form-control select2" multiple="multiple" data-placeholder="Select"
                                data-allow-clear="true"
                                id="tgid">
                            <option></option>
                            @if(count ($tgid_candidates) > 0)
                                @foreach($tgid_candidates as $key => $tgid)
                                    <option value="{{ $tgid -> tgid }}" {{ in_array ($tgid -> tgid, request ('tgid', [])) ? 'selected="selected"' : '' }}>
                                        {{ $tgid -> tgid }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-3 form-group">
                        <label class="form-label" for="visa-follow-up">Visa Follow Up</label>
                        <select name="visa-follow-up" class="form-control select2" data-placeholder="Select"
                                data-allow-clear="true"
                                id="visa-follow-up">
                            <option></option>
                            <option value="not-informed" @selected(request ('visa-follow-up') == 'not-informed')>
                                Not Informed
                            </option>
                            <option value="informed" @selected(request ('visa-follow-up') == 'informed')>
                                Informed
                            </option>
                            <option value="phone-off" @selected(request ('visa-follow-up') == 'phone-off')>
                                Phone Off
                            </option>
                            <option value="not-responding" @selected(request ('visa-follow-up') == 'not-responding')>
                                Not Responding
                            </option>
                        </select>
                    </div>
                @endif
                
                @if(request () -> routeIs ('candidates.ticket-candidates'))
                    <div class="col-md-3 form-group mb-3">
                        <label class="form-label" for="ticket-no">Ticket No</label>
                        <input type="text" name="ticket-no" class="form-control" id="ticket-no"
                               value="{{ request ('ticket-no') }}">
                    </div>
                    
                    <div class="col-md-3 form-group mb-3">
                        <label class="form-label" for="flight-no">Flight No</label>
                        <input type="text" name="flight-no" class="form-control" id="flight-no"
                               value="{{ request ('flight-no') }}">
                    </div>
                    
                    <div class="col-md-3 form-group mb-3">
                        <label class="form-label" for="departure-date">Departure Date</label>
                        <input type="text" name="departure-date" class="form-control flatpickr-basic" id="departure-date"
                               value="{{ request ('departure-date') }}">
                    </div>
                    
                    <div class="col-md-3 form-group mb-3">
                        <label class="form-label" for="candidate-status">Status</label>
                        <select name="status" class="form-control select2" data-placeholder="Select"
                                data-allow-clear="true"
                                id="candidate-status">
                            <option></option>
                            <option value="confirmed" @selected(request ('status') == 'confirmed')>Confirmed</option>
                            <option value="waiting" @selected(request ('status') == 'waiting')>Waiting</option>
                            <option value="travelled" @selected(request ('status') == 'travelled')>Travelled</option>
                            <option value="no-show" @selected(request ('status') == 'no-show')>No Show</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group mb-3">
                        <label class="form-label" for="ticket-follow-up">Ticket Follow Up</label>
                        <select name="ticket-follow-up" class="form-control select2" data-placeholder="Select"
                                data-allow-clear="true"
                                id="ticket-follow-up">
                            <option></option>
                            <option value="not-informed" @selected(request ('ticket-follow-up') == 'not-informed')>
                                Not Informed
                            </option>
                            <option value="informed" @selected(request ('ticket-follow-up') == 'informed')>
                                Informed
                            </option>
                            <option value="phone-off" @selected(request ('ticket-follow-up') == 'phone-off')>
                                Phone Off
                            </option>
                            <option value="not-responding" @selected(request ('ticket-follow-up') == 'not-responding')>
                                Not Responding
                            </option>
                        </select>
                    </div>
                @endif
                
                @if(request () -> routeIs ('candidates.protector-candidates'))
                    <div class="col-md-3 form-group">
                        <label class="form-label" for="candidate-status">Status</label>
                        <select name="status" class="form-control select2" data-placeholder="Select"
                                data-allow-clear="true"
                                id="candidate-status">
                            <option></option>
                            <option value="sent" @selected(request ('status') == 'sent')>Sent</option>
                            <option value="done" @selected(request ('status') == 'done')>Done</option>
                            <option value="hold" @selected(request ('status') == 'hold')>Hold</option>
                            <option value="0" @selected(request ('status') == '0')>In Process</option>
                        </select>
                    </div>
                @endif
                
                @if(request () -> routeIs ('candidates.document-ready-candidates'))
                    <div class="col-md-3 form-group mb-3">
                        <label class="form-label" for="candidate-status">Status</label>
                        <select name="status" class="form-control select2" data-placeholder="Select"
                                data-allow-clear="true"
                                id="candidate-status">
                            <option></option>
                            <option value="yes" @selected(request ('status') == 'yes')>Yes</option>
                            <option value="no" @selected(request ('status') == 'no')>No</option>
                            <option value="0" @selected(request ('status') == '0')>On Hold</option>
                        </select>
                    </div>
                    <div class="col-md-3 form-group mb-3">
                        <label class="form-label" for="proceed-to-visa">Proceed to Visa</label>
                        <select name="proceed-to-visa" class="form-control select2"
                                data-placeholder="Select" data-allow-clear="true" id="proceed-to-visa">
                            <option></option>
                            <option value="1" @selected(request ('proceed-to-visa') == '1')>Yes</option>
                            <option value="0" @selected(request ('proceed-to-visa') == '0')>No</option>
                        </select>
                    </div>
                @endif
                
                @if(!request () -> routeIs ('reporting.status-check'))
                    <div class="col-md-3 form-group">
                        <label class="form-label" for="per-page">Records Per Page</label>
                        <select name="per-page" class="form-control select2" data-placeholder="Select"
                                data-allow-clear="true"
                                id="per-page">
                            @for($records = 50; $records <= 500; $records += 50)
                                <option value="{{ $records }}" @selected(request ('per-page') == $records)>
                                    {{ $records }} Rows
                                </option>
                            @endfor
                        </select>
                    </div>
                @endif
                
                @if(request () -> routeIs ('reporting.status-check'))
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
                @endif
                
                <div class="col-md-2 form-group">
                    <button type="submit" class="btn btn-primary w-100 mt-4">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>