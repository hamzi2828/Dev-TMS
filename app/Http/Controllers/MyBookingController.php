<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AirlineGroup;
use App\Models\Airline;
use App\Models\City;


class MyBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get current date for comparison
        $currentDate = now();

        $query = AirlineGroup::with(['segments', 'airline'])
            ->where('total_seats', '>', 0); // Filter for total_seats > 0

        // Apply filters
        if ($request->has('departure_date') && $request->departure_date) {
            $query->whereHas('segments', function ($query) use ($request) {
                $query->whereDate('departure_date', '=', $request->departure_date);
            });
        }

        if ($request->has('airline') && $request->airline) {
            $query->where('airline_id', $request->airline);
        }

        if ($request->has('origin') && $request->origin) {
            $query->whereHas('segments', function ($query) use ($request) {
                $query->whereHas('originCity', function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->origin . '%');
                });
            });
        }

        if ($request->has('destination') && $request->destination) {
            $query->whereHas('segments', function ($query) use ($request) {
                $query->whereHas('destinationCity', function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->destination . '%');
                });
            });
        }

        // Get the filtered airline groups with pagination
        $airlineGroups = $query->paginate(10);

        // Get all airlines and cities for the filter dropdowns
        $airlines = Airline::all();
        $cities = \App\Models\City::all(); // Fetch all cities for the dropdown

        // Prepare data for the view
        $data['title'] = 'My Booking';
        $data['airlineGroups'] = $airlineGroups;
        $data['airlines'] = $airlines;
        $data['cities'] = $cities; // Pass the cities to the view

        return view('my-bookings.index', $data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data['title'] = 'Create My Booking';

        // Check if 'airlineGroup' parameter exists in the URL
        if ($request->has('airlineGroup')) {
            // Retrieve the AirlineGroup by ID
            $airlineGroupId = $request->query('airlineGroup');
            $airlineGroup = AirlineGroup::with(['segments', 'airline'])
            ->find($airlineGroupId);

            // Check if the AirlineGroup exists
            if ($airlineGroup) {
                // Pass the AirlineGroup details to the view
                $data['airlineGroup'] = $airlineGroup;
            } else {
                // If AirlineGroup is not found, you can handle this case
                // For example, you can redirect with an error message
                return redirect()->route('myBookings.index')->with('error', 'Airline Group not found');
            }
        }
// dd(    $data['airlineGroup'] );
        return view('my-bookings.create', $data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
