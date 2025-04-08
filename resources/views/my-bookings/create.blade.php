<x-dashboard :title="$title">
  
    <style>
        .table:not(.table-dark) thead:not(.table-dark) th {
            color: white;
        }
    </style>
    @if(session('booking_success'))
    <!-- Booking Success Modal -->
    <div class="modal fade" id="bookingSuccessModal" tabindex="-1" aria-labelledby="bookingSuccessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4">
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="fa fa-check-circle text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="fw-bold">Booking Success</h4>
                    <p class="mt-2">
                        This is to inform you that your ticket reservation has been successfully placed 
                        <strong>ON HOLD</strong>.
                    </p>
                    <p>
                        We request you to make the payment by<br>
                        <strong>{{ session('payment_deadline') }}</strong><br>
                        to guarantee your booking.
                    </p>
                    <button class="btn btn-primary mt-3" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Auto-show modal -->
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            const modal = new bootstrap.Modal(document.getElementById('bookingSuccessModal'));
            modal.show();
        });
    </script>
    @endif
    
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
                                            <th style="max-width: 100px"> Total Seats</th>
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
                                            <input type="number" id="adults" class="form-control" name="adults" value="0" min="0" max="{{ $airlineGroup->total_seats }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Children</label>
                                            <input type="number" id="children" class="form-control" name="children" value="0" min="0" max="{{ $airlineGroup->total_seats }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Infants</label>
                                            <input type="number" id="infants" class="form-control" name="infants" value="0" min="0" max="{{ $airlineGroup->total_seats }}" required>
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
                                                    <td id="adult-seats">0</td>
                                                    <td id="adult-total">PKR 0</td>
                                                </tr>
                                                <tr>
                                                    <td>Children</td>
                                                    <td>PKR {{ number_format($airlineGroup->sale_per_child ?? 0, 0) }}</td>
                                                    <td id="child-seats">0</td>
                                                    <td id="child-total">PKR 0</td>
                                                </tr>
                                                <tr>
                                                    <td>Infants</td>
                                                    <td>PKR {{ number_format($airlineGroup->sale_per_infant ?? 0, 0) }}</td>
                                                    <td id="infant-seats">0</td>
                                                    <td id="infant-total">PKR 0</td>
                                                </tr>
                                                <tr class="fw-bold border-top">
                                                    <td colspan="2" class="text-end">Total</td>
                                                    <td id="total-seats">0</td>
                                                    <td id="grand-total">PKR 0</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <input type="hidden" id="total_price" name="total_price" value="0">
                                    </div>
                                </div>
                            </div>

                            <!-- Passenger Details Section (Dynamically Added) -->
                            <h6 class="mt-4">Passenger Details</h6>
                            <div id="passenger-details">
                                <!-- Rows will be added dynamically based on inputs above -->
                            </div>

                            <!-- Confirm Button -->

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
                                <button type="submit" class="btn btn-primary">Book Now</button>
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
                
                return `<div class="row mb-3">
                            <div class="col-md-1" style="max-width: 70px;">
                                <label class="form-label">Sr #</label>
                                <input type="text" class="form-control" value="${index}" readonly>
                            </div>
                            <div class="col-md-2" style="max-width: 150px;">
                                <label class="form-label">Title       <label class="form-label text-danger">*</label></label>
                                <select class="form-select select2" name="passenger[${type}_${index}][title]" required>
                                    ${titleOptions}
                                </select>
                            </div>
                            <div class="col-md-2" style="max-width: 200px;">
                                <label class="form-label">Surname  <label class="form-label text-danger">*</label></label>
                                <input type="text" name="passenger[${type}_${index}][surname]" class="form-control" required>
                            </div>
                            <div class="col-md-2" style="max-width: 200px;">
                                <label class="form-label">Given Name  <label class="form-label text-danger">*</label></label>
                                <input type="text" name="passenger[${type}_${index}][given_name]" class="form-control" required>
                            </div>
                            <div class="col-md-2" style="max-width: 150px;">
                                <label class="form-label">Passport No  <label class="form-label text-danger">*</label></label>
                                <input type="text" name="passenger[${type}_${index}][passport]" class="form-control" required>
                            </div>
                            <div class="col-md-2" style="max-width: 170px;">
                                <label class="form-label">Date of Birth  <label class="form-label text-danger">*</label></label>
                                <input type="date" name="passenger[${type}_${index}][dob]" class="form-control flatpickr-basic" required>
                            </div>
                            <div class="col-md-2" style="max-width: 170px;">
                                <label class="form-label">Passport Expiry  <label class="form-label text-danger">*</label></label>
                                <input type="date" name="passenger[${type}_${index}][passport_expiry]" class="form-control flatpickr-basic" required>
                            </div>
                            <div class="col-md-2" style="max-width: 170px;">
                                <label class="form-label">Nationality  <label class="form-label text-danger">*</label></label>
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
                    
                    // Reset to valid values
                    $('#adults').val(0);
                    $('#children').val(0);
                    $('#infants').val(0);
                    updatePriceSummary();
                    return false;
                }
                
                // Validate infants against adults (usually 1 infant per adult)
                // if (infants > adults) {
                //     alert('Number of infants cannot exceed number of adults. Please adjust your selection.');
                //     $('#infants').val(adults);
                //     updatePriceSummary();
                //     return false;
                // }
                
                return true;
            }
            
            function addPassengerRows(adults, children, infants) {
                if (!updatePriceSummary()) {
                    return;
                }
                
                let rows = '';
    
                if (adults > 0) {
                    rows += createSectionHeader("Adult Passengers");
                    for (let i = 1; i <= adults; i++) {
                        rows += createPassengerRow(i, 'adult');
                    }
                }
    
                if (children > 0) {
                    rows += createSectionHeader("Child Passengers");
                    for (let i = 1; i <= children; i++) {
                        rows += createPassengerRow(i, 'child');
                    }
                }
    
                if (infants > 0) {
                    rows += createSectionHeader("Infant Passengers");
                    for (let i = 1; i <= infants; i++) {
                        rows += createPassengerRow(i, 'infant');
                    }
                }
    
                $('#passenger-details').html(rows);
    
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
    
            $('#adults, #children, #infants').on('change', function () {
                const adults = parseInt($('#adults').val()) || 0;
                const children = parseInt($('#children').val()) || 0;
                const infants = parseInt($('#infants').val()) || 0;
                addPassengerRows(adults, children, infants);
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
                
                return true;
            });
    
            // Initial load
            updatePriceSummary();
            addPassengerRows(
                parseInt($('#adults').val()) || 0,
                parseInt($('#children').val()) || 0,
                parseInt($('#infants').val()) || 0
            );
        });
    </script>
    @endpush
</x-dashboard>