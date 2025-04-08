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
}