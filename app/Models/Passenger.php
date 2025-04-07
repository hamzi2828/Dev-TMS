<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'passengers';
    
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
        'my_booking_id',
        'passenger_type',
        'title',
        'surname',
        'given_name',
        'passport',
        'dob',
        'passport_expiry',
        'nationality'
    ];

    /**
     * Get the booking that owns the passenger
     */
    public function booking()
    {
        return $this->belongsTo(MyBooking::class, 'my_booking_id');
    }
}