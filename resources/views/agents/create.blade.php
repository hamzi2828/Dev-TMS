<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <form class="pt-0" method="post" action="{{ route ('agents.store') }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="card-body pt-1 pb-1">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="title">Title</label>
                                    <input type="text" required="required" autofocus="autofocus" class="form-control"
                                           value="{{ old ('title') }}"
                                           id="title" name="title" />
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="contact">Contact No</label>
                                    <input type="text" class="form-control" value="{{ old ('contact') }}"
                                           id="contact" name="contact" />
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="logo">Logo</label>
                                    <input type="file" class="form-control" id="logo" name="file" />
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="address">Address</label>
                                    <textarea rows="3" class="form-control"
                                              id="address" name="address">{{ old ('address') }}</textarea>
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