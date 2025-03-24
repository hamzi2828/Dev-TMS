<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <form class="pt-0" method="post"
                          action="{{ route ('company-requisitions.update', ['company_requisition' => $company_requisition -> id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="card-body pt-1 pb-1">
                            <div class="row border-bottom mb-4">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="principal-id">Principal</label>
                                    <select id="principal-id" name="principal-id"
                                            class="form-control select2" required="required"
                                            data-placeholder="Select">
                                        <option></option>
                                        @if(count ($principals) > 0)
                                            @foreach($principals as $principal)
                                                <option value="{{ $principal -> id }}" @selected(old ('principal-id', $company_requisition -> principal_id) == $principal -> id)>
                                                    {{ $principal -> name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            
                            @if(count($company_requisition -> jobs) > 0)
                                @foreach($company_requisition -> jobs as $key => $job)
                                    @php
                                        $allocatedQuota = (new \App\Services\CandidateCompanyRequisitionJobService()) -> count_allocated_quota($job -> id);
                                        $remaining = $job -> quota - $allocatedQuota;
                                    @endphp
                                    <input type="hidden" name="requisition-jobs[]" value="{{ $job -> id }}">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label" for="profession">
                                                @if($allocatedQuota < 1)
                                                    <a href="#" onclick="return confirm('Are you sure?')">
                                                        <i class="fs-6 tf-icons ti ti-trash"></i>
                                                    </a>
                                                @endif
                                                Profession
                                            </label>
                                            <select id="profession" class="form-control select2"
                                                    required="required"
                                                    data-placeholder="Select">
                                                <option value="{{ $job -> job ?-> id }}" selected="selected">
                                                    {{ $job -> job ?-> title }}
                                                </option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-2 mb-3">
                                            <label class="form-label" for="quota">Demand</label>
                                            <input type="number" class="form-control quota-{{ $key }}"
                                                   min="{{ $remaining }}"
                                                   onchange="restrictDemand(this.value, {{ $key }})"
                                                   value="{{ old ('quota.'.$key, $job -> quota) }}" id="quota"
                                                   name="requisition-quota[]" required="required">
                                        </div>
                                        
                                        <div class="col-md-2 mb-3">
                                            <label class="form-label" for="used">Used</label>
                                            <input type="number" class="form-control used-{{ $key }}"
                                                   readonly="readonly"
                                                   value="{{ $allocatedQuota }}"
                                                   id="used">
                                        </div>
                                        
                                        <div class="col-md-2 mb-3">
                                            <label class="form-label" for="remaining">Remaining</label>
                                            <input type="number" class="form-control" readonly="readonly"
                                                   value="{{ $remaining }}"
                                                   id="remaining">
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            
                            <div id="addMore"></div>
                        </div>
                        <div class="card-footer border-top pt-4">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Save</button>
                            <a href="javascript:void(0)" type="button" class="btn btn-dark me-sm-3 me-1"
                               onclick="addMoreRequisitionQuota('{{ route ('company-requisitions.add-more') }}')">
                                Add More
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard>