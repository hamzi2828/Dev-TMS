<x-dashboard :title="$title">
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }}</h5>
                    <form class="pt-0" method="post" action="{{ route('myBookings.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body pt-1 pb-1">
                            <!-- Flight and Sector Information -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Airline Group Title</label>
                                    <input type="text" class="form-control" name="title" value="{{ $airlineGroup->title ?? '' }}" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Airline</label>
                                    <input type="text" class="form-control" value="{{ $airlineGroup->airline->title ?? '' }}" readonly>
                                    <input type="hidden" name="airline_id" value="{{ $airlineGroup->airline_id ?? '' }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Sector</label>
                                    <input type="text" class="form-control" value="@php
                                        $section = \App\Models\Section::find($airlineGroup->sector_id ?? 0);
                                        echo $section ? $section->title : ($airlineGroup->sector_id ?? '');
                                    @endphp" readonly>
                                    <input type="hidden" name="sector_id" value="{{ $airlineGroup->sector_id ?? '' }}">
                                </div>
                            </div>

                            <!-- Flight Details Table -->
                            <h6 class="mt-4">Flight Details</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="min-width: 100px">Dep. Date</th>
                                            <th>Airline</th>
                                            <th style="min-width: 70px">Flight #</th>
                                            <th>Origin</th>
                                            <th>Destination</th>
                                            <th>Dep. Time</th>
                                            <th>Arrival Time</th>
                                            <th>Baggage</th>
                                            <th>Meal</th>
                                            <th>Price Adult</th>
                                            <th>Price Child</th>
                                            <th>Price Infant</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($airlineGroup) && $airlineGroup->segments->count() > 0)
                                            @foreach($airlineGroup->segments as $segment)
                                            <tr>
                                                <td>{{ $segment->departure_date }}</td>
                                                <td>{{ $airlineGroup->airline->title ?? 'N/A' }}</td>
                                                <td>{{ $segment->flight_number }}</td>
                                                <td>
                                                    @php
                                                        $originCity = \App\Models\City::find($segment->origin);
                                                        echo $originCity ? $originCity->title : $segment->origin;
                                                    @endphp
                                                </td>
                                                <td>
                                                    @php
                                                        $destinationCity = \App\Models\City::find($segment->destination);
                                                        echo $destinationCity ? $destinationCity->title : $segment->destination;
                                                    @endphp
                                                </td>
                                                <td>{{ $segment->departure_time }}</td>
                                                <td>{{ $segment->arrival_time }}</td>
                                                <td>{{ $segment->baggage }}</td>
                                                <td>{{ $segment->meal }}</td>
                                                <td>{{ $airlineGroup->sale_per_adult }}</td>
                                                <td>{{ $airlineGroup->sale_per_child }}</td>
                                                <td>{{ $airlineGroup->sale_per_infant }}</td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="12" class="text-center">No flight details available</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <!-- Passengers Section -->
                            <h6 class="mt-4">Passengers</h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Adults</label>
                                    <input type="number" id="adults" class="form-control" name="adults" value="0" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Children</label>
                                    <input type="number" id="children" class="form-control" name="children" value="0" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Infants</label>
                                    <input type="number" id="infants" class="form-control" name="infants" value="0" required>
                                </div>
                            </div>

                            <!-- Passenger Details Section (Dynamically Added) -->
                            <h6 class="mt-4">Passenger Details</h6>
                            <div id="passenger-details">
                                <!-- Rows will be added dynamically based on inputs above -->
                            </div>

                            <!-- Confirm Button -->
                            <div class="text-end mb-3">
                                <input type="hidden" name="airline_group_id" value="{{ $airlineGroup->id ?? '' }}">
                                <button type="submit" class="btn btn-primary">Confirm Booking</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                // Function to add passenger details rows
                function addPassengerRows(adults, children, infants) {
                    let rows = '';
                    let passengerIndex = 1;

                    // Add Adult Passengers
                    for (let i = 0; i < adults; i++) {
                        rows += `<div class="row mb-3">
                                    <div class="col-md-1">
                                        <label class="form-label">Adult</label>
                                        <input type="text" class="form-control" value=" ${passengerIndex}" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Title</label>
                                        <input type="text" name="passenger[${passengerIndex}][title]" class="form-control" placeholder="Title" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Surname</label>
                                        <input type="text" name="passenger[${passengerIndex}][surname]" class="form-control" placeholder="Surname" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Given Name</label>
                                        <input type="text" name="passenger[${passengerIndex}][given_name]" class="form-control" placeholder="Given Name" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Passport No</label>
                                        <input type="text" name="passenger[${passengerIndex}][passport]" class="form-control" placeholder="Passport No" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="date" name="passenger[${passengerIndex}][dob]" class="form-control" placeholder="Date of Birth" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Passport Expiry</label>
                                        <input type="date" name="passenger[${passengerIndex}][passport_expiry]" class="form-control" placeholder="Passport Expiry" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Nationality</label>
                                        <input type="text" name="passenger[${passengerIndex}][nationality]" class="form-control" placeholder="Nationality" required>
                                    </div>
                                </div>`;
                        passengerIndex++;
                    }

                    // Add Children Passengers
                    for (let i = 0; i < children; i++) {
                        rows += `<div class="row mb-3">
                                <div class="col-md-1">
                                    <label class="form-label">Child</label>
                                    <input type="text" class="form-control" value=" ${passengerIndex}" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="passenger[${passengerIndex}][title]" class="form-control" placeholder="Title" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Surname</label>
                                    <input type="text" name="passenger[${passengerIndex}][surname]" class="form-control" placeholder="Surname" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Given Name</label>
                                    <input type="text" name="passenger[${passengerIndex}][given_name]" class="form-control" placeholder="Given Name" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Passport No</label>
                                    <input type="text" name="passenger[${passengerIndex}][passport]" class="form-control" placeholder="Passport No" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Date Of Birth</label>
                                    <input type="date" name="passenger[${passengerIndex}][dob]" class="form-control" placeholder="Date Of Birth" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Passport Expiry</label>
                                    <input type="date" name="passenger[${passengerIndex}][passport_expiry]" class="form-control" placeholder="Passport Expiry" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Nationality</label>
                                    <input type="text" name="passenger[${passengerIndex}][nationality]" class="form-control" placeholder="Nationality" required>
                                    </div>
                                </div>`;
                        passengerIndex++;
                    }

                    // Add Infant Passengers
                    for (let i = 0; i < infants; i++) {
                        rows += `<div class="row mb-3">
                                <div class="col-md-1">
                                    <label class="form-label">Infant</label>
                                    <input type="text" class="form-control" value=" ${passengerIndex}" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="passenger[${passengerIndex}][title]" class="form-control" placeholder="Title" required>
                                </div>
                                <div class="col-md-2">
                                        <label class="form-label">Surname</label>
                                        <input type="text" name="passenger[${passengerIndex}][surname]" class="form-control" placeholder="Surname" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Given Name</label>
                                        <input type="text" name="passenger[${passengerIndex}][given_name]" class="form-control" placeholder="Given Name" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Passport No</label>
                                        <input type="text" name="passenger[${passengerIndex}][passport]" class="form-control" placeholder="Passport No" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Date Of Birth</label>
                                        <input type="date" name="passenger[${passengerIndex}][dob]" class="form-control" placeholder="Date Of Birth" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Passport Expiry</label>
                                        <input type="date" name="passenger[${passengerIndex}][passport_expiry]" class="form-control" placeholder="Passport Expiry" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Nationality</label>
                                        <input type="text" name="passenger[${passengerIndex}][nationality]" class="form-control" placeholder="Nationality" required>
                                    </div>
                                </div>`;
                        passengerIndex++;
                    }

                    // Update passenger details container
                    $('#passenger-details').html(rows);
                }

                // Listen for changes in the passenger input fields
                $('#adults, #children, #infants').on('change', function () {
                    const adults = $('#adults').val();
                    const children = $('#children').val();
                    const infants = $('#infants').val();
                    addPassengerRows(adults, children, infants);
                });

                // Initial population
                addPassengerRows($('#adults').val(), $('#children').val(), $('#infants').val());
            });
        </script>
    @endpush
</x-dashboard>
