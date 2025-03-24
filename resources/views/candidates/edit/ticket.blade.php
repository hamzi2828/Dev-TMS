<form class="pt-0" method="post"
      action="{{ $candidate -> ticket ? route ('candidates.tickets.update', ['candidate' => $candidate -> id, 'ticket' => $candidate -> ticket -> id]) : route ('candidates.tickets.store', ['candidate' => $candidate -> id]) }}"
      enctype="multipart/form-data">
    @csrf
    
    @if($candidate -> ticket)
        @method('PUT')
    @endif
    <div class="card-body pt-1 pb-1">
        @include('candidates.edit.candidate-info')
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label" for="airline">Airline</label>
                <select name="airline-id" class="form-control select2"
                        data-placeholder="Select"
                        id="airline">
                    <option></option>
                    @if(count ($airlines) > 0)
                        @foreach($airlines as $airline)
                            <option value="{{ $airline -> id }}"
                                    @selected(old ('airline-id', $candidate -> ticket ?-> airline_id) == $airline -> id)>
                                {{ $airline -> title }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="agent">Travel Agent</label>
                <select name="agent-id" class="form-control select2"
                        data-placeholder="Select"
                        id="agent">
                    <option></option>
                    @if(count ($agents) > 0)
                        @foreach($agents as $agent)
                            <option value="{{ $agent -> id }}"
                                    @selected(old ('agent-id', $candidate -> ticket ?-> agent_id) == $agent -> id)>
                                {{ $agent -> name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="ticket-no">Ticket No</label>
                <input type="text" name="ticket-no" class="form-control" id="ticket-no"
                       autofocus="autofocus"
                       value="{{ old ('ticket-no', $candidate -> ticket ?-> ticket_no) }}">
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="flight-no">Flight No</label>
                <input type="text" name="flight-no" class="form-control" id="flight-no"
                       value="{{ old ('flight-no', $candidate -> ticket ?-> flight_no) }}">
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label" for="pnr">PNR</label>
                <input type="text" name="pnr" class="form-control" id="pnr"
                       value="{{ old ('pnr', $candidate -> ticket ?-> pnr) }}">
            </div>
            
            <div class="col-md-3 mb-3">
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
                                                @selected(old ('city-from', $candidate -> ticket ?-> from_city_id) == $city -> id)>
                                            {{ $city -> title }}
                                        </option>
                                    @endforeach
                                @endif
                            </optgroup>
                        @endforeach
                    @endif
                </select>
            </div>
            
            <div class="col-md-3 mb-3">
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
                                                @selected(old ('city-to', $candidate -> ticket ?-> to_city_id) == $city -> id)>
                                            {{ $city -> title }}
                                        </option>
                                    @endforeach
                                @endif
                            </optgroup>
                        @endforeach
                    @endif
                </select>
            </div>
            
            <div class="col-md-3 mb-1">
                <label class="form-label" for="dept-date">Dept. Date</label>
                <input type="text" class="form-control flatpickr-basic" id="dept-date"
                       name="dept-date" value="{{ old ('dept-date', $candidate -> ticket ?-> dept_date) }}" />
            </div>
            
            <div class="col-md-3 mb-1">
                <label class="form-label" for="dept-time">Dept. Time</label>
                <input type="time" class="form-control" id="dept-time"
                       name="dept-time" value="{{ old ('dept-time', $candidate -> ticket ?-> dept_time) }}" />
            </div>
            
            <div class="col-md-3 mb-1">
                <label class="form-label" for="price">Ticket Price</label>
                <input type="number" class="form-control" id="price"
                       {{ ((!empty(trim ($candidate -> ticket ?-> price))) > 0 && !auth () -> user () -> is_admin()) ? 'readonly="readonly"' : '' }}
                       name="price" value="{{ old ('price', $candidate -> ticket ?-> price) }}" />
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label" for="status">
                    Status
                    <sup class="text-danger fs-5 top-0">*</sup>
                </label>
                <select name="status" class="form-control select2" data-placeholder="Select" required="required"
                        {{ ((!empty(trim ($candidate -> ticket ?-> status))) > 0 && !auth () -> user () -> is_admin()) ? 'disabled="disabled"' : '' }}
                        id="status">
                    <option></option>
                    <option value="hold" @selected(old ('hold', $candidate -> ticket ?-> status) == 'hold')>
                        Hold
                    </option>
                    <option value="confirmed" @selected(old ('status', $candidate -> ticket ?-> status) == 'confirmed')>
                        Confirmed
                    </option>
                    <option value="travelled" @selected(old ('status', $candidate -> ticket ?-> status) == 'travelled')>
                        Travelled
                    </option>
                    <option value="no-show" @selected(old ('status', $candidate -> ticket ?-> status) == 'no-show')>
                        No Show
                    </option>
                </select>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="file">Ticket Copy</label>
                    @if($candidate -> ticket && !empty(trim ($candidate -> ticket ?-> file)))
                        <div>
                            <a href="{{ $candidate -> ticket ?-> file }}"
                               download="{{ $candidate -> fullName() }} - Ticket Copy"
                               target="_blank">
                                <i class="tf-icons ti ti-download"></i>
                            </a>
                            <a href="{{ $candidate -> ticket ?-> file }}" target="_blank">
                                <i class="tf-icons ti ti-photo"></i>
                            </a>
                        </div>
                    @endif
                </div>
                <input type="file" name="file" class="form-control" id="file"
                       accept="image/*">
            </div>
        </div>
    </div>
    <div class="card-footer border-top pt-4">
        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Save</button>
        @if($candidate -> case_closed == '0')
            @can('case_closed', $candidate)
                <a href="{{ route ('candidates.close-case', ['candidate' => $candidate -> id]) }}" type="button"
                   onclick="return confirm('Are you sure?')"
                   class="btn btn-danger me-sm-3 me-1">Close Case</a>
            @endcan
        @endif
    </div>
</form>