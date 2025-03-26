<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <form class="pt-0" method="post" action="{{ route ('airlines.update', ['airline' => $airline -> id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body pt-1 pb-1">
                            <div class="row">
                                <div class="col-4 mb-3">
                                    <label class="form-label" for="code">Code</label>
                                    <input type="text" required="required" class="form-control"
                                           value="{{ old('code', $airline->code) }}"
                                           id="code" name="code" />
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="logo">Logo</label>
                                        @if(!empty(trim ($airline -> file)))
                                            <div> 
                                                <a href="{{ $airline -> file }}"
                                                   download="{{ $airline -> file }}"
                                                   target="_blank">
                                                    <i class="tf-icons ti ti-download"></i>
                                                </a>
                                                <a href="{{ $airline -> file }}" target="_blank">
                                                    <i class="tf-icons ti ti-photo"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" class="form-control" id="logo" name="logo" />
                                </div>

                                <div class="col-5 mb-3">
                                    <label class="form-label" for="title">Title</label>
                                    <input type="text" required="required" autofocus="autofocus" class="form-control"
                                           value="{{ old ('title', $airline -> title) }}"
                                           id="title" name="title" />
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