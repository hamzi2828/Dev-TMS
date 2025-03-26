<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectionFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'airline_id' => 'required|exists:airlines,id',
            'origin_city_id' => 'required|exists:cities,id',
            'destination_city_id' => 'required|exists:cities,id|different:origin_city_id',
            'trip_type' => 'nullable|in:oneway,roundtrip',
            'title' => 'nullable|string|max:255',
            'status' => 'nullable|boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'origin_city_id.required' => 'Origin city is required',
            'origin_city_id.exists' => 'Selected origin city is invalid',
            'destination_city_id.required' => 'Destination city is required',
            'destination_city_id.exists' => 'Selected destination city is invalid',
            'destination_city_id.different' => 'Origin and destination cities must be different',
            'airline_id.required' => 'Airline is required',
            'airline_id.exists' => 'Selected airline is invalid',
            'trip_type.required' => 'Trip type is required',
            'trip_type.in' => 'Invalid trip type selected'
        ];
    }
}
