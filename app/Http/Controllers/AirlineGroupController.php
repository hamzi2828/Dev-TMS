<?php

namespace App\Http\Controllers;
use App\Http\Requests\AirlineGroupFormRequest;
use App\Services\AirlineGroupService;
use App\Services\AirlineService;
use App\Services\SectionService;
use App\Services\AgentService;
use App\Services\CompanyService;
use App\Services\CityService;
use App\Models\Segment;
use App\Models\AirlineGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class AirlineGroupController extends Controller
{
    public function index(Request $request)
    {
        // Start the query for AirlineGroup, eager load segments and airline
        $query = AirlineGroup::with(['segments', 'airline']);

        // Apply filter for departure_date
        if ($request->filled('departure_date')) {
            $query->whereHas('segments', function ($q) use ($request) {
                $q->whereDate('departure_date', '=', $request->departure_date);
            });
        }

        // Apply filter for airline
        if ($request->filled('airline')) {
            $query->where('airline_id', $request->airline);
        }

        // Apply filter for origin city
        if ($request->filled('origin')) {
            $query->whereHas('segments.originCity', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->origin . '%');
            });
        }

        // Apply filter for destination city
        if ($request->filled('destination')) {
            $query->whereHas('segments.destinationCity', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->destination . '%');
            });
        }

        // Use pagination instead of get() to enable appends()
        $airlineGroups = $query->paginate(10)->appends($request->all());

        // Fetch all airlines and cities for the filter dropdowns
        $airlines = (new AirlineService())->all();
        $cities = (new CityService())->all();

        // Prepare the data for the view
        return view('airline-groups.index', [
            'title' => 'Airline Groups',
            'airlineGroups' => $airlineGroups,
            'airlines' => $airlines,
            'cities' => $cities,
        ]);
    }



    public function create()
    {
        $data['title'] = 'Add Airline Group';
        $data['airlines'] = (new AirlineService())->all();
        $data['cities'] = (new CityService())->all();
        $data['sectors'] = (new SectionService())->all();
        $data[ 'agents' ] = ( new AgentService() ) -> all ();
        $data['companies'] = ( new CompanyService() ) -> companies ();
        return view('airline-groups.create', $data);
    }

    public function store(Request $request)
    {

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'airline_id' => 'required|exists:airlines,id',
                'sector_id' => 'required|exists:sections,id',
                'company_id' => 'required|exists:companies,id',

                'cost_per_adult' => 'nullable|numeric',
                'sale_per_adult' => 'nullable|numeric',
                'cost_per_child' => 'nullable|numeric',
                'sale_per_child' => 'nullable|numeric',
                'cost_per_infant' => 'nullable|numeric',
                'sale_per_infant' => 'nullable|numeric',

                'total_seats' => 'required|integer',
                'admin_seats' => 'nullable|integer',
                'travel_agent_id' => 'nullable|exists:agents,id',
                'travel_agent_seats' => 'nullable|integer',

                'segments' => 'required|array|min:1',
                'segments.*.departure_date' => 'required|date',
                'segments.*.airline_id' => 'required|exists:airlines,id',
                'segments.*.flight_number' => 'required|string|max:255',
                'segments.*.origin' => 'required|string|max:255',
                'segments.*.destination' => 'required|string|max:255',
                'segments.*.departure_time' => 'required|date_format:H:i',
                'segments.*.arrival_time' => 'required|date_format:H:i',
                'segments.*.baggage' => 'nullable|string|max:255',
                'segments.*.meal' => 'nullable|in:yes,no',
            ]);

            DB::beginTransaction();

            $airlineGroup = AirlineGroup::create([
                'title' => $validated['title'],
                'airline_id' => $validated['airline_id'],
                'sector_id' => $validated['sector_id'],
                'company_id' => $validated['company_id'],
                'cost_per_adult' => $request->cost_per_adult,
                'sale_per_adult' => $request->sale_per_adult,
                'cost_per_child' => $request->cost_per_child,
                'sale_per_child' => $request->sale_per_child,
                'cost_per_infant' => $request->cost_per_infant,
                'sale_per_infant' => $request->sale_per_infant,
                'total_seats' => $request->total_seats,
                'admin_seats' => $request->admin_seats,
                'travel_agent_id' => $request->travel_agent_id,
                'travel_agent_seats' => $request->travel_agent_seats,
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
        $data['sectors'] = (new SectionService())->all();
        $data[ 'agents' ] = ( new AgentService() ) -> all ();
        $data['companies'] = ( new CompanyService() ) -> companies ();
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
                'segments.*.departure_time' => 'required|string|max:255',
                'segments.*.arrival_time' => 'required|string|max:255',
                'segments.*.baggage' => 'nullable|string|max:255',
                'segments.*.meal' => 'nullable|string|max:255',
                'segments.*.id' => 'nullable|integer|exists:segments,id'
            ]);

            DB::beginTransaction();

            // Update Airline Group
            $airlineGroup->update([
                'airline_id' => $validated['airline_id'],
                'sector_id' => $validated['sector_id'],
                'company_id' => $request->company_id,
                'cost_per_adult' => $request->cost_per_adult,
                'sale_per_adult' => $request->sale_per_adult,
                'cost_per_child' => $request->cost_per_child,
                'sale_per_child' => $request->sale_per_child,
                'cost_per_infant' => $request->cost_per_infant,
                'sale_per_infant' => $request->sale_per_infant,
                'total_seats' => $request->total_seats,
                'admin_seats' => $request->admin_seats,
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
