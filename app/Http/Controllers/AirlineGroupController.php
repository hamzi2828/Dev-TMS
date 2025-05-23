<?php

namespace App\Http\Controllers;
use App\Http\Requests\AirlineGroupFormRequest;
use App\Services\AirlineGroupService;
use App\Services\AirlineService;
use App\Services\SectionService;
use App\Services\AgentService;
use App\Services\CompanyService;
use App\Services\CityService;
use App\Models\Section;
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

        if ($request->has('departure_date') && $request->departure_date) {
            $query->whereDoesntHave('segments', function ($query) use ($request) {
                $query->whereDate('departure_date', '<', $request->departure_date);
            });
        }


        if ($request->has('airline') && $request->airline) {
            $query->where('airline_id', $request->airline);
        }

        if ($request->has('origin') && $request->origin) {
            // Handle the case where origin is already a numeric ID
            $query->whereHas('segments', function ($query) use ($request) {
                // Check if it's a numeric value (direct ID)
                if (is_numeric($request->origin)) {
                    $query->where('origin', $request->origin);
                } else {
                    // Try to find matching cities by name
                    $cityIds = \App\Models\City::where('title', 'like', '%' . $request->origin . '%')
                        ->pluck('id')
                        ->toArray();

                    if (!empty($cityIds)) {
                        $query->whereIn('origin', $cityIds);
                    }
                }
            });
        }

        if ($request->has('destination') && $request->destination) {
            // Handle the case where destination is already a numeric ID
            $query->whereHas('segments', function ($query) use ($request) {
                // Check if it's a numeric value (direct ID)
                if (is_numeric($request->destination)) {
                    $query->where('destination', $request->destination);
                } else {
                    // Try to find matching cities by name
                    $cityIds = \App\Models\City::where('title', 'like', '%' . $request->destination . '%')
                        ->pluck('id')
                        ->toArray();

                    if (!empty($cityIds)) {
                        $query->whereIn('destination', $cityIds);
                    }
                }
            });
        }


        if ($request->filled('trip_type')) {
            $query->whereHas('section', function ($query) use ($request) {
                $query->where('trip_type', $request->trip_type);
            });
        }


        // Use pagination instead of get() to enable appends()
        $airlineGroups = $query->paginate(10)->appends($request->all());

        // Fetch all airlines and cities for the filter dropdowns
        $airlines = (new AirlineService())->all();
        $cities = (new CityService())->all();

        // Prepare the data for the view
        return view('airline-groups.index', [
            'title' => 'All Airline Groups',
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

                'basic_per_adult' => 'nullable|numeric',
                'tax_per_adult' => 'nullable|numeric',
                'cost_per_adult' => 'nullable|numeric',
                'sale_per_adult' => 'nullable|numeric',

                'basic_per_child' => 'nullable|numeric',
                'tax_per_child' => 'nullable|numeric',
                'cost_per_child' => 'nullable|numeric',
                'sale_per_child' => 'nullable|numeric',

                'basic_per_infant' => 'nullable|numeric',
                'tax_per_infant' => 'nullable|numeric',
                'cost_per_infant' => 'nullable|numeric',
                'sale_per_infant' => 'nullable|numeric',

                'total_seats' => 'required|integer',
                'admin_seats' => 'nullable|integer',


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
                 'expire_datetime' => 'required|date_format:Y-m-d\TH:i',
            ]);

            DB::beginTransaction();

            $airlineGroup = AirlineGroup::create([
                'title' => $validated['title'],
                'airline_id' => $validated['airline_id'],
                'sector_id' => $validated['sector_id'],
                'company_id' => $validated['company_id'],
                'basic_per_adult' => $validated['basic_per_adult'],
                'tax_per_adult' => $validated['tax_per_adult'],
                'cost_per_adult' => $validated['cost_per_adult'],
                'sale_per_adult' => $validated['sale_per_adult'],
                'basic_per_child' => $validated['basic_per_child'],
                'tax_per_child' => $validated['tax_per_child'],
                'cost_per_child' => $validated['cost_per_child'],
                'sale_per_child' => $validated['sale_per_child'],
                'basic_per_infant' => $validated['basic_per_infant'],
                'tax_per_infant' => $validated['tax_per_infant'],
                'cost_per_infant' => $validated['cost_per_infant'],
                'sale_per_infant' => $validated['sale_per_infant'],
                'total_seats' => $validated['total_seats'],
                'admin_seats' => $validated['admin_seats'],
                'expire_datetime' => $validated['expire_datetime'],
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
                'segments.*.id' => 'nullable|integer|exists:segments,id',
                'expire_datetime' => 'required|date_format:Y-m-d\TH:i',
            ]);


            DB::beginTransaction();

            // Update Airline Group
            $airlineGroup->update([
                'airline_id' => $validated['airline_id'],
                'sector_id' => $validated['sector_id'],
                'company_id' => $request->company_id,
                'basic_per_adult' => $request->basic_per_adult,
                'tax_per_adult' => $request->tax_per_adult,
                'cost_per_adult' => $request->cost_per_adult,
                'sale_per_adult' => $request->sale_per_adult,
                'basic_per_child' => $request->basic_per_child,
                'tax_per_child' => $request->tax_per_child,
                'cost_per_child' => $request->cost_per_child,
                'sale_per_child' => $request->sale_per_child,
                'basic_per_infant' => $request->basic_per_infant,
                'tax_per_infant' => $request->tax_per_infant,
                'cost_per_infant' => $request->cost_per_infant,
                'sale_per_infant' => $request->sale_per_infant,
                'total_seats' => $request->total_seats,
                'admin_seats' => $request->admin_seats,
                'expire_datetime' => $request->expire_datetime,
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
