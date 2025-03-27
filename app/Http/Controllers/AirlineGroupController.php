<?php

namespace App\Http\Controllers;
use App\Http\Requests\AirlineGroupFormRequest;
use App\Services\AirlineGroupService;
use App\Services\AirlineService;
use App\Services\SectionService;
use App\Services\CityService;
use App\Models\AirlineGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class AirlineGroupController extends Controller
{
    public function index()
    {
        $airlineGroups = AirlineGroup::with(['segments', 'airline'])->get();
        
        $data['title'] = 'Airline Groups';
        $data['airlineGroups'] = $airlineGroups;
    
        return view('airline-groups.index', $data);
    }
    

    public function create()
    {
        $data['title'] = 'Add Airline Group';
        $data['airlines'] = (new AirlineService())->all();
        $data['cities'] = (new CityService())->all();
        $data['sectors'] = (new SectionService())->all(); // 
        return view('airline-groups.create', $data);
    }
    

    public function store(Request $request)
    {

        try {
            $validated = $request->validate([
                'airline_id' => 'required|exists:airlines,id',
                'sector_id' => 'required|exists:sections,id',
                'segments' => 'required|array',
                'segments.*.departure_date' => 'required|date',
                'segments.*.airline_id' => 'required|integer|exists:airlines,id',
                'segments.*.flight_number' => 'required|string|max:255',
                'segments.*.origin' => 'required|string|max:255',
                'segments.*.destination' => 'required|string|max:255',
                'segments.*.departure_time' => 'required|date_format:H:i',
                'segments.*.arrival_time' => 'required|date_format:H:i',
                'segments.*.baggage' => 'nullable|string|max:255',
                'segments.*.meal' => 'nullable|string|max:255',
            ]);
    
            DB::beginTransaction();
    
    
            $airlineGroup = AirlineGroup::create([
                'airline_id' => $validated['airline_id'],
                'sector_id' => $validated['sector_id'],
            ]);
    
            foreach ($validated['segments'] as $segment) {
                $airlineGroup->segments()->create($segment);
            }
    
            DB::commit();
    
            return redirect()->route('airlineGroups.index')->with('success', 'Airline Group created successfully.');
    
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    

    public function show(AirlineGroup $airlineGroup)
    {
        return view('airline-groups.show', compact('airlineGroup'));
    }

    public function edit(AirlineGroup $airlineGroup)
    {
     
        $data['title'] = 'Edit Airline Group';
        $data['airlineGroup'] = $airlineGroup;
        $data['airlines'] = (new AirlineService())->all();
        $data['cities'] = (new CityService())->all();
        $data['sectors'] = (new SectionService())->all(); // 
        return view('airline-groups.edit', $data);
    }

    public function update(Request $request, AirlineGroup $airlineGroup)
    {
        try {
            $validated = $request->validate([
                'airline_id' => 'required|exists:airlines,id',
                'sector_id' => 'required|exists:sections,id',
                'segments' => 'required|array',
                'segments.*.departure_date' => 'required|date',
                'segments.*.airline_id' => 'required|integer|exists:airlines,id',
                'segments.*.flight_number' => 'required|string|max:255',
                'segments.*.origin' => 'required|string|max:255',
                'segments.*.destination' => 'required|string|max:255',
                'segments.*.departure_time' => 'required|date_format:H:i:s',
                'segments.*.arrival_time' => 'required|date_format:H:i:s',
                'segments.*.baggage' => 'nullable|string|max:255',
                'segments.*.meal' => 'nullable|string|max:255',
                'segments.*.id' => 'nullable|integer|exists:segments,id'
            ]);
    
            DB::beginTransaction();
    
            // Update Airline Group
            $airlineGroup->update([
                'airline_id' => $validated['airline_id'],
                'sector_id' => $validated['sector_id'],
            ]);
    
            $existingSegmentIds = $airlineGroup->segments()->pluck('id')->toArray();
            $submittedSegmentIds = [];
    
            foreach ($validated['segments'] as $segmentData) {
                $segmentFields = collect($segmentData)->only([
                    'departure_date',
                    'airline_id',
                    'flight_number',
                    'origin',
                    'destination',
                    'departure_time',
                    'arrival_time',
                    'baggage',
                    'meal',
                ])->toArray();
    
                if (!empty($segmentData['id'])) {
                    // Update existing segment
                    $segment = $airlineGroup->segments()->where('id', $segmentData['id'])->first();
                    if ($segment) {
                        $segment->update($segmentFields);
                        $submittedSegmentIds[] = $segment->id;
                    }
                } else {
                    // Create new segment
                    $newSegment = $airlineGroup->segments()->create($segmentFields);
                    $submittedSegmentIds[] = $newSegment->id;
                }
            }
    
            // If deleted_segments is present, handle them
            if ($request->has('deleted_segments')) {
                $this->handleDeletedSegments($airlineGroup, $request->input('deleted_segments'));
            }
    
            DB::commit();
    
            return redirect()->route('airlineGroups.index')->with('success', 'Airline Group updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    

    protected function handleDeletedSegments(AirlineGroup $airlineGroup, array $segmentIds)
        {
       
            if (!empty($segmentIds)) {
                $airlineGroup->segments()->whereIn('id', $segmentIds)->delete();
            }
        }

    
    public function destroy(AirlineGroup $airlineGroup)
    {
        $airlineGroup->delete();

        return redirect()->route('airlineGroups.index')
            ->with('success', 'Airline Group deleted successfully');
    }
}
