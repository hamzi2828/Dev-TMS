<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <form class="pt-0" method="post" action="{{ route ('principals.store') }}"
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
                                    <label class="form-label" for="footer">Footer</label>
                                    <input type="file" class="form-control" id="footer" name="footer" />
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="city-id">City</label>
                                    <select name="city-id" class="form-control select2"
                                            data-placeholder="Select"
                                            id="city-id">
                                        <option></option>
                                        @if(count ($countries) > 0)
                                            @foreach($countries as $country)
                                                <optgroup label="{{ $country -> title }}">
                                                    @if(count ($country -> cities) > 0)
                                                        @foreach($country -> cities as $city)
                                                            <option value="{{ $city -> id }}"
                                                                    @selected(old ('city-id') == $city -> id)>
                                                                {{ $city -> title }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </optgroup>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="col-md-9 mb-3">
                                    <label class="form-label" for="address">Address</label>
                                    <textarea rows="3" class="form-control"
                                              id="address" name="address">{{ old ('address') }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <h5 class="card-header border-bottom pt-3 pb-2 mb-3 text-danger fw-bold">
                            Principal Profession Fee
                        </h5>
                        <div class="card-body pt-1 pb-1">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <div class="card-datatable table-responsive">
                                        <table class="table table-hover table-sm table-bordered" id="excel-table">
                                            <thead class="border-top bg-light">
                                            <tr>
                                                <th width="5%" align="center">#</th>
                                                <th width="75%">Profession</th>
                                                <th width="20%">Fee</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count ($jobs) > 0)
                                                @foreach($jobs as $key => $job)
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="job[]" value="{{ $job -> id }}">
                                                            {{ $loop -> iteration }}
                                                        </td>
                                                        <td>{{ $job -> title }}</td>
                                                        <td>
                                                            <label class="w-100">
                                                                <input type="number" class="form-control" name="fee[]"
                                                                       value="{{ old ('fee.'.$key, 0) }}">
                                                            </label>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
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