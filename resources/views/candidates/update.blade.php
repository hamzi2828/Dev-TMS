<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            
            <div class="col-xl-12">
                <div class="nav-align-top nav-tabs-shadow mb-4">
                    <ul class="nav nav-tabs justify-content-start" role="tablist">
                        @include('candidates.tabs')
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="navs-top-home" role="tabpanel">
                            @if(request () -> routeIs ('candidates.edit'))
                                @include('candidates.edit.personal')
                            @endif
                            
                            @if(request () -> routeIs ('candidates.show'))
                                @include('candidates.edit.show')
                            @endif
                            
                            @if(request () -> routeIs ('candidates.interviews.*'))
                                @include('candidates.edit.interview')
                            @endif
                            
                            @if(request () -> routeIs ('candidates.medicals.*'))
                                @include('candidates.edit.medical')
                            @endif
                            
                            @if(request () -> routeIs ('candidates.requisitions.*'))
                                @include('candidates.edit.requisition')
                            @endif
                            
                            @if(request () -> routeIs ('candidates.billing'))
                                @include('candidates.edit.billing')
                            @endif
                            
                            @if(request () -> routeIs ('candidates.trade-change'))
                                @include('candidates.edit.trade-change')
                            @endif
                            
                            @if(request () -> routeIs ('candidates.visas.*'))
                                @include('candidates.edit.visa')
                            @endif
                            
                            @if(request () -> routeIs ('candidates.tickets.*'))
                                @include('candidates.edit.ticket')
                            @endif
                            
                            @if(request () -> routeIs ('candidates.protectors.*'))
                                @include('candidates.edit.protector')
                            @endif
                            
                            @if(request () -> routeIs ('candidates.attachments'))
                                @include('candidates.edit.attachments')
                            @endif
                            
                            @if(request () -> routeIs ('candidates.document-ready.*'))
                                @include('candidates.edit.document-ready')
                            @endif
                            
                            @if(request () -> routeIs ('candidates.back-out.*'))
                                @include('candidates.edit.back-out')
                            @endif
                            
                            @if(request () -> routeIs ('candidates.payment-follow-up.*'))
                                @include('candidates.edit.payment-follow-up')
                            @endif
                            
                            @if(request () -> routeIs ('candidates.visa-follow-up.*'))
                                @include('candidates.edit.visa-follow-up')
                            @endif
                            
                            @if(request () -> routeIs ('candidates.ticket-follow-up.*'))
                                @include('candidates.edit.ticket-follow-up')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard>