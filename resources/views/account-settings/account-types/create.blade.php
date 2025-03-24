<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <form class="pt-0" method="post" method="post"
                          action="{{ route ('account-types.store') }}">
                        @csrf
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-9 mb-1">
                                    <label class="col-form-label font-small-4"
                                           for="title">Title</label>
                                    <input type="text" id="title" class="form-control"
                                           required="required" autofocus="autofocus"
                                           name="title" placeholder="Title" value="{{ old ('title') }}" />
                                </div>
                                
                                <div class="col-3 mb-1">
                                    <label class="col-form-label font-small-4"
                                           for="title">Account Tye</label>
                                    <select name="type" class="form-control select2" required="required"
                                            data-placeholder="Select">
                                        <option></option>
                                        <option value="credit" @selected(old ('type') == 'credit')>Credit</option>
                                        <option value="debit" @selected(old ('type') == 'debit')>Debit</option>
                                    </select>
                                </div>
                            </div>
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