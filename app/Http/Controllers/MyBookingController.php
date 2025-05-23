<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AirlineGroup;
use App\Models\MyBooking;
use App\Models\Passenger;
use Illuminate\Support\Facades\DB;
use App\Models\Airline;
use App\Models\City;
use App\Models\Section;

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





        // Get the filtered airline groups with pagination
        $airlineGroups = $query->paginate(10);

        // Get all airlines and cities for the filter dropdowns
        $airlines = Airline::all();
        $cities = \App\Models\City::all(); // Fetch all cities for the dropdown

        // Prepare data for the view
        $data['title'] = 'All Booking';
        $data['airlineGroups'] = $airlineGroups;
        $data['airlines'] = $airlines;
        $data['cities'] = $cities; // Pass the cities to the view

        return view('my-bookings.index', $data);
    }


    public function myBookings2(Request $request)
    {
        // Get current date for comparison
        $currentDate = now();

        $query = AirlineGroup::with(['segments', 'airline'])
            ->where('total_seats', '>', 0); // Filter for total_seats > 0

        // Apply filters

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





        // Get the filtered airline groups with pagination
        $airlineGroups = $query->get();

        // Get all airlines and cities for the filter dropdowns
        $airlines = Airline::all();
        $cities = \App\Models\City::all(); // Fetch all cities for the dropdown

        // Prepare data for the view
        $data['title'] = 'All Booking';
        $data['airlineGroups'] = $airlineGroups;
        $data['airlines'] = $airlines;
        $data['cities'] = $cities; // Pass the cities to the view

        return view('my-bookings.myBookings2', $data);
    }

    public function pendingBookings(Request $request)
    {
        $query = MyBooking::with(['airline', 'airlineGroup.segments', 'passengers'])
            ->latest()
            ->where('status', 'pending');

        // Optional: Add filters (e.g., by airline, origin, etc.) if needed

        $myBookings = $query->paginate(10);

        $airlines = Airline::all();
        $cities = City::all();

        $data['title'] = 'My Pending Bookings';
        $data['myBookings'] = $myBookings;
        $data['airlines'] = $airlines;
        $data['cities'] = $cities;

        return view('my-bookings.pendingBookings', $data);
    }



    public function canceledBookings(Request $request)
    {
        $query = MyBooking::with(['airline', 'airlineGroup.segments', 'passengers'])
        ->latest()
            ->where('status', 'cancelled');



        $myBookings = $query->paginate(10);

        $airlines = Airline::all();
        $cities = City::all();

        $data['title'] = 'My Canceled Bookings';
        $data['myBookings'] = $myBookings;
        $data['airlines'] = $airlines;
        $data['cities'] = $cities;

        return view('my-bookings.canceledBookings', $data);
    }


    public function completedBookings(Request $request)
    {
        $query = MyBooking::with(['airline', 'airlineGroup.segments', 'passengers'])
        ->latest()
            ->where('status', 'confirmed');



        $myBookings = $query->paginate(10);

        $airlines = Airline::all();
        $cities = City::all();

        $data['title'] = 'My Confirmed Bookings';
        $data['myBookings'] = $myBookings;
        $data['airlines'] = $airlines;
        $data['cities'] = $cities;

        return view('my-bookings.completedBookings', $data);
    }
    public function confirmBookings(Request $request)
    {
        $booking = MyBooking::find($request->id);
        $booking->status = 'confirmed';

        $pnr = $request->pnr;

        if (MyBooking::where('pnr', $pnr)->exists()) {
            return redirect()->back()->with('error', 'PNR already exists');
        }

        $booking->pnr = $pnr;
        $booking->save();

        return redirect()->back()->with('success', 'Booking confirmed successfully');
    }


    public function cancelBookings(Request $request)
    {
        $booking = MyBooking::find($request->id);
        $booking->status = 'cancelled';
        $booking->save();

        $airlineGroup = AirlineGroup::find($booking->airline_group_id);
        $totalSeats = $booking->adults + $booking->children;
        $airlineGroup->used_seats = $airlineGroup->used_seats - $totalSeats;
        $airlineGroup->save();


        return redirect()->back()->with('success', 'Booking cancelled successfully');
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
        // dd($request->all());
        // Validate the request data
        $request->validate([
            'airline_id' => 'required|exists:airlines,id',
            'airline_group_id' => 'required|exists:airline_groups,id',
            'sector_id' => 'required|exists:sections,id',
            'adults' => 'required|integer|min:0',
            'children' => 'required|integer|min:0',
            'infants' => 'required|integer|min:0',
            'total_price' => 'required|numeric|min:0',
            'passenger.adult_*' => 'required_if:adults,>,0',
            'passenger.child_*' => 'required_if:children,>,0',
            'passenger.infant_*' => 'required_if:infants,>,0',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
                $airlineCode = Airline::findOrFail($request->airline_id)->code;
                $lastBookingRef = MyBooking::whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m'))
                ->whereDay('created_at', date('d'))
                ->latest()
                ->first();

            $datePrefix = date('Ymd');

            if ($lastBookingRef) {
                // Extract the last 3 digits from the booking reference
                $lastSequence = (int)substr($lastBookingRef->booking_reference, -3);
                $nextSequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $nextSequence = '001';
            }

            $bookingRef = $airlineCode . $datePrefix . $nextSequence;

            // Create the booking
            $booking = MyBooking::create([
                'airline_id' => $request->airline_id,
                'airline_group_id' => $request->airline_group_id,
                'sector_id' => $request->sector_id,
                'adults' => $request->adults,
                'children' => $request->children,
                'infants' => $request->infants,
                'total_price' => $request->total_price,
                'booking_reference' => $bookingRef,
                'status' => 'pending',
                'user_id' => auth()->user()->id,
            ]);

            $airlineGroup = AirlineGroup::find($request->airline_group_id);
            $airlineGroup->used_seats += $request->adults + $request->children;
            $airlineGroup->save();
            // Process passenger data
            if ($request->has('passenger')) {
                $passengers = $request->passenger;

                // Process adult passengers
                for ($i = 1; $i <= $request->adults; $i++) {
                    if (isset($passengers['adult_' . $i])) {
                        $passengerData = $passengers['adult_' . $i];
                        Passenger::create([
                            'my_booking_id' => $booking->id,
                            'passenger_type' => 'adult',
                            'title' => $passengerData['title'],
                            'surname' => $passengerData['surname'],
                            'given_name' => $passengerData['given_name'],
                            'passport' => $passengerData['passport'],
                            'dob' => $passengerData['dob'],
                            'passport_expiry' => $passengerData['passport_expiry'],
                            'nationality' => $passengerData['nationality'],
                        ]);
                    }
                }

                // Process child passengers
                for ($i = 1; $i <= $request->children; $i++) {
                    if (isset($passengers['child_' . $i])) {
                        $passengerData = $passengers['child_' . $i];
                        Passenger::create([
                            'my_booking_id' => $booking->id,
                            'passenger_type' => 'child',
                            'title' => $passengerData['title'],
                            'surname' => $passengerData['surname'],
                            'given_name' => $passengerData['given_name'],
                            'passport' => $passengerData['passport'],
                            'dob' => $passengerData['dob'],
                            'passport_expiry' => $passengerData['passport_expiry'],
                            'nationality' => $passengerData['nationality'],
                        ]);
                    }
                }

                // Process infant passengers
                for ($i = 1; $i <= $request->infants; $i++) {
                    if (isset($passengers['infant_' . $i])) {
                        $passengerData = $passengers['infant_' . $i];
                        Passenger::create([
                            'my_booking_id' => $booking->id,
                            'passenger_type' => 'infant',
                            'title' => $passengerData['title'],
                            'surname' => $passengerData['surname'],
                            'given_name' => $passengerData['given_name'],
                            'passport' => $passengerData['passport'],
                            'dob' => $passengerData['dob'],
                            'passport_expiry' => $passengerData['passport_expiry'],
                            'nationality' => $passengerData['nationality'],
                        ]);
                    }
                }
            }

            // Commit the transaction
            DB::commit();

            // Redirect with success message
            return redirect()->back()
            ->with([
                'booking_success' => true,
                'booking_reference' => $booking->booking_reference,
                'payment_deadline' => now()->addHour()->format('H:i, F j, Y'),
            ]);

        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            // Return with error message
            return redirect()->back()
                ->with('error', 'Failed to create booking: ' . $e->getMessage())
                ->withInput();
        }
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
        // Find the booking with related data
        $booking = MyBooking::with(['airline', 'airlineGroup.segments', 'passengers'])
            ->findOrFail($id);

        // Get the airline group details for the booking
        $airlineGroup = AirlineGroup::with(['segments', 'airline'])
            ->find($booking->airline_group_id);

        // Prepare data for the view
        $data['title'] = 'Edit Booking';
        $data['booking'] = $booking;
        $data['airlineGroup'] = $airlineGroup;

        // Return the edit view with the data
        return view('my-bookings.edit', $data);
    }


    /**
 * Update the specified resource in storage.
 */
    public function update(Request $request, string $id)
    {
        // Remove the debug statement
        // dd($request->all());

        // Validate the request data
        $request->validate([
            'airline_id' => 'required|exists:airlines,id',
            'airline_group_id' => 'required|exists:airline_groups,id',
            'sector_id' => 'required|exists:sections,id',
            'adults' => 'required|integer|min:0',
            'children' => 'required|integer|min:0',
            'infants' => 'required|integer|min:0',
            'total_price' => 'required|numeric|min:0',
            'terms_and_conditions' => 'required',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Find the booking
            $booking = MyBooking::findOrFail($id);

            // Update basic booking details
            $booking->update([
                'adults' => $request->adults,
                'children' => $request->children,
                'infants' => $request->infants,
                'discount' => $request->discount,
                'total_price' => $request->total_price,
            ]);

            // Process passenger data
            if ($request->has('passenger')) {
                $passengers = $request->passenger;
                $existingPassengerIds = [];

                // Process all passengers regardless of type
                foreach ($passengers as $key => $passengerData) {
                    // Extract passenger type from the key (adult, child, infant)
                    $passengerType = explode('_', $key)[0];

                    if (isset($passengerData['id'])) {
                        // Update existing passenger
                        $passenger = Passenger::findOrFail($passengerData['id']);
                        $passenger->update([
                            'title' => $passengerData['title'],
                            'surname' => $passengerData['surname'],
                            'given_name' => $passengerData['given_name'],
                            'passport' => $passengerData['passport'],
                            'dob' => $passengerData['dob'],
                            'passport_expiry' => $passengerData['passport_expiry'],
                            'nationality' => $passengerData['nationality'],
                        ]);

                        $existingPassengerIds[] = $passenger->id;
                    } else {
                        // Create new passenger
                        $passenger = Passenger::create([
                            'my_booking_id' => $booking->id,
                            'passenger_type' => $passengerType,
                            'title' => $passengerData['title'],
                            'surname' => $passengerData['surname'],
                            'given_name' => $passengerData['given_name'],
                            'passport' => $passengerData['passport'],
                            'dob' => $passengerData['dob'],
                            'passport_expiry' => $passengerData['passport_expiry'],
                            'nationality' => $passengerData['nationality'],
                        ]);

                        $existingPassengerIds[] = $passenger->id;
                    }
                }

                // Delete passengers that are no longer needed
                // This will remove any passenger that wasn't updated or created in this request
                $booking->passengers()
                    ->whereNotIn('id', $existingPassengerIds)
                    ->delete();
            }

            // Commit the transaction
            DB::commit();

            // Redirect with success message
            return redirect()->route('myBookings.pending')
                            ->with('success', 'Booking updated successfully.');

        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            // Return with error message
            return redirect()->back()
                            ->with('error', 'Failed to update booking: ' . $e->getMessage())
                            ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

