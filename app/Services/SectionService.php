<?php

namespace App\Services;

use App\Models\Section;
use App\Models\Airline;
use App\Models\City;
use App\Services\LogService;
use Illuminate\Support\Str;

class SectionService
{
    public function all()
    {
        return Section::latest()->get();
    }

    public function save($request)
    {
       ;
        $section = Section::create([
            'user_id' => auth()->user()->id,
            'route_type' => $request->input('route_type'),
            'title' => $request->input('title'),
            'origin_city_id' => $request->input('origin_city_id'),
            'destination_city_id' => $request->input('destination_city_id'),
            'trip_type' => $request->input('trip_type'),
            'status' => true
        ]);

        (new LogService())->log('section-created', $section);
        return $section;
    }

    public function edit($request, $section): void
    {
        $section->status = $request->boolean('status', true);
        $section->route_type = $request->input('route_type');
        $section->title = $request->input('title');
        $section->origin_city_id = $request->input('origin_city_id');
        $section->destination_city_id = $request->input('destination_city_id');
        $section->trip_type = $request->input('trip_type');
        
        $section->update();
        (new LogService())->log('section-updated', $section);
    }

}