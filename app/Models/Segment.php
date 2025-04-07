<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AirlineGroup;

class Segment extends Model
{
    use HasFactory;

    protected $fillable = [
        'airline_group_id',
        'departure_date',
        'airline_id',
        'flight_number',
        'origin',
        'destination',
        'departure_time',
        'arrival_time',
        'baggage',
        'meal',
    ];


    public function airlineGroup()
    {
        return $this->belongsTo(AirlineGroup::class, 'airline_group_id');
    }


    public function airline()
    {
        return $this->belongsTo(Airline::class, 'airline_id');
    }
    public function originCity()
    {
        return $this->belongsTo(City::class, 'origin');
    }
    public function destinationCity()
    {
        return $this->belongsTo(City::class, 'destination');
    }
}
