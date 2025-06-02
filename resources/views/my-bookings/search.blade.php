<div class="card mb-3">
    <div class="card-header border-bottom pt-3 pb-3 d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Search</h5>
        <span class="d-flex align-items-center">
            <p class="mb-0 me-5">Credit Limit: {{ $credit_limit }}</p>
            <p class="mb-0 ">Remaining Credit: {{ $credit_limit  - $used_credit }}</p>
        </span>
    </div>
    <div class="card-body mt-3">
        <form method="GET" action="{{ $action }}"  class="mb-3">
            <div class="row">

                <div class="col-md-3">
                    <label for="departure_date">Departure Date</label>
                    <input type="date" name="departure_date" id="departure_date" class="form-control flatpickr-basic" value="{{ request('departure_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="airline">Airline</label>
                    <select name="airline" id="airline" class="form-control select2" data-allow-clear="true">>
                        <option value="">All Airlines</option>
                        @foreach($airlines as $airline)
                            <option value="{{ $airline->id }}" {{ request('airline') == $airline->id ? 'selected' : '' }}>{{ $airline->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 ">
                    <label for="origin">Origin</label>
                    <select name="origin" id="origin" class="form-control select2" data-allow-clear="true">>
                        <option value="">All Origins</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ request('origin') == $city->id ? 'selected' : '' }}>{{ $city->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 ">
                    <label for="destination">Destination</label>
                    <select name="destination" id="destination" class="form-control select2" data-allow-clear="true">>
                        <option value="">All Destinations</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ request('destination') == $city->id ? 'selected' : '' }}>{{ $city->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mt-3">
                    <label for="booking_reference">Booking Reference</label>
                    <input type="text" name="booking_reference" id="booking_reference" class="form-control" value="{{ request('booking_reference') }}">
                </div>
                <div class="col-md-3 mt-3">
                    <label for="tavel_agent">Tavel Agent</label>
                    <select name="tavel_agent" id="tavel_agent" class="form-control select2" data-allow-clear="true">>
                        <option value="">All Tavel Agents</option>
                        @foreach($tavel_agents as $tavel_agent)
                            <option value="{{ $tavel_agent->id }}" {{ request('tavel_agent') == $tavel_agent->id ? 'selected' : '' }}>{{ $tavel_agent->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mt-3 ">
                    <label class="form-label" for="trip_type">Trip Type</label>
                    <select class="form-select select2" id="trip_type" name="trip_type"  data-allow-clear="true" >
                        <option value="">Select Trip Type</option>
                        <option value="oneway" {{ request('trip_type') == 'oneway' ? 'selected' : '' }}>One Way</option>
                        <option value="roundtrip" {{ request('trip_type') == 'roundtrip' ? 'selected' : '' }}>Round Trip</option>
                    </select>
                </div>
                @if (request()->routeIs('myBookings.completed'))
                <div class="col-md-3 mt-3">
                    <label for="start_date">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control flatpickr-basic" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3 mt-3">
                    <label for="end_date">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control flatpickr-basic" value="{{ request('end_date') }}">
                </div>
                 @endif
                <div class="col-md-3 mt-3">
                    <button type="submit" class="btn btn-primary" style="margin-top: 22px;">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>
