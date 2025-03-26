<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <form class="pt-0" method="post"
                          action="{{ route('sections.update', ['section' => $section->id]) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body pt-1 pb-1">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="trip_type">Trip Type</label>
                                    <select class="form-select select2" id="trip_type" name="trip_type">
                                        <option value="">Select Trip Type</option>
                                        <option value="oneway" {{ $section->trip_type == 'oneway' ? 'selected' : '' }}>One Way</option>
                                        <option value="roundtrip" {{ $section->trip_type == 'roundtrip' ? 'selected' : '' }}>Round Trip</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="airline_id">Airline</label>
                                    <select class="form-select select2" id="airline_id" name="airline_id" required>
                                        <option value="">Select Airline</option>
                                        @foreach($airlines as $airline)
                                            <option value="{{ $airline->id }}" 
                                                {{ $section->airline_id == $airline->id ? 'selected' : '' }}>
                                                {{ $airline->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="origin_city_id">Origin</label>
                                    <select class="form-select select2" id="origin_city_id" name="origin_city_id" required>
                                        <option value="">Select Origin City</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ $section->origin_city_id == $city->id ? 'selected' : '' }}>
                                                {{ $city->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="destination_city_id">Destination</label>
                                    <select class="form-select select2" id="destination_city_id" name="destination_city_id" required>
                                        <option value="">Select Destination City</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ $section->destination_city_id == $city->id ? 'selected' : '' }}>
                                                {{ $city->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-top pt-4">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#destination_city_id').on('change', function() {
                let origin = $('#origin_city_id').val();
                let destination = $(this).val();
                
                if(origin === destination) {
                    alert('Origin and Destination cities cannot be same');
                    $(this).val('').trigger('change');
                }
            });
        });
    </script>
    @endpush
</x-dashboard>