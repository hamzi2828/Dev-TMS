<x-dashboard :title="$title">
    @push('styles')
        <style>
            table h5 {
                color: rgb(234, 84, 85);
                font-weight: bolder !important;
                font-size: 1.125rem !important;
            }
        </style>
    @endpush
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <form class="pt-0" method="post" action="{{ route ('roles.update', ['role' => $role -> id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="card-body pt-1 pb-1">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label" for="title">Title</label>
                                    <input type="text" name="title" class="form-control"
                                           value="{{ old ('title', $role -> title) }}"
                                           id="title" required="required" autofocus="autofocus">
                                </div>
                            </div>
                            
                            @include('roles.permissions')
                        
                        </div>
                        <div class="card-footer border-top pt-4">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard>