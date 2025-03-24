<form class="pt-0" method="post"
      action="{{ $candidate -> back_out ? route ('candidates.back-out.update', ['candidate' => $candidate -> id, 'back_out' => $candidate -> back_out -> id]) : route ('candidates.back-out.store', ['candidate' => $candidate -> id]) }}"
      enctype="multipart/form-data">
    @csrf
    
    @if($candidate -> back_out)
        @method('PUT')
    @endif
    
    <div class="card-body pt-1 pb-1">
        @include('candidates.edit.candidate-info')
        <div class="row">
            <div class="col-md-12 mb-3">
                <label class="form-label" for="reason">Reason</label>
                <textarea name="reason" class="form-control" rows="5"
                          id="reason">{{ old ('reason', $candidate -> back_out ?-> reason) }}</textarea>
            </div>
        </div>
    </div>
    
    <div class="card-footer border-top pt-4">
        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Save</button>
        @can('unback', \App\Models\CandidateBackOut::class)
            @if($candidate -> back_out)
                <a href="{{ route ('candidates.back-out.unback', ['candidate' => $candidate -> id, 'backOut' => $candidate -> back_out -> id]) }}"
                   class="btn btn-danger me-sm-3 me-1" onclick="return confirm('Are you sure?')">UnBack</a>
            @endif
        @endcan
    </div>
</form>