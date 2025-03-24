<option></option>
@if(count ($country -> cities) > 0)
    @foreach($country -> cities as $city)
        <option value="{{ $city -> id }}" @selected(old ('city-id') == $city -> id)>
            {{ $city -> title }}
        </option>
    @endforeach
@endif