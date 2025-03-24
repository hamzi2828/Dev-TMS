<div class="row border-bottom mb-4">
    <div class="col-md-2 mb-3">
        <label class="form-label" for="_sr_no">Sr.No</label>
        <input type="text" id="_sr_no" class="form-control" value="{{ env ('APP_NAME') . '-' . $candidate -> sr_no }}"
               disabled="disabled">
    </div>
    
    <div class="col-md-3 mb-3">
        <label class="form-label" for="_name">Name</label>
        <input type="text" id="_name" class="form-control" value="{{ $candidate -> fullName() }}" disabled="disabled">
    </div>
    
    <div class="col-md-2 mb-3">
        <label class="form-label" for="_referral">Referral</label>
        <input type="text" id="_referral" class="form-control" value="{{ $candidate -> referral ?-> name }}" disabled="disabled">
    </div>
    
    <div class="col-md-3 mb-3">
        <label class="form-label" for="_cnic">CNIC</label>
        <input type="text" id="_cnic" class="form-control" value="{{ $candidate -> cnic }}" disabled="disabled">
    </div>
    
    <div class="col-md-2 mb-3">
        <label class="form-label" for="_passport">Passport</label>
        <input type="text" id="_passport" class="form-control" value="{{ $candidate -> passport }}" disabled="disabled">
    </div>
</div>