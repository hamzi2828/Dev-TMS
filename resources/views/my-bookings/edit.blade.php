<x-dashboard :title="$title">

    <style>
        .table:not(.table-dark) thead:not(.table-dark) th {
            color: white;
        }
    </style>

    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header border-bottom pt-3 pb-2 mb-3">{{ $title }} - Ref: {{ $booking->booking_reference }}</h5>
                    <form class="pt-0" method="post" action="{{ route('myBookings.update', $booking->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body pt-1 pb-1">
                            <!-- Booking Status Information -->
                            <div class="alert alert-info mb-3">
                                <strong>Current Status:</strong> {{ ucfirst($booking->status) }}
                            </div>

                            <!-- Flight and Sector Information -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Airline</label>
                                    <input type="text" class="form-control" value="{{ $airlineGroup->airline->title ?? '' }}" readonly>
                                    <input type="hidden" name="airline_id" value="{{ $airlineGroup->airline_id ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
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
                                    <thead style="background-color: #636363;">
                                        <tr>
                                            <th style="min-width: 150px">Dep. Date</th>
                                            <th>Airline</th>
                                            <th style="min-width: 70px">Flight</th>
                                            <th>Origin</th>
                                            <th>Destination</th>
                                            <th>Dep. Time</th>
                                            <th style="max-width: 120px"> Arrival Time</th>
                                            <th>Baggage</th>
                                            <th>Meal</th>
                                            <th style="max-width: 100px"> Available Seats</th>
                                            <th style="max-width: 100px">Price Adult</th>
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
                                                    <div>{{ \Carbon\Carbon::parse($segment->departure_time)->format('H:i') }}</div>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($airlineGroup->segments as $segment)
                                                    <div>{{ \Carbon\Carbon::parse($segment->arrival_time)->format('H:i')  }}</div>
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
                                            <td>{{ $airlineGroup->total_seats }}</td>
                                            <td>{{ number_format($airlineGroup->sale_per_adult, 2) }}</td>
                                            <td>{{ number_format($airlineGroup->sale_per_child, 2) }}</td>
                                            <td>{{ number_format($airlineGroup->sale_per_infant, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Passengers & Price Summary Section -->
                            <h6 class="mt-4">Passengers</h6>
                            <div class="row">
                                <!-- Left Side: Passenger Inputs -->
                                <div class="col-md-6">
                                    <div class="card p-3 h-100">
                                        <h6 class="fw-bold border-bottom pb-2">Passengers</h6>
                                        <div class="mb-3">
                                            <label class="form-label">Adults</label>
                                            <input type="number" id="adults" class="form-control" name="adults" value="{{ $booking->adults }}" min="0" max="{{ $airlineGroup->total_seats }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Children</label>
                                            <input type="number" id="children" class="form-control" name="children" value="{{ $booking->children }}" min="0" max="{{ $airlineGroup->total_seats }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Infants</label>
                                            <input type="number" id="infants" class="form-control" name="infants" value="{{ $booking->infants }}" min="0" max="{{ $airlineGroup->total_seats }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Side: Price Summary -->
                                <div class="col-md-6">
                                    <div class="card p-3 h-100">
                                        <h6 class="fw-bold border-bottom pb-2">Price</h6>
                                        <table class="table table-bordered mb-0 text-center">
                                            <thead style="background-color: #636363;">
                                                <tr>
                                                    <th style="width: 30%">Type</th>
                                                    <th>Price</th>
                                                    <th>Seats</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Adult</td>
                                                    <td>PKR {{ number_format($airlineGroup->sale_per_adult ?? 0, 0) }}</td>
                                                    <td id="adult-seats">{{ $booking->adults }}</td>
                                                    <td id="adult-total">PKR {{ number_format($booking->adults * $airlineGroup->sale_per_adult, 0) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Children</td>
                                                    <td>PKR {{ number_format($airlineGroup->sale_per_child ?? 0, 0) }}</td>
                                                    <td id="child-seats">{{ $booking->children }}</td>
                                                    <td id="child-total">PKR {{ number_format($booking->children * $airlineGroup->sale_per_child, 0) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Infants</td>
                                                    <td>PKR {{ number_format($airlineGroup->sale_per_infant ?? 0, 0) }}</td>
                                                    <td id="infant-seats">{{ $booking->infants }}</td>
                                                    <td id="infant-total">PKR {{ number_format($booking->infants * $airlineGroup->sale_per_infant, 0) }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-end">Discount</td>
                                                    <td>
                                                        <input type="number"
                                                               id="discount"
                                                               name="discount"
                                                               value="{{ $booking->discount ?? 0 }}"
                                                               class="form-control"
                                                               min="0"
                                                               step="1"
                                                               onchange="updateTotalPrice()"
                                                               oninput="this.value = Math.min(parseInt(this.value) || 0, parseFloat(document.getElementById('total_price').value) || 0)">
                                                        <small class="text-danger d-none" id="discount-error">Discount cannot exceed total price</small>
                                                    </td>
                                                </tr>
                                                <tr class="fw-bold border-top">
                                                    <td colspan="2" class="text-end">Total</td>
                                                    <td id="total-seats">{{ $booking->adults + $booking->children + $booking->infants }}</td>
                                                    <td id="grand-total">PKR <span id="total-price-span">{{ number_format($booking->total_price - ($booking->discount ?? 0), 2) }}</span></td>
                                                </tr>

                                                <script>
                                                    function updateTotalPrice() {
                                                        const discountInput = document.getElementById('discount');
                                                        const discountError = document.getElementById('discount-error');
                                                        const totalPrice = parseFloat(document.getElementById('total_price').value) || 0;
                                                        let discount = parseInt(discountInput.value) || 0;

                                                        // Ensure discount doesn't exceed total price
                                                        if (discount > totalPrice) {
                                                            discount = totalPrice;
                                                            discountInput.value = totalPrice;
                                                            discountError.classList.remove('d-none');
                                                        } else {
                                                            discountError.classList.add('d-none');
                                                        }

                                                        const newTotalPrice = Math.max(0, (totalPrice - discount)).toFixed(2);
                                                        document.getElementById('grand-total').innerHTML = `PKR ${newTotalPrice.replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
                                                        document.getElementById('total-price-span').textContent = newTotalPrice;
                                                    }
                                                </script>
                                            </tbody>
                                        </table>
                                        <input type="hidden" id="total_price" name="total_price" value="{{ $booking->total_price }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Passenger Details Section -->
                            <h6 class="mt-4">Passenger Details</h6>
                            <div id="passenger-details">
                                <!-- Adult Passengers -->
                                @if($booking->passengers->where('passenger_type', 'adult')->count() > 0)
                                    <hr><h5 class="mt-4 mb-3 fw-bold">Adult Passengers</h5>
                                    @foreach($booking->passengers->where('passenger_type', 'adult') as $index => $passenger)
                                        <div class="row mb-3">
                                            <div class="col-md-1" style="max-width: 70px;">
                                                <label class="form-label">Sr #</label>
                                                <input type="text" class="form-control" value="{{ $index + 1 }}" readonly>
                                            </div>
                                            <div class="col-md-2" style="max-width: 150px;">
                                                <label class="form-label">Title <label class="form-label text-danger">*</label></label>
                                                <select class="form-select select2" name="passenger[adult_{{ $index + 1 }}][title]" required>
                                                    <option value="">Select</option>
                                                    <option value="Mr." {{ $passenger->title == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                                                    <option value="Mrs." {{ $passenger->title == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                                                    <option value="Ms." {{ $passenger->title == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2" style="max-width: 200px;">
                                                <label class="form-label">Surname <label class="form-label text-danger">*</label></label>
                                                <input type="text" name="passenger[adult_{{ $index + 1 }}][surname]" class="form-control" value="{{ $passenger->surname }}" required>
                                            </div>
                                            <div class="col-md-2" style="max-width: 200px;">
                                                <label class="form-label">Given Name <label class="form-label text-danger">*</label></label>
                                                <input type="text" name="passenger[adult_{{ $index + 1 }}][given_name]" class="form-control" value="{{ $passenger->given_name }}" required>
                                            </div>
                                            <div class="col-md-2" style="max-width: 150px;">
                                                <label class="form-label">Passport No <label class="form-label text-danger">*</label></label>
                                                <input type="text" name="passenger[adult_{{ $index + 1 }}][passport]" class="form-control" value="{{ $passenger->passport }}" required>
                                            </div>
                                            <div class="col-md-2" style="max-width: 170px;">
                                                <label class="form-label">Date of Birth <label class="form-label text-danger">*</label></label>
                                                <input type="date" name="passenger[adult_{{ $index + 1 }}][dob]" class="form-control flatpickr-basic" value="{{ $passenger->dob }}" required>
                                            </div>
                                            <div class="col-md-2" style="max-width: 170px;">
                                                <label class="form-label">Passport Expiry <label class="form-label text-danger">*</label></label>
                                                <input type="date" name="passenger[adult_{{ $index + 1 }}][passport_expiry]" class="form-control flatpickr-basic" value="{{ $passenger->passport_expiry }}" required>
                                            </div>
                                            <div class="col-md-2" style="max-width: 170px;">
                                                <label class="form-label">Nationality <label class="form-label text-danger">*</label></label>
                                                <select class="form-select select2" name="passenger[adult_{{ $index + 1 }}][nationality]" required>
                                                    <option value="">Select</option>
                                                    <option value="Pakistani" {{ $passenger->nationality == 'Pakistani' ? 'selected' : '' }}>Pakistani</option>
                                                    <option value="British" {{ $passenger->nationality == 'British' ? 'selected' : '' }}>British</option>
                                                    <option value="American" {{ $passenger->nationality == 'American' ? 'selected' : '' }}>American</option>
                                                    <option value="Indian" {{ $passenger->nationality == 'Indian' ? 'selected' : '' }}>Indian</option>
                                                    <option value="Chinese" {{ $passenger->nationality == 'Chinese' ? 'selected' : '' }}>Chinese</option>
                                                    <option value="Saudi" {{ $passenger->nationality == 'Saudi' ? 'selected' : '' }}>Saudi</option>
                                                    <option value="UAE" {{ $passenger->nationality == 'UAE' ? 'selected' : '' }}>UAE</option>
                                                </select>
                                            </div>
                                            <input type="hidden" name="passenger[adult_{{ $index + 1 }}][id]" value="{{ $passenger->id }}">
                                        </div>
                                    @endforeach
                                @endif

                                <!-- Child Passengers -->
                                @if($booking->passengers->where('passenger_type', 'child')->count() > 0)
                                    <hr><h5 class="mt-4 mb-3 fw-bold">Child Passengers</h5>
                                    @foreach($booking->passengers->where('passenger_type', 'child') as $index => $passenger)
                                        <div class="row mb-3">
                                            <div class="col-md-1" style="max-width: 70px;">
                                                <label class="form-label">Sr #</label>
                                                <input type="text" class="form-control" value="{{ $index + 1 }}" readonly>
                                            </div>
                                            <div class="col-md-2" style="max-width: 150px;">
                                                <label class="form-label">Title <label class="form-label text-danger">*</label></label>
                                                <select class="form-select select2" name="passenger[child_{{ $index + 1 }}][title]" required>
                                                    <option value="">Select</option>
                                                    <option value="Mr." {{ $passenger->title == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                                                    <option value="Mrs." {{ $passenger->title == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                                                    <option value="Ms." {{ $passenger->title == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2" style="max-width: 200px;">
                                                <label class="form-label">Surname <label class="form-label text-danger">*</label></label>
                                                <input type="text" name="passenger[child_{{ $index + 1 }}][surname]" class="form-control" value="{{ $passenger->surname }}" required>
                                            </div>
                                            <div class="col-md-2" style="max-width: 200px;">
                                                <label class="form-label">Given Name <label class="form-label text-danger">*</label></label>
                                                <input type="text" name="passenger[child_{{ $index + 1 }}][given_name]" class="form-control" value="{{ $passenger->given_name }}" required>
                                            </div>
                                            <div class="col-md-2" style="max-width: 150px;">
                                                <label class="form-label">Passport No <label class="form-label text-danger">*</label></label>
                                                <input type="text" name="passenger[child_{{ $index + 1 }}][passport]" class="form-control" value="{{ $passenger->passport }}" required>
                                            </div>
                                            <div class="col-md-2" style="max-width: 170px;">
                                                <label class="form-label">Date of Birth <label class="form-label text-danger">*</label></label>
                                                <input type="date" name="passenger[child_{{ $index + 1 }}][dob]" class="form-control flatpickr-basic" value="{{ $passenger->dob }}" required>
                                            </div>
                                            <div class="col-md-2" style="max-width: 170px;">
                                                <label class="form-label">Passport Expiry <label class="form-label text-danger">*</label></label>
                                                <input type="date" name="passenger[child_{{ $index + 1 }}][passport_expiry]" class="form-control flatpickr-basic" value="{{ $passenger->passport_expiry }}" required>
                                            </div>
                                            <div class="col-md-2" style="max-width: 170px;">
                                                <label class="form-label">Nationality <label class="form-label text-danger">*</label></label>
                                                <select class="form-select select2" name="passenger[child_{{ $index + 1 }}][nationality]" required>
                                                    <option value="">Select</option>
                                                    <option value="Pakistani" {{ $passenger->nationality == 'Pakistani' ? 'selected' : '' }}>Pakistani</option>
                                                    <option value="British" {{ $passenger->nationality == 'British' ? 'selected' : '' }}>British</option>
                                                    <option value="American" {{ $passenger->nationality == 'American' ? 'selected' : '' }}>American</option>
                                                    <option value="Indian" {{ $passenger->nationality == 'Indian' ? 'selected' : '' }}>Indian</option>
                                                    <option value="Chinese" {{ $passenger->nationality == 'Chinese' ? 'selected' : '' }}>Chinese</option>
                                                    <option value="Saudi" {{ $passenger->nationality == 'Saudi' ? 'selected' : '' }}>Saudi</option>
                                                    <option value="UAE" {{ $passenger->nationality == 'UAE' ? 'selected' : '' }}>UAE</option>
                                                </select>
                                            </div>
                                            <input type="hidden" name="passenger[child_{{ $index + 1 }}][id]" value="{{ $passenger->id }}">
                                        </div>
                                    @endforeach
                                @endif

                                <!-- Infant Passengers -->
                                @if($booking->passengers->where('passenger_type', 'infant')->count() > 0)
                                    <hr><h5 class="mt-4 mb-3 fw-bold">Infant Passengers</h5>
                                    @foreach($booking->passengers->where('passenger_type', 'infant') as $index => $passenger)
                                        <div class="row mb-3">
                                            <div class="col-md-1" style="max-width: 70px;">
                                                <label class="form-label">Sr #</label>
                                                <input type="text" class="form-control" value="{{ $index + 1 }}" readonly>
                                            </div>
                                            <div class="col-md-2" style="max-width: 150px;">
                                                <label class="form-label">Title <label class="form-label text-danger">*</label></label>
                                                <select class="form-select select2" name="passenger[infant_{{ $index + 1 }}][title]" required>
                                                    <option value="">Select</option>
                                                    <option value="Master" {{ $passenger->title == 'Master' ? 'selected' : '' }}>Master</option>
                                                    <option value="Miss" {{ $passenger->title == 'Miss' ? 'selected' : '' }}>Miss</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2" style="max-width: 200px;">
                                                <label class="form-label">Surname <label class="form-label text-danger">*</label></label>
                                                <input type="text" name="passenger[infant_{{ $index + 1 }}][surname]" class="form-control" value="{{ $passenger->surname }}" required>
                                            </div>
                                            <div class="col-md-2" style="max-width: 200px;">
                                                <label class="form-label">Given Name <label class="form-label text-danger">*</label></label>
                                                <input type="text" name="passenger[infant_{{ $index + 1 }}][given_name]" class="form-control" value="{{ $passenger->given_name }}" required>
                                            </div>
                                            <div class="col-md-2" style="max-width: 150px;">
                                                <label class="form-label">Passport No <label class="form-label text-danger">*</label></label>
                                                <input type="text" name="passenger[infant_{{ $index + 1 }}][passport]" class="form-control" value="{{ $passenger->passport }}" required>
                                            </div>
                                            <div class="col-md-2" style="max-width: 170px;">
                                                <label class="form-label">Date of Birth <label class="form-label text-danger">*</label></label>
                                                <input type="date" name="passenger[infant_{{ $index + 1 }}][dob]" class="form-control flatpickr-basic" value="{{ $passenger->dob }}" required>
                                            </div>
                                            <div class="col-md-2" style="max-width: 170px;">
                                                <label class="form-label">Passport Expiry <label class="form-label text-danger">*</label></label>
                                                <input type="date" name="passenger[infant_{{ $index + 1 }}][passport_expiry]" class="form-control flatpickr-basic" value="{{ $passenger->passport_expiry }}" required>
                                            </div>
                                            <div class="col-md-2" style="max-width: 170px;">
                                                <label class="form-label">Nationality <label class="form-label text-danger">*</label></label>
                                                <select class="form-select select2" name="passenger[infant_{{ $index + 1 }}][nationality]" required>
                                                    <option value="">Select</option>
                                                    <option value="Pakistani" {{ $passenger->nationality == 'Pakistani' ? 'selected' : '' }}>Pakistani</option>
                                                    <option value="British" {{ $passenger->nationality == 'British' ? 'selected' : '' }}>British</option>
                                                    <option value="American" {{ $passenger->nationality == 'American' ? 'selected' : '' }}>American</option>
                                                    <option value="Indian" {{ $passenger->nationality == 'Indian' ? 'selected' : '' }}>Indian</option>
                                                    <option value="Chinese" {{ $passenger->nationality == 'Chinese' ? 'selected' : '' }}>Chinese</option>
                                                    <option value="Saudi" {{ $passenger->nationality == 'Saudi' ? 'selected' : '' }}>Saudi</option>
                                                    <option value="UAE" {{ $passenger->nationality == 'UAE' ? 'selected' : '' }}>UAE</option>
                                                </select>
                                            </div>
                                            <input type="hidden" name="passenger[infant_{{ $index + 1 }}][id]" value="{{ $passenger->id }}">
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <!-- Dynamic Passenger Form Section (for adding/removing passengers) -->
                            <div id="dynamic-passenger-form"></div>

                            <!-- Terms and Update Button -->
                            <div class="col-md-8 mt-5">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="1" id="terms_and_conditions" name="terms_and_conditions" required style="box-shadow: 0 0 5px red;">
                                    <label class="form-check-label" for="terms_and_conditions" style="color:red; font-size: 1.2rem;">
                                        &nbsp;I hereby confirm that all the information provided is accurate and complete
                                    </label>
                                </div>
                            </div>

                            <div class="text-end mb-3 mt-5">
                                <input type="hidden" name="airline_group_id" value="{{ $airlineGroup->id ?? '' }}">
                                <a href="{{ route('myBookings.index') }}" class="btn btn-secondary me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Booking</button>
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
            // Store the original prices
            const adultPrice = {{ $airlineGroup->sale_per_adult ?? 0 }};
            const childPrice = {{ $airlineGroup->sale_per_child ?? 0 }};
            const infantPrice = {{ $airlineGroup->sale_per_infant ?? 0 }};
            const totalSeatsAvailable = {{ $airlineGroup->total_seats ?? 0 }};

            // Initialize select2 and flatpickr
            $('.select2').select2({
                width: '100%'
            });

            $('.flatpickr-basic').flatpickr({
                dateFormat: 'Y-m-d',
                allowInput: true
            });

            function formatCurrency(amount) {
                return new Intl.NumberFormat('en-PK', {
                    style: 'currency',
                    currency: 'PKR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(amount).replace('PKR', 'PKR ');
            }

            function createSectionHeader(label) {
                return `<hr><h5 class="mt-4 mb-3 fw-bold">${label}</h5>`;
            }

            function createPassengerRow(index, type) {
                const titleOptions = type === 'infant' ?
                    `<option value="">Select</option>
                     <option value="Master">Master</option>
                     <option value="Miss">Miss</option>` :
                    `<option value="">Select</option>
                     <option value="Mr.">Mr.</option>
                     <option value="Mrs.">Mrs.</option>
                     <option value="Ms.">Ms.</option>`;

                return `<div class="row mb-3 new-passenger-row" data-type="${type}" data-index="${index}">
                            <div class="col-md-1" style="max-width: 70px;">
                                <label class="form-label">Sr #</label>
                                <input type="text" class="form-control" value="${index}" readonly>
                            </div>
                            <div class="col-md-2" style="max-width: 150px;">
                                <label class="form-label">Title <label class="form-label text-danger">*</label></label>
                                <select class="form-select select2" name="passenger[${type}_${index}][title]" required>
                                    ${titleOptions}
                                </select>
                            </div>
                            <div class="col-md-2" style="max-width: 200px;">
                                <label class="form-label">Surname <label class="form-label text-danger">*</label></label>
                                <input type="text" name="passenger[${type}_${index}][surname]" class="form-control" required>
                            </div>
                            <div class="col-md-2" style="max-width: 200px;">
                                <label class="form-label">Given Name <label class="form-label text-danger">*</label></label>
                                <input type="text" name="passenger[${type}_${index}][given_name]" class="form-control" required>
                            </div>
                            <div class="col-md-2" style="max-width: 150px;">
                                <label class="form-label">Passport No <label class="form-label text-danger">*</label></label>
                                <input type="text" name="passenger[${type}_${index}][passport]" class="form-control" required>
                            </div>
                            <div class="col-md-2" style="max-width: 170px;">
                                <label class="form-label">Date of Birth <label class="form-label text-danger">*</label></label>
                                <input type="date" name="passenger[${type}_${index}][dob]" class="form-control flatpickr-basic" required>
                            </div>
                            <div class="col-md-2" style="max-width: 170px;">
                                <label class="form-label">Passport Expiry <label class="form-label text-danger">*</label></label>
                                <input type="date" name="passenger[${type}_${index}][passport_expiry]" class="form-control flatpickr-basic" required>
                            </div>
                            <div class="col-md-2" style="max-width: 170px;">
                                <label class="form-label">Nationality <label class="form-label text-danger">*</label></label>
                                <select class="form-select select2" name="passenger[${type}_${index}][nationality]" required>
                                    <option value="">Select</option>
                                    <option value="Pakistani" selected>Pakistani</option>
                                    <option value="British">British</option>
                                    <option value="American">American</option>
                                    <option value="Indian">Indian</option>
                                    <option value="Chinese">Chinese</option>
                                    <option value="Saudi">Saudi</option>
                                    <option value="UAE">UAE</option>
                                </select>
                            </div>
                        </div>`;
            }

            function updatePriceSummary() {
                const adults = parseInt($('#adults').val()) || 0;
                const children = parseInt($('#children').val()) || 0;
                const infants = parseInt($('#infants').val()) || 0;

                // Update seat counts
                $('#adult-seats').text(adults);
                $('#child-seats').text(children);
                $('#infant-seats').text(infants);
                $('#total-seats').text(adults + children + infants);

                // Calculate and update totals
                const adultTotal = adults * adultPrice;
                const childTotal = children * childPrice;
                const infantTotal = infants * infantPrice;
                const grandTotal = adultTotal + childTotal + infantTotal;

                $('#adult-total').text(formatCurrency(adultTotal));
                $('#child-total').text(formatCurrency(childTotal));
                $('#infant-total').text(formatCurrency(infantTotal));
                $('#grand-total').text(formatCurrency(grandTotal));
                $('#total_price').val(grandTotal);

                // Validate total passengers against available seats
                const totalPassengers = adults + children + infants;
                if (totalPassengers > totalSeatsAvailable) {
                    alert(`You can only book up to ${totalSeatsAvailable} seats. Please adjust your selection.`);

                    // Reset to the original values
                    $('#adults').val({{ $booking->adults }});
                    $('#children').val({{ $booking->children }});
                    $('#infants').val({{ $booking->infants }});
                    updatePriceSummary();
                    return false;
                }

                // Validate infants against adults (usually 1 infant per adult)
                if (infants > adults) {
                    alert('Number of infants cannot exceed number of adults. Please adjust your selection.');
                    $('#infants').val(adults);
                    updatePriceSummary();
                    return false;
                }

                return true;
            }

            function handlePassengerChanges() {
                // Get current and new counts
                const currentAdults = {{ $booking->passengers->where('passenger_type', 'adult')->count() }};
                const currentChildren = {{ $booking->passengers->where('passenger_type', 'child')->count() }};
                const currentInfants = {{ $booking->passengers->where('passenger_type', 'infant')->count() }};

                const newAdults = parseInt($('#adults').val()) || 0;
                const newChildren = parseInt($('#children').val()) || 0;
                const newInfants = parseInt($('#infants').val()) || 0;

                // Clear previous dynamic form elements
                $('#dynamic-passenger-form').empty();

                // Handle additions
                let formContent = '';

                // Add new adult passengers
                if (newAdults > currentAdults) {
                    formContent += createSectionHeader("New Adult Passengers");
                    for (let i = currentAdults + 1; i <= newAdults; i++) {
                        formContent += createPassengerRow(i, 'adult');
                    }
                }

                // Add new child passengers
                if (newChildren > currentChildren) {
                    formContent += createSectionHeader("New Child Passengers");
                    for (let i = currentChildren + 1; i <= newChildren; i++) {
                        formContent += createPassengerRow(i, 'child');
                    }
                }

                // Add new infant passengers
                if (newInfants > currentInfants) {
                    formContent += createSectionHeader("New Infant Passengers");
                    for (let i = currentInfants + 1; i <= newInfants; i++) {
                        formContent += createPassengerRow(i, 'infant');
                    }
                }

                // Add warning for removed passengers
                if (newAdults < currentAdults || newChildren < currentChildren || newInfants < currentInfants) {
                    formContent += `
                    <div class="alert alert-warning mt-4">
                        <h6 class="fw-bold">Warning: Passenger Removal</h6>
                        <p>You have reduced the number of passengers. The following passengers will be removed upon saving:</p>
                        <ul>`;

                    if (newAdults < currentAdults) {
                        formContent += `<li>Adults: ${currentAdults - newAdults} passenger(s) will be removed</li>`;
                    }
                    if (newChildren < currentChildren) {
                        formContent += `<li>Children: ${currentChildren - newChildren} passenger(s) will be removed</li>`;
                    }
                    if (newInfants < currentInfants) {
                        formContent += `<li>Infants: ${currentInfants - newInfants} passenger(s) will be removed</li>`;
                    }

                    formContent += `
                        </ul>
                        <p>If this is not intended, please adjust the passenger counts.</p>
                    </div>`;
                }

                // Update the form
                $('#dynamic-passenger-form').html(formContent);

                // Re-initialize select2 after DOM update
                $('.select2').select2({
                    width: '100%'
                });

                // Initialize flatpickr for date inputs
                $('.flatpickr-basic').flatpickr({
                    dateFormat: 'Y-m-d',
                    allowInput: true
                });
            }

            // Update price summary and passenger form when passenger counts change
            $('#adults, #children, #infants').on('change', function () {
                if (updatePriceSummary()) {
                    handlePassengerChanges();
                }
            });

            // Form validation before submission
            $('form').on('submit', function(e) {
                const adults = parseInt($('#adults').val()) || 0;
                const children = parseInt($('#children').val()) || 0;
                const infants = parseInt($('#infants').val()) || 0;
                const totalPassengers = adults + children + infants;

                if (totalPassengers === 0) {
                    e.preventDefault();
                    alert('Please select at least one passenger.');
                    return false;
                }

                if (totalPassengers > totalSeatsAvailable) {
                    e.preventDefault();
                    alert(`You can only book up to ${totalSeatsAvailable} seats. Please adjust your selection.`);
                    return false;
                }

                if (infants > adults) {
                    e.preventDefault();
                    alert('Number of infants cannot exceed number of adults.');
                    return false;
                }

                if (!$('#terms_and_conditions').is(':checked')) {
                    e.preventDefault();
                    alert('Please confirm that all information is accurate and complete.');
                    return false;
                }

                // Confirm submission if passengers are being removed
                const currentAdults = {{ $booking->passengers->where('passenger_type', 'adult')->count() }};
                const currentChildren = {{ $booking->passengers->where('passenger_type', 'child')->count() }};
                const currentInfants = {{ $booking->passengers->where('passenger_type', 'infant')->count() }};

                if (adults < currentAdults || children < currentChildren || infants < currentInfants) {
                    if (!confirm('You are about to remove some passengers. Are you sure you want to continue?')) {
                        e.preventDefault();
                        return false;
                    }
                }

                return true;
            });

            // Initialize price summary on page load
            updatePriceSummary();
        });
    </script>
    @endpush
</x-dashboard>
