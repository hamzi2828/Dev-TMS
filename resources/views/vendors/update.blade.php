<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <form class="pt-0" method="post"
                          action="{{ route ('vendors.update', ['vendor' => $vendor -> id]) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body pt-1 pb-1">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="title">Title</label>
                                    <input type="text" required="required" autofocus="autofocus" class="form-control"
                                           value="{{ old ('title', $vendor -> title) }}"
                                           id="title" name="title" />
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="contact">Contact No</label>
                                    <input type="text" class="form-control"
                                           value="{{ old ('contact', $vendor -> contact) }}"
                                           id="contact" name="contact" />
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="fee">Fee</label>
                                    <input type="number" class="form-control" value="{{ old ('fee', $vendor -> fee) }}"
                                           id="fee" name="fee" />
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="vendor-payable">Vendor Payable</label>
                                    <input type="number" class="form-control" value="{{ old ('vendor-payable', $vendor -> vendor_payable) }}"
                                           id="vendor-payable" name="vendor-payable" />
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="address">Address</label>
                                    <textarea rows="3" class="form-control"
                                              id="address"
                                              name="address">{{ old ('address', $vendor -> address) }}</textarea>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="left-logo">Left Logo</label>
                                        @if(!empty(trim ($vendor -> left_logo)))
                                            <div>
                                                <a href="{{ $vendor -> left_logo }}"
                                                   download="{{ $vendor -> left_logo }}"
                                                   target="_blank">
                                                    <i class="tf-icons ti ti-download"></i>
                                                </a>
                                                <a href="{{ $vendor -> left_logo }}" target="_blank">
                                                    <i class="tf-icons ti ti-photo"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" class="form-control" id="left-logo" name="left-logo" />
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="right-logo">Right Logo</label>
                                        @if(!empty(trim ($vendor -> right_logo)))
                                            <div>
                                                <a href="{{ $vendor -> right_logo }}"
                                                   download="{{ $vendor -> right_logo }}"
                                                   target="_blank">
                                                    <i class="tf-icons ti ti-download"></i>
                                                </a>
                                                <a href="{{ $vendor -> right_logo }}" target="_blank">
                                                    <i class="tf-icons ti ti-photo"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" class="form-control" id="right-logo" name="right-logo" />
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