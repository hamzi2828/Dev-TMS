<form class="pt-0" method="post"
      action="{{ $candidate -> interview ? route ('candidates.interviews.update', ['candidate' => $candidate -> id, 'interview' => $candidate -> interview -> id]) : route ('candidates.interviews.store', ['candidate' => $candidate -> id]) }}"
      enctype="multipart/form-data">
    @csrf
    
    @if($candidate -> interview)
        @method('PUT')
    @endif
    <div class="card-body pt-1 pb-1">
        @include('candidates.edit.candidate-info')
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label" for="diagnostic">Diagnostic</label>
                <input type="text" name="diagnostic" class="form-control"
                       id="diagnostic" autofocus="autofocus"
                       value="{{ old ('diagnostic', $candidate -> interview ?-> diagnostic) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="writing">Writing</label>
                <input type="text" name="writing" class="form-control"
                       id="writing"
                       value="{{ old ('writing', $candidate -> interview ?-> writing) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="spoken-english-score">Spoken English</label>
                <input type="text" name="spoken-english-score" class="form-control"
                       id="spoken-english-score"
                       value="{{ old ('spoken-english-score', $candidate -> interview ?-> english) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="overall-ept">Overall EPT</label>
                <input type="text" name="overall-ept" class="form-control"
                       id="overall-ept"
                       value="{{ old ('overall-ept', $candidate -> interview ?-> ept) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="attitude">Attitude</label>
                <input type="text" name="attitude" class="form-control" id="attitude"
                       value="{{ old ('attitude', $candidate -> interview ?-> attitude) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="job-experience">Job Experience</label>
                <input type="text" name="job-experience" class="form-control" id="job-experience"
                       value="{{ old ('job-experience', $candidate -> interview ?-> experience) }}">
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label" for="status">
                    Status
                    <sup class="text-danger fs-5 top-0">*</sup>
                </label>
                <select name="status" class="form-control select2" data-placeholder="Select" required="required"
                        {{ ((!empty(trim ($candidate -> interview ?-> status))) && $candidate -> interview ?-> status_update_count > 0 && !auth () -> user () -> is_admin()) ? 'disabled="disabled"' : '' }}
                        id="status">
                    <option></option>
                    <option value="selected" @selected(old ('status', $candidate -> interview ?-> status) == 'selected')>
                        Selected
                    </option>
                    <option value="rejected" @selected(old ('status', $candidate -> interview ?-> status) == 'rejected')>
                        Rejected
                    </option>
                    <option value="standby" @selected(old ('status', $candidate -> interview ?-> status) == 'standby')>
                        StandBy
                    </option>
                </select>
            </div>
            
            <div class="col-md-9 mb-3">
                <label class="form-label" for="remarks">Remarks</label>
                <textarea name="remarks" class="form-control"
                          id="remarks" rows="5">{{ old ('remarks', $candidate -> interview ?-> remarks) }}</textarea>
            </div>
        </div>
        
        <div class="row">
            <h4 class="bg-dark text-white pt-1 pb-1 fw-semibold">Attachments</h4>
        </div>
        
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="ept-result">EPT Result (Front)</label>
                    @if($candidate -> interview ?-> document && !empty(trim ($candidate -> interview ?-> document ?-> ept)))
                        <div>
                            <a href="{{ $candidate -> interview ?-> document ?-> ept }}"
                               download="{{ $candidate -> fullName() }} - EPT Result" target="_blank">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> interview ?-> document ?-> ept }}" target="_blank">
                                <i class="tf-icons ti ti-photo"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" name="ept-result" class="form-control" id="ept-result"
                       accept="image/*">
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="ept-result-back">EPT Result (Back)</label>
                    @if($candidate -> interview ?-> document && !empty(trim ($candidate -> interview ?-> document ?-> ept_back)))
                        <div>
                            <a href="{{ $candidate -> interview ?-> document ?-> ept_back }}"
                               download="{{ $candidate -> fullName() }} - EPT Result Back" target="_blank">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> interview ?-> document ?-> ept_back }}" target="_blank">
                                <i class="tf-icons ti ti-photo"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" name="ept-result-back" class="form-control" id="ept-result-back"
                       accept="image/*">
            </div>
            
            <div class="col-md-3 mb-3 d-none">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="experience-letter">Experience Letter</label>
                    @if($candidate -> interview ?-> document && !empty(trim ($candidate -> interview ?-> document ?-> experience)))
                        <div>
                            <a href="{{ $candidate -> interview ?-> document ?-> experience }}"
                               download="{{ $candidate -> fullName() }} - Experience Letter" target="_blank">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> interview ?-> document ?-> experience }}" target="_blank">
                                <i class="tf-icons ti ti-photo"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" name="experience-letter" class="form-control" id="experience-letter"
                       accept="image/*">
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="assessment-aptitude-front">Assessment-Aptitude (Front)</label>
                    @if($candidate -> interview ?-> document && !empty(trim ($candidate -> interview ?-> document ?-> assessment_aptitude_front)))
                        <div>
                            <a href="{{ $candidate -> interview ?-> document ?-> assessment_aptitude_front }}"
                               download="{{ $candidate -> fullName() }} - Assessment-Aptitude (Front)" target="_blank">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> interview ?-> document ?-> assessment_aptitude_front }}" target="_blank">
                                <i class="tf-icons ti ti-photo"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" name="assessment-aptitude-front" class="form-control" id="assessment-aptitude-front"
                       accept="image/*">
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="assessment-aptitude-back">Assessment-Aptitude (Back)</label>
                    @if($candidate -> interview ?-> document && !empty(trim ($candidate -> interview ?-> document ?-> assessment_aptitude_back)))
                        <div>
                            <a href="{{ $candidate -> interview ?-> document ?-> assessment_aptitude_back }}"
                               download="{{ $candidate -> fullName() }} - Assessment-Aptitude (Back)" target="_blank">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> interview ?-> document ?-> assessment_aptitude_back }}" target="_blank">
                                <i class="tf-icons ti ti-photo"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" name="assessment-aptitude-back" class="form-control" id="assessment-aptitude-back"
                       accept="image/*">
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="spoken-english">Spoken English</label>
                    @if($candidate -> interview ?-> document && !empty(trim ($candidate -> interview ?-> document ?-> english)))
                        <div>
                            <a href="{{ $candidate -> interview ?-> document ?-> english }}"
                               download="{{ $candidate -> fullName() }} - Spoken English" target="_blank">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> interview ?-> document ?-> english }}" target="_blank">
                                <i class="tf-icons ti ti-photo"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" name="spoken-english" class="form-control" id="spoken-english"
                       accept="image/*">
            </div>
        </div>
    </div>
    <div class="card-footer border-top pt-4">
        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Save</button>
    </div>
</form>