<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <div class="card-body pt-1 pb-1">
                        <div class="row">
                            <div class="col-12 chat-of-accounts">
                                {!! $accounts_heads !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard>