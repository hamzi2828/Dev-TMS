<div class="row">
    <div class="col-md-3 mb-3">
        <label class="form-label" for="profession">Profession</label>
        <select id="profession" name="jobs[]" class="form-control select2"
                data-placeholder="Select">
            <option></option>
            @if(count ($jobs) > 0)
                @foreach($jobs as $job)
                    <option value="{{ $job -> id }}" @selected(old ('jobs.0') == $job -> id)>
                        {{ $job -> title }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
    
    <div class="col-md-2 mb-3">
        <label class="form-label" for="quota">Demand</label>
        <input type="number" class="form-control" value="{{ old ('quota.0') }}" id="quota"
               name="quota[]">
    </div>
</div>