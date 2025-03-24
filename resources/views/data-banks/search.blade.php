<div class="card mb-3">
    <div class="card-header border-bottom pt-3 pb-3">
        <h5 class="card-title mb-0">Search</h5>
    </div>
    <div class="card-body mt-3">
        <form method="get" action="{{ route ('data-banks.index') }}">
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
                
                <div class="col-md-2 form-group">
                    <button type="submit" class="btn btn-primary w-100 mt-4">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>