<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyBooking extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'my_bookings';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Disable the model prefix
     *
     * @var string
     */
    protected $prefix = '';

    protected $fillable = [
        'airline_id',
        'airline_group_id',
        'sector_id',
        'adults',
        'children',
        'infants',
        'total_price',
        'booking_reference',
        'status',
        'user_id',
        'discount',
    ];

    /**
     * Get the airline associated with the booking
     */
    public function airline()
    {
        return $this->belongsTo(Airline::class, 'airline_id');
    }

    /**
     * Get the airline group associated with the booking
     */
    public function airlineGroup()
    {
        return $this->belongsTo(AirlineGroup::class, 'airline_group_id');
    }

    /**
     * Get the sector associated with the booking
     */
    public function sector()
    {
        return $this->belongsTo(Section::class, 'sector_id');
    }

    /**
     * Get the passengers associated with the booking
     */
    public function passengers()
    {
        return $this->hasMany(Passenger::class, 'my_booking_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public static function getBookingCost($bookingId)
    {
        $booking = self::with('airlineGroup')->find($bookingId);


        if (!$booking || !$booking->airlineGroup) {
            return null;
        }

        $adultsCost = $booking->adults * $booking->airlineGroup->cost_per_adult;
        $childrenCost = $booking->children * $booking->airlineGroup->cost_per_child;
        $infantsCost = $booking->infants * $booking->airlineGroup->cost_per_infant;

        return $adultsCost + $childrenCost + $infantsCost;
    }


    public static function getBookingSale($bookingId)
    {
        $booking = self::with('airlineGroup')->find($bookingId);

        if (!$booking || !$booking->airlineGroup) {
            return null;
        }

        $adultsSale = $booking->adults * $booking->airlineGroup->sale_per_adult;
        $childrenSale = $booking->children * $booking->airlineGroup->sale_per_child;
        $infantsSale = $booking->infants * $booking->airlineGroup->sale_per_infant;

        return $adultsSale + $childrenSale + $infantsSale;
    }


    public static function getAgentAccountHeadId( $bookingId )
    {
        $booking = self::with('airlineGroup')->find($bookingId);
        $user = User::find($booking->user_id);
        $agent = Agent::find($user->agent_id);
        return $agent->account_head_id;
    }

}
