<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <form class="pt-0" method="post" action="{{ route('airlineGroups.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body pt-1 pb-1">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="title">Airline Group Title</label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="" required>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="airline_id">Airline</label>
                                    <select class="form-select select2" id="airline_id" name="airline_id" required>
                                        <option value=""></option>
                                        @foreach($airlines as $airline)
                                            <option value="{{ $airline->id }}">{{ $airline->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="sector_id">Sector</label>
                                    <select class="form-select select2" id="sector_id" name="sector_id" required>
                                        <option value=""> </option>
                                        @foreach($sectors as $sector)
                                            <option value="{{ $sector->id }}">{{ $sector->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="company_id">Company</label>
                                    <select class="form-select select2" id="company_id" name="company_id" required>
                                        <option value=""> </option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="basic_per_adult">Basic Fare Per Adult</label>
                                    <input type="number" step="0.01" class="form-control" id="basic_per_adult" name="basic_per_adult" onchange="calculateCost('adult')" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="tax_per_adult">Tax Per Adult</label>
                                    <input type="number" step="0.01" class="form-control" id="tax_per_adult" name="tax_per_adult" onchange="calculateCost('adult')" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="cost_per_adult">Cost Per Adult</label>
                                    <input type="number" step="0.01" class="form-control" id="cost_per_adult" name="cost_per_adult" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="sale_per_adult">Sale Per Adult</label>
                                    <input type="number" step="0.01" class="form-control" id="sale_per_adult" name="sale_per_adult" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="basic_per_child">Basic Fare Per Child</label>
                                    <input type="number" step="0.01" class="form-control" id="basic_per_child" name="basic_per_child" onchange="calculateCost('child')">
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="tax_per_child">Tax Per Child</label>
                                    <input type="number" step="0.01" class="form-control" id="tax_per_child" name="tax_per_child" onchange="calculateCost('child')">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="cost_per_child">Cost Per Child</label>
                                    <input type="number" step="0.01" class="form-control" id="cost_per_child" name="cost_per_child" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="sale_per_child">Sale Per Child</label>
                                    <input type="number" step="0.01" class="form-control" id="sale_per_child" name="sale_per_child" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="basic_per_infant">Basic Fare Per Infant</label>
                                    <input type="number" step="0.01" class="form-control" id="basic_per_infant" name="basic_per_infant" onchange="calculateCost('infant')">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="tax_per_infant">Tax Per Infant</label>
                                    <input type="number" step="0.01" class="form-control" id="tax_per_infant" name="tax_per_infant" onchange="calculateCost('infant')">
                                </div>
                                <div class="col-md-3 mb-3">
                                        <label class="form-label" for="cost_per_infant">Cost Per Infant</label>
                                    <input type="number" step="0.01" class="form-control" id="cost_per_infant" name="cost_per_infant" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="sale_per_infant">Sale Per Infant</label>
                                    <input type="number" step="0.01" class="form-control" id="sale_per_infant" name="sale_per_infant" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="total_seats">No. of Seats</label>
                                    <input type="number" class="form-control" id="total_seats" name="total_seats" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="admin_seats">Seats Allocation for Admin</label>
                                    <input type="number" class="form-control" id="admin_seats" name="admin_seats" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label" for="expire_datetime">Expire Date Time</label>
                                    <input type="datetime-local" class="form-control" id="expire_datetime" name="expire_datetime" required>
                                </div>

                            </div>
                            </div>

                            <!-- End of Travel Agent Section -->
                              <div id="segments-container">
                                  <!-- First Segment -->
                                  <div class="segment-wrapper mb-3 border p-3 rounded">
                                      <div class="d-flex justify-content-between align-items-center mb-2">
                                          <h6 class="fw-bold mb-0">Segment 1</h6>
                                      </div>
                                      <div class="row segment-row">
                                          <div class="col-md-3 mb-3">
                                              <label class="form-label">Departure Date</label>
                                              <input type="date" class="form-control" name="segments[0][departure_date]" required>
                                          </div>
                                          <div class="col-md-3 mb-3">
                                              <label class="form-label">Airline</label>
                                              <select class="form-select select2" name="segments[0][airline_id]" required>
                                                  <option value=""></option>
                                                  @foreach($airlines as $airline)
                                                      <option value="{{ $airline->id }}">{{ $airline->title }}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                          <div class="col-md-3 mb-3">
                                              <label class="form-label">Flight #</label>
                                              <input type="text" class="form-control" name="segments[0][flight_number]" required>
                                          </div>
                                          <div class="col-md-3 mb-3">
                                              <label class="form-label">Origin</label>
                                              <select class="form-control select2" name="segments[0][origin]" required>
                                                  <option value=""></option>
                                                  @foreach($cities as $city)
                                                      <option value="{{ $city->id }}">{{ $city->title }}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                          <div class="col-md-3 mb-3">
                                              <label class="form-label">Destination</label>
                                              <select class="form-control select2" name="segments[0][destination]" required>
                                                  <option value=""></option>
                                                  @foreach($cities as $city)
                                                      <option value="{{ $city->id }}">{{ $city->title }}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                          <div class="col-md-3 mb-3">
                                              <label class="form-label">Departure Time</label>
                                              <input type="time" class="form-control" name="segments[0][departure_time]" required>
                                          </div>
                                          <div class="col-md-3 mb-3">
                                              <label class="form-label">Arrival Time</label>
                                              <input type="time" class="form-control" name="segments[0][arrival_time]" required>
                                          </div>
                                          <div class="col-md-3 mb-3">
                                              <label class="form-label">Baggage</label>
                                              <input type="text" class="form-control" name="segments[0][baggage]" required>
                                          </div>
                                          <div class="col-md-3 mb-3">
                                              <label class="form-label">Meal</label>
                                              <select class="form-select select2" name="segments[0][meal]" required>
                                                  <option value=""></option>
                                                  <option value="yes">Yes</option>
                                                  <option value="no">No</option>
                                              </select>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                            <div class="text-end mb-3">
                                <button type="button" id="add-segment" class="btn btn-outline-secondary">+ Add More</button>
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
            let segmentIndex = 1;

            const airlineOptions = `
                <option value=""></option>
                @foreach($airlines as $airline)
                    <option value="{{ $airline->id }}">{{ $airline->title }}</option>
                @endforeach
            `;

            const mealOptions = `
                <option value=""></option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            `;

            $(document).ready(function () {
                $('.select2').select2();

                $('#add-segment').on('click', function () {
                    const segmentHtml = `
                        <div class="segment-wrapper mb-3 border p-3 rounded">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-bold mb-0">Segment ${segmentIndex + 1}</h6>
                                <button type="button" class="btn btn-sm btn-danger remove-segment">🗑</button>
                            </div>
                            <div class="row segment-row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Departure Date</label>
                                    <input type="date" class="form-control" name="segments[${segmentIndex}][departure_date]" required>
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
                                    <select class="form-control select2" name="segments[${segmentIndex}][origin]" required>
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
                                    <input type="time" class="form-control" name="segments[${segmentIndex}][departure_time]" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Arrival Time</label>
                                    <input type="time" class="form-control" name="segments[${segmentIndex}][arrival_time]" required>
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
                    `;                    $('#segments-container').append(segmentHtml);
                    $('.select2').select2();
                    segmentIndex++;
                });

                // Remove segment
                $(document).on('click', '.remove-segment', function () {
                    $(this).closest('.segment-wrapper').remove();
                });
            });
        </script>


<script>
    function calculateCost(passengerType) {
        const basicFare = parseFloat(document.getElementById('basic_per_' + passengerType).value) || 0;
        const tax = parseFloat(document.getElementById('tax_per_' + passengerType).value) || 0;
        const cost = basicFare + tax;
        document.getElementById('cost_per_' + passengerType).value = cost.toFixed(2);
    }
    </script>
    @endpush
</x-dashboard>
