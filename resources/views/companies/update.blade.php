<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <form class="pt-0" method="post"
                          action="{{ route ('companies.update', ['company' => $company -> id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="card-body pt-1 pb-1">
                            
                            <div class="row">
                                <div class="col-2 mb-3">
                                    <label class="form-label" for="code">Code</label>
                                    <input
                                            type="text" required="required" autofocus="autofocus"
                                            class="form-control" value="{{ old ('code', $company -> code) }}"
                                            id="code"
                                            name="code" />
                                </div>
                                
                                <div class="col-4 mb-3">
                                    <label class="form-label" for="title">Name</label>
                                    <input
                                            type="text" required="required"
                                            class="form-control" value="{{ old ('title', $company -> title) }}"
                                            id="title"
                                            name="title" />
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="landline">Landline</label>
                                    <input
                                            type="text"
                                            id="landline" value="{{ old ('landline', $company -> landline) }}"
                                            class="form-control"
                                            name="landline" />
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="mobile">Mobile</label>
                                    <input
                                            type="text"
                                            id="mobile" value="{{ old ('mobile', $company -> mobile) }}"
                                            class="form-control"
                                            name="mobile" />
                                </div>
                                
                                <div class="col-12 mb-3">
                                    <label class="form-label" for="address">Address</label>
                                    <textarea name="address" id="address" class="form-control"
                                              rows="5">{{ old ('address', $company -> address) }}</textarea>
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