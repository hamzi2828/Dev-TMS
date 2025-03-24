<form class="pt-0" method="post"
      action="{{ $candidate -> document_ready ? route ('candidates.document-ready.update', ['candidate' => $candidate -> id, 'document_ready' => $candidate -> document_ready -> id]) : route ('candidates.document-ready.store', ['candidate' => $candidate -> id]) }}"
      enctype="multipart/form-data">
    @csrf
    
    @if($candidate -> document_ready)
        @method('PUT')
    @endif
    <div class="card-body pt-1 pb-1">
        @include('candidates.edit.candidate-info')
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label" for="status">Status</label>
                <select name="status" class="form-control select2" data-placeholder="Select"
                        {{ ((!empty(trim ($candidate -> document_ready ?-> status))) > 0 && !auth () -> user () -> is_admin()) ? 'disabled="disabled"' : '' }}
                        id="status">
                    <option></option>
                    <option value="hold" @selected(old ('hold', $candidate -> document_ready ?-> status) == 'hold')>
                        Hold
                    </option>
                    @if($candidate -> proceed_to_visa == '1')
                        <option value="yes" @selected(old ('yes', $candidate -> document_ready ?-> status) == 'yes')>
                            Yes
                        </option>
                    @endif
                    <option value="no" @selected(old ('status', $candidate -> document_ready ?-> status) == 'no')>
                        No
                    </option>
                </select>
            </div>
            <div class="col-md-9 mb-3">
                <label class="form-label" for="reason">Not Ready Reason</label>
                <textarea name="reason" class="form-control" rows="5"
                          id="reason">{{ old ('reason', $candidate -> document_ready ?-> reason) }}</textarea>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label" for="agreement-id">Agreement Template</label>
                <select name="agreement-id" class="form-control select2" data-placeholder="Select"
                        id="agreement-id">
                    <option></option>
                    @if(count ($agreements) > 0)
                        @foreach($agreements as $agreement)
                            <option value="{{ $agreement -> id }}" @selected(old ('agreement-id', $candidate -> document_ready ?-> agreement_id) == $agreement -> id)>
                                {{ $agreement -> principal ?-> name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="card-footer border-top pt-4">
        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Save</button>
        @if($candidate -> document_ready ?-> agreement_id)
            <a href="{{ route ('invoices.agreement', ['candidate' => $candidate -> id, 'document_ready' => $candidate -> document_ready -> id]) }}"
               class="btn btn-dark" target="_blank">Print</a>
        @endif
    </div>
</form>