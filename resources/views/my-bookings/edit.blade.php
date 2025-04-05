<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>

                    <form class="pt-0" method="post"
                          action="{{ route('airlineGroups.update', ['airlineGroup' => $airlineGroup->id]) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body pt-1 pb-1">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="title">Airline Group Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $airlineGroup->title }}" required>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="airline_id">Select Airline</label>
                                    <select class="form-select select2" id="airline_id" name="airline_id" required>
                                        <option value="">Select Airline</option>
                                        @foreach($airlines as $airline)
                                            <option value="{{ $airline->id }}" {{ $airlineGroup->airline_id == $airline->id ? 'selected' : '' }}>
                                                {{ $airline->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="sector_id">Select Sector</label>
                                    <select class="form-select select2" id="sector_id" name="sector_id" required>
                                        <option value="">Select Sector</option>
                                        @foreach($sectors as $sector)
                                            <option value="{{ $sector->id }}" {{ $airlineGroup->sector_id == $sector->id ? 'selected' : '' }}>
                                                {{ $sector->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="company_id">Company</label>
                                    <select class="form-select select2" id="company_id" name="company_id" required>
                                        <option value=""> </option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}" {{ $airlineGroup->company_id == $company->id ? 'selected' : '' }}>
                                                {{ $company->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="cost_per_adult">Cost Per Adult</label>
                                    <input type="number" step="0.01" class="form-control" name="cost_per_adult" value="{{ $airlineGroup->cost_per_adult }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="sale_per_adult">Sale Per Adult</label>
                                    <input type="number" step="0.01" class="form-control" name="sale_per_adult" value="{{ $airlineGroup->sale_per_adult }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="cost_per_child">Cost Per Child</label>
                                    <input type="number" step="0.01" class="form-control" name="cost_per_child" value="{{ $airlineGroup->cost_per_child }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="sale_per_child">Sale Per Child</label>
                                    <input type="number" step="0.01" class="form-control" name="sale_per_child" value="{{ $airlineGroup->sale_per_child }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="cost_per_infant">Cost Per Infant</label>
                                    <input type="number" step="0.01" class="form-control" name="cost_per_infant" value="{{ $airlineGroup->cost_per_infant }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="sale_per_infant">Sale Per Infant</label>
                                    <input type="number" step="0.01" class="form-control" name="sale_per_infant" value="{{ $airlineGroup->sale_per_infant }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="total_seats">No. of Seats</label>
                                    <input type="number" class="form-control" name="total_seats" value="{{ $airlineGroup->total_seats }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="admin_seats">Seats Allocation for Admin</label>
                                    <input type="number" class="form-control" name="admin_seats" value="{{ $airlineGroup->admin_seats }}" required>
                                </div>
                            </div>

                            </div>

                            <div id="segments-container">
                                @foreach($airlineGroup->segments as $index => $segment)
                                    <div class="segment-wrapper mb-3 border p-3 rounded">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="fw-bold mb-0">Segment {{ $index + 1 }}</h6>
                                            <button type="button" class="btn btn-sm btn-danger remove-segment">🗑</button>
                                        </div>
                                        <div class="row segment-row">
                                            <input type="hidden" name="segments[{{ $index }}][id]" value="{{ $segment->id }}">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Departure Date</label>
                                                <input type="date" class="form-control flatpickr-basic" name="segments[{{ $index }}][departure_date]" value="{{ $segment->departure_date }}" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Airline</label>
                                                <select class="form-select select2" name="segments[{{ $index }}][airline_id]" required>
                                                    <option value="">Select Airline</option>
                                                    @foreach($airlines as $airline)
                                                        <option value="{{ $airline->id }}" {{ $segment->airline_id == $airline->id ? 'selected' : '' }}>
                                                            {{ $airline->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Flight #</label>
                                                <input type="text" class="form-control" name="segments[{{ $index }}][flight_number]" value="{{ $segment->flight_number }}" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Origin</label>
                                                <select class="form-select select2" name="segments[{{ $index }}][origin]" required>
                                                    <option value="">Select Origin City</option>
                                                    @foreach($cities as $city)
                                                        <option value="{{ $city->id }}" {{ $segment->origin == $city->id ? 'selected' : '' }}>
                                                            {{ $city->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Destination</label>
                                                <select class="form-select select2" name="segments[{{ $index }}][destination]" required>
                                                    <option value="">Select Destination City</option>
                                                    @foreach($cities as $city)
                                                        <option value="{{ $city->id }}" {{ $segment->destination == $city->id ? 'selected' : '' }}>
                                                            {{ $city->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Departure Time</label>
                                                <input type="time" class="form-control" name="segments[{{ $index }}][departure_time]" value="{{ $segment->departure_time }}" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Arrival Time</label>
                                                <input type="time" class="form-control" name="segments[{{ $index }}][arrival_time]" value="{{ $segment->arrival_time }}" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Baggage</label>
                                                <input type="text" class="form-control" name="segments[{{ $index }}][baggage]" value="{{ $segment->baggage }}" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Meal</label>
                                                <select class="form-select select2" name="segments[{{ $index }}][meal]" required>
                                                    <option value="">Select</option>
                                                    <option value="yes" {{ $segment->meal == 'yes' ? 'selected' : '' }}>Yes</option>
                                                    <option value="no" {{ $segment->meal == 'no' ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="text-end mb-3">
                                <button type="button" id="add-segment" class="btn btn-outline-secondary">+ Add More</button>
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
            let segmentIndex = {{ count($airlineGroup->segments) }};

            const airlineOptions = `@foreach($airlines as $airline)<option value="{{ $airline->id }}">{{ $airline->title }}</option>@endforeach`;
            const mealOptions = `<option value="">Select</option><option value="yes">Yes</option><option value="no">No</option>`;

            $(document).ready(function () {
                $('.select2').select2();

                $('#add-segment').on('click', function () {
                    const html = `
                        <div class="segment-wrapper mb-3 border p-3 rounded">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-bold mb-0">Segment ${segmentIndex + 1}</h6>
                                <button type="button" class="btn btn-sm btn-danger remove-segment">🗑</button>
                            </div>
                            <div class="row segment-row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Departure Date</label>
                                    <input type="date" class="form-control flatpickr-basic" name="segments[${segmentIndex}][departure_date]" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Airline</label>
                                    <select class="form-select select2" name="segments[${segmentIndex}][airline_id]" required>
                                        ${airlineOptions}
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Flight #</label>
                                    <input type="text" class="form-control" name="segments[${segmentIndex}][flight_number]" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Origin</label>
                                    <select class="form-select select2" name="segments[${segmentIndex}][origin]" required>
                                        <option value="">Select Origin City</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Destination</label>
                                    <select class="form-select select2" name="segments[${segmentIndex}][destination]" required>
                                        <option value="">Select Destination City</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Departure Time</label>
                                    <input type="time" class="form-control" name="segments[${segmentIndex}][departure_time]" required step="60">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Arrival Time</label>
                                    <input type="time" class="form-control" name="segments[${segmentIndex}][arrival_time]" required step="60">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Baggage</label>
                                    <input type="text" class="form-control" name="segments[${segmentIndex}][baggage]" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Meal</label>
                                    <select class="form-select select2" name="segments[${segmentIndex}][meal]" required>
                                        ${mealOptions}
                                    </select>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#segments-container').append(html);
                    $('.select2').select2();
                    segmentIndex++;
                });

                $(document).on('click', '.remove-segment', function () {
                    const wrapper = $(this).closest('.segment-wrapper');

                    // Check if this is an existing segment
                    const segmentIdInput = wrapper.find('input[name$="[id]"]');
                    if (segmentIdInput.length) {
                        const segmentId = segmentIdInput.val();
                        // Append hidden input to form to track deletion
                        wrapper.hide(); // Hide visually
                        wrapper.append(`<input type="hidden" name="deleted_segments[]" value="${segmentId}">`);
                    } else {
                        wrapper.remove(); // New segment, just remove
                    }
                });

            });
        </script>
    @endpush
</x-dashboard>
