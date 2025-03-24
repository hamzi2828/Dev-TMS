<option></option>
@if(count ($jobs) > 0)
    @foreach($jobs as $job)
        @php
            $allocatedQuota = (new \App\Services\CandidateCompanyRequisitionJobService()) -> count_allocated_quota($job -> id);
            $availableQuota = $job -> quota - $allocatedQuota;
        @endphp
        @if($availableQuota > 0)
            <option value="{{ $job -> id }}">
                {{ env ('MRF_NO') . $job -> company_requisition_id }} -
                {{ $job -> job ?-> title }} ({{ $availableQuota }})
            </option>
        @endif
    @endforeach
@endif