<form class="pt-0" method="post"
      action="{{ $candidate -> protector ? route ('candidates.protectors.update', ['candidate' => $candidate -> id, 'protector' => $candidate -> protector -> id]) : route ('candidates.protectors.store', ['candidate' => $candidate -> id]) }}"
      enctype="multipart/form-data">
    @csrf
    
    @if($candidate -> protector)
        @method('PUT')
    @endif
    <div class="card-body pt-1 pb-1">
        @include('candidates.edit.candidate-info')
        <div class="row">
            @if($candidate -> cleared_payments == '1')
                <div class="col-md-12">
                    <div class="alert alert-success">
                        Note! Accounts has been cleared. Documents can be hand over to candidate.
                    </div>
                </div>
            @endif
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="reg-no">Vide Reg. No</label>
                <input type="text" name="reg-no" class="form-control" id="reg-no"
                       autofocus="autofocus"
                       value="{{ old ('reg-no', $candidate -> protector ?-> reg_no) }}">
            </div>
            
            <div class="col-md-3 mb-1">
                <label class="form-label" for="protector-date">Date</label>
                <input type="text" class="form-control flatpickr-basic" id="protector-date"
                       name="protector-date"
                       value="{{ old ('protector-date', $candidate -> protector ?-> protector_date) }}" />
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="price">Fee</label>
                <input type="text" name="price" class="form-control" id="price" readonly="readonly"
                       value="{{ config ('constants.protector_fee') }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="status">
                    Status
                    <sup class="text-danger fs-5 top-0">*</sup>
                </label>
                <select name="status" class="form-control select2" data-placeholder="Select" required="required"
                        {{ ((!empty(trim ($candidate -> protector ?-> status))) > 0 && !auth () -> user () -> is_admin()) ? 'disabled="disabled"' : '' }}
                        id="status">
                    <option></option>
                    <option value="hold" @selected(old ('hold', $candidate -> protector ?-> status) == 'hold')>
                        Hold
                    </option>
                    <option value="sent" @selected(old ('status', $candidate -> protector ?-> status) == 'sent')>
                        Sent
                    </option>
                    <option value="done" @selected(old ('status', $candidate -> protector ?-> status) == 'done')>
                        Done
                    </option>
                </select>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="file">Protector Copy</label>
                    @if($candidate -> protector && !empty(trim ($candidate -> protector ?-> file)))
                        <div>
                            <a href="{{ $candidate -> protector ?-> file }}"
                               download="{{ $candidate -> fullName() }} - Protector Copy"
                               target="_blank">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> protector ?-> file }}" target="_blank">
                                <i class="tf-icons ti ti-photo"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" name="file" class="form-control" id="file"
                       accept="image/*">
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="video">Candidate Video</label>
                    @if($candidate -> protector && !empty(trim ($candidate -> protector ?-> video)))
                        <div>
                            <a href="{{ $candidate -> protector ?-> video }}"
                               download="{{ $candidate -> fullName() }} - Candidate Video"
                               target="_blank">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> protector ?-> video }}" target="_blank">
                                <i class="tf-icons ti ti-video"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" name="video" class="form-control" id="video"
                       accept="video/*">
            </div>
        </div>
    </div>
    <div class="card-footer border-top pt-4">
        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Save</button>
        <a href="{{ route ('invoices.specialized-deposit-slip', ['candidate' => $candidate -> id]) }}"
           class="btn btn-dark me-3" target="_blank">Specialized Deposit Slip</a>
        <a href="{{ route ('invoices.foreign-services-contract', ['candidate' => $candidate -> id]) }}"
           class="btn btn-warning me-3" target="_blank">Foreign Services Contract</a>
        <a href="{{ route ('invoices.form-7', ['candidate' => $candidate -> id]) }}"
           class="btn btn-info me-3" target="_blank">Form-7</a>
        <a href="{{ route ('invoices.form-32a', ['candidate' => $candidate -> id]) }}"
           class="btn btn-success me-3" target="_blank">Form-32A</a>
        <a href="{{ route ('invoices.undertaking', ['candidate' => $candidate -> id]) }}"
           class="btn btn-dribbble me-3" target="_blank">Undertaking</a>
    </div>
</form>