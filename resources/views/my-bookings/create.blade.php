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


                                    <thead class="border-top">
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
                                        <tr>
                                            <td>
                                                @foreach($airlineGroup->segments as $segment)
                                                    <div>{{ \Carbon\Carbon::parse($segment->departure_date)->format('d M Y') }}</div>
                                                @endforeach
                                            </td>
                                            <td>{{ $airlineGroup->airline->title ?? 'N/A' }}</td>
                                            <td>
                                                @foreach($airlineGroup->segments as $segment)
                                                    <div>{{ $segment->flight_number }}</div>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($airlineGroup->segments as $segment)
                                                    <div>{{ \App\Models\City::find($segment->origin)->title ?? 'N/A' }}</div>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($airlineGroup->segments as $segment)
                                                    <div>{{ \App\Models\City::find($segment->destination)->title ?? 'N/A' }}</div>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($airlineGroup->segments as $segment)
                                                    <div>{{ $segment->departure_time }}</div>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($airlineGroup->segments as $segment)
                                                    <div>{{ $segment->arrival_time }}</div>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($airlineGroup->segments as $segment)
                                                    <div>{{ $segment->baggage }}</div>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($airlineGroup->segments as $segment)
                                                    <div>{{ ucfirst($segment->meal) }}</div>
                                                @endforeach
                                            </td>
                                            <td>{{ number_format($airlineGroup->sale_per_adult, 2) }}</td>
                                            <td>{{ number_format($airlineGroup->sale_per_child, 2) }}</td>
                                            <td>{{ number_format($airlineGroup->sale_per_infant, 2) }}</td>

                                        </tr>
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
            function createSectionHeader(label) {
                return `<hr><h5 class="mt-4 mb-3 fw-bold">${label}</h5>`;
            }

            function createPassengerRow(index, type) {
                return `<div class="row mb-3">
                            <div class="col-md-1">
                                <label class="form-label">Sr #</label>
                                <input type="text" class="form-control" value="${index}" readonly>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Title</label>
                                <input type="text" name="passenger[${type}_${index}][title]" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Surname</label>
                                <input type="text" name="passenger[${type}_${index}][surname]" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Given Name</label>
                                <input type="text" name="passenger[${type}_${index}][given_name]" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Passport No</label>
                                <input type="text" name="passenger[${type}_${index}][passport]" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="passenger[${type}_${index}][dob]" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Passport Expiry</label>
                                <input type="date" name="passenger[${type}_${index}][passport_expiry]" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Nationality</label>
                                <input type="text" name="passenger[${type}_${index}][nationality]" class="form-control" required>
                            </div>
                        </div>`;
            }

            function addPassengerRows(adults, children, infants) {
                let rows = '';

                // Adults Section
                if (adults > 0) {
                    rows += createSectionHeader("Adult Passengers");
                    for (let i = 1; i <= adults; i++) {
                        rows += createPassengerRow(i, 'adult');
                    }
                }

                // Children Section
                if (children > 0) {
                    rows += createSectionHeader("Child Passengers");
                    for (let i = 1; i <= children; i++) {
                        rows += createPassengerRow(i, 'child');
                    }
                }

                // Infants Section
                if (infants > 0) {
                    rows += createSectionHeader("Infant Passengers");
                    for (let i = 1; i <= infants; i++) {
                        rows += createPassengerRow(i, 'infant');
                    }
                }

                $('#passenger-details').html(rows);
            }

            $('#adults, #children, #infants').on('change', function () {
                const adults = parseInt($('#adults').val()) || 0;
                const children = parseInt($('#children').val()) || 0;
                const infants = parseInt($('#infants').val()) || 0;
                addPassengerRows(adults, children, infants);
            });

            // Initial load
            addPassengerRows(
                parseInt($('#adults').val()) || 0,
                parseInt($('#children').val()) || 0,
                parseInt($('#infants').val()) || 0
            );
        });
    </script>
@endpush


</x-dashboard>
