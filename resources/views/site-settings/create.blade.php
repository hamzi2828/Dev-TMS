<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <form class="pt-0" method="post" enctype="multipart/form-data"
                          action="{{ route ('site-settings.store') }}">
                        @csrf
                        <div class="card-body pt-1 pb-1">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="title">Title</label>
                                    <input type="text" class="form-control" autofocus="autofocus"
                                           name="title" placeholder="Title" id="title"
                                           value="{{ old ('title', $settings -> settings ?-> title) }}" />
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" class="form-control" id="email"
                                           name="email" placeholder="Email"
                                           value="{{ old ('email', $settings -> settings ?-> email) }}" />
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone"
                                           name="phone" placeholder="Phone"
                                           value="{{ old ('phone', $settings -> settings ?-> phone) }}" />
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="logo">Logo</label>
                                        @if(!empty(trim ($settings -> settings ?-> logo)))
                                            <div>
                                                <a href="{{ $settings -> settings ?-> logo }}"
                                                   download="Logo"
                                                   target="_blank">
                                                    <i class="tf-icons ti ti-download"></i>
                                                </a>
                                                <a href="{{ $settings -> settings ?-> logo }}" target="_blank">
                                                    <i class="tf-icons ti ti-photo"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" name="logo" class="form-control" id="logo"
                                           accept="image/*">
                                </div>
                                
                                <div class="col-md-8 mb-3">
                                    <label class="form-label" for="address">Address</label>
                                    <textarea name="address" class="form-control" id="address"
                                              rows="3">{{ old ('address', $settings -> settings ?-> address) }}</textarea>
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