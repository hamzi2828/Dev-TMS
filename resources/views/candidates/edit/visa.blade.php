<form class="pt-0" method="post"
      action="{{ $candidate -> visa ? route ('candidates.visas.update', ['candidate' => $candidate -> id, 'visa' => $candidate -> visa -> id]) : route ('candidates.visas.store', ['candidate' => $candidate -> id]) }}"
      enctype="multipart/form-data">
    @csrf
    
    @if($candidate -> visa)
        @method('PUT')
    @endif
    <div class="card-body pt-1 pb-1">
        @include('candidates.edit.candidate-info')
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label" for="tgid">T.G.I.D</label>
                <input type="text" name="tgid" class="form-control" id="tgid"
                       value="{{ old ('tgid', $candidate -> visa ?-> tgid) }}" autofocus="autofocus">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="status">
                    Status
                    <sup class="text-danger fs-5 top-0">*</sup>
                </label>
                @php $status = $candidate -> visa ?-> status ?? 'in-process' @endphp
                <select name="status" class="form-control select2" data-placeholder="Select" required="required"
                        id="status">
                    <option></option>
                    <option value="in-process" @selected(old ('status', $status) == 'in-process')>
                        In Process
                    </option>
                    <option value="issued" @selected(old ('status', $status) == 'issued')>
                        Issued
                    </option>
                    <option value="rejected" @selected(old ('status', $status) == 'rejected')>
                        Rejected
                    </option>
                </select>
            </div>
            
            <div class="col-md-4 mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="file">Visa Copy</label>
                    @if($candidate -> visa && !empty(trim ($candidate -> visa ?-> file)))
                        <div>
                            <a href="{{ $candidate -> visa ?-> file }}"
                               download="{{ $candidate -> fullName() }} - Visa Copy"
                               target="_blank">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> visa ?-> file }}" target="_blank">
                                <i class="tf-icons ti ti-photo"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" name="file" class="form-control" id="file"
                       accept="image/*">
            </div>
        </div>
    </div>
    <div class="card-footer border-top pt-4">
        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Save</button>
    </div>
</form>