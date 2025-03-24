<form class="pt-0" method="post"
      action="{{ $candidate -> requisition ? route ('candidates.requisitions.update', ['candidate' => $candidate -> id, 'requisition' => $candidate -> requisition -> id]) : route ('candidates.requisitions.store', ['candidate' => $candidate -> id]) }}"
      enctype="multipart/form-data">
    @csrf
    
    @if($candidate -> requisition)
        @method('PUT')
    @endif
    <div class="card-body pt-1 pb-1">
        @include('candidates.edit.candidate-info')
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label" for="company-id">
                    Company
                    <sup class="text-danger fs-5 top-0">*</sup>
                </label>
                <select name="company-id" class="form-control select2"
                        data-placeholder="Select"
                        onchange="loadCompanyRequisitions(this.value, '{{ route ('load-company-requisitions') }}')"
                        required="required" id="company-id">
                    <option></option>
                    @if(count ($companies) > 0)
                        @foreach($companies as $company)
                            <option value="{{ $company -> id }}"
                                    @selected(old ('company-id', $company_id) == $company -> id)>
                                {{ $company -> title }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="company-requisition-job">
                    Profession/MRF
                    <sup class="text-danger fs-5 top-0">*</sup>
                </label>
                <select name="company-requisition-job-id" class="form-control select2"
                        data-placeholder="Select"
                        required="required" id="company-requisition-job">
                    <option></option>
                    @if(count ($jobs) > 0)
                        @foreach($jobs as $job)
                            @php
                                $allocatedQuota = (new \App\Services\CandidateCompanyRequisitionJobService()) -> count_allocated_quota($job -> id);
                                $availableQuota = $job -> quota - $allocatedQuota;
                            @endphp
                            @if($availableQuota > 0)
                                <option value="{{ $job -> id }}"
                                        @selected(old ('company-requisition-job', $company_requisition_job_id) == $job -> id)>
                                    {{ env ('MRF_NO') . $job -> company_requisition_id }} -
                                    {{ $job -> job ?-> title }} ({{ $availableQuota }})
                                    @endif
                                </option>
                                @endforeach
                            @endif
                </select>
            </div>
        </div>
    </div>
    <div class="card-footer border-top pt-4">
        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Save</button>
        @if($candidate -> requisition)
            @can('delete', $candidate -> requisition)
                <a href="javascript:void(0)"
                   onclick="event.preventDefault(); document.getElementById('delete-form').submit();"
                   class="btn btn-danger">Delete</a>
            @endcan
        @endif
    </div>
</form>

@if($candidate -> requisition)
    @can('delete', $candidate -> requisition)
        <form id="delete-form"
              action="{{ route ('candidates.requisitions.destroy', ['candidate' => $candidate -> id, 'requisition' => $candidate -> requisition -> id, 'method' => 'DELETE']) }}"
              method="POST">
            @csrf
            @method('DELETE')
        </form>
    @endcan
@endif