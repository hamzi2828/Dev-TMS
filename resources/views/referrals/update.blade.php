<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <form class="pt-0" method="post"
                          action="{{ route ('referrals.update', ['referral' => $referral -> id]) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body pt-1 pb-1">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="title">Title</label>
                                    <input type="text" required="required" autofocus="autofocus" class="form-control"
                                           value="{{ old ('title', $referral -> name) }}"
                                           id="title" name="title" />
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="contact">Contact No</label>
                                    <input type="text" class="form-control"
                                           value="{{ old ('contact', $referral -> contact) }}"
                                           id="contact" name="contact" />
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="logo">Logo</label>
                                        @if(!empty(trim ($referral -> file)))
                                            <div>
                                                <a href="{{ $referral -> file }}"
                                                   download="{{ $referral -> file }}"
                                                   target="_blank">
                                                    <i class="tf-icons ti ti-download"></i>
                                                </a>
                                                <a href="{{ $referral -> file }}" target="_blank">
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
                                              name="address">{{ old ('address', $referral -> address) }}</textarea>
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