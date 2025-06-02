<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MyBooking;
use App\Models\AirlineGroup;
use App\Models\Agent;
use App\Models\GeneralLedger;
use App\Models\Passenger;
use Illuminate\Support\Facades\DB;
use App\Models\Airline;
use App\Models\City;
use App\Models\Section;
use Illuminate\Contracts\View\View;
use App\Services\AccountService;
use App\Services\GeneralLedgerService;

class MyBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $agent_id = auth()->user()->agent_id;
        $agent = Agent::where('id', $agent_id)->first();

        // Get current date for comparison
        $currentDate = now();

        $query = AirlineGroup::with(['segments', 'airline'])
            ->where('total_seats', '>', 0)
            ->where('status', 'active');


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

        $agent_account_head_id = $agent ? $agent->account_head_id : null;
        if($agent_account_head_id){
            $used_credit = (new \App\Http\Helpers\GeneralHelper())->getAgentUsedCredit($agent_account_head_id);
        }else{
            $used_credit = 0;
        }

        $data['title'] = 'All Booking';
        $data['airlineGroups'] = $airlineGroups;
        $data['airlines'] = $airlines;
        $data['cities'] = $cities;
        $data['credit_limit'] = $agent ? $agent->credit_limit : 0;
        $data['used_credit'] = $used_credit;

        return view('my-bookings.myBookings2', $data);
    }


    public function pendingBookings(Request $request)
    {
        $roleName = DB::table('user_roles')
            ->join('roles', 'user_roles.role_id', '=', 'roles.id')
            ->where('user_roles.user_id', auth()->user()->id)
            ->value('roles.slug');

        if ($roleName === 'admin') {
            $query = MyBooking::with(['airline', 'airlineGroup.segments', 'passengers'])
                ->latest()
                ->where('status', 'pending');
            }else{
                $query = MyBooking::with(['airline', 'airlineGroup.segments', 'passengers'])
                ->latest()
                ->where('status', 'pending')
                ->where('user_id', auth()->user()->id);
            }

        // Optional: Add filters (e.g., by airline, origin, etc.) if needed

        $agent_id = auth()->user()->agent_id;
        $agent = Agent::where('id', $agent_id)->first();

        $myBookings = $query->paginate(10);

        $airlines = Airline::all();
        $cities = City::all();
        $agent_account_head_id = $agent ? $agent->account_head_id : null;
        if($agent_account_head_id){
            $used_credit = (new \App\Http\Helpers\GeneralHelper())->getAgentUsedCredit($agent_account_head_id);
        }else{
            $used_credit = 0;
        }

        $data['title'] = 'My Pending Bookings';
        $data['myBookings'] = $myBookings;
        $data['airlines'] = $airlines;
        $data['cities'] = $cities;
        $data['credit_limit'] = $agent ? $agent->credit_limit : 0;
        $data['used_credit'] = $used_credit;

        return view('my-bookings.pendingBookings', $data);
    }



    public function canceledBookings(Request $request)
    {

        $roleName = DB::table('user_roles')
            ->join('roles', 'user_roles.role_id', '=', 'roles.id')
            ->where('user_roles.user_id', auth()->user()->id)
            ->value('roles.slug');

        $agent_id = auth()->user()->agent_id;
        $agent = Agent::where('id', $agent_id)->first();

        if ($roleName === 'admin') {
            $query = MyBooking::with(['airline', 'airlineGroup.segments', 'passengers'])
                ->latest()
                ->where('status', 'cancelled');
            }else{
                $query = MyBooking::with(['airline', 'airlineGroup.segments', 'passengers'])
                ->latest()
                ->where('status', 'cancelled')
                ->where('user_id', auth()->user()->id);
            }



        $myBookings = $query->paginate(10);

        $airlines = Airline::all();
        $cities = City::all();
        $agent_account_head_id = $agent ? $agent->account_head_id : null;
        if($agent_account_head_id){
            $used_credit = (new \App\Http\Helpers\GeneralHelper())->getAgentUsedCredit($agent_account_head_id);
        }else{
            $used_credit = 0;
        }

        $data['title'] = 'My Canceled Bookings';
        $data['myBookings'] = $myBookings;
        $data['airlines'] = $airlines;
        $data['cities'] = $cities;
        $data['credit_limit'] = $agent ? $agent->credit_limit : 0;
        $data['used_credit'] = $used_credit;

        return view('my-bookings.canceledBookings', $data);
    }


    public function completedBookings(Request $request)
    {
        $roleName = DB::table('user_roles')
            ->join('roles', 'user_roles.role_id', '=', 'roles.id')
            ->where('user_roles.user_id', auth()->user()->id)
            ->value('roles.slug');
            $agent_id = auth()->user()->agent_id;
            $agent = Agent::where('id', $agent_id)->first();

        if ($roleName === 'admin') {
            $query = MyBooking::with(['airline', 'airlineGroup.segments', 'passengers'])
                ->latest()
                ->where('status', 'confirmed');
            }else{
                $query = MyBooking::with(['airline', 'airlineGroup.segments', 'passengers'])
                ->latest()
                ->where('status', 'confirmed')
                ->where('user_id', auth()->user()->id);
            }



        $myBookings = $query->paginate(10);

        $airlines = Airline::all();
        $cities = City::all();
        $agent_account_head_id = $agent ? $agent->account_head_id : null;
        if($agent_account_head_id){
            $used_credit = (new \App\Http\Helpers\GeneralHelper())->getAgentUsedCredit($agent_account_head_id);
        }else{
            $used_credit = 0;
        }

        $data['title'] = 'My Confirmed Bookings';
        $data['myBookings'] = $myBookings;
        $data['airlines'] = $airlines;
        $data['cities'] = $cities;
        $data['credit_limit'] = $agent ? $agent->credit_limit : 0;
        $data['used_credit'] = $used_credit;

        return view('my-bookings.completedBookings', $data);
    }

    public function confirmBookings(Request $request)
    {
        DB::beginTransaction();

        try {
            // Eager load the relationships to avoid N+1 queries
            $booking = MyBooking::with(['airlineGroup.company'])->find($request->id);

            if (!$booking) {
                throw new \Exception('Booking not found');
            }

            $totalCost = MyBooking::getBookingCost($request->id);
            $totalSale = MyBooking::getBookingSale($request->id);
            $agent_account_head_id = MyBooking::getAgentAccountHeadId($request->id);

            if ($totalSale === null) {
                throw new \Exception('Could not calculate total sale amount');
            }

            // Update booking status
            $booking->status = 'confirmed';
            $booking->confirmed_by = auth()->id();
            $pnr = $request->pnr;

            if (MyBooking::where('pnr', $pnr)->where('id', '!=', $booking->id)->exists()) {
                throw new \Exception('PNR already exists');
            }

            $booking->pnr = $pnr;
            $booking->save();

            // Get the company's account head ID
            $companyAccountHeadId = $booking->airlineGroup->company->account_head_id ?? null;

            if (!$companyAccountHeadId) {
                throw new \Exception('Company account head ID not found');
            }

            // Get the logged-in user's agent and their account head ID
            $agent = Agent::with('user')->find(auth()->user()->agent_id);

            if (!$agent) {
                throw new \Exception('Agent not found for this user');
            }

            if (!$agent_account_head_id) {
                throw new \Exception('Agent account head ID not found');
            }

            if($booking->discount === null){
                $netSale = $totalSale;
            }else{
                $netSale = $totalSale - $booking->discount;
            }

            // Create debit entry for the total sale to head ID 199
            $ledgerData = [
                'account_head_id' => 199,
                'user_id' => auth()->user()->id,
                'debit' => $totalCost,
                'credit' => 0,
                'transaction_date' => now(),
                'description' => 'Booking confirmed - PNR: ' . $pnr,
                'ledgerable_type' => get_class($booking),
                'ledgerable_id' => $booking->id
            ];

            // Create the ledger entry
            GeneralLedger::create([
                'account_head_id' => 199,
                'user_id' => auth()->user()->id,
                'debit' => $totalCost,
                'credit' => 0,
                'transaction_date' => now(),
                'description' => 'Booking confirmed - PNR: ' . $pnr,
                'ledgerable_type' => get_class($booking),
                'ledgerable_id' => $booking->id
            ]);

            // Create credit entry for the total cost to company's account head
            GeneralLedger::create([
                'account_head_id' => $companyAccountHeadId,
                'user_id' => auth()->user()->id,
                'debit' => 0,
                'credit' => $totalCost,
                'transaction_date' => now(),
                'description' => 'Booking cost - PNR: ' . $pnr,
                'ledgerable_type' => get_class($booking),
                'ledgerable_id' => $booking->id
            ]);

            // Create entry for the net sale to user's account
            GeneralLedger::create([
                'account_head_id' => $agent_account_head_id,
                'user_id' => auth()->user()->id,
                'debit' => $netSale,
                'credit' => 0,
                'transaction_date' => now(),
                'description' => 'Booking net sale - PNR: ' . $pnr,
                'ledgerable_type' => get_class($booking),
                'ledgerable_id' => $booking->id
            ]);

            // Create entry for the net sale to account 434
            GeneralLedger::create([
                'account_head_id' => 434,
                'user_id' => auth()->user()->id,
                'debit' => 0,
                'credit' => $netSale,
                'transaction_date' => now(),
                'description' => 'Booking net sale - PNR: ' . $pnr,
                'ledgerable_type' => get_class($booking),
                'ledgerable_id' => $booking->id
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Booking confirmed successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error confirming booking: ' . $e->getMessage());
        }
    }


    public function cancelBookings(Request $request)
    {
        DB::beginTransaction();

        try {
            // Find the booking with necessary relationships
            $booking = MyBooking::with(['airlineGroup.company'])->find($request->id);

            if ($booking->status === 'confirmed') {
                // Update booking status
                $booking->status = 'cancelled';
                $booking->save();

                // Update airline group seats
                $airlineGroup = AirlineGroup::find($booking->airline_group_id);
                $totalSeats = $booking->adults + $booking->children;
                $airlineGroup->used_seats = $airlineGroup->used_seats - $totalSeats;
                $airlineGroup->save();

                // Get the original booking financial values
                $totalCost = MyBooking::getBookingCost($request->id);
                $totalSale = MyBooking::getBookingSale($request->id);
                $agent_account_head_id = MyBooking::getAgentAccountHeadId($request->id);

                if ($totalSale === null) {
                    throw new \Exception('Could not calculate total sale amount');
                }

                // Calculate net sale
                if ($booking->discount === null) {
                    $netSale = $totalSale;
                } else {
                    $netSale = $totalSale - $booking->discount;
                }

                // Get the company's account head ID
                $companyAccountHeadId = $booking->airlineGroup->company->account_head_id ?? null;

                if (!$companyAccountHeadId) {
                    throw new \Exception('Company account head ID not found');
                }

                // Get the logged-in user's agent and their account head ID
                $agent = Agent::with('user')->find(auth()->user()->agent_id);

                if (!$agent) {
                    throw new \Exception('Agent not found for this user');
                }


                if (!$agent_account_head_id) {
                    throw new \Exception('agent account head ID not Linked');
                }

                // Create reverse entries - exact opposite of the confirmation entries

                // 1. Reverse the debit entry for account head 199
                GeneralLedger::create([
                    'account_head_id' => 199,
                    'user_id' => auth()->user()->id,
                    'debit' => 0,
                    'credit' => $totalCost,  // Opposite of original entry
                    'transaction_date' => now(),
                    'description' => 'Booking cancelled - PNR: ' . $booking->pnr,
                    'ledgerable_type' => get_class($booking),
                    'ledgerable_id' => $booking->id
                ]);

                // 2. Reverse the credit entry for company's account head
                GeneralLedger::create([
                    'account_head_id' => $companyAccountHeadId,
                    'user_id' => auth()->user()->id,
                    'debit' => $totalCost,  // Opposite of original entry
                    'credit' => 0,
                    'transaction_date' => now(),
                    'description' => 'Booking cost reversed - PNR: ' . $booking->pnr,
                    'ledgerable_type' => get_class($booking),
                    'ledgerable_id' => $booking->id
                ]);

                // 3. Reverse the debit entry for user's account
                GeneralLedger::create([
                    'account_head_id' => $agent_account_head_id,
                    'user_id' => auth()->user()->id,
                    'debit' => 0,
                    'credit' => $netSale,  // Opposite of original entry
                    'transaction_date' => now(),
                    'description' => 'Booking net sale reversed - PNR: ' . $booking->pnr,
                    'ledgerable_type' => get_class($booking),
                    'ledgerable_id' => $booking->id
                ]);

                // 4. Reverse the credit entry for account 434
                GeneralLedger::create([
                    'account_head_id' => 434,
                    'user_id' => auth()->user()->id,
                    'debit' => $netSale,  // Opposite of original entry
                    'credit' => 0,
                    'transaction_date' => now(),
                    'description' => 'Booking net sale reversed - PNR: ' . $booking->pnr,
                    'ledgerable_type' => get_class($booking),
                    'ledgerable_id' => $booking->id
                ]);



            }else{

                $booking = MyBooking::find($request->id);

                $booking->status = 'cancelled';
                $booking->save();
                $airlineGroup = AirlineGroup::find($booking->airline_group_id);
                $totalSeats = $booking->adults + $booking->children;
                $airlineGroup->used_seats = $airlineGroup->used_seats - $totalSeats;
                $airlineGroup->save();


            }

            DB::commit();
            return redirect()->back()->with('success', 'Booking cancelled successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error cancelling booking: ' . $e->getMessage());
        }
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
       // dd( $data['airlineGroup'] );
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

    public function myLedger(Request $request): View {
        $agent_account_head_id = Agent::find(auth()->user()->agent_id)->account_head_id;
        $request->merge(['account-head-id' => $agent_account_head_id]);
        $data['title'] = 'My Ledger';
        $data['account_heads'] = (new AccountService())->convertToOptions(disabled: false);
        $account_heads = (new AccountService())->getRecursiveAccountHeads($request->input('account-head-id'));
        $parent_account_head = (new AccountService())->get_account_head_by_id($request->input('account-head-id'));
        $account_head[] = $parent_account_head;
        $account_heads_list = array_merge($account_head, $account_heads);
        $data['ledgers'] = (new GeneralLedgerService())->build_ledgers_table($account_heads_list);
        return view('my-bookings.my-ledger', $data);
    }
}

