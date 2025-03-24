<form class="pt-0" method="post" action="{{ route ('candidates.save-trade-change', ['candidate' => $candidate -> id]) }}">
    @csrf
    <div class="card-body pt-1 pb-1">
        @include('candidates.edit.candidate-info')
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label" for="job-id">
                    Trade Change
                    <sup class="text-danger fs-5 top-0">*</sup>
                </label>
                <select name="job-id" class="form-control select2" data-placeholder="Select"
                        required="required" id="job-id">
                    <option></option>
                    @if(count ($jobs) > 0)
                        @foreach($jobs as $job)
                            <option value="{{ $job -> id }}"
                                    @selected(old ('job-id', $candidate -> tc_job_id) == $job -> id)>
                                {{ $job -> title }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
    <div class="card-footer border-top pt-4">
        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Save</button>
    </div>
</form>