<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <form class="pt-0" method="POST" action="{{ route('sections.update', $section->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body pt-1 pb-1">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="title">Title</label>
                                    <input type="text" required class="form-control" id="title" name="title"
                                           value="{{ old('title', $section->title) }}" />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="trip_type">Trip Type</label>
                                    <select class="form-select select2" id="trip_type" name="trip_type" required>
                                        <option value="">Select Trip Type</option>
                                        <option value="oneway" {{ $section->trip_type == 'oneway' ? 'selected' : '' }}>One Way</option>
                                        <option value="roundtrip" {{ $section->trip_type == 'roundtrip' ? 'selected' : '' }}>Round Trip</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="route_type">Trip Route</label>
                                    <select class="form-select select2" id="route_type" name="route_type" required>
                                        <option value="">Select Trip Route</option>
                                        <option value="direct" {{ $section->route_type == 'direct' ? 'selected' : '' }}>Direct</option>
                                        <option value="via" {{ $section->route_type == 'via' ? 'selected' : '' }}>Via</option>
                                    </select>
                                </div>



                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="origin_city_id">Origin</label>
                                    <select class="form-select select2" id="origin_city_id" name="origin_city_id" required>
                                        <option value="">Select Origin City</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" {{ $section->origin_city_id == $city->id ? 'selected' : '' }}>
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
                                            <option value="{{ $city->id }}" {{ $section->destination_city_id == $city->id ? 'selected' : '' }}>
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

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .select2-container--default .select2-selection--single {
                height: 38px;
                border: 1px solid #d9dee3;
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 38px;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 36px;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('.select2').select2();

                $('#destination_city_id').on('change', function () {
                    let origin = $('#origin_city_id').val();
                    let destination = $(this).val();

                    if (origin === destination) {
                        alert('Origin and Destination cities cannot be same');
                        $(this).val('').trigger('change');
                    }
                });

                $('#trip_type').select2({
                    placeholder: 'Select Trip Type',
                    allowClear: true,
                    width: '100%'
                });
            });
        </script>
    @endpush
</x-dashboard>
