<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <form class="pt-0" method="post" action="{{ route ('company-requisitions.store') }}">
                        @csrf
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
                                                <option value="{{ $principal -> id }}" @selected(old ('principal-id') == $principal -> id)>
                                                    {{ $principal -> name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="profession">Profession</label>
                                    <select id="profession" name="jobs[]" class="form-control select2"
                                            required="required"
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
                                           name="quota[]" required="required">
                                </div>
                            </div>
                            
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