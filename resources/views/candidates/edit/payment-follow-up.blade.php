<form class="pt-0" method="post"
      action="{{ $candidate -> payment_follow_up ? route ('candidates.payment-follow-up.update', ['candidate' => $candidate -> id, 'payment_follow_up' => $candidate -> payment_follow_up -> id]) : route ('candidates.payment-follow-up.store', ['candidate' => $candidate -> id]) }}"
      enctype="multipart/form-data">
    @csrf
    
    @if($candidate -> payment_follow_up)
        @method('PUT')
    @endif
    <div class="card-body pt-1 pb-1">
        @include('candidates.edit.candidate-info')
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label" for="status">Status</label>
                <select name="status" class="form-control select2" data-placeholder="Select" required="required"
                        id="status">
                    <option></option>
                    <option value="not-informed" @selected(old ('status', $candidate -> payment_follow_up ?-> status) == 'not-informed')>
                        Not Informed
                    </option>
                    <option value="informed" @selected(old ('status', $candidate -> payment_follow_up ?-> status) == 'informed')>
                        Informed
                    </option>
                    <option value="phone-off" @selected(old ('status', $candidate -> payment_follow_up ?-> status) == 'phone-off')>
                        Phone Off
                    </option>
                    <option value="not-responding" @selected(old ('status', $candidate -> payment_follow_up ?-> status) == 'not-responding')>
                        Not Responding
                    </option>
                </select>
            </div>
            <div class="col-md-8 mb-3">
                <label class="form-label" for="description">Description</label>
                <textarea name="description" class="form-control" rows="5"
                          id="description">{{ old ('description', $candidate -> payment_follow_up ?-> description) }}</textarea>
            </div>
        </div>
    </div>
    <div class="card-footer border-top pt-4">
        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Save</button>
    </div>
</form>