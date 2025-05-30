<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <form class="pt-0" method="post"
                          action="{{ route ('agents.update', ['agent' => $agent -> id]) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body pt-1 pb-1">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="title">Title</label>
                                    <input type="text" required="required" autofocus="autofocus" class="form-control"
                                           value="{{ old ('title', $agent -> name) }}"
                                           id="title" name="title" />
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="contact">Contact No</label>
                                    <input type="text" class="form-control"
                                           value="{{ old ('contact', $agent -> contact) }}"
                                           id="contact" name="contact" />
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="logo">Logo</label>
                                        @if(!empty(trim ($agent -> file)))
                                            <div>
                                                <a href="{{ $agent -> file }}"
                                                   download="{{ $agent -> file }}"
                                                   target="_blank">
                                                    <i class="tf-icons ti ti-download"></i>
                                                </a>
                                                <a href="{{ $agent -> file }}" target="_blank">
                                                    <i class="tf-icons ti ti-photo"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" class="form-control" id="logo" name="logo" />
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="address">Address</label>
                                    <textarea rows="3" class="form-control"
                                              id="address"
                                              name="address">{{ old ('address', $agent -> address) }}</textarea>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="credit_limit">Credit Limit</label>
                                    <input type="number" class="form-control" id="credit_limit" name="credit_limit"
                                           value="{{ old ('credit_limit', $agent -> credit_limit) }}" />
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
