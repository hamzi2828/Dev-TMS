<div class="card mb-3">
    <div class="card-header border-bottom pt-3 pb-3">
        <h5 class="card-title mb-0">Search</h5>
    </div>
    <div class="card-body mt-3">
        <form method="GET" action="{{ request()->routeIs('myBookings.pending') ? route('myBookings.pending') : route('myBookings.index') }}" class="mb-3">
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
                <div class="col-md-3">
                    <label for="origin">Origin</label>
                    <select name="origin" id="origin" class="form-control select2" data-allow-clear="true">>
                        <option value="">All Origins</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ request('origin') == $city->id ? 'selected' : '' }}>{{ $city->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="destination">Destination</label>
                    <select name="destination" id="destination" class="form-control select2" data-allow-clear="true">>
                        <option value="">All Destinations</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ request('destination') == $city->id ? 'selected' : '' }}>{{ $city->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mt-3">
                    <label class="form-label" for="trip_type">Trip Type</label>
                    <select class="form-select select2" id="trip_type" name="trip_type"  data-allow-clear="true" >
                        <option value="">Select Trip Type</option>
                        <option value="oneway" {{ request('trip_type') == 'oneway' ? 'selected' : '' }}>One Way</option>
                        <option value="roundtrip" {{ request('trip_type') == 'roundtrip' ? 'selected' : '' }}>Round Trip</option>
                    </select>
                </div>

                <div class="col-md-3 mt-3">
                    <button type="submit" class="btn btn-primary" style="margin-top: 22px;">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>