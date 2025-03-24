<div class="modal fade" id="flightDetailModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
     data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered1 modal-simple modal-lg">
        <div class="modal-content p-0">
            <div class="border-bottom modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-start mb-0">
                    <h3 class="mb-2">Bulk Flight Details Update</h3>
                    <p class="text-muted mb-0">Update Candidates Flight Details In Bulk</p>
                </div>
            </div>
            <form method="post" action="{{ route ('upsert-flight-details') }}">
                @csrf
                <div class="modal-body pt-3">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="airline">Airline</label>
                            <select name="airline-id" class="form-control select2"
                                    data-placeholder="Select"
                                    id="airline">
                                <option></option>
                                @if(count ($airlines) > 0)
                                    @foreach($airlines as $airline)
                                        <option value="{{ $airline -> id }}"
                                                @selected(old ('airline-id') == $airline -> id)>
                                            {{ $airline -> title }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="agent">Travel Agent</label>
                            <select name="agent-id" class="form-control select2"
                                    data-placeholder="Select"
                                    id="agent">
                                <option></option>
                                @if(count ($agents) > 0)
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent -> id }}"
                                                @selected(old ('agent-id') == $agent -> id)>
                                            {{ $agent -> name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="flight-no">Flight No</label>
                            <input type="text" name="flight-no" class="form-control" required="required" id="flight-no"
                                   value="{{ old ('flight-no') }}">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="city-from">From</label>
                            <select name="city-from" class="form-control select2"
                                    data-placeholder="Select"
                                    id="city-from">
                                <option></option>
                                @if(count ($countries) > 0)
                                    @foreach($countries as $country)
                                        <optgroup label="{{ $country -> title }}">
                                            @if(count ($country -> cities) > 0)
                                                @foreach($country -> cities as $city)
                                                    <option value="{{ $city -> id }}"
                                                            @selected(old ('city-from') == $city -> id)>
                                                        {{ $city -> title }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </optgroup>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="city-to">To</label>
                            <select name="city-to" class="form-control select2"
                                    data-placeholder="Select"
                                    id="city-to">
                                <option></option>
                                @if(count ($countries) > 0)
                                    @foreach($countries as $country)
                                        <optgroup label="{{ $country -> title }}">
                                            @if(count ($country -> cities) > 0)
                                                @foreach($country -> cities as $city)
                                                    <option value="{{ $city -> id }}"
                                                            @selected(old ('city-to') == $city -> id)>
                                                        {{ $city -> title }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </optgroup>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                        <div class="col-md-4 mb-1 mb-3">
                            <label class="form-label" for="dept-date">Dept. Date</label>
                            <input type="text" class="form-control flatpickr-basic" id="dept-date"
                                   name="dept-date" value="{{ old ('dept-date') }}" />
                        </div>
                        
                        <div class="col-md-4 mb-1 mb-3">
                            <label class="form-label" for="dept-time">Dept. Time</label>
                            <input type="time" class="form-control" id="dept-time"
                                   name="dept-time" value="{{ old ('dept-time') }}" />
                        </div>
                        
                        <div class="col-md-4 mb-1 mb-3">
                            <label class="form-label" for="status">Status</label>
                            <select name="status" class="form-control select2"
                                    data-placeholder="Select"
                                    required="required"
                                    id="status">
                                <option></option>
                                <option value="confirmed" @selected(old ('status') == 'confirmed')>
                                    Confirmed
                                </option>
                                <option value="travelled" @selected(old ('status') == 'travelled')>
                                    Travelled
                                </option>
                                <option value="no-show" @selected(old ('status') == 'no-show')>
                                    No Show
                                </option>
                            </select>
                        </div>
                        
                        <div class="col-md-4 mb-1 mb-3">
                            <label class="form-label" for="one-price">Price</label>
                            <input type="number" class="form-control" id="one-price"
                                   onchange="ticketPrice(this.value)" />
                        </div>
                        
                        <div class="col-md-4 mb-1 mb-3">
                            <label class="form-label" for="pnr">PNR</label>
                            <input type="text" class="form-control" id="pnr"
                                   name="pnr" value="{{ old ('pnr') }}" />
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover table-sm table-bordered">
                                <thead class="border-top">
                                <tr>
                                    <th width="10%">#</th>
                                    <th width="20%">Name</th>
                                    <th width="20%">Father Name</th>
                                    <th width="25%">Ticket No</th>
                                    <th width="25%">Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count ($candidates) > 0)
                                    @foreach($candidates as $candidate)
                                        <tr>
                                            <td>
                                                <input type="hidden" name="candidates[]" value="{{ $candidate -> id }}">
                                                {{ $loop -> iteration }}
                                            </td>
                                            <td>{{ $candidate -> fullName() }}</td>
                                            <td>{{ $candidate -> father_name }}</td>
                                            <td>
                                                <label class="form-label w-100" for="ticket-no">
                                                    <input type="text" name="tickets[]" class="form-control"
                                                           id="ticket-no"
                                                           autofocus="autofocus"
                                                           value="{{ old ('ticket-no') }}">
                                                </label>
                                            </td>
                                            <td>
                                                <label class="form-label w-100" for="price">
                                                    <input type="number" name="price[]" min="0"
                                                           class="form-control price"
                                                           id="price">
                                                </label>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top pb-1">
                    <div class="col-12 text-start">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                        <button type="reset" class="btn btn-label-secondary btn-reset" data-bs-dismiss="modal"
                                aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>